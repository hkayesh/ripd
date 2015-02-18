<?php
/*
 * This page is commonly (internally) used to create proprietor, employee, customer. So this page not need to give any security
 */
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/makeAccountNumbers.php';
include_once 'includes/checkAccountNo.php';
include_once 'includes/email_conf.php';

function showPowerHeads()
{
    echo  "<option value=0> -সিলেক্ট করুন- </option>";
    $sql_office= mysql_query("SELECT * FROM office WHERE office_type='pwr_head' ORDER BY office_name;");
    while($headrow = mysql_fetch_assoc($sql_office))
    {
        echo  "<option value=".$headrow['account_number'].">".$headrow['office_name']."</option>";
    }
}

if($_POST['submit'])
        {
        $user_username = $_POST['user_username'];
        $user_password = md5($_POST['user_password']);
        $account_name = $_POST['name'];
        $account_number = $_POST['acc_num'];
        $account_email = $_POST['email'];
        $account_mobile = $_POST['mobile'];
        $account_mobile = "88".$account_mobile;
        $account_type = $_POST['account_type'];
        $account_number1 = checkAccountNo($account_number);
        if($account_type == "proprietor")
        {
             mysql_query("INSERT INTO cfs_user (user_name, password, blocked, account_name, account_number, account_open_date, mobile, email, cfs_account_status, user_type)
                                                                        VALUES ('$user_username', '$user_password', '0', '$account_name', '$account_number1', NOW(), '$account_mobile', '$account_email', 'active', 'owner')") or exit(mysql_error()." sorry");
        }
        elseif($account_type == "employee")
        {
            $p_employee_type = $_POST['employee_type']; 
            mysql_query("INSERT INTO cfs_user (user_name, password, blocked, account_name, account_number, account_open_date, mobile, email, cfs_account_status, user_type)
                                                                        VALUES ('$user_username', '$user_password', '0', '$account_name', '$account_number1', NOW(), '$account_mobile', '$account_email', 'active', '$p_employee_type')") or exit(mysql_error()." sorry");
        }
 else {
     mysql_query("INSERT INTO cfs_user (user_name, password, blocked, account_name, account_number, account_open_date, mobile, email, cfs_account_status, user_type)
                                                                        VALUES ('$user_username', '$user_password', '0', '$account_name', '$account_number1', NOW(), '$account_mobile', '$account_email', 'active', 'customer')") or exit(mysql_error()." sorry");
 }
       
        $cfs_user_id = mysql_insert_id();
        if($account_type == "employee")
                {
                    $p_employee_type = $_POST['employee_type'];
                    $p_employee_grade = $_POST['employee_grade'];
                    $p_employee_salary = $_POST['salary'];
                    $p_onsid = $_POST['ospID'];
                    $p_postonsID = $_POST['post'];
                    $p_posting_type = $_POST['posttype'];
                    mysql_query("INSERT into $dbname.employee (status, employee_type, joining_date, posting_type, emp_ons_id, pay_grade_id, cfs_user_idUser)
                                           VALUES ('posting', '$p_employee_type', NOW() ,'$p_posting_type', '$p_onsid', '$p_employee_grade', '$cfs_user_id')") or exit(mysql_error());
                    $employee_id = mysql_insert_id();
                    // employee_posting table-e insert***********************
                    mysql_query("INSERT into $dbname.employee_posting (posting_type, posting_date, Employee_idEmployee, ons_relation_idons_relation, post_in_ons_idpostinons)
                                            VALUES ('$p_posting_type',NOW(), $employee_id, $p_onsid, $p_postonsID)");
                    // update post_in_ons table***********************
                    mysql_query("UPDATE `post_in_ons` SET `free_post` = free_post-1,`used_post` = used_post+1 WHERE `idpostinons` =$p_postonsID");
                   //employee_salary table-e insert***************
                    mysql_query("INSERT into $dbname.employee_salary (total_salary, insert_date, user_id, pay_grade_idpaygrade)
                                            VALUES ('$p_employee_salary',NOW(), $employee_id, $p_employee_grade)");
                    
                    $empinfo_ins = mysql_query("INSERT into $dbname.employee_information (Employee_idEmployee) VALUES ($employee_id)");
                    $employee_info_id = mysql_insert_id();
                    if($empinfo_ins == 1) {$pass_message = "create_employee_account_inner.php?empInfoID=".$employee_info_id; }
                }
        else if($account_type == "customer")
                {
                    $pin_number = $_POST['pin_num'];
                    // get referer ID*****************************
                    $getreferer_sql = mysql_query("SELECT * FROM pin_makingused, sales_summary WHERE idsalessummary = sales_summery_idsalessummery AND pin_no = '$pin_number'");
                    $refererrow = mysql_fetch_assoc($getreferer_sql);
                    $db_referid = $refererrow['sal_buyerid'];
                    $db_pv= $refererrow['sal_totalpv'];
                     //get account type from pv ************************
                    $getactype_sql = mysql_query("SELECT * FROM account_type WHERE account_minPV_value <= $db_pv ORDER BY account_minPV_value DESC LIMIT 1");
                    $actyperow = mysql_fetch_assoc($getactype_sql);
                    $db_accounttypeID = $actyperow['idAccount_type'];
                    //cutomer_account table-e insert*************
                    mysql_query("INSERT into $dbname.customer_account (opening_pin_no, referer_id, Account_type_idAccount_type, Designation_idDesignation, cfs_user_idUser)
                                            VALUES ('$pin_number', $db_referid, $db_accounttypeID, 1, $cfs_user_id )") or exit(mysql_error());
                    $cust_acc_id= mysql_insert_id();
                    $pass_message = "create_customer_account_inner.php?custACid=".$cust_acc_id;
                }
       else if($account_type == "proprietor")
                {
                    $pwrHeadAccNo = $_POST['powerStore_accountNumber'];
                    $sel_pwrID = mysql_query("SELECT * FROM office WHERE account_number = '$pwrHeadAccNo' ");
                    $officerow = mysql_fetch_assoc($sel_pwrID);
                    $db_pwrOfficeID = $officerow['idOffice'];
                    $db_pwrHeadname = $officerow['office_name'];
                    $sql_pro_ins= mysql_query("INSERT INTO proprietor_account (powerStore_name, powerStore_accountNumber, Office_idOffice, cfs_user_idUser)
                                            VALUES ('$db_pwrHeadname', '$pwrHeadAccNo',$db_pwrOfficeID,  $cfs_user_id)");
                    $propreitor_account_id = mysql_insert_id();
                    if($sql_pro_ins == 1){$pass_message = "create_proprietor_account_inner.php?proID=".$propreitor_account_id;}                     
                }
        $email_pass = $_POST['user_password'];
        $email_create = CreateEmailAccount($user_username, $email_pass);
        //echo $email_create; //make decision to give error message
        }

?>
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
        var unicode=e.charCode? e.charCode : e.keyCode
            if (unicode!=8)
            { //if the key isn't the backspace key (which we should allow)
                if (unicode<48||unicode>57) //if not a number
                return false //disable key press
            }
}
   function checkIt(evt) // float value-er jonno***********************
    {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        status = "";
        return true;
    }
    status = "This field accepts numbers only.";
    return false;
}
function checkPass(passvalue) // check password in repeat
{
    var user_password = document.getElementById('user_password').value;
    if(user_password != passvalue)
        {
            document.getElementById('reap_password').focus();
            document.getElementById('passcheck').style.color='red';
            document.getElementById('passcheck').innerHTML = "পাসওয়ার্ড সঠিক হয় নি";
        }
        else{
            document.getElementById('passcheck').style.color='green';
            document.getElementById('passcheck').innerHTML="OK";
        }
}
    function showAccountNo(account)
    {
        document.getElementById('powerStore_accountNumber').value= account;
    }

function checkSalaryRange(sal)
{
    var range = document.getElementById('SalaryRange').innerText;
    var myarr = range.split("-");
    var min = myarr[0];
    var max = myarr[1];
    var sal = Number(sal);
    if((sal<= max) && (sal>=min))
        {document.getElementById('showerror').innerHTML = "";}
    else{document.getElementById('showerror').innerHTML = "দুঃখিত, সেলারি রেঞ্জ অতিক্রম করেছে"; }
}
function setParent(office,offid)
{
        document.getElementById('officesearch').value = office;
        document.getElementById('ospID').value = offid;
        document.getElementById('offResult').style.display = "none";
}
function showTypeBox()
{
    document.getElementById('postingbox').style.visibility= 'visible';
}
</script>
<script>
function check(str) // for currect email address form checking
{
if (str.length==0)
  {
  document.getElementById("error_msg").innerHTML=""; 
  document.getElementById("error_msg").style.border="0px";
  return;
  }
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
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("error_msg").innerHTML=xmlhttp.responseText;
    document.getElementById("error_msg").style.display = "inline";
    }
  }
xmlhttp.open("GET","includes/check.php?x="+str,true);
xmlhttp.send();
}

function setTypeGrade(emptype) // for select grade according to type of employee
{
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
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("showGrade").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","includes/getGradeForEmployeeType.php?type="+emptype+"&step=1",true);
xmlhttp.send();
}

function showSalaryRange(paygrdid) // for selecting salary range according to grade
{
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
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("SalaryRange").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","includes/getGradeForEmployeeType.php?paygrdid="+paygrdid+"&step=2",true);
xmlhttp.send();
}

function searchOSP(keystr)
{
        var xmlhttp;
        var type = document.querySelector('input[name = "whatoffice"]:checked').value;
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
                   document.getElementById('offResult').style.display = "none";
               }
                else
                    {document.getElementById('offResult').style.visibility = "visible";
                document.getElementById('offResult').setAttribute('style','position:absolute;top:87%;left:48%;width:250px;z-index:10;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('offResult').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getGradeForEmployeeType.php?searchkey="+keystr+"&step=3&type="+type,true);
        xmlhttp.send();	
}

function showPost()
{
    var onsid = document.getElementById('ospID').value;
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
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("getPost").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","includes/getGradeForEmployeeType.php?onsid="+onsid+"&step=4",true);
xmlhttp.send();
}
function checkUserName(uname)
{
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
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("usernamecheck").innerHTML=xmlhttp.responseText;
    document.getElementById('save').disabled= false;
    }
  }
xmlhttp.open("GET","includes/checkUserName.php?strkey="+uname,true);
xmlhttp.send();
}
function beforeSave()
        {
            if(document.getElementById('usernamecheck').innerHTML != "") 
                {
                document.getElementById('save').disabled= true;
                }
                else {document.getElementById('save').disabled= false;}
        }
</script>
<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a onclick="goBack();" style="cursor: pointer;"><b><u>ফিরে যান</u></b></a></div> 
        <div>            
            <form method="POST" action="">
                <?php
                    $input= $_GET['id'];
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
                       <td>:   <input class='box' type='text' id='email' name='email' onblur='check(this.value)' /> <em>ইংরেজিতে লিখুন</em> <span id='error_msg' style='margin-left: 5px'></span></td>			
                    </tr>
                    <tr>
                        <td >মোবাইল</td>
                        <td>: <input class='box' type='text' id='mobile' name='mobile' onkeypress=' return numbersonly(event)' style='font-size:16px;' placeholder='01XXXXXXXXX' /><em2>*</em2><em>ইংরেজিতে লিখুন</em></td>		
                    </tr>";
                    if($input == "customer")
                            {
                            echo "<tr>
                                <td >পিন নাম্বার</td>
                                <td>:   <input class='box' type='text' id='pin_num' name='pin_num' /><em2>*</em2><em>ইংরেজিতে লিখুন</em></td>		
                            </tr>";
                            }
                    echo "
                   <tr>
                        <td>ইউজারের নাম</td>
                      <td>:   <input class='box' type='text' id='user_username' name='user_username' onblur='checkUserName(this.value)'/><em2>*</em2><em>ইংরেজিতে লিখুন</em> <span style='color:red;' id='usernamecheck'></td>
                    </tr>   
                    <tr>
                        <td>পাসওয়ার্ড</td>
                       <td>:   <input class='box' type='password' id='user_password' name='user_password' /><em2>*</em2><em>ইংরেজিতে লিখুন</em></td>
                    </tr>
                    <tr>
                        <td>কনফার্ম পাসওয়ার্ড</td>
                       <td>:   <input class='box' type='password' id='reap_password' name='reap_password' onkeyup='checkPass(this.value);'/> <em>ইংরেজিতে লিখুন</em> <span id='passcheck'></span></td>
                    </tr>";
                    if($input == "employee") {
                   echo "<tr>
                        <td colspan='2' ><hr /></td>
                    </tr>
                    <tr>
                        <td>কর্মচারীর ধরন</td>
                      <td>:   <select  class='box'  name='employee_type' style =' font-size: 14px' onchange='setTypeGrade(this.value)'>
                                <option >-একটি নির্বাচন করুন-</option>
                                <option value='programmer'>প্রোগ্রামার</option>
                                <option value='presenter'>প্রেজেন্টার</option>
                                <option value='trainer'>ট্রেইনার</option>
                                <option value='employee'>এমপ্লয়ী</option> 
                            </select><em2> *</em2></td>
                    </tr>   
                    <tr>
                        <td>গ্রেড নির্বাচন</td>
                       <td id='showGrade'>: </td>
                    </tr>
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
                        <td>: <input type='radio' name='posttype' value ='Acting'/> অ্যাক্টিং &nbsp;&nbsp;&nbsp;
                            <input  type='radio' name='posttype' value ='Permanent'/> পার্মানেন্ট</td>
                    </tr>
                    <tr>
                        <td>যোগদানের তারিখ</td>
                        <td>: <input class='box' type='text' id='date' placeholder='Date' name='date' value=''/>
                        </td>            
                    </tr>"; }
                    if($input == 'proprietor')
                    {
                        echo "<tr>
                        <td>পাওয়ার স্টোরের নাম</td>
                        <td >:  <select  class='box' name='powerStore_name' style='height:20px;'onchange='showAccountNo(this.value)'>";
                                showPowerHeads();
                         echo "</select><em2> *</em2>	
                        </td>
                        <td>পাওয়ার স্টোরের একাউন্ট নং </td>
                        <td>:  <input class='box' type='text' readonly='' id='powerStore_accountNumber' name='powerStore_accountNumber' /></td>	
                    </tr>";
                    }
                    echo "<tr>                    
                        <td colspan='4' style='padding-left: 250px; '>";
                    if($_POST['submit'])
                            {
                            echo "<a href='$pass_message'>পরবর্তী ধাপে যেতে ক্লিক করুন</a>";
                            }
                    else echo "<input class='btn' style ='font-size: 12px;' type='submit' name='submit' id='save' value='সেভ করুন' disabled onclick='beforeSave();'/>";
                    echo "</td>                           
                    </tr>             
                </table>";        
                ?>
            </form>
        </div>
    </div>      
</div> 
<?php
include_once 'includes/footer.php';
?>
