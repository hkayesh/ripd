<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/sms_send_function.php';

$update_msg = "";
?>
<title>পাসওয়ার্ড পুনরুদ্ধার</title>
<style type="text/css">@import "css/bush.css";</style>

<script>
    function getAccount(keystr) //search employee by account number***************
    {
        var xmlhttp;
        //alert("gdgfdg..........");
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
            if(keystr.length ==0)
            {
                document.getElementById('accountfound').style.display = "none";
            }
            else
            {document.getElementById('accountfound').style.visibility = "visible";
                document.getElementById('accountfound').setAttribute('style','position:absolute;top:39%;left:63.5%;width:225px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
            }
            document.getElementById('accountfound').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("POST","includes/accountSearch.php?key="+keystr+"&location=recover_password.php",true);
        xmlhttp.send();	
    }    
</script>

<?php
if (isset($_POST['submit_new_password'])) {
    $receiver_acc_cfs_id = $_POST['account_cfs_userid'];
    $receiver_acc_user_name = $_POST['account_name'];
    $receiver_acc_mobile_number = $_POST['account_mobile'];

    $new_pass_str = "";
    for ($i = 0; $i < 8; $i++) {
        $arr_rand_generator = array("num", "cap");
        $rand_controller = array_rand($arr_rand_generator);
        if ($rand_controller == "num")
            $new_pass_str .= chr(rand(48, 57));
        else if ($rand_controller == "cap")
            $new_pass_str .= chr(rand(65, 90));
        else
            $new_pass_str .= chr(rand(97, 122)); // this numbers refer to numbers of the ascii table (small-caps)
    }

    if (!empty($new_pass_str)) {
            $send_sms_content = "Dear User, Your password has been changed. Your  new password is: $new_pass_str";
            //echo 'New Password = '.$new_pass_str. "<br/>";
            //echo "Mobile No: ".$receiver_acc_mobile_number;

            $sendResult = SendSMSFuntion($receiver_acc_mobile_number, $send_sms_content);
            //echo "Result is: " . $sendResult;
            $sendStatus = substr($sendResult, 0, 2);
            //echo "SendStatus = ".$sendStatus;
            if($sendStatus == 'OK'){
                $finalPass = md5($new_pass_str);
                $update_pass_sql = "Update cfs_user SET password = '$finalPass' WHERE idUser = '$receiver_acc_cfs_id'";
                if(mysql_query($update_pass_sql)){
                    $update_msg = "'$receiver_acc_user_name' একাউন্ট নামের পাসওয়ার্ড সফলভাবে আপডেট হয়েছে এবং '$receiver_acc_mobile_number' এই নাম্বারে পাসওয়ার্ডটি পাঠানো হয়েছে ";
                }else{
                    $update_msg = "দুঃখিত, '$receiver_acc_mobile_number' এই নাম্বারে যে পাসওয়ার্ডটি পাঠানো হয়েছে তা সিস্টেমে আপডেট হয় নাই। পুনরায় পাসওয়ার্ডটি আপডেট করুন";
                }
            }else{
                $update_msg = "দুঃখিত, '$receiver_acc_user_name' একাউন্টধারীর মোবাইল নাম্বারে মেসেজ পাঠানো যাচ্ছে না, পুনরায় চেষ্টা করুন";
            }
            
        } else {
            $update_msg = "দুঃখিত, পাসওয়ার্ড আপডেট হয় নাই। আবার চেষ্টা করুন";
        }
}

if (isset($_POST['submit_account'])){
    //print_r($_POST);
    $account_msg = '';
    //$account_status = '';
    $accountcfsid = $_POST['account_cfs_id'];
    //if($inserted_success_msg!=""){}
    //echo "Account Status: ".$account_status;
    $select_acc_result = mysql_query("SELECT * FROM  cfs_user WHERE idUser = $accountcfsid");
    $getrow = mysql_fetch_assoc($select_acc_result);
    $db_accountname = $getrow['account_name'];
    $db_accountnumber = $getrow['account_number'];
    $db_accountmobile = $getrow['mobile'];
    $db_user_type = $getrow['user_type'];
    $db_account_status = $getrow['cfs_account_status'];
    $account_status = $db_account_status;
    if ($db_account_status != "active") {
        $account_msg = "এই একাউন্টটি already " . $db_account_status . " আছে";
    }
    if ($db_user_type == 'customer') {
        $sql_cust_info = mysql_query("Select * from customer_account where cfs_user_idUser = $accountcfsid");
        $resull_cust_info = mysql_fetch_array($sql_cust_info);
        $db_account_holder_picture = $resull_cust_info['scanDoc_picture'];
        $db_acc_father_name = $resull_cust_info['cust_father_name'];
        $db_acc_mother_name = $resull_cust_info['cust_mother_name'];
    } elseif ($db_user_type == "employee" or $db_user_type == "presenter" or $db_user_type == "trainer" or $db_user_type == "programmer") {
        $sql_employee_info = mysql_query("Select * from employee, employee_information where cfs_user_idUser = $accountcfsid And Employee_idEmployee = idEmployee");
        $resull_employee_info = mysql_fetch_array($sql_employee_info);
        $db_account_holder_picture = $resull_employee_info['emplo_scanDoc_picture'];
        $db_acc_father_name = $resull_cust_info['employee_fatherName'];
        $db_acc_mother_name = $resull_cust_info['employee_motherName'];
    }
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 48%; float: left"><a href="crm_management.php"><b>ফিরে যান</b></a></div>
        <div style="text-align: right;padding-right: 35px;"><a href="close_account.php?action=new"></a>&nbsp;&nbsp;<a href=""></a></div>
    </div>
    <div>           
        <form name="" method="POST" enctype="multipart/form-data" onsubmit="">	
            <table class="formstyle"  style=" width: 85%; ">          
                <tr>
                    <th style="text-align: center" colspan="2"><h1>একাউন্ট পাসওয়ার্ড পুনরুদ্ধার</h1>
                </th>
                </tr>
                <tr>
                    <td colspan="3" height="25px" style="text-align: center;"><b>
                            <span style="color:gray;font-size:16px;">
                                <blink><?php
    if (!empty($account_msg)) {
        echo $account_msg;
    }if (!empty($msg)) {
        echo $msg;
    }
    ?></blink></span></b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>একাউন্ট নাম্বার</td>
                                <td>: <?php echo $db_accountnumber; ?> 
                                    <input type="hidden" name="account_cfs_userid" id="account_cfs_userid" value="<?php echo $accountcfsid; ?>"/>
                                </td>                                      
                            </tr>
                            <tr>
                                <td>একাউন্টধারীর নাম</td>
                                <td >:  <?php echo $db_accountname; ?></td>
                            <input type="hidden" name="account_name" id="account_name" value="<?php echo $db_accountname; ?>"/>
                </tr>
                <tr>
                    <td>একাউন্ট ধরণ</td>
                    <td >:  <?php echo $db_user_type; ?></td>
                </tr>
                <tr>
                    <td>পিতার নাম</td>
                    <td >:  <?php echo $db_acc_father_name; ?></td>
                </tr>
                <tr>
                    <td>মাতার নাম</td>
                    <td >:  <?php echo $db_acc_mother_name; ?></td>
                </tr>
                <tr>
                    <td>মোবাইল নাম্বার</td>
                    <td >:  <?php echo $db_accountmobile; ?></td>
                <input type="hidden" name="account_mobile" id="account_mobile" value="<?php echo $db_accountmobile; ?>"/>
                </tr>
            </table>
            </td>
            <td width="40%">
                <table>
                    <tr>
                        <td colspan="">খুঁজুন:  <input type="text" class="box" style="width: 230px;" id="accountsearch" name="accountsearch" onkeyup="getAccount(this.value)" placeholder="টাইপ একাউন্ট নাম্বার"/>
                            <div id="accountfound"></div></td>
                    </tr>
                    <tr><td>একাউন্টধারীর ছবিঃ <img border="0" src="<?php echo $db_account_holder_picture; ?>" alt="account_holder_pic" width="100" height="100"></td></tr>

                </table>
            </td>
            </tr>

            <tr>                    
                <td colspan="2" style="padding-left: 250px; " ><?php
                                if ($account_status == 'active') {
                                    echo '<input class="btn" style =" font-size: 12px; width: 30%;" type="submit" name="submit_new_password" value="সেন্ড নিউ পাসওয়ার্ড"/>';
                                } else {
                                    echo '<input class="btn" style =" font-size: 12px; background-color:gray; width: 30%;" type="submit" name="submit_new_password" value="সেন্ড নিউ পাসওয়ার্ড" disabled />';
                                }
    ?>
                </td>                           
            </tr>
            </table>
        </form>
    </div>  
    <?php
} else {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 48%; float: left"><a href="crm_management.php"><b>ফিরে যান</b></a></div>
        <div style="text-align: right;padding-right: 35px;"><a href="close_account.php?action=new"></a>&nbsp;&nbsp;<a href=""></a></div>
    </div>
    <div>           
        <form name="account_close_form" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">	
            <table class="formstyle"  style=" width: 85%; height: 300px;">          
                <tr>
                    <th style="text-align: center" colspan="2"><h1>একাউন্ট পাসওয়ার্ড পুনরুদ্ধার</h1></th>
                </tr>                  
                <tr>
                    <td width="60%" style="text-align: center;"><b>
                            <span style="color:gray;font-size:16px;">
                                <blink><?php
    if (!empty($update_msg)) {
        echo $update_msg;
    }
    ?></blink></span></b>
                    </td>
                    <td width="40%">
                        <table>
                            <tr>
                                <td colspan="">খুঁজুন:  <input type="text" class="box" style="width: 230px;" id="accountsearch" name="accountsearch" onkeyup="getAccount(this.value)" placeholder="টাইপ একাউন্ট নাম্বার"/>
                                    <div id="accountfound"></div></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </div>
<?php
}
include_once 'includes/footer.php';
?> 
