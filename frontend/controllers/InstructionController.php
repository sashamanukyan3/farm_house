<?php


namespace frontend\controllers;


use Yii;
use yii\web\Controller;

class InstructionController extends Controller
{
    public function actionIndex() {
        $instructions = \common\models\Instruction::find()->where(['is_active' => 1])->orderBy(['weight' => SORT_ASC])->all();
        $this->view->params['breadcrumbs'] = [
            ['label' => Yii::t('app', 'Фермерский дом'), 'url' => null],
        ];
        return $this->render('index', [
            'instructions' => $instructions
        ]);
    }
}