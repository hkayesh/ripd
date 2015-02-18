<?php
if(isset($_GET['TP']))
{
    $tkPerTicket = $_GET['TP'];
    $mpPerTicket = $_GET['MP'];
    $totalseat = $_GET['seat'];
    if($totalseat == 0)
    {
        echo ' <table style="color: darkblue;"> ';
        echo ' <tr><td colspan="2" style="padding-left: 10px;"></br>
                  <span style="color: red; font-size: 15px; text-decoration: blink; padding-left: 220px !important;">কমপক্ষে একটি সিট সিলেক্ট করুন</span></td></tr>';
        echo '</table>';
    }
    else
    {
    $total_ticketprize = $tkPerTicket*$totalseat;
    $total_makingcharge = $mpPerTicket*$totalseat;
    $total_amount = $total_ticketprize + $total_makingcharge;
        echo ' <table style="color: darkblue;"> ';
        echo " <tr>
        <td style='padding-left: 0px !important;'>মোট টিকেট</td>
        <td >: <span style='color: black;'>$totalseat টি</span></td><td style='width:30%;'></td><td style='width:20%;'></td>
        </tr>
        <tr>
        <td style='padding-left: 0px !important;'>মোট টিকেট প্রাইজ</td>
        <td style='color: black;'>: $total_ticketprize TK <input type= 'hidden' name='totalTicketPrize' value='$total_ticketprize' /></td>
         </tr>
         <tr>
         <td style='padding-left: 0px !important;'>মোট মেকিং চার্জ</td>
        <td style='color: black;'>: $total_makingcharge TK <input type= 'hidden' name='totalMakingCharge' value='$total_makingcharge' /></td>
        </tr>
        <tr>
         <td style='padding-left: 0px !important;'>মোট টিকেট বিক্রয়মূল্য</td>
        <td style='color: black;'>: $total_amount TK<input type= 'hidden' name='totalTaka' value='$total_amount' /></td>
        </tr>
        <tr>
        <td style='width:50%;padding-left: 0px !important;text-align:center;'><input type='radio' name='bycash' onclick='paycash($total_amount)' />পেমেন্ট বাই ক্যাশ</td>
        <td style='width:50%;text-align:center;'><input type='radio' name='bycash' onclick='paybyaccount($total_amount)'/>পেমেন্ট বাই অ্যাকাউন্ট</td>
        </tr><table>
    ";
    }
}
elseif ($_GET['ticketTotal']) {
    $tkPerTicket = $_GET['ticketTotal'];
    $totalseat = $_GET['seat'];
    if($totalseat == 0)
    {
        echo ' <table style="color: darkblue;"> ';
        echo ' <tr><td colspan="2" style="padding-left: 10px;"></br>
                  <span style="color: red; font-size: 15px; text-decoration: blink; padding-left: 220px !important;">কমপক্ষে একটি সিট সিলেক্ট করুন</span></td></tr>';
        echo '</table>';
    }
    else
    {
    $total_ticketprize = $tkPerTicket*$totalseat;
        echo ' <table style="color: darkblue;"> ';
        echo " <tr>
        <td style='padding-left: 0px !important;'>মোট টিকেট</td>
        <td >: <span style='color: black;'>$totalseat টি</span></td></td>
        </tr>
        <tr>
            <td style='padding-left: 0px !important;'>মোট টিকেট প্রাইজ</td>
            <td style='color: black;'>: $total_ticketprize TK <input type= 'hidden' name='totalTaka' value='$total_ticketprize' /></td>
         </tr>
         <tr>
             <td style='padding-left: 0px !important;'>পাসওয়ার্ড</td>
            <td style='color: black;'>: <input class='box' type= 'password' name='password' onblur='checkCorrectPass(this.value);'/> <span id='passmsg'></span></td>
         </tr>
         <tr>
            <td colspan='2' style='text-align:center;' ><input class = 'btn' style =' font-size: 12px;' type = 'submit' readonly name='submit_ticket' id='submit_ticket' onclick='return beforeSave()' value='ক্রয় করা হল'  /></td>
         </tr>
         <table>
    ";
    }

}
?>