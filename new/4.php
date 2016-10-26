<?php

header('content-type:text/html;charset=utf-8;');

//分页

$page=$_GET['page'];
$allcount= 200;
$page_size =5;
$page_show =5;
$page_count = ceil($allcount/$page_size);
if($page <= 1 || $page == '') $page = 1;
if($page >= $page_count) $page = $page_count;
$select_limit = $page_size;
$select_from = ($page - 1) * $page_size.',';
$pre_page = ($page == 1)? 1 : $page - 1;
$next_page= ($page == $page_count)? $page_count : $page + 1 ;
$pagenav .= "第 $page/$page_count 页 共 $rows 条记录 ";
$pagenav .= "<a href='?page=1'>首页</a> ";
$pagenav .= "<a href='?page=$pre_page'>前一页</a> ";
//当前显示的开始也
$page_show_start = (ceil($page/$page_show)-1)*$page_show;
//显示分页
$page_show_str = '';
if($page_show>$page_count){
    $page_show = $page_count;
}
for($j=0;$j<=$page_show;$j++){
    $page_show_now = $page_show_start+$j;
    if($page==$page_show_now){
        $page_show_str .= "<a href='?page=$page_show_now'><strong>$page_show_now</strong></a> ";
    }else{
        $page_show_str .= "<a href='?page=$page_show_now'>$page_show_now</a> ";
    }
}
$pagenav.=$page_show_str;
$pagenav .= "<a href='?page=$next_page'>后一页</a> ";
$pagenav .= "<a href='?page=$page_count'>末页</a>";
$pagenav.="　跳到<select name='topage' size='1' onchange='window.location="?page="+this.value'>";
for($i=1;$i<=$page_count;$i++){
    if($i==$page) $pagenav.="<option value='$i' selected>$i</option>";
    else $pagenav.="<option value='$i'>$i</option>";
}
$pagenav .='</select>';
echo '<div class="pages">'.$pagenav.'</div>' ;
?>