<?php
session_start();
include_once './connectionPDO.php';
$ons_id =  $_SESSION['loggedInOfficeID'];
$ons_type =  $_SESSION['loggedInOfficeType'];

if (!isset($_SESSION['arrProductTemp']))
{
 $_SESSION['arrProductTemp'] = array();
}
if(isset($_GET['name']))
{
    $g_chartID = $_GET['chartID'];
    $g_name = $_GET['name'];
    $g_code = $_GET['code'];
    $g_qty = $_GET['totalQty'];
    $g_total = $_GET['amount'];
    $tkPerQty = round(($g_total / $g_qty),2);
    $arr_temp = array($g_name,$g_code,$g_qty,$g_total,$tkPerQty);
    $_SESSION['arrProductTemp'][$g_chartID] = $arr_temp;
}

elseif (isset ($_GET['type'])) {
    $g_id = $_GET['chartID'];
    unset($_SESSION['arrProductTemp'][$g_id]);
}

elseif(isset($_GET['check']))
{
    $g_amount = $_GET['reuseamount'];
    $sel_acc_store_logc = $conn->prepare("SELECT ACM FROM acc_store_logc WHERE ons_type = ?  AND ons_id =?");
    $sel_acc_store_logc->execute(array($ons_type, $ons_id));
    $row = $sel_acc_store_logc->fetchAll();
    foreach ($row as $value) {
        $db_amount = $value['ACM'];
    }
    if($g_amount > $db_amount)
    {
        echo '0';
    }
    else
    {
        echo '1';
    }
}
?>
