<?php
error_reporting(0);
include 'includes/ConnectDB.inc';
$cfsID = $_SESSION['userIDUser'];

$check=1;
    while($check==1)
    {
        $str_pin= "pin";
        for($i=0;$i<3;$i++)
            {
                $str_random_no=(string)mt_rand (0 ,9999 );
                $str_pin_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
                $str_pin =$str_pin."-".$str_pin_random;
            }
        $result = mysql_query("SELECT * FROM pin_makingused where pin_no= '$str_pin'");
        if(mysql_num_rows($result) == 0)
        {
            $insreslt = mysql_query( "INSERT INTO pin_makingused (pin_no ,pin_state, pin_making_date, pin_madeby_cfsuserid) 
                                                    VALUES ('$str_pin', 'open', CURDATE(), $cfsID)");
            $check = 2;
        }
    }
    echo $str_pin;
?>
