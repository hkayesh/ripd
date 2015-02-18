<?php
//error_reporting(0);
include 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$loginUSERid = $_SESSION['userIDUser'] ;
$loginOfcID = $_SESSION['loggedInOfficeID'];

$ins_cash_requisition = $conn->prepare("INSERT INTO cash_requisition (requisit_amount, reason, ons_id, requisition_date) 
                                                            VALUES (?,?,?,NOW())");
$insert_notification = $conn->prepare("INSERT INTO notification (nfc_senderid,nfc_receiverid,nfc_message,nfc_actionurl,nfc_date,nfc_status, nfc_type, nfc_catagory) 
                                                            VALUES (?,?,?,?,NOW(),?,?,?)");
$sel_onsID = $conn->prepare("SELECT idons_relation FROM ons_relation WHERE add_ons_id = ? AND catagory='office'");
$sel_ripd_head = $conn->prepare("SELECT idons_relation FROM ons_relation LEFT JOIN office ON add_ons_id = idOffice 
                                                    WHERE catagory='office' AND office_type = 'ripd_head' ");

if(isset($_POST['submit']))
{
    $p_amount = $_POST['t_in_amount'];
    $p_description = $_POST['inDescription'];
    
    $sel_onsID->execute(array($loginOfcID));
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
    
    $sqlresult = $ins_cash_requisition->execute(array($p_amount,$p_description,$office_ons_id));
    $db_last_insert_id = $conn->lastInsertId();
    $msg = "টাকা আবেদন";
    $url = "cash_requisition_from_office.php?id=".$db_last_insert_id;
    $status = "unread";
    $type="msg";
    $nfc_catagory="official";
    $sqlrslt3 = $insert_notification->execute(array($loginUSERid,$head_ons_id,$msg,$url,$status,$type,$nfc_catagory));
     if($sqlresult && $sqlrslt3)
     {
         $conn->commit();
         echo "<script>alert('আবেদন করা হয়েছে')</script>";
     }
     else {
                $conn->rollBack();
                echo "<script>alert('দুঃখিত,আবেদন করা হয়নি')</script>";
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
    if ((document.getElementById('t_in_amount').value != "")
            && (document.getElementById('t_in_amount').value != "0"))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="return beforeSubmit();" action="">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;">টাকা প্রদানের আবেদন</th></tr>
                    <tr>
                        <td >মোট প্রয়োজনীয় এমউন্ট</td>
                        <td>: <input class="box" type="text" id="t_in_amount" name="t_in_amount" style="text-align: right;" onkeypress=' return numbersonly(event)' /><em2> *</em2> TK</td>          
                    </tr>
                    <tr> 
                        <td>কারন</td>
                        <td> <textarea name="inDescription" ></textarea></td>           
                    </tr>
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="আবেদন করুন" /></td>                           
                    </tr>    
                </table>
            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>