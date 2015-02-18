<?php
//include 'includes/session.inc';
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$loginUSERid = $_SESSION['userIDUser'] ;
$g_ons_exp_id = $_GET['id'];
$g_nfcid = $_GET['nfcid'];

$sql_update_notification = $conn->prepare("UPDATE notification SET nfc_status=? WHERE idnotification=? ");
$sql_fixed_expenditure = $conn->prepare("UPDATE ons_fixed_expenditure SET status='approved' WHERE idfixexp=? ");
$insert_notification = $conn->prepare("INSERT INTO notification (nfc_senderid,nfc_receiverid,nfc_message,nfc_actionurl,nfc_date,nfc_status, nfc_type, nfc_catagory) 
                                                            VALUES (?,?,?,?,NOW(),?,?,?)");
$sel_fixed_exp = $conn->prepare("SELECT * FROM ons_fixed_expenditure WHERE idfixexp= ? AND 	status = 'made' ");
$sql_select_ons = $conn->prepare("SELECT * FROM ons_relation WHERE idons_relation = ?");
$sql_select_office = $conn->prepare("SELECT * FROM office WHERE idOffice = ?");
$sql_select_sales_store = $conn->prepare("SELECT * FROM sales_store WHERE idSales_store = ?");

$sel_fixed_exp->execute(array($g_ons_exp_id));
$row = $sel_fixed_exp->fetchAll();
foreach ($row as $value) {
    $db_month = $value['month'];
    $db_year = $value['year'];
    $monthName = date("F", mktime(0, 0, 0, $db_month, 10));
    $db_rent = $value['ons_rent'];
    $db_currentbill = $value['ons_current_bill'];
    $db_waterbill = $value['ons_water_bill'];
    $db_otherscost = $value['ons_others_total'];
    $db_monthlytotal = $value['ons_monthly_total'];
    $db_onsID = $value['fk_onsid'];
    $sql_select_ons->execute(array($db_onsID));
   $row2 = $sql_select_ons->fetchAll();
    foreach ($row2 as $value2) {
        $db_catagory = $value2['catagory'];
        $db_id = $value2['add_ons_id'];
    }
    if($db_catagory == 'office')
    {
        $sql_select_office->execute(array($db_id));
        $row3 = $sql_select_office->fetchAll();
        foreach ($row3 as $value3) {
            $db_officename = $value3['office_name'];
        }
    }
    else
    {
        $sql_select_sales_store->execute(array($db_id));
        $row3 = $sql_select_sales_store->fetchAll();
        foreach ($row3 as $value3) {
            $db_officename = $value3['salesStore_name'];
        }
    }
}
if(isset($_POST['submit']))
{
     $conn->beginTransaction(); 
    $sqlrslt1= $sql_fixed_expenditure->execute(array($g_ons_exp_id ));
    $status = 'complete';
    $sqlrslt2 = $sql_update_notification->execute(array($status,$g_nfcid));
    $url = "monthly_cost_paid.php?id=".$g_ons_exp_id;
    $status1 = "unread";
    $type="action";
    $nfc_catagory="official";
    $msg = "মাসিক খরচ অনুমোদন";
    $onsID = $_POST['senderOnsID'];
    $sqlrslt3 = $insert_notification->execute(array($loginUSERid,$onsID,$msg,$url,$status1,$type,$nfc_catagory));
     if($sqlrslt1 && $sqlrslt2 && $sqlrslt3)
        {
            $conn->commit();
            echo "<script>alert('খরচ অনুমোদন করা হল');
                window.location = 'main_account_management.php';</script>";
        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত,খরচ অনুমোদন করা যায়নি)</script>";
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
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;"><?php echo $db_officename?> -এর মাসিক খরচ অনুমোদন, <?php echo $monthName." ,".$db_year?></th></tr>
                    <tr>
                        <td >অফিস ভাড়া</td>
                        <td>: <input class="box" type="text" style="text-align: right;" readonly="" value="<?php echo $db_rent;?>" /> টাকা <input type="hidden" name="senderOnsID" value="<?php echo $db_onsID?>" /></td>          
                    </tr>
                    <tr>
                        <td >কারেন্ট বিল</td>
                        <td>: <input class="box" type="text" style="text-align: right;" readonly="" value="<?php echo $db_currentbill;?>" /> টাকা</td> 
                    </tr>
                    <tr>
                        <td >পানির বিল</td>
                        <td>: <input class="box" type="text" style="text-align: right;" readonly="" value="<?php echo $db_waterbill;?>" /> টাকা</td> 
                    </tr>
                    <tr>
                        <td >অন্যান্য</td>
                        <td>: <input class="box" type="text" style="text-align: right;" readonly="" value="<?php echo $db_otherscost;?>" /> টাকা</td> 
                    </tr>
                    <tr>
                        <td >মোট মাসিক খরচ</td>
                        <td>: <input class="box" type="text" style="text-align: right;" readonly="" value="<?php echo $db_monthlytotal;?>" /> টাকা</td> 
                    </tr> 
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="অনুমোদন হল" /></td>                           
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