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
                    'actions' => ['index','chat','mensaje','get','cerrar'],
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

        // Ordenar por fecha de inicio de manera descendente
        $chats = $chats->all();
        $chatce = $chatce->orderBy(['fecha_fin' => SORT_DESC])->all();


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

    public function actionChat($chat)
    {
        $id = $this->decryptBy($chat);
        if ($id === null) {
            Yii::$app->session->setFlash('error', 'ID de chat inválido.');
            return $this->redirect(['index']);
        }

        // Obtener el ID del chat enviado desde la vista
        $chatId = Yii::$app->request->get('chatId');

        // Inicializar la consulta de Chats
        $chatQuery = Chats::find();

        if (Yii::$app->user->identity->rol == "Paciente") {
            $chatQuery->where(['id_paciente' => Yii::$app->user->identity->id])
                       ->andWhere(['id_medico' => $id]);
        } elseif (Yii::$app->user->identity->rol == "Medico") {
            $chatQuery->where(['id_medico' => Yii::$app->user->identity->id])
                       ->andWhere(['id_paciente' => $id]);
        }

        // Verificar si ya existe un chat activo
        $chatExistente = $chatQuery->andWhere(['estado' => 'activo'])->one();

        // Si se desea consultar un chat existente
        if ($chatId) {
            $chatParaConsultar = Chats::findOne($chatId);
            if ($chatParaConsultar) {
                return $this->render('chat', [
                    'persona' => Usuarios::findOne($id),
                    'chat' => $chatParaConsultar,
                ]);
            }
        }

        // Si ya existe un chat activo, retornarlo
        if ($chatExistente) {
            return $this->render('chat', [
                'persona' => Usuarios::findOne($id),
                'chat' => $chatExistente,
            ]);
        }

        // Si no existe un chat activo, crear uno nuevo
        $nuevoChat = new Chats();
        $nuevoChat->id_paciente = Yii::$app->user->identity->id;
        $nuevoChat->id_medico = $id;

        if ($nuevoChat->save()) {
            return $this->render('chat', [
                'persona' => Usuarios::findOne($id),
                'chat' => $nuevoChat,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Error al crear el chat: ' . implode(', ', $nuevoChat->getErrors()));
            return $this->redirect(['index']);
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

    public function actionCerrar()
    {
        $chatId = Yii::$app->request->post('id');

        // Aquí debes verificar si el chat existe
        $chat = Chats::findOne($chatId);
        if ($chat) {
            $chat->estado = 'completado'; // O el estado que desees
            if ($chat->save()) {
                return $this->asJson(['success' => true]);
            } else {
                return $this->asJson(['success' => false]);
            }
        }

        return $this->asJson(['success' => false]);
    }

}
