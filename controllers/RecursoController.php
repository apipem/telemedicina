<?php

namespace app\controllers;

use app\models\Usuarios;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class RecursoController extends Controller
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
                    'actions' => ['persona'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['listestudiantes','listprofesores'],
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


    public function actionPersona()
    {
        $p = new Usuarios();
        $p->documento = $_GET["cc"];
        $p->tipo_documento = $_GET["td"];
        $p->nombre_completo = $_GET["name"];
        $p->rol = $_GET["user"];
        $p->correo_electronico = $_GET["email"];
        $p->contrasena = $_GET["password"];
        $p->estado = 0;

        if ($p->save()) {
            return "ok";
        } else {
            return "Error";
        }

    }

    public function actionListprofesores(){return Json::encode(Usuario::find()->where("rol = 'profesor'")->all());}


    public function actionListmaterias(){return Json::encode(Materia::find()->all());}

    public function actionListproyectos(){return Json::encode(Proyecto::find()->all());}

}
