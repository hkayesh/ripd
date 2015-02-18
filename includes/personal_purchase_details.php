<?php
error_reporting(0);
session_start();
include_once 'MiscFunctions.php';
include 'connectionPDO.php';
$id = $_GET['sum_id'];
$select_summary_details = $conn->prepare("SELECT *  FROM sales, inventory WHERE sales_summery_idsalessummery = ?
                                                                        AND inventory_idinventory = idinventory");
$sel_command = $conn->prepare("SELECT * FROM running_command");
$sel_command->execute();
$arr_rslt = $sel_command->fetchAll();
foreach ($arr_rslt as $value) {
    $db_pv = $value['pv_value'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<style type="text/css">@import "../css/bush.css";</style>
</head>   
<body>
<div id="main_text_box">
    <div style="width: 100%;font-family: SolaimanLipi !important;">
        <table  class="formstyle" style="width: 98%;margin: 15px !important;" cellspacing="0">     
        <tr><th colspan="6" style="text-align: center" colspan="2"><h1>ক্রয়কৃত পণ্যতালিকা </h1></th></tr>
        <tr id='table_row_odd'>
            <td width="8%" style="color: blue;border:1px black solid; "><div align="center"><strong>ক্রম</strong></div></td>
            <td width="20%" style="color: blue;border:1px black solid; "><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
            <td width="30%" style="color: blue;border:1px black solid;"><div align="center"><strong>প্রোডাক্টের নাম</strong></div></td>
            <td width="10%" style="color: blue;border:1px black solid; "><div align="center"><strong>পরিমাণ</strong></div></td>
            <td width="15%" style="color: blue;border:1px black solid; "><div align="center"><strong>মোট (টাকা)</strong></div></td>
            <td width="15%" style="color: blue;border:1px black solid; "><div align="center"><strong>মোট পিভি</strong></div></td>
        </tr>
            <?php 
                $select_summary_details->execute(array($id));
                $details = $select_summary_details->fetchAll();
                $count = 0;
                $total_quantity = 0;
                $total_amount = 0;
                foreach ($details as $row){
                $count++;
                $show_count = english2bangla($count);
                $db_ins_product_code= $row['ins_product_code'];
                $db_ins_productname = $row['ins_productname'];
                $total_quantity += $db_quantity= $row['quantity'];
                $show_quantity = english2bangla($db_quantity);
                $total_amount += $db_sales_amount= $row['sales_amount'];
                $show_amount = english2bangla($db_sales_amount);
                $total_pv += $db_sales_pv= ($row['sales_profit']*$db_pv);
                echo "
                <tr>
                <td style='text-align: cente;border:1px black solid;'>$show_count</td>
                <td style='border:1px black solid;'>$db_ins_product_code</td>
                <td style='border:1px black solid;'>$db_ins_productname</td>
                <td style='text-align: center;border:1px black solid;'>$show_quantity</td>
                <td style='text-align: center;border:1px black solid;'>$show_amount</td>
                <td style='text-align: center;border:1px black solid;'>".  english2bangla($db_sales_pv)."</td>
                </tr>";
            }
            ?>
        <tr>        
            <td style='text-align: right;border:1px black solid;' colspan="3" ><strong>সর্বমোট :</strong></td>
            <td style='text-align: center;border:1px black solid;'><?php echo english2bangla($total_quantity)." টি";?></td>
            <td style='text-align: center;border:1px black solid;'><?php echo english2bangla($total_amount)." টাকা";?></td>
            <td style='text-align: center;border:1px black solid;'><?php echo english2bangla($total_pv);?></td>
        </tr>
    </table>
   </div>
</div></br>
</body>
</html>
