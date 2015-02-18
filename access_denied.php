<?php
/*
 * This page will be used for showing no access message to the user
 */
error_reporting(0);
include_once 'includes/header.php';
?>
<style type="text/css">
    @import "css/domtab.css";
</style>
<div class="columnSld" style="height: 150px; ">
    <div style="width: 80%; text-align: center; margin-left: 10%; background-color: #FC7891; color: #222222; font-size: 16px; border: 1px solid #212121">
        <img src="images/Warning.png" height="30px" width="30px" style="vertical-align: bottom; margin-right: 10px;">
        <?php 
        $getMessage = $_GET['msgNoAccess'];
        $messageNoAccess = "দুঃখিত, আপনার এই পেজ দেখার অনুমতি নাই";
        echo $messageNoAccess;
        ?>
    </div>
</div>
<?php
include_once 'includes/footer.php';
?>