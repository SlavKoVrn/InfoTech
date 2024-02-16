<?php
use frontend\models\BookSearch;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var frontend\models\BookSearch $model */
/** @var $topAuthors */
/** @var $years */

?>
<div class="book-view">


    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col col-sm-4">
            <h2>Отчет за период</h2>
        </div>
        <div class="col col-sm-4">
            <?= $form->field($model, 'release_year')->dropDownList($years) ?>
        </div>
        <div class="col col-sm-4">
            <div class="form-group">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if (count($topAuthors)) : ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Автор</th>
            <th scope="col">Количество книг</th>
            <th scope="col">Книги</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($topAuthors as $author) : ?>
        <tr>
            <td><?= $author['fio'] ?></td>
            <td><?= $author['book_count'] ?></td>
            <td>
                <?php foreach ($author['currentBooks'] as $book) : ?>
                    <?php if (empty($model->release_year) or (!empty($model->release_year) and $book['release_year'] == $model->release_year)) : ?>
                        <?= $book['isbn']. ' ' . $book['name']. ' ' . $book['release_year'].'</br>'; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

</div>
