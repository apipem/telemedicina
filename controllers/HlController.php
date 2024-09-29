<?php

namespace app\controllers;

use app\models\Usuarios;
use app\models\Chats;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class HlController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'generate-adm', 'generate-orm', 'generate-rsp'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $patients = Usuarios::find()->where(['rol' => "Paciente"])->all();

        return $this->render('index', ['patients' => $patients]);
    }

   public function actionGenerateAdm()
   {
       // Verifica si se ha enviado una solicitud POST
       if (Yii::$app->request->isPost) {
           $patientId = Yii::$app->request->post('patientId');

           // Verifica que el ID del paciente sea válido
           if (!$patientId) {
               throw new BadRequestHttpException('ID de paciente inválido.');
           }

           // Aquí deberías obtener los datos del paciente desde la base de datos
           $patient = Usuarios::findOne($patientId);

           // Si el paciente no se encuentra, puedes manejar el error
           if (!$patient) {
               throw new NotFoundHttpException('Paciente no encontrado.');
           }

           $message = $this->createAdtMessage($patient);
           return $this->render('hl7_message', ['message' => $message]);
       } else {
           throw new BadRequestHttpException('Solicitud no válida.');
       }
   }



    public function actionGenerateOrm($orderDetails)
    {
        // Aquí deberías construir el mensaje ORM basado en los detalles de la orden
        $message = $this->createOrmMessage($orderDetails);
        return $this->render('hl7_message', ['message' => $message]);
    }

    public function actionGenerateRsp($patientId)
    {
        // Aquí deberías obtener los datos del paciente
        $patient = Usuarios::findOne($patientId);
        $message = $this->createRspMessage($patient);
        return $this->render('hl7_message', ['message' => $message]);
    }

    private function createAdtMessage($patient)
    {
        $msg = "MSH|^~\\&|HOSPITAL|SENDER|HOSPITAL|RECEIVER|".date('YmdHis')."||ADT^A01|".uniqid()."|P|2.5\n";
        $msg .= "EVN|A01|".date('YmdHis')."\n";
        $msg .= "PID|1||{$patient->documento}^^^HOSPITAL|".strtoupper($patient->nombre_completo)."||{$patient->fecha_nacimiento}|{$patient->genero}|||{$patient->direccion}^^{$patient->Ciudad}\n";
        return $msg;
    }

    private function createOrmMessage($orderDetails)
    {
        $msg = "MSH|^~\\&|HOSPITAL|SENDER|LAB|RECEIVER|".date('YmdHis')."||ORM^O01|".uniqid()."|P|2.5\n";
        // Suponiendo que $orderDetails es un array con información de la orden
        $msg .= "PID|1||{$orderDetails['patient_id']}^^^HOSPITAL|".strtoupper($orderDetails['patient_name'])."||{$orderDetails['dob']}|{$orderDetails['gender']}|||{$orderDetails['address']}^^{$orderDetails['city']}^CA^90210\n";
        $msg .= "ORC|NW|{$orderDetails['order_id']}|{$orderDetails['order_id']}||CM|1|".date('YmdHis')."|||^^^Dr. {$orderDetails['doctor_name']}\n";
        $msg .= "OBR|1|{$orderDetails['order_id']}|{$orderDetails['test_id']}|{$orderDetails['test_name']}^L|||".date('YmdHis')."\n";
        return $msg;
    }

    private function createRspMessage($patient)
    {
        $msg = "MSH|^~\\&|HOSPITAL|SENDER|RECEIVER|HOSPITAL|".date('YmdHis')."||RSP^K11|".uniqid()."|P|2.5\n";
        $msg .= "PID|1||{$patient->documento}^^^HOSPITAL|".strtoupper($patient->nombre_completo)."||{$patient->fecha_nacimiento}|{$patient->genero}|||{$patient->direccion}^^{$patient->Ciudad}^CA^90210\n";
        return $msg;
    }
}
