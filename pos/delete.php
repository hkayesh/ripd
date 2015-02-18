<?php
include 'includes/ConnectDB.inc';
if (isset($_GET['id']))
{
    $location =   $_GET['selltype'];
    $dltItem = $_GET['id'];
    unset($_SESSION['arrSellTemp'][$dltItem]);
       header("location: $location");
}
?>