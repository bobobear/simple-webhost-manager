<?php
/*================================
函数功能：制造一个对话框前部分
函数名称：dialogbegin
调用方式：dialogbegin('标题');
---------------------------------
函数编写：dfc643(北极光.Norckon)
编写日期：2013年10月4日（五）
            http://www.fcsys.us
================================*/
function dialogbegin($title)
{
    print '<table width="502" border="0" cellspacing="0" cellpadding="0"  align="center" style="text-align:left;"><tbody><tr><td width="7" class="title"><img src="../style.fc/image.img.1004/arc.gif" width="7" height="24"></td><td width="495" align="left" valign="middle" class="title">'.$title.'</td></tr><tr><td colspan="2"><table width="502" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td class="vline" rowspan="15"><br></td><td width="500"><table width="410" border="0" align="center" cellpadding="0" cellspacing="0" class="space"><tbody><tr><td>';
}

/*================================
函数功能：制造一个对话框前部分
函数名称：dialogend
调用方式：dialogend('INPUT代码');
---------------------------------
函数编写：dfc643(北极光.Norckon)
编写日期：2013年10月4日（五）
            http://www.fcsys.us
================================*/
function dialogend($button)
{
    print '</td></tr></tbody></table><br></td><td class="vline" rowspan="15"><br></td></tr><tr><td class="hline"></td></tr>  <!-- 分割线 --><tr><td height="30" class="tail" align="right" nowrap="">'.$button.'&nbsp;&nbsp;</td></tr><tr><td class="hline"></td></tr>  <!-- 分割线 --></tbody></table></td></tr></tbody></table>';
}
?>