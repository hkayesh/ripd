<?php
//error_reporting(0);
include_once 'includes/MiscFunctions.php';
include_once 'includes/header.php';
include_once './includes/insertQueryPDO.php';
include_once './includes/updateQueryPDO.php';
include_once './includes/selectQueryPDO.php';
$arrayUserType = array('employee' => 'কর্মচারী', 'programmer' => 'প্রোগ্রামার', 'presenter' => 'প্রেজেন্টার', 'trainer' => 'trainer');
function getGrade($sql,$type)
{
    $sql->execute(array($type));
    $row5 = $sql->fetchAll();
     echo  "<option value=0> -সিলেক্ট করুন- </option>";
    foreach ($row5 as $graderow) {
         echo  "<option value=".$graderow['idpaygrade'].">".$graderow['grade_name']."</option>";
    }
}
function getPosts($sql,$offid)
{
    $offtype = 'office';
    $sql->execute(array($offid,$offtype));
    $row6 = $sql->fetchAll();
     echo  "<option value=0> -সিলেক্ট করুন- </option>";
    foreach ($row6 as $postrow) {
         echo  "<option value=".$postrow['idpostinons'].">".$postrow['post_name']."</option>";
    }
}
if(isset($_POST['promotion']))
{
     $p_oldOnSID = $_POST['oldonsID'];
     $p_oldPostingID = $_POST['oldpost'];
     $p_empID = $_POST['empID'];
     $p_newgrade = $_POST['nextGrade'];
     $p_newSalary = $_POST['nextSalary'];
     $p_newPostinID = $_POST['newpostID'];
     echo $p_loannext = $_POST['loanAmount'];
     echo $p_repaymonth = $_POST['repayMonth'];
     $p_loanID = $_POST['loanID'];
     $todate = date("Y-m-d");
     $conn->beginTransaction();
     $emppromotion =$sql_insert_employee_salary->execute(array($p_newSalary,$p_loannext,$p_repaymonth,$p_loanID,$p_empID, $p_newgrade));
     if($p_newPostinID != 0)
     {
            $empposting =$sql_insert_employee_posting->execute(array($todate, $p_empID, $p_oldOnSID,$p_newPostinID));
            $update1=$sql_update_post_in_ons_up->execute(array($p_oldPostingID));
            $update2=$sql_update_post_in_ons_down->execute(array($p_newPostinID));
     }
     
     if(($emppromotion) || ($empposting && $update2 && $update1))
     {
         $conn->commit();
         echo "<script>alert('প্রোমোশন হয়েছে')</script>";
     }
     else {
                $conn->rollBack();
                echo "<script>alert('দুঃখিত,প্রোমোশন হয়নি')</script>";
            }
}
?>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css">
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
function checkSalaryRange(sal)
    {
        var range = document.getElementById('SalaryRange').innerText;
        var myarr = range.split("-");
        var min = myarr[0];
        var max = myarr[1];
        var sal = Number(sal);
        if ((sal <= max) && (sal >= min))
        {
            document.getElementById('showerror').innerHTML = "";
        }
        else {
            document.getElementById('showerror').innerHTML = "দুঃখিত, সেলারি রেঞ্জ অতিক্রম করেছে";
        }
    }
function checkIt(evt) // float value-er jonno***********************
    {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 8 || (charCode > 47 && charCode < 58) || charCode == 46) {
            status = "";
            return true;
        }
        status = "This field accepts numbers only.";
        return false;
    }
function beforeSubmit()
{
    if ((document.getElementById('nextSalary').value != "")
                && (document.getElementById('SalaryRange').innerHTML != "")
                && (document.getElementById('showerror').innerHTML == ""))
        { return true; }
    else { alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন"); return false; }
}
 function showSalaryRange(paygrdid) // for selecting salary range according to grade
    {
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("SalaryRange").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "includes/getGradeForEmployeeType.php?paygrdid=" + paygrdid + "&step=2", true);
        xmlhttp.send();
    }
</script>
<script type="text/javascript">
    function selectOffice()
    { TINY.box.show({iframe:'includes/select_office.php',width:900,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
    
    function promotionSalaryUpdate()
    {
        TINY.box.show({iframe:'includes/promotion_salary_update.php',width:650,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); 
    }
</script>

<div class="main_text_box">
        <?php
        $back_parent = $_GET['bkprnt'];
        $back_parent_change = str_replace("%%", "&", $back_parent);
        echo "<div style='padding-left: 110px;'><a href='$back_parent_change'><b>ফিরে যান</b></a></div>";
        ?>
        <div>
            <form  method="post" style="width: 90%;" action="" onsubmit="return beforeSubmit()">
                <?php
                $g_officeID = end(explode("=", $back_parent_change));
                $employee_id = $_GET['0to1o1ff01i0c1e0'];
                $sql_select_office->execute(array($g_officeID));
                        $row9 = $sql_select_office->fetchAll();
                        foreach ($row9 as $offrow) {
                            $offname1 = $offrow['office_name'];
                        } 
                $sql_select_emplyee_cfs->execute(array($employee_id));
                $row1 = $sql_select_emplyee_cfs->fetchAll();
                foreach ($row1 as $cfs_row) {
                    $db_old_onsid = $cfs_row['emp_ons_id'];
                    $db_cfs_name = $cfs_row['account_name'];
                    $db_cfs_account = $cfs_row['account_number'];
                    $db_mobile = $cfs_row['mobile'];
                    $db_picture = $cfs_row['emplo_scanDoc_picture'];
                    $db_cfsuserid = $cfs_row['idUser'];
                    $db_usertype = $cfs_row['user_type'];
                }
                $sql_select_emp_address->execute(array($employee_id));
                $row2 = $sql_select_emp_address->fetchAll();
                foreach ($row2 as $addressrow) {
                    $db_house = $addressrow['house'];
                    $db_houseno = $addressrow['house_no'];
                    $db_road = $addressrow['house'];
                    $db_thana = $addressrow['thana_name'];
                    $db_district = $addressrow['district_name'];
                    $db_division = $addressrow['division_name'];
                }
                    $sql_select_employee_grade->execute(array($employee_id));
                    $row3 = $sql_select_employee_grade->fetchAll();
                    foreach ($row3 as $arr_grade) {
                        $db_salary = $arr_grade['total_salary'];
                        $db_gradename = $arr_grade['grade_name'];
                        $db_loannext = $arr_grade['loan_next'];
                        $db_repaymonth = $arr_grade['loan_repay_month'];
                        $db_loanID = $arr_grade['fk_idloan'];
                    }
                                                           
                    $sql_select_emp_post->execute(array($db_cfsuserid));
                    $row4 = $sql_select_emp_post->fetchAll();
                    foreach ($row4 as $arr_row) {
                        $db_post = $arr_row['post_name'];
                        $db_idposting = $arr_row['idpostinons'];
                        $db_postingDate = $arr_row['posting_date'];
                    }                                  
                echo "<table  class='formstyle'>";
                echo "<tr>
                                <th colspan='4' style='text-align: center'>
                                <div style='width: 80%; float: left; padding-top: 18px;'>
                                    <h1>".$db_cfs_name."</h1>
                                    <h2>".$db_cfs_account."</h2>
                                    <h3>মোবাইলঃ ".$db_mobile."</h3>
                                    <h3>বাসা-".$db_house.",".$db_houseno.", রোড-".$db_road.", থানাঃ ".$db_thana.", জেলাঃ".$db_district.", বিভাগঃ".$db_division."</h3>
                                </div>
                                <div style='float: right'><img src='".$db_picture."' style='width:150px;height:150px;' /></div></th>
                            </tr>";
                echo "<tr><td colspan='4'><hr></td></tr>";
                echo '<tr>
                     <td colspan="4">
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">বর্তমান অবস্থা</legend>
                            <table>
                            <tr>
                                <td style="width: 25%; text-align:right">অফিস</td>
                                <td style="width: 25%;text-align:left">: '.$offname1.'<input type="hidden" name="oldonsID" value="'.$db_old_onsid.'" /></td>
                                <td style="width: 25%; text-align:right">কর্মচারীর ধরন</td>
                                <td style="width: 25%; text-align:left">: '.$arrayUserType[$db_usertype].'<input type="hidden" name="empID" value="'.$employee_id.'" /></td>
                            </tr>
                            <tr>
                               <td style="text-align:right">পোস্ট<input type="hidden" name="oldpost" value="'.$db_idposting.'" /></td>
                                <td style="text-align:left">: '.$db_post.'</td>
                                <td style=" text-align:right">গ্রেড</td>
                                <td style=" text-align:left">: '.$db_gradename.'</td>
                            </tr>
                            <tr>
                               <td style="text-align:right">যোগদানের তারিখ</td>
                                <td style="text-align:left">: '.english2bangla(date("d/m/Y",  strtotime($db_postingDate))).'</td>
                                <td style="text-align:right">বেতন</td>
                                <td style="text-align:left">: '.english2bangla($db_salary).' টাকা</td>
                            </tr>
                            </table>
                            </filedset></td>
                    </tr>';

                $sql_select_working_days->execute(array($db_cfsuserid));
                        $row8 = $sql_select_working_days->fetchAll();
                        foreach ($row8 as $totalrow) {
                            $totalworkingDays = $totalrow['COUNT(idempattend)'];
                        }
                        $status1 = "present";
                        $sql_total_attend->execute(array($status1,$loginUSERid));
                        $trow1 = $sql_total_attend->fetchAll();
                        foreach ($trow1 as $value) {
                            $total_presentDays = $value['COUNT(idempattend)'];
                        }
                        $status2 ="absent";
                        $sql_total_attend->execute(array($status2,$loginUSERid));
                        $trow2 = $sql_total_attend->fetchAll();
                        foreach ($trow2 as $value) {
                            $total_absentDays = $value['COUNT(idempattend)'];
                        }
                        $status3 = "leave";
                        $sql_total_attend->execute(array($status3,$loginUSERid));
                        $trow3 = $sql_total_attend->fetchAll();
                        foreach ($trow3 as $value) {
                            $total_leaveDays = $value['COUNT(idempattend)'];
                        }
                        $totalattendPercent = ($total_presentDays / $totalworkingDays) * 100;
                echo '<tr>
                     <td colspan="4">
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">সামগ্রিক কর্মজীবন</legend>
                            <table>
                            <tr>
                               <td style="width: 25%; text-align:right">উপস্থিতির হার</td>
                                <td style="width: 25%; text-align:left">: '.english2bangla($totalattendPercent).'</td>
                                <td style="width: 25%; text-align:right">মোট কর্মদিবস</td>
                                <td style="width: 25%; text-align:left">: '.english2bangla($totalworkingDays).'</td>
                            </tr>
                            <tr>
                               <td style="width: 25%; text-align:right">উপস্থিত</td>
                                <td style="width: 25%; text-align:left">: '.english2bangla($total_presentDays).'দিন</td>
                                <td style="width: 25%; text-align:right">অনুপস্থিত</td>
                                <td style="width: 25%; text-align:left">: '.english2bangla($total_absentDays).'দিন</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width: 50%; text-align:right">ছুটি</td>
                                <td colspan="2" style="width: 50%; text-align:left">: '.english2bangla($total_leaveDays).'দিন</td>     
                            </tr>
                            <tr>
                            <td colspan="4"><div align="center"><a onclick="detailsWithPrice()" style="cursor:pointer;color:blue;">উপস্থিতির বিস্তারিত তথ্য</a></div></td>
                            </tr>
                            </table>
                            </filedset></td>
                    </tr>';

                echo '<tr>
                     <td colspan="4">
                     <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">প্রমোশন এন্ড সেলারি আপডেট</legend>
                            <table>
                            <tr>
                                <td style="width: 20%; text-align:right">রানিং গ্রেড</td>
                                <td style="width: 20%; text-align:left">: '.$db_gradename.'<input type="hidden" name="loanAmount" value="'.$db_loannext.'" /></td>
                                <td style="width: 20%; text-align:right">নেক্সট গ্রেড</td>
                                <td style="width: 40%; text-align:left">: <select class="box" name="nextGrade" onchange="showSalaryRange(this.value)">';
                                    getGrade($sql_select_all_grade,$db_usertype);
                                 echo '</select><em2>*</em2></td>
                            </tr>
                            <tr>
                                <td style="text-align:right">রানিং সেলারি</td>
                                <td style="text-align:left">: '.english2bangla($db_salary).' টাকা<input type="hidden" name="repayMonth" value="'.$db_repaymonth.'" /></td>
                                <td style="text-align:right">নেক্সট সেলারি<input type="hidden" name="loanID" value="'.$db_loanID.'" /></td>
                                <td style="text-align:left">: <input type="text" class="box" name="nextSalary" id="nextSalary" style="width:60px;text-align:right;" onkeypress="return checkIt(event)" onkeyup="checkSalaryRange(this.value);" /> টাকা<em2>*</em2>
                                (সেলারি রেঞ্জঃ <span id="SalaryRange" style="color:red;"></span>)
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2></td>
                                <td colspan="2" id="showerror" style="text-align:right;color:red;"></td>
                           </tr>
                             <tr>
                                <td style="text-align:right">রানিং দায়িত্ব / পোস্ট</td>
                                <td style=" text-align:left">:  '.$db_post.'</td>
                                <td style=" text-align:right">নেক্সট পোস্ট</td>
                                <td style="text-align:left">: <select class="box" name="newpostID" style="font-family: SolaimanLipi !important;">';
                                    getPosts($sql_select_post_own_office,$g_officeID);
                                 echo '</select></td>
                            </tr>
                            </table>
                            </filedset></td>
                    </tr>';
                echo "<tr><td colspan='4' style='text-align: center' ><input class='btn' style ='font-size: 12px' type='submit' name='promotion' value='প্রমোশন' /></td></tr>";
                echo "</table>";
                ?>
            </form>
        </div>
    </div>

    <?php
    include 'includes/footer.php';
    ?>