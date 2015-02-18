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
$sel_total_loan = $conn->prepare("SELECT COUNT(idLoan), SUM(loan_amount) FROM loan WHERE Employee_idEmployee = ? AND loan_status ='paid' ");
$sel_total_loan->execute(array($db_empID));
$totalloanrow = $sel_total_loan->fetchAll();
foreach ($totalloanrow as $row) {
    $db_total_loan = $row['COUNT(idLoan)'];
    $db_total_amount = $row['SUM(loan_amount)'];
}

$sel_loan = $conn->prepare("SELECT * FROM loan WHERE Employee_idEmployee = ? AND loan_status ='paid' ORDER BY loan_date");

?>
<title>প্রিভিইয়াস স্টেটমেন্ট</title>
<style type="text/css"> @import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>

<div class="main_text_box">
    <div style="padding-left: 110px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
    <div>
        <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
            <tr><th colspan="2" style="text-align: center;font-size: 22px;">প্রিভিয়াস লোন স্টেটমেন্ট</th></tr>
            <tr >
                <td style="text-align: right; width: 50%"><b>মোট লোন সংখ্যাঃ</b></td>
                <td><?php echo $db_total_loan;?> টি</td>
            </tr>
            <tr>
                <td style="text-align: right; width: 50%"><b>টোটাল লোন এমাউন্টঃ</b></td>
                <td><?php echo $db_total_amount;?> টাকা</td>
            </tr>
            <tr>
                <td colspan="2">
                    <table border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">    
                            <tr  id="table_row_odd">
                                <td style="border: black 1px solid; text-align: center">ক্রম</td>
                                <td style="border: black 1px solid; text-align: center">শুরুর তারিখ</td>
                                <td style="border: black 1px solid; text-align: center" >শেষের তারিখ</td>
                                <td style="border: black 1px solid; text-align: center">কিস্তির মাস</td>
                                <td style="border: black 1px solid; text-align: center">মাসিক কিস্তির এমাউন্ট (টাকা)</td>
                                <td style="border: black 1px solid; text-align: center">মোট এমাউন্ট (টাকা)</td>
                            </tr>
                        <?php
                                $sl = 1;
                                $sel_loan->execute(array($db_empID));
                                $loanrow = $sel_loan->fetchAll();
                                foreach ($loanrow as $row) {
                                    $db_loan_amount = $row['loan_amount'];
                                    $db_total_month = $row['repay_howmany_month'];
                                    $db_monthly_amount = $row['repay_amount_monthly'];
                                    $db_loan_date = $row['loan_date'];
                                    $ending_date = date('d/m/Y', strtotime("+".$db_total_month." months", strtotime($db_loan_date)));
                        ?>
                            <tr>
                                <td style="border: black 1px solid; text-align: center"><?php echo $sl;?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo english2bangla(date("d/m/Y",  strtotime($db_loan_date)));?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo english2bangla($ending_date);?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo $db_total_month;?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo $db_monthly_amount;?></td>
                                <td style="border: black 1px solid; text-align: center"><?php echo $db_loan_amount;?></td>
                            </tr> 
                                <?php $sl++;  } ?>
                        </table>
                </td>
            </tr>
        </table>
    </div>           
</div>
<?php
include_once 'includes/footer.php';
?>