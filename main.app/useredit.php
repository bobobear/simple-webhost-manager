<!DOCTYPE html>
<!FC-SYSTEM> <!-- MARKED BY FC-SYSTEM -->
<!-- =========================================
样本文件：编辑用户
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
        <?php dialogbegin('编辑用户'); ?>     <!--   对话框标题   -->
            <table border="0">
                <tr><td>用户列表:</td><td><select name="userid">
                    <?php 
                        if($_POST['search']=="读入信息"||$_POST['search']=="修改")
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
                <tr><td>用户名:</td><td><input name="username" type="text" class="input" size="50" value="<?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("username")->item(0)->nodeValue:"暂无结果"; ?>"/></td></tr>
                <tr><td>密码:</td><td><input name="password" type="password" class="input" size="38"/>(留空表不改)</td></tr>
                <tr><td>域名:</td><td><input name="domain" type="text" class="input" size="50" value="<?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("domain")->item(0)->nodeValue:"暂无结果"; ?>"/></td></tr>
                <tr><td>数据库:</td><td><input name="database" type="text" class="input" size="50" disabled value="<?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("database")->item(0)->nodeValue:"暂无结果"; ?>"/></td></tr>
                <tr><td>根目录:</td><td><?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("wwwroot")->item(0)->nodeValue:"暂无结果"; ?><br/><small>新目录:<?php echo $appPath->item(0)->getElementsByTagName("wwwroot")->item(0)->nodeValue.'\\新用户名'; ?></small></td></tr>
            </table>
        <?php dialogend('<input name="search" type="submit" class="buttonface" value="修改">'); ?>  
        <?php 
            if("修改"==$_POST['search'])
            {
                if($_POST['username']=="")
                {
                    echo '<SCRIPT>alert("请确认信息是否完整？");</SCRIPT>';
                    exit ;
                }
                echo '正在向系统发起编辑用户请求...[ OK ]<BR/>正在重命名用户目录...';
                {
                    system('ren "'.$appPath->item(0)->getElementsByTagName("wwwroot")->item(0)->nodeValue.'\\'.$user->item($_POST['userid']-1)->getElementsByTagName("username")->item(0)->nodeValue.'" "'.$_POST['username'].'"');
                }
                echo '[ OK ]<BR/>正在删除旧Nginx虚拟主机文件...';
                {
                    $file =$appPath->item(0)->getElementsByTagName("nginx")->item(0)->nodeValue.'\\vhost\\'.$user->item($_POST['userid']-1)->getElementsByTagName("domain")->item(0)->nodeValue.'.ini';
                    system('del /f /s /q "'.$file.'"');
                }
                echo '[ OK ]<BR/>正在创建新Nginx虚拟主机文件...';
                {
                    $nginxroot=strtr($appPath->item(0)->getElementsByTagName("wwwroot")->item(0)->nodeValue.'\\'.$_POST['username'],"\\","/");
                    
                    $file =$appPath->item(0)->getElementsByTagName("nginx")->item(0)->nodeValue.'\\vhost\\'.$_POST['domain'].'.ini';
                    $fp=fopen($file,"a+");
                    $nginxdata="#-------------".$_POST['domain']."------------\r\n    server {\r\n        listen       80;\r\n        server_name  ".$_POST['domain'].";\r\n\r\n        location / {\r\n            root   ".$nginxroot.";\r\n            index  index.php index.html index.htm default.htm default.html;\r\n        }\r\n\r\n        error_page   500 502 503 504  /50x.html;\r\n        location = /50x.html {\r\n            root   html;\r\n        }\r\n\r\n        location ~ \\.php$ {\r\n            root           ".$nginxroot.";\r\n            fastcgi_pass   127.0.0.1:9000;\r\n            fastcgi_index  index.php;\r\n            fastcgi_param  SCRIPT_FILENAME  ".$nginxroot."\$fastcgi_script_name;\r\n            include        fastcgi_params;\r\n        }\r\n    }\r\n#-------------------------------------";
                    fwrite($fp,$nginxdata);
                    fclose($fp); 
                }
                echo '[ OK ]<BR/>正在修改MySQL中用户数据库...';
                {
                    if(function_exists (mysql_close))
                    {
                        $con =mysql_connect($sqluser->item(0)->getElementsByTagName("server")->item(0)->nodeValue.":".$sqluser->item(0)->getElementsByTagName("port")->item(0)->nodeValue,$sqluser->item(0)->getElementsByTagName("user")->item(0)->nodeValue,$sqluser->item(0)->getElementsByTagName("password")->item(0)->nodeValue) or die("数据库连接失败"); 
                        if (!$con)
                        {
                            die('MYSQL连接出错: ' . mysql_error());
                        }
                        mysql_query("SET PASSWORD FOR '".$user->item($_POST['userid']-1)->getElementsByTagName("username")->item(0)->nodeValue."'@'".$sqluser->item(0)->getElementsByTagName("server")->item(0)->nodeValue."' = PASSWORD('".$_POST['password']."');",$con);
                        mysql_close($con);
                    }
                    else
                        echo '[ FAILED ]<BR/>';
                }
                echo '正在编辑FileZilla资料档...[ OK ]<BR/>';
                {
                    include '../prog.fc/renftpuser.php';
                }
                echo '<BR/>所有任务已经完成！<BR/><font color="red">若需生效请【重启】所有服务</font>';
                
                
                $user->item($_POST['userid']-1)->getElementsByTagName("username")->item(0)->nodeValue=$_POST['username'];
                if(""==$_POST['password']) {$nopassword=1;} else {$user->item($_POST['userid']-1)->getElementsByTagName("password")->item(0)->nodeValue=$_POST['password'];}
                $user->item($_POST['userid']-1)->getElementsByTagName("domain")->item(0)->nodeValue=$_POST['domain'];
                //$user->item($_POST['userid']-1)->getElementsByTagName("database")->item(0)->nodeValue=$_POST['database'];
                //$user->item($_POST['userid']-1)->getElementsByTagName("wwwroot")->item(0)->nodeValue=$_POST['wwwroot'];
                
                $xmlDoc->save("../comm.fc/server-users.xml");   //保存设置
                
                if($nopassword)
                    echo '<SCRIPT>alert("所有密码未更改，且数据库用户名与数据库名也未更改，设置已经保存");window.location.href="'.$_SERVER['PHP_SELF'].'";</SCRIPT>';
                else
                    echo '<SCRIPT>alert("密码以及设置已经保存，但数据库用户名与数据库名也未更改");window.location.href="'.$_SERVER['PHP_SELF'].'";</SCRIPT>';
            }
        ?>
    </form>
</center></body>
</html>