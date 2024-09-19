<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chats".
 *
 * @property int $id
 * @property int $id_paciente
 * @property int $id_medico
 * @property string|null $fecha_inicio
 * @property string|null $fecha_fin
 * @property string|null $estado
 * @property string|null $fecha_creacion
 * @property string|null $fecha_actualizacion
 *
 * @property Usuarios $medico
 * @property MensajesChat[] $mensajesChats
 * @property Usuarios $paciente
 */
class Chats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_paciente', 'id_medico'], 'required'],
            [['id_paciente', 'id_medico'], 'integer'],
            [['fecha_inicio', 'fecha_fin', 'fecha_creacion', 'fecha_actualizacion'], 'safe'],
            [['estado'], 'string'],
            [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['id_paciente' => 'id']],
            [['id_medico'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['id_medico' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_paciente' => 'Id Paciente',
            'id_medico' => 'Id Medico',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'estado' => 'Estado',
            'fecha_creacion' => 'Fecha Creacion',
            'fecha_actualizacion' => 'Fecha Actualizacion',
        ];
    }

    /**
     * Gets query for [[Medico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedico()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'id_medico']);
    }

    /**
     * Gets query for [[MensajesChats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensajesChats()
    {
        return $this->hasMany(MensajesChat::class, ['id_chat' => 'id']);
    }

    /**
     * Gets query for [[Paciente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'id_paciente']);
    }
}
