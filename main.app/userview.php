<!DOCTYPE html>
<!FC-SYSTEM> <!-- MARKED BY FC-SYSTEM -->
<!-- =========================================
样本文件：查看用户
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
<body class="dialogbody"><center>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
        <input name="update" type="hidden" value="go" />
        <?php dialogbegin('查看用户'); ?>     <!--   对话框标题   -->
            <table border="0">
                <tr><td>用户列表:</td><td><select name="userid">
                    <?php 
                        if($_POST['search']=="查询")
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
                </select>
                </td></tr>
                <tr><td>用户ID:</td><td><?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("userid")->item(0)->nodeValue:"暂无结果"; ?></td></tr>
                <tr><td>用户名:</td><td><?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("username")->item(0)->nodeValue:"暂无结果"; ?></td></tr>
                <tr><td>域名:</td><td><?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("domain")->item(0)->nodeValue:"暂无结果"; ?></td></tr>
                <tr><td>数据库:</td><td><?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("database")->item(0)->nodeValue:"暂无结果"; ?></td></tr>
                <tr><td>根目录:</td><td><?php echo $_POST['update']=="go"?$user->item($_POST['userid']-1)->getElementsByTagName("wwwroot")->item(0)->nodeValue:"暂无结果"; ?></td></tr>
            </table>
        <?php dialogend('<input name="search" type="submit" class="buttonface" value="查询">'); ?>    
    </form>
</center></body>
</html>