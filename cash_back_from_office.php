<?php
include 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$loginUSERid = $_SESSION['userIDUser'] ;
$loginOfcAcc = $_SESSION['loggedInOfficeID'];
 
$sel_banks = $conn->prepare("SELECT * FROM bank_list ORDER BY bank_name");
$ins_acc_ofc = $conn->prepare("INSERT INTO acc_ofc_physc_in (inamount, bank_id, cheque_number, amount_status, sender_id, office_id, sending_date)
                                                    VALUES (?,?,?,'to_ripd', ?,?,NOW()) ");
$insert_notification = $conn->prepare("INSERT INTO notification (nfc_tablename,nfc_tableid,nfc_senderid,nfc_receiverid,nfc_message,nfc_actionurl,nfc_date,nfc_status, nfc_type, nfc_catagory) 
                                                            VALUES ('acc_ofc_physc_in',?,?,?,?,?,NOW(),?,?,?)");
$sel_onsID = $conn->prepare("SELECT idons_relation FROM ons_relation WHERE add_ons_id = ? AND catagory='office'");
$sel_ripd_head = $conn->prepare("SELECT idons_relation FROM ons_relation LEFT JOIN office ON add_ons_id = idOffice 
                                                    WHERE catagory='office' AND office_type = 'ripd_head' ");

function getBanks($sql)
{
     echo "<option value= 0> -সিলেক্ট করুন- </option>";
    $sql->execute(array());
    $arr_bank = $sql->fetchAll();
    foreach ($arr_bank as $bankrow) {
        echo "<option value=".$bankrow['idbank'].">". $bankrow['bank_name'] ."</option>";
    }
}

if(isset($_POST['submit']))
{
    $p_amount = $_POST['t_in_amount'];
    $p_inType = $_POST['cashInType'];
    if($p_inType == 'cheque')
    {
        $p_bankID = $_POST['bankName'];
        $p_chequeNo = $_POST['chequeNo'];
    }
    else
    {
        $p_bankID = 0;
        $p_chequeNo = 0;
    }
    $sel_onsID->execute(array($loginOfcAcc));
    $offrow = $sel_onsID->fetchAll();
    foreach ($offrow as $value) {
       $office_ons_id = $value['idons_relation'];
    }
    $sel_ripd_head->execute();
    $headrow = $sel_ripd_head->fetchAll();
    foreach ($headrow as $value) {
       $head_ons_id = $value['idons_relation'];
    }
    
    $conn->beginTransaction();
        $y1 = $ins_acc_ofc->execute(array($p_amount,$p_bankID,$p_chequeNo, $loginUSERid, $office_ons_id));
        $db_last_insert_id = $conn->lastInsertId();
        $msg = "টাকা প্রাপ্তি";
        $url = "cash_recieve_from_office.php?id=".$db_last_insert_id;
        $status = "unread";
        $type="action";
        $nfc_catagory="official";
        $sqlrslt3 = $insert_notification->execute(array($db_last_insert_id,$loginUSERid,$head_ons_id,$msg,$url,$status,$type,$nfc_catagory));
        
    if ($y1 && $sqlrslt3) {
        $conn->commit();
       echo "<script>alert('টাকা প্রদান করা হল')</script>";
    } else {
        $conn->rollBack();
        echo "<script>alert('টাকা প্রদান করা হয়নি')</script>";
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
    var radiocheck = 0;
      var radios = document.getElementsByName("cashInType");
      for(var i=0; i<radios.length; i++){
	if(radios[i].checked) { radiocheck = 1; }
	}
    if ((document.getElementById('t_in_amount').value != "")
            && (document.getElementById('t_in_amount').value != "0")
            && (radiocheck == 1))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
function showBox(classname)
{
    elements = $(classname);
    elements.each(function() { 
        $(this).css("visibility","visible"); 
    });
}
function hideBox(classname)
{
    elements = $(classname);
    elements.each(function() { 
        $(this).css("visibility","hidden"); 
    });
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
        xmlhttp.open("GET","includes/getAccountInfoForCashIn.php?acNo="+acNo+"&type=office",true);
        xmlhttp.send();
    }

</script>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="return beforeSubmit()" action="">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;">রিপড টাকা প্রদান</th></tr>
                    <tr>
                        <td >মোট পরিমান</td>
                        <td>: <input class="box" type="text" id="t_in_amount" name="t_in_amount" onkeypress=' return numbersonly(event)' value="<?php echo $totalAmount;?>" /><em2> *</em2> TK</td>          
                    </tr>
                    <tr>
                        <td >পদ্ধতি</td>
                        <td>: <input type="radio" name="cashInType" value="cash" onclick="hideBox('.bank')" /> ক্যাশ &nbsp;&nbsp;&nbsp;&nbsp;
                                 <input type="radio" name="cashInType" value="cheque" onclick="showBox('.bank')" /> চেক<em2> *</em2></td>          
                    </tr>
                    <tr class="bank" style="visibility: hidden;">
                        <td >ব্যাংক</td>
                        <td>: <select class="box" name="bankName">
                                <?php getBanks($sel_banks);?>
                            </select></td>          
                    </tr>
                    <tr class="bank" style="visibility: hidden;">
                        <td >চেক নং</td>
                        <td>: <input class="box" type="text" name="chequeNo" value="0"/> 
                    </tr>
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><br/><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="টাকা প্রদান করুন" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>