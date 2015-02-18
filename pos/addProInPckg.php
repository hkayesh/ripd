<?php
//error_reporting(0);
session_start();
if (!isset($_SESSION['arrProductTemp']))
{
 $_SESSION['arrProductTemp'] = array();
}
if(isset($_GET['name']))
{
     $prochartid=$_GET['chartID'];
     $procode=$_GET['code'];
     $proname=$_GET['name'];
     $QTY=$_GET['totalQty'];
     $arr_temp = array($procode, $proname, $QTY);
     $_SESSION['arrProductTemp'][$prochartid] = $arr_temp;
}
elseif (isset ($_GET['type'])) {
    $g_id = $_GET['chartID'];
    unset($_SESSION['arrProductTemp'][$g_id]);
}
?>