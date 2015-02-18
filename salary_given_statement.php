<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/selectQueryPDO.php';
if (isset($_GET['id'])) {
    $empCfsid = $_GET['id'];
    $selreslt = mysql_query("SELECT * FROM  cfs_user WHERE idUser = $empCfsid");
    $getrow = mysql_fetch_assoc($selreslt);
    $db_empname = $getrow['account_name'];
    $db_empmobile = $getrow['mobile'];
    $db_email = $getrow['email'];
    $db_account_number = $getrow['account_number'];
    $sql_post = mysql_query("SELECT post_name FROM employee, employee_posting, post_in_ons, post
                                              WHERE idPost = Post_idPost AND idpostinons = post_in_ons_idpostinons AND Employee_idEmployee = idEmployee
                                              AND  cfs_user_idUser = $empCfsid");
    $sql_postrow = mysql_fetch_assoc($sql_post);
    $db_empposition = $sql_postrow['post_name'];
    $sql_employee = mysql_query("SELECT * FROM employee WHERE cfs_user_idUser = $empCfsid");
    $emprow = mysql_fetch_assoc($sql_employee);
    $db_paygrdid = $emprow['pay_grade_id'];
    $sql_grade = mysql_query("SELECT * FROM pay_grade WHERE idpaygrade = $db_paygrdid");
    $emgrade = mysql_fetch_assoc($sql_grade);
    $db_paygrd_name = $emgrade['grade_name'];
    $db_empid = $emprow['idEmployee'];
    $sql_empinfo = mysql_query("SELECT * FROM employee_information WHERE Employee_idEmployee = $db_empid");
    $empinforow = mysql_fetch_assoc($sql_empinfo);
    $db_empphoto = $empinforow['emplo_scanDoc_picture'];

    $currentMonth = date('n');
    $currentYear = date('Y');
    if($currentMonth == 1){
        $currentYear = $currentYear - 1;
        $preMonth = 12;
    } else {
        $preMonth = $currentMonth -1;
    }
    // ************** attendance *************************************
    $select_attendance = mysql_query("SELECT COUNT(idempattend) FROM employee,employee_attendance 
        WHERE   year_no ='$currentYear' AND month_no='$preMonth' AND  cfs_user_idUser = $empCfsid AND idEmployee = emp_user_id ");
    $row = mysql_fetch_assoc($select_attendance);
    $workingDays = $row['COUNT(idempattend)'];

    $sql_attend =$conn->prepare("SELECT COUNT(idempattend) FROM employee,employee_attendance WHERE emp_atnd_type=? AND  year_no =? AND month_no=? AND  cfs_user_idUser = ? AND idEmployee = emp_user_id ");
    $status1 = "present";
    $sql_attend->execute(array($status1,$currentYear,$preMonth,$empCfsid));
    $row1 = $sql_attend->fetchAll();
    foreach ($row1 as $value) {
        $presentDays = $value['COUNT(idempattend)'];
    }
    $status2 ="absent";
    $sql_attend->execute(array($status2,$currentYear,$preMonth,$empCfsid));
    $row2 = $sql_attend->fetchAll();
    foreach ($row2 as $value) {
        $absentDays = $value['COUNT(idempattend)'];
    }
    $status3 = "leave";
    $sql_attend->execute(array($status3,$currentYear,$preMonth,$empCfsid));
    $row3 = $sql_attend->fetchAll();
    foreach ($row3 as $value) {
        $leaveDays = $value['COUNT(idempattend)'];
    }
    // ****************************** salary select ***************************************************************
    $select_salary_chart = mysql_query("SELECT * FROM salary_chart WHERE month_no='$preMonth' AND year_no='$currentYear' AND user_id=$empCfsid ");
    $sal_chart_row = mysql_fetch_assoc($select_salary_chart);
    $db_salary = $sal_chart_row['given_amount'];
    $db_deduct = $sal_chart_row['deducted_amount'];
    $db_bonus = $sal_chart_row['bonus_amount'];
    $db_given_salary = $sal_chart_row['total_given_amount'];
    $db_actual_salary = $sal_chart_row['actual_salary'];
    $db_pension_amount = $sal_chart_row['pension_amount'];
    $db_loan_amount = $sal_chart_row['loan_amount'];
    ?>
    <title>বেতন প্রদানের স্টেটমেন্ট</title>
    <style type="text/css"> @import "css/bush.css";</style>
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="salary_given_statement.php"><b>ফিরে যান</b></a></div>
        <div>
            <form method="POST" onsubmit="" name="" enctype="multipart/form-data" action="">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 18px;">বেতন প্রদানের স্টেটমেন্ট, <?php
                            $last_month = date('F', strtotime('last month'));
                            echo $last_month . "'";
                            $year = date("Y");
                            if ($last_month == "December")
                                echo $year - 1;
                            else
                                echo $year;
                            ?>
                        </th></tr>
                    <tr>
                        <td colspan="2" style=" text-align: right; padding-left: 120px !important; margin: 0px">
                            <table style="border: 1px solid black; width: 80%; ">
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>নাম :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_empname ?></td>
                                    <td width="40%" style="padding-right: 0px;" rowspan="4"> 
                                        <img src="<?php echo $db_empphoto; ?>" width="128px" height="128px" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>একাউন্ট নাম্বার :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_account_number ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>মোবাইল :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_empmobile ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>ইমেল :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_email ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style=" text-align: right; padding-left: 120px !important; margin: 0px">
                            <table style="width: 80%; ">
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>অফিস :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $_SESSION['loggedInOfficeName']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>পোস্ট :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_empposition;?></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>গ্রেড :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_paygrd_name ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>সেলারী :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo english2bangla($db_actual_salary)." টাকা"?></td>
                                </tr>
                                <tr>
                            </table>
                        </td>
                    </tr> 

                    <tr>
                        <td style=" text-align: left; padding-left: 120px !important; margin: 0px; width: 50%">
                            <fieldset style="border: #686c70 solid 3px;width: 95%;">
                                <legend style="color: brown;">বেতনের শ্রেণী বিন্যাস</legend>
                                <table style=" width: 95%; padding-left: 5%" cellspacing="0">
                                    <tr>
                                        <td style="border: 1px solid black;"><b>শ্রেণী</b></td>
                                        <td style="border: 1px solid black;"><b>এমাউন্ট</b></td>
                                    </tr>
                                    <?php
                                    $criteria_total = 0;
                                    $select_salary_criteria = mysql_query("SELECT * FROM salary_criteria");
                                    while($sal_criteria_row = mysql_fetch_assoc($select_salary_criteria))
                                    {
                                        $db_criteria = $sal_criteria_row['criteria_name'];
                                        $db_percentange = $sal_criteria_row['percentage'];
                                        $salary_part = round((($db_actual_salary * $db_percentange) / 100),2);
                                        $criteria_total+= $salary_part;
                                        echo "<tr><td style='border: 1px solid black;'>$db_criteria</td>";
                                        echo "<td style='border: 1px solid black;'>".english2bangla($salary_part)." টাকা</td></tr>";
                                    }
                                        echo "<tr><td style='border: 1px solid black;'>মূল</td>";
                                        echo "<td style='border: 1px solid black;'>".english2bangla($db_actual_salary-$criteria_total)." টাকা</td></tr>";
                                    ?>
                                </table>
                            </fieldset>
                        </td>
                        <td style=" text-align: left; padding-left: 0px !important; margin: 0px;">
                            <fieldset style="border: #686c70 solid 3px;width: 70%;">
                                <legend style="color: brown;">হাজিরা সারসংক্ষেপ</legend>
                                <table style=" width: 95%; padding-left: 5%" cellspacing="0">
                                    <tr>
                                        <td  ><b>মোট কার্যদিবস</b></td>
                                        <td >: <?php echo english2bangla($workingDays) ?> দিন</td>
                                    </tr>
                                    <tr>
                                        <td  ><b>উপস্থিত</b></td>
                                        <td >: <?php echo english2bangla($presentDays) ?> দিন</td>
                                    </tr>
                                    <tr>
                                        <td  ><b>অনুপস্থিত</b></td>
                                        <td >: <?php echo english2bangla($absentDays) ?> দিন</td>
                                    </tr>
                                    <tr>
                                        <td  ><b>ছুটি</b></td>
                                        <td >: <?php echo english2bangla($leaveDays) ?> দিন</td>
                                    </tr>                                    
                                </table>
                            </fieldset>

                            <fieldset style="border: #686c70 solid 3px;width: 70%;">
                                <legend style="color: brown;">অন্যান্য</legend>
                                <table style=" width: 95%; padding-left: 5%" cellspacing="0">
                                    <tr>
                                        <td  ><b>বোনাস</b></td>
                                        <td >: <?php echo english2bangla($db_bonus) ?> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td  ><b>হ্রাস</b></td>
                                        <td >: <?php echo english2bangla($db_deduct) ?> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td><b>পেনশন এমাউন্ট</b></td>
                                        <td>: <?php echo english2bangla($db_pension_amount) ?> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td><b>লোন এমাউন্ট</b></td>
                                        <td>: <?php echo english2bangla($db_loan_amount) ?> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td  ><b>মোট প্রদেয় বেতন</b></td>
                                        <td >: <?php echo english2bangla($db_given_salary) ?> টাকা</td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr >
                        <td style="padding-top: 100px; width: 40%; padding-left: 120px"><hr></td>
                    </tr>
                    <tr>
                        <td style="width: 40%; padding-left: 120px; text-align: center">কর্তৃপক্ষের স্বাক্ষর</td>
                    </tr>
                </table>
            </form>
        </div>           
    </div>
<?php } else {
    ?>
    <title>বেতনের জন্য কর্মচারী লিস্ট</title>
<style type="text/css"> @import "css/style.css";</style>
<div class="column6">
    <div class="main_text_box">      
        <div style="padding-left: 110px;">
            <a href="hr_employee_management.php"><b>ফিরে যান</b></a></br>
            <div style="border: 1px solid grey;">
                <table  style=" width: 100%; margin-bottom: 10px;" > 
                    <tr><th style="text-align: center; background-image: radial-gradient(circle farthest-corner at center top , #FFFFFF 0%, #0883FF 100%);height: 45px;padding-bottom: 5px;padding-top: 5px;" colspan="2" ><h1>কর্মচারীর লিস্ট</h1></th></tr>
                </table>
                <fieldset id="fieldset_style" style=" width: 90% !important; margin-left: 30px !important;" >
                        <div>
                            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                                <thead>
                                    <tr align="left" id="table_row_odd">
                                        <td><b>কর্মচারীর নাম</b></td>
                                        <td><b>একাউন্ট</b></td>
                                        <td><b>মোবাইল</b></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php
                                    $office_id = $_SESSION['loggedInOfficeID'];
                                    $office_type = $_SESSION['loggedInOfficeType'];
                                    $sql_select_id_ons_relation->execute(array($office_type, $office_id));
                                    $id_ons = $sql_select_id_ons_relation->fetchAll();
                                    foreach ($id_ons as $row){
                                        $db_idons_relation = $row['idons_relation'];
                                    }
                                    $rs = mysql_query("SELECT * FROM cfs_user WHERE  	cfs_account_status = 'active' AND idUser = ANY(SELECT cfs_user_idUser FROM employee  WHERE emp_ons_id = '$db_idons_relation');");

                                    while ($rowemployee = mysql_fetch_assoc($rs)) 
                                    {  
                                         $db_user_id = $rowemployee['idUser'];
                                         $db_mobile =  english2bangla($rowemployee['mobile']);
                                         $db_empaccount = $rowemployee['account_number'];
                                        $db_empname = $rowemployee['account_name'];
                                       ?>
                                       <tr align="left">
                                           <td><?php echo $db_empname;?></td>
                                        <td><?php echo $db_empaccount;?></td>
                                        <td><?php echo $db_mobile;?></td>
                                        <td><a href="salary_given_statement.php?id=<?php echo $db_user_id?>">সেলারি স্টেটমেন্ট</a></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>                        
                        </div>     
                </fieldset>
            </div>
        </div>
    </div>
</div>
    <?php
}
include_once 'includes/footer.php';
?>
