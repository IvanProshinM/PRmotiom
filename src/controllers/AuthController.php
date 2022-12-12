<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\RegistrationForm;
use app\models\User;
use app\services\CreateUserService;
use app\services\UserAuthService;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    private CreateUserService $createUserService;

    private UserAuthService $userAuthService;

    public $enableCsrfValidation = false;

    public function __construct(
        $id,
        $module,
        CreateUserService $createUserService,
        UserAuthService $userAuthService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->createUserService = $createUserService;
        $this->userAuthService = $userAuthService;
    }

    public function actionRegistration()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new RegistrationForm();

        $model->load(Yii::$app->request->post(), '');
        if ($model->validate()) {
            $newUser = User::find()
                ->where(["email" => $model->email])
                ->one();
            if ($newUser) {
                return [
                    'errors' => [
                        'email' => 'Пользователь с такой почтой уже существует'
                    ]
                ];
            }

            $user = $this->createUserService->saveUser($model);

            return [
                'errors' => $user['errors'],
                'data' => $user['model'] ? [
                    'login' => $user['model']->login,
                    'email' => $user['model']->email,
                    'password' => $user['model']->password
                ] : null
            ];
        }
        return [
            'errors' => $model->errors
        ];
    }


    public function actionLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new LoginForm();

        $model->load(Yii::$app->request->post(), '');

        if ($model->validate()) {
            $user = $this->userAuthService->authorizate($model);
            if ($user === null) {
                return [
                    'errors' => [
                        'Неверный логин или пароль'
                    ]
                ];
            }
            return [
                'access_token' => $user->access_token,
                'errors' => [],
            ];
        }
        return [
            'errors' => $model->errors
        ];
    }


    public function actionLogout()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $token = preg_replace("/^(.*?)(\s)(.*?)$/", '\\3', Yii::$app->request->headers->get('Authorization'));
        $user = User::findIdentityByAccessToken($token);
        if ($user === null) {
            return true;
        }
        $user->access_token = null;
        return $user->save();
    }
}
