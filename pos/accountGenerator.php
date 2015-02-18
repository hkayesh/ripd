<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
include_once '../includes/email_conf.php';
include_once '../includes/sms_send_function.php';
$msg = "";
function rendomgenerator() // 4 digit + 4 digit random no generator*******************************
{
    $str_random_part=""; 
    for($i=0;$i<2;$i++)
        {
            $str_random_no=(string)mt_rand (0 ,999 );
            $str_random= str_pad($str_random_no,3, "0", STR_PAD_LEFT);
            $str_random_part = $str_random_part."-".$str_random;
        }
        $str_random_no2=(string)mt_rand (0 ,9999 );
        $str_random2 = str_pad($str_random_no2,4, "0", STR_PAD_LEFT);
        $str_random_part = $str_random_part."-".$str_random2;
        return $str_random_part;
}
function getPersonalAccount() // for employee, customers account number generate****************************************
{
    $str_acc= "ac";
    $forwhileloop = 1;
    while($forwhileloop==1)
    {
            $randompart = rendomgenerator();
            $str_acc = $str_acc.$randompart;
           $result= mysql_query("SELECT * FROM `cfs_user` WHERE account_number='$str_acc';");
            if (mysql_fetch_array($result)=="" )
            {
                $forwhileloop = 0;
                break;
            }
    }
    return $str_acc;
}
function checkAccountNo($accNo)
{
    $forWhileLoop = 1;
    while($forWhileLoop == 1)
    {
        $cfs_query = mysql_query("SELECT * FROM cfs_user WHERE account_number= '$accNo'");
        $y = mysql_num_rows($cfs_query);
        if($y > 0)
        {
           $accNo = getPersonalAccount();
        }
         else {
             $forWhileLoop = 0;
             break;
         }
     }
     return $accNo;
}
function getPackages()
{
     echo "<option value=0> -সিলেক্ট করুন- </option>";
    $result= mysql_query("SELECT * FROM account_type ORDER BY account_minPV_value ");
    while ( $pckgrow = mysql_fetch_array($result) ){
        echo "<option value=" . $pckgrow['idAccount_type'] . ">" . $pckgrow['account_name'] . "</option>";
    }
}
if(isset($_POST['openaccount']))
{
        $user_username = $_POST['user_username'];
        $account_name = $_POST['cust_name'];
        $referer_account = $_POST['referer_account'];
        $account_type = $_POST['account_type'];
        $account_number = $_POST['acc_num'];
        $account_email = $_POST['email'];
        $account_mobile = $_POST['mobile'];
        $account_mobile1 = "88".$account_mobile;
        $account_number1 = checkAccountNo($account_number);
        $emailusername = str_replace("-", "", $account_number1);
        $ripdemailid = $emailusername . "@ripduniversal.com";
         //  ****************** password create & send ******************************************
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
            $ripdemailid = "";}
            $roleid = 0;
            $sel_securityroles = mysql_query("SELECT * FROM security_roles WHERE role_name= 'customer' ");
            $securityrolesrow = mysql_fetch_assoc($sel_securityroles);
            $roleid =$securityrolesrow['idsecurityrole'];
            
            $ins_cfsuser=mysql_query("INSERT INTO cfs_user (user_name, password, blocked, account_name, account_number, account_open_date, mobile, email, ripd_email,cfs_account_status, security_roles_idsecurityrole, user_type)
                                                                        VALUES ('$user_username', '$passwrd', '0', '$account_name', '$account_number1', NOW(), '$account_mobile1', '$account_email', '$ripdemailid','active', $roleid,'customer')") or exit(mysql_error()." sorry");
            $cfs_user_id = mysql_insert_id();
       
             // **************************get referer ID*****************************
                    $getreferer_sql = mysql_query("SELECT * FROM cfs_user WHERE account_number = '$referer_account' ");
                    $refererrow = mysql_fetch_assoc($getreferer_sql);
                    $db_referid = $refererrow['idUser'];
           //*************************cutomer_account table-e insert*************
                    $ins_custaccount=mysql_query("INSERT INTO customer_account (opening_pin_no, referer_id, Account_type_idAccount_type, Designation_idDesignation, cfs_user_idUser)
                                            VALUES (0, $db_referid, $account_type, 1, $cfs_user_id )") or exit(mysql_error());
                    
                    if ($ins_cfsuser && $ins_custaccount ) {
                        mysql_query("COMMIT");
                        $msg = "কর্মচারী তৈরি হয়েছে";
                    } else {
                        mysql_query("ROLLBACK");
                        $msg = "দুঃখিত, কর্মচারী তৈরি হয়নি";
                    }
        }
        else {
        $msg = "দুঃখিত,একাউন্টধারীর মোবাইল নাম্বারে মেসেজ পাঠানো যাচ্ছে না, পুনরায় চেষ্টা করুন ";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
<script>
    function numbersonly(e)
    {
        var unicode = e.charCode ? e.charCode : e.keyCode
        if (unicode != 8)
        { //if the key isn't the backspace key (which we should allow)
            if (unicode < 48 || unicode > 57) //if not a number
                return false //disable key press
        }
    }

    function beforeSave()
    {
        if ((document.getElementById('usernamecheck').innerHTML == "")
                && (document.getElementById('user_username').value != "")
                && (document.getElementById('cust_name').value != "")
                && (document.getElementById('pckgvalue').value != "")
                && (document.getElementById('mblValidationMsg').innerHTML == "")
                && (document.getElementById('showReferer').innerHTML != "দুঃখিত, ভুল অ্যাকাউন্ট নাম্বার"))
        {
            document.getElementById('openaccount').readonly = false;
            return true;
        }
        else {
            document.getElementById('openaccount').readonly = true;
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
        xmlhttp.open("GET", "../includes/check.php?x=" + str, true);
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
            }
        }
        xmlhttp.open("GET", "../includes/checkUserName.php?strkey=" + uname, true);
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
            }
        }
        xmlhttp.open("GET", "../includes/mobileNoValidation.php?mobile=" + mblno, true);
        xmlhttp.send();
    }
function getPackageValue(pckg)
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
                document.getElementById("pckgvalue").value = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "includes/getPackageValue.php?type=1&pckgID="+pckg, true);
        xmlhttp.send();
}
function showReferer(acNo)
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
                document.getElementById("showReferer").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "includes/getPackageValue.php?type=2&acNo="+acNo, true);
        xmlhttp.send();
}
</script>
</head>
<body>
    <div id="maindiv">
        <div align="center" style="width: 100%;height: 480px;font-family: SolaimanLipi !important; padding: 10px;color: #000;">
            <?php if($msg !="") { ?>
            <div align="center" style="width: 100%;height: 200px;font-family: SolaimanLipi !important; padding: 10px;color: green;">
                <?php echo $msg;?>
            </div>
            <?php }
                else {?>
            <form action="" onsubmit="return beforeSave();" method="post">
        <table style="width: 97%;height: 450px;font-family: SolaimanLipi !important; padding: 10px;color: #000;">
            <tr>
                <td style="text-align: right;">প্যাকেজের নাম</td>
                <td colspan="3">: <select class="box" name="account_type" style="width: 150px;font-family: SolaimanLipi !important;" onchange="getPackageValue(this.value)" ><?php getPackages();?></select><em> * </em>
                    প্যাকেজ মূল্য <input id="pckgvalue" style="width: 50px;border: 0px;color: #0033cc;font-size: 16px;" /> টাকা</td>
            </tr>
            <tr>
                <td style="text-align: right;">কাস্টমারের নাম</td>
                <td>: <input class="box" type="text" name="cust_name"  id="cust_name"/><em> *</em></td>
                <td style="text-align: right;">রেফারের একাউন্ট নং</td>
                <td>: <input class="box" type="text" name="referer_account"  id="referer_account" onblur="showReferer(this.value);" maxlength="15" />
                    <em> *</em></br><span id='showReferer' style="color: #0033cc;"></span></td>
            </tr>
            <tr>
                   <td style="text-align: right;">মোবাইল নং</td>
                   <td>: <input class="box" type="text" id='mobile' name='mobile' onkeypress=' return numbersonly(event)' onblur='validateMobile(this.value)' placeholder='01XXXXXXXXX' />
                       <em> *</em><em>ইংরেজিতে লিখুন</em></br><span id='mblValidationMsg'></span></td>	
                    <td style="text-align: right;">ইমেল</td>
                   <td>: <input class="box" type="text" id='email' name='email' onblur='check(this.value)'  /><em>ইংরেজিতে লিখুন</em></br><span id='error_msg' style='margin-left: 5px'></span></td>
               </tr>
               <tr>
                   <td style="text-align: right;">ইউজার নাম</td>
                   <td>: <input class="box" type="text" id='user_username' name='user_username' onblur='userminlength(this.value),checkUserName(this.value)' />
                       <em> *</em><em>ইংরেজিতে লিখুন</em></br><span style='color:red;' id='usernamecheck'></span><span style='color:red;' id='minlegthcheck'></span></td>
                   <td style="text-align: right;">একাউন্ট নাম্বার</td>
                   <td>: <input class='box' type='text' id='acc_num' name='acc_num' readonly value= "<?php echo getPersonalAccount(); ?>" /></td>
               </tr>
        </table>
        <input type="submit" readonly value="একাউন্ট খুলুন" name="openaccount" id="openaccount" style="font-family: SolaimanLipi !important;"/>
    </form>
                <?php }?>
    </div>
    </div>
</body>
</html>