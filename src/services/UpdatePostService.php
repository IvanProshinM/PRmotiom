<?php

namespace app\services;

use app\models\Post;
use app\models\PostView;
use app\models\UpdatePostView;

class UpdatePostService
{

    public function updatePost(UpdatePostView  $post)
    {

        $newPost = Post::find()
            ->where(['id' => $post->postId])
            ->andWhere(['user_id'=>\Yii::$app->user->id])
            ->one();
        if (!$newPost) {
            throw new \Exception('Пост таким id не найден');
        }
        $newPost->name = $post->postName;
        $newPost->postText = $post->postText;
        $newPost->updatedAt = date('Y-m-d', time());

        $newPost->save();

        return $newPost;
    }
}