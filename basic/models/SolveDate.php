<?php
/**
 * Created by PhpStorm.
 * User: liyu
 * Date: 2016/10/31/0031
 * Time: 下午 4:48
 */
namespace app\models;
use yii\db\ActiveRecord;
use yii;

class SolveDate extends ActiveRecord
{
    public function getDateAllNum ($date_start, $date_end, $op)
    {
        if ($op)  //如果有筛选
            $sql = "SELECT COUNT(*) FROM dbs WHERE stime BETWEEN '$date_start' and '$date_end'";
        else     //如果没有筛选 抓取全部结果
            $sql = "SELECT COUNT(*) FROM dbs";

        $date_all_num = Yii::$app->db->createCommand ($sql)->queryScalar();
        return $date_all_num;
    }

    public function getDate ($page, $date_start, $date_end, $op, $page_num)
    {
        $limit_start = ($page - 1) * $page_num; //起始位置
        if ($op)  //如果有筛选
            $sql = "SELECT *FROM dbs WHERE stime BETWEEN '$date_start' and '$date_end' 
                 ORDER BY stime ASC limit $limit_start, $page_num";
        else     //如果没有筛选 抓取全部结果
            $sql = "SELECT * FROM dbs ORDER BY stime DESC limit $limit_start, $page_num";

        $result = Yii::$app->db->createCommand ($sql)->queryAll();
     //   var_dump(mysqli_error());
        return $result;
    }
}