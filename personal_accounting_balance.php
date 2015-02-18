<?php
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
?>
<style type="text/css">
    @import "css/bush.css";
</style>
<div class="columnSubmodule" style="font-size: 14px;">
    <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;"> 
        <tr>
            <th colspan="2">টাকা পাঠানোর সিস্টেম</th>
        </tr>
        <tr>
            <td><a href="send_amount.php">টাকা পাঠানো</a></td>
            <td><a href="amount_transfer.php">টাকা ট্রান্সফার করা</a></td>
        </tr>
        <tr>
            <th colspan="2">টাকা উঠানোর সিস্টেম</th>
        </tr>
        <tr>
            <td colspan="2"><a href="make_personal_payout_cheque.php">চেক মেইকিং ফর আউট</a></td>
        </tr>
    </table>
</div>
<?php
include_once 'includes/footer.php';
?>