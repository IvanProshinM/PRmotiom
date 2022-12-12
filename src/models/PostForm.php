<?php

namespace app\models;

use yii\base\Model;

class PostForm extends Model
{
    public $name;
    public $postText;

    public function rules()
    {
        return [
            [['name', 'postText',], 'required'],
            [['name', 'postText',], 'string'],
            [['name'], 'string', 'length' => [4, 10]],
        ];
    }
}
