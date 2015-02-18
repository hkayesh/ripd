<?php
error_reporting(0);
include_once './connectionPDO.php';
$ons_id = $_SESSION['loggedInOfficeID'];
$ons_type = $_SESSION['loggedInOfficeType'];
if($_GET['type'] == 1)
{
    $g_fundCode = $_GET['fundCode'];
    $sel_internal_fund = $conn->prepare("SELECT * FROM acc_store_logc WHERE ons_type = ? AND ons_id=?");
    $sel_internal_fund->execute(array($ons_type,$ons_id));
    $row = $sel_internal_fund->fetchAll();
    foreach ($row as $value) {
        echo $value[$g_fundCode];
    }
}

?>