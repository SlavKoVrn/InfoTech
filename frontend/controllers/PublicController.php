<?php

namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Response;

class PublicController extends \yii\web\Controller
{
    public function actionAuthors() {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $q = Yii::$app->request->get('q');
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = (new Query)
                ->select('id, fio AS text')
                ->from('authors')
                ->where(['like', 'fio', $q]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }
}
