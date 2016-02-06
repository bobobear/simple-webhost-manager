<!DOCTYPE html>
<!FC-SYSTEM> <!-- MARKED BY FC-SYSTEM -->
<!-- =========================================
样本文件：对话框样本文件
文本版本：1, 0, 0, 1
字符编码：Unicode UTF-8
程序语言：PHP
编写人员：dfc643(北极光.Norckon)
                         http://www.fcsys.us
========================================== -->
<html>
<?php 
include '../comm.fc/sys-config.php'; //全局设置 
include '../comm.fc/gb-head.php';   //公用HTML头部 
include '../prog.fc/dialog.php';    //对话框函数
?>  
<body class="dialogbody"><center>
    <?php dialogbegin('系统提示'); ?>     <!--   对话框标题   -->
        <h1>您已成功退出登陆!</h1>                           <!-- ┎─────┒ -->                        <!-- ┖─────┚ -->
    <?php dialogend('FC-System Computer Inc'); ?>    
</center></body>
</html>