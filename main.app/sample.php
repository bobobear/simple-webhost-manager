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
include '../prog.fc/daolian.php';    //防盗链功能
?>  
<body class="dialogbody"><center>
    <form action="Sample.action" enctype="multipart/form-data" method="post">
        <?php dialogbegin('欢迎来到Kitty的世界！'); ?>     <!--   对话框标题   -->
            <h1>Hello Kitty!</h1>                           <!-- ┎─────┒ -->
            <hr/>                                           <!-- ┃对话框内容┃ -->
            FC-System Computer Inc.                         <!-- ┖─────┚ -->
        <?php dialogend('
            <input name="Custom1" type="button" class="button" value="自定义按钮1">      <!-- ┎─────┒ -->
            <input name="Custom2" type="button" class="button" value="自定义按钮2">      <!-- ┃按钮区内容┃ -->
            <input name="forDetail" type="button" class="button" value="现在就去了解">   <!-- ┖─────┚ -->
        '); ?>    
    </form>
</center></body>
</html>