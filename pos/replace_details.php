<?php
error_reporting(0);
session_start();
include_once 'includes/MiscFunctions.php';
include 'includes/connectionPDO.php';
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
$id = $_GET['rep_id'];
$select_replace_details = $conn->prepare("SELECT * FROM replace_product, inventory WHERE replace_product_summary_idreproductsum = ?
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
                <td>প্রোডাক্ট কোড</td>
                <td>প্রোডাক্ট নাম</td>
                <td>রিপ্লেস পরিমাণ</td>
                <td>টাকা</td>
            </tr>
            <?php 
            $select_replace_details->execute(array($id));
            $details = $select_replace_details->fetchAll();
            foreach ($details as $row){
                $db_ins_product_code= $row['ins_product_code'];
                $db_ins_productname = $row['ins_productname'];
                $db_reppro_quantity= $row['reppro_quantity'];
                $db_reppro_amount= $row['reppro_amount'];
                echo "
             <tr>
                <td>$db_ins_product_code</td>
                <td>$db_ins_productname</td>
                <td>$db_reppro_quantity</td>
                <td>$db_reppro_amount</td>
            </tr>";
            }
            ?>
        </table>
   </div>
</div></br>
</div>
</body>
</html>