<!DOCTYPE html>
<!FC-SYSTEM> <!-- MARKED BY FC-SYSTEM -->
<!-- =========================================
程序文件：退出系统
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
include 'syslogin.php';             //用户验证功能
?>  

<body class="dialogbody"><center>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php dialogbegin('退出系统'); ?>     <!--   对话框标题   -->
    真的要退出系统吗？
<?php dialogend('<input name="syslogout" type="submit" class="buttonface" value="退出系统"/>'); ?>
<br/>
<center>This System Designed by <a href="http://www.fcsys.us/">FC-System Computer Inc</a></center>
</form>
</center></body>

<?php
    if($_POST['syslogout']=="退出系统")
    {
        unset($_SESSION['FC_GOODJOU']);
        echo '<SCRIPT>window.top.location.href="syslogout-other.php"</SCRIPT>';
    }
?>
</html>