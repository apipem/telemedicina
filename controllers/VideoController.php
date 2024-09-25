<?php

namespace app\controllers;

use app\models\Usuarios;
use app\models\Videollamadas;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class VideoController extends Controller
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
                    'actions' => ['index','video','programar','guardar'],
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
                                           ->all();

       // Inicializar la consulta de Chats
       $video = Videollamadas::find();
       $videoe = Videollamadas::find();

       // Filtrar según el rol del usuario
       if (Yii::$app->user->identity->rol == "Paciente") {
           $video->where(['id_paciente' => Yii::$app->user->identity->id]);
           $videoe->where(['id_paciente' => Yii::$app->user->identity->id]);
       } elseif (Yii::$app->user->identity->rol == "Medico") {
           $video->where(['id_medico' => Yii::$app->user->identity->id]);
           $videoe->where(['id_medico' => Yii::$app->user->identity->id]);
       }

       $video->andWhere(['estado' => 'programada']);
       $videoe->andWhere(['estado' => 'completada']);

       // Ordenar por fecha de inicio de manera descendente
       $video = $video->all();
       $videoe = $videoe->orderBy(['fecha_programada' => SORT_DESC])->all();


        return $this->render('index', [
               'medicos' => $medicos,
               'video' => $video,
               'videoe' => $videoe,
           ]);

    }
public function decryptBy($chat)
{
     // Decodificar antes de desencriptar
       $chat = urldecode($chat);

       try {
           $id = Yii::$app->security->decryptByKey($chat, 'telem');
           // Verifica si la desencriptación fue exitosa
           if ($id === false) {
               throw new \Exception("Desencriptación fallida.");
           }
       } catch (\Exception $e) {
           Yii::error("Error al desencriptar: " . $e->getMessage());
           return null; // Devuelve null en caso de error
       }

    return $id;
}


   public function actionVideo($video)
   {
       $id = $this->decryptBy($video);
       if ($id === null) {
           Yii::$app->session->setFlash('error', 'ID de video inválido.');
           return $this->redirect(['index']);
       }
   
       $chatId = Yii::$app->request->get('chatId');
       $videoQuery = Videollamadas::find();
   
       // Filtrar según el rol del usuario
       if (Yii::$app->user->identity->rol == "Paciente") {
           $videoQuery->where(['id_paciente' => Yii::$app->user->identity->id])
                      ->andWhere(['id_medico' => $id]);
       } else {
           $videoQuery->where(['id_medico' => Yii::$app->user->identity->id])
                      ->andWhere(['id_paciente' => $id]);
       }
   
       // Verificar si ya existe un chat activo
       $videoExistente = $videoQuery->andWhere(['estado' => 'programada'])->one();
   
       // Consultar un chat existente
       if ($chatId) {
           $videoParaConsultar = Videollamadas::findOne($chatId);
           if ($videoParaConsultar) {
               return $this->render('video', [
                   'persona' => Usuarios::findOne($id),
                   'video' => $videoParaConsultar,
               ]);
           }
       }
   
       // Si ya existe un chat activo, retornarlo
       if ($videoExistente) {
           return $this->render('video', [
              'persona' => Usuarios::findOne($id),
               'video' => $videoExistente,
           ]);
       }
   
      // Crear un nuevo chat si no existe uno activo
      $video = new Videollamadas();
      $video->id_paciente = Yii::$app->user->identity->id;
      $video->id_medico = $id;

      if ($video->save()) {
          return $this->render('video', [
              'persona' => Usuarios::findOne($id),
              'video' => $video, // Usar la variable correcta
          ]);
      } else {
          // Obtener errores y asegurarte de que sea un string
          $errors = $video->getErrors();
          $errorString = '';
          foreach ($errors as $field => $messages) {
              $errorString .= implode(', ', $messages) . ' '; // Combina errores por campo
          }

          Yii::$app->session->setFlash('error', 'Error al crear el video: ' . trim($errorString));
          return $this->redirect(['index']);
      }

   }

   public function actionProgramar()
   {
       if (Yii::$app->request->isAjax) {
           $meetLink = Yii::$app->request->post('meetLink');
           $fechaHora = Yii::$app->request->post('fechaHora');
           $id = Yii::$app->request->post('video');

           // Validar los datos
           if (empty($meetLink) || empty($fechaHora)) {
               return $this->asJson(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
           }

           $video = Videollamadas::findOne($id);
           if (!$video) {
               return $this->asJson(['success' => false, 'message' => 'Videollamada no encontrada.']);
           }
           $video->url_reunion = $meetLink;
           $video->fecha_programada = $fechaHora;

           // Guardar el modelo
           if ($video->save()) {
               return $this->asJson(['success' => true, 'message' => 'Videollamada programada exitosamente.']);
           } else {
               return $this->asJson(['success' => false, 'message' => 'Error al programar la videollamada: ' . implode(', ', $video->getErrors())]);
           }
       }

       throw new BadRequestHttpException('Petición no válida.');
   }

   public function actionGuardar()
   {
       if (Yii::$app->request->isAjax) {

           $videoID = Yii::$app->request->post('videoID');
           $patientID = Yii::$app->request->post('patientID');
           $patientName = Yii::$app->request->post('patientName');
           $email = Yii::$app->request->post('email');
           $address = Yii::$app->request->post('address');
           $phone = Yii::$app->request->post('phone');
           $consultaDetails = Yii::$app->request->post('consultaDetails');
           $additionalNotes = Yii::$app->request->post('additionalNotes');

           // Validar los datos
           if (empty($patientName) || empty($email) || empty($address) || empty($phone) || empty($consultaDetails)) {
               return $this->asJson(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
           }

           $video = Videollamadas::findOne($videoID);
           $user = Usuarios::findOne($patientID);
           if (!$video && !$user) {
               return $this->asJson(['success' => false, 'message' => 'Error al consultar datos.']);
           }

           $video->notas = $additionalNotes;
           $video->detalles_consulta = $consultaDetails;
           $video->estado = "completada";
           $user->correo_electronico = $email;
           $user->telefono =$phone;
           $user->direccion = $address;

           // Guardar el modelo
           if ($video->save() && $user->save()) {
               return $this->asJson(['success' => true, 'message' => 'Consulta guardada exitosamente.']);
           } else {
               return $this->asJson(['success' => false, 'message' => 'Error al guardar la consulta: ' . implode(', ', $consulta->getErrors())]);
           }
       }

       throw new BadRequestHttpException('Petición no válida.');
   }


}
