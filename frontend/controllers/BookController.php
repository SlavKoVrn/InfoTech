<?php

namespace frontend\controllers;

use common\models\Book;
use common\models\Author;
use common\models\Subscriber;
use frontend\models\BookSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $years = Book::find()
            ->distinct('release_year')
            ->orderBy('release_year DESC')
            ->all();
        $years = ArrayHelper::map($years,'release_year','release_year');
        $years = ArrayHelper::merge([''=>'Весь период'],$years);

        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $query = Author::find()
            ->select(['authors.id', 'authors.fio', 'COUNT(books.id) as book_count'])
            ->innerJoinWith('currentBooks')
            ->groupBy('authors.id')
            ->orderBy('book_count DESC')
            ->limit(10);

        if ($searchModel->release_year ?? false){
            $query->andWhere(['books.release_year' => $searchModel->release_year]);
        }
        $topAuthors = $query->asArray()->all();

        $subscriber = new Subscriber;
        if ($this->request->isPost and $subscriber->load($this->request->post()) and $subscriber->validate()) {
            $subscriberExists = Subscriber::find()->where(['phone'=>$subscriber->phone])->one();
            if ($subscriberExists){
                Yii::$app->session->addFlash('warning', $subscriber->humanPhone.' Подписка уже зарегистрирована на '.$subscriber->name);
            } elseif ($subscriber->save()) {
                Yii::$app->session->addFlash('success', $subscriber->humanPhone.' Подписка зарегистрирована');
            }
            $subscriber = new Subscriber;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'years' => $years,
            'topAuthors' => $topAuthors,
            'subscriber' => $subscriber,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param int $id Ид
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Ид
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
