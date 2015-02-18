<?php
//include 'includes/session.inc';
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
 $loginUSERid = $_SESSION['userIDUser'] ;
 $logedinOfficeId = $_SESSION['loggedInOfficeID'];
 
 $g_progcost_id = $_GET['id'];
 $g_nfcid = $_GET['nfcid'];
$arr_fundtype = array('presentation'=>'SPR','program'=>'SPG','training'=>'STR','travel'=>'STL');

$sql_update_notification = $conn->prepare("UPDATE notification SET nfc_status=? WHERE idnotification=? ");
$up_prog_cost = $conn->prepare("UPDATE program_cost SET pc_status='given' WHERE idprogcost=? ");
$up_main_fund = $conn->prepare("UPDATE main_fund SET fund_amount=fund_amount - ? WHERE fund_code=? ");
$sel_prog_cost = $conn->prepare("SELECT * FROM program_cost JOIN program ON fk_program_id = idprogram WHERE idprogcost= ? AND pc_status = 'approved' ");
$ins_daily_inout = $conn->prepare("INSERT INTO acc_ofc_daily_inout (daily_date, daily_onsid, out_amount) VALUES (NOW(),?,?)");
// ************************* select query ****************************************
$sel_prog_cost->execute(array($g_progcost_id));
$row = $sel_prog_cost->fetchAll();
foreach ($row as $value) {
    $db_progname = $value['program_name'];
    $db_progdate = $value['program_date'];
    $db_needtotal = $value['pc_need_amount'];
    $db_prog_type = $value['program_type'];
}
$fundcode = $arr_fundtype[$db_prog_type];

if(isset($_POST['submit'])) // after submit***************************************
{
    $sel_onsID = $conn->prepare("SELECT idons_relation FROM ons_relation WHERE add_ons_id = ? AND catagory='office'");
    $sel_onsID->execute(array($logedinOfficeId));
    $offrow = $sel_onsID->fetchAll();
    foreach ($offrow as $value) {
       $office_ons_id = $value['idons_relation'];
    }
    
    $p_total = $_POST['total'];
    $p_fundcode = $_POST['fundcode'];
    $nfcID=$_POST['nfcID'];
    
    $conn->beginTransaction(); 
    $sqlrslt1= $up_prog_cost->execute(array($g_progcost_id));
    $status = 'complete';
    $sqlrslt3 = $sql_update_notification->execute(array($status,$nfcID));
    $insert = $ins_daily_inout->execute(array($office_ons_id,$p_total));
    $sqlrslt4 = $up_main_fund->execute(array($p_total,$p_fundcode));
      if($sqlrslt1 && $sqlrslt3 && $insert && $sqlrslt4)
        {
            $conn->commit();
            echo "<script>alert('বাজেট উত্তোলন করা হল');</script>";
            header('Location:main_account_management.php');
        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত,বাজেট উত্তোলন করা যায়নি)</script>";
        }
}
?>
<style type="text/css"> @import "css/bush.css";</style>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="notification.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" action="program_cost_paid.php">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;">বাজেটের টাকা গ্রহন</th></tr>
                    <tr>
                        <td colspan="2" style="text-align: center;font-size: 16px;"><input type="hidden" name="total" value="<?php echo $db_needtotal;?>" />
                            <?php echo english2bangla(date('d/m/Y', strtotime($db_progdate)))?>-তারিখের <?php echo $db_progname?>-এর খরচ বাবদ <?php echo english2bangla($db_needtotal);?> টাকা গ্রহন ও উত্তোলন করা হল
                        </td>          
                    </tr>
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input type="hidden" name="fundcode" value="<?php echo $fundcode;?>" />
                            <input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="গ্রহন করা হল" />
                        <input type="hidden" name="nfcID" value="<?php echo $g_nfcid;?>" /></td>                           
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