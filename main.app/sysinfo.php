<!DOCTYPE html>
<!FC-SYSTEM> <!-- MARKED BY FC-SYSTEM -->
<!-- =========================================
程序文件：系统信息
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
    <form action="#" enctype="multipart/form-data" method="post">
        <?php dialogbegin('服务器系统信息'); ?>     <!--   对话框标题   -->
            <table border="0">
                <tr><td width="25%">系统制造商:</td><td>Microsoft Windows</td></tr>
                <tr><td>操作系统:</td><td><?php echo php_uname(); ?></td></tr>
                <tr><td>系统时间:</td><td><?php date_default_timezone_set (PRC); echo date("Y-m-d G:i:s"); ?></td></tr>
                <tr><td>系统目录:</td><td><?php echo $_SERVER['SystemRoot']; ?></td></tr>
                <tr><td>虚拟主机域名:</td><td><?php echo $_SERVER['SERVER_NAME']; ?></td></tr>
                <tr><td>当前进程用户:</td><td><?php echo Get_Current_User(); ?></td></tr>
                <tr><td>本文件路径:</td><td><?php echo __FILE__; ?></td></tr>
            </table>
        <?php dialogend('FC-System Computer Inc'); ?>    
        <br/>
        <?php dialogbegin('PHP环境信息'); ?>     <!--   对话框标题   -->
            <table border="0">
                <tr><td>PHP版本:</td><td  colspan="2">PHP <?php echo PHP_VERSION; ?> @ <?php echo php_sapi_name(); ?></td></tr>
                <tr><td>安装路径:</td><td colspan="2"><?php echo DEFAULT_INCLUDE_PATH; ?></td></tr>
                <tr><td>上传制限:</td><td width="150px"><?PHP echo get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件"; ?></td><td>最大执行时间: <?PHP echo get_cfg_var("max_execution_time")."秒 "; ?></td></tr>
                <tr><td>MySQL支持:</td><td colspan="2"><?php echo function_exists (mysql_close)?"支持MySQL数据库":"不支持MySQL数据库"; ?></td></tr>
                <tr><td>引擎:</td><td colspan="2"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td></tr>
            </table>
        <?php dialogend('FC-System Computer Inc'); ?>   
        <br/> 
        <?php dialogbegin('服务器网络信息'); ?>     <!--   对话框标题   -->
            <table border="0">
                <tr><td>服务器地址:</td><td><?php echo $_SERVER["HTTP_HOST"]; ?> 端口:<?php echo $_SERVER['SERVER_PORT']; ?></td></tr>
                <tr><td>客户机IP地址:</td><td><?php echo GetHostByName($_SERVER['REMOTE_ADDR']); ?></td></tr>
                <tr><td>服务器用户域:</td><td><?php echo $_SERVER['USERDOMAIN']==""?"服务器没有设置Windows域":$_SERVER['USERDOMAIN']; ?></td></tr>
            </table>
        <?php dialogend('FC-System Computer Inc'); ?>   
        <br/>
        <center>This System Designed by <a href="http://www.fcsys.us/">FC-System Computer Inc</a></center>
    </form>
</center></body>
</html>