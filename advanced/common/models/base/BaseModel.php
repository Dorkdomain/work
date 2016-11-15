<?php
/**
 * Created by PhpStorm.
 * User: liyu
 * Date: 2016/11/11/0011
 * Time: 上午 11:49
 */
namespace common\models\base;

use Yii;
use yii\db\ActiveRecord;

//重写数据基类

class BaseModel extends ActiveRecord
{
    public function getPages($query, $curPage=1, $pageSize=10,$search=null)
    {
        if ($search)
            $query = $query->andFilterWhere($search);

        $data['count']=$query->count();
        if (!$data['count'])
            return ['count'=>0, 'curPage'=>$curPage, 'pageSize'=>$pageSize, 'start'=>0, 'end'=>0, 'data'=>[]];
        $curPage=(ceil($data['count']/$pageSize)<$curPage)?ceil($data['count']/$pageSize):$curPage;

        $date['curPage'] = $curPage;
        //每页显示条数
        $data['pageSize'] = $pageSize;
        //起始页
        $data['start'] = ($curPage-1)*$pageSize+1;
        //末页
        $data['end'] = (ceil($data['count']/$pageSize) == $curPage)?$data['count']:($curPage-1)*$pageSize+$pageSize;
        //数据
        $data['data'] = $query->offset(($curPage-1)*$pageSize)->limit($pageSize)->asArray()->all();
        return $data;
    }
}