<?php
include 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$logedinOfficeId = $_SESSION['loggedInOfficeID'];
$logedinOfficeName = $_SESSION['loggedInOfficeName'];
$loginUSERid = $_SESSION['userIDUser'];

if(isset($_POST['cash_in']))
{
    $p_cfsid = $_POST['acID'];
    $p_total_amount = $_POST['t_in_amount'];
    $p_reason = $_POST['inDescription'];
    $in_cheque_number = get_time_random_no(10);
    $ins_acc_cheque = $conn->prepare("INSERT INTO acc_user_cheque (cheque_num, cheque_type, cheque_description, cheque_mak_datetime, cheque_amount, cheque_makerid, cheque_status)
                                                                 VALUES (?,'in', ?,NOW(),?, ?, 'in_amount')");
    $ins_daily_inout = $conn->prepare("INSERT INTO acc_ofc_daily_inout (daily_date, daily_onsid, in_amount) VALUES (NOW(),?,?)");
    $sel_onsID = $conn->prepare("SELECT idons_relation FROM ons_relation WHERE add_ons_id = ? AND catagory='office'");
    $up_main_fund = $conn->prepare("UPDATE main_fund SET fund_amount = fund_amount + ?, last_update = NOW() WHERE fund_code = 'HIA'");
    $insert_notification = $conn->prepare("INSERT INTO notification (nfc_senderid,nfc_receiverid,nfc_message,nfc_actionurl,nfc_date,nfc_status, nfc_type, nfc_catagory) 
                                                            VALUES (?,?,?,?,NOW(),?,?,?)");
    
    $sel_onsID->execute(array($logedinOfficeId));
    $offrow = $sel_onsID->fetchAll();
    foreach ($offrow as $value) {
       $office_ons_id = $value['idons_relation'];
    }
    $url = "";
    $status = "unread";
    $type="msg";
    $nfc_catagory="personal";
    $notice = "আপনি ".$logedinOfficeName." অফিস হতে আপনার অ্যাকাউন্টে ".$p_total_amount." টাকা ইন করেছেন";
    
    $conn->beginTransaction();
    
    $sqlrslt1 = $ins_acc_cheque->execute(array($in_cheque_number,$p_reason,$p_total_amount,$p_cfsid));
    $sqlrslt2 = $ins_daily_inout->execute(array($office_ons_id,$p_total_amount));
    $sqlrslt3 = $up_main_fund->execute(array($p_total_amount));
    $sqlrslt4 = $insert_notification->execute(array($loginUSERid,$p_cfsid,$notice,$url,$status,$type,$nfc_catagory));
    
    if($sqlrslt1  && $sqlrslt2 && $sqlrslt3 && $sqlrslt4)
        {
            $conn->commit();
            echo "<script>alert('ক্যাশ ইন করা হল')</script>";
        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত,ক্যাশ ইন করা যায়নি')</script>";
        }
}

?>
<style type="text/css"> @import "css/bush.css";</style>
<script>
function numbersonly(e)
    {
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8)
        { //if the key isn't the backspace key (which we should allow)
            if (unicode<48||unicode>57) //if not a number
                return false //disable key press
        }
    }
function beforeSubmit()
{
    if ((document.getElementById('acNo').value != "") 
            && (document.getElementById('acName').value != "")
            && (document.getElementById('t_in_amount').value != "")
            && (document.getElementById('t_in_amount').value != "0"))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>
<script>
    function getAccountInfo(acNo)
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById('info').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/getAccountInfoForCashIn.php?acNo="+acNo+"&type=personal",true);
        xmlhttp.send();
    }
</script>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="return beforeSubmit();" action="cash_in.php">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;">ক্যাশ ইন</th></tr>
                    <tr>
                        <td>একাউন্ট নাম্বার</td>
                        <td>: <input class="box" type="text" id="acNo" name="acNo" maxlength="15" onblur="getAccountInfo(this.value)" /><em2> *</em2></td>
                    </tr>
                    <tr>
                        <td colspan="2" id="info" style="padding-left: 0px !important;"></td>
                    </tr>
                    <tr>
                        <td >মোট ইন পরিমান</td>
                        <td>: <input class="box" type="text" id="t_in_amount" name="t_in_amount" onkeypress=' return numbersonly(event)' /><em2> *</em2> TK</td>          
                    </tr> 
                    <tr> 
                        <td>কারন</td>
                        <td> <textarea name="inDescription" ></textarea></td>           
                    </tr>
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="cash_in" value="ক্যাশ ইন করুন" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>