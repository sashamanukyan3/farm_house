<?php
namespace frontend\controllers;

use common\models\Bonus;
use common\models\BonusBuy;
use common\models\BonusTotal;
use common\models\Friends;
use common\models\Mails;
use common\models\Message;
use common\models\Reviews;
use common\models\Settings;
use common\models\User;
use vova07\imperavi\actions\GetAction;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class BonusController extends Controller
{

    public function actionIndex(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        Settings::setLocation('Бонус');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $BonusAddList = Bonus::find()->limit(20)->orderBy(['id' => SORT_DESC])->all();

        $BonusBuyList = BonusBuy::find()->limit(10)->orderBy(['id' => SORT_DESC])->all();

        $BonusBuyModel = new BonusBuy();

        $BonusRemaining = BonusTotal::find()->where(['id' => 1])->one();

        $bonusTotalPrice = BonusTotal::findOne(['id' => 1]);

        if ($BonusBuyModel->load(Yii::$app->request->post())) {
            if($user->energy < Settings::$bonusEnergy)
            {
                echo '<div class="alert alert-danger bonus-error-msg" role="alert">'.Settings::bonusEnergyMsg().'</div>';
            }
            else
            {
                $data = Yii::$app->request->post();
                if(!empty($data)) {
                    if ($bonusTotalPrice->price >= Settings::$bonusAdd) {
                        $PostDate = $data["BonusBuy"]["date"];
                        $PostHour = time();
                        $PostUsername = $data["BonusBuy"]["username"];

                        $BonusBuyControl = BonusBuy::find()->where(['username' => $PostUsername])->orderBy(['id' => SORT_DESC])->one();

                        if ($BonusBuyControl) {
                            $LastHour = $BonusBuyControl->date;
                        } else {
                            $LastHour = 3700;
                        }

                        $test = $PostHour - $LastHour;
                        if ($test > 3600) {
                            $BonusBuyModel->summ = Settings::$bonusAdd;
                            $BonusBuyModel->save();
                            $user->energy -= Settings::$bonusEnergy;
                            $user->for_pay += Settings::$bonusAdd;
                            $user->save();
                            $ForPrice = BonusTotal::find()->where(['id' => 1])->one();
                            $ForPrice->updateCounters(['price' => -Settings::$bonusAdd]);
                            return $this->redirect(['bonus/index']);
                        } else {
                            echo '<div class="alert alert-danger bonus-error-msg" role="alert">' . Settings::bonusMsg() . '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger bonus-error-msg" role="alert">' . Yii::t('app', 'В резерве бонуса недостаточно средств') . '</div>';
                    }
                }
            }
        }

        return $this->render('index', [
            'user' => $user,
            'BonusAddList' => $BonusAddList,
            'BonusBuyModel' => $BonusBuyModel,
            'BonusBuyList' => $BonusBuyList,
            'BonusRemaining' => $BonusRemaining,
        ]);

    }

    public function actionAdd(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        Settings::setLocation('Бонус');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $model = new Bonus();

        $BonusAddList = Bonus::find()->limit(30)->orderBy(['id' => SORT_DESC])->all();

        $BonusRemaining = BonusTotal::find()->where(['id' => 1])->one();

        $command = Yii::$app->db->createCommand("SELECT sum(price) FROM bonus");

        $test = $command->queryScalar();

        if(Yii::$app->request->post()) {
            $data = Yii::$app->request->post();

            if(!empty($data)) {
                $price = floatval($data['price']);
                $username = Yii::$app->user->identity->username;

                $ForPayControl = User::find()->select(['id', 'username', 'for_pay'])->where(['username' => $username])->one();
                if ($price > 0) {
                    if ($price < $ForPayControl->for_pay) {

                        $bonusModel = new Bonus();

                        $bonusModel->price = $price;
                        $bonusModel->username = $username;
                        $bonusModel->date = time();

                        $bonusModel->save();

                        if ($bonusModel->save()) {
                            $ForPay = User::find()->where(['username' => $username])->one();
                            $ForPay->updateCounters(['for_pay' => -$price]);
                            $ForPrice = BonusTotal::find()->where(['id' => 1])->one();
                            $ForPrice->updateCounters(['price' => $price]);
                            return $this->redirect(['bonus/add']);
                        }
                    } else {
                        echo '<div class="alert alert-danger bonus-error-msg" role="alert">' . Settings::bonusMessage() . '</div>';
                    }
                }
            }
        }

        return $this->render('add', [
            'user' => $user,
            'model' => $model,
            'BonusAddList' => $BonusAddList,
            'BonusRemaining' => $BonusRemaining,
            'test' => $test,
        ]);

    }

}
