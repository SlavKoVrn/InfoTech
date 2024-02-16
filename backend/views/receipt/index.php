<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var yii\web\View $this */
/** @var $receiptBooks */

$this->title = 'Поступление книг';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receipt-index">

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Ид</th>
            <th scope="col">Книга</th>
            <th scope="col">ISBN</th>
            <th scope="col">Год выпуска</th>
            <th scope="col">Авторы</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($receiptBooks as $book) : ?>
            <tr>
                <td><?= $book['id'] ?></td>
                <td><?= Html::a($book['name'],Url::toRoute(['book/update','id'=> $book['id']]),[
                        'target' => '_blank',
                    ]) ?></td>
                <td><?= $book['isbn'] ?></td>
                <td><?= $book['release_year'] ?></td>
                <td>
                    <?php $i = 1; foreach ($book['currentAuthors'] as $author) : ?>
                        <?= $i++ .'. ' . $author['fio'].'</br>'; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
