<?php
include_once './ConnectDB.inc';
if (isset ($_GET['ticketprize'])) 
{
     $ticketTaka = $_GET['ticketprize'];
    echo " <td colspan='4' style='padding-left: 278px; ' >
                <input type= 'hidden' name='paymenttype' value='cash' />
                <input class = 'btn' style =' font-size: 12px; ' type = 'submit' name='submit_ticket' value='ক্রয় করা হল' /></td>";
}
elseif (isset ($_GET['ticketprizeForAcc'])) 
{
     $ticketTaka = $_GET['ticketprizeForAcc'];
     $buyerCfsID = $_GET['buyer'];
     { 
       // code throgh send sms here ....................................................  
     }
     $sel_acc_balance = mysql_query("SELECT total_balanace FROM acc_user_balance WHERE cfs_user_iduser = $buyerCfsID");
     $balancerow = mysql_fetch_assoc($sel_acc_balance);
     $db_total_balance = $balancerow['total_balanace'];
     if($ticketTaka > $db_total_balance)
     {
         echo "<td colspan='4' style='text-align:center;color:red;'>
                    দুঃখিত,টিকেটগুলো ক্রয় করার জন্য প্রয়োজনীয় পরিমান টাকা আপনার একাউন্টে নেই
                    </td>";
     }
     else
     {
        echo " <td colspan='4' style='text-align:center; '>
                <input type= 'hidden' name='paymenttype' value='account' />
                 <input class = 'btn' style =' font-size: 12px;' type = 'submit' name='submit_ticket' id='submit_ticket' value='ক্রয় করা হল' /></td>";
     }
}
?>