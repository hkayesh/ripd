<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$msg = "";
if(isset($_POST['submit']))
{
    $p_catagory = $_POST['catagory'];
    $p_grade = $_POST['grade'];
    $p_minsalary = $_POST['min_sal'];
    $p_maxsalary = $_POST['max_sal'];
    $p_pension = $_POST['pension'];
    
    $insquery = mysql_query("INSERT INTO pay_grade (grade_name, employee_type, max_salary ,min_salary , insert_date , pension ) 
            VALUES ('$p_grade','$p_catagory',$p_maxsalary,$p_minsalary,NOW(),$p_pension)");
    if($insquery == 1)
    {
        $msg = "গ্রেড-সেলারি সফলভাবে এন্ট্রি হয়েছে";
    }
    else {$msg = "গ্রেড-সেলারি এন্ট্রি হয়নি";}
}
?>
<title>মেইক সেলারি রেঞ্জ</title>
<style type="text/css"> @import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
  <script type="text/javascript">
 function update(id)
	{ TINY.box.show({iframe:'updateSalaryRange.php?gradeid='+id,width:500,height:280,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
 </script>
<script>
function checkIt(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        status = "";
        return true;
    }
    status = "This field accepts numbers only.";
    return false;
}
function beforSubmit()
{
    var getoption = document.getElementById('catagory');
    if (getoption.options[getoption.selectedIndex].value != "")
        {
            document.getElementById('save').readonly = false;
            return true;
        }
        else {
            document.getElementById('save').readonly = true;
            return false;
        }
}
</script>

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
        <div class="domtab" style="font-family: SolaimanLipi !important;">
            <ul class="domtabs">
                <li class="current"><a href="#01" style="width: 200px !important">ক্রিয়েট গ্রেড অ্যান্ড সেলারি</a></li> 
                <li class="current"><a href="#02">গ্রেড লিস্ট</a>
            </ul>
        </div>   

        <div>
            <h2><a name="01" id="01"></a></h2><br/>
            <form method="POST" onsubmit="" name="" action="make_grade_salary_range.php">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;">          
                    <tr><th colspan="2" style="text-align: center;">ক্রিয়েট গ্রেড অ্যান্ড সেলারি</th></tr>
                    <tr>
                        <td colspan="2" style="text-align: center; font-size: 16px;color: green;">  <?php if($msg != "") {echo $msg;}?></td>                                               
                    </tr>
                    <tr>
                        <td>ক্যাটাগরি</td>
                        <td>: <select class="selectOption" name="catagory" id="catagory" style="width: 167px !important;font-family: SolaimanLipi !important; font-size: 14px;">
                                <option value="">--ক্যাটাগরি সিলেক্ট করুন--</option>
                                <option value="presenter">প্রেজেন্টার</option>
                                <option value="programmer">প্রোগ্রামার</option>
                                <option value="trainer">ট্রেইনার</option>
                                <option value='traveller'>ট্র্যাভেলার</option>
                                <option value="employee">এমপ্লই</option>
                            </select>
                        </td>            
                    </tr>
                    <tr>
                        <td>গ্রেড</td>
                        <td>:   <input class="box" type="text" id="grade" name="grade" /></td>                                  
                    </tr>
                    <tr>
                        <td>সর্বনিম্ন সেলারি</td>
                        <td>:   <input class="box" type="text" id="min_sal" name="min_sal" onkeypress="return checkIt(event)" /> টাকা</td>                                  
                    </tr>
                    <tr>
                        <td>সর্বোচ্চ সেলারি</td>
                        <td>:   <input class="box" type="text" id="max_sal" name="max_sal" onkeypress="return checkIt(event)" /> টাকা</td>                                  
                    </tr>
                    <tr>
                        <td>পেনসন</td>
                        <td>:   <input class="box" type="text" id="pension" name="pension" onkeypress="return checkIt(event)"/> %</td>                                  
                    </tr>
                    <tr>                    
                        <td colspan="2" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" id="save" name="submit" readonly="" onclick="return beforSubmit()" value="সেভ করুন" />
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>

        <div>
            <h2><a name="02" id="02"></a></h2><br/>
            <form method="POST" onsubmit="" name="frm" action="">	
                <table  class="formstyle">          
                    <tr><th colspan="2" style="text-align: center;">গ্রেড লিস্ট</th></tr>
                      <td colspan="6">
                            <span id="office2">
                                <table  style="border: black solid 1px;" align="center" width= 90%" cellpadding="1px" cellspacing="1px">
                                    <thead>
                                        <tr style="border: black solid 1px;">
                                        <th>ক্যাটাগরি</th>
                                        <th>গ্রেড</th>
                                        <th>সেলারি রেঞ্জ</th>
                                        <th>পেনসন (%)</th>
                                        <th></th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql_paygrade = "SELECT * FROM pay_grade ORDER BY employee_type ASC";
                                    $rs = mysql_query($sql_paygrade);

                                    while ($rowpaygrade = mysql_fetch_assoc($rs)) 
                                    {
                                        $gradid = $rowpaygrade['idpaygrade'];
                                        echo "<tr>";
                                        echo "<td style='text-align:center;'>".$rowpaygrade['employee_type']."</td>";
                                        echo "<td style='text-align:center;'>".$rowpaygrade['grade_name']."</td>";
                                        echo "<td style='text-align:center;'>".$rowpaygrade['min_salary']." - ".$rowpaygrade['max_salary']."</td>";
                                        echo "<td style='text-align:center;'>".$rowpaygrade['pension']."</td>";
                                        echo "<td><a onclick='update($gradid)' style='cursor:pointer;color:blue;'><u>এডিট করুন</u></a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                           </span>  
                        </td>
                    </tr>    
                    </table>
            </form>
        </div>                 
    </div>
    </div>
    <?php
    include_once 'includes/footer.php';
    ?>