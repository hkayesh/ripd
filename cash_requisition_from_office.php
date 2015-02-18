<?php
//include 'includes/session.inc';
//error_reporting(0);
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$loginUSERid = $_SESSION['userIDUser'] ;
$g_requisition_id = $_GET['id'];

$sel_requisition = $conn->prepare("SELECT * FROM cash_requisition WHERE idrequisition= ?");
$sql_select_ons = $conn->prepare("SELECT * FROM ons_relation WHERE idons_relation = ?");
$sql_select_office = $conn->prepare("SELECT * FROM office WHERE idOffice = ?");
$sql_select_sales_store = $conn->prepare("SELECT * FROM sales_store WHERE idSales_store = ?");

$sel_requisition->execute(array($g_requisition_id));
$row = $sel_requisition->fetchAll();
foreach ($row as $value) {
    $db_amount = $value['requisit_amount'];
    $db_reason = $value['reason'];
    $db_date = $value['requisition_date'];
    $db_onsID = $value['ons_id'];
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
?>
<style type="text/css"> @import "css/bush.css";</style>

    <div class="main_text_box">
        <div>           
            <form method="POST" action="">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr>
                        <td >অফিসের নাম</td>
                        <td>: <input class="box" type="text" style="text-align: right;" readonly="" value="<?php echo $db_officename;?>" /></td>          
                    </tr>
                    <tr>
                        <td >টাকার পরিমান</td>
                        <td>: <input class="box" type="text" style="text-align: right;" readonly="" value="<?php echo $db_amount;?>" /> টাকা</td> 
                    </tr>
                    <tr>
                        <td >কারন</td>
                        <td><textarea name="description" ><?php echo $db_reason;?></textarea></td> 
                    </tr>
                    <tr>
                        <td >আবেদনের তারিখ</td>
                        <td>: <input class="box" type="text" style="text-align: right;" readonly="" value="<?php echo english2bangla(date("d/m/Y", strtotime($db_date)));?>" /></td> 
                    </tr>   
                </table>
                </fieldset>
            </form>
        </div>
    </div>