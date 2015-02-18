<?php
include_once 'includes/session.inc';
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include_once 'includes/makeAccountNumbers.php';
include_once 'includes/checkAccountNo.php';
include_once 'includes/email_conf.php';
include_once './includes/sms_send_function.php';

function showPowerHeads() {
    echo "<option value=0> -সিলেক্ট করুন- </option>";
    $sql_office = mysql_query("SELECT * FROM office WHERE office_type='pwr_head' ORDER BY office_name;");
    while ($headrow = mysql_fetch_assoc($sql_office)) {
        echo "<option value=" . $headrow['account_number'] . ">" . $headrow['office_name'] . "</option>";
    }
}

if (isset($_POST['submit']) || isset($_POST['retry'])) {

    $user_username = $_POST['user_username'];
    $account_name = $_POST['name'];
    $account_number = $_POST['acc_num'];
    $account_email = $_POST['email'];
    $account_mobile = $_POST['mobile'];
    $account_mobile1 = "88" . $account_mobile;
    $account_number1 = checkAccountNo($account_number);
    $emailusername = str_replace("-", "", $account_number1);
    $ripdemailid = $emailusername . "@ripduniversal.com";
    // ****************** password create & send ******************************************
    $pass = getRandomPassword();
    $passwrd = md5($pass);
    
    $send_sms_content = "Dear User,Your\nACC.# $account_number\nUsername: $user_username\nRIPD email: $ripdemailid\nPassword: $pass\nThanks";
    $sendResult = SendSMSFuntion($account_mobile1, $send_sms_content);
    $sendStatus = substr($sendResult, 0, 2);
    
    if ($sendStatus == 'OK') {
        mysql_query("START TRANSACTION");
        //************************* create official email *************************************************

        $email_create_status = CreateEmailAccount($emailusername, $pass);
        if ($email_create_status == '777') {
            $ripdemailid = $emailusername . "@ripduniversal.com";
        } else {
            $ripdemailid = "";
        }

        $sel_securityroles = mysql_query("SELECT * FROM security_roles WHERE role_name= 'proprietor' ");
        $securityrolesrow = mysql_fetch_assoc($sel_securityroles);
        $roleid = $securityrolesrow['idsecurityrole'];
        $ins_cfsuser = mysql_query("INSERT INTO cfs_user (user_name, password, blocked, account_name, account_number, account_open_date, mobile, email, ripd_email, cfs_account_status, security_roles_idsecurityrole, user_type)
                                                                            VALUES ('$user_username', '$passwrd', '0', '$account_name', '$account_number1', NOW(), '$account_mobile1', '$account_email','$ripdemailid', 'active', $roleid, 'owner')") or exit(mysql_error());
        $cfs_user_id = mysql_insert_id();
        $pwrHeadAccNo = $_POST['powerStore_accountNumber'];
        $sel_pwrID = mysql_query("SELECT * FROM office WHERE account_number = '$pwrHeadAccNo' ");
        $officerow = mysql_fetch_assoc($sel_pwrID);
        $db_pwrOfficeID = $officerow['idOffice'];
        $db_pwrHeadname = $officerow['office_name'];
        $sql_pro_ins = mysql_query("INSERT INTO proprietor_account (powerStore_name, powerStore_accountNumber, Office_idOffice, cfs_user_idUser)
                                                VALUES ('$db_pwrHeadname', '$pwrHeadAccNo',$db_pwrOfficeID,  $cfs_user_id)") or exit(mysql_error());
        $propreitor_account_id = mysql_insert_id();
        $encodedID = base64_encode($propreitor_account_id);
        if ($ins_cfsuser && $sql_pro_ins) {
            mysql_query("COMMIT");
            header( 'Location: create_proprietor_account_inner.php?proID='.$encodedID);
        } else {
            mysql_query("ROLLBACK");
            $msg = "দুঃখিত, প্রোপ্রাইটার তৈরি হয়নি";
        }
    } else {
        $smserror = "দুঃখিত,একাউন্টধারীর মোবাইল নাম্বারে মেসেজ পাঠানো যাচ্ছে না, পুনরায় চেষ্টা করুন অথবা মেন্যুয়াল পাসওয়ার্ড দিয়ে সেভ করুন";
        $error = 1;
    }

    //echo $email_create; //make decision to give error message
}
if (isset($_POST['submitwithpass'])) {
    $user_username = $_POST['user_username'];
    $account_name = $_POST['name'];
    $account_number = $_POST['acc_num'];
    $account_email = $_POST['email'];
    $account_mobile = $_POST['mobile'];
    $account_mobile1 = "88" . $account_mobile;
    $account_number1 = checkAccountNo($account_number);
    $emailusername = str_replace("-", "", $account_number1);
    $ripdemailid = $emailusername . "@ripduniversal.com";
    $pass = $_POST['reap_password'];
    $passwrd = md5($pass);
    
    mysql_query("START TRANSACTION");
    //************************* create official email *************************************************

    $email_create_status = CreateEmailAccount($emailusername, $pass);
    if ($email_create_status == '777') {
        $ripdemailid = $emailusername . "@ripduniversal.com";
    } else {
        $ripdemailid = "";
    }

    $sel_securityroles = mysql_query("SELECT * FROM security_roles WHERE role_name= 'proprietor' ");
    $securityrolesrow = mysql_fetch_assoc($sel_securityroles);
    $roleid = $securityrolesrow['idsecurityrole'];
    $ins_cfsuser = mysql_query("INSERT INTO cfs_user (user_name, password, blocked, account_name, account_number, account_open_date, mobile, email, ripd_email, cfs_account_status, security_roles_idsecurityrole, user_type)
                                                                            VALUES ('$user_username', '$passwrd', '0', '$account_name', '$account_number1', NOW(), '$account_mobile1', '$account_email','$ripdemailid', 'active', $roleid, 'owner')") or exit(mysql_error());
    $cfs_user_id = mysql_insert_id();
    $pwrHeadAccNo = $_POST['powerStore_accountNumber'];
    $sel_pwrID = mysql_query("SELECT * FROM office WHERE account_number = '$pwrHeadAccNo' ");
    $officerow = mysql_fetch_assoc($sel_pwrID);
    $db_pwrOfficeID = $officerow['idOffice'];
    $db_pwrHeadname = $officerow['office_name'];
    $sql_pro_ins = mysql_query("INSERT INTO proprietor_account (powerStore_name, powerStore_accountNumber, Office_idOffice, cfs_user_idUser)
                                                VALUES ('$db_pwrHeadname', '$pwrHeadAccNo',$db_pwrOfficeID,  $cfs_user_id)") or exit(mysql_error());
    $propreitor_account_id = mysql_insert_id();
    $encodedID = base64_encode($propreitor_account_id);
    if ($ins_cfsuser && $sql_pro_ins) {
        mysql_query("COMMIT");
        header('Location: create_proprietor_account_inner.php?proID=' . $encodedID);
    } else {
        mysql_query("ROLLBACK");
        $msg = "দুঃখিত, প্রোপ্রাইটার তৈরি হয়নি";
    }
}
?>
<?php 
include_once 'includes/header.php';
?>
<title>ক্রিয়েট প্রোপ্রাইটার অ্যাকাউন্ট</title>
<style type="text/css">@import "css/bush.css";</style>
<script>
function goBack()
    {
        window.history.go(-1);
    }
function numbersonly(e)
    {
        var unicode = e.charCode ? e.charCode : e.keyCode
        if (unicode != 8)
        { //if the key isn't the backspace key (which we should allow)
            if (unicode < 48 || unicode > 57) //if not a number
                return false //disable key press
        }
    }
function checkIt(evt) // float value-er jonno***********************
    {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 8 || (charCode > 47 && charCode < 58) || charCode == 46) {
            status = "";
            return true;
        }
        status = "This field accepts numbers only.";
        return false;
    }
function checkPass(passvalue) // check password in repeat
    {
        var user_password = document.getElementById('user_password').value;
        if (user_password != passvalue)
        {
            document.getElementById('reap_password').focus();
            document.getElementById('passcheck').style.color = 'red';
            document.getElementById('passcheck').innerHTML = "পাসওয়ার্ড সঠিক হয় নি";
        }
        else {
            document.getElementById('passcheck').style.color = 'green';
            document.getElementById('passcheck').innerHTML = "OK";
        }
    }
function showAccountNo(account)
    {
        document.getElementById('powerStore_accountNumber').value = account;
    }

function beforeSave()
    {
        if ((document.getElementById('usernamecheck').innerHTML == "") && (document.getElementById('powerStore_accountNumber').value != ""))
        {
            document.getElementById('save').readonly = false;
            return true;
        }
        else {
            document.getElementById('save').readonly = true;
            return false;
        }
    }
function beforeSave2()
    {
        if ((document.getElementById('usernamecheck').innerHTML == "") && (document.getElementById('powerStore_accountNumber').value != "") && (document.getElementById('passcheck').innerHTML == "OK"))
        {
            document.getElementById('save2').readonly = false;
            return true;
        }
        else {
            document.getElementById('save2').readonly = true;
            return false;
        }
    }
function beforeSaveRetry()
    {
        if ((document.getElementById('usernamecheck').innerHTML == "") && (document.getElementById('powerStore_accountNumber').value != "") && (document.getElementById('passcheck').innerHTML == ""))
        {
            document.getElementById('retry').readonly = false;
            return true;
        }
        else {
            document.getElementById('retry').readonly = true;
            return false;
        }
    }
function userminlength(username)
{
    if(username.length < 5)
        {
            document.getElementById('user_username').focus();
            document.getElementById('minlegthcheck').innerHTML= "কমপক্ষে ৫ অক্ষর হতে হবে";
        }
         else{
           document.getElementById('minlegthcheck').innerHTML= "";
        }
}
function passminlength(pass)
{
    if(pass.length < 10)
        {
            document.getElementById('user_password').focus();
            document.getElementById('minlengtherror').innerHTML= "কমপক্ষে ১০ অক্ষর হতে হবে";
        }
         else{
            document.getElementById('minlengtherror').innerHTML= "";
        }
}
</script>
<script>
    function check(str) // for currect email address form checking
    {
        if (str.length == 0)
        {
            document.getElementById("error_msg").innerHTML = "";
            document.getElementById("error_msg").style.border = "0px";
            return;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("error_msg").innerHTML = xmlhttp.responseText;
                document.getElementById("error_msg").style.display = "inline";
            }
        }
        xmlhttp.open("GET", "includes/check.php?x=" + str, true);
        xmlhttp.send();
    }

function checkUserName(uname)
    {
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("usernamecheck").innerHTML = xmlhttp.responseText;
                document.getElementById('save').disabled = false;
            }
        }
        xmlhttp.open("GET", "includes/checkUserName.php?strkey=" + uname, true);
        xmlhttp.send();
    }
function validateMobile(mblno)
    {
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("mblValidationMsg").innerHTML = xmlhttp.responseText;
                var message = document.getElementById("mblValidationMsg").innerText;
                if (message != "OK")
                {
                    document.getElementById('mobile').focus();
                }
                //document.getElementById('save').disabled= false;
            }
        }
        xmlhttp.open("GET", "includes/mobileNoValidation.php?mobile=" + mblno, true);
        xmlhttp.send();
    }
</script>
<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a onclick="goBack();" style="cursor: pointer;"><b><u>ফিরে যান</u></b></a></div> 
        <div>            
            <form method="POST" action="">
                <?php
                if ((isset($_POST['submit']) || isset($_POST['retry'])) && $error == 1) {
                    $input = 'proprietor';
                    $arrayAccountType = array('employee' => 'কর্মচারীর', 'customer' => 'কাস্টমারের', 'proprietor' => 'প্রোপ্রাইটারের');
                    $showAccountType = $arrayAccountType[$input];
                    echo "<table  class='formstyle'>          
                    <tr><th colspan='4' style='text-align: center;'>$showAccountType মূল তথ্য</th></tr>  
                   <tr><td colspan ='2' style='text-align: center;'><font color='read'>$smserror</font></td></tr>
                    <tr>
                        <td >$showAccountType নাম</td>
                        <td>:   <input class='box' type='text' id='name' name='name' value='$account_name'/><em2> *</em2></td>			
                    </tr>
                    <tr>
                        <td >একাউন্ট নাম্বার</td>
                        <td>:   <input class='box' type='text' id='acc_num' name='acc_num' readonly value='$account_number1' /></td>			
                    </tr>
                    <tr>
                        <td >ই মেইল</td>
                       <td>:   <input class='box' type='text' id='email' name='email' onblur='check(this.value)' value='$account_email' /> <em>ইংরেজিতে লিখুন</em> <span id='error_msg' style='margin-left: 5px'></span></td>			
                    </tr>
                    <tr>
                        <td >মোবাইল</td>
                        <td>: <input class='box' type='text' id='mobile' name='mobile' onkeypress=' return numbersonly(event)' onblur='validateMobile(this.value)' style='font-size:16px;' placeholder='01XXXXXXXXX' value='$account_mobile' />
                        <em2>*</em2><em>ইংরেজিতে লিখুন</em> <span id='mblValidationMsg'></span></td>		
                    </tr>
                   <tr>
                        <td>ইউজারের নাম</td>
                      <td>: <input class='box' type='text' id='user_username' name='user_username' onblur='userminlength(this.value),checkUserName(this.value)' value='$user_username' />
                      <em2>*</em2><em>ইংরেজিতে লিখুন</em></br><span style='color:red;' id='usernamecheck'></span><span style='color:red;' id='minlegthcheck'></span></td>
                    </tr>   
                    <tr>
                        <td>পাওয়ার স্টোরের নাম</td>
                        <td >:  <select  class='box' name='powerStore_name' style='height:20px;'onchange='showAccountNo(this.value)'>";
                    showPowerHeads();
                    echo "</select><em2> *</em2>	
                        </td>
                        </tr>
                        <tr>
                        <td>পাওয়ার স্টোরের একাউন্ট নং </td>
                        <td>:  <input class='box' type='text' readonly='' id='powerStore_accountNumber' name='powerStore_accountNumber' /></td>	
                    </tr>
                    <tr>
                        <td>পাসওয়ার্ড</td>
                       <td>:   <input class='box' type='password' id='user_password' name='user_password' maxlength='15' onblur='passminlength(this.value)'/><em2>*</em2><em>ইংরেজিতে লিখুন</em></br><span style='color:red;' id='minlengtherror'></span></td>
                    </tr>
                    <tr>
                        <td>কনফার্ম পাসওয়ার্ড</td>
                       <td>:   <input class='box' type='password' id='reap_password' name='reap_password' onkeyup='checkPass(this.value);'/> <em>ইংরেজিতে লিখুন</em> <span id='passcheck'></span></td>
                    </tr>
                    <tr>                    
                        <td colspan='4' style='padding-left: 200px; '>
                        <input class='btn' style ='font-size: 12px;width:200px;' type='submit' name='submitwithpass' id='save2' value='সেভ' readonly onclick='return beforeSave2();'/>                   
                        <input class='btn' style ='font-size: 12px;width:200px;' type='submit' name='retry' id='retry' value='রি ট্রাই' onclick='return beforeSaveRetry()'/>
                    </td>                           
                    </tr>             
                </table>";
                } else {
                    $input = 'proprietor';
                    $arrayAccountType = array('employee' => 'কর্মচারীর', 'customer' => 'কাস্টমারের', 'proprietor' => 'প্রোপ্রাইটারের');
                    $showAccountType = $arrayAccountType[$input];
                    echo "<table  class='formstyle'>          
                    <tr><th colspan='4' style='text-align: center;'>$showAccountType মূল তথ্য</th></tr>  
                    <tr>
                        <td >$showAccountType নাম</td>
                        <td>:   <input class='box' type='text' id='name' name='name'/><em2> *</em2></td>			
                    </tr>
                    <tr>
                        <td >একাউন্ট নাম্বার</td>
                        <td>:   <input class='box' type='text' id='acc_num' name='acc_num' readonly value= " . getPersonalAccount() . " /></td>			
                    </tr>
                    <tr>
                        <td >ই মেইল</td>
                       <td>:   <input class='box' type='text' id='email' name='email' onblur='check(this.value)' /> <em>ইংরেজিতে লিখুন</em> <span id='error_msg'></span></td>			
                    </tr>
                    <tr>
                        <td >মোবাইল</td>
                        <td>: <input class='box' type='text' id='mobile' name='mobile' onkeypress=' return numbersonly(event)' onblur='validateMobile(this.value)' style='font-size:16px;' placeholder='01XXXXXXXXX' />
                        <em2>*</em2><em>ইংরেজিতে লিখুন</em> <span id='mblValidationMsg'></span></td>		
                    </tr>
                   <tr>
                        <td>ইউজারের নাম</td>
                      <td>:   <input class='box' type='text' id='user_username' name='user_username' onblur='userminlength(this.value),checkUserName(this.value)' />
                      <em2>*</em2><em>ইংরেজিতে লিখুন</em></br><span style='color:red;' id='usernamecheck'></span><span style='color:red;' id='minlegthcheck'></span></td>
                    </tr>   
                    <tr>
                        <td>পাওয়ার স্টোরের নাম</td>
                        <td >:  <select  class='box' name='powerStore_name' style='height:22px;'onchange='showAccountNo(this.value)'>";
                    showPowerHeads();
                    echo "</select><em2> *</em2>	
                        </td>
                        </tr>
                        <tr>
                        <td>পাওয়ার স্টোরের একাউন্ট নং </td>
                        <td>:  <input class='box' type='text' readonly='' id='powerStore_accountNumber' name='powerStore_accountNumber' /></td>	
                    </tr>
                    <tr>                    
                        <td colspan='4' style='padding-left: 250px; '>
                   <input class='btn' style ='font-size: 12px;width:200px;' type='submit' name='submit' id='save' value='সেভ এন্ড সেন্ড পাসওয়ার্ড' readonly onclick='return beforeSave();'/>
                    </td>                           
                    </tr>             
                </table>";
                }
                ?>
            </form>
        </div>
    </div>      
</div> 
<?php
include_once 'includes/footer.php';
?>