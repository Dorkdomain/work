<?php
/**
 * Created by PhpStorm.
 * User: liyu
 * Date: 2016/10/31/0031
 * Time: 下午 5:44
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\SolveDate;
use yii\data\Pagination;

class DbsController extends Controller
{
    public function actionIndex()
    {
        $op = false;
        $page_num = 18;
        $page = Yii::$app->request->get('page', 1);
        $date_start = Yii::$app->request->get('date_start', null);
        $date_end = Yii::$app->request->get('date_end', null);
        if ($date_start != null && $date_end != null)
        {
            if (strtotime ($date_end) - strtotime ($date_start) >= 0)
                $op = true;
        }
        $model = new SolveDate();
        $result = $model->getDate ($page, $date_start, $date_end, $op, $page_num);
        $date_all_num = $model->getDateAllNum ($date_start, $date_end, $op);
        $pages = new Pagination(['totalCount'=>$date_all_num, 'pageSize'=>$page_num]);
        return $this->render('test', ['result'=>$result, 'pages'=>$pages,]);
    }
}