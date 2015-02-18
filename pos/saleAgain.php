<?php
error_reporting(0);
session_start();
if($_GET['selltype']==1)
{
    unset($_SESSION['arrSellTemp']);
    unset($_SESSION['SESS_MEMBER_ID']);
    unset($_SESSION['pro_inventory_array']);
    header("location: newSale.php?selltype=1");
}
//for wholesale....................................................
elseif($_GET['selltype']==2)
{
    unset($_SESSION['arrSellTemp']);
    unset($_SESSION['SESS_MEMBER_ID']);
    unset($_SESSION['pro_inventory_array']);
    header("location: newSale.php?selltype=2");
}
//for sell after replace....................................................
elseif($_GET['selltype']==3)
{
    unset($_SESSION['repMoney']);
    unset($_SESSION['arrSellTemp']);
    unset($_SESSION['SESS_MEMBER_ID']);
    unset($_SESSION['recipt']);
    unset($_SESSION['pro_inventory_array']);
    header("location: newSale.php?selltype=1");
}
?>