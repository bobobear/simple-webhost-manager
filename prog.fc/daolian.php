<?php
/*================================
�������ܣ���ֹ�û�ֱ������URL
�������ƣ�daolian
���÷�ʽ��include '���ļ�';
---------------------------------
������д��dfc643(������.Norckon)
��д���ڣ�2013��10��4�գ��壩
            http://www.fcsys.us
================================*/
include '../comm.fc/sys-config.php';  //��ȫ�ֱ����п����Ƿ���������
function daolian($daolian)
{
    if(1==$daolian)
    echo '<script>if(window.parent == window) window.location.href="http://www.fcsys.us";</script>';
}
daolian($daolian); //ִ��һ��
?>