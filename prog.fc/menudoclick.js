/*================================
程序功能：显示子菜单
程序名称：menudoclick
调用方式：doClick(id);
---------------------------------
函数编写：dfc643(北极光.NorcKon)
编写日期：2013年10月5日（六）
            http://www.fcsys.us
================================*/

function closeAllSubMenu()
{
    for(i=1;i<=MENU_ITEMS;i++)
    {
        if(document.getElementById('ol'+i).className=="dot2")
            document.getElementById('ol'+i).style.display="none";
    }
}

function doClick(n)
{
    if(document.getElementById("ol"+n).className=="dot2")
        return ;  //如果是子菜单调用函数那么什么都不干
    else 
    {
        closeAllSubMenu();//不管何种情况，总是先关闭所有菜单
        for(i=1;i<=MENU_ITEMS;i++)
        {
            if(document.getElementById("ol"+i).className=="minus")
                document.getElementById("ol"+i).className="plus";
        }
    }
             
    for(i=n+1;i<=MENU_ITEMS;i++)
    {
        if(document.getElementById("ol"+n).className=="plus"&&document.getElementById("ol"+i).style.display=="none"&&document.getElementById("ol"+i).className=="dot2")
            {
                document.getElementById("ol"+i).style.display="block";
            }
        else if(document.getElementById("ol"+i).className!="dot2"&&document.getElementById("ol"+n).className!="minus")
            break;
        else
            closeAllSubMenu();
    }
    
    if(document.getElementById("ol"+n).className=="plus")
        document.getElementById("ol"+n).className="minus";
}
