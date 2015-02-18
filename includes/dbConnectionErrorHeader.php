<?php 
error_reporting(0);
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>রিপড ইউনিভার্সাল</title>
            <?php 
            include_once 'headContent_css_js_others.php';
            ?>
    </head>
    <body>

        <div id="main_container">
            <div id="header">
                <div id="logo"></div>
                <div class="banner_adds"></div>
                <div class="banner_sub_adds"></div>
                <div class="menu">
                    <ul>
                        <li><a href="index.php">হোম</a></li>
                        <li><a>কোম্পানি</a>
                            <ul>
                                <li><a href="about_company.php">এবাউট কোম্পানী</a></li>
                                <li><a href="product_info.php" title="">পণ্যের তথ্য</a></li>
                                <li><a href="patent.php" title="">প্যাটেন্ট</a></li>
                                <li><a href="programProfile.php" title="">অনুষ্ঠানসূচি</a></li>
                                <li><a href="awards.php" title="">এওয়ার্ড</a></li>
                            </ul>
                        </li>
                        <li><a href="masterChart.php">মূল পণ্যতালিকা</a></li>
                        <li><a>যোগাযোগ</a>
                            <ul>
                                <li><a href="officeNcontact.php">অফিস এন্ড কন্টাক্ট</a></li>
                                <li><a href="salesStoreAndContact.php" title="">সেলস স্টোর এন্ড কন্টাক্ট</a></li>
                            </ul>
                        </li>
                        <li><a>নোটিশ বোর্ড</a>
                            <ul>
                                <li><a href="program_notice.php">প্রোগ্রাম</a></li>
                                <li><a href="presentation_notice.php" title="">প্রেজেন্টেশন</a></li>
                                <li><a href="training_notice.php" title="">ট্রেইনিং</a></li>
                                <li><a href="travel_notice.php" title="">ট্রাভেল</a></li>
                            </ul>
                        </li>
                        <li><a>ক্যালেন্ডার</a>
                            <ul>
                                <li><a href="office_day_calendar.php">অফিস ক্যালেন্ডার</a></li>
                                <li><a href="salestore_day_calendar.php" title="">শপিং ক্যালেন্ডার</a></li>
                            </ul>
                        </li>
                        <li><a href="makeapplication.php">আবেদনপত্র</a></li>
                        <?php
                        if(isset($_SESSION['UserID']) && isset($_SESSION['acc_holder_name']))
                            {
                            $user_name = $_SESSION['acc_holder_name'];
                            $logged_in_office_name = $_SESSION['loggedInOfficeName'];
                            echo '<li><a href="main_account_management.php">'.$_SESSION['loggedInOfficeName'].'</a></li>';
                            echo '<li><a href="account_management.php">'.$user_name.'</a></li>';                        
                            echo '<li><a href="logout.php">লগ আউট</a></li>';
                            }
                        else
                            {
                            echo '<li><a href="login.php"> লগ ইন </a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </div> 
<div id="main_content">               

