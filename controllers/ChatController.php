<?php

namespace app\controllers;

use app\models\Usuarios;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class ChatController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return ['access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['index','chat'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $medicos = Usuarios::find() ->where(['rol' => 'Medico'])
                                       ->andWhere(['estado' => '1'])
                                       //->andWhere(['condition2' => 'value2'])
                                       ->all();
         return $this->render('index', [
                'medicos' => $medicos,
                'chat' => 0,
            ]);

    }

    public function actionChat($chat)
    {
        // Desencriptar el ID
        $id = Yii::$app->security->decryptByKey($chat, 'tele');

        // Ahora puedes usar $id para buscar el médico o realizar otras acciones
        $medico = Usuarios::findOne($id);

        return $this->render('chat');
    }

}
