<?php
//error_reporting(0);
include 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$cfsID = $_SESSION['userIDUser'];
$ons_id = $_SESSION['loggedInOfficeID'];
$ons_type = $_SESSION['loggedInOfficeType'];
$ins_fund_to_fund = $conn->prepare("INSERT INTO acc_store_fund_transfer (amount, source_fund_code, receiver_fund_code, reason, transfer_date, ons_type,ons_id) 
                                                            VALUES (?,?,?,?,NOW(),?,?)");
if(isset($_POST['submit']))
{
    $p_fromfundid = $_POST['fromfund'];
    $p_tofundid = $_POST['tofund'];
    $p_amount = $_POST['t_in_amount'];
    $p_description = $_POST['inDescription'];
    $query1 = $p_fromfundid.' = '.$p_fromfundid.'-'.$p_amount;
    $query2 = $p_tofundid.' = '.$p_tofundid.'+'.$p_amount;
    $conn->beginTransaction();
    $sqlresult = $ins_fund_to_fund->execute(array($p_amount, $p_fromfundid, $p_tofundid,$p_description,$ons_type,$ons_id));
    //$sqlresult2 = $up_acc_store_logc->execute(array($query1,$query2,$ons_type,$ons_id));
    $sqlresult2 = mysql_query("UPDATE acc_store_logc SET $query1,$query2, last_update = NOW()
                                                           WHERE  ons_type ='$ons_type' AND ons_id=$ons_id") or exit(mysql_error());
     if($sqlresult && $sqlresult2)
     {
         $conn->commit();
         echo "<script>alert('ট্রান্সফার হয়েছে')</script>";
     }
     else {
                $conn->rollBack();
                echo "<script>alert('দুঃখিত,ট্রান্সফার হয়নি')</script>";
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
function checkAmount(inAmount)
{
    var fundamount= Number(document.getElementById('fundAmount').value);
    if(Number(inAmount) > fundamount)
        {
            document.getElementById('showerror').innerHTML= "দুঃখিত, পরিমান অতিক্রম করেছে";
        }
     else
        {
            document.getElementById('showerror').innerHTML= "";
        }
}
function beforeSubmit()
{
    if ((document.getElementById('fromfund').value != "0") 
            && (document.getElementById('fundAmount').value != "")
            && (document.getElementById('fundAmount').value != "0")
            && (document.getElementById('t_in_amount').value != "")
            && (document.getElementById('t_in_amount').value != "0")
            && (document.getElementById('tofund').value != "0")
            && (document.getElementById('showerror').innerHTML == ""))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
function getAmount(fundCode)
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
          document.getElementById('fundAmount').value = xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/internalFundIncludes.php?fundCode="+fundCode+"&type=1",true);
        xmlhttp.send();	
}
</script>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="return beforeSubmit();" action="">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;">ফান্ড থেকে ফান্ডে টাকা ট্রান্সফার</th></tr>
                    <tr>
                        <td>
                            <fieldset style="border:3px solid #686c70;width: 90%;">
                                <legend style="color: brown;">যে ফান্ড থেকে ট্রান্সফার হবে</legend>
                                <table>
                                    <tr>
                                        <td >ফান্ড</td>
                                        <td>: <select class="box" name="fromfund" id="fromfund" onchange="getAmount(this.value);">
                                                <option value="0">-সিলেক্ট করুন-</option>
                                                <option value="ACM">ক্রয়মূল্য</option>
                                                <option value="AEP">এক্সট্রা প্রফিট</option>                                            
                                                <option value="ASE">সেলিং আর্ন</option>
                                                <option value="ARI">রিপড ইনকাম</option>
                                                <option value="AVG">ভগ্নাংশ এমাউন্ট</option>
                                                </select><em2> *</em2>
                                        </td>          
                                    </tr>
                                    <tr>
                                        <td >ট্রান্সফার এ্যামাউন্ট</td>
                                        <td>: <input class="box" type="text" id="fundAmount" style="text-align: right;"  /> TK</td>          
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                        <td>
                            <fieldset style="border:3px solid #686c70;width: 90%;">
                                <legend style="color: brown;">যে ফান্ডে ট্রান্সফার হবে</legend>
                                <table>
                                    <tr>
                                        <td >ফান্ড</td>
                                        <td>: <select class="box" name="tofund" id="tofund">
                                                <option value="0">-সিলেক্ট করুন-</option>
                                                <option value="ACM">ক্রয়মূল্য</option>
                                                <option value="AEP">এক্সট্রা প্রফিট</option>                                            
                                                <option value="ASE">সেলিং আর্ন</option>
                                                <option value="ARI">রিপড ইনকাম</option>
                                                <option value="AVG">ভগ্নাংশ এমাউন্ট</option>
                                            </select><em2> *</em2></td>          
                                    </tr>
                                    <tr>
                                        <td >টোটাল ইন এ্যামাউন্ট</td>
                                        <td>: <input class="box" type="text" id="t_in_amount" name="t_in_amount" style="text-align: right;" onkeypress=' return numbersonly(event)' onkeyup="checkAmount(this.value)" /><em2> *</em2> TK</td>          
                                    </tr>
                                    <tr>
                                        <td colspan="2" id="showerror" style="text-align: center;color: red;"></td>  
                                    </tr>
                                    <tr> 
                                        <td>কারন</td>
                                        <td> <textarea name="inDescription" ></textarea></td>           
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="ট্রান্সফার করুন" /></td>                           
                    </tr>    
                </table>
            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>