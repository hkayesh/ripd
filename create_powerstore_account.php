<?php 
error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/makeAccountNumbers.php';
include_once 'includes/email_conf.php';
$msg = "";

if(isset($_POST['submit0']))
{
    $name = $_POST['office_name'];
    $off_add = $_POST['office_address'];
    $off_no = $_POST['office_no'];
    $off_acc = $_POST['office_acc'];
    $thana = $_POST['thana_id'];
     $emailusername = str_replace("-", "", $off_acc);
    $ripdemailid = $emailusername . "@ripduniversal.com";
    $passwrd = $emailusername;
    //************************* create official email *************************************************
             $email_create_status = CreateEmailAccount($emailusername, $passwrd);
            if ($email_create_status != '777') {
                $ripdemailid = "";
            }
     mysql_query("START TRANSACTION");
   $sql= "INSERT INTO ". $dbname .".`office` (`office_type` ,`office_selection` ,`office_name` ,`office_number` ,`account_number` ,`office_email` ,email_password, `Thana_idThana`,`office_details_address`) 
              VALUES ( 'pwr_head', 'pwr','$name' , '$off_no', '$off_acc','$ripdemailid' ,'$passwrd' , '$thana', '$off_add')";
    $reslt=mysql_query($sql);
    $off = mysql_insert_id();
    
     $ssql = "INSERT INTO ". $dbname .".`ons_relation` ( `catagory` ,`insert_date` ,`add_ons_id`) VALUES (  'office', NOW(), '$off');";
    $sreslt = mysql_query($ssql);
    $ons = mysql_insert_id();
    
    $b_space = $_POST['office_space'];
    $b_type = $_POST['building_type'];
    $b_floor = $_POST['floor_number'];
    $isql = "INSERT INTO ". $dbname .".`ons_information` ( `space` ,`building_type` ,`floor` ,`ons_relation_idons_relation`) VALUES ( '$b_space', '$b_type', '$b_floor', '$ons');";
    $ireslt = mysql_query($isql);
      
     $rent1 = $_POST['office_rent1'];
     $rent2 = $_POST['office_rent2'];
     $rent = $rent1.".".$rent2;
     $e_bill1 = $_POST['electicity_bill1'];
     $e_bill2 = $_POST['electicity_bill2'];
     $e_bill = $e_bill1.".".$e_bill2;
     $w_bill1 = $_POST['water_bill1'];
     $w_bill2 = $_POST['water_bill2'];
     $w_bill = $w_bill1.".".$w_bill2;
     $adv_pay1 = $_POST['advanced_payment1'];
     $adv_pay2 = $_POST['advanced_payment2'];
     $adv_pay = $adv_pay1.".".$adv_pay2;
     $deco1 = $_POST['decoration1'];
     $deco2 = $_POST['decoration2'];
     $deco = $deco1.".".$deco2;
     $csql = "INSERT INTO ". $dbname .".`ons_cost` (`rent` ,`current_bill` ,`water_bill` ,`advanced_amount` ,`decoration` ,`ons_relation_idons_relation`) 
                VALUES ('$rent', '$e_bill', '$w_bill', '$adv_pay', '$deco', '$ons');";
     $creslt = mysql_query($csql);
     $ons_cost = mysql_insert_id();
   
     $sub = $_POST['sub'];
     $quan1 = $_POST['quantity1'];
     $quan2 = $_POST['quantity2'];
     $n = count($sub);
    
     for($i=0; $i<$n; $i++)
     {
         $quan[$i] = $quan1[$i].".".$quan2[$i];
         $osql = "INSERT INTO ". $dbname .".`ons_cost_others` (`cost_type` ,`cost_amount` ,`ons_cost_idons_cost`) 
                        VALUES ( '$sub[$i]',  '$quan[$i]', '$ons_cost');";
         $oreslt = mysql_query($osql) or exit('query failed: '.mysql_error());
     }
     
         $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
        $extension = end(explode(".", $_FILES["image"]["name"]));
        $image_name = $off_acc."_".$_FILES["image"]["name"];
        $image_path = "pic/" . $image_name;
        if (($_FILES["image"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                {
                    move_uploaded_file($_FILES["image"]["tmp_name"], "pic/" . $image_name);
                } 
                
                  $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
                    $extension = end(explode(".", $_FILES["signature"]["name"]));
                    $sign_name = $off_acc."_". $_FILES["signature"]["name"];
                    $sing_path = "sign/" . $sign_name;
       if (($_FILES["signature"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                    {
                            move_uploaded_file($_FILES["signature"]["tmp_name"], "sign/" . $sign_name);
                     }                 
                $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
        $extension = end(explode(".", $_FILES["owner_finger_print"]["name"]));
        $finger_name = $off_acc."_".$_FILES["owner_finger_print"]["name"];
        $finger_path = "fingerprints/".$finger_name;
        if (($_FILES["owner_finger_print"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                {
                        move_uploaded_file($_FILES["owner_finger_print"]["tmp_name"], "fingerprints/" . $finger_name);
                } 
                
                $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG","pdf");
        $extension = end(explode(".", $_FILES["scanDoc"]["name"]));
         $scan_name = $off_acc."_".$_FILES["scanDoc"]["name"];
          $scan_path = "scaned/".$scan_name;
        if (($_FILES["scanDoc"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                {
                        move_uploaded_file($_FILES["scanDoc"]["tmp_name"], "scaned/" . $scan_name);
                }
      
     $own_name = $_POST['owner_Name'];          
     $own_add = $_POST['owner_address'];
     $own_mbl = $_POST['mobile_number'];
     $own_mail = $_POST['mail_address'];
     $own_valid = $_POST['validity'];
    
     $ownsql = "INSERT INTO ". $dbname .".`ons_deed` (`owner_name` ,`owner_address` ,`cell_number` ,`owner_email` ,`owner_photo` ,`owner_signature`  ,`expire_date` ,`scan_documents` ,`ons_relation_idons_relation`,`owner_fingerprint`) VALUES  ( '$own_name', '$own_add' , '$own_mbl' , '$own_mail'  , '$image_path' , '$sing_path'  , '$own_valid' , '$scan_path' , '$ons' , '$finger_path');";
     $ownreslt = mysql_query($ownsql) or exit('query failed: '.mysql_error());
     
       // ****************** default insert into post_in_ons ***************************************
     $sel_post = mysql_query("SELECT * FROM post WHERE post_name='এডমিন'");
     $noOfRows = mysql_num_rows($sel_post);
     if($noOfRows < 1)
     {
         $ins_post = mysql_query("INSERT INTO post (post_name, responsibility_desc) VALUES ('এডমিন' , 'এডমিনিস্ট্রেশন')");
         $postid = mysql_insert_id();
         $ins_postinons = mysql_query("INSERT INTO post_in_ons (number_of_post, free_post, post_onstype, used_post, post_onsid, Post_idPost)
                                                        VALUES (1, 1, 'office', 0, $off, $postid)");
     }
 else {
     $postrow = mysql_fetch_assoc($sel_post);
     $postid = $postrow['idPost'];
     $ins_postinons = mysql_query("INSERT INTO post_in_ons (number_of_post, free_post, post_onstype, used_post, post_onsid, Post_idPost)
                                                        VALUES (1, 1, 'office', 0, $off, $postid)");   
     }
     
    if($reslt && $sreslt && $ireslt && $oreslt && $ownreslt && $ins_postinons)
     {
         mysql_query("COMMIT");
         $msg = "পাওয়ার স্টোর তৈরি হয়েছে";
     }
     else
     {
         mysql_query("ROLLBACK");
         $msg = "দুঃখিত, পাওয়ার স্টোর তৈরি হয়নি";
     }
   }

?>
<title>ক্রিয়েট পাওয়ার অফিস অ্যাকাউন্ট</title>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>

<script type="text/javascript">    
    
        $('.del').live('click',function(){
	$(this).parent().parent().remove();
        });
        $('.add').live('click',function()
        {
            var appendTxt= "<tr><td><input class='textfield'  id='sub' name='sub[]' type='text' /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class='textfield' style='text-align: right' id='quantity1' name='quantity1[]' type='text' onkeypress='return numbersonly(event)' />\n\
                                        . <input class='boxTK' id='quantity2' name=quantity2[]' type='text' onkeypress='return numbersonly(event)'/> TK</td>\n\
                                         <td><input type='button' class='del' /></td><td>&nbsp;<input type='button' class='add' /></td></tr>";
            $("#container_others:last").after(appendTxt);
        })

    window.onclick = function()
    {
        new JsDatePick({
            useMode: 2,
            target: "validity",
            dateFormat: "%Y-%m-%d"
        });
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
</script> 

<script  type="text/javascript">
    function getDistrict()
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
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById('did').innerHTML=xmlhttp.responseText;
            }
        }
        var division_id;
        division_id = document.getElementById('division_id').value;
        xmlhttp.open("GET","includes/getDistrict.php?did="+division_id+"&mtD=blank",true);
        xmlhttp.send();
    }
        
       function getThana()
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
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById('tidd').innerHTML=xmlhttp.responseText;
            }
        }
          var division_id, district_id;
        division_id = document.getElementById('division_id').value;
        district_id = document.getElementById('district_id').value;
    
      
        xmlhttp.open("GET","includes/getThana.php?tDsId="+district_id+"&tDfId="+division_id+"&mtT=blank",true);
        xmlhttp.send();
    }
    
    function check(str)
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

function check2(str)
{
if (str.length==0)
  {
  document.getElementById("error_msg2").innerHTML=""; 
  document.getElementById("error_msg2").style.border="0px";
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
    document.getElementById("error_msg2").innerHTML=xmlhttp.responseText;
    document.getElementById("error_msg2").style.display = "inline";
    }
  }
xmlhttp.open("GET","includes/check.php?x="+str,true);
xmlhttp.send();
}
function beforeSubmit()
{
    if ((document.getElementById('office_name').value != "")
                && (document.getElementById('mobile_number').innerHTML != "")
                && (document.getElementById('owner_Name').innerHTML == "")
                && (document.getElementById('advanced_payment1').value !="")
                && (document.getElementById('floor_number').value !="")
                && (document.getElementById('office_rent1').value !="")
                && (document.getElementById('office_address').value !="")
                && (document.getElementById('thana_id').value !=""))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box" style="width: 100%;">
        <div style="padding-left: 110px;"><a href="office_sstore_management.php"><b>ফিরে যান</b></a><a href="" onclick="javasrcipt:window.open('update_office_account_office_pstore.php?pwr=1');return false;" style="padding-left: 510px;"><b>মেইন পাওয়ারস্টোর লিস্ট</b></a></div>
        <div>           
            <form method="POST" enctype="multipart/form-data" action="" id="off_form" name="off_form" onsubmit="return beforeSubmit()">       
                <table class="formstyle"  style=" width: 70%; ">          
                    <tr><th style="text-align: center" colspan="2"><h1>মেইন পাওয়ারস্টোর একাউন্ট তৈরির ফর্ম</h1></th></tr>

                <tr><td colspan="2" style="text-align: center;color: green;font-size: 16px;"><?php if($msg != "") echo $msg;?></td></tr>
                     <tr>
                        <td>পাওয়ারস্টোরের নাম</td>
                        <td>:    <input  class ="textfield" type="text" id="office_name" name="office_name" /><em2> *</em2></td>
                    </tr>
                     <tr>
                        <td>পাওয়ারস্টোরের অ্যাকাউন্ট</td>
                        <td>:    <input  class ="textfield" type="text" readonly="" id="office_acc" name="office_acc" value="<?php echo getHpwAccount();?>"/></td>
                    </tr>
                    <tr>
                        <td>বিভাগ</td>
                        <td>: <select  name ="division_id" id="division_id" class="box2" onChange="getDistrict()" >
                                 <option value="all">- বিভাগ -</option>
                            <?php
                            $division_sql = mysql_query("SELECT * FROM " . $dbname . ".division ORDER BY division_name ASC");
                            while ($division_rows = mysql_fetch_array($division_sql)) {
                                $db_division_id = $division_rows['idDivision'];
                                $db_division_name = $division_rows['division_name'];
                                if ($db_division_name == $selected_division_name) {
                                    echo "<option value='$db_division_id' selected=\"selected\">$db_division_name</option>";
                                } else {
                                    echo "<option value='$db_division_id'>$db_division_name</option>";
                                }
                            }
                            ?>
                            </select>    
                        </td>                                      
                    </tr><tr>
                        <td>জেলা</td>
                        <td>: <span id="did">
                                <select name="district_id"  id="district_id"  class="box2"  onchange="getThana()">
                                 <option value="">- জেলা -</option>
                                <?php
                                $district_res = mysql_query("SELECT * FROM " . $dbname . ".district ORDER BY district_name ASC");
                                while ($district_rows = mysql_fetch_array($district_res)) {
                                    $db_district_id = $district_rows['idDistrict'];
                                    $db_district_name = $district_rows['district_name'];
                                    if ($db_district_name == $selected_district_name) {
                                        echo "<option value='$db_district_id' selected=\"selected\">$db_district_name</option>";
                                    } else {
                                        echo "<option value='$db_district_id'>$db_district_name</option>";
                                    }
                                }
                                ?>
                            </select>
                    </td>
                    </tr><tr>
                          <td>থানা</td>
                          <td>: <span id="tidd">
                                  <select class="box2" name= "thana_id" id="thana_id"> 
                                       <option value="">- থানা -</option>
                                      <?php 
                        $sql_thana= "SELECT * FROM  ".$dbname.".thana ORDER BY thana_name ASC";
                        $result_thana=  mysql_query($sql_thana);
                        while ($row_thana=  mysql_fetch_array($result_thana))
                        {
                                  $db_thana_id = $row_thana['idThana'];
                                    $db_thana_name = $row_thana['thana_name'];
                                    if ($db_thana_name == $selected_thana_name) {
                                        echo "<option value='$db_thana_id' selected=\"selected\">$db_thana_name</option>";
                                    } else {
                                        echo "<option value='$db_district_id'>$db_thana_name</option>";
                                    }
                        }
                        
                        ?>
                                  </select><em2> *</em2>
                          </td></tr>
                           <tr>
                        <td>পাওয়ারস্টোরের ঠিকানা</td>
                        <td>:    <input  class ="textfield" type="text" id="office_address_" name="office_address" /><em2> *</em2></td>
                    </tr>
                           <tr>
                        <td>পাওয়ারস্টোরের নাম্বার</td>
                        <td>:    <input  class ="textfield" type="text" id="office_no" name="office_no" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" ><hr /></td>
                    </tr>
                    <tr>	
                        <td  colspan="2" style =" font-size: 14px"><b>অবস্থান নির্ণয়</b></td>    
                    </tr>
                    <tr>
                        <td>অফিস স্পেস</td>
                        <td >:   <input class="textfield" type="text" id="office_space" name="office_space" />&nbsp;স্কয়ার ফিট </td>
                    </tr>
                    <tr>
                        <td  >ভবনের ধরন</td>
                        <td >:   <input class="textfield" type="text" id="building_type" name="building_type" /></td>
                    </tr>
                    <tr>
                        <td >ফ্লোর নাম্বার</td>
                        <td>:   <input class="textfield" type="text" id="floor_number" name="floor_number" /><em2> *</em2> </td>
                    </tr>   
                    <tr>
                        <td colspan="2" ><hr /></td>
                    </tr>
                    <tr>	
                        <td  colspan="2" style =" font-size: 14px"><b>অফিস খরচ </b></td>    
                    </tr>
                    <tr>
                        <td  >ভাড়া</td>
                        <td >:   <input class="textfield" style="text-align: right" type="text" id="office_rent1" name="office_rent1" onkeypress="return numbersonly(event)" />
                            . <input class="boxTK" type="text" maxlength="2"  id="office_rent2" name="office_rent2"  onkeypress=" return numbersonly(event)"/>TK <em> (ইংরেজিতে লিখুন)</em><em2> *</em2></td>
                        
                    </tr>
                    <tr>
                        <td  >কারেন্ট বিল</td>
                        <td >:   <input class="textfield" style="text-align: right" type="text" id="electicity_bill1" name="electicity_bill1" onkeypress="return numbersonly(event)" />
                            . <input class="boxTK" type="text" maxlength="2"  id="electicity_bill2" name="electicity_bill2" onkeypress="return numbersonly(event)" />TK<em> (ইংরেজিতে লিখুন)</em></td>
                    </tr>
                    <tr>
                        <td >পানি বিল</td>
                        <td>:   <input class="textfield" style="text-align: right" type="text" id="water_bill1" name="water_bill1" onkeypress="return numbersonly(event)" />
                            . <input class="boxTK" type="text" maxlength="2" id="water_bill2" name="water_bill2" onkeypress="return numbersonly(event)" />TK<em> (ইংরেজিতে লিখুন)</em> </td>
                    </tr> 
                    <tr>
                        <td colspan="2" ><hr /></td>
                    </tr>
                    <tr>	
                        <td  colspan="2" style =" font-size: 14px"><b>প্রারম্ভিক খরচ</b></td>    
                    </tr>
                    <tr>
                        <td >অগ্রিম</td>
                        <td >:   <input class="textfield" style="text-align: right" type="text" id="advanced_payment1" name="advanced_payment1"  onkeypress="return numbersonly(event)" />
                            . <input class="boxTK" type="text" maxlength="2" id="advanced_payment2" name="advanced_payment2" onkeypress="return numbersonly(event)" />TK<em> (ইংরেজিতে লিখুন)</em><em2> *</em2></td>
                    </tr>
                    <tr>
                        <td  >ডেকোরেশন</td>
                        <td >:   <input class="textfield" style="text-align: right" type="text" id="decoration1" name="decoration1" onkeypress="return numbersonly(event)" />
                            . <input class="boxTK" type="text" maxlength="2" id="decoration2" name="decoration2" onkeypress="return numbersonly(event)" />TK<em> (ইংরেজিতে লিখুন)</em></td>
                    </tr>
                    <tr>
                        <td colspan="2" >                
                    <tr>
                        <td style="padding-top: 14px;vertical-align: top; width: 25%;">অন্যান্য</td>
                        <td>
                            <table id="container_others">
                                <tr>
                                     <td>বিষয়  :</td>
                                      <td>পরিমান : <em> (ইংরেজিতে লিখুন)</em></td>
                                 </tr>
                                <tr>
                                    <td><input class="textfield" id="sub" name="sub[]"  type="text" /></td>
                                    <td><input class="textfield" style="text-align: right" id="quantity1" name="quantity1[]" type="text" onkeypress="return numbersonly(event)" />  
                                        . <input class="boxTK" maxlength="2" id="quantity2" name="quantity2[]" type="text" onkeypress="return numbersonly(event)" /> TK</td>
                                    <td><input type="button" class="add" /></td>
                              </tr>
                            </table>
                        </td>
                    </tr>                  
                    </td>
                    </tr> 
                    <tr>
                        <td colspan="2" ><hr /></td>
                    </tr>
                    <tr>	
                        <td  colspan="2" style =" font-size: 14px"><b>চুক্তি</b></td>    
                    </tr>
                    <tr>
                        <td >মালিকের নাম</td>
                        <td >:   <input class="textfield" type="text" id="owner_Name" name="owner_Name" /><em2> *</em2></td>
                    </tr>
                    <tr>
                        <td  >বাসার ঠিকানা</td>
                        <td >:   <input class="textfield" type="text" id="owner_address" name="owner_address" /></td>
                    </tr>
                    <tr>
                        <td >মোবাইল নাম্বার</td>
                        <td>:   <input class="textfield" type="text" id="mobile_number" name="mobile_number" onkeypress=' return numbersonly(event)'/> <em> (ইংরেজিতে লিখুন)</em><em2> *</em2></td>
                    </tr>
                    <tr>
                        <td >ই-মেইল</td>
                        <td>:   <input class="textfield" type="text" id="mail_address" name="mail_address" onblur="check2(this.value)" /><em> (ইংরেজিতে লিখুন)</em><div id="error_msg2" style="margin-left: 5px"></div></td>
                    </tr>
                    <tr>
                        <td >চুক্তির বৈধতা</td>
                        <td>:   <input class="textfield" type="text" id="validity" placeholder="Date" name="validity" value=""/> </td>
                    </tr>
                    <tr>
                        <td >ছবি</td>
                        <td >:   <input type="file" name="image" style="font-size:10px;"/> </td>
                    </tr>
                    <tr>
                        <td >স্বাক্ষর</td>
                        <td >:   <input class="filefield" type="file" id="signature" name="signature" style="font-size:10px;"/> </td>
                    </tr>         
                    <tr>
                        <td >  টিপসই</td>
                        <td >:   <input class="filefield" type="file" id="owner_finger_print" name="owner_finger_print" style="font-size:10px;"/> </td>
                    </tr>        
                    <tr>
                        <td >স্ক্যানড ডকুমেন্টস</td>
                        <td >:   <input class="filefield" type="file" id="scanDoc" name="scanDoc" style="font-size:10px;"/> </td>
                    </tr>
                    <tr>                    
                        <td colspan="4" style="padding-left: 250px; " >
                            <input class="btn" style =" font-size: 12px " type="submit" name="submit0" id="submit0" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" />             
                        </td>                           
               </table>
            </form>
        </div>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>