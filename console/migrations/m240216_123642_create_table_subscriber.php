<?php

use yii\db\Migration;

/**
 * Class m240216_123642_create_table_subscriber
 */
class m240216_123642_create_table_subscriber extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriber}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'phone' => $this->string(20),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscriber}}');
    }

}
