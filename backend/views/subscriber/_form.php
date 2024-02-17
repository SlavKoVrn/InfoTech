<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var common\models\Subscriber $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="subscriber-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
        'mask' => '+7(999)-999-99-99'
    ]); ?>

    <?= $form->field($model, 'authors')->widget(Select2::class, [
        'data' => $model->getAuthorkNames(),
        'options' => [
            'placeholder' => 'Авторы',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 1,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Подождите...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['book/authors']),
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
