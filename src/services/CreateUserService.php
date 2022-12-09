<?php

namespace app\services;

use app\models\RegistrationView;
use app\models\User;
use yii\helpers\VarDumper;

class CreateUserService
{

    public function saveUser(RegistrationView $user)
    {
        $model = new User();
        $model->login = $user->login;
        $model->email = $user->email;
        $model->setPassword($user->password);
        $model->save();

        return $model;
    }


}