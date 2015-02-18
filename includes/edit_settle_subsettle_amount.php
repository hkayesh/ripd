<?php
error_reporting(0);
include_once 'ConnectDB.inc';
//echo"<pre>";
//print_r($_POST);
//echo"</pre>";
    $db_ssearn_amount = $_POST['ssearn_amount'];
    $db_ssearn_id = $_POST['ssearn_id'];    
    //echo "db_charge_criteria_value ".$db_charge_criteria_value. " db_charge_criteria_id= ".$db_charge_criteria_id;
    
if(isset($_POST['edit'])){
    $edit_ssearn_amount= "UPDATE settle_subsettle_earn SET earn_amount='$db_ssearn_amount', update_date=NOW() WHERE idsettlesubsettleearn='$db_ssearn_id'";
    if(mysql_query($edit_ssearn_amount)){
        //echo "I am successful Edit" ;
           header("location: ../settle_subsettle_earn.php?editmsg=2&editflag=2");
    }
}elseif(isset ($_POST['postpond'])){    
    //$db_charge_criteria_id = $_POST['charge_criteria_id'];
    $postpond_ssearn_amount= "UPDATE settle_subsettle_earn SET  earn_status='postpond', update_date=NOW() WHERE idsettlesubsettleearn='$db_ssearn_id'";
    if(mysql_query($postpond_ssearn_amount)){
            header("location: ../settle_subsettle_earn.php?editmsg=3&editflag=2");
    }
}
    elseif(isset ($_POST['restart'])){
    //$db_charge_criteria_id = $_POST['charge_criteria_id'];
    $restart_ssearn_amount= "UPDATE settle_subsettle_earn SET  earn_status='active', update_date=NOW() WHERE idsettlesubsettleearn='$db_ssearn_id'";
    if(mysql_query($restart_ssearn_amount)){
        //echo "I am successful restart" ;
            header("location: ../settle_subsettle_earn.php?editmsg=4&editflag=2");
    }
    }
?>
