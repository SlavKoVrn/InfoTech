<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Book $model */

\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h3><?= Html::a(Html::encode($model->name), ['view', 'id' => $model->id],[
            'style' => 'text-decoration:none;'
        ]) ?></h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'format'=>'raw',
                'label'=>'Фото главной страницы',
                'value'=>function($model){
                    return Html::img(Yii::$app->getRequest()->getHostInfo().'/upload/'.$model->main_page_photo,[
                        'style' => 'max-width:222px',
                    ]);
                }
            ],
            'name',
            'description:ntext',
            'isbn',
            'release_year',
        ],
    ]) ?>

</div>
