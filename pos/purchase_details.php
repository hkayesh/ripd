<?php
error_reporting(0);
session_start();
include_once 'includes/MiscFunctions.php';
include 'includes/connectionPDO.php';
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
$id = $_GET['pur_id'];
$select_purchase_details = $conn->prepare("SELECT * 
                                                    FROM product_purchase, product_chart 
                                                    WHERE pps_id = ?
                                                    AND Product_chart_idproductchart = idproductchart");
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
                <td width="8%" style="color: blue; font-size: 20px"><div align="center"><strong>ক্রম</strong></div></td>
                <td width="20%" style="color: blue; font-size: 20px"><div align="center"><strong>কোড</strong></div></td>
                <td width="20%" style="color: blue; font-size: 20px"><div align="center"><strong>নাম</strong></div></td>
                <td width="10%" style="color: blue; font-size: 20px"><div align="center"><strong>পরিমাণ</strong></div></td>
                <td width="15%" style="color: blue; font-size: 20px"><div align="center"><strong>ক্রয়মূল্য (টাকা)</strong></div></td>
                <td width="10%" style="color: blue; font-size: 20px"><div align="center"><strong>ক্রয়ের ধরণ</strong></div></td>
            </tr>
            <?php 
            $select_purchase_details->execute(array($id));
            $details = $select_purchase_details->fetchAll();
            $count = 0;
            foreach ($details as $row){
                $count++;
                $show_count = english2bangla($count);
                $db_pro_code= $row['pro_code'];
                $db_pro_productname = $row['pro_productname'];
                $db_quantity= $row['in_howmany'];
                $show_quantity = english2bangla($db_quantity);
                $db_sales_amount= $row['in_buying_price'];
                $show_amount = english2bangla($db_sales_amount);
                $db_input_type = $row['input_type'];
                if($db_input_type == "in"){
                   $db_input_type =  "নতুন ক্রয়";
                }else if($db_input_type == "replace"){
                    $db_input_type = "রিপ্লেস";
                }
                echo "
             <tr>
                <td style='text-align: center'>$show_count</td>
                <td >$db_pro_code</td>
                <td >$db_pro_productname</td>
                <td style='text-align: center'>$show_quantity</td>
                <td style='text-align: center'>$show_amount</td>
                <td style='text-align: center'>$db_input_type</td>
            </tr>";
            }
            ?>
            <tr>
            </tr>
        </table>
   </div>
</div></br>
</div>
</body>
</html>