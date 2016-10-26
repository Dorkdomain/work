<?php
/**
 * Created by PhpStorm.
 * User: liyu
 * Date: 2016/10/21/0021
 * Time: 下午 5:02
 */

$con = mysqli_connect ('localhost', 'root', '123456', 'icp');
if (!$con)
{
    echo ('Could not connect: '.mysqli_connect_error());
}
mysqli_set_charset ($con, "utf8");

SelectValue (); //筛选功能
ShowTr (); //输出表头

// 获取筛选条件
$op = false;
$DateSt = '';
$DateEnd = '';
if (!(empty($_GET['start'])) && !(empty($_GET['end'])))
{
    $DateSt = date('Y-m-d',strtotime($_GET['start']));
    $DateEnd = date('Y-m-d',strtotime($_GET['end']));
    if (strtotime ($DateEnd) - strtotime ($DateSt) >= 0)
    {
        // echo $DateSt, $DateEnd, "<br>";
        $op = true;
    }
}

if ($op)  //如果有筛选
{
    $sql = "SELECT *FROM db WHERE stime BETWEEN '$DateSt' and '$DateEnd'";
}
else     //如果没有筛选 抓取全部结果
{
    $sql = "SELECT * FROM db";
}
$result = mysqli_query ($con, $sql);

// 分页
$AllNum = mysqli_num_rows ($result); //数据总条数
$PageNum = 18;  //每页数据条数
$PageShow = 10; // 每页页码数
$PageAllNum = ceil ($AllNum / $PageNum); //总页数
$page = empty ($_GET['page']) ? 1 : $_GET['page']; //当前页数
$page = (int)$page;
$LimitStart = ($page - 1) * $PageNum; //起始位置

if ($op)
{
    $sql = "SELECT *FROM db WHERE stime BETWEEN '$DateSt' and
 '$DateEnd' ORDER BY stime ASC limit $LimitStart, $PageNum";
}
else
{
    $sql = "SELECT *FROM db ORDER BY stime DESC limit $LimitStart, $PageNum";
}
$result = mysqli_query ($con, $sql);
//输出数据
while ($row = mysqli_fetch_array($result))
{
    echo "<tr align = 'center'><td>$row[sname]</td><td>$row[nature]</td>
       <td>$row[num]</td><td>$row[url_name]</td>
       <td>$row[url]</td><td>$row[stime]</td></tr>";
}

echo "</table>";
for ($i = 1; $i <= $PageAllNum; $i++)
{
    if ($i == $page)
    {
        $show = "<b>$i</b>";    //当前页 页码加粗
    }
    else
    {
        //if ($op)
        $show = "<a href = 'http://mjj.com?page=".$i."&start=".$DateSt."&end=".$DateEnd."'>$i</a>"; //非当前页面以超链接显示
        //  else
        //    $show = "<a href = 'http://mjj.com?page=".$i."'>$i</a>";
    }
    echo "&nbsp".$show."&nbsp";
}

function ShowTr ()
{
    echo "<table border = '1' cellspacing = '0' bgcolor = #FFFFFF>";
    echo "<tr><th>主办单位名称</th><th>主办单位性质</th><th>许可证号</th>
<th>网络名称</th><th>网络首页地址</th><th>审批时间</th></tr>";
}

function SelectValue ()
{
    echo "<form method = 'get' action = ''>".'起始日期：'
        ."<input type = 'text' name = 'start'>" .'结束日期: '. "<input type = 'text' name = 'end'> 
    <input type = 'submit' value = '确定'> &nbsp&nbsp&nbsp";
}
?>