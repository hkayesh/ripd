<?php
error_reporting(0);
include_once 'includes/session.inc';
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
        $p_employee_grade = $_POST['employee_grade'];
        $p_employee_salary = $_POST['salary'];
        $p_onsid = $_POST['ospID'];
        $p_postonsID = $_POST['post'];
        $p_posting_type = $_POST['posttype'];
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
                                           VALUES ('posting', '$p_employee_type', '$p_joiningdate' ,'$p_posting_type', '$p_onsid', '$p_employee_grade', '$cfs_user_id')") or exit(mysql_error()."step2");
                    $employee_id = mysql_insert_id();
                    // employee_posting table-e insert***********************
                    $ins_empposting = mysql_query("INSERT INTO employee_posting (posting_date, Employee_idEmployee, ons_relation_idons_relation, post_in_ons_idpostinons)
                                            VALUES (NOW(), $employee_id, $p_onsid, $p_postonsID)")or exit(mysql_error()."step3");
                    // update post_in_ons table***********************
                    $ins_postinons=mysql_query("UPDATE `post_in_ons` SET `free_post` = free_post-1,`used_post` = used_post+1 WHERE `idpostinons` =$p_postonsID")or exit(mysql_error()."step4");
                   //employee_salary table-e insert***************
                    $ins_empsalary= mysql_query("INSERT INTO employee_salary (total_salary, insert_date, user_id, pay_grade_idpaygrade)
                                            VALUES ('$p_employee_salary',NOW(), $employee_id, $p_employee_grade)")or exit(mysql_error()."step5");
                    
                    $empinfo_ins = mysql_query("INSERT INTO employee_information (Employee_idEmployee) VALUES ($employee_id)") or exit(mysql_error()."step6");
                    $employee_info_id = mysql_insert_id();
                    $encodedID = base64_encode($employee_info_id);
                    
                     if ($ins_cfsuser && $ins_employee && $ins_empposting && $ins_postinons && $ins_postinons && $ins_empsalary && $empinfo_ins) {
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
        $ripdemailid = $emailusername."@ripduniversal.com";
        $p_employee_type = $_POST['employee_type'];
        $p_employee_grade = $_POST['employee_grade'];
        $p_employee_salary = $_POST['salary'];
        $p_onsid = $_POST['ospID'];
        $p_postonsID = $_POST['post'];
        $p_posting_type = $_POST['posttype'];
        $p_joiningdate = $_POST['date'];
        $roleid = $_POST['role'];
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
                                                                                VALUES ('posting', '$p_employee_type','$p_joiningdate' ,'$p_posting_type', '$p_onsid', '$p_employee_grade', '$cfs_user_id')") or exit(mysql_error());
                    $employee_id = mysql_insert_id();
                    // employee_posting table-e insert***********************
                    $ins_empposting = mysql_query("INSERT INTO employee_posting ( posting_date, Employee_idEmployee, ons_relation_idons_relation, post_in_ons_idpostinons)
                                                                            VALUES (NOW(), $employee_id, $p_onsid, $p_postonsID)")or exit(mysql_error());
                    // update post_in_ons table***********************
                    $ins_postinons=mysql_query("UPDATE post_in_ons SET free_post = free_post-1,used_post = used_post+1 WHERE idpostinons =$p_postonsID")or exit(mysql_error());
                   //employee_salary table-e insert***************
                    $ins_empsalary= mysql_query("INSERT INTO employee_salary (total_salary, insert_date, user_id, pay_grade_idpaygrade)
                                                                        VALUES ('$p_employee_salary',NOW(), $employee_id, $p_employee_grade)")or exit(mysql_error());
                    
                    $empinfo_ins = mysql_query("INSERT INTO employee_information (Employee_idEmployee) VALUES ($employee_id)")or exit(mysql_error());
                    $employee_info_id = mysql_insert_id();
                    $encodedID = base64_encode($employee_info_id);
                     if ($ins_cfsuser && $ins_employee && $ins_empposting && $ins_postinons && $ins_postinons && $ins_empsalary && $empinfo_ins) {
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
<title>ক্রিয়েট কর্মচারী অ্যাকাউন্ট</title>
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

    function checkSalaryRange(sal)
    {
        var range = document.getElementById('SalaryRange').innerText;
        var myarr = range.split("-");
        var min = myarr[0];
        var max = myarr[1];
        var sal = Number(sal);
        if ((sal <= max) && (sal >= min))
        {
            document.getElementById('showerror').innerHTML = "";
        }
        else {
            document.getElementById('showerror').innerHTML = "দুঃখিত, রেঞ্জের মধ্যেই বেতন দিন";
        }
    }
    function setParent(office, offid)
    {
        document.getElementById('officesearch').value = office;
        document.getElementById('ospID').value = offid;
        document.getElementById('offResult').style.display = "none";
    }
    function showTypeBox()
    {
        document.getElementById('postingbox').style.visibility = 'visible';
    }
    function beforeSave()
    {
        var radio = document.forms['employee_form'].elements['posttype'];
        if ((document.getElementById('usernamecheck').innerHTML == "")
                && (document.getElementById('salary').value != "")
                && (document.getElementById('SalaryRange').innerHTML != "")
                && (document.getElementById('showerror').innerHTML == "")
                && (document.getElementById('role').value != 0)
                && ((radio[0].checked) || (radio[1].checked)))
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
        var radio = document.forms['employee_form'].elements['posttype'];
        if ((document.getElementById('usernamecheck').innerHTML == "")
                && (document.getElementById('salary').value != "")
                && (document.getElementById('SalaryRange').innerHTML != "")
                && (document.getElementById('showerror').innerHTML == "")
                && (document.getElementById('role').value != 0)
                && ((radio[0].checked) || (radio[1].checked))
                && (document.getElementById('passcheck').innerHTML == "OK"))
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
        var radio = document.forms['employee_form'].elements['posttype'];
        if ((document.getElementById('usernamecheck').innerHTML == "")
                && (document.getElementById('salary').value != "")
                && (document.getElementById('SalaryRange').innerHTML != "")
                && (document.getElementById('showerror').innerHTML == "")
                && (document.getElementById('role').value != 0)
                && ((radio[0].checked) || (radio[1].checked))
                && (document.getElementById('passcheck').innerHTML == ""))
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
function setTypeGrade(emptype) // for select grade according to type of employee
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
                document.getElementById("showGrade").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "includes/getGradeForEmployeeType.php?type=" + emptype + "&step=1", true);
        xmlhttp.send();
    }
function showSalaryRange(paygrdid) // for selecting salary range according to grade
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
                document.getElementById("SalaryRange").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "includes/getGradeForEmployeeType.php?paygrdid=" + paygrdid + "&step=2", true);
        xmlhttp.send();
    }

function searchOSP(keystr)
    {
        var xmlhttp;
        var type = document.querySelector('input[name = "whatoffice"]:checked').value;
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
            if (keystr.length == 0)
            {
                document.getElementById('offResult').style.display = "none";
            }
            else
            {
                document.getElementById('offResult').style.visibility = "visible";
                document.getElementById('offResult').setAttribute('style', 'position:absolute;top:80.5%;left:56.5%;width:250px;z-index:10;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
            }
            document.getElementById('offResult').innerHTML = xmlhttp.responseText;
        }
        xmlhttp.open("GET", "includes/getGradeForEmployeeType.php?searchkey=" + keystr + "&step=3&type=" + type, true);
        xmlhttp.send();
    }

    function showPost()
    {
        var onsid = document.getElementById('ospID').value;
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
                document.getElementById("getPost").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "includes/getGradeForEmployeeType.php?onsid=" + onsid + "&step=4", true);
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
                    $input= 'employee';
                    $arrayAccountType = array('employee' => 'কর্মচারীর', 'customer' => 'কাস্টমারের', 'proprietor' => 'প্রোপ্রাইটারের');
                    $showAccountType  = $arrayAccountType[$input];
                    
                    echo "<tr><td><input type='hidden' value='$input' name='account_type'/></td></tr>
                    <table  class='formstyle'>          
                    <tr><th colspan='4' style='text-align: center;'>$showAccountType মূল তথ্য</th></tr>  
                         <tr><td colspan ='2' style='text-align: center;'><font color='read'>$smserror</font></td></tr>
                    <tr>
                        <td >$showAccountType নাম</td>
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
                        <td>কর্মচারীর ধরন</td>
                      <td>:   <select  class='box'  name='employee_type' style =' font-size: 14px' onchange='setTypeGrade(this.value)'>
                                <option >-একটি নির্বাচন করুন-</option>
                                <option value='programmer'>প্রোগ্রামার</option>
                                <option value='presenter'>প্রেজেন্টার</option>
                                <option value='trainer'>ট্রেইনার</option>
                                <option value='traveller'>ট্র্যাভেলার</option>
                                <option value='employee'>এমপ্লয়ী</option> 
                            </select><em2> *</em2></td>
                    </tr>   
                    <tr>
                        <td>গ্রেড নির্বাচন</td><td id='showGrade'>: </td>";
                    
//                        <td>: <select class='box' onchange='showSalaryRange(this.value)' name='employee_grade'><em2> *</em2>
//                                    <option value=0> -সিলেক্ট করুন- </option>";
//                                  $sql_paygrade= mysql_query("SELECT * FROM pay_grade WHERE employee_type = 'employee' ");
//                                  while($paygraderow = mysql_fetch_assoc($sql_paygrade))
//                                  {
//                                      echo  "<option value=".$paygraderow['idpaygrade'].">".$paygraderow['grade_name']."</option>";
//                                  }
//                                  echo "</select>
//                       </td>
                   echo" </tr>
                    <tr>
                        <td>সেলারি</td>
                       <td>:   <input class='box' type='text' id='salary' name='salary' onkeypress='return checkIt(event)' onkeyup='checkSalaryRange(this.value);'/><em2> *</em2> টাকা (সেলারি রেঞ্জঃ <span id='SalaryRange' style='color:red;'></span>)</td>
                    </tr>
                    <tr>
                        <td colspan='2' id='showerror' style='text-align:center;color:red;'></td>
                   </tr>
                   <tr>
                        <td>অফিস সিলেক্ট করুন</td> 
                        <td>: <input type='radio'  id='whatoffice' name='whatoffice' value ='office'/> অফিস &nbsp;&nbsp;&nbsp;
                            <input  type='radio' id='whatoffice' name='whatoffice' value ='s_store'/> সেলসস্টোর</td>
                    </tr>
                     <tr>
                        <td>অফিস / সেলস স্টোর / পাওয়ার স্টোর</td>
                        <td>: <input class='box' type='text' id='officesearch' name='officesearch' onkeyup='searchOSP(this.value)'/><em2> *</em2>
                        <div id='offResult'></div><input type='hidden' name='ospID' id='ospID'/></br>
                        </td>            
                    </tr>
                    <tr>
                        <td>দায়িত্ব / পোস্ট</td>  
                        <td id='getPost'>
                        </td>            
                    </tr>
                    <tr id='postingbox'  style='visibility: hidden;'>
                        <td>পোস্টের ধরন</td>
                        <td>: <input type='radio' name='posttype' id='posttype' value ='acting'/> অ্যাক্টিং &nbsp;&nbsp;&nbsp;
                            <input  type='radio' name='posttype' id='posttype' value ='permanent'/> পার্মানেন্ট</td>
                    </tr>
                    <tr>
                        <td>যোগদানের তারিখ</td>
                        <td>: <input class='box' type='text' id='date' placeholder='Date' name='date' value='$p_joiningdate'/>
                        </td>            
                    </tr>
                    <tr>
                     <td>কর্মচারীর রোল</td>
                      <td>:   <select  class='box'  name='role' id='role' style =' font-size: 14px'>";
                      showRoles();
                        echo "</select><em2> *</em2></td>
                    </tr>   
                    <tr>
                        <td>পাসওয়ার্ড</td>
                       <td>: <input class='box' type='password' id='user_password' name='user_password' maxlength='15' onblur='passminlength(this.value)'/><em2>*</em2><em>ইংরেজিতে লিখুন</em></br><span style='color:red;' id='minlengtherror'></span></td>
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
                 } else {
                      $input= 'employee';
                    $arrayAccountType = array('employee' => 'কর্মচারীর', 'customer' => 'কাস্টমারের', 'proprietor' => 'প্রোপ্রাইটারের');
                    $showAccountType  = $arrayAccountType[$input];
                    
                    echo "<tr><td><input type='hidden' value='$input' name='account_type'/></td></tr>";

                    echo "<table  class='formstyle'>          
                    <tr><th colspan='4' style='text-align: center;'>$showAccountType মূল তথ্য</th></tr>  
                    <tr>
                        <td >$showAccountType নাম</td>
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
                        <td>কর্মচারীর ধরন</td>
                      <td>:   <select  class='box'  name='employee_type' style =' font-size: 14px' onchange='setTypeGrade(this.value)'>
                                <option >-একটি নির্বাচন করুন-</option>
                                <option value='programmer'>প্রোগ্রামার</option>
                                <option value='presenter'>প্রেজেন্টার</option>
                                <option value='trainer'>ট্রেইনার</option>
                                <option value='traveller'>ট্র্যাভেলার</option>
                                <option value='employee'>এমপ্লয়ী</option> 
                            </select><em2> *</em2></td>
                    </tr>   
                    <tr>
                         <td>গ্রেড নির্বাচন</td><td id='showGrade'>: </td>";
                    
//                        <td>: <select class='box' onchange='showSalaryRange(this.value)' name='employee_grade'><em2> *</em2>
//                                    <option value=0> -সিলেক্ট করুন- </option>";
//                                  $sql_paygrade= mysql_query("SELECT * FROM pay_grade WHERE employee_type = 'employee' ");
//                                  while($paygraderow = mysql_fetch_assoc($sql_paygrade))
//                                  {
//                                      echo  "<option value=".$paygraderow['idpaygrade'].">".$paygraderow['grade_name']."</option>";
//                                  }
//                                  echo "</select>
//                       </td>
                   echo" </tr>
                    <tr>
                        <td>সেলারি</td>
                       <td>:   <input class='box' type='text' id='salary' name='salary' onkeypress='return checkIt(event)' onkeyup='checkSalaryRange(this.value);'/><em2> *</em2> টাকা (সেলারি রেঞ্জঃ <span id='SalaryRange' style='color:red;'></span>)</td>
                    </tr>
                    <tr>
                        <td colspan='2' id='showerror' style='text-align:center;color:red;'></td>
                   </tr>
                   <tr>
                        <td>অফিস সিলেক্ট করুন</td> 
                        <td>: <input type='radio'  id='whatoffice' name='whatoffice' value ='office'/> অফিস &nbsp;&nbsp;&nbsp;
                            <input  type='radio' id='whatoffice' name='whatoffice' value ='s_store'/> সেলসস্টোর</td>
                    </tr>
                     <tr>
                        <td>অফিস / সেলস স্টোর / পাওয়ার স্টোর</td>
                        <td>: <input class='box' type='text' id='officesearch' name='officesearch' onkeyup='searchOSP(this.value)'/><em2> *</em2>
                        <div id='offResult'></div><input type='hidden' name='ospID' id='ospID'/></br>
                        </td>            
                    </tr>
                    <tr>
                        <td>দায়িত্ব / পোস্ট</td>  
                        <td id='getPost'>
                        </td>            
                    </tr>
                    <tr id='postingbox'  style='visibility: hidden;'>
                        <td>পোস্টের ধরন</td>
                        <td>: <input type='radio' name='posttype' value ='acting'/> অ্যাক্টিং &nbsp;&nbsp;&nbsp;
                            <input  type='radio' name='posttype' value ='permanent'/> পার্মানেন্ট</td>
                    </tr>
                    <tr>
                        <td>যোগদানের তারিখ</td>
                        <td>: <input class='box' type='text' id='date' placeholder='Date' name='date' value=''/>
                        </td>            
                    </tr>
                    <tr>
                     <td>কর্মচারীর রোল</td>
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
<?php
include_once 'includes/footer.php';
?>
