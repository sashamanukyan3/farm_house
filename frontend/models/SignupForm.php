<?php
namespace frontend\models;

use common\models\LandItem;
use common\models\PaddockChickenItems;
use common\models\PurchaseHistory;
use common\models\User;
use common\models\UserStorage;
use common\models\Land;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $verifyCode;
    public $sex;
    public $isSubscribed;
    public $refId;
    public $refLink;
    public $signup_ip;
    public $signup_date;
    public $login_date;
    public $last_ip;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app', 'Пользователь с таким логином уже существует')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app', 'Пользователь с такой почтой уже существует')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['verifyCode', 'captcha'],
            ['sex', 'integer'],
            ['refId', 'integer'],
            ['refLink', 'string'],
            ['isSubscribed', 'boolean'],
            ['signup_date', 'integer'],
            ['login_date', 'integer'],
            ['signup_ip', 'string'],
            ['last_ip', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'verifyCode' => Yii::t('app', 'Я не бот'),
            'username' => Yii::t('app', 'Логин'),
            'password' => Yii::t('app', 'Пароль'),
            'sex' => Yii::t('app', 'Пол'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->sex = $this->sex;
            $user->photo = 'ava.png';
            $user->is_subscribed = $this->isSubscribed;
            $user->ref_id = $this->refId;
            $user->refLink = $this->refLink;
            $user->level = 1;
            $user->energy = 100;
            $user->signup_ip = $this->signup_ip;
            $user->signup_date = $this->signup_date;
            $user->need_experience = 10;
            $user->pay_pass = mt_rand(1000, 9999);
            $user->first_login = 1;

            $user->generateAuthKey();

            if ($user->save()) {
                //create user storage
                $userStorage = new UserStorage();
                $userStorage->user_id = $user->id;
                $userStorage->save();

                //create 9 land items
                $landItems = array();
                for($i=1; $i<10;$i++)
                {
                    $landItems[$i]['user_id'] = $user->id;

                    $landItems[$i]['position_number'] = $i;
                    // 0 потому что пока неизвестно что здесь будет посажено
                    $landItems[$i]['plant_alias'] = 0;
                    $landItems[$i]['is_fertilized'] = 0;
                    if($i < 2)
                    {
                        $status_id = LandItem::STATUS_READY_FOR_SOW;
                        $landItems[$i]['level'] = 1;
                    }
                    elseif($i > 1 && $i < 5)
                    {
                        $status_id = LandItem::STATUS_AVAILABLE;
                        $landItems[$i]['level'] = 1;
                    }
                    else
                    {
                        if($i<9 && $i>=5)
                        {
                            $landItems[$i]['level'] = 2;
                        }
                        else
                        {
                            $landItems[$i]['level'] = 3;
                        }
                        $status_id = LandItem::STATUS_NOT_AVAILABLE;
                    }
                    $landItems[$i]['status_id'] = $status_id;
                }
                Yii::$app->db->createCommand()->batchInsert('land_items', ['user_id', 'position_number','plant_alias','is_fertilized','level','status_id'],
                    $landItems
                )->execute();
                unset($landItems);

                for($j = 1; $j < 10; $j++) {
                    $paddockItems = new PaddockChickenItems();
                    $paddockItems->user_id = $user->id;
                    if($j == 1){
                        $paddockItems->status_id = PaddockChickenItems::STATUS_READY;
                    }
                    else {
                        $paddockItems->status_id = PaddockChickenItems::STATUS_NOT_AVAILABLE;
                    }
                    $paddockItems->level = $j;
                    $paddockItems->save();
                    if($j == 1){$firstPaddockItemId = $paddockItems->item_id;}
                }
                //echo '<pre>'; var_dump($lastPaddockItemId); die();
                $chickenItems = array();
                for($k = 1; $k < 10; $k++) {
                    $chickenItems[$k]['paddock_id'] = $firstPaddockItemId;
                    $chickenItems[$k]['user_id'] = $user->id;
                    $chickenItems[$k]['position'] = $k;
                }
                Yii::$app->db->createCommand()
                    ->batchInsert('chicken_items', ['paddock_id', 'user_id', 'position'], $chickenItems)
                    ->execute();
                unset($chickenItems);

                //create 9 paddock_bull_items
                $paddockBullItems = array();
                for($j = 5; $j < 14; $j++) {
                    $paddockBullItems[$j]['user_id'] = $user->id;
                    $paddockBullItems[$j]['level'] = $j;
                }

                Yii::$app->db->createCommand()
                    ->batchInsert('paddock_bull_items', ['user_id', 'level'], $paddockBullItems)
                    ->execute();
                unset($paddockBullItems);

                //create 9 paddock_goat_items
                $paddockGoatItems = array();
                for($j = 10; $j < 19; $j++) {
                    $paddockGoatItems[$j]['user_id'] = $user->id;
                    $paddockGoatItems[$j]['level'] = $j;
                }

                Yii::$app->db->createCommand()
                    ->batchInsert('paddock_goat_items', ['user_id', 'level'], $paddockGoatItems)
                    ->execute();
                unset($paddockGoatItems);

                //create 9 paddock_items
                $paddockCowItems = array();
                for($j = 15; $j < 24; $j++) {
                    $paddockCowItems[$j]['user_id'] = $user->id;
                    $paddockCowItems[$j]['level'] = $j;
                }

                Yii::$app->db->createCommand()
                    ->batchInsert('paddock_cow_items', ['user_id', 'level'], $paddockCowItems)
                    ->execute();
                unset($paddockGoatItems);

                //create 9 factory_dough_items
                $factoryDoughItems = array();
                for($f = 10; $f <= 330; $f+=40) {
                    $factoryDoughItems[$f]['user_id'] = $user->id;
                    $factoryDoughItems[$f]['level'] = $f;
                }

                Yii::$app->db->createCommand()
                    ->batchInsert('factory_dough', ['user_id', 'level'], $factoryDoughItems)
                    ->execute();
                unset($factoryDoughItems);

                //create 9 factory_mince_items
                $factoryMinceItems = array();
                for($f = 20; $f <= 340; $f+=40) {
                    $factoryMinceItems[$f]['user_id'] = $user->id;
                    $factoryMinceItems[$f]['level'] = $f;
                }

                Yii::$app->db->createCommand()
                    ->batchInsert('factory_mince', ['user_id', 'level'], $factoryMinceItems)
                    ->execute();
                unset($factoryDoughItems);

                //create 9 factory_cheese_items
                $factoryCheeseItems = array();
                for($f = 30; $f <= 350; $f+=40) {
                    $factoryCheeseItems[$f]['user_id'] = $user->id;
                    $factoryCheeseItems[$f]['level'] = $f;
                }

                Yii::$app->db->createCommand()
                    ->batchInsert('factory_cheese', ['user_id', 'level'], $factoryCheeseItems)
                    ->execute();
                unset($factoryCheeseItems);

                //create 9 factory_mince_items
                $factoryCurdItems = array();
                for($f = 40; $f <=360; $f+=40) {
                    $factoryCurdItems[$f]['user_id'] = $user->id;
                    $factoryCurdItems[$f]['level'] = $f;
                }

                Yii::$app->db->createCommand()
                    ->batchInsert('factory_curd', ['user_id', 'level'], $factoryCurdItems)
                    ->execute();
                unset($factoryCurdItems);

                //create 9 mince_bakery
                $minceBakeryItems = array();
                for($f = 30; $f <=270; $f+=30) {
                    $minceBakeryItems[$f]['user_id'] = $user->id;
                    $minceBakeryItems[$f]['level'] = $f;
                }

                Yii::$app->db->createCommand()
                    ->batchInsert('meat_bakery', ['user_id', 'level'], $minceBakeryItems)
                    ->execute();
                unset($minceBakeryItems);

                //create 9 cheese_bakery
                $cheeseBakeryItems = array();
                for($f = 40; $f <=280; $f+=30) {
                    $cheeseBakeryItems[$f]['user_id'] = $user->id;
                    $cheeseBakeryItems[$f]['level'] = $f;
                }

                Yii::$app->db->createCommand()
                    ->batchInsert('cheese_bakery', ['user_id', 'level'], $cheeseBakeryItems)
                    ->execute();
                unset($cheeseBakeryItems);

                //create 9 curd_bakery
                $curdBakeryItems = array();
                for($f = 50; $f <=290; $f+=30) {
                    $curdBakeryItems[$f]['user_id'] = $user->id;
                    $curdBakeryItems[$f]['level'] = $f;
                }

                Yii::$app->db->createCommand()
                    ->batchInsert('curd_bakery', ['user_id', 'level'], $curdBakeryItems)
                    ->execute();
                unset($curdBakeryItems);

                $purchaseType = ['chicken', 'bull', 'goat', 'cow', 'paddock_chickens', 'paddock_bulls', 'paddock_goats', 'paddock_cows', 'factory_dough', 'factory_mince', 'factory_cheese', 'factory_curd', 'meat_bakery', 'cheese_bakery', 'curd_bakery'];
                $purchaseComment = ['Покупка животных: курица', 'Покупка животных: бычок', 'Покупка животных: коза', 'Покупка животных: корова', 'Покупка загона: загон кур', 'Покупка загона: загон бычков', 'Покупка загона: загон коз', 'Покупка загона: загон коров', 'Покупка фабрики: фабрика теста', 'Покупка фабрики: фабрика фарша', 'Покупка фабрики: фабрика сыра', 'Покупка фабрики: фабрика творога', 'Покупка пекарни: пекарня пирога с мясом', 'Покупка перкарни: пекарня пирога с сыром', 'Покупка пекарни: пекарня пирога с творогом'];
                for($k = 0; $k <= count($purchaseType)-1; $k++){
                    $purchase[$k]['username'] = $user->username;
                    $purchase[$k]['alias'] = $purchaseType[$k];
                    $purchase[$k]['comment'] = $purchaseComment[$k];
                    $purchase[$k]['time_buy'] = time();
                }
                Yii::$app->db->createCommand()
                    ->batchInsert('purchase_history', ['username', 'alias', 'comment', 'time_buy'], $purchase)
                    ->execute();
                unset($purchaseType, $purchaseComment, $purchase);

                $purchaseType = ['feed_chickens', 'feed_bulls', 'feed_goats', 'feed_cows', 'chicken', 'bull', 'goat', 'cow', 'paddock_chickens', 'paddock_bulls', 'paddock_goats', 'paddock_cows', 'factory_dough', 'factory_mince', 'factory_cheese', 'factory_curd', 'meat_bakery', 'cheese_bakery', 'curd_bakery'];
                $purchaseComment = ['Покупка корма животных: корм кур', 'Покупка корма животных: корм бычков', 'Покупка корма животных: корм коз', 'Покупка корма животных: корм коров', 'Покупка животных: курица', 'Покупка животных: бычок', 'Покупка животных: коза', 'Покупка животных: корова', 'Покупка загона: загон кур', 'Покупка загона: загон бычков', 'Покупка загона: загон коз', 'Покупка загона: загон коров', 'Покупка фабрики: фабрика теста', 'Покупка фабрики: фабрика фарша', 'Покупка фабрики: фабрика сыра', 'Покупка фабрики: фабрика творога', 'Покупка пекарни: пекарня пирога с мясом', 'Покупка перкарни: пекарня пирога с сыром', 'Покупка пекарни: пекарня пирога с творогом'];
                for($e = 0; $e <= count($purchaseType)-1; $e++){
                    $myPurchase[$e]['user_id'] = $user->id;
                    $myPurchase[$e]['alias'] = $purchaseType[$e];
                    $myPurchase[$e]['comment'] = $purchaseComment[$e];
                }
                Yii::$app->db->createCommand()
                    ->batchInsert('my_purchase_history', ['user_id', 'alias', 'comment'], $myPurchase)
                    ->execute();
                unset($purchaseType, $purchaseComment, $myPurchase);

                return $user;
            }
        }

        return null;
    }

    /**
     * Sends an email with signup datas.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            $textBody = Yii::t('app', 'Ваш логин') . ': ' .
                $user->username  . ' ' .
                Yii::t('app', 'Ваш платежный пароль') . ': ' .
                $user->pay_pass;
            return \Yii::$app->mailer->compose()
                ->setFrom(['f.farmhouse@yandex.ru' => \Yii::$app->name . ' robot'])
                ->setTo($user->email)
                ->setSubject(Yii::t('app', 'Регистрация на сайте Ферма') . '!')
                ->setTextBody($textBody)
                ->send();
        }

        return false;
    }
}
