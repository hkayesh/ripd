<?php
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
?>
<style type="text/css">@import "css/bush.css";</style>
<link type="text/css" rel="stylesheet" href="css/tinybox.css">
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
 function accGenerate()
	{ TINY.box.show({iframe:'pos/accountGenerator.php',width:1100,height:600,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
 </script> 
<div class="columnSubmodule" style="font-size: 14px;">
    <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;"> 
        <tr>
            <th colspan="2">নিজ একাউন্ট ম্যানেজমেন্ট</th>
        </tr>
        <tr>
            <td><a href="convert_package_customer.php">কনভার্ট ওউন একাউন্ট প্যাকেজ</a></td>
            <td><a href="use_pin.php">পিন নং ব্যবহার</a></td>
        </tr> 
        <tr>
            <th colspan="2">নতুন একাউন্ট তৈরি</th>
        </tr>
        <tr>
            <td><a href="create_customer_account.php">নতুন কাস্টমার একাউন্ট তৈরি</a></td>
            <td><a onclick="accGenerate();" style="cursor: pointer;color: #03C;"><u>নতুন এগ্রিমেন্ট একাউন্ট তৈরি</u></a></td>
        </tr>
    </table>
</div>
<?php
include_once 'includes/footer.php';
?>