<?php

use yii\db\Migration;

/**
 * Class m240217_022341_create_table_subscriber_authors
 */
class m240217_022341_create_table_subscriber_author extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriber_author}}', [
            'id' => $this->primaryKey(),
            'subscriber_id' => $this->integer(),
            'author_id' => $this->integer(),
        ]);

        $this->createIndex('idx-subscriber_author-subscriber_id', '{{%subscriber_author}}', 'subscriber_id');
        $this->createIndex('idx-subscriber_author-author_id', '{{%subscriber_author}}', 'author_id');

        $this->addForeignKey(
            'fk-subscriber_author-subscriber_id',
            '{{%subscriber_author}}',
            'subscriber_id',
            '{{%subscriber}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-subscriber_author-author_id',
            '{{%subscriber_author}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-subscriber_author-subscriber_id', '{{%subscriber_author}}');
        $this->dropForeignKey('fk-subscriber_author-author_id', '{{%subscriber_author}}');
        $this->dropIndex('idx-subscriber_author-subscriber_id', '{{%subscriber_author}}');
        $this->dropIndex('idx-subscriber_author-author_id', '{{%subscriber_author}}');

        $this->dropTable('{{%subscriber_author}}');
    }

}
