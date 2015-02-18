<?php
error_reporting(0);
session_start();
include_once 'includes/MiscFunctions.php';
include 'includes/connectionPDO.php';
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
$id = $_GET['sum_id'];
$select_summary_details = $conn->prepare("SELECT * 
                                                    FROM sales, inventory
                                                    WHERE sales_summery_idsalessummery = ?
                                                    AND inventory_idinventory = idinventory");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script language="JavaScript" type="text/javascript" src="productsearch.js"></script>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
</head>
    
<body>
<div id="maindiv">
<div class="wraper" style="width: 99%;font-family: SolaimanLipi !important;">
    <div style="width: 100%;font-family: SolaimanLipi !important;">
        <table border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td width="8%" style="color: blue; font-size: 25px"><div align="center"><strong>ক্রম</strong></div></td>
                <td width="20%" style="color: blue; font-size: 25px"><div align="center"><strong>কোড</strong></div></td>
                <td width="30%" style="color: blue; font-size: 25px"><div align="center"><strong>নাম</strong></div></td>
                <td width="10%" style="color: blue; font-size: 25px"><div align="center"><strong>পরিমাণ</strong></div></td>
                <td width="15%" style="color: blue; font-size: 25px"><div align="center"><strong>মোট (টাকা)</strong></div></td>
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
                echo "
             <tr>
                <td style='text-align: center'>$show_count</td>
                <td>$db_ins_product_code</td>
                <td>$db_ins_productname</td>
                <td style='text-align: center'>$show_quantity</td>
                <td style='text-align: center'>$show_amount</td>
            </tr>";
            }
            ?>
            <tr>        
                <td colspan="3" ><div align="right"><strong>সর্বমোট :</strong></div></td>
                <td ><div align="center"><?php echo english2bangla($total_quantity)." টি";?></div></td>
                <td ><div align="center"><?php echo english2bangla($total_amount)." টাকা";?></div></td>
            </tr>
        </table>
   </div>
</div></br>
</div>
</body>
</html>