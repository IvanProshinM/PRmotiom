<?php

namespace app\models;

use yii\base\Model;

class LoginView extends Model
{

    public $login;
    public $password;


    public function rules()
    {
        return [
            [['login','password'], 'string'],
            [['login', 'password'], 'required']
        ];
    }


}