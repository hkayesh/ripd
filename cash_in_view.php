<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include 'includes/header.php';
if(isset($_POST['cash_in']))
{
    $check_no = get_time_random_no(10);
    $p_acNo = $_POST['acNo'];
    $p_acName = $_POST['acName'];
    $p_acMobile = $_POST['mobile'];
    $p_totalAmount = $_POST['t_in_amount'];
    $p_description = $_POST['inDescription'];
    $sel_cfs_user = $conn->prepare("SELECT * FROM cfs_user WHERE account_number= ? ");
    $sel_cfs_user->execute(array($p_acNo));
    $row = $sel_cfs_user->fetchAll();
    foreach ($row as $value) {
        $cfsID = $value['idUser'];
    }
    $ins_user_cheque = $conn->prepare("INSERT INTO acc_user_cheque (cheque_num, cheque_type, cheque_description, 	cheque_mak_datetime, cheque_amount, cheque_makerid, cheque_status) 
        VALUES (?,'in',?,NOW(),?,?,'in_amount')");
    $sqlrslt1 = $ins_user_cheque->execute(array($check_no,$p_description,$p_totalAmount,$cfsID));
    if($sqlrslt1)
        {
            echo "<script>alert('সফলভাবে টাকা এন্ট্রি হয়েছে')</script>";
        }
        else {
            echo "<script>alert('দুঃখিত,টাকা এন্ট্রি হয়নি')</script>";
        }
}
?>
<script>
    function print1()
    {
        window.print();
    }
</script>
<style type="text/css"> @import "css/bush.css";</style>
<link href="css/print.css" rel="stylesheet" type="text/css" media="print"/>
<div class="columnSld" style="padding-left: 50px;">
    <div class="main_text_box">
        <div id="noprint"style="padding-left: 10px;"><a href="cash_in_step1.php"><b>ফিরে যান</b></a></div>
        <div style="width: 90%;">           
           <table  class="formstyle" style="width: 95%;margin: 15px !important;">          
                    <tr><th colspan="2" style="text-align: center;">ক্যাশ ইন</th></tr>
                    <tr id="noprint">
                        <td style="text-align: center;">অফিস কপি</td>
                    </tr>
                    <tr>
                        <td>
                            <div id="cheque" style="width: 100%; height: 300px; font-size: 14px;font-weight: bold;border: blue solid 2px; margin: 0 auto;background-image: url(images/cheque.gif);background-repeat: no-repeat;background-size:100% 100%;">
                                <div id="head" style="width: 100%; height: 50px;">
                                    <div id="company" style="width: 100%; height: 100%; float: left; background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 100%;"></div>
                                    <div style="width: 100%;height: 50%;float: left;padding-left: 4px;">
                                        <div id="dt" style="width: 55%;height: 100%;float: left">Date: <?php echo date("d-m-Y");?></div>
                                        <div id="cheque_no" style="width: 44%;height:100%;float: left;text-align: right;padding-right: 2px;">Slip No: <input type="text" readonly="" size="13" value="<?php echo $check_no;?>"/></div>
                                    </div>
                                </div>
                                <div style="width:100%;height: 70%;">
                                    <div id="left" style="width: 55%;height: 50%;float: left;padding-top: 10px;">
                                        <div style="height: 35%;">A/C Number : <input type="text" readonly="" style="width: 62%;" value="<?php echo $p_acNo?>"/></div>
                                        <div style="height: 35%;">A/C Name&nbsp;&nbsp;&nbsp; : <input type="text" readonly="" style="width:62%;" value="<?php echo $p_acName?>" /></div>
                                        <div style="height: 35%;">A/C Mobile&nbsp;&nbsp;: <input type="text" readonly="" style="width: 61%;" value="<?php echo $p_acMobile?>" /></div>
                                    </div>
                                    <div id="ri8" style="width: 43%; height: 48%;float: left;border: black solid 1px;margin-top: 4px;padding-top: 4px;padding-left: 4px;padding-right: 2px;">
                                        <div style="width: 100%;height: 20%;">TK <input type="text" readonly="" size="15" style="height:100%;text-align: right;" value="<?php echo $p_totalAmount?>"/> /= BDT</div>
                                        <div style="width: 100%;height: 50%;">Sum Of Total in Words: </br><textarea readonly="" style="width: 95%;height: 100%;float: left;"><?php echo convert_number($p_totalAmount)."taka only";?></textarea></div>
                                    </div>
                                </div>
                                <div style="width: 100%;height: 10%;">
                                    <div style="width: 55%;height: 100%;float: left;text-align: center"><hr style="width:80%; height: 2px; background-color: black;"/>Depositor Sign</div>
                                    <div style="width: 45%;height: 100%;float: left;text-align: center"><hr style="width:100%; height: 2px; background-color: black;"/>Receiver Sign</div>
                                </div>
                             </div>
                        </td>
                    </tr>
                    <tr>
                        <td>---------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
                    </tr>
                    <tr id="noprint">
                        <td style="text-align: center;">ব্যক্তির কপি</td>
                    </tr>
                    <tr>
                        <td>
                            <div id="cheque" style="width: 100%; height: 300px; font-size: 14px;font-weight: bold;border: blue solid 2px; margin: 0 auto;background-image: url(images/cheque.gif);background-repeat: no-repeat;background-size:100% 100%;">
                                <div id="head" style="width: 100%; height: 50px;">
                                    <div id="company" style="width: 100%; height: 100%; float: left; background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 100%;"></div>
                                    <div style="width: 100%;height: 50%;float: left;padding-left: 4px;">
                                        <div id="dt" style="width: 55%;height: 100%;float: left">Date: <?php echo date("d-m-Y");?></div>
                                        <div id="cheque_no" style="width: 44%;height:100%;float: left;text-align: right;padding-right: 2px;">Slip No: <input type="text" readonly="" size="13" value="<?php echo $check_no;?>"/></div>
                                    </div>
                                </div>
                                <div style="width:100%;height: 70%;">
                                    <div id="left" style="width: 55%;height: 50%;float: left;padding-top: 10px;">
                                        <div style="height: 35%;">A/C Number : <input type="text" readonly="" style="width: 62%;" value="<?php echo $p_acNo?>"/></div>
                                        <div style="height: 35%;">A/C Name&nbsp;&nbsp;&nbsp; : <input type="text" readonly="" style="width:62%;" value="<?php echo $p_acName?>" /></div>
                                        <div style="height: 35%;">A/C Mobile&nbsp;&nbsp;: <input type="text" readonly="" style="width: 61%;" value="<?php echo $p_acMobile?>" /></div>
                                    </div>
                                    <div id="ri8" style="width: 43%; height: 48%;float: left;border: black solid 1px;margin-top: 4px;padding-top: 4px;padding-left: 4px;padding-right: 2px;">
                                        <div style="width: 100%;height: 20%;">TK <input type="text" readonly="" size="15" style="height:100%;text-align: right;" value="<?php echo $p_totalAmount?>"/> /= BDT</div>
                                        <div style="width: 100%;height: 50%;">Sum Of Total in Words: </br><textarea readonly="" style="width: 95%;height: 100%;float: left;"><?php echo convert_number($p_totalAmount)."taka only";?></textarea></div>
                                    </div>
                                </div>
                                <div style="width: 100%;height: 10%;">
                                    <div style="width: 55%;height: 100%;float: left;text-align: center"><hr style="width:80%; height: 2px; background-color: black;"/>Depositor Sign</div>
                                    <div style="width: 45%;height: 100%;float: left;text-align: center"><hr style="width:100%; height: 2px; background-color: black;"/>Receiver Sign</div>
                                </div>
                             </div>
                        </td>
                    </tr>
                    <tr  id="noprint">
                        <td style="text-align: center"><input class="btn" type="button" value="প্রিন্ট করুন" onclick="print1();"></td>
                    </tr>
           </table>
        </div>
    </div>
</div>
    <?php
    include 'includes/footer.php';
    ?>