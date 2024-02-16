<?php

use common\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var frontend\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var $years */
/** @var $topAuthors */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
$css=<<<CSS
.book-view { 
  border-radius: 15px;
  background-color: Snow;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.pagination > li > a {
    padding:5px;
}
.pagination > li.active > a {
    color:white;
    background-color:#1c84c6;
    padding:5px;
}
CSS;
$this->registerCss($css);
?>
<div class="book-index">

    <?php echo $this->render('report', [
        'model' => $searchModel,
        'topAuthors' => $topAuthors,
        'years' => $years,
    ]); ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['timeout'=>0]); ?>
    <?php echo $this->render('_search', [
        'model' => $searchModel,
        'years' => $years,
    ]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            //return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
            return $this->render('_card',['model'=>$model]);
        },
    ]) ?>

    <?php Pjax::end(); ?>

</div>
