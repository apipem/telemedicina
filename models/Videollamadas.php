<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "videollamadas".
 *
 * @property int $id
 * @property int $id_paciente
 * @property int $id_medico
 * @property string|null $url_reunion
 * @property string|null $fecha_programada
 * @property string|null $notas
 * @property string|null $estado
 * @property string|null $detalles_consulta
 * @property string|null $fecha_creacion
 * @property string|null $fecha_actualizacion
 *
 * @property Usuarios $medico
 * @property Usuarios $paciente
 */
class Videollamadas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'videollamadas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_paciente', 'id_medico'], 'required'],
            [['id_paciente', 'id_medico'], 'integer'],
            [['fecha_programada', 'fecha_creacion', 'fecha_actualizacion'], 'safe'],
            [['notas', 'estado', 'detalles_consulta'], 'string'],
            [['url_reunion'], 'string', 'max' => 255],
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
            'url_reunion' => 'Url Reunion',
            'fecha_programada' => 'Fecha Programada',
            'notas' => 'Notas',
            'estado' => 'Estado',
            'detalles_consulta' => 'Detalles Consulta',
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
     * Gets query for [[Paciente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'id_paciente']);
    }
}
