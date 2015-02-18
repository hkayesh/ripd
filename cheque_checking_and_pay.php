<?php
include 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$logedInUserID = $_SESSION['userIDUser'];
$logedinOfficeId = $_SESSION['loggedInOfficeID'];

$msg="";
if(isset($_POST['check']))
{
    $p_chequeNo = $_POST['chequeNo'];
    $sel_cheque = $conn->prepare("SELECT * FROM acc_user_cheque JOIN cfs_user ON 	cheque_makerid = idUser WHERE cheque_num = ?");
    $sel_cheque->execute(array($p_chequeNo));
    $chequerow = $sel_cheque->fetchAll();
    if(count($chequerow) > 0)
    {
        foreach ($chequerow as $row) {
            $db_makingdatetime = $row['cheque_mak_datetime'];
            $date = date('d-m-Y', strtotime($db_makingdatetime));
            $time = date('H:i a', strtotime($db_makingdatetime));
            $db_status = $row['cheque_status'];
            $db_amount = $row['cheque_amount'];
            $db_name = $row['account_name'];
            $db_number = $row['account_number'];
            $takaInWords = convert_number($db_amount);
            $db_cheque_id = $row['iduserchq'];
        }
    }
    else
    {
        $msg = "দুঃখিত, এই চেক নাম্বারটি সঠিক নয়। দয়া করে সঠিক চেক নাম্বারটি লিখুন";
    }
}

if(isset($_POST['pay']))
{
    $p_adminpass = md5($_POST['pass']);
    $p_chequeID = $_POST['chequeID'];
    $p_amount = $_POST['amount'];
    
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
            
            $up_cheque = $conn->prepare("UPDATE acc_user_cheque SET cheque_status='paid', cheque_update_datetime=NOW(), 
                                                                cheque_updated_userid=?, chqupd_officeid= ? WHERE iduserchq = ? ");
            $update = $up_cheque->execute(array($logedInUserID,$logedinOfficeId,$p_chequeID));
            $ins_daily_inout = $conn->prepare("INSERT INTO acc_ofc_daily_inout (daily_date, daily_onsid, out_amount) VALUES (NOW(),?,?)");
            $insert = $ins_daily_inout->execute(array($office_ons_id,$p_amount));
                if($update && $insert)
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
                    <tr ><th colspan="2" style="text-align: center;font-size: 16px;">চেক-এর বৈধতা যাচাই এবং টাকা প্রদান </th></tr>
                    <tr>
                        <td>
                            <form method="POST" action="">
                                <table>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">চেক নাম্বার :</td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='chequeNo' /> </td>
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
                                        <td colspan="2" style="text-align: center;" id="viewCheque">
                                            <br/>
                                            <div id='cheque' style='width: 574px; height: 320px; font-size:12px; border: blue solid 1px; margin: 0 auto; background-image: url(images/cheque.gif);background-repeat: no-repeat;background-size:100% 320px;'>
                                                    <div style='width: 558px;height: 70px;float: left;padding-left: 15px; background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 70px;'></div>
                                                    <div id='cheque_body' style='width: 570px;float: left;padding-left: 2px;'>
                                                           <div style='width: 570px;float: left;'>
                                                                  <div id='cheque_dateTime' style='text-align:left; width: 280px;float: left'><b>তারিখঃ</b> <?php echo $date; ?>&nbsp;&nbsp;&nbsp;&nbsp;<b>সময়ঃ</b> <?php print $time; ?></div>
                                                                  <div id='cheque_no' style='text-align: right;width: 290px;float: left;'><b>চেক নাম্বার :</b> <input type='text'readonly='' style='width: 200px;' value='<?php echo $p_chequeNo; ?>' /></div>
                                                            </div></br></br>
                                                             <div style='text-align: left;'><span><b>টাকার পরিমাণ :</b> <input type='text' name="amount" readonly='' style='width:200px;text-align:right;padding:0px 2px;' value='<?php echo $db_amount; ?>' /> TK</span></div>
                                                             <div id='amount_in_words' style='text-align: left;'><span><b>টাকার পরিমাণ (কথায়) :</b></span><?php echo $takaInWords; ?> Taka only.</div></br>
                                                             <div style='text-align: left;'><span><b>অ্যাকাউন্ট নং  :</b> </span><input type='text' readonly style='width:200px;padding:0px 2px;' value='<?php echo $db_number ?>' /></div></br>
                                                                 <div style='text-align: left;'><span><b>অ্যাকাউন্টের নাম: </b></span><input type='text' readonly style='width:200px;padding:0px 2px;' value='<?php echo $db_name ?>' /></div>
                                                             <div style='float: right;height: 20px;padding-top: 10px;text-align: right;'><input type='text' readonly style='width:230px;' /><hr style='width:230px; height: 2px; background-color: black;'/> <b>এখানে স্বাক্ষর করুন</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                                     </div>
                                                </div>
                                            <br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;width: 50%;">চেক স্ট্যাটাস :<input type="hidden" name="chequeID" value="<?php echo $db_cheque_id?>" /></td>
                                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='chequeStatus' id='chequeStatus' readonly="" value="<?php echo $db_status;?>" /> </td>
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
