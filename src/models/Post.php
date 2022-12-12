<?php

namespace app\models;

use app\query\PostQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $status
 * @property string $postText
 * @property string $createdAt
 * @property string $updatedAt
 */
class Post extends ActiveRecord
{

    public static function tableName()
    {
        return 'post';
    }

    public static function find()
    {
        return new PostQuery(static::class);
    }
}
