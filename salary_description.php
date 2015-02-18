<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/selectQueryPDO.php';

    $empCfsid = $_SESSION['userIDUser'];
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

    if(isset($_POST['submit']))
{
    $p_month = $_POST['month'];
    $p_year = $_POST['year'];
    $monthName = date("F", mktime(0, 0, 0, $p_month, 10));
    // ************** attendance *************************************
    $select_attendance = mysql_query("SELECT COUNT(idempattend) FROM employee,employee_attendance 
        WHERE   year_no ='$p_year' AND month_no='$p_month' AND  cfs_user_idUser = $empCfsid AND idEmployee = emp_user_id ");
    $row = mysql_fetch_assoc($select_attendance);
    $workingDays = $row['COUNT(idempattend)'];

    $sql_attend =$conn->prepare("SELECT COUNT(idempattend) FROM employee,employee_attendance WHERE emp_atnd_type=? AND  year_no =? AND month_no=? AND  cfs_user_idUser = ? AND idEmployee = emp_user_id ");
    $status1 = "present";
    $sql_attend->execute(array($status1,$p_year,$p_month,$empCfsid));
    $row1 = $sql_attend->fetchAll();
    foreach ($row1 as $value) {
        $presentDays = $value['COUNT(idempattend)'];
    }
    $status2 ="absent";
    $sql_attend->execute(array($status2,$p_year,$p_month,$empCfsid));
    $row2 = $sql_attend->fetchAll();
    foreach ($row2 as $value) {
        $absentDays = $value['COUNT(idempattend)'];
    }
    $status3 = "leave";
    $sql_attend->execute(array($status3,$p_year,$p_month,$empCfsid));
    $row3 = $sql_attend->fetchAll();
    foreach ($row3 as $value) {
        $leaveDays = $value['COUNT(idempattend)'];
    }
    // ****************************** salary select ***************************************************************
    $select_salary_chart = mysql_query("SELECT * FROM salary_chart WHERE month_no='$p_month' AND year_no='$p_year' AND user_id=$empCfsid ");
    $sal_chart_row = mysql_fetch_assoc($select_salary_chart);
    $db_salary = $sal_chart_row['given_amount'];
    $db_deduct = $sal_chart_row['deducted_amount'];
    $db_bonus = $sal_chart_row['bonus_amount'];
    $db_given_salary = $sal_chart_row['total_given_amount'];
    $db_actual_salary = $sal_chart_row['actual_salary'];
    $db_pension_amount = $sal_chart_row['pension_amount'];
    $db_loan_amount = $sal_chart_row['loan_amount'];
}
    ?>
    <title>বেতন প্রদানের স্টেটমেন্ট</title>
    <style type="text/css"> @import "css/bush.css";</style>
    <link rel="stylesheet" href="css/print.css" type="text/css">
    <style type="text/css">
    #search {
        width: 50px;background-color: #009933;border: 2px solid #0077D5;cursor: pointer; color: wheat;
    }
    #search:hover {
        background-color: #0077D5;border: 2px inset #009933;color: wheat;
    }
</style>
<script type="text/javascript">
function printthis()
{
    window.print();
}
</script>

    <div class="main_text_box">
        <div id="noprint" style="padding-left: 110px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
        <div>
            <div id="onprint" style="display: none;text-align: center;"><font style="font-size: 16px;">রিপড ইউনিভার্সেল</font> <sub>লিমিটেড</sub></br><?php echo english2bangla(date("d-m-Y"))?></div>
                <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 18px;">বেতন স্টেটমেন্ট</th></tr>
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
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>বর্তমান অফিস :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $_SESSION['loggedInOfficeName']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%; text-align: right"><b>বর্তমান পোস্ট :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_empposition;?></td>
                                </tr>
                                 <tr>
                                    <td style="width: 50%; text-align: right"><b>বর্তমান গ্রেড :</b></td>
                                    <td style="width: 50%; text-align: left"><?php echo $db_paygrd_name;?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr id="noprint">
                        <td  colspan="2">
                            <fieldset style="border: #686c70 solid 3px;width: 68%;margin-left:15%;">
                                <legend style="color: brown">সার্চ</legend>
                                <form method="POST"  action="">	
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
                    </tr> 
                    <tr>
                         <td style="width: 50%; text-align: right"><b>মাস : </b><?php echo $monthName;?> <b>বছর : </b><?php echo $p_year;?></td>
                         <td style="width: 50%; text-align: left"><b>প্রদেয় বেতন : </b><?php echo english2bangla($db_actual_salary)." টাকা"?></td>
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
                            <table>
                                 <tr id="noprint"><td style="text-align: right"><div style="width: 50px;height: 50px;background-image: url('images/print.gif');background-size: 100% 100%;cursor: pointer;" onclick="printthis()"></div></td></tr>
                            </table>
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
                                        <td><b>বোনাস</b></td>
                                        <td>: <?php echo english2bangla($db_bonus) ?> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td><b>হ্রাস</b></td>
                                        <td>: <?php echo english2bangla($db_deduct) ?> টাকা</td>
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
                                        <td><b>মোট প্রাপ্ত বেতন</b></td>
                                        <td>: <?php echo english2bangla($db_given_salary) ?> টাকা</td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                </table>
        </div>           
    </div>
<?php include_once 'includes/footer.php';?>