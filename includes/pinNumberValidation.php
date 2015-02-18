<?php
include_once './ConnectDB.inc';
$logedInUserID = $_SESSION['userIDUser'];

if(isset($_GET['pin']))
{
    $g_pin = $_GET['pin'];
    $sel_pinmakingused= mysql_query("SELECT * FROM pin_makingused WHERE pin_no='$g_pin' AND pin_state ='open' ");
    if(mysql_num_rows($sel_pinmakingused) == 1)
    {
        $pinmsg = "";
    }
    else
    {$pinmsg = "দুঃখিত আপনার পিন নম্বরটি সঠিক নয় অথবা ব্যবহৃত হয়েছে";}
    echo $pinmsg;
}

elseif(isset($_GET['pinno']))
{
    $g_pin = $_GET['pinno'];
    $sel_pinmakingused= mysql_query("SELECT * FROM pin_makingused LEFT JOIN sales_summary ON sales_summery_idsalessummery = idsalessummary
                                                                WHERE pin_no='$g_pin' AND pin_state ='open' AND  sal_buyerid= '$logedInUserID' ");
    if(mysql_num_rows($sel_pinmakingused) == 1)
    {
        echo "<td colspan='2' style='text-align:center;'>
                    <table style='width:100%;'>
                        <tr>
                            <td  style='text-align: right;width: 50%;'>পিন পিভি ভ্যালু : </td>
                            <td style='text-align: left;width: 50%;'><input class='box' name='pinvalue' /></td>
                        </tr>
                        <tr>
                            <td style='text-align: right;'>পিন তৈরির তারিখ : </td>
                            <td><input class='box' name='pindate' /></td>
                        </tr>
                    </table>
            </td>";
    }
    else
    {
        echo "<td colspan='2' style='text-align:center;color:red;'>দুঃখিত আপনার পিন নম্বরটি সঠিক নয় অথবা ব্যবহৃত হয়েছে</td>";
    }
}
?>
