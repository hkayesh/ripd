<?php
error_reporting(0);
session_start();
include_once './MiscFunctions.php';
$accountnumber = $_SESSION['personalAccNo'];
$accountname = $_SESSION['acc_holder_name'];
$g_amount = $_GET['amount'];
$cheque_no = $_GET['cheque'];
$takaInWords = convert_number($g_amount);

echo "</br><div id='cheque' style='width: 574px; height: 320px; font-size:12px; border: blue solid 1px; margin: 0 auto; background-image: url(images/cheque.gif);background-repeat: no-repeat;background-size:100% 320px;'>
                 <div style='width: 558px;height: 70px;float: left;padding-left: 15px; background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 70px;'></div>
                 <div id='cheque_body' style='width: 570px;float: left;padding-left: 2px;'>
                        <div style='width: 570px;float: left;'>
                               <div id='cheque_dateTime' style='text-align:left; width: 280px;float: left'><b>তারিখ :</b> "; echo date("d.m.y");echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>সময় :</b> ";echo date('g:i a' , strtotime('+5 hour'));echo"</div>
                               <div id='cheque_no' style='text-align: right;width: 290px;float: left;'><b>চেক নাম্বার :</b> <input type='text'readonly='' style='width: 200px;' value='$cheque_no' /></div>
                         </div></br></br>
                          <div style='text-align: left;'><span><b>টাকার পরিমাণ :</b> <input type='text' readonly='' style='width:200px;text-align:right;padding:0px 2px;' value='$g_amount' /> TK</span></div>
                          <div id='amount_in_words' style='text-align: left;'><span><b>টাকার পরিমাণ (কথায়) :</b></span>$takaInWords Taka only.</div></br>
                          <div style='text-align: left;'><span><b>অ্যাকাউন্ট নং  :</b></span><input type='text' readonly style='width:200px;padding:0px 2px;' value='$accountnumber' /></div></br>
                              <div style='text-align: left;'><span><b>অ্যাকাউন্টের নাম :</b></span><input type='text' readonly style='width:200px;padding:0px 2px;' value='$accountname' /></div>
                          <div style='float: right;height: 20px;padding-top: 10px;text-align: right;'><input type='text' readonly style='width:230px;' /><hr style='width:230px; height: 2px; background-color: black;'/> এখানে স্বাক্ষর করুন&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                  </div>
             </div></br>";
?>
