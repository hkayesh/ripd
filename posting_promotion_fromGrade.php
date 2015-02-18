<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include_once 'includes/header.php';
include_once './includes/selectQueryPDO.php';

?>
<style type="text/css">@import "css/bush.css";</style>
<?php
    function showGrades($gradeName)
            {
            $showGradeName = array('employee' => 'কর্মচারীর', 'presenter' => 'প্রেজেন্টারের', 'programmer' => 'প্রোগ্রামারের', 'trainer' => 'ট্রেইনারের');
            $printGradeName = $showGradeName[$gradeName];
            echo "<table  class='formstyle' style='margin:20px;width:95%;'>";          
                echo "<tr><th colspan='7' style='text-align: center;'>গ্রেড ভিত্তিক $printGradeName সংখ্যা</th></tr>";
                echo "<tr align='left' id='table_row_odd'>
                    <td>গ্রেডের নাম</td>
                    <td colspan='2'>$printGradeName সংখ্যা</td>
                </tr>";
                 $query_grade = mysql_query("SELECT idpaygrade, grade_name, COUNT(*) as num
                                                    FROM pay_grade, employee as emp
                                                    WHERE emp.employee_type='$gradeName' AND pay_grade_id = idpaygrade
                                                    GROUP BY grade_name");
                //$query_grade = mysql_query("SELECT idEmployee_grade, grade_name, COUNT(*) FROM employee, employee_grade WHERE Employee_grade_idEmployee_grade=idEmployee_grade AND employee_type='$gradeName' GROUP BY grade_name");
                $total_employee = 0;
                
                while($rows_grade = mysql_fetch_array($query_grade))
                        {                    
                        $grade_id = $rows_grade['idpaygrade'];
                        $grade_name = $rows_grade['grade_name'];
                        $employee_number = $rows_grade['num'];
                        $numShow = english2bangla($employee_number);
                        $total_employee = $total_employee + $employee_number;
                        echo "<tr>
                            <td>$grade_name</td>
                            <td>$numShow জন</td>
                            <td><a href='posting_promotion_fromGrade.php?iffimore=00d110t01l11s01&sh110ow1=$gradeName&gi010d10=$grade_id'>$printGradeName তালিকা দেখুন</a></td>
                        </tr>";
                        }
                        $totalNumShow = english2bangla($total_employee);
                echo "<tr align='left' id='table_row_odd'>                                                 
                    <td style='text-align: right;'>সর্বমোট $printGradeName সংখ্যাঃ</td>
                    <td colspan='2' style='text-align: left;'>$totalNumShow জন</td>
                </tr>";
            echo "</table>";
            }
?>
    <?php
    if($_GET['iffimore'] == '00d110t01l11s01') {
    ?>
    <div class="main_text_box">
        <div style="padding-left: 20px;"><a href="posting_promotion_fromGrade.php?iffimore=1m10a01i11n"><b>ফিরে যান</b></a></div>
        <div>
            <?php
            $dtls_gradeName = $_GET['sh110ow1'];
            $showGradeName = array('employee' => 'কর্মচারীর', 'presenter' => 'প্রেজেন্টারের', 'programmer' => 'প্রোগ্রামারের', 'trainer' => 'ট্রেইনারের');
            $printGradeName = $showGradeName[$dtls_gradeName];
            $dtls_grade_id = $_GET['gi010d10'];
            echo "<table  class='formstyle' style='margin:20px;width:95%;'>";          
                echo "<tr><th colspan='11' style='text-align: center;'>গ্রেড ভিত্তিক $printGradeName তালিকা</th></tr>";
                echo "<tr align='left' id='table_row_odd'>
                    <td><b>ক্রম</b></td>
                    <td><b>$printGradeName নাম</b></td>
                    <td><b>একাউন্ট নাম্বার</b></td>
                    <td><b>গ্রেড</b></td>
                    <td><b>গ্রেডের স্থায়িত্বকাল</b></td>
                    <td><b>দায়িত্ব</b></td>
                    <td><b>অফিসে সময়কাল</b></td>
                    <td><b>অফিসের নাম</b></td>
                    <td colspan='3'></td>
                </tr>";
                $row_count = 1;
                $query_employee = mysql_query("SELECT account_name, account_number, grade_name,idEmployee,emp_ons_id,idUser
                                                                        FROM pay_grade, cfs_user, employee,ons_relation
                                                                        WHERE cfs_user_idUser = idUser
                                                                        AND idpaygrade = pay_grade_id
                                                                        AND idpaygrade ='$dtls_grade_id'
                                                                        AND emp_ons_id = idons_relation AND catagory='office' ");
                while($rows_employee = mysql_fetch_array($query_employee))
                        {
                            $employee_name = $rows_employee['account_name'];
                            $account_number = $rows_employee['account_number'];
                            $empID = $rows_employee['idEmployee'];
                            $db_onsid = $rows_employee['emp_ons_id'];
                            $db_cfsuserid = $rows_employee['idUser'];
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
                                     $get_office_id = $value['idOffice'];
                                 }
                             }
                             else {
                                 $sql_select_sales_store->execute(array($db_offid));
                                 $row2 = $sql_select_sales_store->fetchAll();
                                 foreach ($row2 as $value) {
                                     $db_offname = $value['salesStore_name'];
                                 }
                             }
                            $rowShow = english2bangla($row_count);
                            $timestamp=time(); //current timestamp
                            $sql_select_employee_grade->execute(array($empID));
                            $graderow = $sql_select_employee_grade->fetchAll();
                            foreach ($graderow as $arr_grade) {
                                $db_gradeInsertDate = $arr_grade['insert_date'];
                                $grade_name = $arr_grade['grade_name'];
                            }
                            $start = date_create($db_gradeInsertDate);
                            $interval1 = date_diff(date_create(), $start);
                            $grdyears = english2bangla($interval1->format('%Y'));
                            $grdmonths2 = english2bangla($interval1->format('%M'));
                            $grddays = english2bangla($interval1->format('%d'));

                            $sql_select_emp_post->execute(array($db_cfsuserid));
                            $row4 = $sql_select_emp_post->fetchAll();
                            foreach ($row4 as $arr_row) {
                                $db_post = $arr_row['post_name'];
                                $db_idposting = $arr_row['idpostinons'];
                                $db_postingDate = $arr_row['posting_date'];
                            }         
                            $datetime1 = date_create($db_postingDate);
                            $interval = date_diff(date_create(), $datetime1);
                            $years = english2bangla($interval->format('%Y'));
                            $months2 = english2bangla($interval->format('%M'));
                            $days = english2bangla($interval->format('%d'));
                        
                                $go2parent = "posting_promotion_fromGrade.php?iffimore=00d110t01l11s01%%sh110ow1=".$dtls_gradeName."%%gi010d10=".$dtls_grade_id."%%i010d10=".$get_office_id;
                                echo "<tr>
                                <td style='padding-left:4px;'>$rowShow</td>
                                <td style='padding-left:4px;'>$employee_name</td>
                                <td style='padding-left:4px;'>$account_number</td>
                                <td style='padding-left:4px;'>$grade_name</td>
                                <td style='padding-left:4px;'>$grdyears বছর, $grdmonths2 মাস, $grddays দিন</td>
                                <td style='padding-left:4px;'>$db_post</td>
                                <td style='padding-left:4px;'>$years বছর, $months2 মাস, $days দিন</td>
                                <td style='padding-left:4px;'>$db_offname</td>
                                <td style='padding-left:4px;'><a href='posting_to.php?0to1o1ff01i0c1e0=$empID&bkprnt=$go2parent'>পোস্টিং</a></td>
                                <td style='padding-left:4px;'><a href='promotion_to.php?0to1o1ff01i0c1e0=$empID&bkprnt=$go2parent'>প্রোমশন</a></td>
                                <td style='padding-left:4px;'><a href='postingNpromotion.php?0to1o1ff01i0c1e0=$empID&bkprnt=$go2parent'>পোস্টিং এন্ড প্রোমশন</a></td>
                            </tr>";
                            $row_count = $row_count + 1;
                        }
            echo "</table>";
            ?>
        </div>
    </div>
    <?php 
        }
        else {
    ?>
    <div class="main_text_box">
        <div style="padding-left: 10px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
        <div class="domtab">
            <ul class="domtabs">
                <li class="current"><a href="#01">কর্মচারী</a></li>
                <li class="current"><a href="#02">প্রেজেন্টার</a></li>
                <li class="current"><a href="#03">প্রোগ্রামার</a></li>
                <li class="current"><a href="#04">ট্রেইনার</a></li>
            </ul>
        </div>
        <div>
            <h2><a name="01" id="01"></a></h2><br/>
            <?php showGrades("employee");?>
        </div>
        <div>
            <h2><a name="02" id="02"></a></h2><br/>
            <?php showGrades("presenter");?>
        </div>
        <div>
            <h2><a name="03" id="03"></a></h2><br/>
            <?php showGrades("programmer");?>
        </div>
        <div>
            <h2><a name="04" id="04"></a></h2><br/>
            <?php showGrades("trainer");?>
        </div>
    </div>    
<?php
        }
include 'includes/footer.php';
?>