<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

if (isset($_POST['submit'])) 
{
    $p_lv_name= $_POST['leave_name'];
    $p_lv_code= $_POST['leave_code'];
    $p_lv_des= $_POST['leave_des'];
    $p_lv_deduct= $_POST['deduct'];
   $p_lv_deduct_value= $_POST['deductvalue'];
   $p_grd_id = $_POST['grdid'];
    $p_accepted = $_POST['acceptedLeave'];
    $count = count($p_accepted);

     $insquery = mysql_query("INSERT INTO leave_policy (leave_code, leave_name, description ,salary_deduct , deduct_percentage) 
            VALUES ('$p_lv_code','$p_lv_name','$p_lv_des','$p_lv_deduct','$p_lv_deduct_value')");
     
    if($insquery == 1)
    {  $msg = "ছুটি তৈরি হয়েছে"; }
   else {$msg = "ছুটি তৈরি হয়নি";}
}

// ******************* leave code update***************************    
$sql_leave = mysql_query("SELECT leave_code FROM `leave_policy` ORDER BY idleavepolicy DESC LIMIT 1 ");
$sqlrow = mysql_fetch_assoc($sql_leave);
if($sqlrow == "")
{
    $leaveCode = "leave-0000";
}
else
{
    $db_str_leaveCode = $sqlrow['leave_code'];
    $code = end(explode('-', $db_str_leaveCode));
    $y = (int)$code;
    $y=$y+1;
    $str_y= (string)$y;
    $yUpdate= str_pad($str_y,4, "0", STR_PAD_LEFT);
    $leaveCode = "leave-".$yUpdate;
}
?>
<title>ছুটি পলিসি তৈরি</title>
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
             document.getElementById('showReductionbox').style.visibility= 'visible';
        }
        else
            {
             document.getElementById('showReductionbox').style.visibility= 'hidden';  
           }
}
function beforeSubmit()
{
     var radiocheck = 0;
      var radios = document.getElementsByName("deduct");
      for(var i=0; i<radios.length; i++){
	if(radios[i].checked) { radiocheck = 1; }
	}
    if ((document.getElementById('leave_name').value !="") 
        && (radiocheck == 1))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>

<div class="column6">
    <div class="main_text_box">
                <div style="padding-left: 170px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
                <div class="domtab" style="font-family: SolaimanLipi !important;">
                    <ul class="domtabs" style=" margin-left: 150px;">
                        <li class="current"><a href="#01" style="width: 120px !important">নতুন ছুটি তৈরি</a></li> 
                        <li class="current"><a href="#02">ছুটির লিস্ট</a>
                    </ul>
                </div>
                
                <div>
                <h2><a name="01" id="01"></a></h2><br/>
                <form method="POST" action="leave_policy.php" style=" padding-left: 60px;" onsubmit="return beforeSubmit()">
                    <table  class="formstyle" style="font-family: SolaimanLipi !important;" > 
                         <tr><th colspan="2" style="text-align: center;">নতুন ছুটি তৈরি</th></tr>
                          <tr>
                        <td colspan="2" style="text-align: center; font-size: 16px;color: green;">  <?php if($msg != "") {echo $msg;}?></td>                                               
                    </tr>
                    <tr><td style="text-align: right; width: 40%"><b>ছুটির নাম : </b></td>
                        <td style="text-align: left; width: 60%"><input class="box" type="text" name="leave_name" id="leave_name"class="box" /><em2> *</em2></td>
                        </tr>
                        <tr><td style="text-align: right; width: 40%"><b>ছুটির কোড :</b></td>
                            <td style="text-align: left; width: 60%"> <input class="box" type="text" readonly="" name="leave_code" class="box" value="<?php echo $leaveCode;?>" /></td>
                        </tr>
                        <tr><td style="text-align: right; width: 40%"><b>বর্ণনা : </b></td>
                            <td style="text-align: left; width: 60%"><textarea class="box" type="text" name="leave_des" class="box" /></textarea></td>
                        </tr>
                        <tr><td style="text-align: right; width: 40%"><b >বেতন কর্তন : </b></td>
                            <td><input type='radio' name='deduct' id="deduct" value='yes' onclick = 'deduction(this.value)'/> হবে
                                    <input type='radio' name='deduct' id="deduct" value='no'  onclick = 'deduction(this.value)' /> হবে না <em2> *</em2></td>
                        </tr>
                        <tr><td style="text-align: right; width: 40%"><b>কর্তন পরিমান : </b></td>
                            <td><span  id="showReductionbox" style="visibility: hidden;" ><input class="box" type="text" name="deductvalue" onkeypress="return checkIt(event)" /> %</span></td>
                        </tr> 
                        <tr>                    
                            <td colspan="4" style="padding-left: 200px; " >
                                <?php 
                                if($_POST['submit'])
                            {?>
                                <a href='editLeavePolicy.php?lvcode=<?php echo $p_lv_code;?>'>পরবর্তী ধাপে যেতে ক্লিক করুন</a>
                            <?php }
                            else
                            {?>
                                <input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" />
                                <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" />
                            <?php }?></td>                           
                        </tr> 
                    </table>
                </form>
            </div>
            
                <div>
            <h2><a name="02" id="02"></a></h2><br/>
                <form method="POST" onsubmit="" style=" padding-left: 60px;">	
                    <table   class="formstyle" style="font-family: SolaimanLipi !important;">      
                        <tr>
                            <th colspan="8" >ছুটির লিস্ট </th>                        
                        </tr>  
                        <tr id = "table_row_odd">
                            <td width="29%" style="text-align: center;">ছুটির ধরণ</td>
                            <td width="27%" style="text-align: center;">ছুটির কোড</td>
                            <td width="28%" style="text-align: center;">বর্ণনা</td>
                            <td width="16%" style="text-align: center;"></td>
                        </tr>
                        <?php
                                            $sqllv = mysql_query("SELECT * FROM `leave_policy` ");
                                            while($lvrow = mysql_fetch_assoc($sqllv))
                                            {                                           
                                                echo "<tr><td>".$lvrow['leave_name']."</td>
                                                            <td>".$lvrow['leave_code']."</td>
                                                            <td>".$lvrow['description']."</td>
                                                            <td><a href='editLeavePolicy.php?lvcode=".$lvrow['leave_code']."'>এডিট করুন</a></td></tr>";             
                                            }
                          ?>
                    </table>
                </form>  
            </div>
       </div>
    </div>
<?php include_once 'includes/footer.php'; ?>