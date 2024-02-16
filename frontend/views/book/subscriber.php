<?php
use frontend\models\BookSearch;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

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
            <h3>Подписка на уведомления по СМС на новое поступление книг</h3>
        </div>
    </div>
    <div class="row" style="margin-bottom: 20px">
        <div class="col col-sm-1">
        </div>
        <div class="col col-sm-3">
            <?= $form->field($subscriber, 'name')->textInput() ?>
        </div>
        <div class="col col-sm-3">
            <?= $form->field($subscriber, 'phone')->widget(MaskedInput::class, [
                'mask' => '+7(999)-999-99-99'
            ]) ?>
        </div>
        <div class="col col-sm-3">
            <div class="form-group">
                <?= Html::submitButton('Подписаться', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
