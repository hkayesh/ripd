<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
$g_roleid = $_GET['roleid'];
$role_sel = mysql_query("SELECT * FROM security_roles WHERE 	idsecurityrole = $g_roleid;");
$rolrow = mysql_fetch_assoc($role_sel);
$db_rolname = $rolrow['role_name'];
$db_roldes = $rolrow['role_desc'];
$msg ="";
if(isset($_POST['update']))
{
    $p_name = $_POST['up_rolename'];
    $p_des = $_POST['up_roledes'];
    $p_id = $_POST['roleID'];
    $upquery = mysql_query("UPDATE `security_roles` SET `role_name` = '$p_name', `role_desc` = '$p_des' WHERE `idsecurityrole` =$p_id");
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
                    <tr><th colspan="2" style="text-align: center;">আপডেট রোল</th></tr>
                    <?php if($msg == "") {?>
                    <tr>
                    <td style="text-align: center; width: 50%;">রোল নাম</td>
                    <td>: <input  class="box" type="text" name="up_rolename"  value="<?php echo $db_rolname;?>"/>
                        <input type="hidden" name="roleID" value="<?php echo $g_roleid;?>" /></td>   
                    </tr>
                    <tr>
                        <td style="text-align: center; width: 50%;">রোলের বর্ণনা</td>
                        <td>&nbsp;&nbsp;<textarea  class="box" type="text" name="up_roledes"  value="" ><?php echo $db_roldes;?></textarea></td>   
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