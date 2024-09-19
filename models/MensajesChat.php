<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensajes_chat".
 *
 * @property int $id
 * @property int $id_chat
 * @property int $id_remitente
 * @property string $mensaje
 * @property string|null $enviado_a
 *
 * @property Chats $chat
 * @property Usuarios $remitente
 */
class MensajesChat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensajes_chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_chat', 'id_remitente', 'mensaje'], 'required'],
            [['id_chat', 'id_remitente'], 'integer'],
            [['mensaje'], 'string'],
            [['enviado_a'], 'safe'],
            [['id_chat'], 'exist', 'skipOnError' => true, 'targetClass' => Chats::class, 'targetAttribute' => ['id_chat' => 'id']],
            [['id_remitente'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['id_remitente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_chat' => 'Id Chat',
            'id_remitente' => 'Id Remitente',
            'mensaje' => 'Mensaje',
            'enviado_a' => 'Enviado A',
        ];
    }

    /**
     * Gets query for [[Chat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Chats::class, ['id' => 'id_chat']);
    }

    /**
     * Gets query for [[Remitente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRemitente()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'id_remitente']);
    }
}
