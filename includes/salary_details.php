<?php
error_reporting(0);
//include 'includes/session.inc';
include_once './connectionPDO.php';
include_once 'selectQueryPDO.php';
include_once 'MiscFunctions.php';
echo $g_onsID = $_GET['onsID'];
$g_month = $_GET['month'];
$g_year = $_GET['year'];
$monthName = date("F", mktime(0, 0, 0, $g_month, 10));
$arr_who = array('presenter'=>'প্রেজেন্টার','programmer'=>'প্রোগ্রামার','trainer'=>'ট্রেইনার','employee'=>'কর্মচারী');

$sql_select_ons_relation->execute(array($g_onsID));
$row = $sql_select_ons_relation->fetchAll();
foreach ($row as $value) {
    $db_id = $value['add_ons_id'];
    $db_catagory = $value['catagory'];
     if( $db_catagory == 'office')
        {
            $sql_select_office->execute(array($db_id));
            $arr_office = $sql_select_office->fetchAll();
            foreach ($arr_office as $offrow) {
                $db_offname = $offrow['office_name'];
            }
        }
        else
        {
            $sql_select_sales_store->execute(array($db_id));
            $arr_office = $sql_select_sales_store->fetchAll();
            foreach ($arr_office as $offrow) {
                $db_offname = $offrow['salesStore_name'];
            }
        }
}
$total_employee = 0;
$sel_total_employee = $conn->prepare("SELECT COUNT(idEmployee) , employee.employee_type, pay_grade_id, SUM(total_given_amount), grade_name
                                                                FROM salary_approval, salary_chart, employee, pay_grade
                                                                WHERE salapp_onsid =? AND salary_approval.month_no =?                                                             
                                                                AND salary_approval.year_no =? AND salappid = fk_sal_aprv_salappid
                                                                AND user_id = cfs_user_idUser AND pay_grade_id = idpaygrade
                                                                GROUP BY employee.employee_type, pay_grade_id");
$sel_total_employee->execute(array($g_onsID,$g_month,$g_year));
$row1 = $sel_total_employee->fetchAll();
foreach ($row1 as $row_emp_sal) {
    $total_employee+= $row_emp_sal['COUNT(idEmployee)'];
}
?>
<style type="text/css">@import "css/bush.css";</style> 

<div class="main_text_box">
        <div>           
            <form method="POST" onsubmit="" >	
                <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 95%;margin-left: 10px;">          
                    <tr><th style="text-align: center" colspan="2"><h1><?php echo $monthName.", ".$g_year." ".$db_offname?></h1></th></tr>
                    <tr><td style="text-align: center" colspan="2">মোট কর্মচারী : <?php echo $total_employee?> জন</td></tr>
                    <tr>
                        <td>
                              <table style="width: 96%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                                        <thead>
                                      <tr id="table_row_odd">
                                          <td width="10%" style="border: solid black 1px;"><div align="center"><strong>ক্রম</strong></div></td>
                                          <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>কর্মচারীর ধরন</strong></div></td>
                                        <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>গ্রেড</strong></div></td>
                                        <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>কর্মচারীর সংখ্যা</strong></div></td>
                                        <td width="30%"  style="border: solid black 1px;"><div align="center"><strong>বেতন (টাকা)</strong></div></td>
                                      </tr>
                                      </thead>
                                      <tbody style="background-color: #FCFEFE">
                                    <?php
                                            $sl = 1; $total_salary = 0;
                                            foreach ($row1 as $row_emp_sal) {
                                                    $count_employee= $row_emp_sal['COUNT(idEmployee)'];
                                                    $employee_type = $row_emp_sal['employee_type'];
                                                    $emp_grade = $row_emp_sal['grade_name'];
                                                    $total_salary += $row_emp_sal['SUM(total_given_amount)'];
                                                echo "<tr>
                                                        <td style='border: 1px solid black'>". english2bangla($sl)."</td>
                                                        <td style='border: 1px solid black'>$arr_who[$employee_type]</td>
                                                        <td style='border: 1px solid black;text-align:center;'>$emp_grade</td>
                                                        <td style='border: 1px solid black;text-align:center;'>".english2bangla($count_employee)." জন</td>
                                                        <td style='border: 1px solid black;text-align:right;'>".english2bangla($row_emp_sal['SUM(total_given_amount)'])."</td>
                                                    </tr>";
                                                $sl++;
                                            }
                                        ?>
                                          <tr>
                                              <td colspan="4" style='border: 1px solid black;text-align:right;'>মোট</td>
                                              <td style='border: 1px solid black;text-align:right;'><?php echo english2bangla($total_salary)." টাকা"?></td>
                                          </tr>
                                      </tbody>
                                      <tr>
                                </table>
                        </td>
                    </tr>
                    <tr><td></br></td></tr>
                </table>
            </form>
        </div>
    </div>   