<?php

namespace app\controllers;

use app\models\Usuarios;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Chats;
use app\models\MensajesChat;


class CorreoController extends Controller
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
                    'actions' => ['index'],
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
        $user = Usuarios::find();

        // Filtrar según el rol del usuario
        if (Yii::$app->user->identity->rol == "Paciente") {
           $user =  $user->where(['rol' => 'Medico']);
        } elseif (Yii::$app->user->identity->rol == "Medico") {
            $user =  $user->where(['rol' => 'Paciente']);
        }

        $user =  $user->andWhere(['estado' => '1'])->all();

         return $this->render('index', [
                'user' => $user,
            ]);

    }

}
