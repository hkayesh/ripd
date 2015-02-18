<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$loginUSERname = $_SESSION['acc_holder_name'] ;
$logedInUser = $_SESSION['userIDUser'];
$logedInUserType = $_SESSION['userType'];
$type = getTypeFromWho($logedInUserType);
$typeinbangla= getProgramType($type);
$whoinbangla = getProgramer2($logedInUserType);
// ************************ select query **************************************************
$select_previous_program = $conn->prepare("SELECT * FROM program,office WHERE program_type = ?
                                                                            AND Office_idOffice = idOffice
                                                                            AND program_date <= CURDATE() AND attendance_status='given'
                                                                            AND idprogram= ANY(SELECT fk_idprogram FROM presenter_list, employee
                                                                                                         WHERE fk_Employee_idEmployee = idEmployee AND cfs_user_idUser =? ) 
                                                                            ORDER BY program_date ASC");
$select_done_program = $conn->prepare("SELECT COUNT(idprogram) FROM program,office WHERE program_type = ?
                                                                            AND Office_idOffice = idOffice
                                                                            AND program_date <= CURDATE() AND attendance_status='given'
                                                                            AND idprogram= ANY(SELECT fk_idprogram FROM presenter_list, employee
                                                                                                         WHERE fk_Employee_idEmployee = idEmployee AND cfs_user_idUser =? ) 
                                                                            ORDER BY program_date ASC");
$select_presenters_attendance = $conn->prepare("SELECT COUNT(idprogram) FROM program,office WHERE program_type = ?
                                                                            AND Office_idOffice = idOffice
                                                                            AND program_date <= CURDATE() AND attendance_status='given'
                                                                            AND idprogram= ANY(SELECT fk_idprogram FROM presenter_list, employee
                                                                                                         WHERE fk_Employee_idEmployee = idEmployee AND cfs_user_idUser =? AND prog_attendance=? ) 
                                                                            ORDER BY program_date ASC");
$select_done_program->execute(array($type,$logedInUser));
$row8 = $select_done_program->fetchAll();
foreach ($row8 as $totalrow) {
    $totalDonePrograms = $totalrow['COUNT(idprogram)'];
}
$status1 = "present";
    $select_presenters_attendance->execute(array($type,$logedInUser,$status1));
    $trow1 = $select_presenters_attendance->fetchAll();
    foreach ($trow1 as $value) {
        $total_presentDays = $value['COUNT(idprogram)'];
    }
$status2 ="absent";
    $select_presenters_attendance->execute(array($type,$logedInUser,$status2));
    $trow2 = $select_presenters_attendance->fetchAll();
    foreach ($trow2 as $value) {
        $total_absentDays = $value['COUNT(idprogram)'];
    }
     $totalattendPercent = ($total_presentDays / $totalDonePrograms) * 100;

?>
<style type="text/css"> @import "css/bush.css";</style>

    <div class="main_text_box" style="width: 100% !important;">
        <div style="padding-left: 50px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
          <div>
           <form method="POST"  name="frm" action="">	
               <table  class="formstyle" style="width: 90% !important; font-family: SolaimanLipi !important;margin:0 auto !important;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 20px;">পূর্ববর্তি <?php echo $typeinbangla;?>-এর তালিকা</th></tr>
                    <tr><td colspan="2" style="color: sienna; text-align: center; font-size: 20px;"><b><?php echo $loginUSERname;?></b></td></tr>
                    <tr>               
                        <td>
                            <fieldset style="border: #686c70 solid 3px;width: 50%;margin-left:25%;">
                                <legend style="color: brown">মোট সারসংক্ষেপ</legend>
                                <table>
                                    <tr>
                                        <td ><b>হাজিরার হার :</b></td>
                                        <td ><?php echo english2bangla(round($totalattendPercent, 2));?> %</td>
                                    </tr>
                                    <tr>
                                        <td ><b>মোট <?php echo $typeinbangla;?> :</b></td>
                                        <td ><?php echo english2bangla($totalDonePrograms);?> দিন</td>
                                    </tr>
                                    <tr>
                                        <td><b>উপস্থিত :</b></td>
                                        <td><?php echo english2bangla($total_presentDays);?> দিন</td>
                                        <td><b>অনুপস্থিত :</b></td>
                                        <td><?php echo english2bangla($total_absentDays);?> দিন</td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                    <td>
                        <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">সার্চ</legend>
                            <form method="POST" action="">	
                            <table>
                                <tr>
                                    <td style="padding-left: 0px; text-align: left;" >শুরুর তারিখঃ</td>
                                    <td style="text-align: left"><input class="box" type="date" name="startDate" /></td>	 
                                    <td style="padding-left: 0px; text-align: left;"  >শেষের তারিখঃ</td>
                                    <td style=" text-align: left"><input class="box" type="date" name="lastDate" /></td>
                                    <td style="padding-left: 50px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সার্চ" /></td>
                                </tr>
                            </table>
                           </form>
                        </fieldset>
                    </td> 
                </tr>
                    <tr>
                    <td colspan="2"></br>
                        <table cellspacing="0" cellpadding="0">
                            <tr id="table_row_odd">
                                        <td style='border: 1px solid #000099; text-align: center;font-weight: bold;' >তারিখ</td>
                                        <td style='border: 1px solid #000099;text-align: center;font-weight: bold;' ><?php echo $typeinbangla;?>-এর নাম</td>
                                        <td style='border: 1px solid #000099;text-align: center;font-weight: bold;'>অফিস</td>
                                        <td style='border: 1px solid #000099;text-align: center;font-weight: bold;'>ভেন্যু</td>
                                        <td style='border: 1px solid #000099;text-align: center;font-weight: bold;'>সময়</td>
                                        <td style='border: 1px solid #000099;text-align: center;font-weight: bold;'><?php echo $whoinbangla;?>-এর লিস্ট</td
                            </tr>
                                <tbody style="font-size: 12px !important">
                                    <?php
                                     if(isset($_POST['submit']))
                                        {
                                            $p_startdate = $_POST['startDate'];
                                            $p_lastDate = $_POST['lastDate'];
                                           $select_previous_program = $conn->prepare("SELECT * FROM program,office WHERE program_type = ?
                                                                            AND Office_idOffice = idOffice
                                                                            AND program_date BETWEEN ? AND ? AND attendance_status='given'
                                                                            AND idprogram= ANY(SELECT fk_idprogram FROM presenter_list, employee
                                                                                                         WHERE fk_Employee_idEmployee = idEmployee AND cfs_user_idUser =? ) 
                                                                            ORDER BY program_date ASC");
                                           $select_previous_program->execute(array($type,$p_startdate,$p_lastDate,$logedInUser));
                                            $arr_program = $select_previous_program->fetchAll();
                                            foreach ($arr_program as $row) {
                                            $db_programId = $row['idprogram'];
                                                $db_programName = $row['program_name'];
                                                $db_programLocation = $row['program_location'];
                                                $db_programDate = $row['program_date'];
                                                $db_programTime = $row['program_time'];           
                                                $db_programSubject = $row['subject'];
                                                $db_office_name = $row['office_name'];
                                                $db_office_address = $row['office_details_address'];
                                                $demonastrators = '';
                                                $sql_demonastrators_name = "SELECT * FROM presenter_list, employee, cfs_user WHERE fk_idprogram = '$db_programId' 
                                                                                                  AND fk_Employee_idEmployee = idEmployee AND cfs_user_idUser = idUser";
                                                $row_demonastrators_name = mysql_query($sql_demonastrators_name);
                                                while ($row_names = mysql_fetch_array($row_demonastrators_name)){
                                                    $db_demons_name = $row_names['account_name'];
                                                    $demonastrators = $db_demons_name.", ".$demonastrators;
                                                }
                                                echo "<tr>";
                                                echo "<td style='border:1px solid black;'>".english2bangla(date("d/m/Y",  strtotime($db_programDate)))."</td>";
                                                echo "<td style='border:1px solid black;'>$db_programName</td>";
                                                echo "<td style='border:1px solid black;'>$db_office_name</td>";
                                                echo "<td style='border:1px solid black;'>$db_programLocation</td>";                                             
                                                echo "<td style='border:1px solid black;'>".english2bangla(date('g:i a' , strtotime($db_programTime)))."</td>";
                                                echo "<td style='border:1px solid black;'>$demonastrators</td>";
                                                echo "</tr>";
                                            }
                                        }
                                        else
                                        {
                                        $select_previous_program->execute(array($type,$logedInUser));
                                        $arr_program = $select_previous_program->fetchAll();
                                        foreach ($arr_program as $row) {
                                            $db_programId = $row['idprogram'];
                                                $db_programName = $row['program_name'];
                                                $db_programLocation = $row['program_location'];
                                                $db_programDate = $row['program_date'];
                                                $db_programTime = $row['program_time'];           
                                                $db_programSubject = $row['subject'];
                                                $db_office_name = $row['office_name'];
                                                $db_office_address = $row['office_details_address'];
                                                $demonastrators = '';
                                                $sql_demonastrators_name = "SELECT * FROM presenter_list, employee, cfs_user WHERE fk_idprogram = '$db_programId' 
                                                                                                  AND fk_Employee_idEmployee = idEmployee AND cfs_user_idUser = idUser";
                                                $row_demonastrators_name = mysql_query($sql_demonastrators_name);
                                                while ($row_names = mysql_fetch_array($row_demonastrators_name)){
                                                    $db_demons_name = $row_names['account_name'];
                                                    $demonastrators = $db_demons_name.", ".$demonastrators;
                                                }
                                                echo "<tr>";
                                                echo "<td style='border:1px solid black;'>".english2bangla(date("d/m/Y",  strtotime($db_programDate)))."</td>";
                                                echo "<td style='border:1px solid black;'>$db_programName</td>";
                                                echo "<td style='border:1px solid black;'>$db_office_name</td>";
                                                echo "<td style='border:1px solid black;'>$db_programLocation</td>";                                             
                                                echo "<td style='border:1px solid black;'>".english2bangla(date('g:i a' , strtotime($db_programTime)))."</td>";
                                                echo "<td style='border:1px solid black;'>$demonastrators</td>";
                                                echo "</tr>";
                                            }
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