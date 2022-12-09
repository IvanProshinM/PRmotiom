<?php

namespace app\services;

use app\models\LoginView;
use app\models\User;

class UserAuthService
{

    public function authorizate(LoginView $currentUser)
    {
        $regUser = User::find()
            ->where(['login' => $currentUser->login])
            ->one();
        if ($regUser && ($regUser->validatePassword($currentUser->password))) {

            $regUser->access_token = md5($regUser->login . time());
            $regUser->save();
            return $regUser;
        }
        return null;
    }
}