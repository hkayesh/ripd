<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once './includes/selectQueryPDO.php';

$loginUSERname = $_SESSION['acc_holder_name'] ;
 $loginUSERid = $_SESSION['userIDUser'] ;
 
$sql_select_working_days->execute(array($loginUSERid));
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

if(isset($_POST['submit']))
{
    $p_month = $_POST['month'];;
    $p_year = $_POST['year'];
    $monthName = date("F", mktime(0, 0, 0, $p_month, 10));
    
    $select_attendance = mysql_query("SELECT COUNT(idempattend) FROM employee,employee_attendance 
    WHERE   year_no ='$p_year' AND month_no='$p_month' AND  cfs_user_idUser = $loginUSERid AND idEmployee = emp_user_id ");
    $row = mysql_fetch_assoc($select_attendance);
    $workingDays = $row['COUNT(idempattend)'];

    $sql_attend =$conn->prepare("SELECT COUNT(idempattend) FROM employee,employee_attendance WHERE emp_atnd_type=? AND  year_no =? AND month_no=? AND  cfs_user_idUser = ? AND idEmployee = emp_user_id ");
    $status1 = "present";
    $sql_attend->execute(array($status1,$p_year,$p_month,$loginUSERid));
    $row1 = $sql_attend->fetchAll();
    foreach ($row1 as $value) {
        $presentDays = $value['COUNT(idempattend)'];
    }
    $status2 ="absent";
    $sql_attend->execute(array($status2,$p_year,$p_month,$loginUSERid));
    $row2 = $sql_attend->fetchAll();
    foreach ($row2 as $value) {
        $absentDays = $value['COUNT(idempattend)'];
    }
    $status3 = "leave";
    $sql_attend->execute(array($status3,$p_year,$p_month,$loginUSERid));
    $row3 = $sql_attend->fetchAll();
    foreach ($row3 as $value) {
        $leaveDays = $value['COUNT(idempattend)'];
    }
    $attendPercent = ($presentDays / $workingDays) * 100;
}
?>
<title>নিয়মিত কর্মচারী হাজিরা</title>
<style type="text/css"> @import "css/bush.css";</style>
<style type="text/css">
    #search {
        width: 50px;background-color: #009933;border: 2px solid #0077D5;cursor: pointer; color: wheat;
    }
    #search:hover {
        background-color: #0077D5;border: 2px inset #009933;color: wheat;
    }
</style>

    <div class="main_text_box" style="width: 100% !important;">
        <div style="padding-left: 50px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
          <div>
               <table  class="formstyle" style="width: 90% !important; font-family: SolaimanLipi !important;margin:0 auto !important;">          
                    <tr><th colspan="2" style="text-align: center;">কর্মচারীর বাক্তিগত হাজিরা বিবরণ</th></tr>
                    <tr><td colspan="2" style="color: sienna; text-align: center; font-size: 20px;"><b><?php echo $loginUSERname;?></b></td></tr>
                    <tr><td colspan="2" style="color: sienna; text-align: center; font-size: 16px;"> পূর্বের হাজিরা বিবরণ</td></tr>
                    <tr>
                        <td>
                            <fieldset style="border: #686c70 solid 3px;width: 90%;margin-left:5%;">
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
                        <td>
                            <fieldset style="border: #686c70 solid 3px;width: 90%;margin-left:5%;">
                                <legend style="color: brown">মোট সারসংক্ষেপ</legend>
                                <table>
                                    <tr>
                                            <td > হাজিরার হার :</td>
                                            <td ><?php echo english2bangla(round($totalattendPercent, 2));?> %</td>
                                        </tr>
                                        <tr>
                                            <td >মোট কার্যদিবস :</td>
                                            <td ><?php echo english2bangla($totalworkingDays);?> দিন</td>
                                        </tr>
                                        <tr>
                                            <td>উপস্থিতি :</td>
                                            <td><?php echo english2bangla($total_presentDays);?> দিন</td>
                                            <td>অনুপস্থিতি :</td>
                                            <td><?php echo english2bangla($total_absentDays);?> দিন</td>
                                            <td>ছুটি :</td>
                                            <td><?php echo english2bangla($total_leaveDays);?> দিন</td>
                                        </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                    <td colspan="2">
                        <table cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="5" style="text-align: center;color: sienna; text-align: center; font-size: 20px;"></br> <?php echo $monthName.", ".$p_year;?> -এর হাজিরা বিবরণ </td>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align: center;">
                                    <fieldset style="border: #686c70 solid 3px;width: 60%;margin-left: 20%;">
                                        <legend style="color: brown">মাসিক সারসংক্ষেপ</legend>
                                        <table>
                                            <tr>
                                            <td > হাজিরার হার :</td>
                                            <td ><?php echo english2bangla($attendPercent);?> %</td>
                                        </tr>
                                        <tr>
                                            <td >মোট কার্যদিবস :</td>
                                            <td ><?php echo english2bangla($workingDays);?> দিন</td>
                                        </tr>
                                        <tr>
                                            <td>উপস্থিতি :</td>
                                            <td><?php echo english2bangla($presentDays);?> দিন</td>
                                            <td>অনুপস্থিতি :</td>
                                            <td><?php echo english2bangla($absentDays);?> দিন</td>
                                            <td>ছুটি :</td>
                                            <td><?php echo english2bangla($leaveDays);?> দিন</td>
                                        </tr>
                                        </table>
                                    </fieldset></br>
                                </td>
                            </tr>
                            <tr id="table_row_odd">
                                        <td style='border: 1px solid #000099; text-align: center' >তারিখ</td>
                                        <td style='border: 1px solid #000099;text-align: center' >স্ট্যাটাস</td>
                                        <td style='border: 1px solid #000099;text-align: center'>ইন টাইম</td>
                                        <td style='border: 1px solid #000099;text-align: center'>আউট টাইম</td>
                                        <td style='border: 1px solid #000099;text-align: center'>ওভারটাইম (ঘণ্টা)</td>
                            </tr>
                                <tbody style="font-size: 12px !important">
                                 <?php
                                 if(isset($_POST['submit']))
                                 {
                                    $sel_attendace = mysql_query("SELECT * FROM employee,employee_attendance 
                                    WHERE   year_no ='$p_year' AND month_no='$p_month' AND  cfs_user_idUser = $loginUSERid AND idEmployee = emp_user_id
                                      ORDER BY date_of_atnd ");
                                    while($attendRow = mysql_fetch_assoc($sel_attendace))
                                    {
                                        $db_date = $attendRow['date_of_atnd'];
                                        $date = date("d-m-Y",  strtotime($db_date));
                                        $db_status = $attendRow['emp_atnd_type'];
                                        $db_inTime = $attendRow['emp_intime'];
                                        $db_OutTime = $attendRow['emp_outtime'];
                                        $db_overTime = $attendRow['emp_extratime'];
                                        echo "<tr><td style='border: 1px solid black; text-align: center'>$date</td>
                                            <td style='border: 1px solid black; text-align: center'>$db_status</td>
                                            <td style='border: 1px solid black; text-align: center'>$db_inTime</td>
                                            <td style='border: 1px solid black; text-align: center'>$db_OutTime</td>
                                            <td style='border: 1px solid black; text-align: center'>$db_overTime</td></tr>";
                                    }
                                 }
                                ?>
                                </tbody>
                            </table>
                           </td>
                    </tr>
                </table>
        </div>                 
    </div>
    <?php include_once 'includes/footer.php';?>
