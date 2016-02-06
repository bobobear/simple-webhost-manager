<!DOCTYPE html>
<!FC-SYSTEM> <!-- MARKED BY FC-SYSTEM -->
<!-- =========================================
样本文件：服务控制
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

<?php
$xmlDoc = new DOMDocument('1.0', 'UTF-8');      //创建DOM指定编码
$xmlDoc->load("../comm.fc/server-config.xml");  //载入XML配置文件
$service=$xmlDoc->getElementsByTagName("service"); //services节点读入
?>

<body class="dialogbody"><center>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
        <?php dialogbegin('服务控制'); ?>     <!--   对话框标题   -->
            <table border="0">
                <tr>
                    <td>nginx服务:</td>
                    <td>
                        <input name="nginx" type="submit" class="buttonface" value="启动">
                        <input name="nginx" type="submit" class="buttonface" value="停止">
                        <input name="nginx" type="submit" class="buttonface" value="重启">  
                    </td>
                </tr>
                <tr>
                    <td>MySQL服务:</td>
                    <td>
                        <input name="mysql" type="submit" class="buttonface" value="启动">
                        <input name="mysql" type="submit" class="buttonface" value="停止">
                        <input name="mysql" type="submit" class="buttonface" value="重启">  
                    </td>
                </tr>
                <tr>
                    <td>FileZilla服务:</td>
                    <td>
                        <input name="filezilla" type="submit" class="buttonface" value="启动">
                        <input name="filezilla" type="submit" class="buttonface" value="停止">
                        <input name="filezilla" type="submit" class="buttonface" value="重启">  
                    </td>
                </tr>
            </table>
        <?php dialogend('FC-System Computer Inc.'); ?>    
    </form>
    <?php
        if(function_exists(win32_start_service))
        {
            switch($_POST['nginx'])
            {
                case '启动': win32_start_service($service->item(0)->getElementsByTagName("nginx")->item(0)->nodeValue); echo '<SCRIPT>alert("Nginx启动命令执行完成")</SCRIPT>'; break;
                case '停止': win32_stop_service($service->item(0)->getElementsByTagName("nginx")->item(0)->nodeValue); 
                             system('taskkill /f /im nginx.exe');
                             system('taskkill /f /im xxfpm.exe');
                             system('taskkill /f /im php-cgi.exe');
                             echo '<SCRIPT>alert("Nginx停止命令执行完成")</SCRIPT>'; break;
                case '重启': win32_stop_service($service->item(0)->getElementsByTagName("nginx")->item(0)->nodeValue); 
                             system('taskkill /f /im nginx.exe');
                             //system('taskkill /f /im xxfpm.exe'); //不能关闭PHP，不然不能自动了
                             //system('taskkill /f /im php-cgi.exe');
                             win32_start_service($service->item(0)->getElementsByTagName("nginx")->item(0)->nodeValue); 
                             echo '<SCRIPT>alert("Nginx重启命令执行完成，稍等5秒后手动刷新页面")</SCRIPT>'; break;
                default: break;
            }
            switch($_POST['mysql'])
            {
                case '启动': win32_start_service($service->item(0)->getElementsByTagName("mysql")->item(0)->nodeValue); echo '<SCRIPT>alert("MySQL启动命令执行完成")</SCRIPT>'; break;
                case '停止': win32_stop_service($service->item(0)->getElementsByTagName("mysql")->item(0)->nodeValue); echo '<SCRIPT>alert("MySQL停止命令执行完成")</SCRIPT>'; break;
                case '重启': win32_restart_service($service->item(0)->getElementsByTagName("mysql")->item(0)->nodeValue); echo '<SCRIPT>alert("MySQL重启命令执行完成")</SCRIPT>'; break;
                default: break;
            }
            switch($_POST['filezilla'])
            {
                case '启动': win32_start_service($service->item(0)->getElementsByTagName("filezilla")->item(0)->nodeValue); echo '<SCRIPT>alert("FileZilla启动命令执行完成")</SCRIPT>'; break;
                case '停止': win32_stop_service($service->item(0)->getElementsByTagName("filezilla")->item(0)->nodeValue); echo '<SCRIPT>alert("FileZilla停止命令执行完成")</SCRIPT>'; break;
                case '重启': win32_stop_service($service->item(0)->getElementsByTagName("filezilla")->item(0)->nodeValue); sleep(5); win32_start_service($service->item(0)->getElementsByTagName("filezilla")->item(0)->nodeValue); echo '<SCRIPT>alert("FileZilla重启命令执行完成")</SCRIPT>'; break;
                default: break;
            }
        }
        else
        {
            echo '<hr/>您的服务器没有为PHP安装<b>win32service</b>扩展库，请前往PHP官方站点<a href="http://pecl.php.net/package/win32service">下载安装</a>至php的ext目录当中，并注意要在php.ini中添加<b>extension=php_win32service.dll;</b>语句，最后重新启动nginx生效！<u>注意：请核对好PHP版本</u>';
        }
    ?>
</center></body>
</html>