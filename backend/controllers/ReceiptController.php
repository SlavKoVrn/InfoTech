<?php

namespace backend\controllers;

use common\models\Author;
use common\models\Book;
use common\models\BookAuthor;
use Yii;
use yii\web\Controller;
use Faker\Factory;

/**
 * Receipt Controller
 */
class ReceiptController extends Controller
{

    /**
     * Displays receipt of books.
     *
     * @return string
     */
    public function actionIndex()
    {
        $faker = Factory::create('ru_RU');

        $newBooks = [];
        for ($i = 1; $i <= 20; $i++) {
            $book = new Book;
            $book->setAttributes([
                'name' => $faker->realText(22),
                'release_year' => random_int(1900, 2022),
                'isbn' => $faker->isbn13(),
                'description' => $faker->realText(1000),
            ]);
            $book->save();
            $newBooks[] = $book->id;
        }

        $books = Book::find()->where(['in','id',$newBooks])->all();
        foreach ($books as $book){
            $authorsCount = random_int(1,5);
            $randomAuthors = Author::find()->limit($authorsCount)->orderBy('RAND()')->all();
            foreach ($randomAuthors as $author){
                $bookAuthor = new BookAuthor;
                $bookAuthor->setAttributes([
                    'book_id' => $book->id,
                    'author_id' => $author->id,
                ]);
                $bookAuthor->save();
            }
        }

        $receiptBooks = Book::find()
            ->joinWith('currentAuthors')
            ->where(['in','books.id',$newBooks])
            ->asArray()
            ->all();

        return $this->render('index',['receiptBooks' => $receiptBooks]);
    }

}
