<?php
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$logedInUserID = $_SESSION['userIDUser'];
$logedinOfficeId = $_SESSION['loggedInOfficeID'];
$arr_trans =  array('sender'=>'প্রেরক','receiver'=>'প্রাপক','paid'=>'দেয়া হয়েছে','unpaid'=>'দেয়া হয়নি','transfer'=>'ট্রান্সফার করা হয়েছে','cancel'=>'বাতিল');

$msg="";
if(isset($_POST['check']))
{
    $p_pinNo = $_POST['pinNo'];
    $sel_cheque = $conn->prepare("SELECT * FROM acc_user_amount_transfer JOIN cfs_user ON trans_senderid = idUser WHERE send_amt_pin = ? AND trans_type='send'");
    $sel_cheque->execute(array($p_pinNo));
    $chequerow = $sel_cheque->fetchAll();
    if(count($chequerow) > 0)
    {
        foreach ($chequerow as $row) {
            $db_makingdatetime = $row['trans_date_time'];
            $date = date('d-m-Y', strtotime($db_makingdatetime));
            $db_status = $row['send_amt_status'];
            $db_amount = $row['trans_amount'];
            $db_name = $row['account_name'];
            $db_charger = $row["chrg_givenby"];
            $db_charge = $row["trans_servicecharge"];
            $db_get_amount = $row['reciever_get'];
            $db_sendID = $row['idpamounttrans'];
            $db_send_track = $row['send_track'];
            $db_amount_track = $row['send_amount_track'];
        }
    }
    else
    {
        $msg = "দুঃখিত, এই পিন নাম্বারটি সঠিক নয়। দয়া করে সঠিক পিন নাম্বারটি লিখুন";
    }
}

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
        <div id="noprint" style="padding-left: 110px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
               <table  class="formstyle" style="width: 80%;font-family: SolaimanLipi !important; font-size: 14px;">          
                    <tr ><th colspan="2" style="text-align: center;font-size: 16px;">পাঠানো টাকা প্রদান </th></tr>
                    <tr>
                        <td>
                            <form method="POST" action="">
                                <table>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">পিন নাম্বার :</td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='pinNo' /> </td>
                                    </tr>
                                    <tr>
                                        <td  colspan="2" style="text-align: center;" ></br><input class="btn" style =" font-size: 12px; " name='check' type="submit" value="যাচাই করুন" /></td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                    
                    <?php if(isset($_POST['check'])) 
                        {
                            if($msg !="")
                            {
                    ?> 
                    <tr>
                        <td colspan="2" style="color: red;text-align: center;"><?php echo $msg?></td>
                    </tr>
                            <?php } else { ?>
                    <tr>
                        <td>
                            <form method="POST" action="" onsubmit="return beforeSubmit()">
                                <table>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">প্রেরকের নাম :</td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='sendername' id='' readonly="" value="<?php echo $db_name;?>" /> </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">প্রেরিত টাকার পরিমান :</td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='sendamount' id='' readonly="" value="<?php echo $db_amount;?>" /> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">চার্জ প্রদানকারী :</td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='charger' id='' readonly="" value="<?php echo $arr_trans[$db_charger];?>" /> </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">চার্জের পরিমান :</td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='chargeamount' id='' readonly="" value="<?php echo $db_charge;?>" /> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">প্রাপ্ত টাকার পরিমান :<input type="hidden" name="amounttrack" value="<?php echo $db_amount_track?>" /></td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='getamount' id='' readonly="" value="<?php echo $db_get_amount;?>" /> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">পাঠানোর তারিখ :<input type="hidden" name="sendtrack" value="<?php echo $db_send_track?>" /></td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='send_date' id='' readonly="" value="<?php echo english2bangla($date);?>" /> </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">পিন স্ট্যাটাস :<input type="hidden" name="sendID" value="<?php echo $db_sendID?>" /></td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='pin_status' id='' readonly="" value="<?php echo $arr_trans[$db_status];?>" /> </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">এডমিনের পাসওয়ার্ড:</td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="password" name='pass' id="pass" /> </td>
                                    </tr>
                                    <tr>                    
                                        <td id="noprint" colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; width: 150px;" type="submit" name="pay" value="ঠিক আছে" /></td>                           
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                            <?php } }?>
                </table>
                </fieldset>
            </form>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>