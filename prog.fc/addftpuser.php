<?php
/*================================
函数功能：添加一个FTP用户
函数名称：addftpuser
调用方式：include '本文件';
---------------------------------
函数编写：https://forum.filezilla-project.org/viewtopic.php?f=6&t=1340&p=7540
收录日期：2013年10月6日（日）
            http://www.fcsys.us
================================*/
error_reporting(0);
//user info
$username = $_POST['username'];
$password = md5($_POST['password']);
$userDir = $nginxroot;

//location of filezilla
$fileloc = strtr($appPath->item(0)->getElementsByTagName("filezilla")->item(0)->nodeValue,"\\","/")."/";
$filelocfile = ($fileloc."FileZilla Server.xml");
//echo $filelocfile;

////////////////
// start add filezilla user
////////////////

//Check to see if user name is already used
$fp = fopen($filelocfile,"r");
$data = fread($fp,filesize($filelocfile));
$pos1 = strpos($data,'<User Name="'.$_POST['username']);//find user name
//echo (".".$pos1.".");
fclose($fp);

//if user not found .. add
if($pos1 == ""){
echo "「正在添加FTP用户......」<BR/>";

// user setting for FileZilla FTP

$fileread = 1;   //Files Read  1 = YES  0 = NO
$filewrite = 1;  //Files Write
$filedelete = 1; //Files Delete
$fileappend = 1; //Files Append, must have Write on
$dircreate = 1;  //Directory Create
$dirdelete = 1;  //Directory Delete
$dirlist = 1;    //Directory List
$dirsubdirs = 1; //Directory + Subdirs
 
// Aktuelle Config wird eingelesen
$lines = file($filelocfile);


// Copy Config for backup
rename($filelocfile, $fileloc . "FileZilla Server_Backup.xml" );
//rename($filelocfile, $fileloc . date("Y-m-d;H-i-s")." FileZilla Server.xml" );
 

// open Config for writing 
$file = fopen($filelocfile,"w");

for($i=0; $i < sizeof($lines); $i++)
{
fwrite ($file, $lines[$i]);
 
// write new information on top of list after "<Users>" 
if (strstr($lines[$i],"<Users>"))
{
fwrite($file, '<User Name="' . $username . '">
<Option Name="Pass">' . $password . '</Option>
<Option Name="Group"/>
<Option Name="Bypass server userlimit">0</Option>
<Option Name="User Limit">0</Option>
<Option Name="IP Limit">0</Option>
<Option Name="Enabled">1</Option>
<Option Name="Comments"/>
<Option Name="ForceSsl">0</Option>
<IpFilter>
<Disallowed/>
<Allowed/>
</IpFilter>
<Permissions>
<Permission Dir="'.$userDir.'">
<Option Name="FileRead">' . $fileread . '</Option>
<Option Name="FileWrite">' . $filewrite . '</Option>
<Option Name="FileDelete">' . $filedelete . '</Option>
<Option Name="FileAppend">' . $fileappend . '</Option>
<Option Name="DirCreate">' . $dircreate . '</Option>
<Option Name="DirDelete">' . $dirdelete . '</Option>
<Option Name="DirList">' . $dirlist . '</Option>
<Option Name="DirSubdirs">' . $dirsubdirs . '</Option>
<Option Name="IsHome">1</Option>
<Option Name="AutoCreate">0</Option>
</Permission>
</Permissions>
<SpeedLimits DlType="0" DlLimit="10" ServerDlLimitBypass="0" UlType="0" UlLimit="10" ServerUlLimitBypass="0">
<Download/>
<Upload/>
</SpeedLimits>
</User>
');
}
}

// Close xml file
fclose($file);

//added user now reload FileZilla Server XML file to add user
passthru($fileloc.'FileZilla server.exe /reload-config');
Echo ("「FileZilla已经重新激活，用户生效」<BR/>");
}else{
echo "「问题：用户 ".$username." 已经存在创建失败」<BR/>";//did not add user, user name already used
}

////////////////
// end add filezilla user
////////////////
?>