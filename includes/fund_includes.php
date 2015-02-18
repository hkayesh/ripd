<?php
include_once './connectionPDO.php';
if($_GET['type'] == 1)
{
    $g_fundID = $_GET['fundID'];
    $sel_main_fund = $conn->prepare("SELECT fund_amount FROM main_fund WHERE idmainfund = ?");
    $sel_main_fund->execute(array($g_fundID));
    $row = $sel_main_fund->fetchAll();
    foreach ($row as $value) {
        echo $value['fund_amount'];
    }
}
elseif($_GET['type'] == 2)
{
    if (!isset($_SESSION['arrFunds']))
    {
     $_SESSION['arrFunds'] = array();
     $_SESSION['arrCashinInfo'] = array();
    }
    
    $g_fundID = $_GET['fundID'];
    $sel_main_fund = $conn->prepare("SELECT * FROM main_fund WHERE idmainfund = ?");
    $sel_main_fund->execute(array($g_fundID));
    $row = $sel_main_fund->fetchAll();
    foreach ($row as $value) {
        $db_fundname = $value['fund_name'];
        $db_amount = $value['fund_amount'];
        $arr_temp = array($db_fundname,$db_amount);
        $_SESSION['arrFunds'][$g_fundID] = $arr_temp;
    }
    $g_office_acc = $_GET['offAcc'];
    $g_office_name = $_GET['offname'];
    $g_amount = $_GET['totalAmount'];
    $arr_temp1 = array($g_office_acc,$g_amount,$g_office_name);
    $_SESSION['arrCashinInfo'][0] = $arr_temp1;
}
elseif (isset($_GET['delete'])) {
    $g_id = $_GET['id'];
    $g_url = urldecode($_GET['url']);
    unset($_SESSION['arrFunds'][$g_id]);
    header("location: $g_url");
}

elseif ($_GET['type'] == 'loan') {
    $g_code = $_GET['fundcode'];
    $g_need = $_GET['needamount'];
    $sel_main_fund = $conn->prepare("SELECT fund_amount FROM main_fund WHERE fund_code = ?");
    $sel_main_fund->execute(array($g_code));
    $row = $sel_main_fund->fetchAll();
    foreach ($row as $value) {
        $fundamount = $value['fund_amount'];
    }
    if($g_need > $fundamount)
    {
        echo "দুঃখিত,এই পরিমান টাকা দেয়া যাবে না";
    }
    else{ echo ""; }
}
?>
