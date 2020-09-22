<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18.02.2016
 * Time: 15:27
 */

namespace frontend\controllers;
use common\models\ExchangeHistory;
use common\models\PayIn;
use common\models\PayOut;
use common\models\Settings;
use common\models\TransferHistory;
use common\models\User;
use frontend\models\PayForm;
use frontend\models\PayOutForm;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

class PayController extends Controller
{
    /**
     * Обменный пункт
     */
    public function actionExchanger()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        return $this->render('exchanger', compact('user'));

    }

    /**
     * Обменять
     */
    public function actionDoExchange()
    {
        if (Yii::$app->request->isAjax) {
            $summ = Yii::$app->request->post('summ');
            $user = User::findOne(['id' => Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            Yii::$app->response->format = 'json';
            if ($summ) {
                if ($user->for_out >= $summ) {
                    $user->for_out -= $summ;
                    $user->for_pay += $summ;
                    $user->save();
                    $userExchangeHistory = new ExchangeHistory();
                    $userExchangeHistory->amount = $summ;
                    $userExchangeHistory->user_id = $user->id;
                    $userExchangeHistory->created = time();
                    $userExchangeHistory->save();
                    return ['status' => true, 'msg' => Yii::t('app', 'Обмен успешно произведен'), 'for_out' => $user->for_out];
                } else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Сумма для перевода недостаточна')];
                }
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка при обмене. Сумма неизвестна')];
            }
        } else {
            throw new NotFoundHttpException;
        }
    }

    /**
     * Перевод
     */
    public function actionTransfer()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        return $this->render('transfer', compact('user'));
    }

    /**
     * Передать
     */
    public function actionDoTransfer()
    {
        if (Yii::$app->request->isAjax) {
            $summ = Yii::$app->request->post('summ');
            $username = trim(htmlentities(strip_tags(Yii::$app->request->post('username'))));
            $pay_pass = (int)trim(htmlentities(strip_tags(Yii::$app->request->post('pay_pass'))));
            $userFrom = User::findOne(['id' => Yii::$app->user->id]);
            if($userFrom->banned)
            {
                return $this->redirect(['site/banned']);
            }
            Yii::$app->response->format = 'json';
            if (!empty($summ) && !empty($username) && !empty($pay_pass)) {
                $userTo = User::findOne(['username'=> $username]);
                if(is_null($userTo))
                {
                    return ['status'=>false, 'msg'=>Yii::t('app', 'Пользователь с таким логином не существует')];
                }
                if($userFrom->pay_pass != $pay_pass)
                {
                    return ['status'=>false, 'msg'=>Yii::t('app', 'Неправильный платежный пароль')];
                }
                $transferSumm = $summ + ($summ * Settings::$transferProcent)/100;
                if($userFrom->for_pay < $transferSumm)
                {
                    return ['status'=>false, 'msg'=>Yii::t('app', 'У Вас недостаточно средств')];
                }
                if ($userFrom->for_pay >= $summ) {
                    $userTo->for_pay += $summ;
                    $userFrom->for_pay -= $transferSumm;
                    $userFrom->save();
                    $userTo->save();
                    $transferHistory = new TransferHistory();
                    $transferHistory->user_id = Yii::$app->user->id;
                    $transferHistory->username = $username;
                    $transferHistory->amount = $summ;
                    $transferHistory->created = time();
                    $transferHistory->save();
                    return ['status' => true, 'msg' => Yii::t('app', 'Перевод успешно произведен')];
                } else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Сумма для перевода недостаточна')];
                }
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'Все поля должны быть заполнены')];
            }
        } else {
            throw new NotFoundHttpException;
        }
    }

    /**
     * Оплата Yandex
     */
    public function actionPayYandex()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
            if(Yii::$app->getSession()->get('sum'))
            {
            $user = User::findOne(['id' => Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            $sum = Yii::$app->getSession()->get('sum');
            Yii::$app->getSession()->remove('sum');
            Yii::$app->getSession()->set('transfer',$sum);
            return $this->render('pay-yandex',compact('sum'));
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }


    public function actionStatus()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $msg = Yii::$app->request->get('msg');
        if (!empty($msg)) {
            return $this->render('status',compact('msg'));
        }
        else
        {
            return $this->goHome();
        }
    }

    /**
     * Список платежек
     */
    public function actionList()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $msg = Yii::$app->request->get('msg');
        $errMsg = Yii::$app->request->get('ermsg');
        if($msg)
        {
            $msg = Yii::t('app', 'Пополнение успешно завершено');
        }
        if($errMsg)
        {
            $msg = Yii::t('app', 'Пополнение не завершено');
        }

        $payForm = new PayForm();
        return $this->render('list', compact('payForm','msg'));
    }

    /**
     * Принимаем оплату и редиректим в нужную сторону
     */
    public function actionSend()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }

        if(Yii::$app->request->post())
        {
            $PayForm = new PayForm();
            if($PayForm->load(Yii::$app->request->post()))
            {
                if($PayForm->sum < 0.01)
                {
                    \Yii::$app->getSession()->setFlash('pay_err', Yii::t('app', 'Сумма должна быть больше {sum}', [
                        'sum' => '0.01',
                    ]));
                    return $this->redirect(['list']);
                }
                ini_set("session.cookie_domain", ".farmhouse.pro");
                Yii::$app->getSession()->set('sum',$PayForm->sum);
                $user_id = Yii::$app->user->id;
                setcookie("user_id", "$user_id", time()+3600 , "/", ".farmhouse.pro");
                $payIn = new PayIn();
                $payIn->amount = $PayForm->sum;
                $payIn->username = Yii::$app->user->identity->username;
                $payIn->complete = 0;
                $p_sum = $payIn->amount;
                switch($PayForm->pay_type)
                {
                    //QIWI
                    case 1:
                        $payIn->purse = 'QIWI';
                        $payIn->save();
                        $payId = $payIn->id;
                        setcookie("p_id", "$payId", time()+3600 , "/", ".farmhouse.pro");
                        setcookie("p_sum", "$p_sum", time()+3600 , "/", ".farmhouse.pro");
                        $merchant_id 	= '';
                        $secret_word 	= '';
                        $order_id 		= time()+1;
                        $order_amount 	= number_format($PayForm->sum, 2, '.', '');
                        $singtest		= $merchant_id.':'.$order_amount.':'.$secret_word.':'.$order_id;
                        $sign = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$order_id);
                        return $this->redirect("http://www.mykassa.org/api/merchant.php?m=".$merchant_id."&oa=".$order_amount."&o=".$order_id."&s=".$sign."&i=&lang=ru&us_uid=".Yii::$app->user->id);

                    //Payeer.com
                    case 2:
                        $payIn->purse = 'Payeer';
                        $payIn->save();
                        $payId = $payIn->id;
                        setcookie("p_id", "$payId", time()+3600 , "/", ".farmhouse.pro");
                        setcookie("p_sum", "$p_sum", time()+3600 , "/", ".farmhouse.pro");
                        $m_shop 	= '';
                        $m_orderid 	= $payId;
                        $m_amount 	= number_format($PayForm->sum, 2, '.', '');
                        $m_curr 	= 'RUB';
                        $m_desc 	= base64_encode(Yii::t('app', 'Пополнение Фермы') . ' ');
                        $m_key 	= '';
                        $sign = strtoupper(hash('', implode(':', array(
                            $m_shop,
                            $m_orderid,
                            $m_amount,
                            $m_curr,
                            $m_desc,
                            $m_key
                        ))));

                        return $this->redirect("https://payeer.com/merchant/?m_shop=".$m_shop."&m_orderid=".$m_orderid."&m_amount=".$m_amount."&m_curr=".$m_curr."&m_desc=".$m_desc."&m_sign=".$sign);

                    //freekassa.com
                    case 3:
                        $payIn->purse = 'freekassa';
                        $payIn->save();
                        $payId = $payIn->id;
                        setcookie("p_id", "$payId", time()+3600 , "/", ".farmhouse.pro");
                        setcookie("p_sum", "$p_sum", time()+3600 , "/", ".farmhouse.pro");
                        $merchant_id 	= '';
                        $secret_word 	= '';
                        $order_id 		= time()+1;
                        $order_amount 	= number_format($PayForm->sum, 2, '.', '');
                        $sign = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$order_id);
                        return $this->redirect("http://www.free-kassa.ru/merchant/cash.php?m=".$merchant_id."&oa=".$order_amount."&o=".$order_id."&s=".$sign."&i=&lang=ru&us_uid=".Yii::$app->user->id);

                    //Yandex.Деньги
                    case 4:
                        $payIn->purse = 'Yandex';
                        $payIn->save();
                        $payId = $payIn->id;
                        setcookie("p_id", "$payId", time()+3600 , "/", ".farmhouse.pro");
                        setcookie("p_sum", "$p_sum", time()+3600 , "/", ".farmhouse.pro");
                        return $this->redirect(['pay-yandex']);

                    //mykassa
                    case 5:
                        $payIn->purse = 'mykassa';
                        $payIn->save();
                        $payId = $payIn->id;
                        setcookie("p_id", "$payId", time()+3600 , "/", ".farmhouse.pro");
                        setcookie("p_sum", "$p_sum", time()+3600 , "/", ".farmhouse.pro");
                        $merchant_id 	= '';
                        $secret_word 	= '';
                        $order_id 		= time()+1;
                        $order_amount 	= number_format($PayForm->sum, 2, '.', '');
                        $singtest		= $merchant_id.':'.$order_amount.':'.$secret_word.':'.$order_id;
                        $sign = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$order_id);
                        return $this->redirect("http://www.mykassa.org/api/merchant.php?m=".$merchant_id."&oa=".$order_amount."&o=".$order_id."&s=".$sign."&i=&lang=ru&us_uid=".Yii::$app->user->id);
                }

            }
            else
            {
                Yii::$app->getSession()->setFlash('pay_err', Yii::t('app', 'Все поля должны быть заполнены'));
                return $this->redirect(['list']);
            }
        }
    }

    public function actionOut()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        $msg = Yii::$app->request->get('msg');
        $user = User::findOne(['id'=>Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $payOutForm = new PayOutForm();
        $lastMyPayOut = PayOut::find()->where(['username'=>$user->username])->orderBy(['created_at'=>SORT_DESC])->one();
//        var_dump($lastMyPayOut->created_at); die;
        $payOutList = PayOut::find()->where(['username'=>Yii::$app->user->identity->username])->orderBy(['created_at' => SORT_DESC])->limit(10)->all();
        return $this->render('out', compact('user','payOutForm', 'payOutList', 'msg', 'lastMyPayOut'));
    }

    public function actionSendOut()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->post())
        {
            $payOutForm = new PayOutForm();
            if($payOutForm->load(Yii::$app->request->post()))
            {
                $user = User::findOne(['id'=>Yii::$app->user->id]);
                if($user->banned)
                {
                    return $this->redirect(['site/banned']);
                }
                $lastMyPayOut = PayOut::find()->where(['username'=>$user->username])->orderBy(['created_at'=>SORT_DESC])->one();
                if((is_object($lastMyPayOut) && ($lastMyPayOut->created_at < strtotime('24 hour'))) || is_null($lastMyPayOut)) {
                    if ($payOutForm->pay_pass == $user->pay_pass) {
                        if ($payOutForm->sum >= 2) {
                            $payOut = new PayOut();
                            $payOut->pay_type = $payOutForm->pay_type;
                            $payOut->username = $user->username;
                            $payOut->created_at = time();
                            $payOut->status_id = PayOut::STATUS_OPEN;
                            $payOut->purse = $payOutForm->purse;
                            if ($payOutForm->sum >= 2 && $payOutForm->sum < 10) {
                                if ($user->for_out >= $payOutForm->sum) {
                                    if ($user->energy >= 2) {
                                        $user->for_out -= $payOutForm->sum;
                                        $user->energy -= 1;
                                        $payOut->amount = $payOutForm->sum - ($payOutForm->sum * 0.05);
                                    } else {
                                        return $this->redirect(['out', 'msg' => Yii::t('app', 'У вас недостаточно энергии')]);
                                    }
                                } else {
                                    return $this->redirect(['out', 'msg' => Yii::t('app', 'У вас недостаточно средств для вывода')]);
                                }
                            } elseif ($payOutForm->sum >= 10 && $payOutForm->sum < 100) {
                                if ($user->for_out >= $payOutForm->sum) {
                                    if ($user->energy >= intval($payOutForm->sum / 10)) {
                                        $user->for_out -= $payOutForm->sum;
                                        $user->energy -= intval($payOutForm->sum / 10);
                                        $payOut->amount = $payOutForm->sum - ($payOutForm->sum * 0.02);
                                    } else {
                                        return $this->redirect(['out', 'msg' => Yii::t('app', 'У вас недостаточно энергии')]);
                                    }
                                } else {
                                    return $this->redirect(['out', 'msg' => Yii::t('app', 'У вас недостаточно средств для вывода')]);
                                }
                            } elseif ($payOutForm->sum >= 100 && $payOutForm->sum < 1000) {
                                if ($user->for_out >= $payOutForm->sum) {
                                    if ($user->energy >= intval($payOutForm->sum / 10)) {
                                        $user->for_out -= $payOutForm->sum;
                                        $user->energy -= intval($payOutForm->sum / 10);
                                        $payOut->amount = $payOutForm->sum - ($payOutForm->sum * 0.01);
                                    } else {
                                        return $this->redirect(['out', 'msg' => Yii::t('app', 'У вас недостаточно энергии')]);
                                    }
                                } else {
                                    return $this->redirect(['out', 'msg' => Yii::t('app', 'У вас недостаточно средств для вывода')]);
                                }
                            } else {
                                if ($user->for_out >= $payOutForm->sum) {
                                    if ($user->energy >= intval($payOutForm->sum / 10)) {
                                        $user->for_out -= $payOutForm->sum;
                                        $user->energy -= intval($payOutForm->sum / 10);
                                        $payOut->amount = $payOutForm->sum;
                                    } else {
                                        return $this->redirect(['out', 'msg' => Yii::t('app', 'У вас недостаточно энергии')]);
                                    }
                                } else {
                                    return $this->redirect(['out', 'msg' => Yii::t('app', 'У вас недостаточно средств для вывода')]);
                                }
                            }
                            if ($payOut->save() && $user->save()) {
                                return $this->redirect(['out', 'msg' => Yii::t('app', 'Запрос успешно отправлен! Вы можете посмотреть статус запроса <a href="{link}">здесь</a>', [
                                    'link' => Url::toRoute('/pay/out-history'),
                                ])]);
                            } else {
                                return $this->redirect(['out', 'msg' => Yii::t('app', 'Ошибка на стороне сервера')]);
                            }
                        } else {
                            return $this->redirect(['out', 'msg' => Yii::t('app', 'Минимальная сумма на вывод {rub} рубля', ['rub' => 2])]);
                        }
                    } else {
                        return $this->redirect(['out', 'msg' => Yii::t('app', 'Неправильный платежный пароль')]);
                    }
                }else{
                    return $this->redirect(['out', 'msg' => Yii::t('app', 'Вы не можете выводить средства чаще чем 1 раз в сутки')]);
                }
                /*
                 Сумма от 1.00 руб до 9.99 руб - комиссия 5%
                Сумма от 10.00 руб до 99.99 руб - комиссия 2%
                Сумма от 100.00 руб до 999.99 руб - комиссия 1%
                Сумма от 1000.00 руб и выше - комиссия 0%
                При выводе средств снимается энергия, за каждые 10 руб 1 ед энергии. Минимум - 1 ед энергии.
                 */
            }
            else
            {

            }
        }
        else
        {
            throw new NotFoundHttpException;
        }

    }

    public function actionLast()
    {
        $this->view->params['breadcrumbs'] = [
            ['label' => Yii::t('app', 'Последние выплаты'), 'url' => null],
        ];
        $payOutList = PayOut::find()->where(['status_id'=>PayOut::STATUS_CONFIRMED])->orderBy(['created_at' => SORT_DESC])->limit(100)->all();

        return $this->render('last', compact('payOutList'));
    }

    public function actionCancel()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        if (Yii::$app->request->isAjax) {
            $user = User::find()->where(['id' => Yii::$app->user->id])->one();
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            Yii::$app->response->format = 'json';
            $id = Yii::$app->request->post('id');
            $payOut = PayOut::find()->where(['id' => $id])->one();
            $payOut->status_id = PayOut::STATUS_CANCELED;
            $payOut->created_at = time();

            $user->for_pay += $payOut->amount;
            if ($user->save() && $payOut->save()) {
                return ['status' => true, 'msg' => Yii::t('app', 'Заявка на вывод средств отменена')];
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера')];
            }
        } else {
            throw new NotFoundHttpException;
        }
    }

    public function actionTransferHistory()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $transferHistory = TransferHistory::find()->where(['user_id'=>Yii::$app->user->id])->orderBy(['created' => SORT_DESC])->all();
        $allSum = TransferHistory::find()->where(['user_id'=>Yii::$app->user->id])->sum('amount');
        return $this->render('transfer-history', compact('transferHistory','allSum'));
    }

    public function actionExchangeHistory()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $exchangeHistory = ExchangeHistory::find()->where(['user_id'=>Yii::$app->user->id])->orderBy(['created' => SORT_DESC])->all();
        $allSum = ExchangeHistory::find()->where(['user_id'=>Yii::$app->user->id])->sum('amount');
        return $this->render('exchange-history', compact('exchangeHistory','allSum'));
    }

    public function actionInHistory()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $payIn = PayIn::find()->where(['username'=>Yii::$app->user->identity->username])->orderBy(['created'=>SORT_DESC])->all();
        $allSum = PayIn::find()->where(['username'=>Yii::$app->user->identity->username,'complete'=>1])->sum('amount');
        return $this->render('in-history',compact('payIn','allSum'));
    }

    public function actionOutHistory()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $payOut = PayOut::find()->where(['username'=>Yii::$app->user->identity->username])->orderBy(['created_at'=>SORT_DESC])->all();
        $allSum = PayOut::find()->where(['username'=>Yii::$app->user->identity->username,'status_id'=>PayOut::STATUS_CONFIRMED])->sum('amount');
        return $this->render('out-history',compact('payOut','allSum'));
    }
}
