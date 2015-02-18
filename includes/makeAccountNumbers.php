<?php 
include_once 'ConnectDB.inc';
function rendomgenerator() // 4 digit + 4 digit random no generator*******************************
{
    $str_random_part=""; 
    for($i=0;$i<2;$i++)
        {
            $str_random_no=(string)mt_rand (0 ,999 );
            $str_random= str_pad($str_random_no,3, "0", STR_PAD_LEFT);
            $str_random_part = $str_random_part."-".$str_random;
        }
        $str_random_no2=(string)mt_rand (0 ,9999 );
        $str_random2 = str_pad($str_random_no2,4, "0", STR_PAD_LEFT);
        $str_random_part = $str_random_part."-".$str_random2;
        return $str_random_part;
}

function getHpwAccount() // for head powerstore account number generate****************************************
{
    $str_acc= "hp";
    $forwhileloop = 1;
    while($forwhileloop==1)
    {
            $randompart = rendomgenerator();
            $str_acc = $str_acc.$randompart;
           $result= mysql_query("SELECT * FROM `office` WHERE account_number='$str_acc' AND office_type= 'pwr_head';");
            if (mysql_fetch_array($result)=="" )
            {
                $forwhileloop = 0;
                break;
            }
    }
    return $str_acc;
}

function getRoAccount() // for ripd office account number generate****************************************
{
    $str_acc= "rp";
    $forwhileloop = 1;
    while($forwhileloop==1)
    {
            $randompart = rendomgenerator();
            $str_acc = $str_acc.$randompart;
           $result= mysql_query("SELECT * FROM `office` WHERE account_number='$str_acc' AND office_selection= 'ripd';");
            if (mysql_fetch_array($result)=="" )
            {
                $forwhileloop = 0;
                break;
            }
    }
    return $str_acc;
}

function getPwAccount() // for power store account number generate****************************************
{
    $str_acc= "pw";
    $forwhileloop = 1;
    while($forwhileloop==1)
    {
            $randompart = rendomgenerator();
            $str_acc = $str_acc.$randompart;
           $result= mysql_query("SELECT * FROM `office` WHERE account_number='$str_acc' AND office_selection= 'pwr';");
            if (mysql_fetch_array($result)=="" )
            {
                $forwhileloop = 0;
                break;
            }
    }
    return $str_acc;
}

function getSalesAccount() // for sales store account number generate****************************************
{
    $str_acc= "sl";
    $forwhileloop = 1;
    while($forwhileloop==1)
    {
            $randompart = rendomgenerator();
            $str_acc = $str_acc.$randompart;
           $result= mysql_query("SELECT * FROM `sales_store` WHERE account_number='$str_acc';");
            if (mysql_fetch_array($result)=="" )
            {
                $forwhileloop = 0;
                break;
            }
    }
    return $str_acc;
}

function getPersonalAccount() // for employee, customers account number generate****************************************
{
    $str_acc= "ac";
    $forwhileloop = 1;
    while($forwhileloop==1)
    {
            $randompart = rendomgenerator();
            $str_acc = $str_acc.$randompart;
           $result= mysql_query("SELECT * FROM `cfs_user` WHERE account_number='$str_acc';");
            if (mysql_fetch_array($result)=="" )
            {
                $forwhileloop = 0;
                break;
            }
    }
    return $str_acc;
}
?>
