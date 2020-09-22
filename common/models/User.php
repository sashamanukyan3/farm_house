<?php

namespace common\models;

use Yii;
use yii\base\ErrorException;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $first_name
 * @property string $last_name
 * @property integer $sex
 * @property string $birthday
 * @property string $city
 * @property string $country
 * @property string $about
 * @property string $photo
 * @property integer $level
 * @property integer $for_pay
 * @property integer $for_out
 * @property integer $pay_pass
 * @property integer $experience
 * @property integer $energy
 * @property string $phone
 * @property integer $chat_status
 * @property integer $chat_music
 * @property integer $ref_id
 * @property string $ref_for_out
 * @property string $refLink
 * @property integer $is_subscribed
 * @property integer $banned
 * @property string $banned_text
 * @property integer $need_experience
 * @property integer $signup_date
 * @property integer $login_date
 * @property string $signup_ip
 * @property string $last_ip
 * @property integer $first_login
 * @property string $outed
 * @property string $location
 * @property integer $last_visited
 *
 * @property Friends[] $friends
 * @property WallComments[] $wallComments
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED    = 0;
    const STATUS_ACTIVE     = 10;

    const SEX_MALE          = 1;
    const SEX_FEMALE        = 0;
    const SEX_MALE_IMG      = 'man1.png';
    const SEX_FEMALE_IMG    = 'woman1.png';
    const ROLE_ADMIN        = 1;
    const ROLE_MANAGER      = 2;
    const ROLE_USER         = 3;

    public $to;
    public $from;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['email'], 'required'],
            //[['signup_date', 'login_date', 'role', 'created_at', 'updated_at', 'level', 'pay_pass', 'experience', 'energy', 'chat_status', 'ref_id', 'need_experience', 'last_visited'], 'integer'],
            //[[ 'sex', 'chat_music', 'is_subscribed', 'banned', 'first_login'], 'boolean'],
            //[['about', 'banned_text'], 'string'],
            //[['for_pay', 'for_out', 'ref_for_out', 'outed'], 'number'],
            //[['birthday', 'username', 'password_hash', 'password_reset_token', 'email', 'first_name', 'last_name', 'city', 'country', 'photo', 'phone', 'refLink', 'signup_ip', 'last_ip', 'location'], 'string', 'max' => 255],
            //[['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            ['email', 'email'],
            //['status', 'default', 'value' => self::STATUS_ACTIVE],
            //['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['password_reset_token'], 'unique'],
            [['username', 'email', 'first_name', 'last_name', 'city', 'country', 'about', 'phone'], 'filter', 'filter' => function($value) {
                return trim(htmlentities(strip_tags($value), ENT_QUOTES, 'UTF-8'));
            }],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @param int $type
     * @return static|null
     */
    public static function findByUsername($username, $type)
    {
        try{
            $query = static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
            if($type == 1)
            {
                if($username == $query->username){
                    // return $query;
                    return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
                }
            }
            elseif($type == 2)
            {
                if($username == $query->username and $query->role == self::ROLE_ADMIN or $query->role == self::ROLE_MANAGER){
                    //return $query;
                    return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
                }
            }
        }
        catch(ErrorException $e){
        }
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'E-mail',
            'status' => 'Статус',
            'role' => 'Роль',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'sex' => 'Пол',
            'birthday' => 'День рождения',
            'city' => 'Город',
            'country' => 'Страна',
            'about' => 'Обо мне',
            'photo' => 'Фото',
            'level' => 'Уровень',
            'for_pay' => 'Баланс для оплаты',
            'for_out' => 'Баланс для вывода',
            'pay_pass' => 'Pay Pass',
            'experience' => 'Опыт',
            'energy' => 'Энергия',
            'phone' => 'Телефон',
            'chat_status' => 'Статус в чате',
            'chat_music' => 'Звук в чате',
            'ref_id' => 'ID реферала',
            'ref_for_out' => 'Баланс для реферала',
            'refLink' => 'Ссылка откуда пришел',
            'is_subscribed' => 'Подписка на рассылку',
            'banned' => 'Забанен',
            'banned_text' => 'Причина бана',
            'need_experience' => 'Необходимый опыт для соедующего уровня',
            'signup_date' => 'Время регистрации',
            'login_date' => 'Время посещения',
            'signup_ip' => 'IP при регистрации',
            'last_ip' => 'IP последней авторизации',
            'first_login' => 'First Login',
            'outed' => 'Выведенный баланс',
            'location' => 'Страница посещения',
            'last_visited' => 'Последняя авторизация',
        ];
    }
    public function getImage()
    {
        $image =  ($this->photo) ? $this->photo : 'profile.jpg';
        return Yii::getAlias('@frontendWebroot/avatar').'/'.$image;
    }

    public function getImagePath()
    {
        $image =  ($this->photo) ? $this->photo : 'profile.jpg';
        return '@frontend/web/avatar/'.$image;
    }

    public function getBirthday($birthday){
        if(!is_null($birthday))
        {
            $birthdayExplode = explode("-", $birthday);
            $day    = $birthdayExplode[2];
            $month  = $birthdayExplode[1];
            $year   = $birthdayExplode[0];

            switch ($month){
                case 1: $clean_m = ' январь '; break;
                case 2: $clean_m = ' февраль '; break;
                case 3: $clean_m = ' март '; break;
                case 4: $clean_m = ' апрель '; break;
                case 5: $clean_m = ' май '; break;
                case 6: $clean_m = ' июнь '; break;
                case 7: $clean_m = ' июль '; break;
                case 8: $clean_m = ' август '; break;
                case 9: $clean_m = ' сентябрь '; break;
                case 10: $clean_m = ' октябрь '; break;
                case 11: $clean_m = ' ноябрь '; break;
                case 12: $clean_m = ' декабрь '; break;
                default: $clean_m = '';
            }

            return $day . $clean_m . $year;
        }
        else
        {
            return '';
        }


    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * @param $level
     * @return integer
     */
    public function getNeedExperienceByLvl()
    {
        $needExperience = 0;
        //set next need_experience
        if($this->level > 1 && $this->level < 21)
        {
            if($this->level < 4)
            {
                switch($this->level) {
                    case 2:
                        $needExperience = 40;
                        break;
                    case 3:
                        $needExperience = 80;
                        break;
                }
            }
            else
            {
                $needExperience = $this->need_experience += 100;
            }
        }
        elseif($this->level >= 21 && $this->level < 31)
        {
            $needExperience = $this->need_experience += 200;
        }
        elseif($this->level >= 31 && $this->level < 41)
        {
            $needExperience = $this->need_experience += 300;
        }
        elseif($this->level >= 41 && $this->level < 51)
        {
            $needExperience = $this->need_experience += 400;
        }
        elseif($this->level >= 51 && $this->level < 61)
        {
            $needExperience = $this->need_experience += 500;
        }
        elseif($this->level >= 61 && $this->level < 71)
        {
            $needExperience = $this->need_experience += 600;
        }
        elseif($this->level >= 71 && $this->level < 81)
        {
            $needExperience = $this->need_experience += 700;
        }
        elseif($this->level >=81 && $this->level < 91)
        {
            $needExperience = $this->need_experience += 800;
        }
        elseif($this->level >=91 && $this->level < 101)
        {
            $needExperience = $this->need_experience += 900;
        }
        elseif($this->level >= 101)
        {
            $needExperience = $this->need_experience += 1000;
        }

        return $needExperience;
    }

    /**
     * @param integer $takedExperience
     * @return boolean
     */
    public function isLevelUp($takedExperience)
    {
        //получаем весь опыт
        $allExpr = $takedExperience + $this->experience;
        // если весь опыт меньше нужного для след. уров. то
        if($allExpr < $this->need_experience)
        {
            $this->experience = $allExpr;
            $this->save();
            return false;
        }
        else
        {
            // игрок перешел на новыи уровень. По "Опыту" нужно выяснить на какои именно
            $need = $this->need_experience;
            while($allExpr >= $need){
                $this->level += 1;
                $allExpr -= $need;
                $need = $this->getNeedExperienceByLvl();
                $this->need_experience = $need;
            }
            $this->experience = $allExpr;
            $this->save();
            return $this->level;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFriends()
    {
        return $this->hasMany(Friends::className(), ['to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWallComments()
    {
        return $this->hasMany(WallComments::className(), ['user_id' => 'id']);
    }
}