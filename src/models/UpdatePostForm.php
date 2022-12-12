<?php

namespace app\models;

use yii\base\Model;

class UpdatePostForm extends Model
{
    public $postId;
    public $postName;
    public $postText;

    public function rules()
    {
        return [
            [['postId', 'postName', 'postText'], 'required'],
            [['postId'], 'integer'],
            [['postName', 'postText'], 'string']
        ];
    }
}
