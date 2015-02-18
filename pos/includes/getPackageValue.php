<?php
error_reporting(0);
include_once 'ConnectDB.inc';
if($_GET['type'] == 1)
{
    $g_pckgID = $_GET['pckgID'];
    $sel_running_command = mysql_query("SELECT * FROM running_command");
    $pvrow = mysql_fetch_assoc($sel_running_command);
    $db_current_pv = $pvrow['pv_value'];
   $sel_account_type = mysql_query("SELECT * FROM account_type WHERE idAccount_type= '$g_pckgID'");
   $accountrow = mysql_fetch_assoc($sel_account_type);
   $db_accountPV = $accountrow['account_minPV_value'];
   $total_taka = $db_accountPV / $db_current_pv ;
   echo  round($total_taka, 2);
}
elseif($_GET['type']==2)
{
    $g_acNo = $_GET['acNo'];
    $sel_customer = mysql_query("SELECT * FROM cfs_user WHERE account_number = '$g_acNo' AND user_type = 'customer' AND cfs_account_status='active' ");
    $custrow = mysql_fetch_assoc($sel_customer);
    $no_of_rows = mysql_num_rows($sel_customer);
    if($no_of_rows > 0)
    {
        echo $custrow['account_name'];
    }
    else
    {
        echo "দুঃখিত, ভুল অ্যাকাউন্ট নাম্বার";
    }
}
?>
