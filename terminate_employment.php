<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$loginUSERname = $_SESSION['UserID'] ;
$queryemp = mysql_query("SELECT idUser FROM cfs_user WHERE user_name = '$loginUSERname';");
$emprow = mysql_fetch_assoc($queryemp);
$db_onsid = $emprow['idUser'];
if(isset($_POST['submit']))
{
    $p_reason = $_POST['reason'];
    $p_terminationdate = $_POST['termination_date'];
    $p_terminationdes = $_POST['termination_des'];
    $p_paymentstatus = $_POST['status'];
    $p_postblockdate = $_POST['post_block'];
    $p_accblockdate = $_POST['acc_block'];
    $p_empcfsid = $_POST['cfsid'];

    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
        $extension = end(explode(".", $_FILES["terminationdoc"]["name"]));
        $scan_name ="terminate_".$p_empcfsid."_".$_FILES["terminationdoc"]["name"];
        $scan_path = "pic/" . $scan_name;
        if (($_FILES["terminationdoc"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                {
                    move_uploaded_file($_FILES["terminationdoc"]["tmp_name"], "pic/" . $scan_name);
                } 
        else 
                {
                echo "Invalid file format.";
                }
    
    $sql_ins_terminate = mysql_query("INSERT INTO terminate_employeement (term_reason, term_date, term_explanation,  	terminated_by, payment_status, post_block_date, acc_block_date, emp_cfs_id, term_scandoc)
        VALUES ('$p_reason', '$p_terminationdate','$p_terminationdes', $db_onsid,'$p_paymentstatus', '$p_postblockdate', '$p_accblockdate', $p_empcfsid, '$scan_path');");
    if($sql_ins_terminate ==1)
    {
        $msg = "স্থগিতকরন সফল হয়েছে";
    }
 else {
     $msg = "দুঃখিত, স্থগিতকরন হয়নি";        
    }
}
?>
<title>চাকুরি স্থগিতকরন</title>
<style type="text/css"> @import "css/bush.css";</style>
<script>
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
                document.getElementById('empfound').setAttribute('style','position:absolute;top:40%;left:60.5%;width:225px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('empfound').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/employeeSearch.php?key="+keystr+"&location=terminate_employment.php",true);
        xmlhttp.send();	
}
function beforeSubmit()
{
    var radiocheck = 0;
      var radios = document.getElementsByName("status");
      for(var i=0; i<radios.length; i++){
	if(radios[i].checked) { radiocheck = 1; }
	}
    if ((document.getElementById('termination_date').value !="") 
        && (document.getElementById('reason').value != "0")
        && (document.getElementById('post_block').value != "")
        && (document.getElementById('acc_block').value != "")
        && (radiocheck == 1))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
        <div>
            <form method="POST" enctype="multipart/form-data" action="" onsubmit="return beforeSubmit()">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;">          
                    <tr><th colspan="2" style="text-align: center;">চাকুরি স্থগিতকরন</th>
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
                        <td width="53%">
                            <table>
                                 <tr>
                                    <td width="39%" >কারন</td>
                                    <td width="61%">:  <select class="box" name="reason" id="reason">
                                            <option value="0">-সিলেক্ট করুন-</option>
                                            <option value="retired">অবসর</option>
                                            <option value="resign">পদত্যাগ</option>
                                            <option value="dissmised">বরখাস্ত</option>
                                            <option value="other">অন্যান্য</option>
                                        </select><em2> *</em2></td>	 
                                </tr>  
                                <tr>
                                    <td>তারিখ</td>
                                    <td>: <input type="date" class="box" name="termination_date" id="termination_date"/><em2> *</em2></td>	  
                                </tr>  
                                <tr>
                                    <td>বর্ণনা</td>
                                    <td> <textarea class="box" type="text" name="termination_des"></textarea></td>
                                </tr> 
                                <tr>
                                    <td>বেতন প্রদান</td>
                                    <td>:   <input  type="radio" name="status" checked="" value="given" /> দেয়া হয়েছে 
                                        &nbsp;&nbsp;&nbsp;<input  type="radio" name="status" value="undone"  /> দেয়া হয়নি <em2> *</em2>
                                    </td>
                                </tr>
                                <tr>
                                    <td>পোস্ট স্থগিত তারিখ</td>
                                    <td>:   <input class="box" type="date" name="post_block" id="post_block"/><em2> *</em2></td>
                                </tr>
                                <tr>
                                    <td>অ্যাকাউন্ট স্থগিত তারিখ</td>
                                    <td>:   <input class="box" type="date" name="acc_block" id="acc_block" /><em2> *</em2></td>
                                </tr>
                                <tr>
                                    <td>স্ক্যান ডকুমেন্ট</td>
                                    <td>:   <input class="box" type="file" id="termination_doc" name="terminationdoc" /></td>
                                </tr>
                            </table>     
                        </td>
                        <td width="47%">
                             <table>
                                 <tr>
                                     <td colspan="8" style="text-align: right">খুঁজুন:  <input type="text" class="box" style="width: 230px;" id="empsearch" name="empsearch" onkeyup="getEmployee(this.value)"/>
                                    <div id="empfound"></div></td>
                                    </tr>
                                    <tr>
                                        <td width="34%" rowspan='4' style="padding-left: 0px;"> <img src="<?php echo $db_empphoto;?>" width="128px" height="128px" alt=""></td> 
                                    </tr>
                                    <tr>
                                        <td width="66%"><input type="hidden" readonly="" value="<?php echo $db_empname;?>" /><?php echo $db_empname;?></td>
                                    </tr>     
                                    <tr>
                                        <td><input type="hidden" readonly="" value="<?php echo $db_empposition;?>" /><?php echo $db_empposition;?>
                                            <input type="hidden" readonly="" id="emp_paygrade" name="emp_paygrade" value="<?php echo $db_paygrdid;?>" /></td>
                                    </tr>    
                                    <tr>
                                        <td height="74"><input type="hidden" readonly="" value="<?php echo $db_empmobile;?>" /><?php echo $db_empmobile;?>
                                        <input type="hidden" readonly="" name="cfsid"value="<?php echo $empCfsid;?>" /></td>
                                    </tr>     
                                    <tr>
                                        <td height="74" style="text-align: center;"><a href="">বিস্তারিত</a></td>
                                    </tr>     
                                    </table>
                        </td>
                    </tr>
                    <tr>                    
                        <td colspan="2" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" />
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>           
    </div>
    <?php
    include_once 'includes/footer.php';
    ?>
