<?php
error_reporting(0);
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$g_cataname = $_GET['catName'];
$sql_up_category = $conn->prepare("UPDATE product_catagory SET pro_catagory = ? WHERE  pro_catagory = ?");
$msg ="";
if(isset($_POST['update']))
{
    $p_current = $_POST['current_name'];
    $p_update = $_POST['up_name'];
    $upquery = $sql_up_category->execute(array($p_update,$p_current));
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
                    <tr><th colspan="2" style="text-align: center;">আপডেট ক্যাটাগরির নাম</th></tr>
                    <?php if($msg == "") {?>
                  <tr>
                    <td style="text-align: center; width: 50%;">বর্তমান নাম</td>
                    <td>: <input  class="box" type="text" name="current_name"  id="current_name" value="<?php echo $g_cataname;?>" readonly /></td>   
                    </tr>
                    <tr>
                    <td style="text-align: center; width: 50%;">নতুন নাম</td>
                    <td>: <input  class="box" type="text" name="up_name"  id="up_name" /></td>   
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