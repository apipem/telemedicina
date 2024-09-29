<?php

namespace app\controllers;

use app\models\Usuarios;
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
        if (Yii::$app->request->isPost) {
            $patientId = Yii::$app->request->post('patientId');

            if (!$patientId) {
                throw new BadRequestHttpException('ID de paciente inválido.');
            }

            $patient = Usuarios::findOne($patientId);
            if (!$patient) {
                throw new NotFoundHttpException('Paciente no encontrado.');
            }

            $message = $this->createAdtMessage($patient);
            return $this->render('hl7_message', ['message' => $message]);
        } else {
            throw new BadRequestHttpException('Solicitud no válida.');
        }
    }

    public function actionGenerateOrm()
    {
        if (Yii::$app->request->isPost) {
            $patientId = Yii::$app->request->post('patientId');
            $orderId = Yii::$app->request->post('orderId');
            $doctorName = Yii::$app->request->post('doctorName');
            $testName = Yii::$app->request->post('testName');

            if (!$patientId || !$orderId || !$doctorName || !$testName) {
                throw new BadRequestHttpException('Faltan datos necesarios para generar el mensaje ORM.');
            }

            $patient = Usuarios::findOne($patientId);
            if (!$patient) {
                throw new NotFoundHttpException('Paciente no encontrado.');
            }

            $orderDetails = [
                'patient_id' => $patient->documento,
                'patient_name' => $patient->nombre_completo,
                'dob' => $patient->fecha_nacimiento,
                'gender' => $patient->genero,
                'address' => $patient->direccion,
                'city' => $patient->Ciudad,
                'order_id' => $orderId,
                'doctor_name' => $doctorName,
                'test_name' => $testName,
            ];

            $message = $this->createOrmMessage($orderDetails);
            return $this->render('hl7_message', ['message' => $message]);
        } else {
            throw new BadRequestHttpException('Solicitud no válida.');
        }
    }

    public function actionGenerateRsp()
    {
        if (Yii::$app->request->isPost) {
            $patientId = Yii::$app->request->post('patientId');

            if (!$patientId) {
                throw new BadRequestHttpException('ID de paciente inválido.');
            }

            $patient = Usuarios::findOne($patientId);
            if (!$patient) {
                throw new NotFoundHttpException('Paciente no encontrado.');
            }

            $message = $this->createRspMessage($patient);
            return $this->render('hl7_message', ['message' => $message]);
        } else {
            throw new BadRequestHttpException('Solicitud no válida.');
        }
    }

    // Generar mensaje HL7 ADT
    public function createAdtMessage($patient)
    {

        // Construcción del mensaje
        $msg = "MSH|^~\\&|HOSPITAL|SENDER|HOSPITAL|RECEIVER|".date('YmdHis')."||ADT^A01|".uniqid()."|P|2.5\n";
        $msg .= "EVN|A01|".date('YmdHis')."\n";
        $documento = !empty($patient->documento) ? str_replace(' ', '^', $patient->documento) : 'N/A';
        $nombreCompleto = !empty($patient->nombre_completo) ? strtoupper(str_replace(' ', '^', $patient->nombre_completo)) : 'N/A';
        $fechaNacimiento = !empty($patient->fecha_nacimiento) ? str_replace(' ', '^', $patient->fecha_nacimiento) : 'N/A';
        $genero = !empty($patient->genero) ? str_replace(' ', '^', $patient->genero) : 'N/A';
        $direccion = !empty($patient->direccion) ? str_replace(' ', '^', $patient->direccion) : 'N/A';
        $ciudad = !empty($patient->Ciudad) ? str_replace(' ', '^', $patient->Ciudad) : 'N/A';

        $msg .= "PID|1||$documento^^^HOSPITAL|$nombreCompleto||$fechaNacimiento|$genero||$direccion^^$ciudad^CA^90210\n";


        // Agregar segmento PV1 (Patient Visit)

        return $msg;
    }


    private function createOrmMessage($orderDetails)
    {
        $msg = "MSH|^~\\&|HOSPITAL|SENDER|LAB|RECEIVER|".date('YmdHis')."||ORM^O01|".uniqid()."|P|2.5\n";
       $patientId = !empty($orderDetails['patient_id']) ? str_replace(' ', '^', $orderDetails['patient_id']) : 'N/A';
       $patientName = !empty($orderDetails['patient_name']) ? strtoupper(str_replace(' ', '^', $orderDetails['patient_name'])) : 'N/A';
       $dob = !empty($orderDetails['dob']) ? str_replace(' ', '^', $orderDetails['dob']) : 'N/A';
       $gender = !empty($orderDetails['gender']) ? str_replace(' ', '^', $orderDetails['gender']) : 'N/A';
       $address = !empty($orderDetails['address']) ? str_replace(' ', '^', $orderDetails['address']) : 'N/A';
       $city = !empty($orderDetails['city']) ? str_replace(' ', '^', $orderDetails['city']) : 'N/A';

       $msg .= "PID|1||$patientId^^^HOSPITAL|$patientName||$dob|$gender||$address^^$city^CA^90210\n";


        $msg .= "ORC|NW|{$orderDetails['order_id']}|{$orderDetails['order_id']}||CM|1|".date('YmdHis')."|||^^^Dr. {$orderDetails['doctor_name']}\n";
        $msg .= "OBR|1|{$orderDetails['order_id']}|{$orderDetails['order_id']}|{$orderDetails['test_name']}^L|||".date('YmdHis')."\n";
        return $msg;
    }

    private function createRspMessage($patient)
    {
        $msg = "MSH|^~\\&|HOSPITAL|SENDER|RECEIVER|HOSPITAL|".date('YmdHis')."||RSP^K11|".uniqid()."|P|2.5\n";
        $documento = !empty($patient->documento) ? str_replace(' ', '^', $patient->documento) : 'N/A';
        $nombreCompleto = !empty($patient->nombre_completo) ? strtoupper(str_replace(' ', '^', $patient->nombre_completo)) : 'N/A';
        $fechaNacimiento = !empty($patient->fecha_nacimiento) ? str_replace(' ', '^', $patient->fecha_nacimiento) : 'N/A';
        $genero = !empty($patient->genero) ? str_replace(' ', '^', $patient->genero) : 'N/A';
        $direccion = !empty($patient->direccion) ? str_replace(' ', '^', $patient->direccion) : 'N/A';
        $ciudad = !empty($patient->Ciudad) ? str_replace(' ', '^', $patient->Ciudad) : 'N/A';

        $msg .= "PID|1||$documento^^^HOSPITAL|$nombreCompleto||$fechaNacimiento|$genero||$direccion^^$ciudad^CA^90210\n";


        return $msg;
    }
}
