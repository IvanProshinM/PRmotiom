<?php

use yii\db\Migration;

/**
 * Class m221209_111704_add_acess_token_column
 */
class m221209_111704_add_acess_token_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'access_token', $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'access_token');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221209_111704_add_acess_token_column cannot be reverted.\n";

        return false;
    }
    */
}
