<?php

use yii\db\Migration;

/**
 * Class m240215_034056_create_tables_books_authors
 */
class m240215_034056_create_tables_books_authors extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'release_year' => $this->integer(),
            'name' => $this->string(),
            'isbn' => $this->string(),
            'main_page_photo' => $this->string(),
            'description' => $this->text(),
        ]);

        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(),
        ]);

        $this->createTable('{{%book_author}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'author_id' => $this->integer(),
        ]);

        $this->createIndex('idx-book_author-book_id', '{{%book_author}}', 'book_id');
        $this->createIndex('idx-book_author-author_id', '{{%book_author}}', 'author_id');

        $this->addForeignKey(
            'fk-book_author-book_id',
            '{{%book_author}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-book_author-author_id',
            '{{%book_author}}',
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
        $this->dropForeignKey('fk-book_author-book_id', '{{%book_author}}');
        $this->dropForeignKey('fk-book_author-author_id', '{{%book_author}}');
        $this->dropIndex('idx-book_author-book_id', '{{%book_author}}');
        $this->dropIndex('idx-book_author-author_id', '{{%book_author}}');

        $this->dropTable('{{%book_author}}');
        $this->dropTable('{{%books}}');
        $this->dropTable('{{%authors}}');
    }

}
