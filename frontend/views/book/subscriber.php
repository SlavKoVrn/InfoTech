<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;

/** @var common\models\Subscriber $subscriber */

?>
<div class="subscriber-view">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
        'options' => [
            'style' => 'background-color:#dee2e6;margin-bottom:20px;',
        ]
    ]); ?>

    <div class="row">
        <div class="col col-sm-12">
            <h3>Подписка на уведомления по СМС на новое поступление книг от автора</h3>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-1">
        </div>
        <div class="col col-sm-5">
            <?= $form->field($subscriber, 'name')->textInput() ?>
        </div>
        <div class="col col-sm-4">
            <?= $form->field($subscriber, 'phone')->widget(MaskedInput::class, [
                'mask' => '+7(999)-999-99-99'
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-sm-1">
        </div>
        <div class="col col-sm-9">
            <?= $form->field($subscriber, 'authors')->widget(Select2::class, [
                'data' => $subscriber->getAuthorkNames(),
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
                        'url' => Url::to(['public/authors']),
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
        </div>
        <div class="col col-sm-2">
            <div class="form-group">
                <?= Html::submitButton('Подписаться', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
