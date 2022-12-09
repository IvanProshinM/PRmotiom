<?php

namespace app\services;

use app\models\Post;
use app\models\PostView;

class CreatePostService
{

    public function createPost(PostView $post)
    {
        $newPost = new Post();
        $newPost->name = $post->name;
        $newPost->user_id = \Yii::$app->user->id;
        $newPost->postText = $post->postText;
        $newPost->createdAt = date('Y-m-d', time());
        $newPost->updatedAt = date('Y-m-d', time());

        $newPost->save();

        return $newPost;
    }
}