<?php
/**
 * Created by PhpStorm.
 * User: liyu
 * Date: 2016/10/31/0031
 * Time: 下午 7:26
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
?>

<?php $form = ActiveForm::begin(['method'=>'GET',]); ?>
开始日期：<input type = 'date' name = 'date_start'/>&nbsp&nbsp
结束日期：<input type = 'date' name = 'date_end'/>&nbsp&nbsp
<input type = 'submit' />
<a href = updateDate.php style = 'text-decoration:none'>
    <input type = 'button' value = '更新数据'></a>
<br />
<div class="from-group">
    <table border="1" cellpadding="3" cellspacing="1" width="100%" align="center" style="background-color: #b9d8f3;">
        <tr style="text-align: center; COLOR: #0076C8; BACKGROUND-COLOR: #F4FAFF; font-weight: bold">
            <td width="20%" align="center"><b>主办单位名称</b></td>
            <td width="10%" align="center"><b>主办单位性质</b></td>
            <td width="15%" align="center"><b>网站备案/许可证号</b></td>
            <td width="23%" align="center"><b>网站名称</b></td>
            <td width="17%" align="center"><b>网站首页网址</b></td>
            <td align="center"><b>审核时间</b></td>
        </tr>
        <?php
        foreach($result as $row)
        {
            echo '<tr style="text-align: center; COLOR: #0076C8; BACKGROUND-COLOR: #F4FAFF; font-weight: bold">';
            echo "<td>".$row['sname']."</td>";
            echo "<td>".$row['nature']."</td>";
            echo "<td>".$row['num']."</td>";
            echo "<td>".$row['url_name']."</td>";
            echo "<td>".$row['url']."</td>";
            echo "<td>".$row['stime']."</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
<?php ActiveForm::end();?>
<div class='fy'>
    <?= LinkPager::widget(['pagination' => $pages,
        'firstPageLabel' => '首页',
        'lastPageLabel' => '最后一页',
        'prevPageLabel' => '上一页',
        'nextPageLabel' => '下一页',
        'maxButtonCount'=>5,])?>
    </div>