<?php

namespace frontend\models;

use yii\base\Model;

/**
 * ObjectSearch represents the model behind the search form about `common\models\Object`.
 */
class Search extends Model
{
    public $query;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['query'], 'string'],
            [['query'], 'required'],
            ['query', 'filter', 'filter' => 'strip_tags'],
        ];
    }

}
