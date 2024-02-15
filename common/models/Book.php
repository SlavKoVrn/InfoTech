<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property int|null $release_year
 * @property string|null $name
 * @property string|null $isbn
 * @property string|null $main_page_photo
 * @property string|null $description
 */
class Book extends \yii\db\ActiveRecord
{
    public $authors = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['release_year'], 'integer'],
            [['description'], 'string'],
            [['name', 'isbn', 'main_page_photo'], 'string', 'max' => 255],
            [['authors'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'release_year' => 'Год выпуска',
            'name' => 'Название',
            'isbn' => 'ISBN',
            'main_page_photo' => 'Фото главной страницы',
            'description' => 'Описание',
            'authors' => 'Авторы',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->authorsSave($this->authors);
    }

    public function getCurrentAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable(BookAuthor::tableName(), ['book_id' => 'id']);
    }

    public function getAuthorIds()
    {
        return ArrayHelper::map($this->currentAuthors,'id','id');
    }

    public function getAuthorFio()
    {
        return ArrayHelper::map($this->currentAuthors,'id','fio');
    }

    public function authorsSave($newAuthorIds)
    {
        $currentAuthorIds = $this->authorIds;
        $toInsert = [];
        foreach (array_filter(array_diff($newAuthorIds,$currentAuthorIds)) as $author_id){
            $toInsert[] = $author_id;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($toInsert){
                foreach ($toInsert as $author_id){
                    $bookAuthor = new BookAuthor;
                    $bookAuthor->setAttributes([
                        'book_id' => $this->id,
                        'author_id' => $author_id,
                    ]);
                    $bookAuthor->save();
                }
            }
            if ($toRemove = array_filter(array_diff($currentAuthorIds,$newAuthorIds))){
                BookAuthor::deleteAll([
                    'book_id'=>$this->id,
                    'author_id'=>$toRemove
                ]);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
    }

    public function getIsbnName()
    {
        return $this->isbn.' '.$this->name;
    }

}
