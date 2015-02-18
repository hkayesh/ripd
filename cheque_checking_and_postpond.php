<?php
include 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/updateQueryPDO.php';
$msg = "";
$error_msg = "";
if(isset($_POST['postpone'])){
    $p_reason = "";
    $office_userid = $_SESSION['userIDUser'];
    $logged_in_officeID = $_SESSION['loggedInOfficeID'];
    $p_reason = $_POST['reason'];
    $p_chequeNo = $_POST['cheque_number'];
    //echo "$p_reason, postpond, $office_userid, $logged_in_officeID, $p_chequeNo";
    $sql_update_cheque->execute(array($p_reason, "postpond", $office_userid, $logged_in_officeID, $p_chequeNo));
    $msg = "চেক নং $p_chequeNo স্থগিত হয়েছে";
}
if(isset($_POST['check'])) {
                        $p_chequeNo = $_POST['chequeNo'];
                        $sql_select_cheque->execute(array($p_chequeNo));
                        $db_cheque = $sql_select_cheque->fetchAll();
                        $count = 0;
                        foreach ($db_cheque as $row){
                            $db_cheque_num = $row['cheque_num'];
                            $db_cheque_amount = $row['cheque_amount'];
                            $db_accNumber = $row['account_number'];
                            $db_acc_name = $row['account_name'];
                            $takaInWords = convert_number($db_cheque_amount);
                            $db_cheque_status = $row['cheque_status'];
                            $count++;
                        }
                        if($count == 0){
                            $error_msg = "দুঃখিত, আপনার চেক নং টি ভুল অথবা স্থগিত করা আছে";
                        }
}
?>

<style type="text/css"> @import "css/bush.css";</style>

    <div class="main_text_box">
        <div id="noprint" style="padding-left: 110px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="" name="cheque" action="">	
                <table  class="formstyle" style="width: 80%;font-family: SolaimanLipi !important; font-size: 14px;">          
                    <tr ><th colspan="2" style="text-align: center;font-size: 16px;">চেক-এর বৈধতা যাচাই এবং স্থগিত করন </th></tr>
                    <?php if($msg != "") {?>
                    <tr ><td colspan="2" style="color: green; font-size: 25px; text-align: center"><b><?php echo $msg;?></b></td></tr>
                    <?php }?>
                    <tr>
                        <td style="text-align: right;width: 50%;">চেক নাম্বার :</td>
                        <td style="text-align: left;width: 50%;"><input class="box" type="text" name='chequeNo' /> </td>
                    </tr>
                    <?php if($error_msg != "") {?>
                    <tr ><td colspan="2" style="color: red; font-size: 25px; text-align: center"><b><?php echo $error_msg;?></b></td></tr>
                    <?php }?>
                    <tr>
                        <td  colspan="2" style="text-align: center;" ></br><input class="btn" style =" font-size: 12px; " name='check' type="submit" value="যাচাই করুন" /></td>
                    </tr>
                    <?php 
                        if($count != 0){
                        ?>
                    <tr>
                        <td colspan="2" style="text-align: center;" id="viewCheque"><input type="hidden" name="cheque_number" value="<?php echo $db_cheque_num?>">
                            </br><div id='cheque' style='width: 574px; height: 320px; font-size:12px; border: blue solid 1px; margin: 0 auto; background-image: url(images/cheque.gif);background-repeat: no-repeat;background-size:100% 320px;'>
                                    <div style='width: 558px;height: 70px;float: left;padding-left: 15px; background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 70px;'></div>
                                    <div id='cheque_body' style='width: 570px;float: left;padding-left: 2px;'>
                                           <div style='width: 570px;float: left;'>
                                                  <div id='cheque_dateTime' style='text-align:left; width: 280px;float: left'><b>তারিখ :</b><?php echo date("d.m.y"); ?>&nbsp;&nbsp;&nbsp;&nbsp;<b>সময় :</b> <?php print date('g:i a', strtotime('+4 hour')) ?></div>
                                                  <div id='cheque_no' style='text-align: right;width: 290px;float: left;'><b>চেক নাম্বার :</b><input type='text'readonly='' style='width: 200px;' value='<?php echo $db_cheque_num; ?>' /></div>
                                            </div></br></br>
                                             <div style='text-align: left;'><span><b>টাকার পরিমাণ :</b> <input type='text' readonly='' style='width:200px;text-align:right;padding:0px 2px;' value='<?php echo $db_cheque_amount; ?>' /> TK</span></div>
                                             <div id='amount_in_words' style='text-align: left;'><span><b>টাকার পরিমাণ (কথায়) :</b></span><?php echo $takaInWords; ?> Taka only.</div></br>
                                             <div style='text-align: left;'><span><b>অ্যাকাউন্ট নং  :</b> </span><input type='text' readonly style='width:200px;padding:0px 2px;' value='<?php echo $db_accNumber ?>' /></div></br>
                                                 <div style='text-align: left;'><span><b>অ্যাকাউন্টের নাম :</b> </span><input type='text' readonly style='width:200px;padding:0px 2px;' value='<?php echo $db_acc_name ?>' /></div>
                                             <div style='float: right;height: 20px;padding-top: 10px;text-align: right;'><input type='text' readonly style='width:230px;' /><hr style='width:230px; height: 2px; background-color: black;'/> এখানে স্বাক্ষর করুন&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                     </div>
                                </div></br>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;width: 50%;">স্থগিতের কারণ</td>
                        <td style="text-align: left;width: 50%;"><textarea name="reason"></textarea></td>
                    </tr>
                    <tr>                    
                        <td id="noprint" colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; width: 150px;" type="submit" name="postpone" value="স্থগিত" /></td>                           
                    </tr>
                    <?php }?>
                </table>
                </fieldset>
            </form>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>
