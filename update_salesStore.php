<?php
/*
 * This page is used as an inner page for sales store update. so this is not a main page and need not to assing security rule
 */
error_reporting(0);
include_once 'includes/header.php';

$x = $_GET['id'];
$salesid = base64_decode($x);
$all = "SELECT * FROM sales_store WHERE idSales_store=$salesid ";
$allsql = mysql_query($all) or exit('query failed????????: ' . mysql_error());
while ($sale_row = mysql_fetch_assoc($allsql)) {
    $name = $sale_row['salesStore_name'];
    $sales_add = $sale_row['salesStore_details_address'];
    $sales_no = $sale_row['salesStore_number'];
    $sales_mail = $sale_row['salesStore_email'];
    $sales_acc = $sale_row['account_number'];
    $salesstore_banner_old =  $sale_row['sstore_banner'];
    $sale_thana = $sale_row['Thana_idThana'];
}
$onsq = "SELECT * FROM " . $dbname . ".`ons_relation` WHERE add_ons_id=$salesid AND catagory= 's_store' ";
$onssql = mysql_query($onsq) or exit('query failed: ' . mysql_error());
while ($ons_row = mysql_fetch_assoc($onssql)) {
    $idons = $ons_row['idons_relation'];
}

$info = "SELECT * FROM " . $dbname . ".`ons_information` WHERE ons_relation_idons_relation=$idons";
$infosql = mysql_query($info) or exit('query failed: ' . mysql_error());
while ($info_row = mysql_fetch_assoc($infosql)) {
    $space = $info_row['space'];
    $b_type = $info_row['building_type'];
    $floor = $info_row['floor'];
    $info_id = $info_row['idons_information'];
}
$deed = "SELECT * FROM " . $dbname . ".`ons_deed` WHERE ons_relation_idons_relation=$idons";
$deedsql = mysql_query($deed) or exit('query failed: ' . mysql_error());
while ($deed_row = mysql_fetch_assoc($deedsql)) {
    $oname = $deed_row['owner_name'];
    $oaddress = $deed_row['owner_address'];
    $ombl = $deed_row['cell_number'];
    $omail = $deed_row['owner_email'];
    $ophoto = $deed_row['owner_photo'];
    $ophotoname = end(explode("/", $ophoto));
    $osign = $deed_row['owner_signature'];
    $osignname = end(explode("/", $osign));
    $oscanDoc = $deed_row['scan_documents'];
    $oscanDocname = end(explode("/", $oscanDoc));
    $ofinger = $deed_row['owner_fingerprint'];
    $ofingername = end(explode("/", $ofinger));
    $oexpire = $deed_row['expire_date'];
    $deedid = $deed_row['idons_deed'];
}
$cost = "SELECT * FROM " . $dbname . ".`ons_cost` WHERE ons_relation_idons_relation=$idons";
$costsql = mysql_query($cost) or exit('query failed: ' . mysql_error());
while ($cost_row = mysql_fetch_assoc($costsql)) {
    $costid = $cost_row['idons_cost'];
    $rent = $cost_row['rent'];
    $rentINT = (int) $rent;
    list($before_dot, $after_dot) = explode('.', $rent);
    $rentDeci = substr($after_dot, 0, 2);
    $current = $cost_row['current_bill'];
    $currentINT = (int) $current;
    list($before_dot, $after_dot) = explode('.', $current);
    $currentDeci = substr($after_dot, 0, 2);
    $water = $cost_row['water_bill'];
    $waterINT = (int) $water;
    list($before_dot, $after_dot) = explode('.', $water);
    $waterDeci = substr($after_dot, 0, 2);
    $advanced = $cost_row['advanced_amount'];
    $advancedINT = (int) $advanced;
    list($before_dot, $after_dot) = explode('.', $advanced);
    $advancedDeci = substr($after_dot, 0, 2);
    $decoration = $cost_row['decoration'];
    $decorationINT = (int) $decoration;
    list($before_dot, $after_dot) = explode('.', $decoration);
    $decorationDeci = substr($after_dot, 0, 2);
    $idcost = $cost_row['idons_cost'];
}
$count = 0;
$othercost = "SELECT * FROM " . $dbname . ".`ons_cost_others` WHERE ons_cost_idons_cost=$costid";
$othercostsql = mysql_query($othercost) or exit('query failed: ' . mysql_error());

while ($othercost_row = mysql_fetch_assoc($othercostsql)) {
    $sub[$count] = $othercost_row['cost_type'];
    $quan[$count] = $othercost_row['cost_amount'];
    $quanINT[$count] = (int) $quan[$count];
    list($before_dot, $after_dot) = explode('.', $quan[$count]);
    $quanDeci = substr($after_dot, 0, 2);
    $count++;
}
$otherID = $othercost_row['idons_cost_others'];

//********************** update query**************
if (isset($_POST['submit03'])) {
    $off_name = $_POST['sales_name'];
    $off_add = $_POST['sales_address'];
    $sstore_old_banner = $_POST['salsestore_old_banner'];
    
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
        $extension = end(explode(".", $_FILES["sstore_banner_upload"]["name"]));
        $salesstorebanner_name = $_FILES["sstore_banner_upload"]["name"];
        if($salesstorebanner_name != "")
        {
            $salesstorebanner_name = $sales_acc."-". $_FILES["sstore_banner_upload"]["name"];
        if (($_FILES["sstore_banner_upload"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                {            
                $salesstorebanner_path = "images/banners/".$salesstorebanner_name;
                move_uploaded_file($_FILES["sstore_banner_upload"]["tmp_name"], "images/banners/" . $salesstorebanner_name);                        
                } 
        else{
            $salesstorebanner_path = $sstore_old_banner;
            }
        }else{
            $salesstorebanner_path = $sstore_old_banner;
        }
    
    $offup = "UPDATE `sales_store` SET `salesStore_name` = '$off_name', `salesStore_details_address` = '$off_add', `sstore_banner` = '$salesstorebanner_path' WHERE `sales_store`.`idSales_store` =$salesid AND `sales_store`.`Thana_idThana` =$sale_thana;";
    $offupsql = mysql_query($offup) or exit('query failed: ' . mysql_error());
    echo "<script type='text/javascript'>window.location.href = window.location; </script>";
}
if (isset($_POST['submit02'])) {
    $b_space = $_POST['office_space'];
    $b_type = $_POST['building_type'];
    $b_floor = $_POST['floor_number'];
    $infoup = "UPDATE `ons_information` SET `space` = '$b_space', `building_type` = '$b_type', `floor` = '$floor' WHERE `ons_information`.`idons_information` =$info_id  AND `ons_information`.`ons_relation_idons_relation` =$idons;";
    $infoupsql = mysql_query($infoup) or exit('query failed: ' . mysql_error());
    echo "<script type='text/javascript'>window.location.href = window.location; </script>";
}
if (isset($_POST['submit01'])) {
    $rent1 = $_POST['office_rent1'];
    $rent2 = $_POST['office_rent2'];
    $rent = $rent1 . "." . $rent2;
    $e_bill1 = $_POST['electicity_bill1'];
    $e_bill2 = $_POST['electicity_bill2'];
    $e_bill = $e_bill1 . "." . $e_bill2;
    $w_bill1 = $_POST['water_bill1'];
    $w_bill2 = $_POST['water_bill2'];
    $w_bill = $w_bill1 . "." . $w_bill2;
    $adv_pay1 = $_POST['advanced_payment1'];
    $adv_pay2 = $_POST['advanced_payment2'];
    $adv_pay = $adv_pay1 . "." . $adv_pay2;
    $deco1 = $_POST['decoration1'];
    $deco2 = $_POST['decoration2'];
    $deco = $deco1 . "." . $deco2;
    $costup = "UPDATE `ons_cost` SET `rent`= '$rent', `current_bill` = '$e_bill', `water_bill` = '$w_bill',`advanced_amount` = '$adv_pay', `decoration` = '$deco' WHERE `ons_cost`.`idons_cost` =$costid AND `ons_cost`.`ons_relation_idons_relation` =$idons;";

    $otherdel = "DELETE FROM `ons_cost_others` WHERE `ons_cost_others`.`ons_cost_idons_cost` = $costid;";
    $delsql = mysql_query($otherdel) or exit('query failed: ' . mysql_error());
    $sub = $_POST['sub'];
    $quan1 = $_POST['quantity1'];
    $quan2 = $_POST['quantity2'];
    $n = count($sub);
    for ($i = 0; $i < $n; $i++) {
        $quan[$i] = $quan1[$i] . "." . $quan2[$i];
        $osql = "INSERT INTO " . $dbname . ".`ons_cost_others` (`cost_type` ,`cost_amount` ,`ons_cost_idons_cost`) VALUES ( '$sub[$i]',  '$quan[$i]', '$costid');";
        $oreslt = mysql_query($osql) or exit('query failed: ' . mysql_error());
    }

    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["image"]["name"]));
    $image_name = $_FILES["image"]["name"];
    if ($image_name == "") {
        $image_name = $ophotoname;
        $image_path = "pic/" . $image_name;
    } else {
        $image_name = $sales_acc . "-" . $image_name;
        $image_path = "pic/" . $image_name;
        if (($_FILES["image"]["size"] < 999999999999) && in_array($extension, $allowedExts)) {
            if (file_exists("pic/" . $image_name))
                echo "Photo: \"" . $_FILES["image"]["name"] . "\" already exists. ";
            else {
                move_uploaded_file($_FILES["image"]["tmp_name"], "pic/" . $image_name);
            }
        } else {
            echo "Invalid file format.";
        }
    }

    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["signature"]["name"]));
    $sign_name = $_FILES["signature"]["name"];
    if ($sign_name == "") {
        $sign_name = $osignname;
        $sing_path = "sign/" . $sign_name;
    } else {
        $sign_name = $sales_acc . "-" . $sign_name;
        $sing_path = "sign/" . $sign_name;
        if (($_FILES["signature"]["size"] < 999999999999) && in_array($extension, $allowedExts)) {

            if (file_exists("sign/" . $sign_name))
                echo "Photo: \"" . $_FILES["signature"]["name"] . "\" already exists. ";
            else {
                move_uploaded_file($_FILES["signature"]["tmp_name"], "sign/" . $sign_name);
            }
        } else {
            echo "Invalid file format.";
        }
    }
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["owner_finger_print"]["name"]));
    $finger_name = $_FILES["owner_finger_print"]["name"];
    if ($finger_name == "") {
        $finger_name = $ofingername;
        $finger_path = "fingerprints/" . $finger_name;
    } else {
        $finger_name = $sales_acc . "-" . $finger_name;
        $finger_path = "fingerprints/" . $finger_name;
        if (($_FILES["owner_finger_print"]["size"] < 999999999999) && in_array($extension, $allowedExts)) {

            if (file_exists("fingerprints/" . $finger_name))
                echo "Photo: \"" . $_FILES["owner_finger_printt"]["name"] . "\" already exists. ";
            else {
                move_uploaded_file($_FILES["owner_finger_print"]["tmp_name"], "fingerprints/" . $finger_name);
            }
        } else {
            echo "Invalid file format.";
        }
    }
    
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["scanDoc"]["name"]));
    $scan_name = $_FILES["scanDoc"]["name"];
    if ($scan_name == "") {
        $scan_name = $oscanDocname;
        $scan_path = "scaned/" . $scan_name;
    } else {
        $scan_name = $sales_acc . "-" . $scan_name;
        $scan_path = "scaned/" . $scan_name;
        if (($_FILES["scanDoc"]["size"] < 999999999999) && in_array($extension, $allowedExts)) {

            if (file_exists("scaned/" . $scan_name))
                echo "Photo: \"" . $_FILES["scanDoc"]["name"] . "\" already exists. ";
            else {
                move_uploaded_file($_FILES["scanDoc"]["tmp_name"], "scaned/" . $scan_name);
            }
        } else {
            echo "Invalid file format.";
        }
    }
    $own_name = $_POST['owner_Name'];
    $own_add = $_POST['owner_address'];
    $own_mbl = $_POST['mobile_number'];
    $own_mail = $_POST['mail_address'];
    $own_valid = $_POST['validity'];
    $deedup = "UPDATE `ons_deed` SET `owner_name`='$own_name',`owner_address` = '$own_add', `cell_number` = '$own_mbl', `owner_email`='$mail', `owner_photo`='$image_path', `owner_signature`='$sing_path', `expire_date`='$own_valid', `scan_documents`='$scan_path', `owner_fingerprint`='$finger_path' WHERE `ons_deed`.`idons_deed` =$deedid AND `ons_deed`.`ons_relation_idons_relation` =$idons;";
    $deedupsql = mysql_query($deedup) or exit('query failed: ' . mysql_error());
    echo "<script type='text/javascript'>window.location.href = window.location; </script>";
}
?>
<title>আপডেট সেলসস্টোর</title>
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
        var appendTxt= "<tr><td colspan='2'><input class='textfield'  id='sub' name='sub[]' type='text' /></td><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class='textfield' style='text-align: right' id='quantity1' name='quantity1[]' type='text' onkeypress='return numbersonly(event)' />\n\
                                        . <input class='boxTK' id='quantity2' name=quantity2[]' type='text' onkeypress='return numbersonly(event)'/> TK</td>\n\
                                         <td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' class='del' /></td><td><input type='button' class='add' /></td><?php $new++;
echo $new;
?></tr>";
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
<script type="text/javascript">
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
</script>

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="update_salesStore_account.php"><b>ফিরে যান</b></a></div>
        <div>
            <table  class="formstyle"  >   
                <tr><th colspan="4" style="text-align: center" colspan="2"><h1>আপডেট</h1></th></tr>
                <tr><td colspan="4" ></td></tr>
                <tr>
                    <td>
                        <div class="domtab" style="min-height: 100px !important;">
                            <ul class="domtabs" style="margin-left: 100px !important; width: 100% !important; margin-top: 30px !important;">
                                <li class="current"><a href="#01" style="width:14em !important;"> ইনস্ট্যান্ট পজিশন আপডেট</a></li>
                                <li class="current"><a href="#02"> এক্সচেঞ্জ পজিশন আপডেট</a></li>
                                <li class="current"><a href="#03"> শিফট আপডেট</a></li>
                            </ul>
                        </div>  
                    </td>
                </tr>
                <tr>                    
                    <td>
                        <div>
                            <a name="01" id="01"></a>
                            <form method="POST" enctype="multipart/form-data" action="" id="off_form" name="off_form">
                                <table>
                                    <tr>
                                        <td  colspan="2" style =" font-size: 14px"><b>সেলস স্টোরের খরচ </b></td>
                                    </tr>
                                    <tr>
                                        <td>ভাড়া</td>
                                        <td >: <input class="textfield" style="text-align: right" type="text" id="office_rent1" name="office_rent1" onkeypress="return numbersonly(event)" value="<?php echo $rentINT; ?>" />
                                            . <input class="boxTK" type="text" maxlength="2"  id="office_rent2" name="office_rent2"  onkeypress=" return numbersonly(event)" value="<?php echo $rentDeci; ?>"/>TK <em> (ইংরেজিতে লিখুন)</em>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  >কারেন্ট বিল</td>
                                        <td >:   <input class="textfield" style="text-align: right" type="text" id="electicity_bill1" name="electicity_bill1" onkeypress="return numbersonly(event)" value="<?php echo $currentINT; ?>"/>
                                            . <input class="boxTK" type="text" maxlength="2"  id="electicity_bill2" name="electicity_bill2" onkeypress="return numbersonly(event)" value="<?php echo $currentDeci; ?>"/>TK<em> (ইংরেজিতে লিখুন)</em></td>
                                    </tr>
                                    <tr>
                                        <td >পানি বিল</td>
                                        <td>:   <input class="textfield" style="text-align: right" type="text" id="water_bill1" name="water_bill1" onkeypress="return numbersonly(event)" value="<?php echo $waterINT; ?>"/>
                                            . <input class="boxTK" type="text" maxlength="2" id="water_bill2" name="water_bill2" onkeypress="return numbersonly(event)" value="<?php echo $waterDeci; ?>"/>TK<em> (ইংরেজিতে লিখুন)</em> </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="2" ><hr /></td>
                                    </tr>
                                    <tr>	
                                        <td  colspan="2" style =" font-size: 14px"><b>প্রারম্ভিক খরচ</b></td>    
                                    </tr>
                                    <tr>
                                        <td >অগ্রিম</td>
                                        <td >:   <input class="textfield" style="text-align: right" type="text" id="advanced_payment1" name="advanced_payment1"  onkeypress="return numbersonly(event)" value="<?php echo $advancedINT; ?>" />
                                            . <input class="boxTK" type="text" maxlength="2" id="advanced_payment2" name="advanced_payment2" onkeypress="return numbersonly(event)" value="<?php echo $advancedDeci; ?>"/>TK<em> (ইংরেজিতে লিখুন)</em></td>
                                    </tr>
                                    <tr>
                                        <td  >ডেকোরেশন</td>
                                        <td >:   <input class="textfield" style="text-align: right" type="text" id="decoration1" name="decoration1" onkeypress="return numbersonly(event)" value="<?php echo $decorationINT; ?>"/>
                                            . <input class="boxTK" type="text" maxlength="2" id="decoration2" name="decoration2" onkeypress="return numbersonly(event)" value="<?php echo $decorationDeci; ?>"/>TK<em> (ইংরেজিতে লিখুন)</em></td>
                                    </tr>              
                                    <tr>
                                        <td style="padding-top: 14px;vertical-align: top; width: 25%;">অন্যান্য</td>
                                        <td>
                                            <table id="container_others">
                                                <tr>
                                                    <td>বিষয়  :</td>
                                                    <td>পরিমান : <em> (ইংরেজিতে লিখুন)</em></td>
                                                </tr>
                                                <?php
                                                for ($i = 0; $i < $count; $i++) {
                                                    echo "<tr>";
                                                    echo "<td><input class='textfield' id='sub' name='sub[]'  type='text' value='$sub[$i]'/></td>";
                                                    echo"<td><input class='textfield' style='text-align: right' id='quantity1' name='quantity1[]' type='text' onkeypress='return numbersonly(event)' value='$quanINT[$i]' />
                                                            . <input class='boxTK' maxlength='2' id='quantity2' name='quantity2[]' type='text' onkeypress='return numbersonly(event)' value='$quanDeci[$i]' /> TK</td>";
                                                    if ($i == 0) {
                                                        echo "<td></td>";
                                                        echo "<td><input type='button' class='add' /></td>";
                                                    } else {
                                                        echo "<td><input type='button' class='del' /></td>";
                                                        echo "<td><input type='button' class='add' /></td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </table>
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
                                        <td >:   <input class="textfield" type="text" id="owner_Name" name="owner_Name" value="<?php echo $oname; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td  >বাসার ঠিকানা</td>
                                        <td >:   <input class="textfield" type="text" id="owner_address" name="owner_address" value="<?php echo $oaddress; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td >মোবাইল নাম্বার</td>
                                        <td>:   <input class="textfield" type="text" id="mobile_number" name="mobile_number" value="<?php echo $ombl; ?>"/> <em> (ইংরেজিতে লিখুন)</em></td>
                                    </tr>
                                    <tr>
                                        <td >ই-মেইল</td>
                                        <td>:   <input class="textfield" type="text" id="mail_address" name="mail_address" onblur="check2(this.value)" value="<?php echo $omail; ?>" /><em> (ইংরেজিতে লিখুন)</em><div id="error_msg2" style="margin-left: 5px"></div></td>
                                    </tr>
                                    <tr>
                                        <td >চুক্তির বৈধতা</td>
                                        <td>:   <input class="textfield" type="text" id="validity" placeholder="Date" name="validity" value="<?php echo $oexpire; ?>"/> </td>
                                    </tr>
                                    <tr>
                                        <td >ছবি</td>
                                        <td >: <img src="<?php echo $ophoto; ?>" width="80px" height="80px"/>&nbsp;<input type="file" name="image" style="font-size:10px;" /> </td>
                                    </tr>
                                    <tr>
                                        <td >স্বাক্ষর</td>
                                        <td >:  <img src="<?php echo $osign; ?>" width="80px" height="80px"/>&nbsp;<input class="filefield" type="file" id="signature" name="signature" style="font-size:10px;" /> </td>
                                    </tr>         
                                    <tr>
                                        <td >  টিপসই</td>
                                        <td >:   <img src="<?php echo $ofinger; ?>" width="80px" height="80px"/>&nbsp;<input class="filefield" type="file" id="owner_finger_print" name="owner_finger_print" style="font-size:10px;" /> </td>
                                    </tr>        
                                    <tr>
                                        <td >স্ক্যানড ডকুমেন্টস</td>
                                        <td >:   <img src="<?php echo $oscanDoc; ?>" width="80px" height="80px"/>&nbsp;<input class="filefield" type="file" id="scanDoc" name="scanDoc" style="font-size:10px;" /> </td>
                                    </tr>
                                    <tr>                    
                                        <td colspan="4" style="padding-left: 250px; " >
                                            </br><input class="btn" style =" font-size: 12px " type="submit" name="submit01" id="submit01" value="সেভ করুন" />
                                        </td>                           
                                    </tr>
                                </table>
                            </form>
                        </div>

                        <div>
                            <a name="02" id="02"></a><br/>
                            <form method="POST" enctype="multipart/form-data" action="" id="off_form" name="off_form">
                                <table>
                                    <tr>	
                                        <td  colspan="2" style =" font-size: 14px"><b>অবস্থান নির্ণয়</b></td>    
                                    </tr>
                                    <tr>
                                        <td>সেলস স্টোরের  স্পেস</td>
                                        <td >:   <input class="textfield" type="text" id="office_space" name="office_space" value="<?php echo $space; ?>"/>&nbsp;স্কয়ার ফিট </td>
                                    </tr>
                                    <tr>
                                        <td  >ভবনের ধরন</td>
                                        <td >:   <input class="textfield" type="text" id="building_type" name="building_type" value="<?php echo $b_type; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td >ফ্লোর নাম্বার</td>
                                        <td>:   <input class="textfield" type="text" id="floor_number" name="floor_number" value="<?php echo $floor; ?>"/></td>
                                    </tr>
                                    <tr>                    
                                        <td colspan="4" style="padding-left: 250px; " >
                                            </br><input class="btn" style =" font-size: 12px " type="submit" name="submit02" id="submit02" value="সেভ করুন" />
                                        </td>                           
                                    </tr>
                                </table>
                            </form>
                        </div>

                        <div>
                            <a name="03" id="03"></a><br/>
                            <form method="POST" enctype="multipart/form-data" action="" id="off_form" name="off_form">
                                <table>
                                    <tr>	
                                        <td  colspan="2" style =" font-size: 14px"><b>ঠিকানা</b></td>    
                                    </tr>
                                    <tr>
                                        <td>সেলস স্টোরের নাম</td>
                                        <td>:    <input  class ="textfield" type="text" id="sales_name" name="sales_name" value="<?php echo $name; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>সেলস স্টোরের  ঠিকানা</td>
                                        <td>:    <input  class ="textfield" type="text" id="sales_address" name="sales_address" value="<?php echo $sales_add; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>সেলস স্টোরের  নাম্বার</td>
                                        <td>:    <input  class ="textfield" type="text" readonly="" id="sales_no" name="sales_no" value="<?php echo $sales_no; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>সেলস স্টোরের  ইমেইল</td>
                                        <td>:    <input  class ="textfield" type="text" readonly="" id="sales_mail" name="sales_mail" value="<?php echo $sales_mail; ?>" /><em> (ইংরেজিতে লিখুন)</em><div id="error_msg" style="margin-left: 5px"></div></td>
                                    </tr>
                                    <tr>
                                        <td >সেলস স্টোর ব্যানার</td>
                                        <td >: <img src="<?php echo $salesstore_banner_old; ?>" width="500px" height="110px"/>&nbsp;<input type="file" name="sstore_banner_upload" style="font-size:10px;" /> 
                                        <input type="hidden" name="salsestore_old_banner" id="salsestore_old_banner" value="<?php echo $salesstore_banner_old; ?>" /></td></td>
                                    </tr>
                                    <tr>                    
                                        <td colspan="4" style="padding-left: 250px; " >
                                            </br><input class="btn" style =" font-size: 12px " type="submit" name="submit03" id="submit03" value="সেভ করুন" />
                                        </td>                           
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </td>                           
                </tr> 
            </table>
            </fieldset>
            </form>
        </div>
    </div>         
<?php include_once 'includes/footer.php'; ?>