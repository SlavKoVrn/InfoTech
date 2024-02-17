<?php

namespace backend\controllers;

use common\models\Sms;
use common\models\SmsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SmsController implements the CRUD actions for Sms model.
 */
class SmsController extends Controller
{
    /**
     * Lists all Sms models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SmsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
