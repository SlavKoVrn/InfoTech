<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string|null $fio
 */
class Author extends \yii\db\ActiveRecord
{
    public $books = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio'], 'string', 'max' => 255],
            [['books'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'fio' => 'ФИО',
            'books' => 'Книги',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->booksSave($this->books);
    }

    public function getCurrentBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable(BookAuthor::tableName(), ['author_id' => 'id']);
    }

    public function getBookIds()
    {
        return ArrayHelper::map($this->currentBooks,'id','id');
    }

    public function getBookNames()
    {
        return ArrayHelper::map($this->currentBooks,'id','isbnName');
    }

    public function booksSave($newBookIds)
    {
        $currentBookIds = $this->bookIds;
        $toInsert = [];
        foreach (array_filter(array_diff($newBookIds,$currentBookIds)) as $book_id){
            $toInsert[] = $book_id;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($toInsert){
                foreach ($toInsert as $book_id){
                    $bookAuthor = new BookAuthor;
                    $bookAuthor->setAttributes([
                        'author_id' => $this->id,
                        'book_id' => $book_id,
                    ]);
                    $bookAuthor->save();
                }
            }
            if ($toRemove = array_filter(array_diff($currentBookIds,$newBookIds))){
                BookAuthor::deleteAll([
                    'author_id'=>$this->id,
                    'book_id'=>$toRemove
                ]);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
    }

}
