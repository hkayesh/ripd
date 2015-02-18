<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$session_user_id = $_SESSION['userIDUser'];
$sel_emp = $conn->prepare("SELECT idEmployee,emp_ons_id FROM employee WHERE cfs_user_idUser=? ");
$sel_emp->execute(array($session_user_id));
$arr_cfs = $sel_emp->fetchAll();
foreach ($arr_cfs as $value) {
    $empID = $value['idEmployee'];
}
$sel_emp_grade = $conn->prepare("SELECT * FROM employee_salary, pay_grade WHERE pay_grade_idpaygrade= idpaygrade
                                                    AND user_id= ? ORDER BY employee_salary.insert_date DESC");
?>
<title>প্রমোশন ডেসক্রিপশন</title>
<style type="text/css"> @import "css/bush.css";</style>
<div class="main_text_box">
    <div style="padding-left: 110px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
    <div>
        <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
            <tr><th colspan="2" style="text-align: center;font-size: 20px;">প্রমোশন ডেসক্রিপশন</th></tr>
            <?php
                $sel_emp_grade->execute(array($empID));
                $arr_grade = $sel_emp_grade->fetchAll();
                foreach ($arr_grade as $key=> $value) 
                { $sl = 1;
                    if($key == 0)
                    {
                        $db_current_grade = $value['grade_name'];
                        $db_current_grading_date = $value['insert_date']; 
                ?>
            <tr>
                <td style="text-align: right; width: 50%"><b>বর্তমান গ্রেডঃ</b></td>
                <td><?php echo $db_current_grade;?></td>
            </tr>
            <tr >
                <td style="text-align: right; width: 50%"><b>বর্তমান গ্রেড শুরুর তারিখঃ</b></td>
                <td><?php echo english2bangla(date("d/m/Y",  strtotime($db_current_grading_date)));?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <fieldset style="border: #686c70 solid 3px;width: 80%;margin-left: 10%;">
                            <legend style="color: brown;">পূর্ববর্তী গ্রেড</legend>
                            <table style="width: 95%; margin: 0 auto" border="1" cellpadding="5px" cellspacing="0px">    
                            <tr  id="table_row_odd">
                                <td style="border: black 1px solid; text-align: center;font-weight: bold;">ক্রম</td>
                                <td style="border: black 1px solid; text-align: center;font-weight: bold;">গ্রেড</td>
                                <td style="border: black 1px solid; text-align: center;font-weight: bold;" >যোগদানের তারিখ</td>
                                <td style="border: black 1px solid; text-align: center;font-weight: bold;">গ্রেডে অবস্থানকাল</td>
                            </tr>
                            <?php
                                }
                                else
                                {
                                    $db_grade = $value['grade_name'];
                                    $db_grading_date = $value['insert_date'];
                                    $db_previous_key = $key -1;
                                    $datetime1 = date_create($arr_grade[$key]['insert_date']);
                                    $datetime2 = date_create($arr_grade[$db_previous_key]['insert_date']);
                                    $interval = date_diff($datetime1, $datetime2);
                                    $postyears = english2bangla($interval->format('%Y'));
                                    $postmonths2 = english2bangla($interval->format('%M'));
                                    $postdays = english2bangla($interval->format('%d'));
                              ?>
                           <tr>
                                <td style="border: black 1px solid; text-align: center"><?php echo english2bangla($sl);?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo $db_grade;?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo english2bangla(date("d/m/Y",  strtotime($db_grading_date)));?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo $postyears ."বছর,". $postmonths2. "মাস,". $postdays ."দিন";?></td>
                            </tr>
                            <?php
                            $sl++;
                                     }
                                 }
                             ?>
                        </table>
                    </fieldset>
                </td>
            </tr>
        </table>
    </div>           
</div>
<?php
include_once 'includes/footer.php';
?>
