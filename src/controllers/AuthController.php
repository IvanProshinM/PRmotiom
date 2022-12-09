<?php

namespace app\controllers;

use app\models\LoginView;
use app\models\RegistrationView;
use app\models\User;
use app\services\CreateUserService;
use app\services\UserAuthService;
use yii\db\Exception;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\auth\HttpBasicAuth;

class AuthController extends Controller
{

    /**
     * @var CreateUserService
     */
    private $createUserService;

    /**
     * @var UserAuthService
     */
    private $userAuthService;


    public $enableCsrfValidation = false;

    public function __construct($id,
        $module,
                                CreateUserService $createUserService,
                                UserAuthService $userAuthService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->createUserService = $createUserService;
        $this->userAuthService = $userAuthService;
    }


    public function actionRegistration()
    {
        $model = new RegistrationView();

        if ($model->load(\Yii::$app->request->post(), '') && $model->validate()) {

            $newUser = User::find()
                ->where(["email" => $model->email])
                ->one();
            if ($newUser) {
                throw new Exception('Пользователь с такой почтой уже существует');
            }

            $user = $this->createUserService->saveUser($model);

            if (!$user) {
                throw new \Exception('возникла ошибка при создании пользователя');
            }

            \Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'login' => $user->login,
                'email' => $user->email,
                'password' => $user->password
            ];
        }
        return "ошибка введенных данных";
    }


    public function actionLogin()

    {
        $model = new LoginView();


        if ($model->load(\Yii::$app->request->post(), '') && $model->validate()) {
            $user = $this->userAuthService->authorizate($model);
            if ($user === null) {
                throw new \Exception('Неверный логин или пароль ');
            }
            return $user->access_token;
            /* User::findIdentityByAccessToken($user->accessToken);*/
        }

    }


    public function actionLogout()
    {
        $token = preg_replace("/^(.*?)(\s)(.*?)$/", '\\3', \Yii::$app->request->headers->get('Authorization'));
        $user = User::findIdentityByAccessToken($token);
        $user->access_token = null;
        $user->save();
    }


}
