<!DOCTYPE html>
<!FC-SYSTEM> <!-- MARKED BY FC-SYSTEM -->
<?php
//包含全局配置文件
include 'comm.fc/sys-config.php'; 
?>
<html>
<?php include 'comm.fc/gb-head.php'; ?>

    <?php
        if(1==$install)
        {
            //若install为1：那么就include主体文件
            include 'main.app/index.php';
        }
        else if(0==$install)
        {
            //若install为0：那么就跳转至安装文件
            echo "<script>window.location.href='comm.fc/install.php'</script>";
        }
        else
        {
            //若install为不定数：那么就报错
            print '<h1>程序异常</h1>程序配置文件有误，请检查 sys-config.php 中的 install 项目是否正确配置？<hr/>FC-System Computer Inc.';
        }
    ?>
</html>
