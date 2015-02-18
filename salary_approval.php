<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once './includes/selectQueryPDO.php';
include_once './includes/insertQueryPDO.php';
include_once './includes/updateQueryPDO.php';
 $loginUSERid = $_SESSION['userIDUser'] ;
$g_approvalID = $_GET['id'];
$g_nfcid = $_GET['nfcid'];
$sel_select_sal_approval = $conn->prepare("SELECT * FROM salary_approval WHERE salappid= ?");
$sel_select_sal_approval->execute(array($g_approvalID));
$row = $sel_select_sal_approval->fetchAll();
foreach ($row as $salapprovalrow) {
     $db_officeTotalSalary = $salapprovalrow['total_month_salary'];
    $db_month = $salapprovalrow['month_no'];
    $db_year = $salapprovalrow['year_no'];
    $monthName = date("F", mktime(0, 0, 0, $db_month, 10));
    $db_onsid = $salapprovalrow['salapp_onsid'];
    $sql_select_ons_relation->execute(array($db_onsid));
    $row1 = $sql_select_ons_relation->fetchAll();
    foreach ($row1 as $onsrow) {
        $db_onstype = $onsrow['catagory'];
        $db_offid = $onsrow['add_ons_id'];
    }
    if($db_onstype == 'office')
    {
        $sql_select_office->execute(array($db_offid));
        $row2 = $sql_select_office->fetchAll();
        foreach ($row2 as $value) {
            $db_offname = $value['office_name'];
        }
    }
 else {
        $sql_select_sales_store->execute(array($db_offid));
        $row2 = $sql_select_sales_store->fetchAll();
        foreach ($row2 as $value) {
            $db_offname = $value['salesStore_name'];
        }
    }
}
$sel_emp_from_salary = $conn->prepare("SELECT user_id FROM salary_approval,salary_chart WHERE fk_sal_aprv_salappid = salappid AND salappid=? LIMIT 1");
$sel_emp_from_salary->execute(array($g_approvalID));
$row3 = $sel_emp_from_salary->fetchAll();
foreach ($row3 as $value) {
    $db_empcfsid = $value['user_id'];
}
 $select_attendance->execute(array($db_year,$db_month,$db_empcfsid));
 $attendrow = $select_attendance->fetchAll();
 foreach ($attendrow as $row) {
      $workingDays = $row['COUNT(idempattend)'];
  }  

if(isset($_POST['givsalary']))
{
    $p_approvalID = $_POST['salaApprovalID'];
    $p_officeTotalSalary = $_POST['totalOfficeSalary'];
    $p_empCfsID = $_POST['empCFSid'];
    $p_xtrapay = $_POST['xtrapay'];
    $p_deduct = $_POST['deductpay'];
    $p_totalpay = $_POST['totalSalary'];
    $numberOfRows = count($p_empCfsID);
    
    $url = "";
    $personal_status = "unread";
    $type="msg";
    $nfc_catagory="personal"; 
    
    $conn->beginTransaction(); 
    $sqlrslt1= $sql_update_sal_approval->execute(array($p_officeTotalSalary,$loginUSERid,$p_approvalID));
    for($i=1;$i<=$numberOfRows;$i++)
    {
         $sqlrslt2= $sql_update_salary_chart->execute(array($p_deduct[$i], $p_xtrapay[$i], $p_totalpay[$i-1], $p_approvalID,$p_empCfsID[$i]));
         $notice = $monthName." ,".$db_year." -এর বেতন বাবদ ".$p_totalpay[$i-1]." টাকা আপনার একাউন্টে জমা হয়েছে";
         $sqlrslt4 = $insert_notification->execute(array($loginUSERid,$p_empCfsID[$i],$notice,$url,$personal_status,$type,$nfc_catagory));
    }
    $status = 'complete';
    $sqlrslt3 = $sql_update_notification->execute(array($status,$g_nfcid));
     if($sqlrslt1  && $sqlrslt2 && $sqlrslt3 && $sqlrslt4)
        {
            $conn->commit();
            echo "<script>alert('বেতন সফলভাবে মঞ্জুর হয়েছে');
                window.location = 'main_account_management.php';</script>";
        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত,বেতন মঞ্জুর হয়নি')</script>";
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
</script>

    <div class="main_text_box" style="width: 100% !important;">
        <div style="padding-left: 50px;"><a href="notification.php"><b>ফিরে যান</b></a></div>
          <div>
               <table  class="formstyle" style="width: 90% !important; font-family: SolaimanLipi !important;margin:0 auto !important;">          
                    <tr><th colspan="6" style="text-align: center;">বেতন মঞ্জুর</th></tr>
                    <tr>
                    <td colspan="2">
                        <form method="post" action="" >
                        <table cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="11" style="width: 25%; text-align: center;font-size: 25px;color: #009933;"><b><?php echo $db_offname;?></b><input type="hidden" name="approvalID" value="<?php ?>" /></td>
                            </tr>
                            <tr>
                                <td colspan="11" style="width: 25%; text-align: center"><b><?php echo $monthName.", ".$db_year;?>-এ মোট কার্যদিবস</b> : <?php echo $workingDays?>দিন</br></br></td>
                            </tr>
                            <tr id="table_row_odd">
                                        <td style='border: 1px solid #000099;text-align: center;width: 1%;' ><strong>ক্রম</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 10%;' ><strong>কর্মচারীর নাম</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 5%;' ><strong>গ্রেড</strong></td>
                                        <td style='border: 1px solid #000099;text-align: center;width: 10%;' ><strong>পোস্ট</strong></td>
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
                                     $sl = 1;
                                     $sql_select_salary_chart=$conn->prepare("SELECT * FROM salary_chart WHERE fk_sal_aprv_salappid = ?");
                                     $sql_select_salary_chart ->execute(array($g_approvalID));
                                     $row4 = $sql_select_salary_chart->fetchAll();
                                     foreach ($row4 as $chartrow) 
                                        {
                                              $db_userid = $chartrow['user_id'];
                                              $db_monthlypay = $chartrow['given_amount'];
                                              $db_xtrapay = $chartrow['bonus_amount'];
                                              $db_deductpay = $chartrow['deducted_amount'];
                                              $db_totalpay = $chartrow['total_given_amount'];
                                              $sql_select_cfs_user_all->execute(array($db_userid));
                                              $row5=$sql_select_cfs_user_all->fetchAll();
                                              foreach ($row5 as $value) {
                                                  $db_name = $value['account_name'];
                                              }
                                              $sql_select_emp_from_cfs = $conn->prepare("SELECT idEmployee FROM employee WHERE cfs_user_idUser=?");
                                              $sql_select_emp_from_cfs->execute(array($db_userid));
                                              $arr_row = $sql_select_emp_from_cfs->fetchAll();
                                              foreach ($arr_row as $value) {
                                                  $db_empID = $value['idEmployee'];
                                              }
                                               $sql_attend =$conn->prepare("SELECT COUNT(idempattend) FROM employee,employee_attendance WHERE emp_atnd_type=? AND  year_no =? AND month_no=? AND  cfs_user_idUser = ? AND idEmployee = emp_user_id ");
                                               $status1 = "present";
                                               $sql_attend->execute(array($status1,$db_year,$db_month,$db_userid));
                                               $row1 = $sql_attend->fetchAll();
                                               foreach ($row1 as $value) {
                                                   $presentDays = $value['COUNT(idempattend)'];
                                               }
                                               $status2 ="absent";
                                               $sql_attend->execute(array($status2,$db_year,$db_month,$db_userid));
                                               $row2 = $sql_attend->fetchAll();
                                               foreach ($row2 as $value) {
                                                   $absentDays = $value['COUNT(idempattend)'];
                                               }
                                               $status3 = "leave";
                                               $sql_attend->execute(array($status3,$db_year,$db_month,$db_userid));
                                               $row3 = $sql_attend->fetchAll();
                                               foreach ($row3 as $value) {
                                                   $leaveDays = $value['COUNT(idempattend)'];                                             
                                               }
                                               $sql_total_overtime->execute(array($db_year,$db_month,$db_userid));
                                               $row7 = $sql_total_overtime->fetchAll();
                                               foreach ($row7 as $value) {
                                                   $db_overtime = $value['SUM(emp_extratime)'];
                                               }
                                               $sel_emp_salary = $conn->prepare("SELECT * FROM employee_salary WHERE user_id= ?");
                                               $sel_emp_salary->execute(array($db_empID));
                                               $row6 = $sel_emp_salary->fetchAll();
                                               foreach ($row6 as $salaryrow) {
                                                   $db_main_salary = $salaryrow['total_salary'];
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
                                               echo "<tr><td style='border: 1px solid black; text-align: center'>".  english2bangla($sl)."</td>
                                                   <td style='border: 1px solid black; text-align: left'>$db_name<input type='hidden' name='empCFSid[$sl]' value='$db_userid' /></td>
                                                    <td style='border: 1px solid black; text-align: center'>$db_empgrade<input type='hidden' name='salaApprovalID' value='$g_approvalID' /></td>
                                                    <td style='border: 1px solid black; text-align: center'>$db_post</td>
                                                   <td style='border: 1px solid black; text-align: left'>
                                                    <b>উপস্থিতঃ</b> $presentDays দিন</br>
                                                    <b>অনুপস্থিতঃ</b> $absentDays দিন</br>
                                                    <b>ছুটিঃ</b> $leaveDays দিন</br>
                                                    <b>ওভারটাইমঃ</b> $db_overtime ঘণ্টা    
                                                   </td>
                                                   <td style='border: 1px solid black; text-align: center'><a style='cursor:pointer;color:blue;' id='details[$sl]' ><u>বিস্তারিত</u></a></td>
                                                   <td style='border: 1px solid black; text-align: center'>".$db_main_salary."</td>
                                                   <td style='border: 1px solid black; text-align: center'><input type='hidden' name='monthlySalary[$sl]' id='monthlySalary[$sl]' value='$db_monthlypay' />".$db_monthlypay."</td>
                                                   <td style='border: 1px solid black; text-align: left;padding-left:0px;'><input class='box' type='text' style='width:92%;text-align:right' id='xtrapay[$sl]' name='xtrapay[$sl]' onkeypress='return checkIt(event)' value='$db_xtrapay' onkeyup='calculateSalaryPlus(this.value,$sl)' /></td>
                                                   <td style='border: 1px solid black; text-align: left;padding-left:0px;'><input class='box' type='text' style='width:92%;text-align:right;' id='deductpay[$sl]' name='deductpay[$sl]' onkeypress='return checkIt(event)' onkeyup='calculateSalaryMinus(this.value,$sl)' value='$db_deductpay' /></td>
                                                   <td style='border: 1px solid black; text-align: left;padding-left:0px;'><input class='box' type='text' style='width:92%;text-align:right;' readonly id='totalSalary[$sl]' name='totalSalary[]' value='$db_totalpay' /></td></tr>";
                                               $sl++;
                                        }
                                ?>
                                    <tr>
                                        <td colspan="10" style='border: 1px solid black; text-align: right'><b>মোট</b></td>
                                        <td style='border: 1px solid black; text-align: right;padding-left:0px;'><input class='box' type='text' style='width:92%;text-align:right;' readonly name='totalOfficeSalary' id="totalOfficeSalary" value="<?php echo $db_officeTotalSalary;?>" /></td>
                                    </tr>
                                    <tr><td colspan="11" style="text-align: center;"></br><input class="btn" type="submit" name="givsalary" value="বেতন মঞ্জুর" /></td></tr>
                                </tbody>
                            </table>
                            </form>
                           </td>
                    </tr>
                </table>
        </div>                 
    </div>
    <?php include_once 'includes/footer.php';?>
