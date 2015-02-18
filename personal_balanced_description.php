<?php
error_reporting(0);
include_once 'includes/header.php';
?>
<title>ব্যাল্যান্সড ডেসক্রিপশন</title>
<link rel="stylesheet" type="text/css" media="all" href="css/bush.css" />
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="personal_reporting.php"><b>ফিরে যান</b></a></div>  
        <div class="domtab">
            <ul class="domtabs">
                <li class="current"><a href="#01">ইন এমাউন্ট</a></li><li class="current"><a href="#02">আউট এমাউন্ট</a></li>
            </ul>
        </div>

            <div>
            <h2><a name="01" id="01"></a></h2><br/>	
                <table  class="formstyle">     
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>ইন এমাউন্ট</h1></th></tr>
                <tr>
                    <td style="text-align: right; width: 40%;">মাধ্যম</td>
                    <td style="text-align: left; width: 60%;">: <select class="box">
                            <option>-সিলেক্ট করুন-</option>
                            <option>পিভি</option>
                            <option>চেক ইন</option>
                            <option>ট্রান্সফার এমাউন্ট</option>
                        </select></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php
                            echo "<table border='1' cellpadding='0' cellspacing='0'>
                                        <tr id='table_row_odd'>
                                            <td style='border:1px black solid;'>ক্রম</td>
                                            <td style='border:1px black solid;'>তারিখ</td>
                                            <td style='border:1px black solid;'>এমাউন্ট</td>
                                            <td style='border:1px black solid;'>মাধ্যম</td>
                                            <td style='border:1px black solid;'>ট্যাক্স / চার্জ</td>
                                        </tr>";
                            for($i=0;$i<5;$i++)
                            {
                                echo "<tr>
                                    <td style='border:1px black solid;'> </br></td>
                                            <td style='border:1px black solid;'> </br></td>
                                            <td style='border:1px black solid;'> </br></td>
                                            <td style='border:1px black solid;'> </br></td>
                                            <td style='border:1px black solid;'> </br></td>
                                    </tr>";
                            }
                            echo "</table>";
                        ?>
                    </td>
                </tr>
<!--                <tr>
                    <td >
                        <table border='1' cellpadding='0' cellspacing='0'>
                            <tr id='table_row_odd'>
                                <td style='border:1px black solid;'>তারিখ</td>
                                <td style='border:1px black solid;'>বেতনিক মাসের নাম</td>
                                <td style='border:1px black solid;'>এমাউন্ট</td>
                                <td style='border:1px black solid;'>ট্রান্সফারারের একাউন্ট নাম্বার</td>
                                <td style='border:1px black solid;'>পরিমাণ</td>
                                <td style='border:1px black solid;'>পার্সনাল ইন নাম্বার</td>
                                <td style='border:1px black solid;'>পরিমাণ</td>
                                <td style='border:1px black solid;'>পারচেইজিং আর্ন</td>
                                <td style='border:1px black solid;'>বেতন এমাউন্ট</td>
                                <td style='border:1px black solid;'>পরিমাণ</td>
                            </tr>
                            <tr>
                                <td style='border:1px black solid;'>11111</td>
                                <td style='border:1px black solid;'>11111111</td>
                                <td style='border:1px black solid;'>11111111</td>
                                <td style='border:1px black solid;'>22222222</td>
                                <td style='border:1px black solid;'>3333333</td>
                                <td style='border:1px black solid;'>44444444</td>
                                <td style='border:1px black solid;'>555555</td>
                                <td style='border:1px black solid;'>2222222</td>
                                <td style='border:1px black solid;'>4444444</td>
                                <td style='border:1px black solid;'>4444444</td>
                            </tr>
                        </table>
                    </td>
                </tr>-->
            </table>
        </div>

        <div>
            <h2><a name="02" id="02"></a></h2><br/>	
                <table  class="formstyle">     
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>আউট এমাউন্ট</h1></th></tr>
                <tr>
                    <td style="text-align: right; width: 40%;">মাধ্যম</td>
                    <td style="text-align: left; width: 60%;">: <select class="box">
                            <option>-সিলেক্ট করুন-</option>
                            <option>পিভি</option>
                            <option>চেক ইন</option>
                            <option>ট্রান্সফার এমাউন্ট</option>
                        </select></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php
                            echo "<table border='1' cellpadding='0' cellspacing='0'>
                                        <tr id='table_row_odd'>
                                            <td style='border:1px black solid;'>ক্রম</td>
                                            <td style='border:1px black solid;'>তারিখ</td>
                                            <td style='border:1px black solid;'>পে আউট মাধ্যম</td>
                                            <td style='border:1px black solid;'>ট্যাক্স / চার্জ</td>
                                            <td style='border:1px black solid;'>এমাউন্ট</td>
                                        </tr>";
                            for($i=0;$i<5;$i++)
                            {
                                echo "<tr>
                                    <td style='border:1px black solid;'> </br></td>
                                            <td style='border:1px black solid;'> </br></td>
                                            <td style='border:1px black solid;'> </br></td>
                                            <td style='border:1px black solid;'> </br></td>
                                            <td style='border:1px black solid;'> </br></td>
                                    </tr>";
                            }
                            echo "</table>";
                        ?>
                    </td>
                </tr>
<!--                <tr>
                    <td >
                        <table border='1' cellpadding='0' cellspacing='0'>
                            <tr id='table_row_odd'>
                                <td style='border:1px black solid;'>তারিখ</td>
                                <td style='border:1px black solid;'>চেক নাম্বার</td>
                                <td style='border:1px black solid;'>এমাউন্ট</td>
                                <td style='border:1px black solid;'>ট্রান্সফারকৃতএকাউন্ট নাম্বার</td>
                                <td style='border:1px black solid;'>এমাউন্ট</td>
                                <td style='border:1px black solid;'>সেন্ডের পিন নাম্বার</td>
                                <td style='border:1px black solid;'>এমাউন্ট</td>
                                <td style='border:1px black solid;'>মোট এমাউন্ট</td>
                            </tr>
                            <tr>
                                <td style='border:1px black solid;'>11111</td>
                                <td style='border:1px black solid;'>11111111</td>
                                <td style='border:1px black solid;'>11111111</td>
                                <td style='border:1px black solid;'>22222222</td>
                                <td style='border:1px black solid;'>3333333</td>
                                <td style='border:1px black solid;'>44444444</td>
                                <td style='border:1px black solid;'>555555</td>
                                <td style='border:1px black solid;'>2222222</td>
                            </tr>
                        </table>
                    </td>
                </tr>-->
            </table>
        </div>

    </div>
</div>         
<?php include_once 'includes/footer.php'; ?>