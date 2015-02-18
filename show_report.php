<?php
error_reporting(0);
include_once './includes/connectionPDO.php';
include_once './includes/MiscFunctions.php';
$cfsID = $_SESSION['userIDUser'];
$g_progID = $_GET['progid'];

$sel_prog_details = $conn->prepare("SELECT * FROM program_cost JOIN program ON fk_program_id = idprogram 
                                                           WHERE  fk_program_id = ?");
$sel_ticket = $conn->prepare("SELECT * FROM ticket WHERE Program_idprogram = ?");
$sel_prog_details->execute(array($g_progID));
$progrow = $sel_prog_details->fetchAll();
foreach ($progrow as $row) {
    $db_progname = $row['program_name'];
    $db_progno = $row['program_no'];
    $db_progdate = $row['program_date'];
    $db_progBudget = $row['pc_need_amount'];
    $db_progtype = $row['program_type'];
    $db_programer_cost = $row['total_payment'];
}
$total_ticket_amount = 0;
$sel_ticket->execute(array($g_progID));
$ticktrow = $sel_ticket->fetchAll();
foreach ($ticktrow as $value) {
    $db_ticket_sell = $value['total_amount'];
    $total_ticket_amount =+ $db_ticket_sell;
}
$profit_loss = $total_ticket_amount - ($db_programer_cost + $db_progBudget);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css"> @import "css/bush.css";</style>
</head>
<body>

    <div class="main_text_box">
        <div>	
                <table  class="formstyle" style="font-family: SolaimanLipi !important; margin: 5px !important;width: 100%;">          
                    <tr><th colspan="4" style="text-align: center;">রিপোর্ট</th></tr>
                    <tr>
                        <td><?php echo getProgramType($db_progtype);?> এর নম্বর</td>
                        <td>:  <input class="box" type="text" readonly="" value="<?php echo $db_progno?>"/></td>
                    </tr>
                    <tr>
                        <td><?php echo getProgramType($db_progtype);?> এর নাম</td>
                        <td>:  <input class="box" type="text" readonly="" value="<?php echo $db_progname?>" /></td>
                    </tr>
                    <tr>
                        <td><?php echo getProgramType($db_progtype);?> -এর তারিখ</td>
                        <td colspan="3">: <input class="box"type="text" value="<?php echo english2bangla(date('d/m/Y',  strtotime($db_progdate)));?>"/></td>    
                    </tr>
                   <tr>
                    <td>টিকেট বিক্রি হতে মোট আয়</td>               
                    <td colspan="3">: <input class="box" value="<?php echo english2bangla($total_ticket_amount);?>" /> টাকা</td>
                </tr>
                <tr>
                    <td>প্রোগ্রামের খরচ</td>
                    <td colspan="3">: <input  class="box" type="text" readonly value="<?php echo english2bangla($db_progBudget);?>"/> টাকা</td>            
                </tr>           
                <tr>
                    <td>প্রোগ্রামারদের বেতন বাবদ খরচ</td>
                    <td colspan="3">: <input  class="box" type="text" value="<?php echo english2bangla($db_programer_cost);?>"/> টাকা</td>  
                </tr>
                    <tr>
                        <td colspan="3"><hr/></td>
                    </tr>
                <tr>
                    <td>প্রফিট / লস</td>
                    <td>: <input  class="box" type="text" readonly value="<?php echo english2bangla($profit_loss);?>" /> টাকা</td>
                </tr>
                </table>
        </div>
    </div>      
</body>
</html>
