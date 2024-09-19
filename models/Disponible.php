<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disponible".
 *
 * @property int $usuarios_id
 * @property int|null $estado
 *
 * @property Usuarios $usuarios
 */
class Disponible extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'disponible';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuarios_id'], 'required'],
            [['usuarios_id', 'estado'], 'integer'],
            [['usuarios_id'], 'unique'],
            [['usuarios_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuarios_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usuarios_id' => 'Usuarios ID',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuarios_id']);
    }
}
