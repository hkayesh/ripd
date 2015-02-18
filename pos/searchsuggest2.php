<?php
error_reporting(0);
session_start();
include 'includes/ConnectDB.inc';
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];

//-------------------------- all Product inventory list---------------------
if (!isset($_SESSION['pro_inventory_array']))
{
 $_SESSION['pro_inventory_array'] = array();
    $reslt = mysql_query("SELECT * FROM inventory WHERE ins_ons_id=$storeID AND ins_ons_type='$scatagory' ORDER BY ins_productname");
    while ($suggest = mysql_fetch_assoc($reslt)){
        $inventID = $suggest['idinventory'];
        $_SESSION['pro_inventory_array'][$inventID] = $suggest;
    }
}
//--------------------------- searches----------------------------------------------
if (isset($_GET['searchs']) && $_GET['searchs'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$search = $_GET['searchs'];
                    $location = $_GET['selltype'];
	foreach ($_SESSION['pro_inventory_array'] as $k => $v) {
                        if (stripos($v['ins_product_code'], $search) !== false) {
                            echo "<a class='prolinks' style='text-decoration:none;color:brown;display:block;' href=".$location."?code=" . $v['idinventory'] . ">".$v['ins_product_code']." ".$v['ins_productname']."</a>";
                        }
                    }
}
if (isset($_GET['code']) && $_GET['code'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$barcode = $_GET['code'];
	foreach ($_SESSION['pro_inventory_array'] as $k => $v) {
                        if (stripos($v['ins_product_code'], $barcode) !== false) {
                            echo $v['idinventory'];
                        }
                    }
}

elseif (isset($_GET['searchKey']) && $_GET['searchKey'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchKey'];
                  $location = $_GET['where'];
	foreach ($_SESSION['pro_inventory_array'] as $k => $v) {
                        if (stripos($v['ins_productname'], $str_key) !== false) {
                            echo "<a class='prolinks' style='text-decoration:none;color:brown;display:block;' href=".$location."?code=" . $v['idinventory'] . ">".$v['ins_productname']."</a>";
                        }
                    }
}
?>