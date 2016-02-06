<!DOCTYPE html>
<!FC-SYSTEM> <!-- MARKED BY FC-SYSTEM -->
<!-- =========================================
样本文件：删除用户
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
$xmlDoc=new DOMDocument('1.0','UTF-8');         //创建DOM指定编码
$xmlDoc->load('../comm.fc/server-users.xml');   //载入XML配置文件
$usertotal=$xmlDoc->getElementsbyTagName('usertotal')->item(0)->nodeValue;        //读取用户总数
$user=$xmlDoc->getElementsbyTagName('user');    //user节点读入
?>

<?php
$xmlDoc2 = new DOMDocument('1.0', 'UTF-8');      //创建DOM指定编码
$xmlDoc2->load("../comm.fc/server-config.xml");  //载入XML配置文件
$appPath=$xmlDoc2->getElementsByTagName("path"); //path节点读入
$service=$xmlDoc2->getElementsByTagName("service"); //path节点读入
$sqluser=$xmlDoc2->getElementsByTagName("mysqluser"); //mysqluser节点读入
?>

<body class="dialogbody"><center>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="POST">
        <input name="update" type="hidden" value="go" />
        <?php dialogbegin('删除用户'); ?>     <!--   对话框标题   -->
            <table border="0">
                <tr><td>用户列表:</td><td><select name="userid">
                    <?php 
                        if($_POST['search']=="读入信息"||$_POST['search']=="删除用户")
                        {
                            for($i=1;$i<=$usertotal;$i++)
                                if($user->item($i-1)->getElementsByTagName("userid")->item(0)->nodeValue==$_POST['userid'])
                                    if($user->item($i-1)->getElementsByTagName("username")->item(0)->nodeValue=="");
                                    else print '<option value="'.$user->item($i-1)->getElementsByTagName("userid")->item(0)->nodeValue.'" selected>'.$user->item($i-1)->getElementsByTagName("username")->item(0)->nodeValue.' - ['.$user->item($i-1)->getElementsByTagName("domain")->item(0)->nodeValue.']</option>';
                                else
                                    if($user->item($i-1)->getElementsByTagName("username")->item(0)->nodeValue=="");
                                    else print '<option value="'.$user->item($i-1)->getElementsByTagName("userid")->item(0)->nodeValue.'">'.$user->item($i-1)->getElementsByTagName("username")->item(0)->nodeValue.' - ['.$user->item($i-1)->getElementsByTagName("domain")->item(0)->nodeValue.']</option>';
                        }
                        else
                            for($i=1;$i<=$usertotal;$i++)
                                if($user->item($i-1)->getElementsByTagName("username")->item(0)->nodeValue=="");
                                else print '<option value="'.$user->item($i-1)->getElementsByTagName("userid")->item(0)->nodeValue.'">'.$user->item($i-1)->getElementsByTagName("username")->item(0)->nodeValue.' - ['.$user->item($i-1)->getElementsByTagName("domain")->item(0)->nodeValue.']</option>';
                    ?>
                </select><input name="search" type="submit" class="buttonface" value="读入信息">
                </td></tr>
                <tr><td>用户ID:</td><td><?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("userid")->item(0)->nodeValue:"暂无结果"; ?></td></tr>
                <tr><td>用户名:</td><td><?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("username")->item(0)->nodeValue:"暂无结果"; ?></td></tr>
                <tr><td>域名:</td><td><?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("domain")->item(0)->nodeValue:"暂无结果"; ?></td></tr>
                <tr><td>数据库:</td><td><?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("database")->item(0)->nodeValue:"暂无结果"; ?></td></tr>
                <tr><td>根目录:</td><td><?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("wwwroot")->item(0)->nodeValue:"暂无结果"; ?></td></tr>
            </table>
        <?php dialogend('<input name="search" type="submit" class="buttonface" onclick="return confirm(\'真的要删除该用户吗？\')" value="删除用户">'); ?>  
        <?php 
            if("删除用户"==$_POST['search'])
            {                       
                echo '正在向系统发起删除用户请求...[ OK ]<BR/>正在删除用户目录...';
                {
                    system('rd /s /q "'.$appPath->item(0)->getElementsByTagName("wwwroot")->item(0)->nodeValue.'\\'.$user->item($_POST['userid']-1)->getElementsByTagName("username")->item(0)->nodeValue.'"');
                }
                echo '[ OK ]<BR/>正在删除Nginx虚拟主机文件...';
                {
                    $file =$appPath->item(0)->getElementsByTagName("nginx")->item(0)->nodeValue.'\\vhost\\'.$user->item($_POST['userid']-1)->getElementsByTagName("domain")->item(0)->nodeValue.'.ini';
                    system('del /f /s /q "'.$file.'"');
                }
                echo '[ OK ]<BR/>正在删除MySQL中用户数据库...';
                {
                    if(function_exists (mysql_close))
                    {
                        $con =mysql_connect($sqluser->item(0)->getElementsByTagName("server")->item(0)->nodeValue.":".$sqluser->item(0)->getElementsByTagName("port")->item(0)->nodeValue,$sqluser->item(0)->getElementsByTagName("user")->item(0)->nodeValue,$sqluser->item(0)->getElementsByTagName("password")->item(0)->nodeValue) or die("数据库连接失败"); 
                        if (!$con)
                        {
                            die('MYSQL连接出错: ' . mysql_error());
                        }
                        mysql_query("DROP USER '".$user->item($_POST['userid']-1)->getElementsByTagName("username")->item(0)->nodeValue."'@'".$sqluser->item(0)->getElementsByTagName("server")->item(0)->nodeValue."';",$con);
                        mysql_query("DROP DATABASE ".$user->item($_POST['userid']-1)->getElementsByTagName("username")->item(0)->nodeValue."_mysql;",$con);
                        mysql_close($con);
                    }
                    else
                        echo '[ FAILED ]<BR/>';
                }
                echo '正在回滚FileZilla资料档...[ OK ]<BR/>';
                {
                    include '../prog.fc/delftpuser.php';
                }
                echo '<BR/>所有任务已经完成！<BR/><font color="red">若需生效请【重启】所有服务</font>';
                
                
                $user->item($_POST['userid']-1)->getElementsByTagName("username")->item(0)->nodeValue="";
                $user->item($_POST['userid']-1)->getElementsByTagName("password")->item(0)->nodeValue="";
                $user->item($_POST['userid']-1)->getElementsByTagName("domain")->item(0)->nodeValue="";
                $user->item($_POST['userid']-1)->getElementsByTagName("database")->item(0)->nodeValue="";
                $user->item($_POST['userid']-1)->getElementsByTagName("wwwroot")->item(0)->nodeValue="";
                
                $xmlDoc->save("../comm.fc/server-users.xml");   //保存设置
                echo '<SCRIPT>alert("用户已经成功删除");window.location.href="'.$_SERVER['PHP_SELF'].'";</SCRIPT>';
            }
        ?>
    </form>
</center></body>
</html>