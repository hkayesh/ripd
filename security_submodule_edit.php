<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
$g_submodid = $_GET['submodid'];
$submod_sel = mysql_query("SELECT * FROM securiy_submodules WHERE idsecuritysubmod = $g_submodid;");
$submodrow = mysql_fetch_assoc($submod_sel);
$db_submodname = $submodrow['submod_name'];
$db_submoddes = $submodrow['submod_desc'];
$msg ="";
if(isset($_POST['update']))
{
    $p_name = $_POST['up_submodname'];
    $p_des = $_POST['up_submoddes'];
    $p_id = $_POST['submoduleID'];
    $upquery = mysql_query("UPDATE `securiy_submodules` SET `submod_name` = '$p_name', `submod_desc` = '$p_des' WHERE `idsecuritysubmod` =$p_id");
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
                    <tr><th colspan="2" style="text-align: center;">আপডেট সাবমডিউল</th></tr>
                    <?php if($msg == "") {?>
                  <tr>
                    <td style="text-align: center; width: 50%;">সাবমডিউলের নাম</td>
                    <td>: <input  class="box" type="text" name="up_submodname"  id="up_submodname" value="<?php echo $db_submodname;?>"/>
                        <input type="hidden" name="submoduleID" value="<?php echo $g_submodid;?>" /></td>   
                    </tr>
                    <tr>
                        <td style="text-align: center; width: 50%;">সাবমডিউলের বর্ণনা</td>
                        <td>&nbsp;&nbsp;<textarea  class="box" type="text" name="up_submoddes" value="" ><?php echo $db_submoddes;?></textarea></td>   
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