<?php

namespace console\controllers;

use common\models\Book;
use common\models\Author;
use common\models\BookAuthor;
use Faker\Factory;
use yii\console\Controller;

class InsertController extends Controller
{
    public function actionIndex()
    {
        $faker = Factory::create('ru_RU');

        for ($i = 1; $i <= 100; $i++) {
            $author = new Author;
            $author->setAttributes([
                'fio' => $faker->firstName.' '.$faker->lastName,
            ]);
            $author->save();
            echo "$author->id. $author->fio\n";
        }

        for ($i = 1; $i <= 100; $i++) {
            $book = new Book;
            $book->setAttributes([
                'name' => $faker->realText(22),
                'release_year' => random_int(1900, 2022),
                'isbn' => $faker->isbn13(),
                'description' => $faker->realText(1000),
            ]);
            $book->save();
            echo "$book->id. $book->name - $book->isbn - $book->release_year\n";
        }

        $books = Book::find()->all();
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
                echo "$book->id. $book->name - $author->id. $author->fio\n";
            }
        }

    }

}
