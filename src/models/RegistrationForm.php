<?php

namespace app\models;

use yii\base\Model;

class RegistrationForm extends Model

{
    public $login;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['login', 'password'], 'string', 'length' => [2, 10]],
            ['email', 'string'],
            ['email', 'email'],
            [['login', 'password', 'email'], 'required']
        ];
    }
}
