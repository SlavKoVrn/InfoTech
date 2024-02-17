<?php
use common\models\Sms;
use yii\db\Migration;

/**
 * Class m240217_093619_create_table_sms
 */
class m240217_093619_create_table_sms extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sms}}', [
            'id' => $this->primaryKey(),
            'subscriber_id' => $this->integer(),
            'status' => $this->string(10)->defaultValue(Sms::STATUS_NOT_SEND),
            'phone' => $this->string(20),
            'text' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        $this->createIndex('idx-sms-subscriber_id', '{{%sms}}', 'subscriber_id');
        $this->createIndex('idx-sms-status', '{{%sms}}', 'status');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-sms-subscriber_id', '{{%sms}}');
        $this->dropIndex('idx-sms-status', '{{%sms}}');
        $this->dropTable('{{%sms}}');
    }

}
