<?php
//include 'includes/session.inc';
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
 $loginUSERid = $_SESSION['userIDUser'] ;
 $logedinOfficeId = $_SESSION['loggedInOfficeID'];
 
 $g_ons_exp_id = $_GET['id'];
 $g_nfcid = $_GET['nfcid'];

$sql_update_notification = $conn->prepare("UPDATE notification SET nfc_status=? WHERE idnotification=? ");
$sql_fixed_expenditure = $conn->prepare("UPDATE ons_fixed_expenditure SET status='given' WHERE idfixexp=? ");
$sel_fixed_exp = $conn->prepare("SELECT * FROM ons_fixed_expenditure WHERE idfixexp= ? AND 	status = 'approved' ");
$ins_daily_inout = $conn->prepare("INSERT INTO acc_ofc_daily_inout (daily_date, daily_onsid, out_amount) VALUES (NOW(),?,?)");
// ************************* select query ****************************************
$sel_fixed_exp->execute(array($g_ons_exp_id));
$row = $sel_fixed_exp->fetchAll();
foreach ($row as $value) {
    $db_month = $value['month'];
    $db_year = $value['year'];
    $monthName = date("F", mktime(0, 0, 0, $db_month, 10));
    $db_monthlytotal = $value['ons_monthly_total'];
}

if(isset($_POST['submit']))
{
    $sel_onsID = $conn->prepare("SELECT idons_relation FROM ons_relation WHERE add_ons_id = ? AND catagory='office'");
    $sel_onsID->execute(array($logedinOfficeId));
    $offrow = $sel_onsID->fetchAll();
    foreach ($offrow as $value) {
       $office_ons_id = $value['idons_relation'];
    }
    
    $p_total = $_POST['total'];
    $conn->beginTransaction(); 
    $sqlrslt1= $sql_fixed_expenditure->execute(array($g_ons_exp_id ));
    $status = 'complete';
    $sqlrslt3 = $sql_update_notification->execute(array($status,$g_nfcid));
    $insert = $ins_daily_inout->execute(array($office_ons_id,$p_total));
    
     if($sqlrslt1 && $sqlrslt3 && $insert)
        {
            $conn->commit();
            echo "<script>alert('খরচ করা হল');
                window.location = 'main_account_management.php';</script>";
        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত,খরচ করা' যায়নি)</script>";
        }
}
?>
<style type="text/css"> @import "css/bush.css";</style>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="notification.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" action="">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;">মাসিক খরচের টাকা গ্রহন</th></tr>
                    <tr>
                        <td colspan="2" style="text-align: center;font-size: 16px;"><input type="hidden" name="total" value="<?php echo $db_monthlytotal;?>" />
                            <?php echo $monthName." , ".$db_year?>-এর মাসিক খরচ বাবদ <?php echo $db_monthlytotal?> টাকা গ্রহন করা হল
                        </td>          
                    </tr>
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="গ্রহন করা হল" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>