<?php

namespace app\services;

use app\models\RegistrationForm;
use app\models\User;

class CreateUserService
{

    public function saveUser(RegistrationForm $user)
    {
        $model = new User();
        $model->login = $user->login;
        $model->email = $user->email;
        $model->setPassword($user->password);
        $model->save();

        return [
            'model' => $model,
            'errors' => $model->errors
        ];
    }
}
