<?php

namespace backend\controllers;

use Yii;
use common\models\AuthItem;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use backend\models\AuthItemForm;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 */
class AuthItemController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        /* //源码
        $dataProvider = new ActiveDataProvider([
            'query' => AuthItem::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);*/
        $model = new AuthItem();
        //分页
        $curPage = Yii::$app->request->get('page', 1);
        $pageSize = 10;

        //搜索
        $type = Yii::$app->request->get('type', '');
        $value = Yii::$app->request->get('value', '');
        $search = ($type&&$value)?['like', $type, $value]:'';

        //查询语句
        $query = $model->find()->orderBy('created_at DESC');
        $data = $model->getPages($query, $curPage, $pageSize, $search);
        $pages = new Pagination(['totalCount' => $data['count'], 'pageSize' => $pageSize]);

        return $this->render('index', ['pages' =>$pages, 'data' => $data]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /*$model = new AuthItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
        $model = new AuthItemForm();
        //设置场景
        $model->setScenario(AuthItemForm:: SCENARIOS_CREATE);
        //加载数据以及调用创建方法
        if ($model->load(Yii:: $app-> request->post())) {
            if($model->validate()){
                $model->addAuthItem();
                return $this->redirect([ 'view', 'id' => $model->name]);
            }
        }

        return $this->render( 'create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       /* $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/
        $model = new AuthItemForm();
        $model = $model-> getAuthItem($id);
        //设置场景
        $model->setScenario(AuthItemForm:: SCENARIOS_UPDATE);
        if ($model->load(Yii:: $app-> request->post())) {
            if($model->validate()){
                $model->updateAuthItem($id);
                return $this->redirect([ 'view', 'id' => $model->name]);
            }
        }

        return $this->render( 'update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /*$this->findModel($id)->delete();

        return $this->redirect(['index']);*/
        $model = new AuthItemForm();
        $model->setScenario(AuthItemForm:: SCENARIOS_DELETE);
        $model-> name = Yii:: $app-> request->post( 'id');
        $res =  $model->removeAuthItem();
        if(!$res)
            return Json:: encode(['status'=>false,'msg'=>'删除失败！']);

        return Json::encode(['status' =>true]);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
