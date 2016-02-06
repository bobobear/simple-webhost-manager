<?php
/*
==========================================
程序名称：虚拟主机管理系统
程序设计：dfc643（北极光.Norckon）
项目日期：2013年10月4日 20:05:18
程序版本：1, 0, 0, 0  build131004
官方博客：Http://blog.fcsys.us
==========================================
*/
//
//=============程序配置文件===============
//
#ifndef _SYS_CONFIG_
#define _SYS_CONFIG_

//主机编号，将会显示在标题栏中（如：FCSRV039）
$servid='SERVER01';
//安装标志，1:已安装|0:未安装，请勿随便更改此标识
$install='0';
//网站字符集，默认为UTF-8编码，无特殊要求请勿随便更改
$charset='utf-8';
//网站防盗链功能，1:开启|0:禁用
$daolian='1';

//保留注册段字，最后一项必须是#ENDLIST#结尾
$notreg=array('test1','test2','test3','#ENDLIST#');

//系统登陆用户名
$loginuser='admin';
//系统登陆密码
$loginpasswd='admin';

#endif
//_SYS_CONFIG_
?>