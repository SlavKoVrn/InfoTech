<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Subscriber $model */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Подписчики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscriber-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
