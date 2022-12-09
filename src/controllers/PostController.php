<?php

namespace app\controllers;


use app\models\Post;
use app\models\PostView;
use app\models\UpdatePostView;
use app\models\User;
use app\services\CreatePostService;
use app\services\UpdatePostService;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;


class PostController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class
        ];
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['create', 'update'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'update'],
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    public $enableCsrfValidation = false;

    /**
     * @var CreatePostService
     */
    private $createPostService;


    /**
     * @var UpdatePostService
     */
    private $updatePostService;


    public function __construct($id,
        $module,
                                CreatePostService $createPostService,
                                UpdatePostService $updatePostService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->createPostService = $createPostService;
        $this->updatePostService = $updatePostService;
    }


    public function actionCreate()
    {

        $post = new PostView();


        if ($post->load(\Yii::$app->request->post(), '') && $post->validate()) {


            $newPost = $this->createPostService->createPost($post);
            if ($newPost === null) {
                throw new \Exception('Ошибка при создании поста');
            }
            \Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'name' => $newPost->name,
                'postText' => $newPost->postText,
            ];
        }
    }


    public function actionUpdate()
    {
        $model = new UpdatePostView();


        if ($model->load(\Yii::$app->request->post(), '') && $model->validate()) {
            $newPost = $this->updatePostService->updatePost($model);
        }

        \Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'name' => $newPost->name,
            'postText' => $newPost->postText,
        ];


    }

    public function actionGetPost()
    {
        $token = preg_replace("/^(.*?)(\s)(.*?)$/", '\\3', \Yii::$app->request->headers->get('Authorization'));
        $user = User::findIdentityByAccessToken($token);
        $post = Post::find()
            ->where(['user_id'=>$user->id])
            ->all();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $post;
    }
}