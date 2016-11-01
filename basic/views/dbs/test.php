<?php
/**
 * Created by PhpStorm.
 * User: liyu
 * Date: 2016/10/31/0031
 * Time: 下午 7:26
 */
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

?>

<?php $form = ActiveForm::begin(['method' => 'GET',]);  ?>


开始日期：<input type='date' name='date_start'/>&nbsp&nbsp
结束日期：<input type='date' name='date_end'/>&nbsp&nbsp
<input type='submit'/>
<a href = updateData.php style='text-decoration:none'>
    <input type='button' value='更新数据'></a>
<br/>

<table border="1" cellspacing = '0' bgcolor = #FFFFFF">
    <tr>
        <td width="25%" align="center"><b>主办单位名称</b></td>
        <td width="8%" align="center"><b>主办单位性质</b></td>
        <td width="15%" align="center"><b>许可证号</b></td>
        <td width="25%" align="center"><b>网站名称</b></td>
        <td width="15%" align="center"><b>网站首页网址</b></td>
        <td align="center"><b>审核时间</b></td>
    </tr>
    <?php
    foreach ($result as $row) {
        echo '<tr style="text-align: center";>';
        echo "<td>" . $row['sname'] . "</td>";
        echo "<td>" . $row['nature'] . "</td>";
        echo "<td>" . $row['num'] . "</td>";
        echo "<td>" . $row['url_name'] . "</td>";
        echo "<td>" . $row['url'] . "</td>";
        echo "<td>" . $row['stime'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

    <div class='fy'>
        <?= LinkPager::widget(['pagination' => $pages,
            'firstPageLabel' => '首页',
            'lastPageLabel' => '最后一页',
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'maxButtonCount'=>5,])?>
    </div>
<?php ActiveForm::end();?>

