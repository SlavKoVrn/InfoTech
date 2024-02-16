<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Book $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
