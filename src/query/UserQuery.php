<?php

namespace app\query;

use app\models\User;


class UserQuery extends \yii\db\ActiveQuery
{


    /**
     * {@inheritdoc}
     * @return \app\models\User|array|null
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\User|array|null
     */

    public function one($db = null)
    {
        return parent::one($db);
    }

}