<?php
namespace frontend\controllers;

use common\models\AuthUsers;
use common\models\Banner;
use common\models\Contact;
use common\models\Exchange;
use common\models\Faq;
use common\models\FarmStorage;
use common\models\Instruction;
use common\models\LoginHistory;
use common\models\Material;
use common\models\News;
use common\models\PayIn;
use common\models\PayOut;
use common\models\Reviews;
use common\models\Session;
use common\models\Settings;
use common\models\Statistics;
use common\models\User;
use common\models\UserStorage;
use vova07\imperavi\actions\GetAction;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use common\components\Pusher\Pusher;

/**
 * Site controller
 */
class SiteController extends Controller
{
    const APP_KEY = 'f747ca5f8f97665a58dc';
    const APP_SECRET = '403fcd275b23d43088c4';
    const APP_ID = '172832';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
               'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
              //'class' => 'yii\captcha\CaptchaAction',
               'class' => 'frontend\components\MyCaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $login_model = new LoginForm();
        $signup_model = new SignupForm();
        $ref_id = Yii::$app->request->get('ref-id');
        if($ref_id)
        {
            $ref_id = (int)$ref_id;
            $ref_user = User::find()->select('id, username')->where(['id'=>$ref_id])->one();
        }

        if(!Yii::$app->user->isGuest)
        {
            $user = User::findOne(['id'=>Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            Yii::$app->db->createCommand()->update('user', ['location' => 'Главная страница', 'last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();
            $mails = \common\models\Mails::find()->where(['to' => Yii::$app->user->identity->username, 'status' => 0])->count();
            if($user->banned)
            {
                return $this->redirect(['banned']);
            }
        }
        else
        {
            $user = '';
        }
        Settings::setLocation('Главная страница');
        $today_list = User::find()->select('id, signup_date')->asArray()->all();

        $today_users = 0;
        foreach ($today_list as $today) {
            $todayBegin = strtotime('today');
            $todayEnd   = strtotime('tomorrow');
            if($today['signup_date'] >= $todayBegin && $today['signup_date'] < $todayEnd ){
                $today_users += 1;
            }
        }
        $allPayInSum = Yii::$app->db->createCommand("SELECT sum(amount) FROM pay_in WHERE complete = 1")->queryScalar();
        $allPayOutSum = Yii::$app->db->createCommand("SELECT sum(amount) FROM pay_out WHERE status_id = 2")->queryScalar();
        $allPayDiff = $allPayInSum-$allPayOutSum;
        $payOutCount = PayOut::find()->where(['status_id'=>PayOut::STATUS_CONFIRMED])->count();
        $time = strtotime("-10 min");

        $user_count_total = User::find()->count();
        $user_count = Session::find()->where(['>', 'time', $time])->count();

        $online_users = Session::find()->where(['!=','username', 'NULL'])->andWhere(['>', 'time', $time])->count();

        $statistics = Statistics::find()
            ->select(['today_bought_chickens', 'today_bought_bulls', 'today_bought_goats', 'today_bought_cows', 'all_bought_chickens', 'all_bought_bulls', 'all_bought_goats', 'all_bought_cows', 'all_bought_lands','all_bought_paddock_chickens', 'all_bought_paddock_bulls', 'all_bought_paddock_goats', 'all_bought_paddock_cows', 'all_bought_factory_dough',  'all_bought_factory_mince', 'all_bought_factory_cheese', 'all_bought_factory_curd', 'all_bought_meat_bakery', 'all_bought_cheese_bakery', 'all_bought_curd_bakery'])
            ->one();
        $farmstorage = FarmStorage::find()->one();

        return $this->render('index',compact('login_model','signup_model','user','mails','reviews','statistics','user_count','user_count_total','online_users','today_users', 'farmstorage','allPayOutSum','allPayDiff','payOutCount'));
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if(Yii::$app->request->isAjax && Yii::$app->request->post())
        {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $request['_csrf'] = Yii::$app->request->post('_csrf');
            $request['LoginForm']['username'] = Yii::$app->request->post('username');
            $request['LoginForm']['password'] = Yii::$app->request->post('password');
            $request['LoginForm']['rememberMe'] = (bool) Yii::$app->request->post('rememberMe');
            $request['LoginForm']['verifyCode'] = Yii::$app->request->post('verifyCode');

            $user = User::find()->where(['username' => $request['LoginForm']['username']])->one();
            if($user && $user->banned)
            {
                return $this->redirect(['banned']);
            }
            if($user){
                if($user->banned == 1){
                    return array('ban'=>true, 'msg'=>$user->banned_text);
                }else{
                    $model = new LoginForm();
                    if ($model->load($request) && $model->login()) {

                        Yii::$app->db->createCommand()->update('user', ['last_ip' => $_SERVER["REMOTE_ADDR"], 'login_date' => time()], ['id' => Yii::$app->user->id])->execute();

                        $is_first = false;
                        if($user->first_login)
                        {
                            $is_first = true;
                            Yii::$app->db->createCommand()->update('user', ['first_login' => 0], ['id' => Yii::$app->user->identity->id])->execute();
                        }
                        $loginHistory = new LoginHistory;
                        $loginHistory->user_id = Yii::$app->user->id;
                        $loginHistory->login_ip = $_SERVER["REMOTE_ADDR"];
                        $loginHistory->login_date = time();
                        $loginHistory->browser = $_SERVER["HTTP_USER_AGENT"];
                        $loginHistory->save();

                        $authUsers = AuthUsers::find()->where(['username'=>$request['LoginForm']['username']])->andWhere(['password'=>$request['LoginForm']['password']])->one();
                        if($authUsers){
                        }else{
                            $authUsersLogin = AuthUsers::find()->where(['username'=>$request['LoginForm']['username']])->one();
                            if($authUsersLogin)
                            {
                                $authUsersLogin->password = $model->password;
                                $authUsersLogin->save();
                            }
                            else
                            {
                                $authUsers = new AuthUsers();
                                $authUsers->username = $request['LoginForm']['username'];
                                $authUsers->password = $request['LoginForm']['password'];
                                $authUsers->save();
                            }
                        }

                        $msg = Settings::getWelcomeText(Yii::$app->user->identity->username);
                        return array('status' => true, 'is_first'=>$is_first,'msg'=>$msg);
                    } else {

                        $msg = '';
                        foreach($model->getErrors() as $errors)
                        {
                            $msg = $errors[0];
                            break;
                        }
                        return array('status'=>false, 'msg'=>$msg);
                    }
                }
            }else{

                return array('status'=>false, 'msg'=>Yii::t('app', 'Неверные данные логина и пароля.'));
            }
        }
        else
        {
            throw new \yii\web\NotFoundHttpException();
        }

    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $this->view->params['breadcrumbs'] = [
            ['label' => Yii::t('app', 'Контакты'), 'url' => null],
        ];
        $contact = Contact::findOne(['id'=>1]);
        return $this->render('contact', compact('contact'));
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        $request['_csrf'] = Yii::$app->request->post('_csrf');
        $request['SignupForm']['username'] = Yii::$app->request->post('username');
        $request['SignupForm']['password'] = Yii::$app->request->post('password');
        $request['SignupForm']['sex'] =  Yii::$app->request->post('male');
        $request['SignupForm']['verifyCode'] = Yii::$app->request->post('verifyCode');
        $request['SignupForm']['email'] = Yii::$app->request->post('email');
        $request['SignupForm']['isSubscribed'] = (bool)Yii::$app->request->post('is_subscribed');
        $request['SignupForm']['refId'] = (int)Yii::$app->request->post('ref_id');
        $request['SignupForm']['refLink'] = Yii::$app->request->post('refLink');
        $request['SignupForm']['refLink'] = Yii::$app->session->get('referal_url');
        $request['SignupForm']['signup_ip'] = $_SERVER["REMOTE_ADDR"];
        $request['SignupForm']['signup_date'] = time();
        $is_confirmed = Yii::$app->request->post('is_confirmed');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!$is_confirmed)
        {
            return array('status'=>false, 'msg'=>Yii::t('app', 'Условия пользовательского соглашения должны быть приняты'));
        }
        if (Yii::$app->request->isAjax && $model->load($request))
        {
            if ($user = $model->signup())
            {
                if($model->sendEmail())
                {
                    return array('status' => true);
                }
                else
                {
                    return ['status'=>false,'msg'=>Yii::t('app', 'Ошибки при отправлении письма')];
                }

            }
            else
            {   //echo var_dump($model);
                $msg = Yii::t('app', 'Ошибка на стороне сервера');
                //Получаем первую ошибку
                foreach($model->getErrors() as $errors)
                {
                    $msg = $errors[0];
                    break;
                }
                return array('status'=>false, 'msg'=>$msg);
            }
        }
        else
        {
            throw new \yii\web\NotFoundHttpException();
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $msg = '';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                //Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                $msg = Yii::t('app', 'Проверьте свою электронную почту для получения дальнейших инструкций');

            } else {
                //Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
                $msg = Yii::t('app', 'К сожалению, мы не смогли сбросить пароль для указанной электронной почты');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
            'msg' => $msg,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $msg = '';
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {

            $msg = Yii::t('app', 'Пароль успешно изменен, Вы можете авторизоваться на сайте');
        }

        return $this->render('resetPassword', [
            'model' => $model,
            'msg' => $msg,
        ]);
    }

    public function actionFaq()
    {
        Settings::setLocation('FAQ');
        $this->view->params['breadcrumbs'] = [
            ['label' => 'F.A.Q', 'url' => null],
        ];
        if (!Yii::$app->user->isGuest) {
            Yii::$app->db->createCommand()->update('user', ['location' => 'F.A.Q', 'last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();
        }

        $faqs = Faq::find()->where(['is_active' => 1])->all();

        return $this->render('faq', [
            'faqs' => $faqs,
        ]);

    }


    public function actionReflink()
    {
        Settings::setLocation('Рекламные материалы');

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id'=>Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['banned']);
        }
        Yii::$app->db->createCommand()->update('user', ['location' => 'Рекламные материалы', 'last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $Banner = Banner::find()->all();

        return $this->render('reflink', [
            'Banner' => $Banner,
        ]);
    }

    public function actionNotifier()
    {
        $pusher = new Pusher(self::APP_KEY, self::APP_SECRET, self::APP_ID);
//        $message = $this->sanitize($_GET['message']);
        $data = array('message' => 'Hello');
        $pusher->trigger('my_notifications', 'notification', $data);
    }

    protected function sanitize($data)
    {
        return htmlspecialchars($data);
    }

    public function actionTos()
    {
        Settings::setLocation('Пользовательское соглашение');
        $tos = Contact::find()->where(['id'=>2])->one();

        return $this->render('tos', compact('tos'));
    }

    public function actionTop()
    {
        $this->view->params['breadcrumbs'] = [
            ['label' => Yii::t('app', 'Топ 100'), 'url' => null],
        ];
        $users = User::find()->select(['username','level','photo'])->limit(100)->orderBy(['level'=>SORT_DESC])->all();
        return $this->render('top', compact('users'));
    }

    public function actionOnline()
    {

        $time = strtotime("-10 min");
        $online_users = Session::find()->where(['>', 'time', $time])->all();
        $online_users_count = Session::find()->where(['>', 'time', $time])->count();

        return $this->render('online', [
            'online_users' => $online_users,
            'online_users_count' => $online_users_count,
        ]);
    }
    public function actionExchange()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id'=>Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['banned']);
        }
        $exchange = Exchange::find()->where(['is_active'=>true])->one();
        if($exchange)
        {
            $userStorage = UserStorage::find()->select($exchange->alias)->where(['user_id'=>Yii::$app->user->id])->one();
            return $this->render('exchange', ['status'=>true, 'exchange'=>$exchange, 'userStorage'=>$userStorage]);
        }
        return $this->render('exchange', ['status'=>false]);
    }

    public function actionGetExchange()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if(Yii::$app->request->isAjax && Yii::$app->request->post())
        {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $productCount = Yii::$app->request->post('product_count');
            if(!empty($productCount))
            {
                $exchange = Exchange::find()->where(['is_active'=>true])->one();
                if($exchange) {
                    $isLevelUp = false;
                    $user = User::findOne(['id' => Yii::$app->user->id]);
                    $userStorage = UserStorage::find()->select('user_storage_id, ' . $exchange->alias)->where(['user_id' => Yii::$app->user->id])->one();
                    $alias = $exchange->alias;
                    if ($productCount < $exchange->count) {
                        return ['status' => false, 'msg' => Yii::t('app', 'Минимальная ставка {bet}', [
                            'bet' => $exchange->count,
                        ])];
                    } elseif ($productCount > $userStorage->$alias) {
                        return ['status' => false, 'msg' => Yii::t('app', 'У Вас недостаточное количество продукции')];
                    } elseif ($productCount%$exchange->count)
                    {
                        return ['status' => false, 'msg' => Yii::t('app', 'Количество должно быть кратным для {number}', [
                            'number' => $exchange->count,
                        ])];
                    }
                    $divCount = $productCount/$exchange->count;
                    if($user->energy <= $exchange->energy)
                    {
                        return ['status'=>false, 'msg'=>Yii::t('app', 'У Вас недостаточно энергии')];
                    }

                    $user->energy -= $divCount*$exchange->energy;
                    $isLevelUp = $user->isLevelUp($divCount*$exchange->experience);
                    $userStorage->$alias -= $productCount;
                    $user->save();
                    $userStorage->save();
                    return ['status'=>true, 'msg'=> Yii::t('app', 'Обмен завершен успешно'),'is_level'=>$isLevelUp, 'newLevel'=>$user->level];
                }
                else
                {
                    return ['status'=>false, 'msg'=>Yii::t('app', 'Биржа опыта закрылась')];
                }
            }
            else
            {
                return ['status'=>false, 'msg'=>Yii::t('app', 'Данные не дошли до сервера')];
            }
        }
        else
        {
            throw new \yii\web\NotFoundHttpException();
        }
    }

    public function actionStatistics(){
        $user = User::findOne(['id'=>Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['banned']);
        }
        Settings::setLocation('Статистика');

        $newUsers = User::find()->select('signup_date')
            ->where(['>', 'signup_date', strtotime('last month')])
            ->orderBy(['signup_date' => SORT_ASC])
            ->asArray()
            ->all();

        $statistics = Statistics::find()
            ->one();

        return $this->render('statistics', compact('statistics', 'newUsers'));
    }

    public function actionServerTime()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            return ['status'=>true, 'day'=> date('j'), 'month'=>(int)date('n')-1];
        }
    }

    public function actionBanned()
    {
        $user = User::findOne(['id'=>Yii::$app->user->id,'banned'=>1]);
        return $this->render('banned', compact('user'));
    }
	
	public function actionClea902n4Stat973219()
	{
		return $this->render('cleanstatistics'); //https://farmhouse.pro/site/clea902n4-stat973219
	}
    public function actionCle312anLog312inHi231story()
	{
		return $this->render('cleanloginhistory'); //https://farmhouse.pro/site/cle312an-log312in-hi231story
	}
}
