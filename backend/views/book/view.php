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

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'release_year',
            'name',
            'isbn',
            'description:ntext',
            [
                'format'=>'raw',
                'label'=>'Авторы',
                'value'=>function($model){
                    return implode('<br/>',$model->authorFio);
                }
            ],
            [
                'format'=>'raw',
                'label'=>'Фото главной страницы',
                'value'=>function($model){
                    return Html::img(Yii::$app->getRequest()->getHostInfo().'/upload/'.$model->main_page_photo,[
                        'style' => 'max-width:222px',
                    ]);
                }
            ],
        ],
    ]) ?>

</div>
