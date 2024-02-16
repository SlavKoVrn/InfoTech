<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\BookSearch $model */
/** @var yii\widgets\ActiveForm $form */
/** @var $years */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col col-sm-3">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col col-sm-3">
            <?= $form->field($model, 'isbn') ?>
        </div>
        <div class="col col-sm-3">
            <?= $form->field($model, 'release_year')->dropDownList($years) ?>
        </div>
        <div class="col col-sm-3">
            <div class="form-group">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Сброс', ['class' => 'btn btn-outline-secondary','onclick' => 'document.location.href=\'/\';']) ?>
            </div>
        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>
