<?php
//
$StringArea = "京 津 渝 沪 冀 晋 辽 吉 黑 苏 浙 皖 闽 赣 鲁 豫 鄂 湘 粤 琼 川 贵 云 陕 甘 青 台 桂 宁 新 藏 港 澳";
$area = explode (" ", $StringArea);
$AreaNum = count ($area);

//获取备案号
for ($i = 0; $i < $AreaNum; $i++)
{
    $nu = $area["$i"].'ICP备16';
    for ($j = 0; $j <= 200; $j++)
    {
        $temp = sprintf ("%06d", $j);  //生成六位序列号
        $num = $nu.$temp.'号';       //拼接成许可证号
        SolveArr (GetArr($num));
    }
}
//$num = '豫ICP备14018944号';
//SolveArr (GetArr($num));
function GetArr ($num)  //将网页中td中的信息抓取到$arr中
{
    ini_set ('max_execution_time', 300);
    $fp = file_get_contents ("http://www.beianbeian.com/s?keytype=1&q=$num");
    $fp = preg_replace ("/[\t\n\r]+/","",$fp);   //去掉换行制表符等特殊字符
    $prep = "/<td[^>]*?>(.*?)<\/td>/s";   //匹配td内容的正则表达式
    preg_match_all($prep,$fp,$arr);    //抓取td内容
    return $arr;
}

function SolveArr ($arr)  //将td中有用的信息提取出来
{
    $ArrNum = count ($arr["0"]);
    if ($ArrNum > 18)   //如果对应许可证号存在备案信息
    {
        $num = ($ArrNum - 12) / 8;    //计算该许可证号下有几个备案信息
        for ($i = 0; $i < $num; $i++)
        {
         //   if ( trim($arr[0][8+8*$i]) != '') //已经划去的网站暂时不知道如何过滤
            WriteDate ($arr, $i);     //写入数据库
        }
    }
}

function WriteDate ($arr, $i)
{
    //获取想要的值
    $sname = trim (strip_tags($arr[0][9+8*$i]));
    $nature = trim (strip_tags($arr[0][10+8*$i]));
    $num = trim (substr (strip_tags ($arr[0][11+8*$i]), 0, 53));
    $url_name = trim (strip_tags($arr[0][12+8*$i]));
    $url = trim (strip_tags($arr[0][13+8*$i]));
    $stime = trim (strip_tags($arr[0][14+8*$i]));

 //   echo $sname ,$nature, $num, $url_name, $url, $stime, "<br>";
    $con = mysqli_connect ('localhost', 'root', '123456', 'icp');
    if (!$con)
    {
        echo ('Could not connect: ' .mysqli_connect_error());
    }
    mysqli_set_charset ($con, "utf8");   //设置编码方式防止乱码
    mysqli_query ($con, "INSERT INTO db (sname, nature, num, url_name, url, stime)
 VALUES ('$sname' ,'$nature', '$num', '$url_name', '$url', '$stime')");
   // var_dump(mysqli_error($con));
    mysqli_close ($con);
}
?>


