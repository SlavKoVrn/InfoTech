<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Subscriber $model */

$this->title = 'Изменить: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Подписчики', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="subscriber-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
