<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "archivos_subidos".
 *
 * @property int $id
 * @property int $paciente
 * @property int $medico
 * @property string $ruta_archivo
 * @property string|null $descripcion
 * @property string|null $subido_en
 *
 * @property Usuarios $medico0
 * @property Usuarios $paciente0
 */
class ArchivosSubidos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'archivos_subidos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paciente', 'medico', 'ruta_archivo'], 'required'],
            [['paciente', 'medico'], 'integer'],
            [['descripcion'], 'string'],
            [['subido_en'], 'safe'],
            [['ruta_archivo'], 'string', 'max' => 255],
            [['paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['paciente' => 'id']],
            [['medico'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['medico' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'paciente' => 'Paciente',
            'medico' => 'Medico',
            'ruta_archivo' => 'Ruta Archivo',
            'descripcion' => 'Descripcion',
            'subido_en' => 'Subido En',
        ];
    }

    /**
     * Gets query for [[Medico0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedico0()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'medico']);
    }

    /**
     * Gets query for [[Paciente0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente0()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'paciente']);
    }
}
