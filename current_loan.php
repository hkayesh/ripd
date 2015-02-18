<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$session_user_id = $_SESSION['userIDUser'];
$sel_employee_id = $conn->prepare("SELECT idEmployee FROM employee WHERE cfs_user_idUser = ?");
$sel_employee_id->execute(array($session_user_id));
$emprow = $sel_employee_id->fetchAll();
foreach ($emprow as $value) {
    $db_empID = $value['idEmployee'];
}
$sel_loan = $conn->prepare("SELECT * FROM employee_salary, loan WHERE fk_idloan = idLoan
                                                AND user_id = ? ORDER BY insert_date DESC LIMIT 1");
$sel_loan->execute(array($db_empID));
$loanrow = $sel_loan->fetchAll();
foreach ($loanrow as $row) {
    $db_loan_next = $row['loan_next'];
    $db_remain_month = $row['loan_repay_month'];
    $db_loan_amount = $row['loan_amount'];
    $db_total_month = $row['repay_howmany_month'];
    $db_monthly_amount = $row['repay_amount_monthly'];
    $db_loan_date = $row['loan_date'];
}
?>
<style type="text/css"> @import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<div class="main_text_box">
    <div style="padding-left: 110px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
    <div>
        <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
            <tr><th colspan="2" style="text-align: center;font-size: 22px;">কারেন্ট লোন</th></tr>
            <tr >
                <td style="text-align: right; width: 50%"><b>টোটাল লোন এমাউন্টঃ</b></td>
                <td><?php echo $db_loan_amount;?> টাকা</td>
            </tr>
            <tr >
                <td style="text-align: right; width: 50%"><b>লোন গ্রহনের তারিখঃ </b></td>
                <td><?php echo english2bangla(date("d/m/Y",  strtotime($db_loan_date)));?></td>
            </tr>
            <tr >
                <td style="text-align: right; width: 50%"><b>মোট মাসিক কিস্তির পরিমাণঃ </b></td>
                <td><?php echo $db_total_month;?> টি</td>
            </tr>
            <tr >
                <td style="text-align: right; width: 50%"><b>প্রতি কিস্তিতে এমাউন্টঃ </b></td>
                <td><?php echo $db_monthly_amount;?> টাকা</td>
            </tr>
            <tr>
                <td colspan="2" ><hr /></td>
            </tr>
            <tr>
                <td style="width: 50%; border-right: 2px solid black;">
                    <table>
                        <tr>
                            <td style="text-align: right; width: 50%">মোট প্রদেয় কিস্তিঃ </td>
                            <td style="text-align: left"><?php echo ($db_total_month - $db_remain_month);?> টি</td>
                        </tr>
                        <tr>
                            <td style="text-align: right; width: 50%">মোট প্রদেয় এমাউন্টঃ </td>
                            <td style="text-align: left"><?php echo (($db_total_month - $db_remain_month) * $db_monthly_amount) ;?> টাকা</td>
                        </tr>
                    </table>
                </td>
                <td><table>
                        <tr>
                            <td style=" width: 50%">বাকি কিস্তিঃ </td>
                            <td style=""><?php echo $db_remain_month;?> টি</td>
                        </tr>
                        <tr>
                            <td style=" width: 50%">বাকি এমাউন্টঃ </td>
                            <td style=""><?php echo ($db_remain_month * $db_loan_next);?> টাকা</td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td colspan="2" ><hr /></td>
            </tr>
            <tr>
                <td colspan="2">
                        <table border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">    
                            <tr  id="table_row_odd">
                                <td style="border: black 1px solid; text-align: center">তারিখ</td>
                                <td style="border: black 1px solid; text-align: center" >এমাউন্ট</td>
                                <td style="border: black 1px solid; text-align: center">চার্জ</td>
                            </tr>
                            <tr>
                                <td style="border: black 1px solid; text-align: center">1</td>
                                <td style="border: black 1px solid; text-align: center">1</td>
                                <td style="border: black 1px solid; text-align: center">1</td>
                            </tr> 
                        </table>
                </td>
            </tr>
        </table>
    </div>           
</div>
<?php
include_once 'includes/footer.php';
?>