<?php

namespace app\controllers;

use app\models\Usuarios;
use app\models\ArchivosSubidos;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SubidaController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new ArchivosSubidos();

        // Obtener usuarios según el rol del usuario
        $users = Usuarios::find();
        $archivos = ArchivosSubidos::find();
        $archivosre = ArchivosSubidos::find();

        // Filtrar según el rol del usuario
        if (Yii::$app->user->identity->rol == "Paciente") {
            $users->where(['rol' => "Medico"]);
            $archivos->where(['paciente' => Yii::$app->user->id]) ;
            $archivosre->where(['medico' => Yii::$app->user->id]) ;
        } elseif (Yii::$app->user->identity->rol == "Medico") {
            $users->where(['rol' => "Paciente"]);
            $archivos->where(['paciente' => Yii::$app->user->id]) ;
            $archivosre->where(['medico' => Yii::$app->user->id]) ;
        }

        // Obtener usuarios y convertir a un array
        $usersArray = $users->select(['id', 'nombre_completo'])->asArray()->all();
        $users = \yii\helpers\ArrayHelper::map($usersArray, 'id', 'nombre_completo');

        // Obtener archivos subidos por el usuario actual


         $archivos = $archivos->all();
         $archivosre = $archivosre->all();

        return $this->render('index', [
            'model' => $model,
            'users' => $users,
            'archivos' => $archivos,
            'archivosre' => $archivosre,
        ]);
    }




   public function actionUpload()
   {
       $pacienteId = Yii::$app->user->id; // Get the patient's ID
       $medicoId = Yii::$app->request->post('ArchivosSubidos')['medico']; // Get the doctor's ID from the posted data
       $description = Yii::$app->request->post('ArchivosSubidos')['description'] ?? ''; // Get description or default to empty string

       // Ensure the input name matches what's in the form
       $files = UploadedFile::getInstancesByName('ArchivosSubidos[ruta_archivo]');

       if ($files) {
           $success = true;
           $messages = [];

           foreach ($files as $file) {
               $filePath = 'uploads/' . $file->baseName . '.' . $file->extension;

               if ($file->saveAs($filePath)) {
                   // Save the record in the database
                   $archivo = new ArchivosSubidos();
                   $archivo->paciente = $pacienteId;
                   $archivo->medico = $medicoId;
                   $archivo->ruta_archivo = $filePath;
                   $archivo->descripcion = $description; // Use the description safely

                   if (!$archivo->save()) {
                       $success = false;
                       $errorMessages = [];
                       foreach ($archivo->getErrors() as $errors) {
                           $errorMessages = array_merge($errorMessages, $errors);
                       }
                       $messages[] = 'No se pudo guardar en la base de datos: ' . implode(', ', $errorMessages);
                   }
               } else {
                   $success = false;
                   $messages[] = 'No se pudo guardar el archivo: ' . $file->baseName;
               }
           }

           if ($success) {
               return $this->asJson(['success' => true, 'message' => 'Los archivos han sido subidos exitosamente.']);
           } else {
               return $this->asJson(['success' => false, 'message' => implode(', ', $messages)]);
           }
       }

       return $this->asJson(['success' => false, 'message' => 'No se encontraron archivos para subir.']);
   }

}
