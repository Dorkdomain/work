<?php
/**
 * Created by PhpStorm.
 * User: liyu
 * Date: 2016/11/14/0014
 * Time: 下午 4:16
 */
namespace backend\models;

use yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

class Kind extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%kind}}';
    }

    public function rules()
    {
        return[
            [['id', 'pid'], 'integer'],
            [['name'], 'unique','string', 'max' => 30]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名字',
            'pid' => '父级分类ID',
        ];
    }

    public function getKind() //获取所有分类
    {
        $data = self::find()->asArray()->all();
      //  $data = ArrayHelper::toArray($data);
        return $data;
    }

    public static function getTree ($data, $pid = 0, $lev = 0)
    {
        $tree = array();
        foreach ($data as $value)
        {
            if ($value['pid'] == $pid)
            {
                $value['name'] = str_repeat('|__', $lev).$value['name'];
                $tree[] = $value;
                $tree = array_merge($tree, self::getTree($data, $value['id'], $lev + 1));
            }
        }
        return $tree;
    }

    public function getOptions()
    {
        $data = $this->getKind();
        $tree = $this->getTree($data);
        $list = ['选择分类'];
        foreach ($tree as $value)
        {
            $list[$value['id']] = $value['name'];
        }
        return $list;
    }
}

