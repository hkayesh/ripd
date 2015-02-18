<?php
error_reporting(0);
//include_once 'includes/session.inc';
include_once 'includes/MiscFunctions.php';
include_once 'includes/makeAccountNumbers.php';
include_once 'includes/checkAccountNo.php';
include_once 'includes/email_conf.php';
include_once './includes/sms_send_function.php';
function showRoles() {
    echo "<option value=0> -সিলেক্ট করুন- </option>";
    $sql_office = mysql_query("SELECT * FROM security_roles WHERE role_type='emp' ORDER BY role_name;");
    while ($headrow = mysql_fetch_assoc($sql_office)) {
        echo "<option value=" . $headrow['idsecurityrole'] . ">" . $headrow['role_name'] . "</option>";
    }
}

if (isset($_POST['submit']) || isset($_POST['retry']))
        {
        $user_username = $_POST['user_username'];
        $account_name = $_POST['name'];
        $account_number = $_POST['acc_num'];
        $account_email = $_POST['email'];
        $account_mobile = $_POST['mobile'];
        $account_mobile1 = "88" . $account_mobile;
        $account_number1 = checkAccountNo($account_number);
        $emailusername = str_replace("-", "", $account_number1);
        $ripdemailid = $emailusername . "@ripduniversal.com";
        $p_employee_type = $_POST['employee_type']; 
        $p_joiningdate = $_POST['date'];
        $roleid = $_POST['role'];
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
            $ins_cfsuser=mysql_query("INSERT INTO cfs_user (user_name, password, blocked, account_name, account_number, account_open_date, mobile, email, ripd_email, cfs_account_status, security_roles_idsecurityrole,user_type)
                                                                        VALUES ('$user_username', '$passwrd', '0', '$account_name', '$account_number1', NOW(), '$account_mobile1', '$account_email', '$ripdemailid','active', $roleid, '$p_employee_type')") or exit(mysql_error()." sorry");
             $cfs_user_id = mysql_insert_id();
                    
                    $ins_employee = mysql_query("INSERT INTO employee (status, employee_type, joining_date, posting_type, emp_ons_id, pay_grade_id, cfs_user_idUser)
                                           VALUES ('contract', '$p_employee_type', '$p_joiningdate' ,'acting', 0, 0, '$cfs_user_id')") or exit(mysql_error()."step2");
                    $employee_id = mysql_insert_id();                  
                    $empinfo_ins = mysql_query("INSERT INTO employee_information (Employee_idEmployee) VALUES ($employee_id)") or exit(mysql_error()."step6");
                    $employee_info_id = mysql_insert_id();
                    $encodedID = base64_encode($employee_info_id);
                    
                     if ($ins_cfsuser && $ins_employee && $empinfo_ins) {
                        mysql_query("COMMIT");
                        echo "<script>alert('কর্মচারী তৈরি হয়েছে')</script>";
                        header( 'Location: create_employee_account_inner.php?empInfoID='.$encodedID);
                    } else {
                        mysql_query("ROLLBACK");
                        echo "<script>alert('দুঃখিত,কর্মচারী তৈরি হয়নি')</script>";
                    }
      } else {
        $smserror = "দুঃখিত,একাউন্টধারীর মোবাইল নাম্বারে মেসেজ পাঠানো যাচ্ছে না, পুনরায় চেষ্টা করুন অথবা মেন্যুয়াল পাসওয়ার্ড দিয়ে সেভ করুন";
        $error = 1;
    }
}

if (isset($_POST['submitwithpass']))
        {
        $user_username = $_POST['user_username'];
        $account_name = $_POST['name'];
        $account_number = $_POST['acc_num'];
        $account_email = $_POST['email'];
        $account_mobile = $_POST['mobile'];
        $account_mobile1 = "88" . $account_mobile;
        $account_number1 = checkAccountNo($account_number);
        $emailusername = str_replace("-", "", $account_number1);
        $ripdemailid = $emailusername . "@ripduniversal.com";
        $p_employee_type = $_POST['employee_type']; 
        $roleid = $_POST['role'];
        $p_joiningdate = $_POST['date'];
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
             
             $ins_cfsuser=mysql_query("INSERT INTO cfs_user (user_name, password, blocked, account_name, account_number, account_open_date, mobile, email, ripd_email, cfs_account_status, security_roles_idsecurityrole,user_type)
                                                                        VALUES ('$user_username', '$passwrd', '0', '$account_name', '$account_number1', NOW(), '$account_mobile1', '$account_email', '$ripdemailid','active', $roleid, '$p_employee_type')") or exit(mysql_error()." sorry");
             $cfs_user_id = mysql_insert_id();
                    
                    $ins_employee = mysql_query("INSERT INTO employee (status, employee_type, joining_date, posting_type, emp_ons_id, pay_grade_id, cfs_user_idUser)
                                                                                VALUES ('contract', '$p_employee_type','$p_joiningdate' ,'acting', 0, 0, '$cfs_user_id')") or exit(mysql_error());
                    $employee_id = mysql_insert_id();
                         
                    $empinfo_ins = mysql_query("INSERT INTO employee_information (Employee_idEmployee) VALUES ($employee_id)")or exit(mysql_error());
                    $employee_info_id = mysql_insert_id();
                    $encodedID = base64_encode($employee_info_id);
                     if ($ins_cfsuser && $ins_employee && $empinfo_ins) {
                        mysql_query("COMMIT");
                        echo "<script>alert('কর্মচারী তৈরি হয়েছে')</script>";
                        header( 'Location: create_employee_account_inner.php?empInfoID='.$encodedID);
                    } else {
                        mysql_query("ROLLBACK");
                       echo "<script>alert('দুঃখিত,কর্মচারী তৈরি হয়নি')</script>";
                    }
}

?>
<?php include_once 'includes/header.php';?>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>
<script>
    window.onclick = function()
    {
        new JsDatePick({
            useMode: 2,
            target: "date",
            dateFormat: "%Y-%m-%d"
        });
    }
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

    function beforeSave()
    {
        if ((document.getElementById('usernamecheck').innerHTML == "")
                && (document.getElementById('employee_type').value != 0)
                && (document.getElementById('role').value != 0))
        {
            document.getElementById('save').readonly = false;
            return true;
        }
        else {
            document.getElementById('save').readonly = true;
            alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
            return false;
        }
    }
    function beforeSave2()
    {
        if ((document.getElementById('usernamecheck').innerHTML == "")
                && (document.getElementById('employee_type').value != 0)
                && (document.getElementById('role').value != 0)
                && (document.getElementById('passcheck').innerHTML == "OK"))
        {
            document.getElementById('save2').readonly = false;
            return true;
        }
        else {
            document.getElementById('save2').readonly = true;
            alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
            return false;
        }
    }
    function beforeSaveRetry()
    {
        if ((document.getElementById('usernamecheck').innerHTML == "")
                && (document.getElementById('employee_type').value != 0)
                && (document.getElementById('role').value != 0)
                && (document.getElementById('passcheck').innerHTML == ""))
        {
            document.getElementById('retry').readonly = false;
            return true;
        }
        else {
            document.getElementById('retry').readonly = true;
            alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
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
function clearreappass()
{
    document.getElementById('reap_password').value="";
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
                if (message != "")
                {
                    document.getElementById('mobile').focus();
                }
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
            <form method="POST" id="employee_form" name="employee_form" action="">
                <?php
                 if ((isset($_POST['submit']) || isset($_POST['retry'])) && $error == 1) {
                    
                    echo "
                    <table  class='formstyle'>          
                    <tr><th colspan='4' style='text-align: center;'> মূল তথ্য</th></tr>  
                         <tr><td colspan ='2' style='text-align: center;'><font color='read'>$smserror</font></td></tr>
                    <tr>
                        <td >নাম</td>
                        <td>:   <input class='box' type='text' id='name' name='name' value='$account_name'/><em2> *</em2></td>			
                    </tr>
                    <tr>
                        <td >একাউন্ট নাম্বার</td>
                        <td>:   <input class='box' type='text' id='acc_num' name='acc_num' readonly value= '$account_number1' /></td>			
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
                        <td colspan='2' ><hr /></td>
                    </tr>
                    <tr>
                        <td>কাজের ধরন</td>
                      <td>:   <select  class='box'  name='employee_type' id='employee_type' style =' font-size: 14px'>
                                <option value=0>-একটি নির্বাচন করুন-</option>
                                <option value='programmer'>প্রোগ্রামার</option>
                                <option value='presenter'>প্রেজেন্টার</option>
                                <option value='trainer'>ট্রেইনার</option>
                                <option value='traveller'>ট্র্যাভেলার</option>
                            </select><em2> *</em2></td>
                    </tr>   
                    <tr>
                        <td>যোগদানের তারিখ</td>
                        <td>: <input class='box' type='text' id='date' placeholder='Date' name='date' value='$p_joiningdate'/>
                        </td>            
                    </tr>
                    <tr>
                     <td>রোল</td>
                      <td>:   <select  class='box'  name='role' id='role' style =' font-size: 14px'>";
                      showRoles();
                        echo "</select><em2> *</em2></td>
                    </tr>   
                    <tr>
                        <td>পাসওয়ার্ড</td>
                       <td>: <input class='box' type='password' id='user_password' name='user_password' maxlength='15' onblur='passminlength(this.value)' onkeyup='clearreappass()' /><em2>*</em2><em>ইংরেজিতে লিখুন</em></br><span style='color:red;' id='minlengtherror'></span></td>
                    </tr>
                    <tr>
                        <td>কনফার্ম পাসওয়ার্ড</td>
                       <td>:   <input class='box' type='password' id='reap_password' name='reap_password' onkeyup='checkPass(this.value);'/> <em>ইংরেজিতে লিখুন</em> <span id='passcheck'></span></td>
                    </tr>
                    <tr>                    
                    <td colspan='4' style='padding-left: 250px; '>
                    <input class='btn' style ='font-size: 12px;width:200px;' type='submit' name='submitwithpass' id='save2' value='সেভ' readonly onclick='return beforeSave2();'/>                   
                        <input class='btn' style ='font-size: 12px;width:200px;' type='submit' name='retry' id='retry' value='রি ট্রাই' onclick='return beforeSaveRetry()'/>
                    </td>                           
                    </tr>             
                </table>";
                 } 
                 else {                  
                    echo "<table  class='formstyle'>          
                    <tr><th colspan='4' style='text-align: center;'> মূল তথ্য</th></tr>  
                    <tr>
                        <td > নাম</td>
                        <td>:   <input class='box' type='text' id='name' name='name'/><em2> *</em2></td>			
                    </tr>
                    <tr>
                        <td >একাউন্ট নাম্বার</td>
                        <td>:   <input class='box' type='text' id='acc_num' name='acc_num' readonly value= ".getPersonalAccount()." /></td>			
                    </tr>
                    <tr>
                        <td >ই মেইল</td>
                       <td>:   <input class='box' type='text' id='email' name='email' onblur='check(this.value)' /> <em>ইংরেজিতে লিখুন</em></br><span id='error_msg' style='margin-left: 5px'></span></td>			
                    </tr>
                    <tr>
                        <td >মোবাইল</td>
                        <td>: <input class='box' type='text' id='mobile' name='mobile' onkeypress=' return numbersonly(event)' onblur='validateMobile(this.value)' style='font-size:16px;' placeholder='01XXXXXXXXX' value='$account_mobile' />
                        <em2>*</em2><em>ইংরেজিতে লিখুন</em></br><span id='mblValidationMsg'></span></td>		
                    </tr>
                   <tr>
                        <td>ইউজারের নাম</td>
                      <td>:   <input class='box' type='text' id='user_username' name='user_username' onblur='userminlength(this.value),checkUserName(this.value)' />
                      <em2>*</em2><em>ইংরেজিতে লিখুন</em></br><span style='color:red;' id='usernamecheck'></span></br><span style='color:red;' id='minlegthcheck'></span></td>
                    </tr>   
                    <tr>
                        <td colspan='2' ><hr /></td>
                    </tr>
                    <tr>
                        <td>কাজের ধরন</td>
                      <td>:   <select  class='box'  name='employee_type' id='employee_type' style =' font-size: 14px'>
                                <option value=0>-একটি নির্বাচন করুন-</option>
                                <option value='programmer'>প্রোগ্রামার</option>
                                <option value='presenter'>প্রেজেন্টার</option>
                                <option value='trainer'>ট্রেইনার</option>
                                <option value='traveller'>ট্র্যাভেলার</option>
                            </select><em2> *</em2></td>
                    </tr>   
                    <tr>
                        <td>যোগদানের তারিখ</td>
                        <td>: <input class='box' type='text' id='date' placeholder='Date' name='date' value=''/>
                        </td>            
                    </tr>
                    <tr>
                     <td> রোল</td>
                      <td>:   <select  class='box'  name='role' id='role' style =' font-size: 14px'>";
                      showRoles();
                        echo "</select><em2> *</em2></td>
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
<?php include_once 'includes/footer.php';?>