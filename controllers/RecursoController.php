<?php

namespace app\controllers;

use app\models\Usuarios;
use app\models\Disponible;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response; 


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
                    'actions' => ['estado','listprofesores','activate', 'deactivate'],
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
            $disponible = new Disponible();
            $disponible->usuarios_id = $p->id;
            if ($disponible->save()) {
                return "ok";
            }else {
                // Manejo de errores
                foreach ($message->getErrors() as $error) {
                    echo implode(', ', $error) . '<br>';
                }
            }
        } else {
             // Manejo de errores
             foreach ($message->getErrors() as $error) {
                 echo implode(', ', $error) . '<br>';
             }
         }

    }

    public function actionEstado(){
        Yii::$app->response->format = Response::FORMAT_JSON;

        $disponibilidad = Yii::$app->request->post('disponibilidad');

        // Actualiza la disponibilidad del médico
        $medico = Yii::$app->user->identity; // Suponiendo que el usuario es un médico

        if ($medico) {
            $medico->disponible = $disponibilidad; // Asigna el nuevo estado

            if ($medico->save()) {
                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'Error al guardar la disponibilidad.'];
            }
        }

        return ['success' => false, 'message' => 'Médico no encontrado.'];
    }

    public function actionActivate()
        {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $userId = Yii::$app->request->post('id');
            $user = Usuarios::findOne($userId);

            if ($user) {
                $user->estado = 1;
                if ($user->save()) {
                    return ['success' => true, 'message' => 'Usuario activado con éxito.'];
                }
                return ['success' => false, 'message' => 'No se pudo activar el usuario.'];
            }

            return ['success' => false, 'message' => 'Usuario no encontrado.'];
        }

        public function actionDeactivate()
        {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $userId = Yii::$app->request->post('id');
            $user = Usuarios::findOne($userId);

            if ($user) {
                $user->estado = 0;
                if ($user->save()) {
                    return ['success' => true, 'message' => 'Usuario desactivado con éxito.'];
                }
                return ['success' => false, 'message' => 'No se pudo desactivar el usuario.'];
            }

            return ['success' => false, 'message' => 'Usuario no encontrado.'];
        }

}
