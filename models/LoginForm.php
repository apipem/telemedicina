<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * See Model class for more details
     *
     * @return array attribute labels (name => label).
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Documento de Identidad',
            'password' => 'Contraseña',
            'rememberMe' => 'Recordarme'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if ($this->_user->estado == "1"){
                if(Usuarios::isFuncionario($this->getUser()->getId())){
                    return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);

                }else if(Usuarios::isAdministrador()){
                    Yii::$app->user->setReturnUrl('site/index');
                    return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
                }
            }
            echo "<h2 hidden>No autorizado</h2>";
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Usuarios::findByUsername($this->username);
        }

        return $this->_user;
    }
}
