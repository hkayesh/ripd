<?php
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';

$logedInUserType = $_SESSION['userType'];
?>
<style type="text/css">@import "css/bush.css";</style>
<div class="columnSubmodule" style="font-size: 14px;">
    <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;"> 
        <tr>
            <th colspan="2">পণ্য ক্রয় সংক্রান্ত রিপোর্ট</th>
        </tr>
        <tr>
            <td><a href="personal_purchase_statement.php">ব্যক্তিগত ক্রয় স্টেটমেন্ট</a></td>
            <td><a href="own_replace_statement.php">পণ্য রিপ্লেসের তালিকা</a></td>
        </tr>
        <tr>
            <td><a href="in_amount_description.php">ইন ডেসক্রিপশন</a></td>
            <td><a href="personal_balanced_description.php">ব্যালেন্সড ডেসক্রিপশন</a></td>
        </tr>
        <tr>
            <th colspan="2">পেমেন্ট সংক্রান্ত রিপোর্ট</th>
        </tr>
        <tr>
            <td><a href="withdrawal_statement.php">টাকা উত্তোলনের স্টেটমেন্ট</a></td>
            <td><a href="transfer_statement.php">ট্রান্সফার এমাউন্ট স্টেটমেন্ট</a></td>
        </tr>
        <tr>
            <td><a href="payment_statement_chart.php">টাকা পাঠানোর স্টেটমেন্ট</a></td>
        </tr>
        <tr>
            <th colspan="2">আর্ন সংক্রান্ত রিপোর্ট</th>
        </tr>
        <tr>
            <td><a href="cash_in_statement.php">ক্যাশ ইন স্টেটমেন্ট</a></td>
            <td><a href="transfer_in_statement.php">ট্রান্সফার এমাউন্ট স্টেটমেন্ট</a></td>
        </tr>
        <?php 
        if($logedInUserType=='customer'){
        ?>
        <tr>
            <td><a href="systemic_earn_system.php">পিভি আর্ন স্টেটমেন্ট</a></td>
        </tr>
        <?php 
        }
        if($logedInUserType=='customer'){
        ?>
        <tr>
            <th colspan="2">সেলিং স্টেটমেন্ট</th>
        </tr>
        <tr>
            <td colspan="2"><a href="total_buying_description_with_referer_pv.php">টোটাল সেলিং ডেসক্রিপশন উইথ রেফারার পি.ভি</a></td>
        </tr>
        <?php        
        }
        ?>
    </table>
</div>
<?php
include_once 'includes/footer.php';
?>