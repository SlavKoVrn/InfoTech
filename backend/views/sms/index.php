<?php

use common\helpers\Helper;
use common\models\Sms;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\SmsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'СМС';
$this->params['breadcrumbs'][] = $this->title;
$css =<<<CSS
tr.warning{
    background-color:#fcf8e3 !important;
}
tr.danger{
    background-color:#f2dede !important;
}
tr.success{
    background-color:#dff0d8 !important;
}
CSS;
$this->registerCss($css);
?>
<div class="sms-index">

    <?php Pjax::begin(['timeout' => 0]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model){
            if($model->status == Sms::STATUS_NOT_SEND){
                return ['class' => 'warning'];
            }
            if($model->status == Sms::STATUS_ERROR){
                return ['class' => 'danger'];
            }
            if ($model->status == Sms::STATUS_SEND){
                return ['class' => 'success'];
            }
        },
        'columns' => [
            [
                'filter'=>false,
                'attribute' => 'subscriber_id',
                'content' => function($model){
                    return $model->subscriber->name;
                }
            ],
            [
                'filter'=>Sms::getStatusesArray(),
                'attribute' => 'status',
                'content' => function($model){
                    return $model->statuses[$model->status];
                }
            ],
            [
                'attribute' => 'phone',
                'content' => function($model){
                    return Helper::humanPhone($model->phone);
                }
            ],
            'text:ntext',
            [
                'filter'=>false,
                'attribute' => 'created_at',
                'content' => function($model){
                    return date('d.m.Y H:i',strtotime($model->created_at));
                }
            ],
            [
                'filter'=>false,
                'attribute' => 'updated_at',
                'content' => function($model){
                    return date('d.m.Y H:i',strtotime($model->updated_at));
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
