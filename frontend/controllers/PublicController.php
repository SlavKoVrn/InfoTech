<?php

namespace frontend\controllers;

use common\helpers\Helper;
use Yii;
use yii\web\Response;

class PublicController extends \yii\web\Controller
{
    public function actionAuthors() {

        Yii::$app->response->format = Response::FORMAT_JSON;

        return Helper::findAuthorsBySubstring(Yii::$app->request->get('q'));
    }
}
