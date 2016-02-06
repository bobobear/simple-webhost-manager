<?php
/*================================
函数功能：编辑一个FTP用户
函数名称：renftpuser
调用方式：include '本文件';
---------------------------------
函数编写：dfc643(北极光.Norc)
收录日期：2013年10月6日（日）
            http://www.fcsys.us
================================*/
//error_reporting(0);
//用户信息
$username = $user->item($_POST['userid']-1)->getElementsByTagName("username")->item(0)->nodeValue;

//FileZilla程序位置
$fileloc = strtr($appPath->item(0)->getElementsByTagName("filezilla")->item(0)->nodeValue,"\\","/")."/";
$filelocfile = ($fileloc."FileZilla Server.xml");
//echo $filelocfile;

////////////////
// 开始编辑FTP用户
////////////////

//检查用户是否存在
$fp = fopen($filelocfile,"r");
$data = fread($fp,filesize($filelocfile));
$pos1 = strpos($data,'<User Name="'.$username);//查找用户名
//echo (".".$pos1.".");
fclose($fp);

//如果用户存在
if($pos1 != ""){
echo "「正在编辑FTP用户......」<BR/>";

//创建XMLDOM对象
$ftpxmldoc = new DOMDocument();
$ftpxmldoc->load($filelocfile); //加载XML文件

$users_node=$ftpxmldoc->getElementsByTagName("Users")->item(0)->getElementsByTagName("User"); //<Users>节点
for($i=0;$i<32768;$i++)
{
    $user_node=$users_node->item($i);
    
    if($user_node->getAttribute('Name')==$username)
        break;   
}

$user_node->setAttribute('Name',$_POST['username']); //修改用户名节点
if(""!=$_POST['password']) $user_node->getElementsByTagName("Option")->item(0)->nodeValue=md5($_POST['password']); //修改密码节点
$users_node->item($i)->getElementsByTagName("Permissions")->item(0)->getElementsByTagName("Permission")->item(0)->setAttribute('Dir',$_POST['wwwroot']); //修改根目录
$ftpxmldoc->save($filelocfile); //保存XML文档

//使FILEZILLA重新加载配置文件使其生效
passthru($fileloc.'filezilla server.exe /reload-config');
Echo ("「FileZilla已经重新激活，用户生效」<BR/>");
}else{
echo "「问题：用户 ".$username." 不存在，删除失败」<BR/>";//用户不存在删除失败
}

////////////////
// 用户编辑完了
////////////////
?>