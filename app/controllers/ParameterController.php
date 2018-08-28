<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\actions\IndexAction;
use yii\data\ActiveDataProvider;
use app\models\Parameter;
use app\actions\CreateAction;
use app\actions\UpdateAction;


class ParameterController extends Controller { 
    
    public function actions()
    {
        return [
            'parameter-list' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    $dataProvider = new ActiveDataProvider([
                        'query' => Parameter::find(),
                        'sort' => ['defaultOrder' => [
                            'type' => SORT_ASC,
                            'sort_p' => SORT_ASC,
                            'code' => SORT_ASC,
                        ]],
                    ]);
                    return [
                        'dataProvider' => $dataProvider,
                    ];
                }
            ],
            'parameter-create' => [
                'class' => CreateAction::className(),
                'modelClass' => Parameter::className(),
                'successRedirect'=>'parameter-list',
                'ajax'=>true,
            ],
            'parameter-update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Parameter::className(),
                'successRedirect'=>Yii::$app->request->referrer,
                'ajax'=>true,
            ],

        ];
    }
    
    public function actionParameterDelete($type,$code)
    {
        $model = Parameter::findOne(['type'=>$type,'code'=>$code]);
        $stat='error';
        if ($model !== null) {         
            if($model->delete()){
                $stat='success';
            }else{
                $stat='fail';
            }
        }        
        return json_encode(['stat' => $stat]);
    }
    
}
