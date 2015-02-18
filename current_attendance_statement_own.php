<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$loginUSERname = $_SESSION['acc_holder_name'] ;
$loginUSERid = $_SESSION['userIDUser'] ;
$currentMonth = date('n');
$currentYear = date('Y');
$select_attendance = mysql_query("SELECT COUNT(idempattend) FROM employee,employee_attendance 
    WHERE   year_no ='$currentYear' AND month_no='$currentMonth' AND  cfs_user_idUser = $loginUSERid AND idEmployee = emp_user_id ");
$row = mysql_fetch_assoc($select_attendance);
$workingDays = $row['COUNT(idempattend)'];

$sql_attend =$conn->prepare("SELECT COUNT(idempattend) FROM employee,employee_attendance WHERE emp_atnd_type=? AND  year_no =? AND month_no=? AND  cfs_user_idUser = ? AND idEmployee = emp_user_id ");
$status1 = "present";
$sql_attend->execute(array($status1,$currentYear,$currentMonth,$loginUSERid));
$row1 = $sql_attend->fetchAll();
foreach ($row1 as $value) {
    $presentDays = $value['COUNT(idempattend)'];
}
$status2 ="absent";
$sql_attend->execute(array($status2,$currentYear,$currentMonth,$loginUSERid));
$row2 = $sql_attend->fetchAll();
foreach ($row2 as $value) {
    $absentDays = $value['COUNT(idempattend)'];
}
$status3 = "leave";
$sql_attend->execute(array($status3,$currentYear,$currentMonth,$loginUSERid));
$row3 = $sql_attend->fetchAll();
foreach ($row3 as $value) {
    $leaveDays = $value['COUNT(idempattend)'];
}
$attendPercent = ($presentDays / $workingDays) * 100;

?>
<style type="text/css"> @import "css/bush.css";</style>

    <div class="main_text_box" style="width: 100% !important;">
        <div style="padding-left: 50px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
          <div>
           <form method="POST"  name="frm" action="">	
               <table  class="formstyle" style="width: 90% !important; font-family: SolaimanLipi !important;margin:0 auto !important;">          
                    <tr><th colspan="2" style="text-align: center;">কর্মচারীর ব্যক্তিগত হাজিরা বিবরণ</th></tr>
                    <tr><td colspan="13" style="color: sienna; text-align: center; font-size: 20px;"><b><?php echo $loginUSERname;?></b></td></tr>
                    <tr><td colspan="13" style="color: sienna; text-align: center; font-size: 16px;"> চলতি মাস (<?php echo date('F');?>)-এর হাজিরা বিবরণ</td></tr>
                    <tr>
                        <td>
                            <fieldset style="border: #686c70 solid 3px;width: 60%;margin-left:20%;">
                                <legend style="color: brown">সারসংক্ষেপ</legend>
                                <table>
                                    <tr>
                                        <td >চলতি মাসের হাজিরার হার :</td>
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
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                    <td colspan="2">
                        <table align="center" style="border: black solid 1px !important; border-collapse: collapse;">
                                    <thead>                                     
                                        <tr id="table_row_odd">
                                        <td style='border: 1px solid #000099; text-align: center' >তারিখ</td>
                                        <td style='border: 1px solid #000099;text-align: center' >স্ট্যাটাস</td>
                                        <td style='border: 1px solid #000099;text-align: center'>ইন টাইম</td>
                                        <td style='border: 1px solid #000099;text-align: center'>আউট টাইম</td>
                                        <td style='border: 1px solid #000099;text-align: center'>ওভারটাইম (ঘণ্টা)</td>
                                        </tr>
                                </thead>
                                <tbody style="font-size: 12px !important">
                                <?php
                                    $sel_attendace = mysql_query("SELECT * FROM employee,employee_attendance 
                                    WHERE   year_no ='$currentYear' AND month_no='$currentMonth' AND  cfs_user_idUser = $loginUSERid AND idEmployee = emp_user_id
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
                                ?>
                                </tbody>
                            </table>
                           </td>
                    </tr>
                </table>
            </form>
        </div>                 
    </div>
    <?php include_once 'includes/footer.php';?>
