<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
?>

<style type="text/css">
    @import "css/bush.css";
    .formstyle td{
        padding: 5px;
    }
</style>

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="office_sstore_management.php"><b>ফিরে যান</b></a></div>
        <div class="domtab">
            <ul class="domtabs">
                <li class="current"><a href="#01">আউট ফর প্রোডক্ট বাইং</a></li>
                <li class="current"><a href="#02">আউট ফর আদার্স</a></li>
                <li class="current"><a href="#03">চেক ট্রাঞ্জিট পয়েন্ট</a></li>
            </ul>
        </div>   
        <div>
            <h2><a name="01" id="01"></a></h2><br />
            <table  class="formstyle">          
                <tr><th colspan="7" style="text-align: center;">আউট ফর প্রোডক্ট বাইং</th></tr>
                <tr>
                    <td colspan="2">
                        <table style="border: 1px solid #808080">
                            <tr>
                                <td colspan="3" style="text-align: center">এই অফিস এর সকল প্রোডাক্ট এর ক্রয়মুল্য</td>
                            </tr>
                            <tr id="table_row_odd">
                                <td style="width: 10%">ক্রম</td>
                                <td>প্রোডাক্টের নাম</td>
                                <td style="width: 25%">ক্রয়মুল্য</td>
                            </tr> 
                            <tr>
                                <td>১</td>
                                <td>CH-0001-2901</td>
                                <td>ac-12-4302-121</td>
                            </tr>
                            <tr>
                                <td>২</td>
                                <td>CH-0001-2901</td>
                                <td>ac-12-4302-121</td>
                            </tr>
                            <tr>
                                <td>৩</td>
                                <td>CH-0001-2901</td>
                                <td>ac-12-4302-121</td>
                            </tr>
                            <tr>
                                <td>৪</td>
                                <td>CH-0001-2901</td>
                                <td>ac-12-4302-121</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right">নীডেড এমাউন্টঃ </td>
                    <td><input class="box5" type="text" name="needed_amount"/></td>
                </tr>
                <tr>
                    <td style="text-align: right; width: 40%;">সাবজেক্টঃ</td>
                    <td style="padding-left: 0px;"><textarea  name="needed_amount"></textarea></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center"><input type="submit" class="btn" name="submit" value="সেভ">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
        </div>
        <div>
            <h2><a name="02" id="02"></a></h2><br/>
            <table  class="formstyle">          
                <tr><th colspan="7" style="text-align: center;">আউট ফর প্রোডক্ট বাইং</th></tr>
                <tr>
                    <td colspan="2">
                        <table style="border: 1px solid #808080">
                            <tr>
                                <td colspan="3" style="text-align: center">প্রোডাক্টের সফট কস্টিং অফিস ফান্ড</td>
                            </tr>
                            <tr id="table_row_odd">
                                <td style="width: 10%">ক্রম</td>
                                <td>প্রোডাক্টের নাম</td>
                                <td style="width: 25%">এমাউন্ট</td>
                            </tr> 
                            <tr>
                                <td>১</td>
                                <td>CH-0001-2901</td>
                                <td>ac-12-4302-121</td>
                            </tr>
                            <tr>
                                <td>২</td>
                                <td>CH-0001-2901</td>
                                <td>ac-12-4302-121</td>
                            </tr>
                            <tr>
                                <td>৩</td>
                                <td>CH-0001-2901</td>
                                <td>ac-12-4302-121</td>
                            </tr>
                            <tr>
                                <td>৪</td>
                                <td>CH-0001-2901</td>
                                <td>ac-12-4302-121</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right">নীডেড এমাউন্টঃ </td>
                    <td><input class="box5" type="text" name="needed_amount"/></td>
                </tr>
                <tr>
                    <td style="text-align: right; width: 40%;">সাবজেক্টঃ</td>
                    <td style="padding-left: 0px;"><textarea  name="needed_amount"></textarea></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center"><input type="submit" class="btn" name="submit" value="সেভ">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
        </div>    
        <div>
            <h2><a name="03" id="03"></a></h2><br/>
            <table  class="formstyle">          
                <tr>
                    <th colspan="8" style="text-align: center;">চেক ট্রাঞ্জিট পয়েন্ট</th>
                </tr>
                <tr id="table_row_odd">
                    <td style="width: 10%">ক্রম</td>
                    <td style="width: 10%">তারিখ</td>
                    <td >চেক বিষয়ক তথ্য</td>
                </tr>
                <tr>
                    <td>১</td>
                    <td>CH-0001-2901</td>
                    <td>ac-12-4302-121</td>
                </tr>
                <tr>
                    <td>২</td>
                    <td>CH-0001-2901</td>
                    <td>ac-12-4302-121</td>
                </tr>
                <tr>
                    <td>৩</td>
                    <td>CH-0001-2901</td>
                    <td>ac-12-4302-121</td>
                </tr>
                <tr>
                    <td>৪</td>
                    <td>CH-0001-2901</td>
                    <td>ac-12-4302-121</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php
include_once 'includes/footer.php';
?>