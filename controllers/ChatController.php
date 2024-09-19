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
                    'actions' => ['index','chat','mensaje','get'],
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
          $chats = Chats::find();
          $chatce = Chats::find();

          // Filtrar según el rol del usuario
          if (Yii::$app->user->identity->rol == "Paciente") {
              $chats->where(['id_paciente' => Yii::$app->user->identity->id]);
              $chatce->where(['id_paciente' => Yii::$app->user->identity->id]);
          } elseif (Yii::$app->user->identity->rol == "Medico") {
              $chats->where(['id_medico' => Yii::$app->user->identity->id]);
              $chatce->where(['id_medico' => Yii::$app->user->identity->id]);
          }
          $chats->andWhere(['estado' => 'activo']);
          $chatce->andWhere(['estado' => 'completado']);
          $chats = $chats->all();
          $chatce = $chatce->all();

         return $this->render('index', [
                'medicos' => $medicos,
                'chats' => $chats,
                'chatce' => $chatce,
            ]);

    }

   public function decryptBy($chat)
   {
       // Decodificar antes de desencriptar
       $chat = urldecode($chat);

       try {
           $id = Yii::$app->security->decryptByKey($chat, 'telem');
       } catch (\Exception $e) {
           echo "Error al desencriptar: " . $e->getMessage();
           return null; // Devuelve null en caso de error
       }

       // Verificar si se desencriptó correctamente
       if ($id === false) {
           echo "Error al desencriptar el ID.";
           return null; // Devuelve null en caso de error
       }

       return $id;
   }

   public function actionChat($chat)
   {
       // Desencriptar el ID
       $id = $this->decryptBy($chat);
       if ($id === null) {
           return; // Salir si hay un error en la desencriptación
       }

       // Inicializar la consulta de Chats
       $antiguoChatQuery = Chats::find();

       // Filtrar según el rol del usuario
       if (Yii::$app->user->identity->rol == "Paciente") {
           $antiguoChatQuery->where(['id_paciente' => Yii::$app->user->identity->id])
                             ->andWhere(['id_medico' => $id]);
       } elseif (Yii::$app->user->identity->rol == "Medico") {
           $antiguoChatQuery->where(['id_medico' => Yii::$app->user->identity->id])
                             ->andWhere(['id_paciente' => $id]);
       }

       $antiguoChatQuery->andWhere(['estado' => 'activo']);
       $antiguoChat = $antiguoChatQuery->all();

       // Obtener el médico
       $persona = Usuarios::findOne($id);

       // Verificar si se encontraron chats antiguos
       if (!empty($antiguoChat)) {

           foreach ($antiguoChat as $chate) {
               return $this->render('chat', [
                                     'persona' => $persona,
                                     'chat' => $chate,
                                 ]);
           }

       } else {
           // Crear un nuevo chat
           $nuevoChat = new Chats();
           $nuevoChat->id_paciente = Yii::$app->user->identity->id;
           $nuevoChat->id_medico = $id;

           // Intentar guardar el nuevo chat
           if ($nuevoChat->save()) {
               return $this->render('chat', [
                   'persona' => $persona,
                   'chat' => $chat,
               ]);
           } else {
               // Manejo de errores
               foreach ($nuevoChat->getErrors() as $error) {
                   echo implode(', ', $error) . '<br>';
               }
           }
       }
   }

    public function actionMensaje(){
        $chatId = (int) Yii::$app->request->post('chatId');
        $messageText = Yii::$app->request->post('message');

        // Aquí deberías validar y guardar el mensaje en tu base de datos

        $message = new MensajesChat();
        $message->id_chat = $chatId;
        $message->mensaje = $messageText;
        $message->id_remitente = Yii::$app->user->identity->id; // O el identificador que uses

        if ($message->save()) {
           return $this->asJson(['success' => true]);
       } else {
           // Manejo de errores
           foreach ($message->getErrors() as $error) {
               echo implode(', ', $error) . '<br>';
           }
       }
    }

    public function actionGet(){
        $chatId = Yii::$app->request->get('chatId');
        $messages = MensajesChat::find()->where(['id_chat' => $chatId])->all();

        return $this->asJson(['messages' => $messages]);
    }

}
