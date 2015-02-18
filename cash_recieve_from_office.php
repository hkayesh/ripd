<?php
//include 'includes/session.inc';
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
 $loginUSERid = $_SESSION['userIDUser'] ;
 $g_acc_ofc_physc_in = $_GET['id'];
 $g_nfcid = $_GET['nfcid'];

$sql_update_notification = $conn->prepare("UPDATE notification SET nfc_status=? WHERE idnotification=? ");
$sel_select_acc_ofc = $conn->prepare("SELECT * FROM acc_ofc_physc_in LEFT JOIN bank_list ON idbank = bank_id WHERE idofcphysin= ?");
$up_acc_ofc_physc_in = $conn->prepare("UPDATE acc_ofc_physc_in SET receving_date = NOW(), rceiver_id = ? WHERE idofcphysin = ?");
$sql_select_ons = $conn->prepare("SELECT * FROM ons_relation WHERE idons_relation = ?");
$sql_select_office = $conn->prepare("SELECT * FROM office WHERE idOffice = ?");
$sql_select_sales_store = $conn->prepare("SELECT * FROM sales_store WHERE idSales_store = ?");

$sel_select_acc_ofc->execute(array($g_acc_ofc_physc_in));
$row = $sel_select_acc_ofc->fetchAll();
foreach ($row as $value) {
    $db_inamount = $value['inamount'];
    $db_bank = $value['bank_name'];
    $db_cheque = $value['cheque_number'];
    $db_sendingDate = $value['sending_date'];
    $db_onsID = $value['office_id'];
    if($db_cheque == '0')
    {
        $intype = "ক্যাশ";
    }
    else {
           $intype = "চেক";
       }
  
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
    $sqlrslt1= $up_acc_ofc_physc_in->execute(array($loginUSERid,$g_acc_ofc_physc_in ));
    $status = 'complete';
    $sqlrslt3 = $sql_update_notification->execute(array($status,$g_nfcid));
     if($sqlrslt1 && $sqlrslt3)
        {
            $conn->commit();
            echo "<script>alert('টাকা গ্রহন করা হল'); 
                window.location = 'main_account_management.php';</script>";

        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত,টাকা গ্রহন করা' যায়নি)</script>";
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
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;"><?php echo $db_officename?> হতে টাকা গ্রহন</th></tr>
                    <tr>
                        <td >গ্রহনকৃত মোট টাকা</td>
                        <td>: <input class="box" type="text" style="text-align: right;" readonly="" value="<?php echo $db_inamount;?>" /> টাকা</td>          
                    </tr>
                    <tr>
                        <td >পদ্ধতি</td>
                        <td>: <input class="box" type="text" readonly="" value="<?php echo $intype;?>" /></td> 
                    </tr>
                    <tr>
                        <td >ব্যাংকের নাম</td>
                        <td>: <input class="box" type="text" readonly="" value="<?php echo $db_bank;?>" /></td> 
                    </tr>
                    <tr>
                        <td >চেক নং</td>
                        <td>: <input class="box" type="text" readonly="" value="<?php echo $db_cheque;?>" /></td> 
                    </tr>
                    <tr>
                        <td >টাকা প্রেরনের তারিখ</td>
                        <td>: <input class="box" type="text" readonly="" value="<?php echo date("d/m/Y",  strtotime($db_sendingDate));?>" /></td> 
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