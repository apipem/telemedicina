<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre_completo
 * @property int $documento
 * @property string $tipo_documento
 * @property string $contrasena
 * @property string $correo_electronico
 * @property string $rol
 * @property string|null $telefono
 * @property string|null $direccion
 * @property string|null $Ciudad
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
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['nombre_completo', 'documento', 'contrasena', 'correo_electronico', 'rol'], 'required'],
            [['documento', 'estado'], 'integer'],
            [['tipo_documento', 'rol', 'genero'], 'string'],
            [['fecha_nacimiento', 'fecha_creacion', 'fecha_actualizacion'], 'safe'],
            [['nombre_completo', 'contrasena', 'direccion'], 'string', 'max' => 255],
            [['correo_electronico'], 'string', 'max' => 100],
            [['telefono'], 'string', 'max' => 20],
            [['Ciudad'], 'string', 'max' => 45],
            [['correo_electronico'], 'unique'],
            [['documento'], 'unique'],
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
            'documento' => 'Documento',
            'tipo_documento' => 'Tipo Documento',
            'contrasena' => 'Contrasena',
            'correo_electronico' => 'Correo Electronico',
            'rol' => 'Rol',
            'telefono' => 'Telefono',
            'direccion' => 'Direccion',
            'Ciudad' => 'Ciudad',
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

     //////////////////////Metodos para determinar si la persona es un funcionario ///////////////////
        public static function isFuncionario($id){

            if(self::findOne(['id' => $id])){
                return true;
            }
            return false;
        }

        public static function isAdministrador(){
            if(self::findOne(['id' => 1])){
                return true;
            }
            return false;
        }

     /////////////////////Encriptar password//////////////////
        public function beforeSave($insert)
        {
            try {
                $this->contrasena = Yii::$app->security->generatePasswordHash($this->contrasena);
            } catch (Exception $e) {
                echo $e;
            }

            return parent::beforeSave($insert);
        }
    /////////////////////////////////LOGiNNNNNNN////////////////////////////////

        /**
         * Finds an identity by the given ID.
         * @param string|int $id the ID to be looked for
         * @return IdentityInterface the identity object that matches the given ID.
         * Null should be returned if such an identity cannot be found
         * or the identity is not in an active state (disabled, deleted, etc.)
         */
        public static function findIdentity($id)
        {
            return self::findOne(['id' => $id]);
        }

        /**
         * Finds an identity by the given token.
         * @param mixed $token the token to be looked for
         * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
         * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
         * @return IdentityInterface the identity object that matches the given token.
         * Null should be returned if such an identity cannot be found
         * or the identity is not in an active state (disabled, deleted, etc.)
         * @throws NotSupportedException
         */
        public static function findIdentityByAccessToken($token, $type = null)
        {
            //throw new NotSupportedException();
        }

        public static function findByUsername($username){

            return self::findOne(['documento' => $username]);
        }

        /**
         * Returns an ID that can uniquely identify a user identity.
         * @return string|int an ID that uniquely identifies a user identity.
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Returns a key that can be used to check the validity of a given identity ID.
         *
         * The key should be unique for each individual user, and should be persistent
         * so that it can be used to check the validity of the user identity.
         *
         * The space of such keys should be big enough to defeat potential identity attacks.
         *
         * This is required if [[User::enableAutoLogin]] is enabled.
         * @return string a key that is used to check the validity of a given identity ID.
         * @see validateAuthKey()
         * @throws NotSupportedException
         */
        public function getAuthKey()
        {
            return $this->contrasena;
        }

        /**
         * Validates the given auth key.
         *
         * This is required if [[User::enableAutoLogin]] is enabled.
         * @param string $authKey the given auth key
         * @return bool whether the given auth key is valid.
         * @see getAuthKey()
         * @throws NotSupportedException
         */
        public function validateAuthKey($authKey)
        {
            return $this->getAuthKey() === $authKey;
        }


        /**
         * @param $password
         * @return bool
         */
        public function validatePassword($password){
            try{
                if(Yii::$app->security->validatePassword($password, $this->contrasena)){
                    return true;
                }
            }catch(InvalidArgumentException $ex){
                return false;
            }
            //####GENERAR CONTRASENA A USUARIO NUEVO
            //$this->contrasena = 12345;
            //$this->save(false))
            //return true;
        }

        /** @param $displayField
         * @throws \yii\base\InvalidConfigException
         */
        public function dfIsFK($displayField){
            $fkKeys = self::getTableSchema()->foreignKeys;
            foreach($fkKeys as $key){
                if($key[0] === $displayField){
                    $props = self::attributes();
                    foreach($props as $prop){
                        if(strpos($prop,$displayField) !== false){
                            return $prop.'0';
                        }
                    }
                }
            }
            return null;
        }


        /**
         * @inheritdoc
         */
        public function getIdModel(){
            return 'id';
        }

        /**
         * @inheritdoc
         */
        public function getDisplayField()
        {
            return 'nombre_completo';
        }

        /**
         * @inheritdoc
         * @throws Exception
         */
        public function generatePasswordResetToken(){
            $this->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
        }

        /**
         * @inheritdoc
         */
        public function resetPasswordResetToken(){
            $this->password_reset_token = null;
        }

        /**
         * Finds user by password reset token
         *
         * @param string $token password reset token
         * @return static null
         */
        public static function findByPasswordResetToken($token) {
            if (! static::isPasswordResetTokenValid($token)) {
                return null;
            }
            return static::findOne([
                'password_reset_token' => $token,
                'estado' => 'Activo'
            ]);
        }

        /**
         * Finds out if password reset token is valid
         *
         * @param string $token password reset token
         * @return boolean
         */
        public static function isPasswordResetTokenValid($token) {
            if (empty($token)){
                return false;
            }
            $expire = Yii::$app->params['passwordResetTokenExpire'];
            $parts = explode( '_', $token );
            $timestamp = (int)end($parts);
            return $timestamp + $expire >= time();
        }

        /**
         * Removes password reset token
         */
        public function removePasswordResetToken()
        {
            $this->password_reset_token = null;
        }
}
