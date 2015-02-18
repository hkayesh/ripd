<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/areaSearch2.php';
$userID = $_SESSION['userIDUser'];

// ************************** update query ***********************************
if (isset($_POST['submit1'])) {
    $proprietorID = $_POST['proID'];
    $prop_father_name = $_POST['prop_father_name'];
    $prop_motherName = $_POST['prop_motherName'];
    $prop_spouseName = $_POST['prop_spouseName'];
    $prop_occupation = $_POST['prop_occupation'];
    $prop_religion = $_POST['prop_religion'];
    $prop_natonality = $_POST['prop_natonality'];
    $prop_nationalID_no = $_POST['prop_nationalID_no'];
    $prop_passportID_no = $_POST['prop_passportID_no'];
    $prop_birth_certificate_no = $_POST['prop_birth_certificate_no'];
    $dob = $_POST['dob'];
    // picture, sign, finger print
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["image"]["name"]));
    $image_name = $_FILES["image"]["name"];
    if($image_name=="")
        {
            $image_name= "pwr-" .$proprietorID."-".$_POST['imagename'];
             $image_path = "pic/" . $image_name;
        }
        else
        {
            $image_name = "pwr-" .$proprietorID."-image.".$extension;
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
            $sign_name= "pwr-" .$proprietorID."-".$_POST['signname'];
             $sing_path = "sign/" . $sign_name;
        }
        else
        {
            $sign_name = "pwr-" .$proprietorID."-sign.".$extension;
            $sing_path = "sign/" . $sign_name;
            if (($_FILES["scanDoc_signature"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                    {
                        move_uploaded_file($_FILES["scanDoc_signature"]["tmp_name"], "sign/" . $sign_name);
                    } 
            else 
                    {
                    echo "Invalid file format.";
                    }
        }
 
    $extension = end(explode(".", $_FILES["scanDoc_finger_print"]["name"]));
    $finger_name = $_FILES["scanDoc_finger_print"]["name"];
    if($finger_name=="")
        {
            $finger_name="pwr-" .$proprietorID."-".$_POST['fingername'];
             $finger_path = "fingerprints/" . $finger_name;
        }
        else
        {
             $finger_name ="pwr-" .$proprietorID."-finger.".$extension;
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
mysql_query("START TRANSACTION");
    $sql_update_proprietor = mysql_query("UPDATE proprietor_account SET prop_father_name='$prop_father_name', prop_motherName='$prop_motherName', prop_spouseName='$prop_spouseName', 
                                                        prop_occupation='$prop_occupation', prop_religion='$prop_religion', prop_natonality='$prop_natonality', prop_nationalID_no='$prop_nationalID_no', 
                                                        prop_passportID_no='$prop_passportID_no', prop_date_of_birth='$dob', prop_birth_certificate_no='$prop_birth_certificate_no',  
                                                        prop_scanDoc_picture='$image_path', prop_scanDoc_signature='$sing_path',  prop_scanDoc_finger_print='$finger_path'
                                                        WHERE idpropaccount = $proprietorID");
      
    //proprietor's Current Address Infromation
    $p_Village_idVillage = $_POST['vilg_id'];
    $p_Post_idPost = $_POST['post_id'];
    $p_Thana_idThana = $_POST['thana_id'];
    $p_house = $_POST['p_house'];
    $p_house_no = $_POST['p_house_no'];
    $p_road = $_POST['p_road'];
    $p_post_code = $_POST['p_post_code'];
    //proprietor's Permanent Address information
    $pp_Village_idVillage = $_POST['vilg_id1'];
    $pp_Post_idPost = $_POST['post_id1'];
    $pp_Thana_idThana = $_POST['thana_id1'];
    $pp_house = $_POST['pp_house'];
    $pp_house_no = $_POST['pp_house_no'];
    $pp_road = $_POST['pp_road'];
    $pp_post_code = $_POST['pp_post_code'];    
   //address_type=Present
    $sql_sel_present_adrs= mysql_query("SELECT * FROM address WHERE adrs_cepng_id=$proprietorID AND address_whom='pwr' AND address_type='Present' ");
    if(mysql_num_rows($sql_sel_present_adrs)<1)
    {
        $sql_p_insert_current_address = mysql_query("INSERT INTO address 
                                    (address_type, house, house_no, road, address_whom, post_code,Thana_idThana, post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Present', '$p_house', '$p_house_no', '$p_road', 'pwr', '$p_post_code','$p_Thana_idThana','$p_Post_idPost', '$p_Village_idVillage', '$proprietorID')") ;
    }
    else {$sql_p_insert_current_address = mysql_query("UPDATE address 
                                                                    SET house='$p_house', house_no='$p_house_no', road='$p_road', post_code='$p_post_code',Thana_idThana='$p_Thana_idThana', post_idpost='$p_Post_idPost', village_idvillage='$p_Village_idVillage'  WHERE adrs_cepng_id=$proprietorID AND address_whom='pwr' AND address_type='Present' ");}
    //address_type=Permanent
     $sql_sel_permanent_adrs= mysql_query("SELECT * FROM address WHERE adrs_cepng_id=$proprietorID AND address_whom='pwr' AND address_type='Permanent' ");
    if(mysql_num_rows($sql_sel_permanent_adrs)<1)
    {
        $sql_pp_insert_permanent_address = mysql_query("INSERT INTO address 
                                    (address_type, house, house_no, road, address_whom, post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Permanent', '$pp_house', '$pp_house_no', '$pp_road', 'pwr', '$pp_post_code','$pp_Thana_idThana', '$pp_Post_idPost', '$pp_Village_idVillage', '$proprietorID')");
    }
   else {$sql_pp_insert_permanent_address = mysql_query("UPDATE address 
                                                                         SET house='$pp_house', house_no='$pp_house_no', road='$pp_road', post_code='$pp_post_code',Thana_idThana='$pp_Thana_idThana', post_idpost='$pp_Post_idPost', village_idvillage='$pp_Village_idVillage'  WHERE adrs_cepng_id=$proprietorID AND address_whom='pwr' AND address_type ='Permanent' ") or exit(mysql_error()); }

    if ($sql_update_proprietor || $sql_p_insert_current_address || $sql_pp_insert_permanent_address) {
        mysql_query("COMMIT");
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        mysql_query("ROLLBACK");
        $msg = "ভুল হয়েছে";
    }
}
elseif (isset($_POST['submit2'])) {
    $proprietorID = $_POST['proID'];
    $nominee_name = $_POST['nominee_name'];
    $nominee_age = $_POST['nominee_age'];
    $nominee_relation = $_POST['nominee_relation'];
    $nominee_mobile = $_POST['nominee_mobile'];
    $nominee_email = $_POST['nominee_email'];
    $nominee_national_ID = $_POST['nominee_national_ID'];
    $nominee_passport_ID = $_POST['nominee_passport_ID'];
    $nominee_id = $_POST['nomineeID'];
    //Insert Into Nominee table
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["nominee_picture"]["name"]));
    $image = $_FILES["nominee_picture"]["name"];
    if($image=="")
        {
            $image_name="nom-pwr-".$proprietorID. "-" . $_POST['nomimage'];
             $image_path = "pic/" . $image_name;
        }
        else
        {

            $image_name = "nom-pwr-".$proprietorID."-image.".$extension;
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
                                       '$nominee_age','$nominee_passport_ID','$image_path','pwr','$proprietorID')") or exit(mysql_error());
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
        $sql_n_insert_current_address = mysql_query("INSERT INTO $dbname.address 
                                    (address_type, house, house_no,road, address_whom, post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Present', '$n_house', '$n_house_no', '$n_road', 'nmn', '$n_post_code', '$n_Thana_idThana', '$n_Post_idPost', '$n_Village_idVillage','$nominee_id')")or exit(mysql_error());
    }
    else {
        $sql_n_insert_current_address = mysql_query("UPDATE $dbname.address 
                                                                    SET house='$n_house', house_no='$n_house_no', road='$n_road', post_code='$n_post_code',Thana_idThana='$n_Thana_idThana', post_idpost='$n_Post_idPost', village_idvillage='$n_Village_idVillage'  
                                                                    WHERE adrs_cepng_id=$nominee_id AND address_whom='nmn' AND address_type='Present' ");}
    //nominee address_type=Permanent
    $sql_n_sel_permanent_adrs= mysql_query("SELECT * FROM address WHERE adrs_cepng_id=$nominee_id AND address_whom='nmn' AND address_type='Permanent' ");
    if(mysql_num_rows($sql_n_sel_permanent_adrs)<1)
    {
         $sql_np_insert_permanent_address = mysql_query("INSERT INTO $dbname.address 
                                    (address_type, house, house_no, road, address_whom,post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Permanent', '$np_house', '$np_house_no','$np_road', 'nmn',  '$np_post_code','$np_Thana_idThana','$np_Post_idPost', '$np_Village_idVillage','$nominee_id')");
    }
    else {
        $sql_np_insert_permanent_address = mysql_query("UPDATE $dbname.address 
                                                                    SET house='$np_house', house_no='$np_house_no', road='$np_road', post_code='$np_post_code',Thana_idThana='$np_Thana_idThana', post_idpost='$np_Post_idPost', village_idvillage='$np_Village_idVillage'  
                                                                    WHERE adrs_cepng_id=$nominee_id AND address_whom='nmn' AND address_type='Permanent' ");
    }    
   
    if ($sql_nominee || $sql_n_insert_current_address || $sql_np_insert_permanent_address) {
        mysql_query("COMMIT");
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        mysql_query("ROLLBACK");
        $msg = "ভুল হয়েছে";
    }
} 
elseif (isset($_POST['submit3'])) {
    $proprietorID = $_POST['proID'];
    //customer education
    $e_ex_name = $_POST['e_ex_name'];
    $e_pass_year = $_POST['e_pass_year'];
    $e_institute = $_POST['e_institute'];
    $e_board = $_POST['e_board'];
    $e_gpa = $_POST['e_gpa'];
    $a = count($e_ex_name);
    mysql_query("START TRANSACTION");
    $del_p_edu = mysql_query("DELETE FROM education WHERE education_type='pwr' AND cepn_id=$proprietorID");
    for ($i = 0; $i < $a; $i++) {
        $sql_insert_emp_edu = "INSERT INTO " . $dbname . ".`education` ( `exam_name` ,`passing_year` ,`institute_name`,`board`,`gpa`,`education_type`,`cepn_id`) VALUES ('$e_ex_name[$i]', '$e_pass_year[$i]','$e_institute[$i]','$e_board[$i]','$e_gpa[$i]','pwr','$proprietorID');";
        $emp_edu = mysql_query($sql_insert_emp_edu) or exit('query failed: ' . mysql_error());
    }
    //nominee education
    $result = mysql_query("SELECT * FROM $dbname.nominee WHERE cep_type = 'pwr' AND cep_nominee_id=$proprietorID ");
    $nomrow = mysql_fetch_array($result);
    $nomineeID = $nomrow['idNominee'];
    $n_ex_name = $_POST['n_ex_name'];
    $n_pass_year = $_POST['n_pass_year'];
    $n_institute = $_POST['n_institute'];
    $n_board = $_POST['n_board'];
    $n_gpa = $_POST['n_gpa'];
    $b = count($n_ex_name);
    $del_n_edu = mysql_query("DELETE FROM education WHERE education_type='nmn' AND cepn_id=$nomineeID");
    for ($i = 0; $i < $b; $i++) {
        $sql_insert_nom_edu = "INSERT INTO " . $dbname . ".`education` ( `exam_name` ,`passing_year` ,`institute_name`,`board`,`gpa`,`education_type`,`cepn_id`) VALUES ('$n_ex_name[$i]', '$n_pass_year[$i]','$n_institute[$i]','$n_board[$i]','$n_gpa[$i]','nmn','$nomineeID');";
        $nom_edu = mysql_query($sql_insert_nom_edu) or exit('query failed: ' . mysql_error());
    }
    if (($emp_edu && $del_p_edu) || ($nom_edu && $del_n_edu)) {
        mysql_query("COMMIT");
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        mysql_query("ROLLBACK");
        $msg = "ভুল হয়েছে";
    }
}
elseif (isset($_POST['submit4'])) {
    $proprietorID = $_POST['proID'];
    $pathArray = array();
    $p_scanname =$_POST['scan'];
    
    for ($i = 1; $i < 9; $i++) {
        $scan_document = "";
        $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG", "pdf"); //File Type
        $scanDoc = "scanDoc" . $i;
        $files_sequence = array(1 => "ssc", "nationalID", "hsc", "birth_certificate", "onars", "chairman_cert", "masters", "other");
        $file_name = $files_sequence[$i];
        $extension = end(explode(".", $_FILES[$scanDoc]['name']));
        $scan_doc_name =  $file_name."-".$proprietorID."-".$_FILES[$scanDoc]['name'];
        $scan_doc_path_temp = "scaned/".$scan_doc_name;
        if (($_FILES[$scanDoc]['size'] < 999999999999) && in_array($extension, $allowedExts)) {
            move_uploaded_file($_FILES[$scanDoc]['tmp_name'], $scan_doc_path_temp);
            $scan_document = $scan_doc_path_temp;
            $pathArray[$i] = $scan_document;
        } elseif ($_FILES[$scanDoc]['size'] == 0) {
            $pathArray[$i] ="scaned/".$file_name."-".$proprietorID."-".$p_scanname[$i];
        } else {
            echo "Invalid file format.</br>";
        }
    }
$sql_scandoc= mysql_query("SELECT * FROM ep_certificate_scandoc_extra WHERE ep_id=$proprietorID AND emp_type='pwr'");
    if(mysql_num_rows($sql_scandoc) < 1)
    {
    $sql_images_scan_doc = mysql_query("INSERT INTO ep_certificate_scandoc_extra
                                 (emplo_scanDoc_national_id, emplo_scanDoc_birth_certificate, emplo_scanDoc_chairman_certificate, scanDoc_ssc, scanDoc_hsc, scanDoc_hons, scanDoc_masters, scanDoc_other, emp_type, ep_id)
                                 VALUES('$pathArray[2]', '$pathArray[4]', '$pathArray[6]', '$pathArray[1]', '$pathArray[3]', 
                                 '$pathArray[5]',  '$pathArray[7]', '$pathArray[8]', 'pwr','$proprietorID')");
    }
    else {
        $sql_images_scan_doc = mysql_query("UPDATE ep_certificate_scandoc_extra SET emplo_scanDoc_national_id= '$pathArray[2]', emplo_scanDoc_birth_certificate='$pathArray[4]',
                                                emplo_scanDoc_chairman_certificate='$pathArray[6]', scanDoc_ssc='$pathArray[1]', scanDoc_hsc='$pathArray[3]',
                                                scanDoc_hons='$pathArray[5]', scanDoc_masters=  '$pathArray[7]', scanDoc_other='$pathArray[8]' WHERE emp_type= 'pwr' AND ep_id='$proprietorID' ") or exit(mysql_error());
    }
    if ($sql_images_scan_doc) {
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        $msg = "ভুল হয়েছে";
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
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        $msg = "ভুল হয়েছে";
    }
}
?>
<!--######################## select query for show ################################## -->
<?php
// *********************** for bacis ************************************************************************************************
     $sql_proprie_sel = mysql_query("SELECT * FROM proprietor_account,cfs_user WHERE cfs_user_idUser= idUser AND  idUser=$userID ");
     $proprietorrow = mysql_fetch_assoc($sql_proprie_sel);
     $proprietorID = $proprietorrow['cfs_user_idUser'];
     $db_proprietorName = $proprietorrow['account_name'];
     $db_proprietorAcc = $proprietorrow['account_number'];
     $db_proprietorMail = $proprietorrow['email'];
     $db_empRipdMail = $proprietorrow['ripd_email'];
     $db_proprietorMob = $proprietorrow['mobile'];
     $db_proprietorFather = $proprietorrow['prop_father_name'];
     $db_proprietorMother = $proprietorrow['prop_motherName'];
     $db_proprietorSpouse = $proprietorrow['prop_spouseName'];
     $db_proprietorOccu = $proprietorrow['prop_occupation'];
     $db_proprietorRel = $proprietorrow['prop_religion'];
     $db_proprietorNation = $proprietorrow['prop_natonality'];
     $db_proprietorNID = $proprietorrow['prop_nationalID_no'];
     $db_proprietorPID = $proprietorrow['prop_passportID_no'];
     $db_proprietorDOB = $proprietorrow['prop_date_of_birth'];
     $db_proprietorDOBID = $proprietorrow['prop_birth_certificate_no'];
     $db_proprietorSig = $proprietorrow['prop_scanDoc_signature'];
     $signname = end(explode("-", $db_proprietorSig));
     $db_proprietorPic = $proprietorrow['prop_scanDoc_picture'];
     $picname = end(explode("-", $db_proprietorPic));
     $db_proprietorFP = $proprietorrow['prop_scanDoc_finger_print'];
     $fingername = end(explode("-", $db_proprietorFP));
     
     $sql_proprie_adrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='pwr' AND adrs_cepng_id=$proprietorID AND address_type='Present'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $presentAddrow = mysql_fetch_assoc($sql_proprie_adrs_sel);
     $preHouse = $presentAddrow['house'];
     $preHouseNo = $presentAddrow['house_no'];
     $preRode = $presentAddrow['road'];
     $prePostCode = $presentAddrow['post_code'];
     $prePostID = $presentAddrow['idPost_office'];
     $preVilID = $presentAddrow['idvillage'];
     $preThanaID = $presentAddrow['idThana'];
     $preDisID = $presentAddrow['idDistrict'];
     $preDivID = $presentAddrow['idDivision'];
          
     $sql_proprie_Padrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='pwr' AND adrs_cepng_id=$proprietorID AND address_type='Permanent'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $permenentAddrow = mysql_fetch_assoc($sql_proprie_Padrs_sel);
     $perHouse = $permenentAddrow['house'];
     $perHouseNo = $permenentAddrow['house_no'];
     $perRode = $permenentAddrow['road'];
     $perPostCode = $permenentAddrow['post_code'];
     $perPostID = $permenentAddrow['idPost_office'];
     $perVilID = $permenentAddrow['idvillage'];
     $perThanaID = $permenentAddrow['idThana'];
     $perDisID = $permenentAddrow['idDistrict'];
     $perDivID = $permenentAddrow['idDivision'];

// *************************************** for nominee ****************************************************************************** 
     $sql_nomi_sel = mysql_query("SELECT * FROM nominee WHERE cep_type='pwr' AND  cep_nominee_id= $proprietorID ");
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
     
     // *************************************** for education ****************************************************************************** 
     $p_count =0;
     $sql_Pedu_sel = mysql_query("SELECT * FROM education WHERE education_type='pwr' AND cepn_id=$proprietorID");
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
     $sql_Nedu_sel = mysql_query("SELECT * FROM education,nominee WHERE cep_nominee_id=$proprietorID AND cep_type='pwr' 
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
      // **************************************** for প্রয়োজনীয় ডকুমেন্টস ***************************************************************************
       $sql_scandoc= mysql_query("SELECT * FROM ep_certificate_scandoc_extra WHERE ep_id=$proprietorID AND emp_type='pwr'");
        $scan_row = mysql_fetch_assoc($sql_scandoc);
        $db_scan_NID = $scan_row['emplo_scanDoc_national_id'];
        $NID_name = end(explode("-", $db_scan_NID));
        $db_scan_DOB = $scan_row['emplo_scanDoc_birth_certificate'];
        $DOB_name = end(explode("-", $db_scan_DOB));
        $db_scan_CC = $scan_row['emplo_scanDoc_chairman_certificate'];
        $CC_name = end(explode("-", $db_scan_CC));
        $db_scan_ssc = $scan_row['scanDoc_ssc'];
        $ssc_name = end(explode("-", $db_scan_ssc));
        $db_scan_hsc = $scan_row['scanDoc_hsc'];
        $hsc_name = end(explode("-", $db_scan_hsc));
        $db_scan_hons = $scan_row['scanDoc_hons'];
        $hons_name = end(explode("-", $db_scan_hons));
        $db_scan_masters = $scan_row['scanDoc_masters'];
        $masters_name = end(explode("-", $db_scan_masters));
        $db_scan_other = $scan_row['scanDoc_other'];
        $other_name = end(explode("-", $db_scan_other));
?>
<title>প্রোপ্রাইটার অ্যাকাউন্ট</title>
<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/area2.js"></script>
<script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>
<script>
</script>
<script type="text/javascript">    
    $('.del2').live('click',function(){
        $(this).parent().parent().remove();
    });
    $('.add2').live('click',function()
    {var count3 = 2;
        if(count3<6){
            var appendTxt= "<tr> <td><input class='textfield'  name='e_ex_name[]' type='text' /></td><td><input class='box5'  name='e_pass_year[]' type='text' /></td><td><input class='textfield'  name='e_institute[]' type='text' /></td><td><input class='textfield'  name='e_board[]' type='text' /></td><td><input class='box5' name='e_gpa[]' type='text' /></td><td style='padding-right: 3px;'><input type='button' class='del2' /></td><td>&nbsp;<input type='button' class='add2' /></td></tr>";
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

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="account_management.php"><b>ফিরে যান</b></a></div>
        <div class="domtab">
            <ul class="domtabs">
                <li class="current"><a href="#01">মূল তথ্য</a></li><li class="current"><a href="#02">পারিবারিক তথ্য</a></li><li class="current"><a href="#03">নমিনির তথ্য</a></li><li class="current"><a href="#04">শিক্ষাগত যোগ্যতা</a></li><li class="current"><a href="#05">প্রয়োজনীয় ডকুমেন্টস</a></li>
            </ul>
        </div>
        
         <div>
            <h2><a name="01" id="01"></a></h2><br/>
            <form method="POST" onsubmit=""  enctype="multipart/form-data" action="" id="emp_form1" name="emp_form1">	
                <table  class="formstyle">     
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>প্রোপ্রাইটারের মূল তথ্য</h1></th></tr>
                    <tr><td colspan="4" ></td>
                        <?php
                        if ($msg != "") {
                            echo '<tr> <td colspan="2" style="text-align: center; color: green; font-size: 15px"><b>' . $msg . '</b></td></tr>';
                        }
                        ?>
                    </tr>
                   <tr>
                        <td>প্রোপ্রাইটারের নাম</td>
                        <td>:   <input class='box' style="width:220px;" type='text' id='name' name='name' value="<?php echo $db_proprietorName;?>"/>
                            <input type='hidden' name='cfsid' value="<?php echo $userID;?>"/></td>			
                    </tr>
                    <tr>
                        <td >একাউন্ট নাম্বার</td>
                        <td>:   <input class='box' style="width:220px;" type='text' id='acc_num' name='acc_num' readonly value="<?php echo $db_proprietorAcc;?>"/></td>			
                    </tr>
                    <tr>
                        <td>অফিশিয়াল ই মেইল</td>
                        <td>:   <input class='box' style="width:220px;" type='text' readonly="" value="<?php echo $db_empRipdMail;?>" /></td>			
                    </tr>
                    <tr>
                        <td >ব্যক্তিগত ই মেইল</td>
                       <td>:   <input class='box' style="width:220px;" type='text' id='email' name='email' onblur='check(this.value)' value="<?php echo $db_proprietorMail;?>" /> <em>ইংরেজিতে লিখুন</em> <span id='error_msg' style='margin-left: 5px'></span></td>			
                    </tr>
                    <tr>
                        <td >মোবাইল</td>
                        <td>:   <input class='box' style="width:220px;" type='text' id='mobile' name='mobile' onkeypress=' return numbersonly(event)' value="<?php echo $db_proprietorMob;?>" /></td>		
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
            <form method="POST" onsubmit="" enctype="multipart/form-data" action="" id="prop_form" name="prop_form">	
                <table  class="formstyle">  
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>প্রোপ্রাইটারের ব্যক্তিগত তথ্য</h1></th></tr>
                    <tr><td colspan="4" ></td></tr>
                    <tr>
                        <td>বাবার নাম </td>
                        <td>:  <input class="box" type="text" id="prop_father_name" name="prop_father_name" value="<?php echo $db_proprietorFather;?>"/>
                        <input type="hidden" name="proID" value="<?php echo $proprietorID;?>" /></td>	
                        <td>ছবি : </td>
                        <td><img src="<?php echo $db_proprietorPic;?>" width="80px" height="80px"/><input type="hidden" name="imagename" value="<?php echo $picname;?>"/> &nbsp;<input class="box" type="file" id="image" name="image" style="font-size:10px;" /></td>
                    </tr>
                    <tr>
                        <td >মায়ের নাম </td>
                        <td>:  <input class="box" type="text" id="prop_motherName" name="prop_motherName" value="<?php echo $db_proprietorMother;?>"/></td>
                        <td >স্বাক্ষর: </td>
                        <td><img src="<?php echo $db_proprietorSig;?>" width="80px" height="80px"/><input type="hidden" name="signname" value="<?php echo $signname;?>"/>&nbsp;<input class="box" type="file" id="scanDoc_signature" name="scanDoc_signature" style="font-size:10px;"/></td> 
                    </tr>
                    <tr>
                        <td >দম্পতির নাম  </td>
                        <td>:  <input class="box" type="text" id="prop_spouseName" name="prop_spouseName" value="<?php echo $db_proprietorSpouse;?>"/> </td>			
                        <td >টিপসই: </td>
                        <td><img src="<?php echo $db_proprietorFP;?>" width="80px" height="80px"/><input type="hidden" name="fingername" value="<?php echo $fingername;?>"/>&nbsp;<input class="box" type="file" id="scanDoc_finger_print" name="scanDoc_finger_print" style="font-size:10px;"/></td> 
                    </tr>
                    <tr>
                        <td >পেশা</td>
                        <td>:  <input class="box" type="text" id="prop_occupation" name="prop_occupation" value="<?php echo $db_proprietorOccu;?>"/></td>                         
                    </tr>
                    <tr>
                        <td>ধর্ম </td>
                        <td>:  <input  class="box" type="text" id="prop_religion" name="prop_religion" value="<?php echo $db_proprietorRel;?>"/></td>	                             
                    </tr>
                    <tr>
                        <td >জাতীয়তা</td>
                        <td>:  <input class="box" type="text" id="prop_natonality" name="prop_natonality" value="<?php echo $db_proprietorNation;?>"/> </td>			
                    </tr>
                    <tr>
                        <td>জন্মতারিখ</td>
                        <td >:   <input class="box" type="date" name ="dob" value="<?php echo $db_proprietorDOB;?>"/></td>			
                    </tr>
                    <tr>
                    <td >জাতীয় পরিচয়পত্র নং</td>
                    <td>:  <input class="box" type="text" id="prop_nationalID_no" name="prop_nationalID_no" value="<?php echo $db_proprietorNID;?>"/></td>			
                    </tr>
                    <tr>
                        <td >পাসপোর্ট আইডি নং</td>
                        <td>:  <input class="box" type="text" id="prop_passportID_no" name="prop_passportID_no" value="<?php echo $db_proprietorPID;?>"/></td>			
                    </tr>
                    <tr>
                        <td >জন্ম সনদ নং</td>
                        <td>:  <input class="box" type="text" id="prop_birth_certificate_no" name="prop_birth_certificate_no" value="<?php echo $db_proprietorDOBID;?>" /></td>			
                    </tr>   
                    <tr>
                        <td colspan="4" ><hr /></td>
                    </tr>
                    <tr>
                        <td  colspan="2" style =" font-size: 14px"><b>বর্তমান ঠিকানা </b></td>                            
                        <td colspan="2" style =" font-size: 14px"><b> স্থায়ী ঠিকানা   </b></td>
                    </tr>         
                    <tr>
                        <td  >বাড়ির নাম / ফ্ল্যাট নং</td>
                        <td >:   <input class="box" type="text" id="p_house" name="p_house" value="<?php echo $preHouse;?>" /></td>
                        <td  >বাড়ির নাম / ফ্ল্যাট নং</td>
                        <td >:   <input class="box" type="text" id="pp_house" name="pp_house" value="<?php echo $perHouse;?>" /></td>
                    </tr>
                    <tr>
                        <td  >বাড়ি নং</td>
                        <td >:   <input class="box" type="text" id="p_house_no" name="p_house_no" value="<?php echo $preHouseNo;?>" /></td>
                        <td >বাড়ি নং</td>
                        <td>:   <input class="box" type="text" id="pp_house_no" name="pp_house_no" value="<?php echo $perHouseNo;?>" /></td>
                    </tr>
                    <tr>
                        <td >রোড নং</td>
                        <td>:   <input class="box" type="text" id="p_road" name="p_road" value="<?php echo $preRode;?>"/> </td>
                        <td >রোড নং</td>
                        <td>:   <input class="box" type="text" id="pp_road" name="pp_road" value="<?php echo $perRode;?>"/></td>
                    </tr>
                    <tr>
                        <td >পোষ্ট কোড</td>
                        <td>:   <input class="box" type="text" id="p_post_code" name="p_post_code" value="<?php echo $prePostCode;?>"/></td>
                        <td >পোষ্ট কোড</td>
                        <td>:   <input class="box" type="text" id="pp_post_code" name="pp_post_code" value="<?php echo $perPostCode;?>"/></td>
                    </tr> 
                    <tr>
                        <td colspan="2"><?php getArea($preDivID,$preDisID,$preThanaID,$prePostID,$preVilID); ?></td>
                        <td colspan="2"><?php getArea2($perDivID,$perDisID,$perThanaID,$perPostID,$perVilID); ?></td>
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
            <form method="POST" onsubmit="" enctype="multipart/form-data" action="" id="emp_form1" name="emp_form1">	
                <table  class="formstyle">     
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>প্রোপ্রাইটারের নমিনির তথ্য</h1></th></tr>
                    <tr><td colspan="4" ></td>
                    </tr>
                    <tr>
                        <td >নমিনির নাম</td>
                        <td>:  <input class="box" type="text" id="nominee_name" name="nominee_name" value="<?php echo $db_nomName;?>"/><input type="hidden" name="nomineeID" value="<?php echo $db_nomID?>"/></td>	
                        <td>পাসপোর্ট ছবি </td>
                        <td >:  <img src="<?php echo $db_nomPic;?>" width="80px" height="80px"/><input type="hidden" name="nomimage" value="<?php echo $nompicName;?>"/> &nbsp;<input class="box" type="file" id="nominee_picture" name="nominee_picture" style="font-size:10px;"/></td>
                    </tr>     
                    <tr>
                        <td >বয়স</td>
                        <td>:  <input class="box" type="text" id="nominee_age" name="nominee_age" value="<?php echo $db_nomAge;?>"/>
                        <input type="hidden" name="proID" value="<?php echo $proprietorID;?>" /></td>
                    </tr>     
                    <tr>
                        <td >সম্পর্ক </td>
                        <td>:  <input class="box" type="text" id="nominee_relation" name="nominee_relation" value="<?php echo $db_nomRel;?>"/> </td>			
                    </tr>
                    <tr>
                        <td >মোবাইল নং</td>
                        <td>:  <input class="box" type="text" id="nominee_mobile" name="nominee_mobile" value="<?php echo $db_nomMobl;?>"/></td>			
                    </tr>
                    <tr>
                        <td >ইমেইল</td>
                        <td>:  <input class="box" type="text" id="nominee_email" name="nominee_email" value="<?php echo $db_nomEmail;?>"/></td>			
                    </tr>
                    <tr>
                        <td >জাতীয় পরিচয়পত্র নং</td>
                        <td>:  <input class="box" type="text" id="nominee_national_ID" name="nominee_national_ID" value="<?php echo $db_nomNID;?>"/></td>			
                    </tr>
                    <tr>
                        <td >পাসপোর্ট আইডি নং</td>
                        <td>:  <input class="box" type="text" id="nominee_passport_ID" name="nominee_passport_ID" value="<?php echo $db_nomPID;?>"/></td>			
                    </tr> 
                    <tr>
                        <td colspan="4" ><hr /></td>
                    </tr>
                    <tr>	
                        <td  colspan="2" style =" font-size: 14px"><b>বর্তমান ঠিকানা </b></td>                            
                        <td colspan="2" style =" font-size: 14px"><b> স্থায়ী ঠিকানা   </b></td>
                    </tr>
                    <tr>
                        <td  >বাড়ির নাম / ফ্ল্যাট নং</td>
                        <td >:   <input class="box" type="text" id="n_house" name="n_house" value="<?php echo $nompreHouse;?>"/></td>
                        <td  >বাড়ির নাম / ফ্ল্যাট নং</td>
                        <td >:   <input class="box" type="text" id="np_house" name="np_house" value="<?php echo $nomperHouse;?>"/></td>
                    </tr>
                    <tr>
                        <td  >বাড়ি নং</td>
                        <td >:   <input class="box" type="text" id="n_house_no" name="n_house_no" value="<?php echo $nompreHouseNo;?>"/></td>
                        <td >বাড়ি নং</td>
                        <td>:   <input class="box" type="text" id="np_house_no" name="np_house_no" value="<?php echo $nomperHouseNo;?>"/></td>
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
                        <td colspan="4" style="padding-top: 10px; padding-left: 250px;padding-bottom: 5px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit2" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" />
                        </td>                           
                    </tr>
                </table>
                </fieldset>
            </form>
        </div>

         <div>
            <h2><a name="04" id="04"></a></h2><br/>
            <form method="POST" onsubmit="">	
                <table  class="formstyle">          
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>প্রোপ্রাইটারের প্রয়োজনীয় তথ্য</h1></th></tr>
                    <tr><td colspan="4" ></td>
                    </tr>   
                    <tr>
                        <td colspan="2" > 
                    </tr>
                    <tr>
                        <td colspan="2" >
                            <table width="100%">
                                <tr>	
                                    <td  colspan="2"   style =" font-size: 14px"><b>প্রোপ্রাইটারের শিক্ষাগত যোগ্যতা</b></td>                                                
                                </tr>
                                <tr>                      
                                    <td><input type="hidden" name="proID" value="<?php echo $proprietorID;?>" />
                                        <table id="container_others32">
                                            <tr>
                                                <td>পরীক্ষার নাম / ডিগ্রী</td>
                                                <td>পাশের সাল</td>
                                                <td>প্রতিষ্ঠানের নাম </td>
                                                <td>বোর্ড / বিশ্ববিদ্যালয়</td>
                                                <td>জি.পি.এ / বিভাগ</td>      
                                            </tr>
                                             <?php
                                                            echo "<tr><td><input class='textfield'  name='e_ex_name[]' type='text' value='$db_p_xmname[0]'/></td><td><input class='box5'  name='e_pass_year[]' type='text' value='$db_p_xmyear[0]'/></td><td><input class='textfield'  name='e_institute[]' type='text' value='$db_p_xminstitute[0]'/>
                                                                                </td><td><input class='textfield'  name='e_board[]' type='text' value='$db_p_xmboard[0]'/></td><td><input class='box5' name='e_gpa[]' type='text' value='$db_p_xmgpa[0]'/></td><td><input type='button' class='add2' /></td></tr>";
                                                                for($i=1;$i<$p_count;$i++)
                                                                {
                                                                    echo "<tr><td><input class='textfield'  name='e_ex_name[]' type='text' value='$db_p_xmname[$i]'/></td><td><input class='box5'  name='e_pass_year[]' type='text' value='$db_p_xmyear[$i]'/></td><td><input class='textfield'  name='e_institute[]' type='text' value='$db_p_xminstitute[$i]'/>
                                                                                </td><td><input class='textfield'  name='e_board[]' type='text' value='$db_p_xmboard[$i]'/></td><td><input class='box5' name='e_gpa[]' type='text' value='$db_p_xmgpa[$i]'/></td>";
                                                                   echo "<td><input type='button' class='del2' /></td><td><input type='button' class='add2' /></td></tr>";
                                                                }
                                            ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>         
                    <tr>
                        <td colspan="4" ><hr /></td>
                    </tr>
                    <tr>
                        <td colspan="2" >
                            <table width="100%">
                                <tr>	
                                    <td  colspan="2"   style =" font-size: 14px"><b>প্রোপ্রাইটারের নমিনির শিক্ষাগত যোগ্যতা</b></td>                                                
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
                        <td colspan="4" style="padding-top: 10px; padding-left: 250px;padding-bottom: 5px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit3" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" />
                        </td>                           
                    </tr>
                </table>
            </form>
        </div>

         <div>
            <h2><a name="05" id="05"></a></h2><br/>
            <form name="scanDoc_form" method="POST" enctype="multipart/form-data" onsubmit="">	
                <table  class="formstyle">     
                    <tr><th colspan="4" style="text-align: center;"><h1>প্রোপ্রাইটারের প্রয়োজনীয় তথ্য</h1><input type="hidden" name="proID" value="<?php echo $proprietorID;?>" /></th></tr>
                    </tr>                  
                    <tr>	
                        <td  style="width: 110px;" font-weight="bold" > এস.এস.সির সার্টিফিকেট</td>
                        <td>:  <img src="<?php echo $db_scan_ssc;?>" width="80px" height="80px"/><input type="hidden" name="scan[1]" value="<?php echo $ssc_name;?>"/> &nbsp;<input class="box5" type="file" id="scanDoc1" name="scanDoc1" style="font-size:10px;"/></td>
                        <td  font-weight="bold" > জাতীয় পরিচয়পত্র</td>
                        <td>: <img src="<?php echo $db_scan_NID;?>" width="80px" height="80px"/><input type="hidden" name="scan[2]" value="<?php echo $NID_name;?>"/> &nbsp;<input class="box5" type="file" id="scanDoc2" name="scanDoc2" style="font-size:10px;"/></td>
                    </tr>
                    <tr>	
                        <td  font-weight="bold"  style="width: 112px;">এইচ.এস.সির সার্টিফিকেট</td>
                        <td>: <img src="<?php echo $db_scan_hsc;?>" width="80px" height="80px"/><input type="hidden" name="scan[3]" value="<?php echo $hsc_name;?>"/> &nbsp;<input class="box5" type="file" id="scanDoc3" name="scanDoc3" style="font-size:10px;"/></td>
                        <td  font-weight="bold" >জন্ম সনদ</td>
                        <td>: <img src="<?php echo $db_scan_DOB;?>" width="80px" height="80px"/><input type="hidden" name="scan[4]" value="<?php echo $DOB_name;?>"/> &nbsp;<input class="box5" type="file" id="scanDoc4" name="scanDoc4" style="font-size:10px;"/></td>
                    </tr>
                    <tr>	
                        <td  font-weight="bold" >অনার্সের সার্টিফিকেট</td>
                        <td>: <img src="<?php echo $db_scan_hons;?>" width="80px" height="80px"/><input type="hidden" name="scan[5]" value="<?php echo $hons_name;?>"/> &nbsp;<input class="box5" type="file" id="scanDoc5" name="scanDoc5" style="font-size:10px;"/></td>
                        <td  font-weight="bold" >চারিত্রিক সনদ</td>
                        <td>: <img src="<?php echo $db_scan_CC;?>" width="80px" height="80px"/><input type="hidden" name="scan[6]" value="<?php echo $CC_name;?>"/> &nbsp;<input class="box5" type="file" id="scanDoc6" name="scanDoc6" style="font-size:10px;"/></td>
                    </tr>
                    <tr>	
                        <td  font-weight="bold" >মাস্টার্সের  সার্টিফিকেট</td>
                        <td>: <img src="<?php echo $db_scan_masters;?>" width="80px" height="80px"/><input type="hidden" name="scan[7]" value="<?php echo $masters_name;?>"/> &nbsp;<input class="box5" type="file" id="scanDoc7" name="scanDoc7" style="font-size:10px;"/></td>
                        <td  font-weight="bold" >অন্যান্য </td>
                        <td>: <img src="<?php echo $db_scan_other;?>" width="80px" height="80px"/><input type="hidden" name="scan[8]" value="<?php echo $other_name;?>"/> &nbsp;<input class="box5" type="file" id="scanDoc8" name="scanDoc8" style="font-size:10px;"/></td>
                    </tr>
                    <tr>                    
                        <td colspan="4" style="padding-top: 10px; padding-left: 250px;padding-bottom: 5px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit4" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" />
                        </td>                           
                    </tr>
                </table>
            </form>
        </div>
        </div> 
    </div>         
    <?php 
    include_once 'includes/footer.php'; 
    ?>
