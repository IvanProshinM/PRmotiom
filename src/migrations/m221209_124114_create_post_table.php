<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m221209_124114_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name' => $this->string(),
            'publicDate' => $this->string(),
            'postText' => $this->text(),
            'createdAt'=>$this->string(),
            'updatedAt'=>$this->string()
        ]);
        $this->addForeignKey('userId', 'post', 'user_id', 'user', 'id' );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post}}');
    }
}
