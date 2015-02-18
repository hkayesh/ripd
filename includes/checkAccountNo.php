<?php
error_reporting(0);
session_start();
include_once 'ConnectDB.inc';
include_once 'connectionPDO.php';
include_once 'makeAccountNumbers.php';
function checkAccountNo($accNo)
{
    $forWhileLoop = 1;
    while($forWhileLoop == 1)
    {
        $cfs_query = mysql_query("SELECT * FROM cfs_user WHERE account_number= '$accNo'");
        $y = mysql_num_rows($cfs_query);
        if($y > 0)
        {
           $accNo = getPersonalAccount();
        }
         else {
             $forWhileLoop = 0;
             break;
         }
     }
     return $accNo;
}
function checkAccountNo2($accNo,$type)
{
    if($type =='rp' || $type== 'hp' || $type=='pw')
    {
        $forWhileLoop = 1;
        while($forWhileLoop == 1)
        {
            $cfs_query = mysql_query("SELECT * FROM office WHERE account_number= '$accNo'");
            $y = mysql_num_rows($cfs_query);
            if($y > 0)
            {
                switch ($type) {
                    case 'rp':
                        $accNo = getRoAccount() ;
                        break;

                    case 'hp':
                        $accNo = getHpwAccount() ;
                        break;
                    case 'pw':
                        $accNo = getPwAccount();
                        break;
                }
            }
             else {
                 $forWhileLoop = 0;
                 break;
             }
         }
    }
    elseif($type == 'sl')
    {
            $forWhileLoop = 1;
        while($forWhileLoop == 1)
        {
            $cfs_query = mysql_query("SELECT * FROM sales_store WHERE account_number= '$accNo'");
            $y = mysql_num_rows($cfs_query);
            if($y > 0)
            {
               $accNo = getSalesAccount();
            }
             else {
                 $forWhileLoop = 0;
                 break;
             }
         }
    }
         return $accNo;
}
?>
