<!DOCTYPE html>
<!FC-SYSTEM> <!-- MARKED BY FC-SYSTEM -->
<!-- =========================================
样本文件：添加用户
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
$xmlDoc->load('../comm.fc/server-users.xml');   //载入XML用户配置文件
$usertotal=$xmlDoc->getElementsbyTagName('usertotal')->item(0)->nodeValue;        //读取用户总数
$user=$xmlDoc->getElementsbyTagName('user');    //user节点读入
$user_root = $xmlDoc->getElementsByTagName("server-users")->item(0);  //用户配置文件根节点

$xmlDocs = new DOMDocument('1.0', 'UTF-8');      //创建DOM指定编码
$xmlDocs->load("../comm.fc/server-config.xml");  //载入XML配置文件
$appPath=$xmlDocs->getElementsByTagName("path"); //path节点读入
$sqluser=$xmlDocs->getElementsByTagName("mysqluser"); //mysqluser节点读入
?>
<body class="dialogbody"><center>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="POST">
        <input name="update" type="hidden" value="go" />
        <?php dialogbegin('添加用户'); ?>     <!--   对话框标题   -->
            <table border="0">
                <tr><td>用户ID:</td><td><?php echo $usertotal+1; ?></td></tr>
                <tr><td>用户名:</td><td><input name="username" type="text" class="input" size="50" value="由字母开头，仅允许字母数字下划线"/></td></tr>
                <tr><td>密码:</td><td><input name="password" type="password" class="input" size="50"/></td></tr>
                <tr><td>域名:</td><td><input name="domain" type="text" class="input" size="50" value="多个域名空格隔开"/></td></tr>
                <tr><td>数据库:</td><td>用户名_mysql (由系统指定)</td></tr>
                <tr><td>根目录:</td><td><?php echo $appPath->item(0)->getElementsByTagName("wwwroot")->item(0)->nodeValue; ?>\用户名 (由系统指定)</td></tr>
            </table>
        <?php dialogend('<input name="search" type="submit" class="buttonface" value="添加">'); ?>  
        <?php 
            if("添加"==$_POST['search'])
            {
                if($_POST['username']==""||$_POST['password']==""||$_POST['domain']==""||$_POST['username']=="由字母开头，仅允许字母数字下划线"||$_POST['domain']=="多个域名空格隔开")
                {
                    echo '<SCRIPT>alert("资料填写不全，请补充完整后添加");</SCRIPT>';
                    exit ;
                }   
                
                for($i=1;$i<=$usertotal;$i++)   
                {
                    if($user->item($i-1)->getElementsByTagName("username")->item(0)->nodeValue==$_POST['username'])
                    {
                        echo '<SCRIPT>alert("用户名已经存在！");</SCRIPT>';
                        exit ;
                    }
                }
                
                for($i=1;1;$i++)
                {
                    if($notreg[$i]!='#ENDLIST#')
                    {
                        if($_POST['username']==$notreg[$i])
                        {
                            echo '<SCRIPT>alert("【严重错误】用户名在禁止注册列表中！");</SCRIPT>';
                            exit ;
                        }
                    }
                    else
                    {
                        break;
                    }
                }
                
                //创建一个根节点user       
                $user_node = $xmlDoc->createElement("user");
                
                //在新创建的user里面再创建各子节点
                $user_node_userid = $xmlDoc->createElement("userid");
                $user_node_username = $xmlDoc->createElement("username");
                $user_node_password = $xmlDoc->createElement("password");
                $user_node_domain = $xmlDoc->createElement("domain");
                $user_node_database = $xmlDoc->createElement("database");
                $user_node_wwwroot = $xmlDoc->createElement("wwwroot");
                
                //给新创建的子节点赋值
                $user_node_userid->nodeValue = $usertotal+1;
                $user_node_username->nodeValue = $_POST['username'];
                $user_node_password->nodeValue = $_POST['password'];
                $user_node_domain->nodeValue = $_POST['domain'];
                $user_node_database->nodeValue = $_POST['username'].'_mysql';
                $user_node_wwwroot->nodeValue = $appPath->item(0)->getElementsByTagName("wwwroot")->item(0)->nodeValue.'\\'.$_POST['username'];
                
                //将新创建的子节点追加到新创建的user节点中
                $user_node->appendChild($user_node_userid);
                $user_node->appendChild($user_node_username);
                $user_node->appendChild($user_node_password);
                $user_node->appendChild($user_node_domain);
                $user_node->appendChild($user_node_database);
                $user_node->appendChild($user_node_wwwroot);
                
                //将新创建的user节点添加到根节点当中
                $user_root->appendChild($user_node);
                //用户数量自己加一
                $xmlDoc->getElementsbyTagName('usertotal')->item(0)->nodeValue=$usertotal+1;
                
                $xmlDoc->save("../comm.fc/server-users.xml");   //保存设置
                
                echo '正在向系统发起添加用户请求...[ OK ]<BR/>正在创建用户目录...';
                {
                    system ('mkdir "'.$appPath->item(0)->getElementsByTagName("wwwroot")->item(0)->nodeValue.'\\'.$_POST['username'].'"');
                }
                echo '[ OK ]<BR/>正在生成Nginx虚拟主机文件...';
                {
                    $nginxroot=strtr($appPath->item(0)->getElementsByTagName("wwwroot")->item(0)->nodeValue.'\\'.$_POST['username'],"\\","/");
                    
                    $file =$appPath->item(0)->getElementsByTagName("nginx")->item(0)->nodeValue.'\\vhost\\'.$_POST['domain'].'.ini';
                    $fp=fopen($file,"a+");
                    $nginxdata="#-------------".$_POST['domain']."------------\r\n    server {\r\n        listen       80;\r\n        server_name  ".$_POST['domain'].";\r\n\r\n        location / {\r\n            root   ".$nginxroot.";\r\n            index  index.php index.html index.htm default.htm default.html;\r\n        }\r\n\r\n        error_page   500 502 503 504  /50x.html;\r\n        location = /50x.html {\r\n            root   html;\r\n        }\r\n\r\n        location ~ \\.php$ {\r\n            root           ".$nginxroot.";\r\n            fastcgi_pass   127.0.0.1:9000;\r\n            fastcgi_index  index.php;\r\n            fastcgi_param  SCRIPT_FILENAME  ".$nginxroot."\$fastcgi_script_name;\r\n            include        fastcgi_params;\r\n        }\r\n    }\r\n#-------------------------------------";
                    fwrite($fp,$nginxdata);
                    fclose($fp);
                    
                    $userindexfile=$nginxroot."/index.php";
                    $userindexfp=fopen($userindexfile,"a+");
                    $userindexdata="<HEAD><TITLE>Hello Kitty!</TITLE></HEAD><H1>Hello Kitty!</H1><HR/>FC-System Computer Inc";
                    fwrite($userindexfp,$userindexdata);
                    fclose($userindexfp);
                }
                echo '[ OK ]<BR/>正在新建MySQL数据库...';
                {
                    if(function_exists (mysql_close))
                    {
                        $con =mysql_connect($sqluser->item(0)->getElementsByTagName("server")->item(0)->nodeValue.":".$sqluser->item(0)->getElementsByTagName("port")->item(0)->nodeValue,$sqluser->item(0)->getElementsByTagName("user")->item(0)->nodeValue,$sqluser->item(0)->getElementsByTagName("password")->item(0)->nodeValue) or die("数据库连接失败"); 
                        if (!$con)
                        {
                            die('MYSQL连接出错: ' . mysql_error());
                        }
                        mysql_query("CREATE USER '".$_POST['username']."'@'".$sqluser->item(0)->getElementsByTagName("server")->item(0)->nodeValue."' IDENTIFIED BY '".$_POST['password']."';",$con);
                        mysql_query("GRANT USAGE ON *.* TO '".$_POST['username']."'@'".$sqluser->item(0)->getElementsByTagName("server")->item(0)->nodeValue."' IDENTIFIED BY '".$_POST['password']."' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;",$con);
                        mysql_query("CREATE DATABASE IF NOT EXISTS `".$_POST['username']."_mysql`;",$con);
                        mysql_query("GRANT ALL PRIVILEGES ON `".$_POST['username']."_mysql`.* TO '".$_POST['username']."'@'".$sqluser->item(0)->getElementsByTagName("server")->item(0)->nodeValue."';",$con);
                        mysql_close($con);
                        echo '[ OK ]<BR/>';  
                    }
                    else
                        echo '[ FAILED ]<BR/>';
                }
                echo '正在建立FileZilla资料档...[ OK ]<BR/>';
                {
                    include '../prog.fc/addftpuser.php';
                }
                echo '<BR/>所有任务已经完成！<BR/><font color="red">若需生效请【重启】所有服务</font>';
                echo $sql; exit ;
                echo '<SCRIPT>alert("新用户已成功添加");window.location.href="'.$_SERVER['PHP_SELF'].'";</SCRIPT>';
            }
        ?>
    </form>
</center></body>
</html>
