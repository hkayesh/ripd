<?php
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$logedInUserID = $_SESSION['userIDUser'];
$logedinOfficeId = $_SESSION['loggedInOfficeID'];

if(isset($_POST['pay']))
{
    $p_adminpass = md5($_POST['pass']);
    $p_sendID = $_POST['sendID'];
    $p_amount = $_POST['getamount'];
    $p_send_track = $_POST['sendtrack'];
    $p_amount_track = $_POST['amounttrack'];
    $p_charge_amount = $_POST['chargeamount'];
    $charge_code = 'CSA';
    $arr_send_track = explode(',', $p_send_track);
    $arr_amount_track = explode(',', $p_amount_track);
    $arr_fund = array('1'=>'HIA','2'=>'RHC');
    
    $up_main_fund = $conn->prepare("UPDATE main_fund SET fund_amount = fund_amount - ?, last_update=NOW() WHERE fund_code = ?");
    
    $sel_onsID = $conn->prepare("SELECT idons_relation FROM ons_relation WHERE add_ons_id = ? AND catagory='office'");
    $sel_onsID->execute(array($logedinOfficeId));
    $offrow = $sel_onsID->fetchAll();
    foreach ($offrow as $value) {
       $office_ons_id = $value['idons_relation'];
    }
    
    $sel_user = $conn->prepare("SELECT * FROM cfs_user WHERE idUser =? AND password = ?");
    $sel_user->execute(array($logedInUserID,$p_adminpass));
    $cfsrow = $sel_user->fetchAll();
    if(count($cfsrow) == 0)
    {
        echo "<script>alert('দুঃখিত, পাসওয়ার্ড সঠিক হয়নি')</script>";
    }
    else {
            $conn->beginTransaction();
            
            $up_amount_transfer = $conn->prepare("UPDATE acc_user_amount_transfer SET send_amt_status='paid', send_paid_date=NOW(), 
                                                                                paid_office_id=? WHERE idpamounttrans = ? ");
            $update = $up_amount_transfer->execute(array($office_ons_id,$p_sendID));
            
            for($i=0;$i<count($arr_send_track);$i++)
            {
                $track_no = $arr_send_track[$i];
                $fundcode = $arr_fund[$track_no];
                $update1 = $up_main_fund->execute(array($arr_amount_track[$i],$fundcode));
            }
            
            $update2 = $up_main_fund->execute(array($p_charge_amount,$charge_code));
            
            $ins_daily_inout = $conn->prepare("INSERT INTO acc_ofc_daily_inout (daily_date, daily_onsid, out_amount) VALUES (NOW(),?,?)");
            $insert = $ins_daily_inout->execute(array($office_ons_id,$p_amount));
                if($update && $insert && $update1 && $update2)
                {
                    $conn->commit();
                    echo "<script>alert('টাকা প্রদান করা হল')</script>";
                }
                else
                {
                    $conn->rollBack();
                    echo "<script>alert('দুঃখিত, টাকা প্রদান করা হয়নি')</script>";
                }
       }
}
?>

<style type="text/css"> @import "css/bush.css";</style>
<script type="text/javascript">
function getPinInfo(pin) // find pin info *****************
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
                document.getElementById('pin_details').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/PinNumberValidation.php?pinno="+pin,true);
        xmlhttp.send();	
}

function beforeSubmit()
    {
        if((document.getElementById('chequeStatus').value == 'made')
            && (document.getElementById('pass').value != ""))
        {
            return true;
        }
        else {
            alert("দুঃখিত,চেক স্ট্যাটাস টাকা প্রদানের উপযোগী নয়\nঅথবা\nপাসওয়ার্ড দেয়া হয়নি");
            return false; 
        }
    }
</script>

    <div class="main_text_box">
        <div id="noprint" style="padding-left: 110px;"><a href="profile_account_management.php"><b>ফিরে যান</b></a></div>
        <div>           
               <table  class="formstyle" style="width: 80%;font-family: SolaimanLipi !important; font-size: 14px;">          
                    <tr ><th colspan="2" style="text-align: center;font-size: 16px;">পিন নং ব্যবহার </th></tr>
                    <tr>
                        <td>
                            <form method="POST" action="">
                                <table>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">পিন নাম্বার :</td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='pinNo' maxlength="18" onblur="getPinInfo(this.value)"/> </td>
                                    </tr>
                                    <tr id="pin_details"></tr>
                                    <tr>
                                        <td  colspan="2" style="text-align: center;" ></br><input class="btn" style =" font-size: 12px; " name='check' type="submit" value="ব্যবহার করুন" /></td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>