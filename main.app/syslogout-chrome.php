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
 <?php 
        dialogbegin('系统提示');    
            print '<h1>请重启您的Chrome方可退出登陆!</h1>                           <!-- ┎─────┒ -->';
            print '<hr/>                                           <!-- ┃对话框内容┃ -->';
            print '下次登陆请重新启动您的Chrome浏览器！                        <!-- ┖─────┚ -->';
         dialogend('FC-System Computer Inc'); 
 ?>    
</center></body>
</html>