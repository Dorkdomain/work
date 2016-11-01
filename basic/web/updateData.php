<?php

$flag = false;

function GetArr()  //将网页中td中的信息抓取到$arr中
{
    ini_set('max_execution_time', 300);
    for ($i = 1; $i < 100; $i++)
    {
        $fp = file_get_contents("http://www.icp123.net/newlist-$i.php");
        $fp = preg_replace("/[\t\n\r]+/", "", $fp);   //去掉换行制表符等特殊字符
        $prep = "/<td[^>]*?>(.*?)<\/td>/s";   //匹配td内容的正则表达式
        preg_match_all($prep, $fp, $arr);    //抓取td内容
        $ArrNum = count ($arr["0"]);
        for ($j = 0; $j < 80; $j++)
        {
            global $flag;
            if ($flag)
            {
                return;
            }
            if (9 + 7 * $j > $ArrNum)  //如果数组越界
            {
                break;
            }
            WriteDate($arr, $j);     //写入数据库
        }
    }
}

function WriteDate($arr, $j)
{
    //获取想要的值
    global $flag;
    $sname = trim(strip_tags($arr[0][9 + 7 * $j]));
    $nature = trim(strip_tags($arr[0][10 + 7 * $j]));
    $num = trim(substr(strip_tags($arr[0][11 + 7 * $j]), 0, 53));
    $url_name = trim(strip_tags($arr[0][12 + 7 * $j]));
    $url = trim(strip_tags($arr[0][13 + 7 * $j]));
    $stime = trim(strip_tags($arr[0][14 + 7 * $j]));

// echo $sname ,$nature, $num, $url_name, $url, $stime, "<br>";

    $con = mysqli_connect('localhost', 'root', '123456', 'icp');
    mysqli_set_charset($con, "utf8");   //设置编码方式防止乱码
    if ($stime != date("Y-m-d"))   //如果今天的信息已经获取完毕
    {
        $flag = true;
        mysqli_close($con);
        return;
    }

    if (!$con)
    {
        echo('Could not connect: ' . mysqli_connect_error());
    }

    $sql = "SELECT num FROM dbs WHERE num = '$num'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows ($result) > 0)   //如果结果已经存在
    {
        $flag = true;
        mysqli_close($con);
        return;
    }
    mysqli_query($con, "INSERT INTO dbs (sname, nature, num, url_name, url, stime)
 VALUES ('$sname' ,'$nature', '$num', '$url_name', '$url', '$stime')");
 //   var_dump(mysqli_error());
 //   echo 1111111111111111111111111111111111111111111;
    mysqli_close($con);
}

function finish ()
{
    echo "<script language = 'JavaScript'>;alert('更新完成');
location.href ='http://localhost/basic/web/index.php?r=dbs/index';</script>";
}

GetArr();
finish();
?>