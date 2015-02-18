<?php
if(isset($_GET['mobile']))
{
    $value = $_GET['mobile'];
    if (preg_match("/^01(6|5|7|9|1|8)\d{8}$/", $value)) {
        echo "";
    }
 else {
     echo "<br /><font color='red'>দুঃখিত, আপনি ভুল মোবাইল নং দিয়েছেন</font>";
    }
}
?>
