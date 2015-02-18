<?php
error_reporting(0);
session_start();
//include_once 'ConnectDB.inc';

if(isset($_SESSION['UserID']) && isset($_SESSION['acc_holder_name'])){
    $current_page_name = basename($_SERVER["SCRIPT_NAME"]);
    //$current_page_name = 'create_off_sstore_menu.php';
    //echo "current Page: ".$current_page_name."<br/>";
    if(in_array($current_page_name, $_SESSION['pagesArray'])){
        //echo "I got it..............";
    }else{
    $noAccess = "accessdenied";
    header('Location: access_denied.php?msgNoAccess='.$noAccess.'');
    exit();
    }                     
    
}else{
    $loginRequired = "loginNeed";
    //header('Location: login.php?msgLogin=$messgeNotLogin');
    header('Location: login.php?needLoging='.$loginRequired.'');
    exit();
}
?>