<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/areaSearch2.php';
$x= $_GET['id'];
$custAcid = base64_decode($x);
?>
<title>ক্রিয়েট কাস্টমার অ্যাকাউন্ট</title>
<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/area2.js"></script>
<script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>
<script type="text/javascript"> 
    $('.del').live('click',function(){
        $(this).parent().parent().remove();
    });
    $('.add').live('click',function()
    {var count1 = 2;
        if(count1<4){            
            var appendTxt= "<tr><td > <select class='box2' name='m_children_age[]' style ='font-size: 11px'><option>একটি নির্বাচন করুন</option> \n\
<?php
for ($i = 4; $i <= 30; $i++) {
    //echo "$count1";
    $age = english2bangla($i);
    echo "<option value='$age'>" . $age . "</option>";
}
?></select> </td> \n\
                <td style= 'padding-left: 95px;' >  <select class='box2' name='m_children_class[]' style ='font-size: 11px'><option>একটি নির্বাচন করুন</option> \n\
<?php
for ($i = 0; $i <= 18; $i++) {
    $class = number($i);
    echo "<option value='$class'>" . $class . "</option>";
}
?></select> </td><td style= 'padding-left: 60px;'><input type='button' class='del' /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' class='add' /></td>"+count1
            "</tr>";
            $("#container_others30:last").after(appendTxt);
            
        }  
        count1 = count1 + 1;     
    })
            
    $('.del1').live('click',function(){
        $(this).parent().parent().remove();
    });
    $('.add1').live('click',function()
    {var count2 = 2;
        if(count2<6){
            var appendTxt= "<tr><td><select class='box2' name='f_children_age[]' style ='font-size: 11px'><option>একটি নির্বাচন করুন</option> \n\
<?php
for ($i = 4; $i <= 30; $i++) {
    $age = english2bangla($i);
    echo "<option value='$age'>" . $age . "</option>";
}
?></select> </td> \n\
                <td style= 'padding-left: 115px;'>  <select class='box2' name='f_children_class[]' style ='font-size: 11px'><option>একটি নির্বাচন করুন</option> \n\
<?php
for ($i = 0; $i <= 18; $i++) {
    $class = number($i);
    echo "<option value='$class'>" . $class . "</option>";
}
?></select> </td><td style= 'padding-left: 35px;'><input type='button' class='del1' /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' class='add1' /></td></tr>";
            $("#container_others31:last").after(appendTxt);           
        }  
        count2 = count2 + 1;        
    })
    
    $('.del2').live('click',function(){
        $(this).parent().parent().remove();
    });
    $('.add2').live('click',function()
    {var count3 = 2;
        if(count3<6){
            var appendTxt= "<tr> <td><input class='textfield'  name='c_ex_name[]' type='text' /></td><td><input class='box5'  name='c_pass_year[]' type='text' /></td><td><input class='textfield'  name='c_institute[]' type='text' /></td><td><input class='textfield'  name='c_board[]' type='text' /></td><td><input class='box5' name='c_gpa[]' type='text' /></td><td style='padding-right: 3px;'><input type='button' class='del2' /></td><td>&nbsp;<input type='button' class='add2' /></td></tr>";
            $("#container_others32:last").after(appendTxt);          
        }  
        count3 = count3 + 1;        
    })
          
    $('.del3').live('click',function(){
        $(this).parent().parent().remove();
    });
    $('.add3').live('click',function()
    {var count4 = 2;
        if(count4<6){
            var appendTxt= "<tr> <td><input class='textfield'  name='n_ex_name[]' type='text' /></td><td><input class='box5'  name='n_pass_year[]' type='text' /></td><td><input class='textfield'  name='n_institute[]' type='text' /></td><td><input class='textfield'  name='n_board[]' type='text' /></td><td><input class='box5' name='n_gpa[]' type='text' /></td><td style='padding-right: 3px;'><input type='button' class='del3' /></td><td>&nbsp;<input type='button' class='add3' /></td></tr>";
            $("#container_others33:last").after(appendTxt);           
        }  
        count4 = count4 + 1;        
    })
        
</script>
<?php
if (isset($_POST['submit1'])) {
    $cust_father_name = $_POST['cust_father_name'];
    $cust_mother_name = $_POST['cust_mother_name'];
    $cust_spouse_name = $_POST['cust_spouse_name'];
    $cust_family_member = $_POST['cust_family_member'];
    $cust_son_no = $_POST['cust_son_no'];
    $cust_daughter_no = $_POST['cust_daughter_no'];
    $cust_son_student_no = $_POST['cust_son_student_no'];
    $cust_daughter_student_no = $_POST['cust_daughter_student_no'];
    $cust_occupation = $_POST['cust_occupation'];
    $cust_religion = $_POST['cust_religion'];
    $cust_nationality = $_POST['cust_nationality'];
    $cust_nationalID_no = $_POST['cust_nationalID_no'];
    $cust_passportID_no = $_POST['cust_passportID_no'];
    $birth_certificate_no = $_POST['birth_certificate_no'];
    $cust_gurdian_name = $_POST['cust_gurdian_name'];
    $cust_gurdian_relation = $_POST['cust_gurdian_relation'];
    $cust_gurdian_mobile = $_POST['cust_gurdian_mobile'];
    $cust_gurdian_email = $_POST['cust_gurdian_email'];
    $cust_gurdian_education = $_POST['cust_gurdian_education'];
    $cust_gurdian_nationalID_no = $_POST['cust_gurdian_nationalID_no'];
    $cust_gurdian_passportID_no = $_POST['cust_gurdian_passportID_no'];
    $dob = $_POST['dob'];
    // picture, sign, fingerprint**********************************************************************************************
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["image"]["name"]));
    $image_name = $_FILES["image"]["name"];
    if($image_name=="")
        {
            $image_name= "cust-".$custAcid."-".$_POST['imagename'];
             $image_path = "pic/" . $image_name;
        }
        else
        {
            $image_name = "cust-".$custAcid."-image.".$extension;
            $image_path = "pic/" . $image_name;
            if (($_FILES["image"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                    {
                        move_uploaded_file($_FILES["image"]["tmp_name"], "pic/" . $image_name);
                    } 
            else 
                    {
                    echo "Invalid file format.";
                    }
        }
    $extension = end(explode(".", $_FILES["scanDoc_signature"]["name"]));
    $sign_name = $_FILES["scanDoc_signature"]["name"];
    if($sign_name=="")
        {
            $sign_name= "cust-".$custAcid."-".$_POST['signname'];
             $sing_path = "sign/" . $sign_name;
        }
        else
        {
            $sign_name = "cust-".$custAcid."-sign.".$extension;
            $sing_path = "sign/" . $sign_name;
            if (($_FILES["scanDoc_signature"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                    {
                        move_uploaded_file($_FILES["scanDoc_signature"]["tmp_name"], "sign/" . $sign_name);
                    } 
            else 
                    {echo "Invalid file format.";}
        }

    $extension = end(explode(".", $_FILES["scanDoc_finger_print"]["name"]));
    $finger_name = $_FILES["scanDoc_finger_print"]["name"];
    if($finger_name=="")
        {
            $finger_name= "cust-".$custAcid."-".$_POST['fingername'];
             $finger_path = "fingerprints/" . $finger_name;
        }
        else
        {
            $finger_name = "cust-".$custAcid."-finger.".$extension;
            $finger_path = "fingerprints/" . $finger_name;
            if (($_FILES["scanDoc_finger_print"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                    {
                        move_uploaded_file($_FILES["scanDoc_finger_print"]["tmp_name"], "fingerprints/" . $finger_name);
                    } 
            else 
                    {
                    echo "Invalid file format.";
                    }
        }

    $extension = end(explode(".", $_FILES["cust_gurd_scanpic"]["name"]));
    $gurdimage_name = $_FILES["cust_gurd_scanpic"]["name"];
    if($gurdimage_name=="")
        {
            $gurdimage_name= "gurd-".$custAcid."-". $_POST['gurdimagename'];
             $gimage_path = "pic/" . $gurdimage_name;
        }
        else
        {
            $gurdimage_name = "gurd-".$custAcid."-guardpic.".$extension;
            $gimage_path = "pic/" . $gurdimage_name;
            if (($_FILES["cust_gurd_scanpic"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                    {
                        move_uploaded_file($_FILES["cust_gurd_scanpic"]["tmp_name"], "pic/" . $gurdimage_name);
                    } 
            else 
                    {
                    echo "Invalid file format.";
                    }
        }
    //************ scandocs **********************************************************************************************************

    $extension = end(explode(".", $_FILES["scanDoc_birth_certificate"]["name"]));
   $dob_name = $_FILES["scanDoc_birth_certificate"]["name"];
    if($dob_name=="")
        {
            $dob_name= "DOB-".$custAcid."-".$_POST['DOBCname'];
             $dob_path = "scaned/" . $dob_name;
        }
        else
        {
            $dob_name = "DOB-".$custAcid."-scandoc.".$extension;
            $dob_path = "scaned/" . $dob_name;
            if (($_FILES["scanDoc_birth_certificate"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                    {
                        move_uploaded_file($_FILES["scanDoc_birth_certificate"]["tmp_name"], "scaned/" . $dob_name);
                    } 
            else 
                    {
                    echo "Invalid file format.";
                    }
        }

    $extension = end(explode(".", $_FILES["scanDoc_national_id"]["name"]));
    $nid_name = $_FILES["scanDoc_national_id"]["name"];
    if($nid_name=="")
        {
            $nid_name= "NID-".$custAcid."-".$_POST['NIDCname'];
             $nid_path = "scaned/" . $nid_name;
        }
        else
        {
            $nid_name = "NID-".$custAcid."-scandoc.".$extension;
            $nid_path = "scaned/" . $nid_name;
            if (($_FILES["scanDoc_national_id"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                    {
                        move_uploaded_file($_FILES["scanDoc_national_id"]["tmp_name"], "scaned/" . $nid_name);
                    } 
            else 
                    {
                    echo "Invalid file format.";
                    }
        }

    $extension = end(explode(".", $_FILES["scanDoc_chairman_certificate"]["name"]));
    $cc_name = $_FILES["scanDoc_chairman_certificate"]["name"];
    if($cc_name=="")
        {
            $cc_name= "CC-".$custAcid."-".$_POST['CCname'];
             $cc_path = "scaned/" . $cc_name;
        }
        else
        {
            $cc_name = "CC-".$custAcid."-scandoc.".$extension;
            $cc_path = "scaned/" . $cc_name;
            if (($_FILES["scanDoc_chairman_certificate"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                    {
                        move_uploaded_file($_FILES["scanDoc_chairman_certificate"]["tmp_name"], "scaned/" . $cc_name);
                    } 
            else 
                    {
                    echo "Invalid file format.";
                    }
        }
        mysql_query("START TRANSACTION");
    $sql_update_customer = mysql_query("UPDATE customer_account SET cust_father_name='$cust_father_name', cust_mother_name='$cust_mother_name', cust_spouse_name='$cust_spouse_name', cust_family_member='$cust_family_member', cust_son_no='$cust_son_no', cust_daughter_no='$cust_daughter_no', 
                                                        cust_son_student_no='$cust_son_student_no', cust_daughter_student_no='$cust_daughter_student_no', cust_occupation='$cust_occupation', cust_religion='$cust_religion', cust_nationality='$cust_nationality', cust_nationalID_no='$cust_nationalID_no', 
                                                        cust_passportID_no='$cust_passportID_no', cust_date_of_birth='$dob', birth_certificate_no='$birth_certificate_no', cust_gurdian_name='$cust_gurdian_name', cust_gurdian_relation='$cust_gurdian_relation', cust_gurdian_mobile='$cust_gurdian_mobile', 
                                                        cust_gurdian_email='$cust_gurdian_email', cust_gurdian_nationalID_no='$cust_gurdian_nationalID_no', cust_gurdian_passportID_no='$cust_gurdian_passportID_no', cust_gurdian_education='$cust_gurdian_education', scanDoc_national_id='$nid_path', 
                                                        scanDoc_birth_certificate='$dob_path', scanDoc_chairman_certificate='$cc_path', scanDoc_picture='$image_path', scanDoc_signature='$sing_path',  scanDoc_finger_print='$finger_path', cust_gurd_scanpic = '$gimage_path'
                                                        WHERE idCustomer_account=$custAcid ");
    //male child
    $m_children_age = $_POST['m_children_age'];
    $m_children_class = $_POST['m_children_class'];
    $del_m_children = mysql_query("DELETE FROM children WHERE type='M' AND Customer_account_idCustomer_account=$custAcid");
    $n1 = count($m_children_age);
    for ($i1 = 0; $i1 < $n1; $i1++) {
        $sql_insert_malechild = "INSERT INTO `children` ( `children_age` ,`children_class` ,`type`,`Customer_account_idCustomer_account`) VALUES ('$m_children_age[$i1]', '$m_children_class[$i1]','M',$custAcid)";
        $child_male = mysql_query($sql_insert_malechild);
    }
    //female child
    $f_children_age = $_POST['f_children_age'];
    $f_children_class = $_POST['f_children_class'];
    $m = count($f_children_age);
    $del_f_children = mysql_query("DELETE FROM children WHERE type='F' AND Customer_account_idCustomer_account=$custAcid");
    for ($i = 0; $i < $m; $i++) {
        $sql_insert_femalechild = "INSERT INTO " . $dbname . ".`children` ( `children_age` ,`children_class` ,`type`,`Customer_account_idCustomer_account`) VALUES ('$f_children_age[$i]', '$f_children_class[$i]','F','$custAcid');";
        $child_female = mysql_query($sql_insert_femalechild);
    }
    
     //Current Address Infromation
    $g_Village_idVillage = $_POST['vilg_id4'];
    $g_Post_idPost = $_POST['post_id4'];
    $g_Thana_idThana = $_POST['thana_id4'];
    $g_house = $_POST['g_house'];
    $g_house_no = $_POST['g_house_no'];
    $g_road = $_POST['g_road'];
    $g_post_code = $_POST['g_post_code'];
    //Permanent Address information
    $gp_Village_idVillage = $_POST['vilg_id5'];
    $gp_Post_idPost = $_POST['post_id5'];
    $gp_Thana_idThana = $_POST['thana_id5'];
    $gp_house = $_POST['gp_house'];
    $gp_house_no = $_POST['gp_house_no'];
    $gp_road = $_POST['gp_road'];
    $gp_post_code = $_POST['gp_post_code'];
    //gurdian address_type=Present
       $sql_sel_present_adrs= mysql_query("SELECT * FROM address WHERE adrs_cepng_id=$custAcid AND address_whom='cust_prnt' AND address_type='Present' ");
    if(mysql_num_rows($sql_sel_present_adrs)<1)
    {
    $sql_g_insert_current_address = mysql_query("INSERT INTO $dbname.address 
                                    (address_type, house, house_no, road, address_whom, post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Present', '$g_house', '$g_house_no', '$g_road',  'cust_prnt', '$g_post_code', '$g_Thana_idThana', '$g_Post_idPost', '$g_Village_idVillage','$custAcid')");
    }
 else {
        echo $sql_g_insert_current_address = mysql_query("UPDATE address SET house ='$g_house', house_no='$g_house_no' , road='$g_road' ,  post_code='$g_post_code',Thana_idThana='$g_Thana_idThana',  post_idpost='$g_Post_idPost', village_idvillage='$g_Village_idVillage'
                                                                                    WHERE address_type='Present' AND address_whom='cust_prnt' AND adrs_cepng_id='$custAcid'");
    }
//gurdian address_type=Permanent
    $sql_sel_permanent_adrs= mysql_query("SELECT * FROM address WHERE adrs_cepng_id=$custAcid AND address_whom='cust_prnt' AND address_type='Permanent' ");
    if(mysql_num_rows($sql_sel_permanent_adrs)<1)
    {
    $sql_gp_insert_present_address = mysql_query("INSERT INTO $dbname.address 
                                    (address_type, house, house_no,road, address_whom,post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Permanent', '$gp_house', '$gp_house_no','$gp_road', 'cust_prnt','$gp_post_code', '$gp_Thana_idThana','$gp_Post_idPost', '$gp_Village_idVillage','$custAcid')");
    }
    else {
        $sql_gp_insert_present_address = mysql_query("UPDATE address SET  house ='$gp_house', house_no='$gp_house_no' , road='$gp_road' ,  post_code='$gp_post_code',Thana_idThana='$gp_Thana_idThana',  post_idpost='$gp_Post_idPost', village_idvillage='$gp_Village_idVillage'
                                                                                    WHERE address_type='Permanent'  AND address_whom='cust_prnt' AND adrs_cepng_id='$custAcid'");
    }
    if ($sql_update_customer || ($child_male && $del_m_children) || ($child_female && $del_f_children) || $sql_g_insert_current_address || $sql_gp_insert_present_address) {
        mysql_query("COMMIT");
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        mysql_query("ROLLBACK");
        $msg = "ভুল হয়েছে";
    }
} 
elseif (isset($_POST['submit2'])) {
    $nominee_name = $_POST['nominee_name'];
    $nominee_age = $_POST['nominee_age'];
    $nominee_relation = $_POST['nominee_relation'];
    $nominee_mobile = $_POST['nominee_mobile'];
    $nominee_email = $_POST['nominee_email'];
    $nominee_national_ID = $_POST['nominee_national_ID'];
    $nominee_passport_ID = $_POST['nominee_passport_ID'];
    $nominee_id = $_POST['nomineeID'];
    //Insert Into Nominee table **************************************************
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["nominee_picture"]["name"]));
    $image_name = $_FILES["nominee_picture"]["name"];
    if($image_name=="")
        {
            $image_name= "nom-cust-".$custAcid."-".$_POST['nomimagename'];
             $image_path = "pic/" . $image_name;
        }
        else
        {
            $image_name = "nom-cust-".$custAcid."-image.". $extension;
            $image_path = "pic/" . $image_name;
            if (($_FILES["nominee_picture"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                    {
                        move_uploaded_file($_FILES["nominee_picture"]["tmp_name"], "pic/" . $image_name);
                    } 
            else 
                    {
                    echo "Invalid file format.";
                    }
        }
$sql_sel_nominee = mysql_query("SELECT * FROM nominee WHERE idNominee = $nominee_id");
mysql_query("START TRANSACTION");
    if(mysql_num_rows($sql_sel_nominee) <1)
    {
        $sql_nominee = mysql_query("INSERT INTO $dbname.nominee(nominee_name, nominee_relation, nominee_mobile,
                                       nominee_email, nominee_national_ID, nominee_age, nominee_passport_ID, nominee_picture,cep_type, cep_nominee_id) 
                                       VALUES('$nominee_name','$nominee_relation','$nominee_mobile','$nominee_email','$nominee_national_ID',
                                       '$nominee_age','$nominee_passport_ID','$image_path','cust','$custAcid')");
        $nominee_id = mysql_insert_id(); 
    }
     else   {$sql_nominee = mysql_query("UPDATE nominee SET nominee_name='$nominee_name', nominee_picture='$image_path', nominee_relation='$nominee_relation', 
                                                        nominee_mobile='$nominee_mobile', nominee_email='$nominee_email', nominee_national_ID='$nominee_national_ID', nominee_age='$nominee_age', 
                                                        nominee_passport_ID='$nominee_passport_ID' WHERE idNominee = $nominee_id"); }
    
     //Current Address Infromation
    $n_Village_idVillage = $_POST['vilg_id2'];
    $n_Post_idPost = $_POST['post_id2'];
    $n_Thana_idThana = $_POST['thana_id2'];
    $n_house = $_POST['n_house'];
    $n_house_no = $_POST['n_house_no'];
    $n_road = $_POST['n_road'];
    $n_post_code = $_POST['n_post_code'];
    //Permanent Address information
    $np_Village_idVillage = $_POST['vilg_id3'];
    $np_Post_idPost = $_POST['post_id3'];
    $np_Thana_idThana = $_POST['thana_id3'];
    $np_house = $_POST['np_house'];
    $np_house_no = $_POST['np_house_no'];
    $np_road = $_POST['np_road'];
    $np_post_code = $_POST['np_post_code'];
    //nominee address_type=Present
     $sql_n_sel_present_adrs= mysql_query("SELECT * FROM address WHERE adrs_cepng_id=$nominee_id AND address_whom='nmn' AND address_type='Present' ");
    if(mysql_num_rows($sql_n_sel_present_adrs) < 1)
    {
        $sql_n_insert_current_address = mysql_query("INSERT INTO address 
                                    (address_type, house, house_no,road, address_whom, post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Present', '$n_house', '$n_house_no', '$n_road', 'nmn', '$n_post_code', '$n_Thana_idThana', '$n_Post_idPost', '$n_Village_idVillage','$nominee_id')");
    }
    else {
        $sql_n_insert_current_address = mysql_query("UPDATE address 
                                                                    SET house='$n_house', house_no='$n_house_no', road='$n_road', post_code='$n_post_code',Thana_idThana='$n_Thana_idThana', post_idpost='$n_Post_idPost', village_idvillage='$n_Village_idVillage'  
                                                                    WHERE adrs_cepng_id=$nominee_id AND address_whom='nmn' AND address_type='Present' ");}
    //nominee address_type=Permanent
    $sql_n_sel_permanent_adrs= mysql_query("SELECT * FROM address WHERE adrs_cepng_id=$nominee_id AND address_whom='nmn' AND address_type='Permanent' ");
    if(mysql_num_rows($sql_n_sel_permanent_adrs)<1)
    {
         $sql_np_insert_permanent_address = mysql_query("INSERT INTO address 
                                    (address_type, house, house_no, road, address_whom,post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Permanent', '$np_house', '$np_house_no','$np_road', 'nmn',  '$np_post_code','$np_Thana_idThana','$np_Post_idPost', '$np_Village_idVillage','$nominee_id')");
    }
    else {
        $sql_np_insert_permanent_address = mysql_query("UPDATE address 
                                                                    SET house='$np_house', house_no='$np_house_no', road='$np_road', post_code='$np_post_code',Thana_idThana='$np_Thana_idThana', post_idpost='$np_Post_idPost', village_idvillage='$np_Village_idVillage'  
                                                                    WHERE adrs_cepng_id=$nominee_id AND address_whom='nmn' AND address_type='Permanent' ");
    }    

    if ($sql_nominee || $sql_n_insert_current_address || $sql_np_insert_permanent_address) {
        mysql_query("COMMIT");
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        mysql_query("ROLLBACK");
        $msg = "ভুল হয়েছে";
    }
} 
elseif (isset($_POST['submit3'])) {
    //customer education
    $c_ex_name = $_POST['c_ex_name'];
    $c_pass_year = $_POST['c_pass_year'];
    $c_institute = $_POST['c_institute'];
    $c_board = $_POST['c_board'];
    $c_gpa = $_POST['c_gpa'];
    $a = count($c_ex_name);
    mysql_query("START TRANSACTION");
   $del_c_edu = mysql_query("DELETE FROM education WHERE education_type='cust' AND cepn_id=$custAcid");
    for ($i = 0; $i < $a; $i++) {
        $sql_insert_cus_edu = "INSERT INTO education ( `exam_name` ,`passing_year` ,`institute_name`,`board`,`gpa`,`education_type`,`cepn_id`) 
                                            VALUES ('$c_ex_name[$i]', '$c_pass_year[$i]','$c_institute[$i]','$c_board[$i]','$c_gpa[$i]','cust','$custAcid');";
        $cus_edu = mysql_query($sql_insert_cus_edu);
    }
    //nominee education
    $sel_nominee = mysql_query("SELECT * FROM nominee WHERE cep_nominee_id= $custAcid AND cep_type='cust'");
    $nomrow = mysql_fetch_assoc($sel_nominee);
    $db_nomID = $nomrow['idNominee'];
    $n_ex_name = $_POST['n_ex_name'];
    $n_pass_year = $_POST['n_pass_year'];
    $n_institute = $_POST['n_institute'];
    $n_board = $_POST['n_board'];
    $n_gpa = $_POST['n_gpa'];
    $b = count($n_ex_name);
    $del_n_edu = mysql_query("DELETE FROM education WHERE education_type='nmn' AND cepn_id=$db_nomID");
    for ($i = 0; $i < $b; $i++) {
        $sql_insert_nom_edu = "INSERT INTO education ( `exam_name` ,`passing_year` ,`institute_name`,`board`,`gpa`,`education_type`,`cepn_id`) 
                                                VALUES ('$n_ex_name[$i]', '$n_pass_year[$i]','$n_institute[$i]','$n_board[$i]','$n_gpa[$i]','nmn','$db_nomID');";
        $nom_edu = mysql_query($sql_insert_nom_edu);
    }
    if (($del_c_edu && $cus_edu) || ($del_n_edu && $nom_edu)) {
        mysql_query("COMMIT");
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
         mysql_query("ROLLBACK");
        $msg = "ভুল হয়েছে";
    }
} 
elseif (isset($_POST['submit4'])) {
    //Current Address Infromation
    $c_Village_idVillage = $_POST['vilg_id'];
    $c_Post_idPost = $_POST['post_id'];
    $c_Thana_idThana = $_POST['thana_id'];
    $c_house = $_POST['c_house'];
    $c_house_no = $_POST['c_house_no'];
    $c_road = $_POST['c_road'];
    $c_post_code = $_POST['c_post_code'];
    //Permanent Address information
    $cp_Village_idVillage = $_POST['vilg_id1'];
    $cp_Post_idPost = $_POST['post_id1'];
    $cp_Thana_idThana = $_POST['thana_id1'];
    $cp_house = $_POST['cp_house'];
    $cp_house_no = $_POST['cp_house_no'];
    $cp_road = $_POST['cp_road'];
    $cp_post_code = $_POST['cp_post_code'];
   
    //customer address_type=Present
    $sql_sel_present_adrs= mysql_query("SELECT * FROM address WHERE adrs_cepng_id=$custAcid AND address_whom='cust' AND address_type='Present' ");
    mysql_query("START TRANSACTION");
    if(mysql_num_rows($sql_sel_present_adrs)<1)
    {
    $sql_c_insert_current_address = mysql_query("INSERT INTO $dbname.address 
                                    (address_type, house, house_no, road, address_whom, post_code,Thana_idThana, post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Present', '$c_house', '$c_house_no', '$c_road', 'cust', '$c_post_code','$c_Thana_idThana','$c_Post_idPost', '$c_Village_idVillage', '$custAcid')");
    }
    else {$sql_c_insert_current_address = mysql_query("UPDATE address 
                                                                    SET house='$c_house', house_no='$c_house_no', road='$c_road', post_code='$c_post_code',Thana_idThana='$c_Thana_idThana', post_idpost='$c_Post_idPost', village_idvillage='$c_Village_idVillage'  WHERE adrs_cepng_id=$custAcid AND address_whom='cust' AND address_type='Present' ");}
//customer address_type=Permanent
   $sql_sel_permanent_adrs= mysql_query("SELECT * FROM address WHERE adrs_cepng_id=$custAcid AND address_whom='cust' AND address_type='Permanent' ");
    if(mysql_num_rows($sql_sel_permanent_adrs)<1)
    {
    $sql_cp_insert_permanent_address = mysql_query("INSERT INTO $dbname.address 
                                    (address_type, house, house_no, road, address_whom, post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Permanent', '$cp_house', '$cp_house_no', '$cp_road', 'cust', '$cp_post_code','$cp_Thana_idThana', '$cp_Post_idPost', '$cp_Village_idVillage', '$custAcid')");
    }
    else {$sql_cp_insert_permanent_address = mysql_query("UPDATE address 
                                                                         SET house='$cp_house', house_no='$cp_house_no', road='$cp_road', post_code='$cp_post_code',Thana_idThana='$cp_Thana_idThana', post_idpost='$cp_Post_idPost', village_idvillage='$cp_Village_idVillage'  WHERE adrs_cepng_id=$custAcid AND address_whom='cust' AND address_type ='Permanent' "); }
    if ($sql_c_insert_current_address || $sql_cp_insert_permanent_address ) {
        mysql_query("COMMIT");
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        mysql_query("ROLLBACK");
        $msg = "ভুল হয়েছে";
    }
}
elseif (isset($_POST['submit5'])) {
  $p_name = $_POST['name'];
  $p_email = $_POST['email'];
  $p_mobile = $_POST['mobile'];
  if(strlen($p_mobile) == 11)
  {
      $p_mobile = "88".$p_mobile;
  }
  $p_cfsid = $_POST['cfsid'];
  $sql_update_cfs = mysql_query("UPDATE cfs_user SET account_name='$p_name', email='$p_email', mobile='$p_mobile' WHERE idUser=$p_cfsid ");
    if ($sql_update_cfs) {
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        $msg = "ভুল হয়েছে";
    }
}
?>
<!--######################## select query for show ################################## -->
<?php
// *********************** for bacis ************************************************************************************************
     $sql_cust_sel = mysql_query("SELECT * FROM customer_account, cfs_user WHERE idUser=cfs_user_idUser AND  idCustomer_account =  $custAcid ") ;
     $custrow = mysql_fetch_assoc($sql_cust_sel);
     $db_cfsuserid = $custrow['cfs_user_idUser'];
     $db_custName = $custrow['account_name'];
     $db_custAcc = $custrow['account_number'];
     $db_custMail = $custrow['email'];
     $db_custRipdMail = $employeerow['ripd_email'];
     $db_custMob = $custrow['mobile'];
     $db_custPIN = $custrow['opening_pin_no'];
     $db_custFather = $custrow['cust_father_name'];
     $db_custMother = $custrow['cust_mother_name'];
     $db_custSpouse = $custrow['cust_spouse_name'];
     $db_custOccu = $custrow['cust_occupation'];
     $db_custRel = $custrow['cust_religion'];
     $db_custNation = $custrow['cust_nationality'];
     $db_custNID = $custrow['cust_nationalID_no'];
     $db_custPID = $custrow['cust_passportID_no'];
     $db_custDOB = $custrow['cust_date_of_birth'];
     $db_custDOBID = $custrow['birth_certificate_no'];
     $db_custSig = $custrow['scanDoc_signature'];
     $signname = end(explode("-", $db_custSig));
     $db_custPic = $custrow['scanDoc_picture'];
     $picname = end(explode("-", $db_custPic));
     $db_custFP = $custrow['scanDoc_finger_print'];
     $fingername = end(explode("-", $db_custFP));
      $db_custDOBC = $custrow['scanDoc_birth_certificate'];
     $DOBCname = end(explode("-", $db_custDOBC));
      $db_custNIDC = $custrow['scanDoc_national_id'];
     $NIDCname = end(explode("-", $db_custNIDC));
      $db_custCC = $custrow['scanDoc_chairman_certificate'];
     $CCname = end(explode("-", $db_custCC));
     $custFamilyNo = $custrow['cust_family_member'];
     $custSonNo = $custrow['cust_son_no'];
     $custDauNo = $custrow['cust_daughter_no'];
     $custSonStdNo = $custrow['cust_son_student_no'];
     $custDauStdNo = $custrow['cust_daughter_student_no'];
     
     $m_count =0;
     $sql_Mchil_sel = mysql_query("SELECT * FROM children WHERE type='M' AND Customer_account_idCustomer_account=$custAcid");
     while ($m_row = mysql_fetch_assoc($sql_Mchil_sel))
     {
         $db_m_age [$m_count] = $m_row['children_age'];
         $db_m_class [$m_count] = $m_row['children_class'];
         $m_count++;
     }
     $f_count =0;
     $sql_Fchil_sel = mysql_query("SELECT * FROM children WHERE type='F' AND Customer_account_idCustomer_account=$custAcid");
     while ($f_row = mysql_fetch_assoc($sql_Fchil_sel))
     {
         $db_f_age [$f_count] = $f_row['children_age'];
         $db_f_class [$f_count] = $f_row['children_class'];
         $f_count++;
     }
     
      $db_custGurdName = $custrow['cust_gurdian_name'];
      $db_custGurdRel = $custrow['cust_gurdian_relation'];
      $db_custGurdMob = $custrow['cust_gurdian_mobile'];
      $db_custGurdEmail = $custrow['cust_gurdian_email'];
      $db_custGurdNID = $custrow['cust_gurdian_nationalID_no'];
      $db_custGurdPID = $custrow['cust_gurdian_passportID_no'];
      $db_custGurdEdu = $custrow['cust_gurdian_education'];
      $db_custGurdPic = $custrow['cust_gurd_scanpic'];
      $gurdPicname = end(explode("-", $db_custGurdPic));
     
     $sql_cust_adrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='cust' AND adrs_cepng_id=$custAcid AND address_type='Present'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $presentAddrow = mysql_fetch_assoc($sql_cust_adrs_sel);
     $preHouse = $presentAddrow['house'];
     $preHouseNo = $presentAddrow['house_no'];
     $preRode = $presentAddrow['road'];
     $prePostCode = $presentAddrow['post_code'];
     $prePostID = $presentAddrow['idPost_office'];
     $preVilID = $presentAddrow['idvillage'];
     $preThanaID = $presentAddrow['idThana'];
     $preDisID = $presentAddrow['idDistrict'];
     $preDivID = $presentAddrow['idDivision'];
          
     $sql_cust_Padrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='cust' AND adrs_cepng_id=$custAcid AND address_type='Permanent'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $permenentAddrow = mysql_fetch_assoc($sql_cust_Padrs_sel);
     $perHouse = $permenentAddrow['house'];
     $perHouseNo = $permenentAddrow['house_no'];
     $perRode = $permenentAddrow['road'];
     $perPostCode = $permenentAddrow['post_code'];
     $perPostID = $permenentAddrow['idPost_office'];
     $perVilID = $permenentAddrow['idvillage'];
     $perThanaID = $permenentAddrow['idThana'];
     $perDisID = $permenentAddrow['idDistrict'];
     $perDivID = $permenentAddrow['idDivision'];

     $sql_custG_adrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='cust_prnt' AND adrs_cepng_id=$custAcid AND address_type='Present'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $gpresentAddrow = mysql_fetch_assoc($sql_custG_adrs_sel);
     $gpreHouse = $gpresentAddrow['house'];
     $gpreHouseNo = $gpresentAddrow['house_no'];
     $gpreRode = $gpresentAddrow['road'];
     $gprePostCode = $gpresentAddrow['post_code'];
     $gprePostID = $gpresentAddrow['idPost_office'];
     $gpreVilID = $gpresentAddrow['idvillage'];
     $gpreThanaID = $gpresentAddrow['idThana'];
     $gpreDisID = $gpresentAddrow['idDistrict'];
     $gpreDivID = $gpresentAddrow['idDivision'];
          
     $sql_custG_Padrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='cust_prnt' AND adrs_cepng_id=$custAcid AND address_type='Permanent'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $gpermenentAddrow = mysql_fetch_assoc($sql_custG_Padrs_sel);
     $gperHouse = $gpermenentAddrow['house'];
     $gperHouseNo = $gpermenentAddrow['house_no'];
     $gperRode = $gpermenentAddrow['road'];
     $gperPostCode = $gpermenentAddrow['post_code'];
     $gperPostID = $gpermenentAddrow['idPost_office'];
     $gperVilID = $gpermenentAddrow['idvillage'];
     $gperThanaID = $gpermenentAddrow['idThana'];
     $gperDisID = $gpermenentAddrow['idDistrict'];
     $gperDivID = $gpermenentAddrow['idDivision'];

//// *************************************** for nominee ****************************************************************************** 
     $sql_nomi_sel = mysql_query("SELECT * FROM nominee WHERE cep_type='cust' AND  cep_nominee_id= $custAcid ");
     $nomrow = mysql_fetch_assoc($sql_nomi_sel);
     $db_nomID= $nomrow['idNominee'];
     $db_nomName = $nomrow['nominee_name'];
     $db_nomAge = $nomrow['nominee_age'];
     $db_nomRel = $nomrow['nominee_relation'];
     $db_nomMobl = $nomrow['nominee_mobile'];
     $db_nomEmail = $nomrow['nominee_email'];
     $db_nomNID = $nomrow['nominee_national_ID'];
     $db_nomPID = $nomrow['nominee_passport_ID'];
     $db_nomPic = $nomrow['nominee_picture'];
     $nompicName = end(explode("-", $db_nomPic));
     
     $sql_adrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='nmn' AND adrs_cepng_id=$db_nomID AND address_type='Present'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $nompresentAddrow = mysql_fetch_assoc($sql_adrs_sel);
     $nompreHouse = $nompresentAddrow['house'];
     $nompreHouseNo = $nompresentAddrow['house_no'];
     $nompreRode = $nompresentAddrow['road'];
     $nomprePostCode = $nompresentAddrow['post_code'];
     $nomprePostID = $nompresentAddrow['idPost_office'];
     $nompreVilID = $nompresentAddrow['idvillage'];
     $nompreThanaID = $nompresentAddrow['idThana'];
     $nompreDisID = $nompresentAddrow['idDistrict'];
     $nompreDivID = $nompresentAddrow['idDivision'];
          
     $sql_Padrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='nmn' AND adrs_cepng_id=$db_nomID AND address_type='Permanent'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $nompermenentAddrow = mysql_fetch_assoc($sql_Padrs_sel);
     $nomperHouse = $nompermenentAddrow['house'];
     $nomperHouseNo = $nompermenentAddrow['house_no'];
     $nomperRode = $nompermenentAddrow['road'];
     $nomperPostCode = $nompermenentAddrow['post_code'];
     $nomperPostID = $nompermenentAddrow['idPost_office'];
     $nomperVilID = $nompermenentAddrow['idvillage'];
     $nomperThanaID = $nompermenentAddrow['idThana'];
     $nomperDisID = $nompermenentAddrow['idDistrict'];
     $nomperDivID = $nompermenentAddrow['idDivision'];
//     
//     // *************************************** for education ****************************************************************************** 
     $p_count =0;
     $sql_Pedu_sel = mysql_query("SELECT * FROM education WHERE education_type='cust' AND cepn_id=$custAcid");
     while ($pedu_row = mysql_fetch_assoc($sql_Pedu_sel))
     {
         $db_p_xmname [$p_count] = $pedu_row['exam_name'];
         $db_p_xmyear [$p_count] = $pedu_row['passing_year'];
         $db_p_xminstitute [$p_count] = $pedu_row['institute_name'];
         $db_p_xmboard [$p_count] = $pedu_row['board'];
         $db_p_xmgpa [$p_count] = $pedu_row['gpa'];
         $p_count++;
     }
     
      $n_count =0;
     $sql_Nedu_sel = mysql_query("SELECT * FROM education,nominee WHERE cep_nominee_id=$custAcid AND cep_type='cust' 
                                                        AND education_type='nmn' AND cepn_id=idNominee");
     while ($nedu_row = mysql_fetch_assoc($sql_Nedu_sel))
     {
         $db_n_xmname [$n_count] = $nedu_row['exam_name'];
         $db_n_xmyear [$n_count] = $nedu_row['passing_year'];
         $db_n_xminstitute [$n_count] = $nedu_row['institute_name'];
         $db_n_xmboard [$n_count] = $nedu_row['board'];
         $db_n_xmgpa [$n_count] = $nedu_row['gpa'];
         $n_count++;
     }
?>
<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="update_main_account.php?id=customer"><b>ফিরে যান</b></a></div> 
        <div class="domtab">
            <ul class="domtabs">
                <li class="current"><a href="#01">মূল তথ্য</a></li><li class="current"><a href="#02">ব্যাক্তিগত  তথ্য</a></li> <li class="current"><a href="#03">নমিনির তথ্য</a></li><li class="current"><a href="#04">শিক্ষাগত যোগ্যতা</a></li><li class="current"><a href="#05"> যোগাযোগের ঠিকানা</a></li>
            </ul>
        </div>  
        
         <div>
            <h2><a name="01" id="01"></a></h2><br/>
            <form method="POST" onsubmit="" enctype="multipart/form-data" action="" id="emp_form1" name="emp_form1">	
                <table  class="formstyle">     
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>কাস্টমারের মূল তথ্য</h1></th></tr>
                    <tr><td colspan="4" ></td>
                        <?php
                        if ($msg != "") {
                            echo '<tr> <td colspan="2" style="text-align: center; color: green; font-size: 15px"><b>' . $msg . '</b></td></tr>';
                        }
                        ?>
                    </tr>
                   <tr>
                        <td>কাস্টমারের নাম</td>
                        <td>:   <input class='box' style="width:220px;" type='text' id='name' name='name' value="<?php echo $db_custName;?>"/>
                            <input type='hidden' name='cfsid' value="<?php echo $db_cfsuserid;?>"/></td>			
                    </tr>
                    <tr>
                        <td >একাউন্ট নাম্বার</td>
                        <td>:   <input class='box' style="width:220px;" type='text' id='acc_num' name='acc_num' readonly value="<?php echo $db_custAcc;?>"/></td>			
                    </tr>
                    <tr>
                        <td>অফিশিয়াল ই মেইল</td>
                        <td>:   <input class='box' style="width:220px;" type='text' id='ripdemail' name='ripdemail' readonly="" value="<?php echo $db_custRipdMail;?>" /></td>			
                    </tr>
                    <tr>
                        <td >ব্যাক্তিগত ই মেইল</td>
                       <td>:   <input class='box' style="width:220px;" type='text' id='email' name='email' onblur='check(this.value)' value="<?php echo $db_custMail;?>" /> <em>ইংরেজিতে লিখুন</em> <span id='error_msg' style='margin-left: 5px'></span></td>			
                    </tr>
                    <tr>
                        <td >মোবাইল</td>
                        <td>:   <input class='box' style="width:220px;" type='text' id='mobile' name='mobile' onkeypress=' return numbersonly(event);' value="<?php echo $db_custMob;?>" /></td>		
                    </tr>
                    <tr>
                        <td >পিন নাম্বার</td>
                        <td>:   <input class='box' style="width:220px;"  type='text' readonly="" id='pin_num' name='pin_num' value="<?php echo $db_custPIN;?>"/></td>		
                    </tr>
                    <tr>                    
                        <td colspan="4" style="padding-top: 10px; padding-left: 250px;padding-bottom: 5px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit5" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" />
                        </td>                           
                    </tr>
                </table>
                </fieldset>
            </form>
        </div>

        <div>
            <h2><a name="02" id="02"></a></h2><br/>
            <form method="POST" onsubmit="" enctype="multipart/form-data" action="" id="cust_form" name="cust_form">	
                <table class="formstyle" style=" width: 90%; padding-left: 15px; padding-top: 5px;padding-bottom: 8px;" >            
               <tr><td colspan="4" ></td></tr>
                    <tr>
                        <td width="212" >পেশা</td>
                        <td width="234">:   <input class="box" type="text" id="cust_occupation" name="cust_occupation" value="<?php echo $db_custOccu;?>"/></td>                   
                    </tr>
                    <tr>
                        <td>ধর্ম</td>
                        <td>:   <input  class="box" type="text" id="cust_religion" name="cust_religion" value="<?php echo $db_custRel;?>"/></td>	      
                    </tr>
                    <tr>
                        <td >জাতীয়তা</td>
                        <td>:   <input class="box" type="text" id="cust_nationality" name="cust_nationality" value="<?php echo $db_custNation;?>"/> </td>			
                    </tr>
                    <tr>
                        <td>জন্মতারিখ</td>
                        <td >: <input class="box" type="date" name="dob" value="<?php echo $db_custDOB;?>"/></td>			
                    </tr>
                    <tr>
                        <td >জন্ম সনদ নং</td>
                        <td>:   <input class="box" type="text" id="birth_certificate_no" name="birth_certificate_no" value="<?php echo $db_custDOBID;?>"/></td>
                        <td width="208"  font-weight="bold" >জন্ম সনদ </td>
                        <td width="222">: <img src="<?php echo $db_custDOBC;?>" width="80px" height="80px"/> <input class="box5" type="file" id="scanDoc_birth_certificate" name="scanDoc_birth_certificate" style="font-size:10px;"/><input type="hidden" name="DOBCname" value="<?php echo $DOBCname;?>"/> </td> 
                        
                    </tr>                
                    <tr>
                        <td >জাতীয় পরিচয়পত্র নং</td>
                        <td>:   <input class="box" type="text" id="cust_nationalID_no" name="cust_nationalID_no" value="<?php echo $db_custNID;?>"/></td>
                        <td style="width: 100px;" font-weight="bold" > জাতীয় পরিচয়পত্র</td>
                        <td >: <img src="<?php echo $db_custNIDC;?>" width="80px" height="80px"/><input type="hidden" name="NIDCname" value="<?php echo $NIDCname;?>"/> <input class="box5" type="file" id="scanDoc_national_id" name="scanDoc_national_id" style="font-size:10px;"/> </td>
                    </tr>
                    <tr>
                        <td >পাসপোর্ট আইডি নং</td>
                        <td>:    <input class="box" type="text" id="cust_passportID_no" name="cust_passportID_no" value="<?php echo $db_custPID;?>"/> </td>
                        <td  font-weight="bold" >চারিত্রিক সনদ</td>
                        <td >: <img src="<?php echo $db_custCC;?>" width="80px" height="80px"/><input type="hidden" name="CCname" value="<?php echo $CCname;?>"/> <input class="box5" type="file" id="scanDoc_chairman_certificate" name="scanDoc_chairman_certificate" style="font-size:10px;"/></td>
                    </tr>      
                    <tr>  
                        <td font-weight="bold" >ছবি </td>
                        <td>: <img src="<?php echo $db_custPic;?>" width="80px" height="80px"/><input type="hidden" name="imagename" value="<?php echo $picname;?>"/> &nbsp;<input class="box5" type="file" id="image" name="image" style="font-size:10px;" /></td>             
                    </tr>
                    <tr>  
                        <td font-weight="bold" >স্বাক্ষর</td>
                        <td >: <img src="<?php echo $db_custSig;?>" width="80px" height="80px"/><input type="hidden" name="signname" value="<?php echo $signname;?>"/> &nbsp;<input class="box5" type="file" id="scanDoc_signature" name="scanDoc_signature" style="font-size:10px;" /> </td>                  
                    </tr>
                    <tr>	        
                        <td font-weight="bold" > টিপসই</td>
                        <td >: <img src="<?php echo $db_custFP;?>" width="80px" height="80px"/><input type="hidden" name="fingername" value="<?php echo $fingername;?>"/> &nbsp;<input class="box5" type="file" id="scanDoc_finger_print" name="scanDoc_finger_print" style="font-size:10px;" /> </td>       
                    </tr>
                    <tr>
                        <td colspan="4" ><hr /></td>
                    </tr>
                    <tr>	
                        <td  colspan="4"   style =" font-size: 14px"><b>পারিবারিক তথ্য</b></td>                                                
                    </tr>
                    <tr>
                        <td >বাবার নাম </td>
                        <td>:   <input class="box" type="text" id="cust_father_name" name="cust_father_name" value="<?php echo $db_custFather;?>"/></td>			
                    </tr>
                    <tr>
                        <td >মায়ের নাম </td>
                        <td>:    <input class="box" type="text" id="cust_mother_name" name="cust_mother_name" value="<?php echo $db_custMother;?>"/></td>			
                    </tr>
                    <tr>
                        <td >দম্পতির নাম  </td>
                        <td>:   <input class="box" type="text" id="cust_spouse_name" name="cust_spouse_name" value="<?php echo $db_custSpouse;?>"/> </td>			
                    </tr>
                    <tr>
                        <td>পরিবারের সদস্য সংখ্যা  </td>
                        <td>:   <input class="box" type="text" id="cust_family_member" name="cust_family_member" value="<?php echo $custFamilyNo;?>"/>জন</td>			
                    </tr>
                    <tr>
                        <td colspan="4" ><hr /></td>
                    </tr>
                    <tr>	
                        <td  colspan="4"   style =" font-size: 14px"><b>ছেলের সন্তানের তথ্য </b></td>                                                   
                    </tr>
                    <tr>
                        <td >ছেলের সন্তানের সংখ্যা  </td>
                        <td  >:   <input class="textfield" type="text" id="cust_son_no" name="cust_son_no" value="<?php echo $custSonNo;?>"/> জন</td>                          
                    </tr>                                                                                                 
                    <tr>
                        <td>ছেলে  ষ্টুডেন্ট </td>
                        <td>:    <input class="textfield" type="text" id="cust_son_student_no" name="cust_son_student_no" value="<?php echo $custSonStdNo;?>"/> জন</td>
                    </tr>              
                    <tr>
                        <td style="padding-top: 14px;vertical-align: top; width: 25%;" >বয়স ও শ্রেণী</td>
                        <td colspan="4">
                            <table id="container_others30">                     
                                <tr>
                                    <td>সন্তানের বয়স  :</td>
                                    <td>অধ্যয়ণরত শ্রেণী : </td>
                                </tr>
                                        <?php
                                            echo "<tr><td><select class='box2' name='m_children_age[]' style ='font-size: 11px'><option>একটি নির্বাচন করুন</option>";                                                    
                                                        for ($j = 4; $j <= 30; $j++) {
                                                            $getage = english2bangla($j);
                                                                if($db_m_age [0] == $getage )
                                                                {
                                                                    $age = english2bangla($j);
                                                                    echo "<option value='$age' selected>" . $age . "</option>";
                                                                }
                                                                else 
                                                                    {
                                                                      $age = english2bangla($j);
                                                                        echo "<option value='$age'>" . $age . "</option>";   
                                                                    }
                                                        }
                                                       echo " </select></td>";
                                                       echo "<td style= 'padding-left: 62px;' ><select class='box2' name='m_children_class[]' style ='font-size: 11px'><option>একটি নির্বাচন করুন</option>";                                                    
                                                        for ($j = 0; $j <= 18; $j++) {
                                                            $getclass = number($j);
                                                             if($db_m_class [0] == $getclass )
                                                                {
                                                                    $class = number($j);
                                                                    echo "<option value='$class' selected>" . $class . "</option>";
                                                                }
                                                                else 
                                                                    {
                                                                        $class = number($j);
                                                                        echo "<option value='$class'>" . $class . "</option>";
                                                                    }
                                                        }
                                                       echo " </select></td><td><input type='button' class='add' /></td></tr>";
                                                       
                                            for($i=1;$i<$m_count;$i++)
                                                    {
                                                       echo "<tr><td><select class='box2' name='m_children_age[]' style ='font-size: 11px'><option>একটি নির্বাচন করুন</option>";                                                    
                                                         for ($j = 4; $j <= 30; $j++) {     
                                                       $getage = english2bangla($j);
                                                                if($db_m_age [$i] == $getage )
                                                                    {
                                                                        $age = english2bangla($j);
                                                                        echo "<option value='$age' selected>" . $age . "</option>";
                                                                    }
                                                                    else 
                                                                        {
                                                                          $age = english2bangla($j);
                                                                            echo "<option value='$age'>" . $age . "</option>";   
                                                                        }
                                                         }
                                                           echo " </select></td>";
                                                            echo "<td style= 'padding-left: 62px;' ><select class='box2' name='m_children_class[]' style ='font-size: 11px'><option>একটি নির্বাচন করুন</option>";                                                    
                                                              for ($j = 0; $j <= 18; $j++) {
                                                            $getclass = number($j);
                                                             if($db_m_class [$i] == $getclass )
                                                                   {
                                                                       $class = number($j);
                                                                       echo "<option value='$class' selected>" . $class . "</option>";
                                                                   }
                                                                   else 
                                                                       {
                                                                           $class = number($j);
                                                                           echo "<option value='$class'>" . $class . "</option>";
                                                                       }
                                                              }
                                                       echo " </select></td><td style= 'padding-left: 23px;'><input type='button' class='del' /></td><td>&nbsp;<input type='button' class='add' /></td></tr>";
                                                    }
                                        ?>
                            </table>
                        </td>
                    </tr>                  
                    </td>
                    </tr>          
                    <tr>
                        <td colspan="4" ><hr /></td>
                    </tr>
                    <tr>	                                          
                        <td colspan="4" style =" font-size: 14px"><b>মেয়ের সন্তানের তথ্য</b></td>
                    </tr>        
                    <tr>
                        <td >মেয়ের সন্তানের সংখ্যা  </td>
                        <td >:  <input class="textfield" type="text" id="cust_daughter_no" name="cust_daughter_no" value="<?php echo $custDauNo;?>"/> জন</td>
                    </tr>                                                                                                 
                    <tr>
                        <td >মেয়ে  ষ্টুডেন্ট </td>
                        <td>:  <input class="textfield" type="text" id="cust_daughter_student_no" name="cust_daughter_student_no" value="<?php echo $custDauStdNo;?>"/> জন </td>	
                    </tr>                                                                                                
                    <tr>
                        <td colspan="4" >                
                    <tr>
                        <td style="padding-top: 14px;vertical-align: top; width: 25%;">বয়স ও শ্রেণী</td>
                        <td colspan="4">
                            <table id="container_others31">                                                    
                                <tr>
                                    <td>সন্তানের বয়স  :</td>
                                    <td>অধ্যয়ণরত শ্রেণী : </td>
                                </tr>
                               <?php
                                            echo "<tr><td><select class='box2' name='f_children_age[]' style ='font-size: 11px'><option>একটি নির্বাচন করুন</option>";                                                    
                                                        for ($j = 4; $j <= 30; $j++) {
                                                                $getage = english2bangla($j);
                                                                if($db_f_age [0] == $getage )
                                                                {
                                                                    $age = english2bangla($j);
                                                                    echo "<option value='$age' selected>" . $age . "</option>";
                                                                }
                                                                else 
                                                                    {
                                                                      $age = english2bangla($j);
                                                                        echo "<option value='$age'>" . $age . "</option>";   
                                                                    }
                                                        }
                                                       echo " </select></td>";
                                                       echo "<td style= 'padding-left: 62px;'><select class='box2' name='f_children_class[]' style ='font-size: 11px'><option>একটি নির্বাচন করুন</option>";                                                    
                                                        for ($j = 0; $j <= 18; $j++) {
                                                           $getclass = number($j);
                                                             if($db_f_class [0] == $getclass )
                                                                {
                                                                    $class = number($j);
                                                                    echo "<option value='$class' selected>" . $class . "</option>";
                                                                }
                                                                else 
                                                                    {
                                                                        $class = number($j);
                                                                        echo "<option value='$class'>" . $class . "</option>";
                                                                    }
                                                        }
                                                       echo " </select></td><td>&nbsp;<input type='button' class='add1' /></td></tr>";
                                                       
                                            for($i=1;$i<$f_count;$i++)
                                                    {
                                                       echo "<tr><td><select class='box2' name='f_children_age[]' style ='font-size: 11px'><option>একটি নির্বাচন করুন</option>";                                                    
                                                            for ($j = 4; $j <= 30; $j++) {
                                                                   $getage = english2bangla($j);
                                                                if($db_f_age [$i] == $getage )
                                                                    {
                                                                        $age = english2bangla($j);
                                                                        echo "<option value='$age' selected>" . $age . "</option>";
                                                                    }
                                                                    else 
                                                                        {
                                                                          $age = english2bangla($j);
                                                                            echo "<option value='$age'>" . $age . "</option>";   
                                                                        }
                                                            }
                                                           echo " </select></td>";
                                                            echo "<td style= 'padding-left: 62px;'><select class='box2' name='f_children_class[]' style ='font-size: 11px'><option>একটি নির্বাচন করুন</option>";                                                    
                                                             for ($j = 0; $j <= 18; $j++) {
                                                                $getclass = number($j);
                                                             if($db_f_class [$i] == $getclass )
                                                                   {
                                                                       $class = number($j);
                                                                       echo "<option value='$class' selected>" . $class . "</option>";
                                                                   }
                                                                   else 
                                                                       {
                                                                           $class = number($j);
                                                                           echo "<option value='$class'>" . $class . "</option>";
                                                                       }
                                                             }
                                                       echo " </select></td><td style= 'padding-left: 23px;'><input type='button' class='del1' /></td><td>&nbsp;<input type='button' class='add1' /></td></tr>";
                                                    }
                                        ?>
                            </table>
                        </td>
                    </tr>                     
                    <tr>
                        <td colspan="4" ><hr /></td>
                    </tr>
                    <tr>	
                        <td  colspan="4" style =" font-size: 14px"><b>অভিভাবকের তথ্য </b></td>                                                   
                    </tr>
                    <tr>
                        <td  >অভিভাবকের নাম </td>
                        <td>:    <input  class="box" type="text" id="cust_gurdian_name" name="cust_gurdian_name" value="<?php echo $db_custGurdName;?>" /></td>                    
                    </tr>
                    <tr>
                        <td >সম্পর্ক </td>
                        <td>:    <input class="box" type="text" id="cust_gurdian_relation" name="cust_gurdian_relation" value="<?php echo $db_custGurdRel;?>"/></td>			
                    </tr>
                    <tr>
                        <td >মোবাইল নং</td>
                        <td>:   <input class="box" type="text" id="cust_gurdian_mobile" name="cust_gurdian_mobile" value="<?php echo $db_custGurdMob;?>"/></td>			
                    </tr>
                    <tr>
                        <td >ইমেইল</td>
                        <td>:   <input class="box" type="text" id="cust_gurdian_email" name="cust_gurdian_email" value="<?php echo $db_custGurdEmail;?>"/></td>			
                    </tr>
                    <tr>
                        <td >জাতীয় পরিচয়পত্র নং</td>
                        <td>:   <input class="box" type="text" id="cust_gurdian_nationalID_no" name="cust_gurdian_nationalID_no" value="<?php echo $db_custGurdNID;?>"/></td>			
                    </tr>
                    <tr>
                        <td >পাসপোর্ট আইডি নং</td>
                        <td>:   <input class="box" type="text" id="cust_gurdian_passportID_no" name="cust_gurdian_passportID_no" value="<?php echo $db_custGurdPID?>"/></td>			
                    </tr>                   
                    <tr>     
                        <td   font-weight="bold" > ছবি </td>
                        <td> : <img src="<?php echo $db_custGurdPic;?>" width="80px" height="80px"/><input type="hidden" name="gurdimagename" value="<?php echo $gurdPicname;?>"/> <input class="box5" type="file" id="cust_gurd_scanpic" name="cust_gurd_scanpic" style="font-size:10px;"/>
                        </td>             
                    </tr>
                    <tr>
                        <td >শিক্ষাগত যোগ্যতা</td>
                        <td> <textarea class="box" type="text" id="cust_gurdian_education" name="cust_gurdian_education" ><?php echo $db_custGurdEdu;?></textarea></td>			
                    </tr>
                    
                    <tr>
                        <td colspan="4" ><hr /></td>
                    </tr>
                    <tr>	
                        <td  colspan="4" style =" padding-left: 300px; font-size: 15px"><b>অভিভাবকের ঠিকানা</b></td>                            
                    </tr>
                    <tr>	
                        <td  colspan="2" style =" font-size: 14px"><b>বর্তমান ঠিকানা </b></td>                            
                        <td colspan="2" style =" font-size: 14px"><b> স্থায়ী ঠিকানা   </b></td>
                    </tr>
                    <tr>
                        <td>বাড়ির নাম / ফ্ল্যাট নং</td>
                        <td >: <input class="box" type="text" id="g_house" name="g_house" value="<?php echo $gpreHouse;?>"/></td>
                        <td>বাড়ির নাম / ফ্ল্যাট নং</td>
                        <td>: <input class="box" type="text" id="gp_house" name="gp_house" value="<?php echo $gperHouse;?>"/></td>
                    </tr>
                    <tr>
                        <td>বাড়ি নং</td>
                        <td >: <input class="box" type="text" id="g_house_no" name="g_house_no" value="<?php echo $gpreHouseNo;?>"/></td>
                        <td >বাড়ি নং</td>
                        <td>: <input class="box" type="text" id="gp_house_no" name="gp_house_no" value="<?php echo $gperHouseNo;?>"/></td>
                    </tr>
                    <tr>
                        <td >রোড নং</td>
                        <td>: <input class="box" type="text" id="g_road" name="g_road" value="<?php echo $gpreRode;?>"/> </td>
                        <td >রোড নং</td>
                        <td>: <input class="box" type="text" id="gp_road" name="gp_road" value="<?php echo $gperRode;?>"/></td>
                    </tr>
                    <tr>
                        <td >পোষ্ট কোড</td>
                        <td>: <input class="box" type="text" id="g_post_code" name="g_post_code" value="<?php echo $gprePostCode;?>"/></td>
                        <td >পোষ্ট কোড</td>
                        <td>: <input class="box" type="text" id="gp_post_code" name="gp_post_code" value="<?php echo $gperPostCode;?>"/></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php getArea5($gpreDivID,$gpreDisID,$gpreThanaID,$gprePostID,$gpreVilID); ?></td>
                        <td colspan="2"><?php getArea6($gperDivID,$gperDisID,$gperThanaID,$gperPostID,$gperVilID); ?></td>
                    </tr>
                    <tr>                    
                        <td colspan="4" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit1" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>

        <div>
            <h2><a name="03" id="03"></a></h2><br/>
            <form method="POST" onsubmit=""  enctype="multipart/form-data" action="" id="cust_form1" name="cust_form1">	
                <table class="formstyle" style=" width: 90%; padding-left: 15px; padding-top: 5px; padding-bottom: 8px;" >      
                    <tr>
                        <td width="19%" >নমিনির নাম</td>
                        <td width="27%">:   <input class="box" type="text" id="nominee_name" name="nominee_name" value="<?php echo $db_nomName;?>"/><input type="hidden" name="nomineeID" value="<?php echo $db_nomID?>"/></td>
                    </tr>   
                    <tr>
                        <td >বয়স</td>
                        <td>:   <input class="box" type="text" id="nominee_age" name="nominee_age" value="<?php echo $db_nomAge;?>"/></td>
                    </tr>   
                    <tr>
                        <td >সম্পর্ক </td>
                        <td>:   <input class="box" type="text" id="nominee_relation" name="nominee_relation" value="<?php echo $db_nomRel;?>"/> </td>			
                    </tr>
                    <tr>
                        <td >মোবাইল নং</td>
                        <td>:   <input class="box" type="text" id="nominee_mobile" name="nominee_mobile" value="<?php echo $db_nomMobl;?>"/></td>			
                    </tr>
                    <tr>
                        <td >ইমেইল</td>
                        <td>:   <input class="box" type="text" id="nominee_email" name="nominee_email" value="<?php echo $db_nomEmail;?>"/></td>			
                    </tr>
                    <tr>
                        <td >জাতীয় পরিচয়পত্র নং</td>
                        <td>:   <input class="box" type="text" id="nominee_national_ID" name="nominee_national_ID" value="<?php echo $db_nomNID;?>"/></td>			
                    </tr>
                    <tr>
                        <td >পাসপোর্ট আইডি নং</td>
                        <td>:   <input class="box" type="text" id="nominee_passport_ID" name="nominee_passport_ID" value="<?php echo $db_nomPID;?>"/></td>			
                    </tr>                     
                    <tr>
                        <td  font-weight="bold" >ছবি </td>
                        <td >: <img src="<?php echo $db_nomPic;?>" width="80px" height="80px"/><input type="hidden" name="nomimagename" value="<?php echo $nompicName;?>"/> <input class="box5" type="file" id="nominee_picture" name="nominee_picture" style="font-size:10px;"/></td>
                    </tr>
                    <tr><td colspan="4" ><hr /></td></tr> 
                    <tr>	
                        <td  colspan="4" style =" padding-left: 320px; font-size: 15px"><b>নমিনির ঠিকানা</b></td>                            
                    </tr>
                    <tr>	
                        <td  colspan="2" style =" font-size: 14px"><b>বর্তমান ঠিকানা </b></td>                            
                        <td colspan="2" style =" font-size: 14px"><b> স্থায়ী ঠিকানা   </b></td>
                    </tr>
                    <tr>
                        <td  >বাড়ির নাম / ফ্ল্যাট নং</td>
                        <td >: <input class="box" type="text" id="n_house" name="n_house" value="<?php echo $nompreHouse;?>"/></td>
                        <td width="26%"  >বাড়ির নাম / ফ্ল্যাট নং</td>
                        <td width="28%" >: <input class="box" type="text" id="np_house" name="np_house" value="<?php echo $nomperHouse;?>"/></td>
                    </tr>
                    <tr>
                        <td  >বাড়ি নং</td>
                        <td >: <input class="box" type="text" id="n_house_no" name="n_house_no" value="<?php echo $nompreHouseNo;?>"/></td>
                        <td >বাড়ি নং</td>
                        <td>: <input class="box" type="text" id="np_house_no" name="np_house_no" value="<?php echo $nomperHouseNo;?>"/></td>
                    </tr>
                    <tr>
                        <td >রোড নং</td>
                        <td>:   <input class="box" type="text" id="n_road" name="n_road" value="<?php echo $nompreRode;?>"/> </td>
                        <td >রোড নং</td>
                        <td>:   <input class="box" type="text" id="np_road" name="np_road" value="<?php echo $nomperRode;?>"/></td>
                    </tr>
                    <tr>
                        <td >পোষ্ট কোড</td>
                        <td>:   <input class="box" type="text" id="n_post_code" name="n_post_code" value="<?php echo $nomprePostCode;?>"/></td>
                        <td >পোষ্ট কোড</td>
                        <td>:   <input class="box" type="text" id="np_post_code" name="np_post_code" value="<?php echo $nomperPostCode;?>"/></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php getArea3($nompreDivID,$nompreDisID,$nompreThanaID,$nomprePostID,$nompreVilID); ?></td>
                        <td colspan="2"><?php getArea4($nomperDivID,$nomperDisID,$nomperThanaID,$nomperPostID,$nomperVilID); ?></td>
                    </tr>
                    <tr>                    
                        <td colspan="4" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit2" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>                      
                </table>
                </fieldset>
            </form>
        </div>    

        <div>
            <h2><a name="04" id="04"></a></h2><br/>
            <form method="POST" onsubmit="">
                <table class="formstyle" style=" padding-top: 5px; padding-bottom: 8px;" >                                
                    <tr>
                        <td colspan="2" >
                            <table width="100%">
                                <tr>	
                                    <td  colspan="2"   style =" font-size: 14px"><b>ব্যক্তির শিক্ষাগত যোগ্যতা</b></td>                                                
                                </tr>
                                <tr>                      
                                    <td>
                                        <table id="container_others32">
                                            <tr>
                                                <td>পরীক্ষার নাম / ডিগ্রী</td>
                                                <td>পাশের সাল</td>
                                                <td>প্রতিষ্ঠানের নাম </td>
                                                <td>বোর্ড / বিশ্ববিদ্যালয়</td>
                                                <td>জি.পি.এ / বিভাগ</td>      
                                            </tr>
                                            <?php
                                                            echo "<tr><td><input class='textfield'  name='c_ex_name[]' type='text' value='$db_p_xmname[0]'/></td><td><input class='box5'  name='c_pass_year[]' type='text' value='$db_p_xmyear[0]'/></td><td><input class='textfield'  name='c_institute[]' type='text' value='$db_p_xminstitute[0]'/>
                                                                                </td><td><input class='textfield'  name='c_board[]' type='text' value='$db_p_xmboard[0]'/></td><td><input class='box5' name='c_gpa[]' type='text' value='$db_p_xmgpa[0]'/></td><td><input type='button' class='add2' /></td></tr>";
                                                                for($i=1;$i<$p_count;$i++)
                                                                {
                                                                    echo "<tr><td><input class='textfield'  name='c_ex_name[]' type='text' value='$db_p_xmname[$i]'/></td><td><input class='box5'  name='c_pass_year[]' type='text' value='$db_p_xmyear[$i]'/></td><td><input class='textfield'  name='c_institute[]' type='text' value='$db_p_xminstitute[$i]'/>
                                                                                </td><td><input class='textfield'  name='c_board[]' type='text' value='$db_p_xmboard[$i]'/></td><td><input class='box5' name='c_gpa[]' type='text' value='$db_p_xmgpa[$i]'/></td>";
                                                                   echo "<td><input type='button' class='del2' /></td><td><input type='button' class='add2' /></td></tr>";
                                                                }
                                            ?>
                                        </table>
                                    </td>
                                </tr>                                                               
                            </table>
                        </td>
                    </tr>    
                    <tr><td colspan="4" ></td></tr>   
                    <tr>
                        <td colspan="4" ><hr /></td>
                    </tr> 
                    <tr>
                        <td colspan="2" >
                            <table width="100%">
                                <tr>	
                                    <td  colspan="2"   style =" font-size: 14px"><b>নমিনির শিক্ষাগত যোগ্যতা</b></td>                                                
                                </tr>
                                <tr>                         
                                    <td>
                                        <table id="container_others33">
                                            <tr>
                                                <td>পরীক্ষার নাম / ডিগ্রী</td>
                                                <td>পাশের সাল</td>
                                                <td>প্রতিষ্ঠানের নাম </td>
                                                <td>বোর্ড / বিশ্ববিদ্যালয়</td>
                                                <td>জি.পি.এ / বিভাগ</td>      
                                            </tr>
                                            <?php
                                                            echo "<tr><td><input class='textfield'  name='n_ex_name[]' type='text' value='$db_n_xmname[0]'/></td><td><input class='box5'  name='n_pass_year[]' type='text' value='$db_n_xmyear[0]'/></td><td><input class='textfield'  name='n_institute[]' type='text' value='$db_n_xminstitute[0]'/>
                                                                                </td><td><input class='textfield'  name='n_board[]' type='text' value='$db_n_xmboard[0]'/></td><td><input class='box5' name='n_gpa[]' type='text' value='$db_n_xmgpa[0]'/></td><td><input type='button' class='add3' /></td></tr>";
                                                                for($i=1;$i<$n_count;$i++)
                                                                {
                                                                    echo "<tr><td><input class='textfield'  name='n_ex_name[]' type='text' value='$db_n_xmname[$i]'/></td><td><input class='box5'  name='n_pass_year[]' type='text' value='$db_n_xmyear[$i]'/></td><td><input class='textfield'  name='n_institute[]' type='text' value='$db_n_xminstitute[$i]'/>
                                                                                </td><td><input class='textfield'  name='n_board[]' type='text' value='$db_n_xmboard[$i]'/></td><td><input class='box5' name='n_gpa[]' type='text' value='$db_n_xmgpa[$i]'/></td>";
                                                                   echo "<td><input type='button' class='del3' /></td><td><input type='button' class='add3' /></td></tr>";
                                                                }
                                            ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>              
                    <tr>
                        <td ></td>     
                        <td style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit3" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div> 
        <div>
            <h2><a name="05" id="05"></a></h2><br/>
            <form method="POST" onsubmit="" action="">
                <table class="formstyle" style=" width: 90%; padding-left: 15px; padding-top: 5px; padding-bottom: 8px;" >   
                     <tr>	
                        <td  colspan="4" style =" padding-left: 320px; font-size: 15px"><b><u>কাস্টমারের ঠিকানা</u></b></td>                            
                    </tr>
                    <tr>	
                        <td  colspan="2" style =" font-size: 14px"><b>বর্তমান ঠিকানা </b></td>                            
                        <td colspan="2" style =" font-size: 14px"><b> স্থায়ী ঠিকানা   </b></td>
                    </tr>
                    <tr>
                        <td  >বাড়ির নাম / ফ্ল্যাট নং</td>
                        <td >:   <input class="box" type="text" id="c_house" name="c_house" value="<?php echo $preHouse;?>"/></td>
                        <td  >বাড়ির নাম / ফ্ল্যাট নং</td>
                        <td >:   <input class="box" type="text" id="cp_house" name="cp_house" value="<?php echo $perHouse;?>"/></td>
                    </tr>
                    <tr>
                        <td  >বাড়ি নং</td>
                        <td >:   <input class="box" type="text" id="c_house_no" name="c_house_no" value="<?php echo $preHouseNo;?>"/></td>
                        <td >বাড়ি নং</td>
                        <td>:   <input class="box" type="text" id="cp_house_no" name="cp_house_no" value="<?php echo $perHouseNo;?>"/></td>
                    </tr>
                    <tr>
                        <td >রোড নং</td>
                        <td>:   <input class="box" type="text" id="c_road" name="c_road" value="<?php echo $preRode;?>"/> </td>
                        <td >রোড নং</td>
                        <td>:   <input class="box" type="text" id="cp_road" name="cp_road" value="<?php echo $perRode;?>"/></td>
                    </tr>
                    <tr>
                        <td >পোষ্ট কোড</td>
                        <td>:   <input class="box" type="text" id="c_post_code" name="c_post_code" value="<?php echo $prePostCode;?>"/></td>
                        <td >পোষ্ট কোড</td>
                        <td>:   <input class="box" type="text" id="cp_post_code" name="cp_post_code" value="<?php echo $perPostCode;?>"/></td>
                    </tr> 
                    <tr>
                        <td colspan="2"><?php getArea($preDivID,$preDisID,$preThanaID,$prePostID,$preVilID); ?></td>
                        <td colspan="2"><?php getArea2($perDivID,$perDisID,$perThanaID,$perPostID,$perVilID); ?></td>
                    </tr>
                    <tr>                    
                        <td colspan="4" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit4" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>      
                </table>
            </form>
        </div>    
    </div>
</div>
<?php
include_once 'includes/footer.php';
?>