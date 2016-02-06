<?php
/*================================
函数功能：防止用户直接输入URL
函数名称：daolian
调用方式：include '本文件';
---------------------------------
函数编写：dfc643(北极光.Norckon)
编写日期：2013年10月4日（五）
            http://www.fcsys.us
================================*/
include '../comm.fc/sys-config.php';  //从全局变量中控制是否开启防盗链
function daolian($daolian)
{
    if(1==$daolian)
    echo '<script>if(window.parent == window) window.location.href="http://www.fcsys.us";</script>';
}
daolian($daolian); //执行一遍
?>