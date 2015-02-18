<?php
error_reporting(0);
session_start();
include 'includes/ConnectDB.inc';
//-------------------------- all Product chart list---------------------
if (!isset($_SESSION['pro_chart_array']))
{
 $_SESSION['pro_chart_array'] = array();
    $reslt = mysql_query("SELECT idproductchart, pro_code, pro_productname FROM product_chart ORDER BY pro_code");
    while ($suggest = mysql_fetch_assoc($reslt)){
        $_SESSION['pro_chart_array'][] = $suggest;
    }
}
if (isset($_GET['searchcode']) && $_GET['searchcode'] != '') {
	$str_key = $_GET['searchcode'];
                  $location = $_GET['where'];
                    foreach ($_SESSION['pro_chart_array'] as $k => $v) {
                        if (stripos($v['pro_code'], $str_key) !== false) {
                            echo "<a class='prolinks' style='text-decoration:none;color:brown;display:block;' href=".$location."?code=" . $v['idproductchart'] . ">" . $v['pro_code']." ".$v['pro_productname']."</a>";
                        }
                    }
}

if (isset($_GET['searchname']) && $_GET['searchname'] != '') {
	$str_key = $_GET['searchname'];
                  $location = $_GET['where'];
	foreach ($_SESSION['pro_chart_array'] as $k => $v) {
                        if (stripos($v['pro_productname'], $str_key) !== false) {
	            echo "<a class='prolinks' style='text-decoration:none;color:brown;display:block;' href=".$location."?code=" . $v['idproductchart'] . ">" . $v['pro_productname'] . "</a>";
                        }
                }
}
?>