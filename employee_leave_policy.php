<?php
error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$loginUSERname = $_SESSION['UserID'] ;
$queryemp = mysql_query("SELECT idUser FROM cfs_user WHERE user_name = '$loginUSERname';");
$emprow = mysql_fetch_assoc($queryemp);
$db_onsid = $emprow['idUser'];

function getLeaveType()
{
    echo  "<option value=0> -সিলেক্ট করুন- </option>";
    $typerslt= mysql_query("SELECT * FROM leave_policy");
    while($typerow = mysql_fetch_assoc($typerslt))
    {
	echo  "<option value=".$typerow['idleavepolicy'].">".$typerow['leave_name']."</option>";
    }
}
function addDayswithdate($date,$days){

    $date = strtotime("+".$days." days", strtotime($date));
    return  date("Y-m-d", $date);

}
$timestamp=time(); //current timestamp
$da=date("Y/m/d",$timestamp);

if(isset($_POST['submit']))
{
    
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
        $extension = end(explode(".", $_FILES["leavescan"]["name"]));
        $scan_name ="emp_leave_".$_FILES["leavescan"]["name"];
        $scan_path = "pic/" . $scan_name;
        if (($_FILES["leavescan"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                {
                    move_uploaded_file($_FILES["leavescan"]["tmp_name"], "pic/" . $scan_name);
                } 
    $p_startingdate = $_POST['startdate'];
    $p_totaldays = $_POST['leavedays'];
    $days = $p_totaldays -1;
    $p_lv_des = $_POST['leavedes'];
    $p_empcfsid = $_POST['cfsid'];
    $p_policyid = $_POST['leave_type'];
    $p_paygradeid = $_POST['emp_paygrade'];
    $endDate = addDayswithdate($p_startingdate,$days);
    
    $sql_lvingrade =mysql_query("SELECT * FROM `leave_in_grade`WHERE pay_grade_idpaygrade =$p_paygradeid  AND leave_policy_idleavepolicy=$p_policyid");
    $getrow = mysql_fetch_assoc($sql_lvingrade);
    $lvingradeid = $getrow['idleaveingrd'];
     $sql_insert  = mysql_query("INSERT INTO emp_in_leave (starting_date, end_date, total_day, leave_desc, leave_scan_doc, leave_giver_id, emp_id, leave_in_grade_idleaveingrd) 
         VALUES ('$p_startingdate','$endDate','$p_totaldays','$p_lv_des','$scan_path',$db_onsid,$p_empcfsid,$lvingradeid)");
      if($sql_insert != 0)
    {  $msg = "ছুটি তৈরি হয়েছে"; }
   else {$msg = "ছুটি তৈরি হয়নি";}
}
?>
<title>কর্মচারীর ছুটি</title>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script>
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
function checkmaxdays(indays) // check maximum days exeeds or not***************
{
    var maxdays = Number(document.getElementById('maxdays').value);
    
    if(indays > maxdays)
        {
             document.getElementById('submit').style.visibility= 'hidden';
        }
        else
            {
                document.getElementById('submit').style.visibility= 'visible';
            }
}
    window.onclick = function()
    {
        new JsDatePick({
            useMode: 2,
            target: "date",
            dateFormat: "%Y-%m-%d"
        });
    }
</script>
<script>
function getLeaveInGrade(lvpolicy,cfsid) // for employee allocated leave days***************
{
    var xmlhttp;
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
                document.getElementById('maxdays').value=xmlhttp.responseText;
        }
        var emppaygrd = document.getElementById('emp_paygrade').value;
        xmlhttp.open("GET","includes/employeeSearch.php?paygradid="+emppaygrd+"&cfsid="+cfsid+"&lvpolicyid="+lvpolicy+"&location=employee_leave_policy.php",true);
        xmlhttp.send();	
}
function getEmployee(keystr) //search employee by account number***************
{
    var xmlhttp;
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
                   document.getElementById('empfound').style.display = "none";
               }
                else
                    {document.getElementById('empfound').style.visibility = "visible";
                document.getElementById('empfound').setAttribute('style','position:absolute;top:41.5%;left:61.5%;width:225px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('empfound').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/employeeSearch.php?key="+keystr+"&location=employee_leave_policy.php",true);
        xmlhttp.send();	
}

</script>  

<div class="column6" style="width: 100% !important;">
    <div class="main_text_box">    
        <div style="padding-top: 10px;padding-left: 110px; "><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
    <div>
        <form method="POST" action="" enctype="multipart/form-data" style=" font-family: SolaimanLipi !important;">	
            <table  class="formstyle" style =" width:80%"id="make_presentation_fillter">                   
                    <tr>
                        <th colspan="8" style="font-size: 22px;" >কর্মচারীর ছুটি গণনা</th>
                        <?php
                                        if(isset($_GET['id']))
                                        {
                                            $empCfsid = $_GET['id'];
                                            $selreslt= mysql_query("SELECT * FROM  cfs_user WHERE idUser = $empCfsid");
                                            $getrow = mysql_fetch_assoc($selreslt);
                                            $db_empname = $getrow['account_name'];
                                            $db_empmobile = $getrow['mobile'];
                                            $sql_post = mysql_query("SELECT post_name FROM employee, employee_posting, post_in_ons, post
                                                                                        WHERE idPost = Post_idPost AND idpostinons = post_in_ons_idpostinons AND Employee_idEmployee = idEmployee
                                                                                            AND  cfs_user_idUser = $empCfsid");
                                            $sql_postrow = mysql_fetch_assoc($sql_post);
                                            $db_empposition = $sql_postrow['post_name'];
                                            $sql_employee = mysql_query("SELECT * FROM employee WHERE cfs_user_idUser = $empCfsid");
                                            $emprow = mysql_fetch_assoc($sql_employee);
                                            $db_paygrdid = $emprow['pay_grade_id'];
                                            $db_empid = $emprow['idEmployee'];
                                            $sql_empinfo = mysql_query("SELECT * FROM employee_information WHERE Employee_idEmployee = $db_empid");
                                            $empinforow = mysql_fetch_assoc($sql_empinfo);
                                            $db_empphoto = $empinforow['emplo_scanDoc_picture'];
                                            
                                        }
                            ?>
                    </tr> 
                       <tr>
                        <td colspan="2" style="text-align: center; font-size: 16px;color: green;">  <?php if($msg != "") {echo $msg;}?></td>                                               
                    </tr>
                    <tr>
                        <td width="59%">
                            <table>
                                 <tr>
                        <td width="30%" >ছুটির টাইপ</td>
                        <td width="70%">:  <select class="textfield" onchange="getLeaveInGrade(this.value,'<?php echo $empCfsid;?>')" name="leave_type" style =" font-size: 11px">
                                <?php echo getLeaveType(); ?></select></td>	 
                    </tr>  
                    <tr>
                        <td >ছুটি শুরুর তারিখ</td>
                        <td>:  <input class="textfield" type="text" id="date" placeholder="Date" name="startdate" value=""/></td>	  
                    </tr>  
                    <tr>
                        <td >ছুটির দিনের সংখ্যা</td>
                        <td>:  <input class="textfield" type="text" id="leavedays" name="leavedays" onkeypress="return checkIt(event)" onkeyup="checkmaxdays(this.value)"/> দিন
                            (সর্বোচ্চ <input type="text" readonly="" id="maxdays" style="width: 15px;color: red;" /> দিন)</td>	  
                    </tr>  
                    <tr>
                        <td >বর্ণনা</td>
                        <td><textarea class="textfield" type="text" id="leavedes" name="leavedes"></textarea></td>
                    </tr> 
                    <tr>
                        <td >স্ক্যান ডকুমেন্টস</td>
                        <td>:   <input class="box" type="file" id="leavescan" name="leavescan" style="font-size:10px;"/></td>
                    </tr>
                    <tr>
                        <td colspan="2"></br><input class="btn" style =" font-size: 12px;margin-left: 50px;visibility: hidden;" type="submit" id="submit" name="submit" value="সেভ করুন" />
                                <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>
                    </tr>
                            </table>
                        </td>
                           <td width="41%">
                            <table>
                                 <tr>
                                     <td colspan="8" style="text-align: right">খুঁজুন:  <input type="text" class="box" style="width: 230px;" id="empsearch" name="empsearch" onkeyup="getEmployee(this.value)"/>
                                    <div id="empfound"></div></td>
                            </tr>
                            <tr>
                                <td width="40%" rowspan='4' style="padding-left: 0px;"> <img src="<?php echo $db_empphoto;?>" width="128px" height="128px" alt=""></td> 
                            </tr>
                            <tr>
                                <td width="57%"><input type="hidden" readonly="" value="<?php echo $db_empname;?>" /><?php echo $db_empname;?></td>
                            </tr>     
                            <tr>
                                <td><input type="hidden" readonly="" value="<?php echo $db_empposition;?>" /><?php echo $db_empposition;?>
                                    <input type="hidden" readonly="" id="emp_paygrade" name="emp_paygrade" value="<?php echo $db_paygrdid;?>" /></td>
                            </tr>    
                            <tr>
                                <td height="74"><input type="hidden" readonly="" value="<?php echo $db_empmobile;?>" /><?php echo $db_empmobile;?>
                                <input type="hidden" readonly="" name="cfsid"value="<?php echo $empCfsid;?>" /></td>
                            </tr>                 
                            </table>
                        </td>
                    </tr>
                    <tr>
                     
                    </tr>
            </table>
        </form>
    </div>
    </div>
</div>
<?php 
include_once 'includes/footer.php'; 
?>