<?php
error_reporting(0);
session_start();
include_once './includes/connectionPDO.php';
$sel_sales_summary = $conn->prepare("SELECT * FROM `sales_summary` WHERE sal_invoiceno=? ");

$G_sellingType = $_GET['selltype'];
$str_recipt= "RIPD";
$forwhileloop = 1;
while($forwhileloop==1)
{
    for($i=0;$i<3;$i++)
        {
            $str_random_no=(string)mt_rand (0 ,9999 );
            $str_recipt_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
            $str_recipt =$str_recipt."-".$str_recipt_random;
        }
        $sel_sales_summary->execute(array($str_recipt));
       $result= $sel_sales_summary->fetchAll();
        if (count($result)<1)
        {
            $forwhileloop = 0;
            break;
        }
}   
$_SESSION['SESS_MEMBER_ID']=$str_recipt;

if($G_sellingType==1) // for general selling ****************************
{
    header("location: auto.php");
}
elseif($G_sellingType==2) // for wholeselling ***********************************
{
    header("location: wholesale.php");
}
elseif($G_sellingType==3) // sell after replace ******************************************
{
            header("location: sellAfterReplace.php");
}
?>