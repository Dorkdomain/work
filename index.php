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
$PageNext = ($page == $PageAllNum) ? $PageAllNum : $page + 1;
$PagePre = ($page == 1) ? 1 : $page - 1;

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

//显示页码

$Urlpre = 'http://localhost:63342/new/index.php';
$url = "&start=".$DateSt."&end=".$DateEnd."";
$PageNav = "第 $page/$PageAllNum 页 共 $AllNum 条记录  ";
$PageNav .= "<a href = '$Urlpre?page=1$url'>首页</a>"."  ";
$PageNav .= "<a href = '$Urlpre?page=$PagePre$url'>前一页</a>"."  ";
$PageShowStart = (ceil($page / $PageShow) - 1) * $PageShow;

$PageShowStr = '';
if ($PageShow > $PageAllNum)   //如果每页展示的页码数大于总页数
{
    $PageShow = $PageAllNum;
}

for ($i = 1; $i <= $PageShow; $i++)   //显示页码
{
    $PageShowNow = $PageShowStart + $i;
    if ($PageShowNow > $PageAllNum)
    {
        break;
    }
    if ($page == $PageShowNow)    //当前页加粗显示
    {
        $PageShowStr .= "<a href = '$Urlpre?page=$PageShowNow$url'>
                <strong>$PageShowNow</strong></a>" ."  ";
    }
    else
    {
        $PageShowStr .= "<a href = '$Urlpre?page=$PageShowNow$url'>$PageShowNow</a>" ."  ";
    }
}
$PageNav .= $PageShowStr;
$PageNav .= "<a href = '$Urlpre?page=$PageNext$url'>后一页</a>" ."  ";
$PageNav .= "<a href = '$Urlpre?page=$PageAllNum$url'>末页</a>"."  ";
$PageNav .= " 跳到<select name = 'top' size = '1' 
onchange = 'window.location = this.value'>";

for ($j = 1; $j <= $PageAllNum; $j++)  //跳转页面的每个值
{
    if ($j == $page)
    {
        $PageNav .= "<option value = '$Urlpre?page=$j$url' selected>$j</option>";
    }
    else
    {
        $PageNav .= "<option value = '$Urlpre?page=$j$url'>$j</option>";
    }
}
$PageNav .= '</select>';
echo '<div class = "pages">' .$PageNav .'</div>';

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
    $SolUrl = 'http://localhost:63342/new/6.php';
  //  echo "<input type = 'submit' name = 'update' value = '更新数据' onclick = javascript:window.location.href = $SolUrl>";
//    <script language = 'JavaScript'> function open() {window.location.href = $SolUrl;}</script>;
//    echo  "<a href = 'http://localhost:63342/new/6.php'><button class = 'button' id = 'update'>更新数据</button></a>";
// <button class = 'button' id = 'update'>更新数据</button>
    echo "<a href = $SolUrl style = 'text-decoration:none'><input type = 'button' value = '更新数据'></a>";
}
?>