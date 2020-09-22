<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15.02.2016
 * Time: 14:40
 */

namespace common\models;
use Yii;

class Settings
{
    /**
     * Количество отзывов на странице
     * @var int
     */
    public static $pagerReviews = 10;

    /**
     * Необходимая энергия для лайка дизлайка
     * @var int
     */
    public static $likeDislike = 1;

    /**
     * Необходимая энергия для комментария к новостям
     * @var int
     */
    public static $energyCommentForNews = 1;

    /**
     * Уровень для отзыва
     * @var int
     */
    public static $levelReviews = 4;

    /**
     * - энергия за бонус
     * @var int
     */
    public static $bonusEnergy = 2;

    /**
     * Получение бонуса
     * @var float
     */
    public static $bonusAdd = 0.03;

    /**
     * Текст приветствия
     * @param $username
     * @return string
     */
    public static function getWelcomeText($username)
    {
        return Yii::t('app', 'settingsWelcomeText', [
            'username' => $username,
        ]);
    }

    /**
     * Текст на странице ТП
     * @var string
     */
    public static $supportText = ', Уважаемые пользователи проекта ferma.ru!.'.
                        'Для решения возникающих у Вас проблем и вопросов, касающихся проекта ferma.ru, воспользуйтесь системой тикетов нашего сайта <br>'.
                        'Внимание! Прежде чем задать вопрос администрации ferma.ru, пожалуйста, убедитесь в том, что на общедоступных страницах сайта нет на него ответа. Если Ваш вопрос некорректный или ответ на него имеется на страницах проекта, Ваш тикет будет закрыт без предупреждения! Берегите своё время и время администрации сайта.<br>'.
                        'Помните! Чем точнее и полнее Вы изложите суть своей проблемы или вопроса, тем быстрее и точнее Вы получите ответ!<br>'.
                        'С уважением, Администрация ferma.ru.<br>';

    public static function chatRules()
    {
        return Yii::t('app', 'chatRules');
    }

    /**Пользовательское соглашение
     * @var string
     */
    public static $tos = '';

    public static function bonusDisabled()
    {
        return Yii::t('app', 'bonusDisabled');
    }

    /**
     * Текст на странице биржы опыта
     * @param $alias
     * @return string
     */
    public static function getExchangeText($alias)
    {
        switch($alias)
        {
            case 'egg': $product = Yii::t('app', 'яйца'); break;
            case 'meat': $product = Yii::t('app', 'мясо'); break;
            case 'goat_milk': $product = Yii::t('app', 'козье молоко'); break;
            case 'cow_milk': $product = Yii::t('app', 'коровье молоко'); break;
            case 'dough': $product = Yii::t('app', 'тесто'); break;
            case 'mince': $product = Yii::t('app', 'фарш'); break;
            case 'cheese': $product = Yii::t('app', 'сыр'); break;
            case 'curd': $product = Yii::t('app', 'творог'); break;
        }

        return Yii::t('app', 'exchangeText', [
            'productName' => $product,
        ]);
    }

    public static function payExchangerText()
    {
        return Yii::t('app', 'payExchangerText');
    }
    
    public static function payTransferText()
    {
        return Yii::t('app', 'payTransferText');
    }

    /**
     * Процент комиссии за перевод средств
     * @var int
     */
    public static $transferProcent = 5;

    public static function bonusMessage()
    {
        return Yii::t('app', 'bonusMessage');
    }

    public static function bonusEnergyMsg()
    {
        return Yii::t('app', 'bonusEnergyMsg');
    }

    public static function bonusMsg()
    {
        return Yii::t('app', 'bonusMsg');
    }

    /**
     * Недостаточно уровня!
     * @var $wallLevelControl
     */
    public static $wallLevelControl = 3;

    /**
     * Недостаточно энергии!
     * @var $wallEnergyControl
     */
    public static $wallEnergyControl = 9;

    /**
     * энергии -10!
     * @var $wallEnergyRemove
     */
    public static $wallEnergyRemove = -10;

    /**
     * Недостаточно энергии!
     * @var $wallLikeEnergyControl
     */
    public static $wallLikeEnergyControl = 9;

    /**
     * Стена нравится -10 энергии
     * @var $wallLikeEnergyRemove
     */
    public static $wallLikeEnergyRemove = -10;

    /**
     * Недостаточно энергии!
     * @var $wallLikeEnergyRemove
     */
    public static $giftEnergyControl = 49;

    /**
     * Подарки энергии -50!
     * @var $wallLikeEnergyRemove
     */
    public static $giftEnergyRemove = -50;

    /**
     * 50!
     * @var $giftEnergyText
     */
    public static $giftEnergyText = 50;

    /**
     * Недостаточно уровня!
     * @var $wallLikeEnergyRemove
     */
    public static $commentLevelControl = 3;

    /**
     * Недостаточно энергии!
     * @var $wallLikeEnergyRemove
     */
    public static $commentEnergyControl = 9;

    /**
     * Комментарий энергии -10!
     * @var $wallLikeEnergyRemove
     */
    public static $commentEnergyRemove = -10;

    /**
     * Стена уровня контроль
     * @var $wallLikeEnergyRemove
     */
    public static $wallLevel = 2;

    /**
     * Новости уровня контроль
     * @var $wallLikeEnergyRemove
     */
    public static $newsViewLevel = 2;

    /**
     * Gift post level
     * @var $giftLevel
     */
    public static $giftLevel = 2;

    /**
     * Установка место
     */
    public static function setLocation($location)
    {
        if(Yii::$app->user->isGuest){

            $sessionControl = Session::find()->where(['session_id' => Yii::$app->getSession()->getId()])->all();
            if($sessionControl){
                Yii::$app->db->createCommand()->update('session', ['time' => time(), 'location' => $location], ['session_id' => Yii::$app->getSession()->getId()])->execute();
            }else{
                Yii::$app->db->createCommand()->insert('session', ['time' => time(), 'location' => $location, 'session_id' => Yii::$app->getSession()->getId()])->execute();
            }

        }else{

            $sessionControl = Session::find()->where(['username' => Yii::$app->user->identity->username])->all();
            if($sessionControl){
                Yii::$app->db->createCommand()->update('session', ['time' => time(), 'session_id' => Yii::$app->getSession()->getId(), 'location' => $location], ['username' => Yii::$app->user->identity->username])->execute();
            }else{
                Yii::$app->db->createCommand()->insert('session', ['time' => time(), 'location' => $location, 'session_id' => Yii::$app->getSession()->getId(), 'username' => Yii::$app->user->identity->username])->execute();
            }

        }
    }

    /**
     * Необходимая энергия для запуска фабрик
     * @param $energyForRunFactory
     */
    public static $energyForRunFactory = 500;

    /**
     * Необходимая энергия для запуска пекарний
     * @param $energyForRunBakery
     */
    public static $energyForRunMeatBakery = 1100;
    public static $energyForRunCheeseBakery = 1300;
    public static $energyForRunCurdBakery = 1300;

    /**
     * Необходимая энергия для сбора продукции с фабрик
     * @param $energyForGetProductFactory
     */
    public static $energyForGetProductFactory = 500;

    /**
     * Необходимое количество яиц для запуска фабрики теста
     * @param $countEggForRunFactoryDough
     */
    public static $countEggForRunFactoryDough = 300;

    /**
     * Необходимое количество мясо для запуска фабрики фарша
     * @param $countMeatForRunFactoryMince
     */
    public static $countMeatForRunFactoryMince = 300;

    /**
     * Необходимое количество молока козы для запуска фабрики сыра
     * @param $countGoatMilkForRunFactoryMince
     */
    public static $countGoatMilkForRunFactoryCheese = 300;

    /**
     * Необходимое количество молока коровы для запуска фабрики творога
     * @param $countCowMilkForRunFactoryMince
     */
    public static $countCowMilkForRunFactoryCurd = 300;

    /**
     * Количество получаемой продукции с фабрики теста
     * @param $countDough
     */
    public static $countDough = 200;

    /**
     * Количество получаемой продукции с фабрики фарша
     * @param $countMince
     */
    public static $countMince = 200;

    /**
     * Количество получаемой продукции с фабрики сыра
     * @param $countCheese
     */
    public static $countCheese = 200;

    /**
     * Количество получаемой продукции с фабрики творога
     * @param $countCurd
     */
    public static $countCurd = 200;

    /**
     * Количество сборов продукции с фабрик
     * @param $countCollectProductFactory
     */
    public static $countCollectProductFactory = 365; //со всех фабрик одинаково

    /**
     * Количество сборов продукции с пекарний
     * @param $countCollectProductFactory
     */
    public static $countCollectProductBakery = 365; //со всех пекарний одинаково

    /**
     * Необходимое количество теста для запуска пекарний
     * @param $countDoughForRunBakery
     */
    public static $countDoughForRunBakery = 70;

    /**
     * Необходимое количество фарша для запуска пекарний
     * @param $countMinceForRunBakery
     */
    public static $countMinceForRunBakery = 200;

    /**
     * Необходимое количество сыра для запуска пекарний
     * @param $countCheeseForRunBakery
     */
    public static $countCheeseForRunBakery = 200;

    /**
     * Необходимое количество творога для запуска пекарний
     * @param $countCurdForRunBakery
     */
    public static $countCurdForRunBakery = 200;

    /**
     * Количество получаемой продукции с пекарни пирога с мясом
     * @param $countCakeWithMeat
     */
    public static $countCakeWithMeat = 200;

    /**
     * Количество получаемой продукции с пекарни пирога с сыром
     * @param $countCakeWithCheese
     */
    public static $countCakeWithCheese = 200;

    /**
     * Количество получаемой продукции с пекарни пирога с творогом
     * @param $countCakeWithCurd
     */
    public static $countCakeWithCurd = 200;

    /**
     * Количество энергии потребляемой при кормлении куры
     * @param $countEnergyForFeedChicken
     */
    public static $countEnergyForFeedChicken = 5;
    
    public static $countEnergyForAutoFeedChicken = 5;

    public static $countEnergyForGetEggChicken = 5;

    public static $countEnergyForAutoGetEggChicken = 6;

    /**
     * Количество энергии потребляемой при кормлении бычков
     * @param $countEnergyForFeedChicken
     */
    public static $countEnergyForFeedBull = 6;

    public static $countEnergyForAutoFeedBull = 7;

    public static $countEnergyForGetMeat = 10;

    public static $countEnergyForAutoGetMeatBull = 11;


    /**
     * Количество энергии потребляемой при кормлении бычков
     * @param $countEnergyForFeedChicken
     */
    public static $countEnergyForFeedGoat = 7;

    public static $countEnergyForAutoFeedGoat = 8;

    public static $countEnergyForGetMilkGoat = 16;

    public static $countEnergyForAutoGetMilkGoat = 17;

    /**
     * Количество энергии потребляемой при кормлении бычков
     * @param $countEnergyForFeedChicken
     */
    public static $countEnergyForFeedCow = 10;

    public static $countEnergyForAutoFeedCow = 11;

    public static $countEnergyForGetMilkCow = 22;

    public static $countEnergyForAutoGetMilkCow = 23;

    /**
     * Опыты за сбор
     */
    public static $countExpGetEgg = 2;
    public static $countExpGetMeat= 2;
    public static $countExpGetGMilk = 2;
    public static $countExpGetCMilk = 2;

}