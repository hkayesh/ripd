<?php
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$lvingrdsql = "UPDATE `leave_in_grade` SET `no_of_days` = ? WHERE `pay_grade_idpaygrade` =? AND `leave_policy_idleavepolicy` =?";
$lv_up_stmt = $conn->prepare($lvingrdsql);

if (isset($_POST['submit'])) 
{
    $p_lvid = $_POST['leave_id'];
    $p_lv_name= $_POST['leave_name'];
    $p_lv_code= $_POST['leave_code'];
    $p_lv_des= $_POST['leave_des'];
    $p_lv_deduct= $_POST['deduct'];
   $p_lv_deduct_value= $_POST['deductvalue'];
   $p_grd_id = $_POST['grdid'];
    $p_accepted = $_POST['acceptedLeave'];
    $count = count($p_accepted);

    $policy_up_query = mysql_query("UPDATE `leave_policy` SET `leave_name` ='$p_lv_name', description= '$p_lv_des',salary_deduct='$p_lv_deduct' ,deduct_percentage='$p_lv_deduct_value' WHERE `leave_code` ='$p_lv_code';");
     
    if($policy_up_query == 1)
    {
        for($i=0;$i<$count;$i++)
        {
            $accepted = $p_accepted[$i];
            $grdid = $p_grd_id[$i];
            $what = $lv_up_stmt->execute(array($accepted,$grdid,$p_lvid));
        }
         if($what==1)
            {
                $msg = "ছুটি আপডেট হয়েছে";
            }
            else {$msg = "ছুটি আপডেট হয়নি";}
    }
    else {$msg = "এরর";}
}

$g_lv_code =  $_GET['lvcode'];
$sql_lvpolicy = mysql_query("SELECT * FROM leave_policy WHERE leave_code = '$g_lv_code';");
$policyrow = mysql_fetch_assoc($sql_lvpolicy);
$db_policyid=$policyrow['idleavepolicy'];
$db_lvname = $policyrow['leave_name'];
$db_lvdes = $policyrow['description'];
$db_saldeduct = $policyrow['salary_deduct'];
$db_deductionvalue = $policyrow['deduct_percentage'];
?>
<title>ছুটি পলিসি পরিবর্তন</title>
<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript"> 
    function checkIt(evt) // price-er jonno***********************
    {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        status = "";
        return true;
    }
    status = "This field accepts numbers only.";
    return false;
}

function deduction(checkvalue)
{
      if(checkvalue == 'yes')
        {
             document.getElementById('deductvalue').style.visibility= 'visible';
        }
        else
            {
             document.getElementById('deductvalue').style.visibility= 'hidden';  
           }
}
</script>

<div class="column6">
    <div class="main_text_box">
                <div style="padding-left: 170px;"><a href="leave_policy.php"><b>ফিরে যান</b></a></div>
                <form method="POST" action="" style=" padding-left: 60px;">
                    <table  class="formstyle" style="font-family: SolaimanLipi !important;" > 
                         <tr><th colspan="2" style="text-align: center;">ছুটি পলিসি পরিবর্তন</th></tr>
                          <tr>
                        <td colspan="2" style="text-align: center; font-size: 16px;color: green;">  <?php if($msg != "") {echo $msg;}?></td>                                               
                    </tr>
                        <tr><td><b>ছুটির নাম : </b></td>
                            <td><input class="box" type="text" name="leave_name" class="box" value="<?php echo $db_lvname;?>" />
                                <input class="box" type="hidden" name="leave_id" class="box" value="<?php echo $db_policyid;?>" /></td>
                        </tr>
                        <tr><td><b>ছুটির কোড :</b></td>
                            <td> <input class="box" type="hidden" readonly="" name="leave_code" class="box" value="<?php echo $g_lv_code;?>" /><?php echo $g_lv_code;?></td>
                        </tr>
                        <tr><td><b>বর্ণনা : </b></td>
                            <td><textarea class="box" type="text" name="leave_des" class="box" /><?php echo $db_lvdes;?></textarea></td>
                        </tr>
                        <?php
                            if($db_saldeduct == 'yes')
                            {
                        ?>
                        <tr><td><b>বেতন কর্তন : </b></td>
                            <td><input type='radio' name='deduct' id="deduct" value='yes' onclick = 'deduction(this.value)' checked=""/> হবে
                                    <input type='radio' name='deduct' id="deduct" value='no'  onclick = 'deduction(this.value)' /> হবে না</td>
                        </tr>
                        <tr><td><b>কর্তন পরিমান : </b></td>
                            <td><input class="box" type="text" id="deductvalue" name="deductvalue" onkeypress="return checkIt(event)" value="<?php echo $db_deductionvalue; ?>"/> %</td>
                        </tr>
                        <?php
                            }
                            else 
                            {
                        ?>
                         <tr><td><b>বেতন কর্তন : </b></td>
                            <td><input type='radio' name='deduct' id="deduct" value='yes' onclick = 'deduction(this.value)' /> হবে
                                <input type='radio' name='deduct' id="deduct" value='no'  onclick = 'deduction(this.value)' checked="" /> হবে না</td>
                        </tr>
                        <tr><td><b>কর্তন পরিমান : </b></td>
                            <td><input class="box" type="text" id="deductvalue" name="deductvalue" onkeypress="return checkIt(event)" value="0"/> %</td>
                        </tr>
                            <?php }?>
                        <tr>
                            <td colspan="2" ></br><hr /></br></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table>
                                    <tr id = "table_row_odd">
                                        <td width="43%" style="text-align: center;"><b>ক্যাটাগরি</b></td>
                                        <td width="27%" style="text-align: center;"><b>গ্রেড</b></td>
                                        <td width="30%" style="text-align: center;"><b>প্রাপ্ত ছুটি</b></td>
                                    </tr>
                                        <?php
                                            $sqlgrd = mysql_query("SELECT * FROM `pay_grade` ORDER BY employee_type ");
                                            while($grdrow = mysql_fetch_assoc($sqlgrd))
                                            {                                           
                                                $paygradeid = $grdrow['idpaygrade'];
                                                $sql_lvingrade = mysql_query("SELECT * FROM leave_in_grade WHERE pay_grade_idpaygrade=$paygradeid AND leave_policy_idleavepolicy= $db_policyid");
                                                $leaveingrdrow = mysql_fetch_assoc($sql_lvingrade);
                                               $leavedays = $leaveingrdrow['no_of_days'];
                                                echo "<tr><td>".$grdrow['employee_type']."</td>
                                                            <td>".$grdrow['grade_name']."<input name='grdid[]' type='hidden' value='".$grdrow['idpaygrade']."'/></td>
                                                            <td><input  type='text' style='width:100%;text-align: center;' name='acceptedLeave[]' onkeypress='return checkIt(event)' value='$leavedays''/></td></tr>";             
                                            }
                                        ?>
                                </table>
                            </td>
                        </tr>
                        <tr>                    
                            <td colspan="4" style="padding-left: 200px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" />
                                <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                        </tr> 
                    </table>
                </form>
       </div>
    </div>
<?php 
include_once 'includes/footer.php'; 
?>