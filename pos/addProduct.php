<?php
//error_reporting(0);
include './includes/connectionPDO.php';
include './includes/ConnectDB.inc';
$sqlpv = mysql_query("SELECT * FROM running_command;");
$row = mysql_fetch_assoc($sqlpv);
$pvinvalue= $row['pv_value'];

$sql = "INSERT INTO product_temp(store_type ,store_id ,pro_code ,pro_name ,buying_price ,selling_price , profit ,xtra_profit, pv, qty, product_chart_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

 $unitpv = $pvinvalue / 100;
    $G_s_type = $_SESSION['loggedInOfficeType'];
    $G_s_id= $_SESSION['loggedInOfficeID'];
    
    $P_procode=$_POST['pcode'];    
    $P_pname=$_POST['pname'];
     $P_QTY=$_POST['QTY'];
     $P_buyprice=$_POST['buyPrice'];
     $P_sellprice=$_POST['sellPrice'];
     $P_productid=$_POST['proChartID'];
     $P_xtraprofit=$_POST['xtraprofit'];
     $profit = $P_sellprice - ($P_buyprice+$P_xtraprofit);
    $pv = $profit * $unitpv;
$stmt->execute(array($G_s_type,$G_s_id,$P_procode,$P_pname, $P_buyprice, $P_sellprice,  $profit, $P_xtraprofit, $pv, $P_QTY, $P_productid));
header("location: productIN.php");

?>
