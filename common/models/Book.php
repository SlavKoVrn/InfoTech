<?php

namespace common\models;

use Yii;

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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'release_year' => 'Release Year',
            'name' => 'Name',
            'isbn' => 'Isbn',
            'main_page_photo' => 'Main Page Photo',
            'description' => 'Description',
        ];
    }
}
