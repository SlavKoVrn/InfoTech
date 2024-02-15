<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Author $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="author-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'books')->widget(Select2::class, [
        'data' => $model->bookNames,
        'options' => [
            'placeholder' => 'Книги',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 1,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Подождите...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['author/books']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) {return {q:params.term}; }'),
                'delay' => 250,
                'cache' => true,
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(data) {return data.text; }'),
            'templateSelection' => new JsExpression('function (data) {  return data.text; }'),
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
