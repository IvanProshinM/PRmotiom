<?php

namespace app\query;


class PostQuery extends \yii\db\ActiveQuery
{


    /**
     * {@inheritdoc}
     * @return \app\models\Post|array|null
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Post|array|null
     */

    public function one($db = null)
    {
        return parent::one($db);
    }
}
