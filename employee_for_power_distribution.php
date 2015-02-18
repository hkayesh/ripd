<?php
include_once 'includes/MiscFunctions.php';
include 'includes/header.php';
include_once './includes/selectQueryPDO.php';

?>
<style type="text/css">@import "css/bush.css";</style>
 <div class="main_text_box">
    <div style="padding-left: 110px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
        <div>
            <?php
           $get_office_id = $_SESSION['loggedInOfficeID'];
           $sql_select_office->execute(array($get_office_id));
           $arr_off = $sql_select_office->fetchAll();
           foreach ($arr_off as $row) {
               $office_name = $row['office_name'];
           }
            echo "<table  class='formstyle' style='width: 80%;'>";          
                echo "<tr><th colspan='10' style='text-align: center;font-size:18px;'>$office_name - এ কর্মচারীদের তালিকা</th></tr>";
                echo "<tr align='left' id='table_row_odd'>
                    <td><b>ক্রম</b></td>
                    <td><b>কর্মচারীদের নাম</b></td>
                    <td><b>একাউন্ট নাম্বার</b></td>
                    <td><b>গ্রেড</b></td>
                    
                    <td><b>দায়িত্ব</b></td>
                    
                    <td colspan='2'></td>
                </tr>";
                $sel_office_employee->execute(array($get_office_id));
                $row1 = $sel_office_employee->fetchAll();
                $sl = 1;
                foreach ($row1 as $emprow)
                {
                    $empID = $emprow['idEmployee'];
                    $cfs_id = $emprow['cfs_user_idUser'];
                    $timestamp=time(); //current timestamp
                    $sql_select_employee_grade->execute(array($empID));
                    $graderow = $sql_select_employee_grade->fetchAll();
                    foreach ($graderow as $arr_grade) {
                        $db_gradeInsertDate = $arr_grade['insert_date'];
                        $db_gradename = $arr_grade['grade_name'];      
                    }

//                    $start = date_create($db_gradeInsertDate);
//                    $interval1 = date_diff(date_create(), $start);
//                    $grdyears = english2bangla($interval1->format('%Y'));
//                    $grdmonths2 = english2bangla($interval1->format('%M'));
//                    $grddays = english2bangla($interval1->format('%d'));

                    $sql_select_view_emp_post->execute(array($empID,$get_office_id));
                    $result = $sql_select_view_emp_post->fetchAll();
                    foreach ($result as $arr_row) {
                        $db_post = $arr_row['post_name'];
                        $db_postingDate = $arr_row['posting_date'];
                    }                                         
//                        $datetime1 = date_create($db_postingDate);
//                        $interval = date_diff(date_create(), $datetime1);
//                        $years = english2bangla($interval->format('%Y'));
//                        $months2 = english2bangla($interval->format('%M'));
//                        $days = english2bangla($interval->format('%d'));
                    echo "<tr>
                        <td>".english2bangla($sl)."</td>
                        <td>".$emprow['account_name']."</td>
                        <td>".$emprow['account_number']."</td>
                        <td>".$db_gradename."</td>
                        
                        <td>$db_post</td>
                    
                        <td><a href='personal_power_distribution.php?id=$cfs_id'>ক্ষমতা বিকেন্দ্রীকরণ</a></td>
                        <td><a href='personal_power_off.php?id=$cfs_id'>ক্ষমতা স্থগিতকরন</a></td>
                    </tr>"; 
                    $sl++;
                }
            echo "</table>";
            ?>
        </div>
    </div>
    <?php include 'includes/footer.php';?>