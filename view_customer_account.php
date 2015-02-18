<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/areaSearch2.php';
$userID = $_SESSION['userIDUser'];

function show($value) // check if value will be shown or not *************
{
    if($value!="")
    {
        $string =  "'".$value."'readonly";
    }
 else {
        $string =  "'".$value."'";
    }
    echo $string;
}
?>
<title>কাস্টমার অ্যাকাউন্ট</title>
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
    $p_custAcid = $_POST['custAcID'];
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

    // picture**********************************************************************************************
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["image"]["name"]));
    $image_name = $_FILES["image"]["name"];
    if($image_name=="")
        {
            $image_name= "cust-".$p_custAcid."-".$_POST['imagename'];
             $image_path = "pic/" . $image_name;
        }
        else
        {
            $image_name = "cust-".$p_custAcid."-image.".$extension;
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

    $extension = end(explode(".", $_FILES["cust_gurd_scanpic"]["name"]));
    $gurdimage_name = $_FILES["cust_gurd_scanpic"]["name"];
    if($gurdimage_name=="")
        {
            $gurdimage_name= "gurd-".$p_custAcid."-". $_POST['gurdimagename'];
             $gimage_path = "pic/" . $gurdimage_name;
        }
        else
        {
            $gurdimage_name = "gurd-".$p_custAcid."-guardpic.".$extension;
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

mysql_query("START TRANSACTION");
    $sql_update_customer = mysql_query("UPDATE customer_account SET cust_father_name='$cust_father_name', cust_mother_name='$cust_mother_name', cust_spouse_name='$cust_spouse_name', cust_family_member='$cust_family_member', cust_son_no='$cust_son_no', cust_daughter_no='$cust_daughter_no', 
                                                        cust_son_student_no='$cust_son_student_no', cust_daughter_student_no='$cust_daughter_student_no', cust_occupation='$cust_occupation', cust_religion='$cust_religion', cust_nationality='$cust_nationality', cust_nationalID_no='$cust_nationalID_no', 
                                                        cust_passportID_no='$cust_passportID_no', cust_date_of_birth='$dob', birth_certificate_no='$birth_certificate_no', cust_gurdian_name='$cust_gurdian_name', cust_gurdian_relation='$cust_gurdian_relation', cust_gurdian_mobile='$cust_gurdian_mobile', 
                                                        cust_gurdian_email='$cust_gurdian_email', cust_gurdian_nationalID_no='$cust_gurdian_nationalID_no', cust_gurdian_passportID_no='$cust_gurdian_passportID_no', cust_gurdian_education='$cust_gurdian_education',
                                                        scanDoc_picture='$image_path', cust_gurd_scanpic = '$gimage_path'
                                                        WHERE idCustomer_account=$p_custAcid ");
    //male child
    $m_children_age = $_POST['m_children_age'];
    if($m_children_age[0] != "0")
    {
        $m_children_class = $_POST['m_children_class'];
        //$del_m_children = mysql_query("DELETE FROM children WHERE type='M' AND Customer_account_idCustomer_account=$custAcid");
        $n1 = count($m_children_age);
        for ($i1 = 0; $i1 < $n1; $i1++) {
            $sql_insert_malechild = "INSERT INTO `children` ( `children_age` ,`children_class` ,`type`,`Customer_account_idCustomer_account`) VALUES ('$m_children_age[$i1]', '$m_children_class[$i1]','M',$p_custAcid)";
            $child_male = mysql_query($sql_insert_malechild);
        }
    }
    //female child
            $f_children_age = $_POST['f_children_age'];
  if($f_children_age[0] != "0")
    {
        $f_children_class = $_POST['f_children_class'];
        $m = count($f_children_age);
        //$del_f_children = mysql_query("DELETE FROM children WHERE type='F' AND Customer_account_idCustomer_account=$custAcid");
        for ($i = 0; $i < $m; $i++) {
            $sql_insert_femalechild = "INSERT INTO `children` ( `children_age` ,`children_class` ,`type`,`Customer_account_idCustomer_account`) VALUES ('$f_children_age[$i]', '$f_children_class[$i]','F','$p_custAcid');";
            $child_female = mysql_query($sql_insert_femalechild);
        }
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
    if($g_Village_idVillage !="")
    {
         $sql_g_insert_current_address = mysql_query("INSERT INTO address 
                                         (address_type, house, house_no, road, address_whom, post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                          VALUES ('Present', '$g_house', '$g_house_no', '$g_road',  'cust_prnt', '$g_post_code', '$g_Thana_idThana', '$g_Post_idPost', '$g_Village_idVillage','$p_custAcid')");
    }

//gurdian address_type=Permanent
 if($gp_Village_idVillage !="")
    {

         $sql_gp_insert_present_address = mysql_query("INSERT INTO address 
                                    (address_type, house, house_no,road, address_whom,post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Permanent', '$gp_house', '$gp_house_no','$gp_road', 'cust_prnt','$gp_post_code', '$gp_Thana_idThana','$gp_Post_idPost', '$gp_Village_idVillage','$p_custAcid')");
    }
    
    if ($sql_update_customer || ($child_male) || ($child_female) || $sql_g_insert_current_address || $sql_gp_insert_present_address) {
        mysql_query("COMMIT");
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        mysql_query("ROLLBACK");
        $msg = "ভুল হয়েছে";
    }
} 
elseif (isset($_POST['submit2'])) {
    $p_custAcid = $_POST['custAcID'];
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
            $image_name = "nom-cust-".$custAcid."-image.".$extension;
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
        $sql_nominee = mysql_query("INSERT INTO nominee(nominee_name, nominee_relation, nominee_mobile,
                                       nominee_email, nominee_national_ID, nominee_age, nominee_passport_ID, nominee_picture,cep_type, cep_nominee_id) 
                                       VALUES('$nominee_name','$nominee_relation','$nominee_mobile','$nominee_email','$nominee_national_ID',
                                       '$nominee_age','$nominee_passport_ID','$image_path','cust','$p_custAcid')");
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
 if($n_Village_idVillage !="")
    {
        $sql_n_insert_current_address = mysql_query("INSERT INTO address 
                                    (address_type, house, house_no,road, address_whom, post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Present', '$n_house', '$n_house_no', '$n_road', 'nmn', '$n_post_code', '$n_Thana_idThana', '$n_Post_idPost', '$n_Village_idVillage','$nominee_id')");
    }
   
    //nominee address_type=Permanent
if($np_Village_idVillage !="")
    {
         $sql_np_insert_permanent_address = mysql_query("INSERT INTO address 
                                    (address_type, house, house_no, road, address_whom,post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Permanent', '$np_house', '$np_house_no','$np_road', 'nmn',  '$np_post_code','$np_Thana_idThana','$np_Post_idPost', '$np_Village_idVillage','$nominee_id')");
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
    $p_custAcid = $_POST['custAcID'];
    //customer education
    $c_ex_name = $_POST['c_ex_name'];
    $c_pass_year = $_POST['c_pass_year'];
    $c_institute = $_POST['c_institute'];
    $c_board = $_POST['c_board'];
    $c_gpa = $_POST['c_gpa'];
    $a = count($c_ex_name);
    mysql_query("START TRANSACTION");
if($c_ex_name[0] != "")
{
    for ($i = 0; $i < $a; $i++) {
        $sql_insert_cus_edu = "INSERT INTO `education` ( `exam_name` ,`passing_year` ,`institute_name`,`board`,`gpa`,`education_type`,`cepn_id`) 
                                            VALUES ('$c_ex_name[$i]', '$c_pass_year[$i]','$c_institute[$i]','$c_board[$i]','$c_gpa[$i]','cust','$p_custAcid');";
        $cus_edu = mysql_query($sql_insert_cus_edu);
    }
}
    //nominee education
    $sel_nominee = mysql_query("SELECT * FROM nominee WHERE cep_nominee_id= $p_custAcid AND cep_type='cust'");
    $nomrow = mysql_fetch_assoc($sel_nominee);
    $db_nomID = $nomrow['idNominee'];
    $n_ex_name = $_POST['n_ex_name'];
    $n_pass_year = $_POST['n_pass_year'];
    $n_institute = $_POST['n_institute'];
    $n_board = $_POST['n_board'];
    $n_gpa = $_POST['n_gpa'];
    $b = count($n_ex_name);
    if($n_ex_name[0] != "")
    {
        for ($i = 0; $i < $b; $i++) {
            $sql_insert_nom_edu = "INSERT INTO `education` ( `exam_name` ,`passing_year` ,`institute_name`,`board`,`gpa`,`education_type`,`cepn_id`) 
                                                    VALUES ('$n_ex_name[$i]', '$n_pass_year[$i]','$n_institute[$i]','$n_board[$i]','$n_gpa[$i]','nmn','$db_nomID');";
            $nom_edu = mysql_query($sql_insert_nom_edu);
        }
    }
    if (($cus_edu) || ($nom_edu)) {
        mysql_query("COMMIT");
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
         mysql_query("ROLLBACK");
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
    $p_custAcid = $_POST['custAcID'];
    //customer address_type=Present
    mysql_query("START TRANSACTION");
     if($c_Village_idVillage !="")
    {
        $sql_c_insert_current_address = mysql_query("INSERT INTO address 
                                    (address_type, house, house_no, road, address_whom, post_code,Thana_idThana, post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Present', '$c_house', '$c_house_no', '$c_road', 'cust', '$c_post_code','$c_Thana_idThana','$c_Post_idPost', '$c_Village_idVillage', '$p_custAcid')");
    }
   if($cp_Village_idVillage !="")
    {
     $sql_cp_insert_permanent_address = mysql_query("INSERT INTO address 
                                    (address_type, house, house_no, road, address_whom, post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Permanent', '$cp_house', '$cp_house_no', '$cp_road', 'cust', '$cp_post_code','$cp_Thana_idThana', '$cp_Post_idPost', '$cp_Village_idVillage', '$p_custAcid')");
    }
    
    if ($sql_c_insert_current_address || $sql_cp_insert_permanent_address ) {
        mysql_query("COMMIT");
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        mysql_query("ROLLBACK");
        $msg = "ভুল হয়েছে";
    }
}
elseif (isset($_POST['submit5'])) {
  $p_email = $_POST['email'];
  $p_mobile = $_POST['mobile'];
if(strlen($p_mobile) == 11)
  {
      $p_mobile = "88".$p_mobile;
  }
  $p_cfsid = $_POST['cfsid'];
  $sql_update_cfs = mysql_query("UPDATE cfs_user SET email='$p_email', mobile='$p_mobile' WHERE idUser=$p_cfsid ");
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
     $sql_cust_sel = mysql_query("SELECT * FROM customer_account, cfs_user WHERE cfs_user_idUser=idUser AND idUser=$userID") ;
     $custrow = mysql_fetch_assoc($sql_cust_sel);
     $db_custAcID = $custrow['idCustomer_account'];
     $db_custName = $custrow['account_name'];
     $db_custAcc = $custrow['account_number'];
     $db_custMail = $custrow['email'];
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
     $sql_Mchil_sel = mysql_query("SELECT * FROM children WHERE type='M' AND Customer_account_idCustomer_account=$db_custAcID");
     while ($m_row = mysql_fetch_assoc($sql_Mchil_sel))
     {
         $db_m_age [$m_count] = $m_row['children_age'];
         $db_m_class [$m_count] = $m_row['children_class'];
         $m_count++;
     }
     $f_count =0;
     $sql_Fchil_sel = mysql_query("SELECT * FROM children WHERE type='F' AND Customer_account_idCustomer_account=$db_custAcID");
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
     
     $sql_cust_adrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='cust' AND adrs_cepng_id=$db_custAcID AND address_type='Present'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $presentAddrow = mysql_fetch_assoc($sql_cust_adrs_sel);
     $preHouse = $presentAddrow['house'];
     $preHouseNo = $presentAddrow['house_no'];
     $preRode = $presentAddrow['road'];
     $prePostCode = $presentAddrow['post_code'];
     $prePostID = $presentAddrow['idPost_office'];
     $prePostname = $presentAddrow['post_offc_name'];
     $preVilID = $presentAddrow['idvillage'];
     $preVilname = $presentAddrow['village_name'];
     $preThanaID = $presentAddrow['idThana'];
     $preThananame = $presentAddrow['thana_name'];
     $preDisID = $presentAddrow['idDistrict'];
     $preDisname = $presentAddrow['district_name'];
     $preDivID = $presentAddrow['idDivision'];
     $preDivname = $presentAddrow['division_name'];
          
     $sql_cust_Padrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='cust' AND adrs_cepng_id=$db_custAcID AND address_type='Permanent'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $permenentAddrow = mysql_fetch_assoc($sql_cust_Padrs_sel);
     $perHouse = $permenentAddrow['house'];
     $perHouseNo = $permenentAddrow['house_no'];
     $perRode = $permenentAddrow['road'];
     $perPostCode = $permenentAddrow['post_code'];
     $perPostID = $permenentAddrow['idPost_office'];
     $perPostname = $permenentAddrow['post_offc_name'];
     $perVilID = $permenentAddrow['idvillage'];
     $perVilname = $permenentAddrow['village_name'];
     $perThanaID = $permenentAddrow['idThana'];
     $perThananame = $permenentAddrow['thana_name'];
     $perDisID = $permenentAddrow['idDistrict'];
     $perDisname = $permenentAddrow['district_name'];
     $perDivID = $permenentAddrow['idDivision'];
      $perDivname = $permenentAddrow['division_name'];

     $sql_custG_adrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='cust_prnt' AND adrs_cepng_id=$db_custAcID AND address_type='Present'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $gpresentAddrow = mysql_fetch_assoc($sql_custG_adrs_sel);
     $gpreHouse = $gpresentAddrow['house'];
     $gpreHouseNo = $gpresentAddrow['house_no'];
     $gpreRode = $gpresentAddrow['road'];
     $gprePostCode = $gpresentAddrow['post_code'];
     $gprePostID = $gpresentAddrow['idPost_office'];
     $gprePostname = $gpresentAddrow['post_offc_name'];
     $gpreVilID = $gpresentAddrow['idvillage'];
     $gpreVilname = $gpresentAddrow['village_name'];
     $gpreThanaID = $gpresentAddrow['idThana'];
     $gpreThananame = $gpresentAddrow['thana_name'];
     $gpreDisID = $gpresentAddrow['idDistrict'];
     $gpreDisname = $gpresentAddrow['district_name'];
     $gpreDivID = $gpresentAddrow['idDivision'];
     $gpreDivname = $gpresentAddrow['division_name'];
          
     $sql_custG_Padrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='cust_prnt' AND adrs_cepng_id=$db_custAcID AND address_type='Permanent'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $gpermenentAddrow = mysql_fetch_assoc($sql_custG_Padrs_sel);
     $gperHouse = $gpermenentAddrow['house'];
     $gperHouseNo = $gpermenentAddrow['house_no'];
     $gperRode = $gpermenentAddrow['road'];
     $gperPostCode = $gpermenentAddrow['post_code'];
     $gperPostID = $gpermenentAddrow['idPost_office'];
     $gperPostname = $gpermenentAddrow['post_offc_name'];
     $gperVilID = $gpermenentAddrow['idvillage'];
     $gperVilname = $gpermenentAddrow['village_name'];
     $gperThanaID = $gpermenentAddrow['idThana'];
     $gperThananame = $gpermenentAddrow['thana_name'];
     $gperDisID = $gpermenentAddrow['idDistrict'];
     $gperDisname = $gpermenentAddrow['district_name'];
     $gperDivID = $gpermenentAddrow['idDivision'];
     $gperDivname = $gpermenentAddrow['division_name'];

//// *************************************** for nominee ****************************************************************************** 
     $sql_nomi_sel = mysql_query("SELECT * FROM nominee WHERE cep_type='cust' AND  cep_nominee_id= $db_custAcID ");
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
     $nomprePostname = $nompresentAddrow['post_offc_name'];
     $nompreVilID = $nompresentAddrow['idvillage'];
     $nompreVilname = $nompresentAddrow['village_name'];
     $nompreThanaID = $nompresentAddrow['idThana'];
     $nompreThananame = $nompresentAddrow['thana_name'];
     $nompreDisID = $nompresentAddrow['idDistrict'];
     $nompreDisname = $nompresentAddrow['district_name'];
     $nompreDivID = $nompresentAddrow['idDivision'];
     $nompreDivname = $nompresentAddrow['division_name'];
          
     $sql_Padrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='nmn' AND adrs_cepng_id=$db_nomID AND address_type='Permanent'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $nompermenentAddrow = mysql_fetch_assoc($sql_Padrs_sel);
     $nomperHouse = $nompermenentAddrow['house'];
     $nomperHouseNo = $nompermenentAddrow['house_no'];
     $nomperRode = $nompermenentAddrow['road'];
     $nomperPostCode = $nompermenentAddrow['post_code'];
     $nomperPostID = $nompermenentAddrow['idPost_office'];
     $nomperPostname = $nompermenentAddrow['post_offc_name'];
     $nomperVilID = $nompermenentAddrow['idvillage'];
     $nomperVilname = $nompermenentAddrow['village_name'];
     $nomperThanaID = $nompermenentAddrow['idThana'];
     $nomperThananame = $nompermenentAddrow['thana_name'];
     $nomperDisID = $nompermenentAddrow['idDistrict'];
     $nomperDisname = $nompermenentAddrow['district_name'];
     $nomperDivID = $nompermenentAddrow['idDivision'];
     $nomperDivname = $nompermenentAddrow['division_name'];
//     
//     // *************************************** for education ****************************************************************************** 
     $p_count =0;
     $sql_Pedu_sel = mysql_query("SELECT * FROM education WHERE education_type='cust' AND cepn_id=$db_custAcID");
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
     $sql_Nedu_sel = mysql_query("SELECT * FROM education,nominee WHERE cep_nominee_id=$db_custAcID AND cep_type='cust' 
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
        <div style="padding-left: 110px;"><a href="account_management.php"><b>ফিরে যান</b></a></div> 
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
                        <td>:   <input class='box' type='text' id='name' name='name' readonly="" value="<?php echo $db_custName;?>"/>
                            <input type='hidden' name='cfsid' value="<?php echo $userID;?>"/></td>			
                    </tr>
                    <tr>
                        <td >একাউন্ট নাম্বার</td>
                        <td>:   <input class='box' type='text' id='acc_num' name='acc_num' readonly value="<?php echo $db_custAcc;?>"/></td>			
                    </tr>
                    <tr>
                        <td >ই মেইল</td>
                       <td>:   <input class='box' type='text' id='email' name='email' onblur='check(this.value)' value="<?php echo $db_custMail;?>" /> <em>ইংরেজিতে লিখুন</em> <span id='error_msg' style='margin-left: 5px'></span></td>			
                    </tr>
                    <tr>
                        <td >মোবাইল</td>
                        <td>:   <input class='box' type='text' id='mobile' name='mobile' onkeypress=' return numbersonly(event)' value="<?php echo $db_custMob;?>" /> <em>ইংরেজিতে লিখুন</em></td>		
                    </tr>
                    <tr>
                        <td >পিন নাম্বার</td>
                        <td>:   <input class='box' type='text' readonly="" id='pin_num' name='pin_num' value="<?php echo $db_custPIN;?>"/></td>		
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
                        <td width="234">: <input class="box" type="text" id="cust_occupation" name="cust_occupation" value=<?php show($db_custOccu);?>/>
                        <input type='hidden' name='custAcID' value="<?php echo $db_custAcID;?>" /></td>                   
                    </tr>
                    <tr>
                        <td>ধর্ম</td>
                        <td>:   <input  class="box" type="text" id="cust_religion" name="cust_religion" value=<?php show($db_custRel);?>/></td>	      
                    </tr>
                    <tr>
                        <td >জাতীয়তা</td>
                        <td>:   <input class="box" type="text" id="cust_nationality" name="cust_nationality" value=<?php show($db_custNation);?>/> </td>			
                    </tr>
                    <tr>
                        <td>জন্মতারিখ</td>
                        <?php
                            if(($db_custDOB == "") || ($db_custDOB == "0000-00-00") ) {
                        ?>
                        <td >: <input class="box" type="date" name="dob"  /></td>
                            <?php } else {?>
                        <td >: <input class="box" type="text" name="dob" value=<?php show($db_custDOB);?> /></td>
                            <?php }?>
                    </tr>
                    <tr>
                        <td >জন্ম সনদ নং</td>
                        <td>:   <input class="box" type="text" id="birth_certificate_no" name="birth_certificate_no" value=<?php show($db_custDOBID);?>/></td>
                        <td width="208"  font-weight="bold" >জন্ম সনদ </td>
                        <td width="222">: <img src="<?php echo $db_custDOBC;?>" width="80px" height="80px"/></td> 
                        
                    </tr>                
                    <tr>
                        <td >জাতীয় পরিচয়পত্র নং</td>
                        <td>:   <input class="box" type="text" id="cust_nationalID_no" name="cust_nationalID_no" value=<?php show($db_custNID);?>/></td>
                        <td style="width: 100px;" font-weight="bold" > জাতীয় পরিচয়পত্র</td>
                        <td >: <img src="<?php echo $db_custNIDC;?>" width="80px" height="80px"/></td>
                    </tr>
                    <tr>
                        <td >পাসপোর্ট আইডি নং</td>
                        <td>:    <input class="box" type="text" id="cust_passportID_no" name="cust_passportID_no" value=<?php show($db_custPID);?>/> </td>
                        <td  font-weight="bold" >চারিত্রিক সনদ</td>
                        <td >: <img src="<?php echo $db_custCC;?>" width="80px" height="80px"/></td>
                    </tr>      
                    <tr>  
                        <td font-weight="bold" >ছবি </td>
                        <?php
                            if($picname == "") {
                        ?>
                        <td>: <img src="<?php echo $db_custPic;?>" width="80px" height="80px"/><input type="hidden" name="imagename" value="<?php echo $picname;?>"/> &nbsp;<input class="box5" type="file" id="image" name="image" style="font-size:10px;" /></td>
                            <?php }
                            else { ?>
                        <td>: <img src="<?php echo $db_custPic;?>" width="80px" height="80px"/><input type="hidden" name="imagename" value="<?php echo $picname;?>"/></td>
                            <?php }?>
                    </tr>
                    <tr>  
                        <td font-weight="bold" >স্বাক্ষর</td>
                        <td >: <img src="<?php echo $db_custSig;?>" width="80px" height="80px"/></td>                  
                    </tr>
                    <tr>	        
                        <td font-weight="bold" > টিপসই</td>
                        <td >: <img src="<?php echo $db_custFP;?>" width="80px" height="80px"/></td>       
                    </tr>
                    <tr>
                        <td colspan="4" ><hr /></td>
                    </tr>
                    <tr>	
                        <td  colspan="4"   style =" font-size: 14px"><b>পারিবারিক তথ্য</b></td>                                                
                    </tr>
                    <tr>
                        <td >বাবার নাম </td>
                        <td>:   <input class="box" type="text" id="cust_father_name" name="cust_father_name" value=<?php show($db_custFather);?>/></td>			
                    </tr>
                    <tr>
                        <td >মায়ের নাম </td>
                        <td>:    <input class="box" type="text" id="cust_mother_name" name="cust_mother_name" value=<?php show($db_custMother);?>/></td>			
                    </tr>
                    <tr>
                        <td >দম্পতির নাম  </td>
                        <td>:   <input class="box" type="text" id="cust_spouse_name" name="cust_spouse_name" value=<?php show($db_custSpouse);?> /></td>			
                    </tr>
                    <tr>
                        <td>পরিবারের সদস্য সংখ্যা  </td>
                        <td>: <input class="box" type="text" id="cust_family_member" name="cust_family_member" value=<?php show($custFamilyNo);?> />জন</td>			
                    </tr>
                    <tr>
                        <td colspan="4" ><hr /></td>
                    </tr>
                    <tr>	
                        <td  colspan="4"   style =" font-size: 14px"><b>ছেলের সন্তানের তথ্য </b></td>                                                   
                    </tr>
                    <tr>
                        <td >ছেলের সন্তানের সংখ্যা  </td>
                        <td>: <input class="textfield" type="text" id="cust_son_no" name="cust_son_no" value=<?php show($custSonNo);?>/> জন</td>                          
                    </tr>                                                                                                 
                    <tr>
                        <td>ছেলে  ষ্টুডেন্ট </td>
                        <td>: <input class="textfield" type="text" id="cust_son_student_no" name="cust_son_student_no" value=<?php show($custSonStdNo);?>/> জন</td>
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
                                            if($m_count == 0){
                                        ?>
                                            <tr>   
                                                <td> <select class="box2" id="m_children_age" name="m_children_age[]" style =" font-size: 11px">
                                                            <option value="0">একটি নির্বাচন করুন</option>
                                                            <?php
                                                            for ($i = 4; $i <= 30; $i++) {
                                                                $age = english2bangla($i);
                                                                echo "<option value='$age'>" . $age . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><select class="box2" id="m_children_class"name="m_children_class[]" style =" font-size: 11px">
                                                            <option value="0">একটি নির্বাচন করুন</option>
                                                            <?php
                                                            for ($i = 0; $i <= 18; $i++) {
                                                                $class = number($i);
                                                                echo "<option value='$class'>" . $class . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><input type="button" class="add" /></td>
                                                </tr>
                                            <?php }
                                            else {
                                                for($i=0;$i<$m_count;$i++)
                                                {
                                                    echo "<tr><td><input class='box2' type='text' readonly value=$db_m_age[$i] /></td>
                                                            <td><input class='box2' type='text' readonly value=$db_m_class[$i] /></td><td></td></tr>";
                                                }
                                            }?>
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
                        <td >:  <input class="textfield" type="text" id="cust_daughter_no" name="cust_daughter_no" value=<?php show($custDauNo);?>/> জন</td>
                    </tr>                                                                                                 
                    <tr>
                        <td >মেয়ে  ষ্টুডেন্ট </td>
                        <td>:  <input class="textfield" type="text" id="cust_daughter_student_no" name="cust_daughter_student_no" value=<?php show($custDauStdNo);?>/> জন </td>	
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
                                           if($f_count == 0){  
                                ?>
                                 <tr>
                                    <td ><select class="box2" name="f_children_age[]" style =" font-size: 11px">
                                            <option value="0">একটি নির্বাচন করুন</option>
                                            <?php
                                            for ($i = 4; $i <= 30; $i++) {
                                                $age = english2bangla($i);
                                                echo "<option value='$age'>" . $age . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td><select class="box2"  name="f_children_class[]" style =" font-size: 11px">
                                            <option value="0">একটি নির্বাচন করুন</option>
                                            <?php
                                            for ($i = 0; $i <= 18; $i++) {
                                                $class = number($i);
                                                echo "<option value='$class'>" . $class . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td><input type="button" class="add1" /></td>
                                    </tr>
                          <?php } 
                               else {
                                            for($i=0;$i<$f_count;$i++)
                                                {
                                                    echo "<tr><td><input class='box2' type='text' readonly value=$db_f_age[$i] /></td>
                                                            <td><input class='box2'  type='text' readonly value=$db_f_class[$i] /></td><td></td></tr>";
                                                }
                           }?>
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
                        <td>অভিভাবকের নাম </td>
                        <td>: <input  class="box" type="text" id="cust_gurdian_name" name="cust_gurdian_name" value= <?php show($db_custGurdName);?> /></td>                    
                    </tr>
                    <tr>
                        <td >সম্পর্ক </td>
                        <td>: <input class="box" type="text" id="cust_gurdian_relation" name="cust_gurdian_relation" value=<?php show($db_custGurdRel);?>/></td>			
                    </tr>
                    <tr>
                        <td >মোবাইল নং</td>
                        <td>: <input class="box" type="text" id="cust_gurdian_mobile" name="cust_gurdian_mobile" value=<?php show($db_custGurdMob);?>/></td>			
                    </tr>
                    <tr>
                        <td >ইমেইল</td>
                        <td>: <input class="box" type="text" id="cust_gurdian_email" name="cust_gurdian_email" value=<?php show($db_custGurdEmail);?>/></td>			
                    </tr>
                    <tr>
                        <td >জাতীয় পরিচয়পত্র নং</td>
                        <td>: <input class="box" type="text" id="cust_gurdian_nationalID_no" name="cust_gurdian_nationalID_no" value=<?php show($db_custGurdNID);?>/></td>			
                    </tr>
                    <tr>
                        <td >পাসপোর্ট আইডি নং</td>
                        <td>: <input class="box" type="text" id="cust_gurdian_passportID_no" name="cust_gurdian_passportID_no" value=<?php show($db_custGurdPID);?>/></td>			
                    </tr>                   
                    <tr>     
                        <td   font-weight="bold" > ছবি </td>
                        <?php
                            if($gurdPicname == "") {
                        ?>
                        <td> : <img src="<?php echo $db_custGurdPic;?>" width="80px" height="80px"/><input type="hidden" name="gurdimagename" value=<?php echo $gurdPicname;?> /> <input class="box5" type="file" id="cust_gurd_scanpic" name="cust_gurd_scanpic" style="font-size:10px;"/></td>
                        <?php }
                            else { ?>
                        <td> : <img src="<?php echo $db_custGurdPic;?>" width="80px" height="80px"/><input type="hidden" name="gurdimagename" value=<?php echo $gurdPicname;?> /></td>
                        <?php }?>
                    </tr>
                    <tr>
                        <td >শিক্ষাগত যোগ্যতা</td>
                        <?php 
                            if($db_custGurdEdu == "") { ?>
                        <td> <textarea class="box" type="text" id="cust_gurdian_education" name="cust_gurdian_education" ><?php echo $db_custGurdEdu;?></textarea></td>
                            <?php }
                            else {?>
                        <td> <textarea class="box" type="text" id="cust_gurdian_education" name="cust_gurdian_education" readonly><?php echo $db_custGurdEdu;?></textarea></td>
                            <?php }?>
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
                        <td  colspan="2">
                            <table>
                                <tr>
                                    <td>বাড়ির নাম / ফ্ল্যাট নং</td>
                                    <td>: <input class="box" type="text" id="g_house" name="g_house" value=<?php show($gpreHouse);?>/></td>
                                </tr>
                                <tr>
                                     <td>বাড়ি নং</td>
                                    <td >: <input class="box" type="text" id="g_house_no" name="g_house_no" value=<?php show($gpreHouseNo);?>/></td>
                                </tr>
                                <tr>
                                     <td >রোড নং</td>
                                    <td>: <input class="box" type="text" id="g_road" name="g_road" value=<?php show($gpreRode);?>/> </td>
                                </tr>
                                <tr>
                                    <td >পোষ্ট কোড</td>
                                    <td>: <input class="box" type="text" id="g_post_code" name="g_post_code" value=<?php show($gprePostCode);?>/></td>
                                </tr>
                                 <?php 
                                    if($gpreDivID == "") { ?>
                                    <tr>
                                        <td colspan="2"><?php getArea5($gpreDivID,$gpreDisID,$gpreThanaID,$gprePostID,$gpreVilID); ?></td>
                                    </tr>
                                    <?php }
                                    else {?>
                                    <tr>
                                        <td >বিভাগ</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $gpreDivname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >জেলা</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $gpreDisname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >থানা</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $gpreThananame;?> /></td>
                                    </tr>
                                   <tr>
                                        <td >পোস্টঅফিস</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $gprePostname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >গ্রাম/পাড়া/প্রোজেক্ট</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $gpreVilname;?> /></td>
                                    </tr>
                    <?php }?>
                            </table>
                        </td>                            
                        <td colspan="2">
                            <table>
                                <tr>
                                   <td>বাড়ির নাম / ফ্ল্যাট নং</td>
                                    <td>: <input class="box" type="text" id="gp_house" name="gp_house" value=<?php show($gperHouse);?>/></td>
                                </tr>
                                <tr>
                                    <td >বাড়ি নং</td>
                                    <td>: <input class="box" type="text" id="gp_house_no" name="gp_house_no" value=<?php show($gperHouseNo);?>/></td>
                                </tr>
                                <tr>
                                    <td >রোড নং</td>
                                    <td>: <input class="box" type="text" id="gp_road" name="gp_road" value=<?php show($gperRode);?>/></td>
                                </tr>
                                <tr>
                                    <td >পোষ্ট কোড</td>
                                    <td>: <input class="box" type="text" id="gp_post_code" name="gp_post_code" value=<?php show($gperPostCode);?>/></td>
                                </tr>
                                <?php 
                                    if($gperDivID == "") { ?>
                                    <tr>
                                        <td colspan="2"><?php getArea6($gperDivID,$gperDisID,$gperThanaID,$gperPostID,$gperVilID); ?></td>
                                    </tr>
                                    <?php }
                                    else {?>
                                    <tr>
                                        <td >বিভাগ</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $gperDivname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >জেলা</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $gperDisname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >থানা</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $gperThananame;?> /></td>
                                    </tr>
                                   <tr>
                                        <td >পোস্টঅফিস</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $gperPostname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >গ্রাম/পাড়া/প্রোজেক্ট</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $gperVilname;?> /></td>
                                    </tr>
                    <?php }?>
                            </table>
                        </td>
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
                        <td width="27%">:   <input class="box" type="text" id="nominee_name" name="nominee_name" value=<?php show($db_nomName);?> />
                            <input type="hidden" name="nomineeID" value="<?php echo $db_nomID?>"/></td>
                    </tr>   
                    <tr>
                        <td >বয়স</td>
                        <td>:   <input class="box" type="text" id="nominee_age" name="nominee_age" value=<?php show($db_nomAge);?> />
                        <input type='hidden' name='custAcID' value="<?php echo $db_custAcID;?>" /></td>
                    </tr>   
                    <tr>
                        <td >সম্পর্ক </td>
                        <td>:   <input class="box" type="text" id="nominee_relation" name="nominee_relation" value=<?php show($db_nomRel);?> /> </td>			
                    </tr>
                    <tr>
                        <td >মোবাইল নং</td>
                        <td>:   <input class="box" type="text" id="nominee_mobile" name="nominee_mobile" value=<?php show($db_nomMobl);?> /></td>			
                    </tr>
                    <tr>
                        <td >ইমেইল</td>
                        <td>:   <input class="box" type="text" id="nominee_email" name="nominee_email" value=<?php show($db_nomEmail);?> /></td>			
                    </tr>
                    <tr>
                        <td >জাতীয় পরিচয়পত্র নং</td>
                        <td>:   <input class="box" type="text" id="nominee_national_ID" name="nominee_national_ID" value=<?php show($db_nomNID);?> /></td>			
                    </tr>
                    <tr>
                        <td >পাসপোর্ট আইডি নং</td>
                        <td>:   <input class="box" type="text" id="nominee_passport_ID" name="nominee_passport_ID" value=<?php show($db_nomPID);?> /></td>			
                    </tr>                     
                    <tr>
                        <td  font-weight="bold" >ছবি </td>
                        <?php
                            if($nompicName == "") { ?>
                         <td >: <img src="<?php echo $db_nomPic;?>" width="80px" height="80px"/><input type="hidden" name="nomimagename" value="<?php echo $nompicName;?>"/> <input class="box5" type="file" id="nominee_picture" name="nominee_picture" style="font-size:10px;"/></td>
                        <?php }
                            else { ?>
                         <td >: <img src="<?php echo $db_nomPic;?>" width="80px" height="80px"/><input type="hidden" name="nomimagename" value="<?php echo $nompicName;?>"/></td>
                        <?php }?>           
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
                        <td  colspan="2">
                             <table>
                                <tr>
                                   <td  >বাড়ির নাম / ফ্ল্যাট নং</td>
                                    <td >: <input class="box" type="text" id="n_house" name="n_house" value="<?php echo $nompreHouse;?>"/></td>
                                </tr>
                                <tr>
                                    <td  >বাড়ি নং</td>
                                    <td >: <input class="box" type="text" id="n_house_no" name="n_house_no" value="<?php echo $nompreHouseNo;?>"/></td>
                                </tr>
                                <tr>
                                    <td >রোড নং</td>
                                    <td>:   <input class="box" type="text" id="n_road" name="n_road" value="<?php echo $nompreRode;?>"/> </td>
                                </tr>
                                <tr>
                                    <td >পোষ্ট কোড</td>
                                    <td>:   <input class="box" type="text" id="n_post_code" name="n_post_code" value="<?php echo $nomprePostCode;?>"/></td>
                                </tr>
                                <?php 
                                    if($nompreDivID == "") { ?>
                                    <tr>
                                        <td colspan="2"><?php getArea3($nompreDivID,$nompreDisID,$nompreThanaID,$nomprePostID,$nompreVilID); ?></td>
                                    </tr>
                                    <?php }
                                    else {?>
                                    <tr>
                                        <td >বিভাগ</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $nompreDivname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >জেলা</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $nompreDisname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >থানা</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $nompreThananame;?> /></td>
                                    </tr>
                                   <tr>
                                        <td >পোস্টঅফিস</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $nomprePostname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >গ্রাম/পাড়া/প্রোজেক্ট</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $nompreVilname;?> /></td>
                                    </tr>
                                <?php }?>
                             </table>
                        </td>                            
                        <td colspan="2">
                            <table>
                                <tr>
                                       <td width="26%"  >বাড়ির নাম / ফ্ল্যাট নং</td>
                                       <td width="28%" >: <input class="box" type="text" id="np_house" name="np_house" value="<?php echo $nomperHouse;?>"/></td>
                                 </tr>
                                        <tr>
                                            <td >বাড়ি নং</td>
                                            <td>: <input class="box" type="text" id="np_house_no" name="np_house_no" value="<?php echo $nomperHouseNo;?>"/></td>
                                        </tr>
                                        <tr>
                                            <td >রোড নং</td>
                                            <td>:   <input class="box" type="text" id="np_road" name="np_road" value="<?php echo $nomperRode;?>"/></td>
                                        </tr>
                                        <tr>
                                            <td >পোষ্ট কোড</td>
                                            <td>:   <input class="box" type="text" id="np_post_code" name="np_post_code" value="<?php echo $nomperPostCode;?>"/></td>
                                        </tr>
                               <?php 
                                    if($nomperDivID == "") { ?>
                                    <tr>
                                        <td colspan="2"><?php getArea4($nomperDivID,$nomperDisID,$nomperThanaID,$nomperPostID,$nomperVilID); ?></td>
                                    </tr>
                                    <?php }
                                    else {?>
                                    <tr>
                                        <td >বিভাগ</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $nomperDivname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >জেলা</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $nomperDisname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >থানা</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $nomperThananame;?> /></td>
                                    </tr>
                                   <tr>
                                        <td >পোস্টঅফিস</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $nomperPostname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >গ্রাম/পাড়া/প্রোজেক্ট</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $nomperVilname;?> /></td>
                                    </tr>
                                <?php }?>
                            </table>
                        </td>                       
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
                        <td colspan="2" ><input type='hidden' name='custAcID' value="<?php echo $db_custAcID;?>" />
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
                                            if($p_count == 0) { ?>
                                            <tr>
                                                <td><input class="textfield"  name="c_ex_name[]" type="text" /></td>
                                                <td><input class="box5"  name="c_pass_year[]" type="text" /></td>
                                                <td><input class="textfield" name="c_institute[]" type="text" /></td>
                                                <td><input class="textfield"  name="c_board[]" type="text" /></td>
                                                <td style="padding-right: 45px;"><input class="box5"  name="c_gpa[]" type="text" /></td>                                             
                                                <td  ><input type="button" class="add2" /></td>
                                            </tr>
                                            <?php } else { 
                                                 for($i=0;$i<$p_count;$i++)
                                                                {
                                                                    echo "<tr><td><input class='textfield' readonly type='text' value='$db_p_xmname[$i]'/></td><td><input class='box5' readonly type='text' value='$db_p_xmyear[$i]'/></td><td><input class='textfield' readonly type='text' value='$db_p_xminstitute[$i]'/>
                                                                                </td><td><input class='textfield' readonly type='text' value='$db_p_xmboard[$i]'/></td><td><input class='box5' readonly type='text' value='$db_p_xmgpa[$i]'/></td>";
                                                                   echo "<td></td><td></td></tr>";
                                                                }
                                            }?>
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
                                            if($n_count == 0) { ?>
                                            <tr>
                                                <td><input class="textfield"  name="n_ex_name[]" type="text" /></td>
                                                <td><input class="box5"  name="n_pass_year[]" type="text" /></td>
                                                <td><input class="textfield"  name="n_institute[]" type="text" /></td>
                                                <td><input class="textfield"  name="n_board[]" type="text" /></td>
                                                <td style="padding-right: 45px;"><input class="box5"  name="n_gpa[]" type="text" /></td>                                             
                                                <td ><input type="button" class="add3" /></td>
                                            </tr>
                                            <?php } else {
                                                  for($i=0;$i<$n_count;$i++)
                                                                {
                                                                    echo "<tr><td><input class='textfield' readonly type='text' value='$db_n_xmname[$i]'/></td><td><input class='box5' readonly type='text' value='$db_n_xmyear[$i]'/></td><td><input class='textfield' readonly type='text' value='$db_n_xminstitute[$i]'/>
                                                                                </td><td><input class='textfield' readonly type='text' value='$db_n_xmboard[$i]'/></td><td><input class='box5' readonly type='text' value='$db_n_xmgpa[$i]'/></td>";
                                                                   echo "<td></td><td></td></tr>";
                                                                }
                                            }?>
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
                        <td  colspan="2" style =" font-size: 14px"><b>বর্তমান ঠিকানা </b><input type='hidden' name='custAcID' value="<?php echo $db_custAcID;?>" /></td>                            
                        <td colspan="2" style =" font-size: 14px"><b> স্থায়ী ঠিকানা   </b></td>
                    </tr>
                    <tr>	
                        <td  colspan="2">
                            <table>
                                <tr>
                                    <td  >বাড়ির নাম / ফ্ল্যাট নং</td>
                                    <td >:   <input class="box" type="text" id="c_house" name="c_house" value=<?php show($preHouse);?>/></td>
                                </tr>
                                 <tr>
                                    <td  >বাড়ি নং</td>
                                    <td >:   <input class="box" type="text" id="c_house_no" name="c_house_no" value=<?php show($preHouseNo);?> /></td>
                                </tr>
                                 <tr>
                                    <td >রোড নং</td>
                                    <td>:   <input class="box" type="text" id="c_road" name="c_road" value=<?php show($preRode);?> /> </td>
                                </tr>
                                 <tr>
                                    <td >পোষ্ট কোড</td>
                                    <td>:   <input class="box" type="text" id="c_post_code" name="c_post_code" value=<?php show($prePostCode);?> /></td>
                                </tr>
                                <?php 
                                    if($preDivID == "") { ?>
                                    <tr>
                                        <td colspan="2"><?php getArea($preDivID,$preDisID,$preThanaID,$prePostID,$preVilID); ?></td>
                                    </tr>
                                    <?php }
                                    else {?>
                                    <tr>
                                        <td >বিভাগ</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $preDivname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >জেলা</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $preDisname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >থানা</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $preThananame;?> /></td>
                                    </tr>
                                   <tr>
                                        <td >পোস্টঅফিস</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $prePostname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >গ্রাম/পাড়া/প্রোজেক্ট</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $preVilname;?> /></td>
                                    </tr>
                                <?php }?>
                            </table>
                        </td>                            
                        <td colspan="2" >
                            <table>
                                <tr>    
                                    <td  >বাড়ির নাম / ফ্ল্যাট নং</td>
                                    <td >:   <input class="box" type="text" id="cp_house" name="cp_house" value=<?php show($perHouse);?>/></td>
                                </tr>
                                <tr>                     
                                    <td >বাড়ি নং</td>
                                    <td>:   <input class="box" type="text" id="cp_house_no" name="cp_house_no" value=<?php show($perHouseNo);?> /></td>
                                </tr>
                                <tr>                       
                                    <td >রোড নং</td>
                                    <td>:   <input class="box" type="text" id="cp_road" name="cp_road" value=<?php show($perRode);?> /></td>
                                </tr>
                                <tr>                       
                                    <td >পোষ্ট কোড</td>
                                    <td>:   <input class="box" type="text" id="cp_post_code" name="cp_post_code" value=<?php show($perPostCode);?> /></td>
                                </tr>
                                <?php 
                                    if($perDivID == "") { ?>
                                    <tr>
                                         <td colspan="2"><?php getArea2($perDivID,$perDisID,$perThanaID,$perPostID,$perVilID); ?></td>
                                    </tr>
                                    <?php }
                                    else {?>
                                    <tr>
                                        <td >বিভাগ</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $perDivname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >জেলা</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $perDisname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >থানা</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $perThananame;?> /></td>
                                    </tr>
                                   <tr>
                                        <td >পোস্টঅফিস</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $perPostname;?> /></td>
                                    </tr>
                                    <tr>
                                        <td >গ্রাম/পাড়া/প্রোজেক্ট</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $perVilname;?> /></td>
                                    </tr>
                                <?php }?>
                            </table>
                        </td>
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
