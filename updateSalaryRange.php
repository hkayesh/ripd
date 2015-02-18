<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';

$g_gradeid = $_GET['gradeid'];
$selsqlrslt = mysql_query("SELECT * FROM pay_grade WHERE idpaygrade = $g_gradeid;");
$grdrow = mysql_fetch_assoc($selsqlrslt);
$db_grade = $grdrow['grade_name'];
$db_catagory = $grdrow['employee_type'];
$db_maxsal = $grdrow['max_salary'];
$db_minsal = $grdrow['min_salary'];
$db_pension = $grdrow['pension'];
$msg ="";
if(isset($_POST['update']))
{
    $p_id = $_POST['paygradeid'];
    $p_min = $_POST['min_sal'];
    $p_max = $_POST['max_sal'];
    $p_pension = $_POST['pension'];
    $upquery = mysql_query(" UPDATE `pay_grade` SET `min_salary` = '$p_min', `max_salary` = '$p_max', `pension` = '$p_pension', `update_date` = NOW()  WHERE `idpaygrade` =$p_id; ");
    if ($upquery ==1)
	{$msg = "আপডেট হয়েছে";}
        else { $msg ="আপডেট হয়নি"; }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css"> @import "css/bush.css";</style>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
</head>
<body>
                <form method="POST" onsubmit="" name="" action="updateSalaryRange.php">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;margin: 0 !important;">          
                    <tr><th colspan="2" style="text-align: center;">আপডেট গ্রেড সেলারি</th></tr>
                    <?php if($msg == "") {?>
                    <tr>
                        <td>ক্যাটাগরি</td>
                        <td>: <?php echo $db_catagory;?></td>            
                    </tr>
                    <tr>
                        <td>গ্রেড</td>
                        <td>: <?php echo $db_grade;?><input type="hidden" name="paygradeid" value="<?php echo $g_gradeid;?>"/> </td>                                  
                    </tr>
                    <tr>
                        <td>সর্বনিম্ন সেলারি</td>
                        <td>:   <input class="box" type="text" id="min_sal" name="min_sal" onkeypress="return checkIt(event)" value="<?php echo $db_minsal; ?>"/> টাকা</td>                                  
                    </tr>
                    <tr>
                        <td>সর্বোচ্চ সেলারি</td>
                        <td>:   <input class="box" type="text" id="max_sal" name="max_sal" onkeypress="return checkIt(event)" value="<?php echo $db_maxsal; ?>" /> টাকা</td>                                  
                    </tr>
                    <tr>
                        <td>পেনসন</td>
                        <td>:   <input class="box" type="text" id="pension" name="pension" onkeypress="return checkIt(event)" value="<?php echo $db_pension;?>"/> %</td>                                  
                    </tr>
                    <tr>                    
                        <td colspan="2" style="padding-left: 150px; " ></br><input class="btn" style =" font-size: 12px; " type="submit" name="update" value="আপডেট করুন" />
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>
                    <?php }    
                    else { ?>
                    <tr>
                        <td colspan="2" style="text-align: center; font-size: 16px;color: green;"><?php echo $msg;?></td>          
                    </tr><?php }?>
                </table>
                </fieldset>
            </form>
</body>
</html>

