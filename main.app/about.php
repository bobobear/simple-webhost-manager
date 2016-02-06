<!DOCTYPE html>
<!FC-SYSTEM> <!-- MARKED BY FC-SYSTEM -->
<!-- =========================================
程序文件：关于系统
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
    <script>
        function fcsystem()
        {
            window.location.href="http://www.fcsys.us/";
        }
    </script>
    <?php dialogbegin('关于 虚拟主机管理系统'); ?>     <!--   对话框标题   -->
        <h1 style="margin-top:10px;">虚拟主机管理系统<font size="2"><small>版本：1.2 build131009</small></font></h1>
        <hr/>
        本程序完美与nginx, Mysql, Php, Filezilla相兼容，运行于微软Windows系列服务器家族操作系统当中，是一款集中化管理虚拟主机的应用程序。<br/><br/>
        程序是开源软件，由FC-System Computer Inc开发与维护，主要项目人(dfc643[北极光.Norckon])参与程序开发与设计。相关源代码可于FC-System官网下载。
    <?php dialogend('<input name="fcsystem" type="button" class="buttonface" onclick="fcsystem()" value="访问 FC-SYSTEM"/>'); ?>
    <br/>
    <center>This System Designed by <a href="http://www.fcsys.us/">FC-System Computer Inc</a></center>
</center></body>
</html>