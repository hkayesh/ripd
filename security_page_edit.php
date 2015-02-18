<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
function getSubmodules($subid)
{
    $modRslt= mysql_query("SELECT * FROM securiy_submodules ORDER BY submod_name;");
    while($modrow = mysql_fetch_assoc($modRslt))
    {
        if($modrow['idsecuritysubmod'] == $subid)
        {
             echo  "<option value=".$modrow['idsecuritysubmod']." selected>".$modrow['submod_name']."</option>";
        }
        else { echo  "<option value=".$modrow['idsecuritysubmod'].">".$modrow['submod_name']."</option>";}
    }
}
$g_pageid = $_GET['pageid'];
$page_sel = mysql_query("SELECT * FROM security_pages WHERE idsecuritypage = $g_pageid;");
$pagerow = mysql_fetch_assoc($page_sel);
$db_pagename = $pagerow['page_name'];
$db_pageview = $pagerow['page_view_name'];
$db_pagedes = $pagerow['page_desc'];
$db_submodid = $pagerow['security_submodule_idsecuritysubmod'];
$msg ="";
if(isset($_POST['update']))
{
    $p_viewname = $_POST['up_pageviewname'];
    $p_des = $_POST['up_pagedes'];
    $p_id = $_POST['pageID'];
    $p_subid = $_POST['sub_module'];
    $upquery = mysql_query("UPDATE `security_pages` SET `page_view_name` = '$p_viewname', `page_desc` = '$p_des', page_create_date= NOW(), security_submodule_idsecuritysubmod=$p_subid  WHERE `idsecuritypage` =$p_id");
    if ($upquery ==1)
	{$msg = "আপডেট হয়েছে"; }
        else { $msg ="আপডেট হয়নি"; }
}

?>
<script>
    function out()
    {
        setTimeout(function(){parent.location.href=parent.location.href;},1000);
    }
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css"> @import "css/bush.css";</style>
</head>
<body>
                <form method="POST"  action="">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;margin: 0 !important;">          
                    <tr><th colspan="2" style="text-align: center;">আপডেট পেজ</th></tr>
                    <?php if($msg == "") {?>
                       <tr>
                    <td style="text-align: center; width: 50%;">পেজের নাম</td>
                    <td>: <input  class="box" type="text" name="pagename" readonly value="<?php echo $db_pagename;?>"/>
                        <input type="hidden" name="pageID" value="<?php echo $g_pageid;?>" /></td>   
                    </tr>   
                       <tr>
                    <td style="text-align: center; width: 50%;">পেজভিউ নাম</td>
                    <td>: <input  class="box" type="text" name="up_pageviewname"  value="<?php echo $db_pageview;?>"/></td>   
                    </tr>
                       <tr>
                        <td style="text-align: center; width: 50%;">পেজের বর্ণনা</td>
                        <td>&nbsp;&nbsp;<textarea  class="box" type="text" name="up_pagedes" value="" ><?php echo $db_pagedes;?></textarea></td>   
                    </tr>
                    <tr>
                    <td style="text-align: center; width: 50%;">সাবমডিউলের নাম</td>
                    <td>: <select  class="box"  name="sub_module"  style="height: 25px;" >
                            <?php echo getSubmodules($db_submodid);?>
                        </select></td>   
                    </tr>
                 
                    <tr>                    
                        <td colspan="2" style="padding-left: 150px; " ></br><input class="btn" style =" font-size: 12px; " type="submit" name="update" value="আপডেট করুন" />
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>
                    <?php }    
                    else { ?>
                    <tr>
                        <td colspan="2" style="text-align: center; font-size: 16px;color: green;"><?php echo $msg;  echo "<script>out();</script>";?></td>          
                    </tr><?php }?>
                </table>
              </form>
</body>
</html>