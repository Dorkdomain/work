<?php
/**
 * Created by PhpStorm.
 * User: liyu
 * Date: 2016/11/14/0014
 * Time: 下午 4:51
 */
namespace backend\controllers;

use yii;
use backend\models\Kind;
use yii\base\Controller;
use yii\web\NotFoundHttpException;

class KindController extends Controller
{
    public function actionIndex()
    {

    }
    public function actionCreate()
    {
        $model = new Kind();
        $list = $model->getOptions();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
         //   print_r($_POST); die();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
                'list' => $list
            ]);
        }
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    protected function findModel ($id)
    {
        if (($model = Kind::findOne($id)) != null)
            return $model;
        else
            throw new NotFoundHttpException("The requested page does not exist.");
    }
}