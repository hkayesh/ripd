<?php
$logedInUserType = $_SESSION['userType'];
if($logedInUserType == 'customer') $view_link = "view_customer_account.php";
elseif ($logedInUserType == 'owner') $view_link = "view_proprietor_account.php";
else $view_link = "view_employee_account.php"; 
?>
<div class="column1">
    <div class="left_box">
        <div class="top_left_box"></div>
        <div class="center_left_box">
            <div class="box_title"><span>প্রোফাইল</span> ম্যানেজমেন্ট</div>
            <div class="navbox">
                <ul class="nav">
                    <li><a href="personal_notifications.php">নোটিফিকেশন</a></li>
                    <?php 
                    if($logedInUserType == 'customer') {                        
                        echo '<li><a href="personal_reporting.php">রিপোর্টিং</a></li>';
                        echo '<li><a href="personal_accounting_balance.php">একাউন্টিং (ব্যালেন্স)</a></li>';
                        echo '<li><a href="tree_view.php">ট্রি দেখুন</a></li>';
                        echo '<li><a href="profile_account_management.php">একাউন্ট ম্যানেজমেন্ট</a></li>';
                    }elseif ($logedInUserType == 'employee' || $logedInUserType=='presenter' || $logedInUserType=='trainer' || $logedInUserType=='programmer') {                                                
                        echo '<li><a href="personal_reporting.php">রিপোর্টিং</a></li>';
                        echo '<li><a href="personal_accounting_balance.php">একাউন্টিং (ব্যালেন্স)</a></li>';
                        echo '<li><a href="personal_official_profile_employee.php">অফিস সংক্রান্ত</a></li>';
                    }?>
                    <li><a href="online_ticket_buying.php">অনলাইনে টিকেট কেনা</a></li>
                    <li><a href="<?php echo $view_link;?>">ভিউ একাউন্ট</a></li>
                    <li><a href="password_change.php">পাসওয়ার্ড পরিবর্তন</a></li>
                    <li><a href="message_submodule.php">ক্ষুদে বার্তা</a></li>
                    <li><a href="https://webmail.ripduniversal.com" target="_blank">ই-মেইল</a></li>
                </ul>
            </div>
        </div>
        <div class="bottom_left_box">
        </div>
    </div> 

</div>
