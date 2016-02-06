<?php
/*================================
程序功能：生成主菜单项目
程序名称：menugen
调用方式：include '本文件';
---------------------------------
函数编写：dfc643(北极光.Norckon)
编写日期：2013年10月5日（六）
            http://www.fcsys.us
================================*/

//菜单项目个数
$menuitems =11;
//菜单标题
$menutitle = array("系统信息","基本设置","用户管理","查看用户","添加用户","编辑用户","删除用户","系统控制","服务控制","退出登陆","关于系统");
//菜单编码
$menuid = array("1","2","3","4","5","6","7","8","9","10","11");
//菜单类型数组       
$menuclass = array("dot1","dot1","plus","dot2","dot2","dot2","dot2","plus","dot2","dot2","dot1");
//对应菜单文件
$menuahref = array("sysinfo","syssettings","userview","userview","useradd","useredit","userdel","sysrestart","sysrestart","syslogout","about");

for($i=0;$i<$menuitems;$i++)
{
    if("dot2"==$menuclass[$i])
        print '<ol id="ol'.$menuid[$i].'"class="'.$menuclass[$i].'" style="display: none; padding-left: 26px; background-position: 13px 3px;"><a href="../../main.app/'.$menuahref[$i].'.php" target="mainFrame" class="L1" onClick="doClick('.$menuid[$i].')">'.$menutitle[$i].'</a></ol>';
    else
        print '<ol id="ol'.$menuid[$i].'"class="'.$menuclass[$i].'" style="display:block; background-position:0px 3px;PADDING-LEFT: 13px;"><a href="../../main.app/'.$menuahref[$i].'.php" target="mainFrame" class="L1" onClick="doClick('.$menuid[$i].')">'.$menutitle[$i].'</a></ol>';
}

print '<SCRIPT>var MENU_ITEMS='.$menuitems.';</SCRIPT>'; //为menudoclick.js提供菜单数目
?>