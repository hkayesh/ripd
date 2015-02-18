<?php
include 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$mainChequeNo= $_GET['maincheque'];
$officeID = $_GET['id'];
?>
<style type="text/css"> @import "css/bush.css";</style>
<link href="css/print.css" rel="stylesheet" type="text/css" media="print"/>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 110px;" id="noprint"><a href="cheque_making_for_in.php"><b>ফিরে যান</b></a></div>
        <div>           
           <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;">চেক মেইকিং ফর ইন</th></tr>
                    <tr>
                        <td>
                            <div id="cheque" style="width: 574px; height: 310px; border: blue solid 2px; margin: 0 auto; background-color:ghostwhite;">
                                <div style="width: 558px;height: 70px;float: left;padding-left: 15px; background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 70px;"></div>
                                         <div id="cheque_body" style=" width: 570px;float: left;padding-left: 2px;">
                                           <div style="width: 570px;float: left;">
                                           <div id="cheque_dateTime" style="text-align:left; width: 210px;float: left">তারিখঃ <?php echo date("d.m.y");?>&nbsp;&nbsp;&nbsp;&nbsp;সময়ঃ <?php print  date('g:i a' , strtotime('+4 hour')) ?></div>
                                           <div id="cheque_no" style="text-align: right;width: 360px;float: left;">চেক নাম্বার : <input type="text" readonly="" value="<?php echo $mainChequeNo;?>" /></br></br></div>
                                           </div></br></br>
                                           <div style="text-align: right;"><span>টাকার পরিমাণ : <input type="text" readonly="" style="width:200px;" value="<?php echo $P_totalTaka;?>" />TK</span></div>
                                           <div id="amount_in_words"><span>টাকার পরিমাণ (কথায়) :</span><?php echo $totalTaka_inWords;?> Taka only.</div></br>
                                           <div><span>অ্যাকাউন্টধারীর অ্যাকাউন্ট নং  : </span><input type="text" readonly width="400px" /></div></br>
                                           <div style="float: right;text-align: right;"><input type="text" readonly width="200px" /><hr style="width:230px; height: 2px; background-color: black;"/> এখানে স্বাক্ষর করুন&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                    </div>
                            </div>
                        </td>
                    </tr>
           </table>
        </div>
    </div>
</div>
    <?php
    include 'includes/footer.php';
    ?>