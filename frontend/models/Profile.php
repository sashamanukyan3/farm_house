<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use vova07\fileapi\behaviors\UploadBehavior;


/**
 * ContactForm is the model behind the contact form.
 */
class Profile extends Model
{
    public $username;
    public $email;
    public $first_name;
    public $last_name;
    public $country;
    public $city;
    public $about;
    public $phone;
    public $birthday;
    public $photo;
    public $sex;
    public $content;
    public $image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['username', 'email', 'first_name', 'last_name', 'country', 'city', 'about', 'phone', 'photo'], 'string' ],
            [['sex'], 'integer'],

            [['email', 'first_name', 'last_name', 'birthday'], 'required' ],

            // email has to be a valid email address
            ['email', 'email'],
            [['birthday'], 'date', 'format' => 'yyyy-m-dd'],
            [['birthday'], 'safe'],
            [['username', 'email', 'first_name', 'last_name', 'city', 'country', 'about', 'phone'], 'filter', 'filter' => function($value) {
                return trim(htmlentities(strip_tags($value), ENT_QUOTES, 'UTF-8'));
            }],

        ];
    }

    public function changeProfile()
    {
        if ($this->validate()) {
            $user = User::findOne(Yii::$app->user->id);

            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->email = $this->email;
            $user->country = $this->country;
            $user->city = $this->city;
            $user->about = $this->about;
            $user->phone = $this->phone;
            $user->birthday = $this->birthday;
            $user->sex = $this->sex;

            if($this->photo) {
                $user->photo = $this->photo;
            }

            $user = $user->save();
            return $user;
        }
        return null;
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'username'),
            'email' => Yii::t('app', 'email'),
        ];
    }

    public function behaviors()
    {
        return [
            'uploadBehavior' => [
                'class' => UploadBehavior::className(),
                'attributes' => [
                    'photo' => [
                        'path' => '@frontend/web/avatars',
                        'tempPath' => '@frontend/web/avatars',
                        'url' => '@frontend/web/avatars'
                    ],
                ]
            ],
        ];

    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

}
