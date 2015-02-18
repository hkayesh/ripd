<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
function getPages($page) // for getting directory pages
{ 
    echo  "<option value=0> -সিলেক্ট করুন- </option>";
     foreach (glob("*.php") as $filename) {
         if($page == $filename)
         {
             echo  "<option value=".$filename." selected>".$filename."</option>";
         }
         else {echo  "<option value=".$filename.">".$filename."</option>";}
    }
}

$g_modid = $_GET['modid'];
$mod_sel = mysql_query("SELECT * FROM security_modules WHERE idsecuritymod = $g_modid;");
$modrow = mysql_fetch_assoc($mod_sel);
$db_modname = $modrow['module_name'];
$db_moddes = $modrow['module_desc'];
$db_page = $modrow['module_page_name'];
$msg ="";
if(isset($_POST['update']))
{
    $p_name = $_POST['up_modname'];
    $p_des = $_POST['up_moddes'];
    $p_id = $_POST['moduleID'];
    $p_page = $_POST['page'];
    $upquery = mysql_query("UPDATE `security_modules` SET `module_name` = '$p_name', `module_desc` = '$p_des', module_page_name = '$p_page' WHERE `idsecuritymod` =$p_id");
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
                    <tr><th colspan="2" style="text-align: center;">আপডেট মডিউল</th></tr>
                    <?php if($msg == "") {?>
                    <tr>
                    <td style="text-align: center; width: 30%;">মডিউলের নাম</td>
                    <td>: <input  class="box" type="text" name="up_modname"  id="up_modname" value="<?php echo $db_modname;?>"/>
                        <input type="hidden" name="moduleID" value="<?php echo $g_modid;?>" /></td>   
                    </tr>
                    <tr>
                        <td style="text-align: center; width: 30%;">মডিউলের বর্ণনা</td>
                        <td>&nbsp;&nbsp;<textarea  class="box" type="text" name="up_moddes"  id="up_moddes" value="" ><?php echo $db_moddes;?></textarea></td>   
                    </tr>
                    <tr>
                    <td style="text-align: center; width: 30%;">পেজের নাম</td>
                    <td>: <select  class="box"  name="page" style="width: 250px; height: 25px;">
                            <?php getPages($db_page);?>
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