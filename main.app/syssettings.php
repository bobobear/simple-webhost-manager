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

<?php
$xmlDoc = new DOMDocument('1.0', 'UTF-8');      //创建DOM指定编码
$xmlDoc->load("../comm.fc/server-config.xml");  //载入XML配置文件
$appPath=$xmlDoc->getElementsByTagName("path"); //path节点读入
$service=$xmlDoc->getElementsByTagName("service"); //path节点读入
$sqluser=$xmlDoc->getElementsByTagName("mysqluser"); //mysqluser节点读入
?>

<body class="dialogbody"><center>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
        <input name="update" type="hidden" value="go" />
        <?php dialogbegin('系统环境配置'); ?>     <!--   对话框标题   -->
            <table border="0">
                <tr><td>Nginx路径:</td><td><input name="nginxpath" type="text" class="text" size="55" value="<?php echo $appPath->item(0)->getElementsByTagName("nginx")->item(0)->nodeValue; ?>"/></td></tr>
                <tr><td>PHP路径:</td><td><input name="phppath" type="text" class="text" size="55" value="<?php echo $appPath->item(0)->getElementsByTagName("php")->item(0)->nodeValue; ?>"/></td></tr>
                <tr><td>MySQL路径:</td><td><input name="mysqlpath" type="text" class="text" size="55" value="<?php echo $appPath->item(0)->getElementsByTagName("mysql")->item(0)->nodeValue; ?>"/></td></tr>
                <tr><td>Web根路径:</td><td><input name="wwwrootpath" type="text" class="text" size="55" value="<?php echo $appPath->item(0)->getElementsByTagName("wwwroot")->item(0)->nodeValue; ?>"/></td></tr>
                <tr><td>FileZilla:</td><td><input name="filezillapath" type="text" class="text" size="55" value="<?php echo $appPath->item(0)->getElementsByTagName("filezilla")->item(0)->nodeValue; ?>"/></td></tr>
            </table>
        <?php dialogend('<input type="submit" class="buttonface" value="存储设定"/>'); ?>
        <br/>
        <?php dialogbegin('系统服务配置'); ?>     <!--   对话框标题   -->
            <table border="0">
                <tr><td>Nginx服务:</td><td><input name="nginxservice" type="text" class="text" size="55" value="<?php echo $service->item(0)->getElementsByTagName("nginx")->item(0)->nodeValue; ?>"/></td></tr>
                <tr><td>MySQL服务:</td><td><input name="mysqlservice" type="text" class="text" size="55" value="<?php echo $service->item(0)->getElementsByTagName("mysql")->item(0)->nodeValue; ?>"/></td></tr>
                <tr><td>FileZilla:</td><td><input name="filezillaservice" type="text" class="text" size="55" value="<?php echo $service->item(0)->getElementsByTagName("filezilla")->item(0)->nodeValue; ?>"/></td></tr>
            </table>
        <?php dialogend('<input type="submit" class="buttonface" value="存储设定"/>'); ?>
        <br/>
        <?php dialogbegin('MySQL环境配置'); ?>     <!--   对话框标题   -->
            <table border="0">
                <tr><td>服务器地址:</td><td><input name="mysqlserver" type="text" class="text" size="55" value="<?php echo $sqluser->item(0)->getElementsByTagName("server")->item(0)->nodeValue; ?>"/></td></tr>
                <tr><td>服务器端口:</td><td><input name="mysqlport" type="text" class="text" size="55" value="<?php echo $sqluser->item(0)->getElementsByTagName("port")->item(0)->nodeValue; ?>"/></td></tr>
                <tr><td>用户名:</td><td><input name="mysqluser" type="text" class="text" size="55" value="<?php echo $sqluser->item(0)->getElementsByTagName("user")->item(0)->nodeValue; ?>"/></td></tr>
                <tr><td>密码:</td><td><input name="mysqlpassword" type="text" class="text" size="55" value="<?php echo $sqluser->item(0)->getElementsByTagName("password")->item(0)->nodeValue; ?>"/></td></tr>
            </table>
        <?php dialogend('<input type="submit" class="buttonface" value="存储设定"/>'); ?>
        <br/>
        <center>This System Designed by <a href="http://www.fcsys.us/">FC-System Computer Inc</a></center>
    </form>
    <?php
        if("go"==$_POST['update'])
        {
            $appPath->item(0)->getElementsByTagName("nginx")->item(0)->nodeValue=$_POST['nginxpath'];
            $appPath->item(0)->getElementsByTagName("php")->item(0)->nodeValue=$_POST['phppath'];
            $appPath->item(0)->getElementsByTagName("mysql")->item(0)->nodeValue=$_POST['mysqlpath'];
            $appPath->item(0)->getElementsByTagName("wwwroot")->item(0)->nodeValue=$_POST['wwwrootpath'];
            $appPath->item(0)->getElementsByTagName("filezilla")->item(0)->nodeValue=$_POST['filezillapath'];
            $service->item(0)->getElementsByTagName("nginx")->item(0)->nodeValue=$_POST['nginxservice'];
            $service->item(0)->getElementsByTagName("mysql")->item(0)->nodeValue=$_POST['mysqlservice'];
            $service->item(0)->getElementsByTagName("filezilla")->item(0)->nodeValue=$_POST['filezillaservice'];
            $sqluser->item(0)->getElementsByTagName("server")->item(0)->nodeValue=$_POST['mysqlserver'];
            $sqluser->item(0)->getElementsByTagName("port")->item(0)->nodeValue=$_POST['mysqlport'];
            $sqluser->item(0)->getElementsByTagName("user")->item(0)->nodeValue=$_POST['mysqluser'];
            $sqluser->item(0)->getElementsByTagName("password")->item(0)->nodeValue=$_POST['mysqlpassword'];
            $xmlDoc->save("../comm.fc/server-config.xml"); //保存设置
            echo '<SCRIPT>alert("设置已经保存！");window.location.href="'.$_SERVER['PHP_SELF'].'";</SCRIPT>'; //提示信息并刷新
        }
    ?>
</center></body>
</html>