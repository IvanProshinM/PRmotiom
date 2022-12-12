<?php

namespace app\controllers;

use app\models\Post;
use app\models\PostForm;
use app\models\UpdatePostForm;
use app\services\CreatePostService;
use app\services\UpdatePostService;
use Yii;
use yii\filters\auth\HttpBearerAuth;
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
            'only' => ['create', 'update', 'view'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'update', 'view'],
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    public $enableCsrfValidation = false;

    private CreatePostService $createPostService;

    private UpdatePostService $updatePostService;

    public function __construct(
        $id,
        $module,
        CreatePostService $createPostService,
        UpdatePostService $updatePostService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->createPostService = $createPostService;
        $this->updatePostService = $updatePostService;
    }


    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = new PostForm();

        $post->load(Yii::$app->request->post(), '');
        if ($post->validate()) {
            $newPost = $this->createPostService->createPost($post);

            return [
                'errors' => $newPost['errors'],
                'data' => [
                    'name' => $newPost['model']->name,
                    'postText' => $newPost['model']->postText,
                ]
            ];
        }
        return [
            'errors' => $post->errors
        ];
    }


    public function actionUpdate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new UpdatePostForm();

        $model->load(Yii::$app->request->post(), '');
        if ($model->validate()) {
            $newPost = $this->updatePostService->updatePost($model);
            return [
                'errors' => $newPost['errors'],
                'data' => [
                    'name' => $newPost['model']->name,
                    'postText' => $newPost['model']->postText,
                ]
            ];
        }

        Yii::$app->response->forat = Response::FORMAT_JSON;
        return [
            'errors' => $model->errors
        ];
    }

    public function actionView()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Post::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->all();
    }
}
