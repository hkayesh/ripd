<?php
//error_reporting(0);
include 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$cfsID = $_SESSION['userIDUser'];
$sql = $conn->prepare("SELECT * FROM main_fund ORDER BY fund_name");
$ins_fund_to_fund = $conn->prepare("INSERT INTO fund_to_fund (src_fund_id, rcv_fund_id, fund_amount, fund_desc, fund_date, trans_user_id) 
                                                            VALUES (?,?,?,?,NOW(),?)");
function getFunds($sql)
{
    echo "<option value= 0> -সিলেক্ট করুন- </option>";
    $sql->execute(array());
    $arr_fund = $sql->fetchAll();
    foreach ($arr_fund as $fundrow) {
        echo "<option value=".$fundrow['idmainfund'].">". $fundrow['fund_name'] ."</option>";
    }
}
if(isset($_POST['submit']))
{
    $p_fromfundid = $_POST['fromfund'];
    $p_tofundid = $_POST['tofund'];
    $p_amount = $_POST['t_in_amount'];
    $p_description = $_POST['inDescription'];
    
    $sqlresult = $ins_fund_to_fund->execute(array($p_fromfundid, $p_tofundid, $p_amount,$p_description,$cfsID));
     if($sqlresult)
     {
         echo "<script>alert('ট্রান্সফার হয়েছে')</script>";
     }
     else {
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
function getAmount(fundID)
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
        xmlhttp.open("GET","includes/fund_includes.php?fundID="+fundID+"&type=1",true);
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
                                                <?php getFunds($sql);?>
                                            </select><em2> *</em2></td>          
                                    </tr>
                                    <tr>
                                        <td >বর্তমান পরিমান</td>
                                        <td>: <input class="box" type="text" id="fundAmount" style="text-align: right;" readonly="" /> TK</td>          
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
                                                <?php getFunds($sql);?>
                                            </select><em2> *</em2></td>          
                                    </tr>
                                    <tr>
                                        <td >মোট ট্রান্সফার এ্যামাউন্ট</td>
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