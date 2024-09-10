<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre_completo
 * @property string $nombre_usuario
 * @property string $contrasena
 * @property string $correo_electronico
 * @property string $rol
 * @property string|null $telefono
 * @property string|null $direccion
 * @property string|null $fecha_nacimiento
 * @property string|null $genero
 * @property string|null $fecha_creacion
 * @property string|null $fecha_actualizacion
 * @property int $estado
 *
 * @property ArchivosSubidos[] $archivosSubidos
 * @property Chats[] $chats
 * @property Chats[] $chats0
 * @property ConfiguracionesUsuarios[] $configuracionesUsuarios
 * @property CorreosElectronicos[] $correosElectronicos
 * @property CorreosElectronicos[] $correosElectronicos0
 * @property MensajesChat[] $mensajesChats
 * @property Videollamadas[] $videollamadas
 * @property Videollamadas[] $videollamadas0
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_completo', 'nombre_usuario', 'contrasena', 'correo_electronico', 'rol'], 'required'],
            [['rol', 'genero'], 'string'],
            [['fecha_nacimiento', 'fecha_creacion', 'fecha_actualizacion'], 'safe'],
            [['estado'], 'integer'],
            [['nombre_completo', 'contrasena', 'direccion'], 'string', 'max' => 255],
            [['nombre_usuario', 'correo_electronico'], 'string', 'max' => 100],
            [['telefono'], 'string', 'max' => 20],
            [['nombre_usuario'], 'unique'],
            [['correo_electronico'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_completo' => 'Nombre Completo',
            'nombre_usuario' => 'Nombre Usuario',
            'contrasena' => 'Contrasena',
            'correo_electronico' => 'Correo Electronico',
            'rol' => 'Rol',
            'telefono' => 'Telefono',
            'direccion' => 'Direccion',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'genero' => 'Genero',
            'fecha_creacion' => 'Fecha Creacion',
            'fecha_actualizacion' => 'Fecha Actualizacion',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[ArchivosSubidos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArchivosSubidos()
    {
        return $this->hasMany(ArchivosSubidos::class, ['id_usuario' => 'id']);
    }

    /**
     * Gets query for [[Chats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chats::class, ['id_paciente' => 'id']);
    }

    /**
     * Gets query for [[Chats0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats0()
    {
        return $this->hasMany(Chats::class, ['id_medico' => 'id']);
    }

    /**
     * Gets query for [[ConfiguracionesUsuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConfiguracionesUsuarios()
    {
        return $this->hasMany(ConfiguracionesUsuarios::class, ['id_usuario' => 'id']);
    }

    /**
     * Gets query for [[CorreosElectronicos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCorreosElectronicos()
    {
        return $this->hasMany(CorreosElectronicos::class, ['id_remitente' => 'id']);
    }

    /**
     * Gets query for [[CorreosElectronicos0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCorreosElectronicos0()
    {
        return $this->hasMany(CorreosElectronicos::class, ['id_destinatario' => 'id']);
    }

    /**
     * Gets query for [[MensajesChats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensajesChats()
    {
        return $this->hasMany(MensajesChat::class, ['id_remitente' => 'id']);
    }

    /**
     * Gets query for [[Videollamadas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVideollamadas()
    {
        return $this->hasMany(Videollamadas::class, ['id_paciente' => 'id']);
    }

    /**
     * Gets query for [[Videollamadas0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVideollamadas0()
    {
        return $this->hasMany(Videollamadas::class, ['id_medico' => 'id']);
    }
}
