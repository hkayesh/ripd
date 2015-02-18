<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once './includes/selectQueryPDO.php';
include_once './includes/insertQueryPDO.php';

$logedinOfficeId = $_SESSION['loggedInOfficeID'];
$logedinOfficeType = $_SESSION['loggedInOfficeType'];
 $loginUSERid = $_SESSION['userIDUser'];
 
if(isset($_POST['submit']))
{
    $p_month = $_POST['month'];;
    $p_year = $_POST['year'];
    $monthName = date("F", mktime(0, 0, 0, $p_month, 10));
    
    $select_attendance->execute(array($p_year,$p_month,$loginUSERid));
    $attendrow = $select_attendance->fetchAll();
    foreach ($attendrow as $row) {
        $workingDays = $row['COUNT(idempattend)'];
    }
    $sql_select_emponsid->execute(array($loginUSERid));
    $row4 = $sql_select_emponsid->fetchAll();
    foreach ($row4 as $emprow) {
        $db_onsid = $emprow['emp_ons_id'];
    }
    $sel_salary_approval = $conn->prepare("SELECT * FROM salary_approval WHERE month_no= ? AND year_no=? AND salapp_onsid=? ");
    $sel_salary_approval->execute(array($p_month,$p_year,$db_onsid));
    $countrow = count($sel_salary_approval->fetchAll());
    if($countrow > 0)
    {
        $msg = "দুঃখিত, এই মাসের বেতন তৈরি করা হয়ে গেছে";
    }
 else { $msg = "";}
}

if(isset($_POST['makesalary']))
{
    // parent ons id find --------------------------------
   if($logedinOfficeType == 'office') 
 {
     $sql_select_office->execute(array($logedinOfficeId));
     $offrow = $sql_select_office->fetchAll();
     foreach ($offrow as $value) {
         $db_parent_id = $value['parent_id'];
         if($db_parent_id == 0)
         {
             $sql_select_id_ons_relation->execute(array($logedinOfficeType,$logedinOfficeId));
            $onsrow = $sql_select_id_ons_relation->fetchAll();
            foreach ($onsrow as $value) {
                $db_onsID = $value['idons_relation'];
            }
         }
        else {
            $sql_select_id_ons_relation->execute(array($logedinOfficeType,$db_parent_id));
            $onsrow = $sql_select_id_ons_relation->fetchAll();
            foreach ($onsrow as $value) {
                $db_onsID = $value['idons_relation'];
            }
        }
     }    
 }
 else
 {
     $sql_select_sales_store->execute(array($logedinOfficeId));
     $offrow = $sql_select_sales_store->fetchAll();
     foreach ($offrow as $value) {
         $db_parent_id = $value['powerstore_officeid'];
         if($db_parent_id == 0)
         {
              $sql_select_id_ons_relation->execute(array($logedinOfficeType,$logedinOfficeId));
                $onsrow = $sql_select_id_ons_relation->fetchAll();
                foreach ($onsrow as $value) {
                    $db_onsID = $value['idons_relation'];
                }
         }
         else
         {
             $catagory = 'office';
             $sql_select_id_ons_relation->execute(array($catagory,$db_parent_id));
                $onsrow = $sql_select_id_ons_relation->fetchAll();
                foreach ($onsrow as $value) {
                    $db_onsID = $value['idons_relation'];
                }
         }
     }    
 }
  //-----------------------------------------------------------------------
    $msg = "salary make";
    $p_onsid = $_POST['onsID'];
    $p_empCfsID = $_POST['empCFSid'];
    $p_monthlyPay = $_POST['monthlySalary'];
    $p_pension = $_POST['pension'];
    $p_loan = $_POST['loan'];
    $p_actual = $_POST['actual'];
    $p_xtrapay = $_POST['xtrapay'];
    $p_deduct = $_POST['deductpay'];
    $p_totalpay = $_POST['totalSalary'];
    $p_monthNo = $_POST['monthNo'];
    $p_yearNo = $_POST['yearNo'];
    $p_officeTotalSalary = $_POST['totalOfficeSalary'];
    $numberOfRows = count($p_empCfsID);
    
    $conn->beginTransaction(); 
    $sqlrslt1= $insert_sal_approval->execute(array($p_officeTotalSalary,$p_monthNo,$p_yearNo,$p_onsid,$loginUSERid));
    $sal_approval_id = $conn->lastInsertId();
    for($i=1;$i<=$numberOfRows;$i++)
    {
         $sqlrslt2= $insert_sal_chart->execute(array($p_monthNo, $p_yearNo,$p_actual[$i],$p_pension[$i],$p_loan[$i], $p_monthlyPay[$i], $p_deduct[$i], $p_xtrapay[$i], $p_totalpay[$i-1], $p_empCfsID[$i], $sal_approval_id));
    }
    $url = "salary_approval.php?id=".$sal_approval_id;
    $status = "unread";
    $type="action";
    $nfc_catagory="official";
    $sqlrslt3 = $insert_notification->execute(array($loginUSERid,$db_onsID,$msg,$url,$status,$type,$nfc_catagory));
   
     if($sqlrslt1  && $sqlrslt2 && $sqlrslt3)
        {
            $conn->commit();
            echo "<script>alert('বেতন সফলভাবে এন্ট্রি হয়েছে')</script>";
        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত,বেতন এন্ট্রি হয়নি')</script>";
        }
}
?>
<style type="text/css"> @import "css/bush.css";</style>
<style type="text/css">
    #search {
        width: 50px;background-color: #009933;border: 2px solid #0077D5;cursor: pointer; color: wheat;
    }
    #search:hover {
        background-color: #0077D5;border: 2px inset #009933;color: wheat;
    }
</style>
<script type="text/javascript">
    function checkIt(evt) // float value-er jonno***********************
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
function calculateSalaryMinus(deduct,i)
{
    var monthlypay = Number(document.getElementById("monthlySalary["+i+"]").value);
    var xtrapay = Number(document.getElementById("xtrapay["+i+"]").value);
    var salary = (monthlypay+ xtrapay) - Number(deduct);
    document.getElementById("totalSalary["+i+"]").value = salary;
    var finalsalary = 0;
    for (var j=1;j<=document.getElementsByName('totalSalary[]').length;j++){
        finalsalary = finalsalary + Number(document.getElementById('totalSalary['+j+']').value);
    }
    document.getElementById('totalOfficeSalary').value = finalsalary;
}
function calculateSalaryPlus(xtra,i)
{
    var monthlypay = Number(document.getElementById("monthlySalary["+i+"]").value);
    var deductpay = Number(document.getElementById("deductpay["+i+"]").value);
    var salary = (monthlypay - deductpay) + Number(xtra);
    document.getElementById("totalSalary["+i+"]").value = salary;
    var finalsalary = 0;
    for (var j=1;j<=document.getElementsByName('totalSalary[]').length;j++){
        finalsalary = finalsalary + Number(document.getElementById('totalSalary['+j+']').value);
    }
    document.getElementById('totalOfficeSalary').value = finalsalary;
}
function beforeSubmit()
{
    if ((document.getElementById('workingdays').value != 0) && (document.getElementById('totalOfficeSalary').value !=""))
        { return true; }
    else {
        return false; 
    }
}
</script>

    <div class="main_text_box" style="width: 100% !important;">
        <div style="padding-left: 50px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
          <div>
               <table  class="formstyle" style="width: 90% !important; font-family: SolaimanLipi !important;margin:0 auto !important;">          
                    <tr><th colspan="6" style="text-align: center;">কর্মচারীদের বেতন তৈরি</th></tr>
                    <tr>
                        <td colspan="6">
                            <fieldset style="border: #686c70 solid 3px;width: 50%;margin-left:25%;">
                                <legend style="color: brown">সার্চ</legend>
                                <form method="POST"  name="frm" action="">	
                                <table>
                                    <tr>
                                        <td >মাস </td>
                                        <td >
                                            <select style="border: 1px solid black" name="month">
                                                <option value="0">-সিলেক্ট করুন-</option>
                                                <option value="1">জানুয়ারী</option>
                                                <option value="2">ফেব্রুয়ারী</option>
                                                <option value="3">মার্চ</option>
                                                <option value="4">এপ্রিল</option>
                                                <option value="5">মে</option>
                                                <option value="6">জুন</option>
                                                <option value="7">জুলাই</option>
                                                <option value="8">আগস্ট</option>
                                                <option value="9">সেপেম্বর</option>
                                                <option value="10">অক্টোবর</option>
                                                <option value="11">নভেম্বর</option>
                                                <option value="12">ডিসেম্বর</option>
                                            </select>
                                        </td>
                                        <td >বছর</td>
                                        <td ><select class="box" style="width: 70px;" name="year">
                                                <option value="0">-বছর-</option>
                                                <?php
                                                    $thisYear = date('Y');
                                                    $startYear = '2000';

                                                    foreach (range($thisYear, $startYear) as $year) {
                                                    echo '<option value='.$year.'>'. $year .'</option>'; }
                                                ?>
                                            </select>
                                        </td>
                                        <td><input id="search" type="submit" name="submit" value="দেখুন" /></td>
                                    </tr>
                                </table>
                                </form>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                    <td colspan="2"></br>
                        <form method="post" action="" onsubmit="return beforeSubmit();">
                        <table cellspacing="0" cellpadding="0">
                            <?php 
                                if(isset($_POST['submit']))
                                     { ?>
                            <tr>
                                <td colspan="10" style="width: 25%; text-align: center"><b><?php echo $monthName.", ".$p_year;?>-এ মোট কার্যদিবস</b> : <?php echo $workingDays?><input type="hidden" id="workingdays" value="<?php echo $workingDays?>" />দিন 
                                    <input type="hidden" name="yearNo" value="<?php echo $p_year;?>" /><input type="hidden" name="monthNo" value="<?php echo $p_month;?>" /></br></br></td>
                            </tr>
                                     <?php }?>
                                        <tr id="table_row_odd">
                                                    <td style='border: 1px solid #000099;text-align: center;width: 1%;' ><strong>ক্রম</strong></td>
                                                    <td style='border: 1px solid #000099;text-align: center;width: 10%;' ><strong>কর্মচারীর নাম</strong></td>
                                                    <td style='border: 1px solid #000099;text-align: center;width: 5%;' ><strong>গ্রেড</strong></td>
                                                    <td style='border: 1px solid #000099;text-align: center;width: 10%;'><strong>পোস্ট</strong></td>
                                                    <td style='border: 1px solid #000099;text-align: center;width: 15%;'><strong>উপস্থিতির হিসেব</strong></td>
                                                     <td style='border: 1px solid #000099;text-align: center;width: 3%;'><strong>উপস্থিতির বিস্তারিত তথ্য</strong></td>
                                                    <td style='border: 1px solid #000099;text-align: center;width: 10%;'><strong>মূল বেতন (টাকা)</strong></td>
                                                    <td style='border: 1px solid #000099;text-align: center;width: 10%;'><strong>মাসে পাবে (পেনসন ও লোন বাদ)</strong></td>
                                                    <td style='border: 1px solid #000099;text-align: center;width: 10%;'><strong>অতিরিক্ত প্রদান (টাকা)</strong></td>
                                                    <td style='border: 1px solid #000099;text-align: center;width: 10%;'><strong>বেতন কর্তন (টাকা)</strong></td>
                                                    <td style='border: 1px solid #000099;text-align: center;width: 10%;'><strong>মোট বেতন (টাকা)</strong></td>
                                        </tr>
                                <tbody style="font-size: 12px !important">
                                 <?php
                                 if(isset($_POST['submit']))
                                 {
                                     if($msg != "")
                                     {
                                         echo "<tr><td colspan='11' style='text-align:center;color:red;'>$msg</td></tr>";
                                     }
                                else 
                                    {
                                        $sl = 1;
                                        $offTotalSalary = 0;
                                        $sql_select_all_employee->execute(array($db_onsid));
                                        $row5 = $sql_select_all_employee->fetchAll();
                                        foreach ($row5 as $allemprow) 
                                           {
                                               $db_name = $allemprow['account_name'];
                                               $db_userid = $allemprow['idUser'];
                                               $db_empID = $allemprow['idEmployee'];
                                               $sql_attend =$conn->prepare("SELECT COUNT(idempattend) FROM employee,employee_attendance WHERE emp_atnd_type=? AND  year_no =? AND month_no=? AND  cfs_user_idUser = ? AND idEmployee = emp_user_id ");
                                               $status1 = "present";
                                               $sql_attend->execute(array($status1,$p_year,$p_month,$db_userid));
                                               $row1 = $sql_attend->fetchAll();
                                               foreach ($row1 as $value) {
                                                   $presentDays = $value['COUNT(idempattend)'];
                                               }
                                               $status2 ="absent";
                                               $sql_attend->execute(array($status2,$p_year,$p_month,$db_userid));
                                               $row2 = $sql_attend->fetchAll();
                                               foreach ($row2 as $value) {
                                                   $absentDays = $value['COUNT(idempattend)'];
                                               }
                                               $status3 = "leave";
                                               $sql_attend->execute(array($status3,$p_year,$p_month,$db_userid));
                                               $row3 = $sql_attend->fetchAll();
                                               foreach ($row3 as $value) {
                                                   $leaveDays = $value['COUNT(idempattend)'];                                             
                                               }
                                               $sql_total_overtime->execute(array($p_year,$p_month,$db_userid));
                                               $row7 = $sql_total_overtime->fetchAll();
                                               foreach ($row7 as $value) {
                                                   $db_overtime = $value['SUM(emp_extratime)'];
                                               }
                                               $sel_emp_salary = $conn->prepare("SELECT * FROM employee_salary WHERE user_id= ? ORDER BY insert_date DESC LIMIT 1");
                                               $sel_emp_salary->execute(array($db_empID));
                                               $row6 = $sel_emp_salary->fetchAll();
                                               foreach ($row6 as $salaryrow) {
                                                   $db_main_salary = $salaryrow['total_salary'];
                                                   $db_pension = $salaryrow['pension'];
                                                   $db_loan = $salaryrow['loan_next'];
                                                   $totalsalary = $db_main_salary - ($db_pension + $db_loan);
                                                   $offTotalSalary = $offTotalSalary+$totalsalary;
                                               }
                                               $sql_select_employee_grade->execute(array($db_empID));
                                               $row8 = $sql_select_employee_grade->fetchAll();
                                               foreach ($row8 as $gradrow) {
                                                   $db_empgrade = $gradrow['grade_name'];
                                               }
                                               $sql_select_view_emp_post = $conn->prepare("SELECT post_name FROM employee_posting,post_in_ons,post 
                                                   WHERE Employee_idEmployee = ? AND ons_relation_idons_relation=? AND post_in_ons_idpostinons= idpostinons 
                                                   AND Post_idPost= idPost ORDER BY posting_date DESC LIMIT 1");
                                               $sql_select_view_emp_post->execute(array($db_empID,$db_onsid));
                                               $row9 = $sql_select_view_emp_post->fetchAll();
                                               foreach ($row9 as $postrow) {
                                                   $db_post = $postrow['post_name'];
                                               }
                                               echo "<tr><td style='border: 1px solid black; text-align: center'>".english2bangla($sl)."</td>
                                                   <td style='border: 1px solid black; text-align: left'>$db_name<input type='hidden' name='empCFSid[$sl]' value='$db_userid' /></td>
                                                    <td style='border: 1px solid black; text-align: center'>$db_empgrade<input type='hidden' name='onsID' value='$db_onsid' /></td>
                                                    <td style='border: 1px solid black; text-align: center'>$db_post</td>
                                                   <td style='border: 1px solid black; text-align: left'>
                                                    <b>উপস্থিতঃ</b> $presentDays দিন</br>
                                                    <b>অনুপস্থিতঃ</b> $absentDays দিন</br>
                                                    <b>ছুটিঃ</b> $leaveDays দিন</br>
                                                    <b>ওভারটাইমঃ</b> $db_overtime ঘণ্টা    
                                                   </td>
                                                   <td style='border: 1px solid black; text-align: center'><a style='cursor:pointer;color:blue;' id='details[$sl]' ><u>বিস্তারিত</u></a><input type='hidden' name='actual[$sl]' value='$db_main_salary' /></td>
                                                   <td style='border: 1px solid black; text-align: center'>".$db_main_salary."<input type='hidden' name='pension[$sl]' value='$db_pension' /><input type='hidden' name='loan[$sl]' value='$db_loan' /></td>
                                                   <td style='border: 1px solid black; text-align: center'><input type='hidden' name='monthlySalary[$sl]' id='monthlySalary[$sl]' value='$totalsalary' />".$totalsalary."</td>
                                                   <td style='border: 1px solid black; text-align: left;padding-left:0px;'><input class='box' type='text' style='width:92%;text-align:right' id='xtrapay[$sl]' name='xtrapay[$sl]' onkeypress='return checkIt(event)' onkeyup='calculateSalaryPlus(this.value,$sl)'  /></td>
                                                   <td style='border: 1px solid black; text-align: left;padding-left:0px;'><input class='box' type='text' style='width:92%;text-align:right;' id='deductpay[$sl]' name='deductpay[$sl]' onkeypress='return checkIt(event)' onkeyup='calculateSalaryMinus(this.value,$sl)' /></td>
                                                   <td style='border: 1px solid black; text-align: left;padding-left:0px;'><input class='box' type='text' style='width:92%;text-align:right;' readonly id='totalSalary[$sl]' name='totalSalary[]' value='$totalsalary' /></td></tr>";
                                               $sl++;
                                       }
                                       echo '<tr>
                                                <td colspan="10" style="border: 1px solid black; text-align: right"><b>মোট</b></td>
                                                <td style="border: 1px solid black; text-align: right;padding-left:0px;"><input class="box" type="text" style="width:92%;text-align:right;" readonly name="totalOfficeSalary" id="totalOfficeSalary" value="'.$offTotalSalary.'" /></td>
                                            </tr>
                                            <tr><td colspan="11" style="text-align: center;"></br><input class="btn" readonly="" type="submit" name="makesalary" value="বেতন প্রদান করুন" style="width: 150px;" /></td></tr>';
                                    }
                                 }
                                ?>
                                </tbody>
                            </table>
                            </form>
                           </td>
                    </tr>
                </table>
        </div>                 
    </div>
    <?php include_once 'includes/footer.php';?>
