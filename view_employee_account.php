<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/areaSearch2.php';
$userID = $_SESSION['userIDUser'];

function show($value) // check if value will be shown or not *************
{
    if($value!="")
    { $string =  "'".$value."'readonly"; }
    else 
     { $string =  "'".$value."'"; }
    echo $string;
}
// ************************** update query ***********************************
if (isset($_POST['submit1'])) {
    $employeeID = $_POST['employeeID'];
    $employee_fatherName = $_POST['employee_fatherName'];
    $employee_motherName = $_POST['employee_motherName'];
    $employee_spouseName = $_POST['employee_spouseName'];
    $employee_occupation = $_POST['employee_occupation'];
    $employee_religion = $_POST['employee_religion'];
    $employee_natonality = $_POST['employee_natonality'];
    $employee_national_ID = $_POST['employee_national_ID'];
    $employee_passport = $_POST['employee_passport'];
    $employee_birth_certificate_No = $_POST['employee_birth_certificate_No'];
    $dob = $_POST['dob'];
    // picture, sign, finger print *****************************************************
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["image"]["name"]));
    $image_name = $_FILES["image"]["name"];
    if($image_name=="")
        {
            $image_name= "emp-" .$employeeID."-" . $_POST['imagename'];
             $image_path = "pic/" . $image_name;
        }
        else
        {
            $image_name = "emp-" .$employeeID."-image.".$extension;
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

mysql_query("START TRANSACTION");
    $sql_update_employee = mysql_query("UPDATE employee_information SET employee_fatherName='$employee_fatherName', 
                                     employee_motherName='$employee_motherName', employee_spouseName='$employee_spouseName', 
                                     employee_occupation='$employee_occupation', employee_religion='$employee_religion', employee_natonality='$employee_natonality',
                                     employee_national_ID='$employee_national_ID', employee_passport='$employee_passport', employee_date_of_birth='$dob',
                                     employee_birth_certificate_No='$employee_birth_certificate_No' ,emplo_scanDoc_picture='$image_path'
                                     WHERE Employee_idEmployee=$employeeID") or exit(mysql_error());
      
    //proprietor's Current Address Infromation
    $e_Village_idVillage = $_POST['vilg_id'];
    $e_Post_idPost = $_POST['post_id'];
    $e_Thana_idThana = $_POST['thana_id'];
    $e_house = $_POST['e_house'];
    $e_house_no = $_POST['e_house_no'];
    $e_road = $_POST['e_road'];
    $e_post_code = $_POST['e_post_code'];
    //proprietor's Permanent Address information
     $ep_Village_idVillage = $_POST['vilg_id1'];
    $ep_Post_idPost = $_POST['post_id1'];
    $ep_Thana_idThana = $_POST['thana_id1'];
    $ep_house = $_POST['ep_house'];
    $ep_house_no = $_POST['ep_house_no'];
    $ep_road = $_POST['ep_road'];
    $ep_post_code = $_POST['ep_post_code'];   
   //address_type=Present
 if($e_Village_idVillage !="")
    {
        $sql_e_insert_current_address = mysql_query("INSERT INTO address 
                                    (address_type, house, house_no, road, address_whom, post_code,Thana_idThana, post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Present', '$e_house', '$e_house_no', '$e_road', 'emp', '$e_post_code','$e_Thana_idThana','$e_Post_idPost', '$e_Village_idVillage', '$employeeID')")or exit(mysql_error()." sorryyyyyy sroryrr") ;
    }
    //address_type=Permanent
  if($ep_Village_idVillage !="")
    {
        $sql_ep_insert_permanent_address = mysql_query("INSERT INTO address 
                                    (address_type, house, house_no, road, address_whom, post_code,Thana_idThana,  post_idpost, village_idvillage ,adrs_cepng_id)
                                     VALUES ('Permanent', '$ep_house', '$ep_house_no', '$ep_road', 'emp', '$ep_post_code','$ep_Thana_idThana', '$ep_Post_idPost', '$ep_Village_idVillage', '$employeeID')");
    }
    if ($sql_update_employee || $sql_e_insert_current_address || $sql_ep_insert_permanent_address) {
        mysql_query("COMMIT");
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        mysql_query("ROLLBACK");
        $msg = "ভুল হয়েছে";
    }
}
elseif (isset($_POST['submit2'])) {
    $employeeID = $_POST['employeeID'];
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
            $image_name= "nom-emp-" .$employeeID. "-" . $_POST['nomimage'];
             $image_path = "pic/" . $image_name;
        }
        else
        {
            $image_name = "nom-emp-" .$employeeID."-image.".$extension;
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
                                       '$nominee_age','$nominee_passport_ID','$image_path','emp','$employeeID')");
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
                                     VALUES ('Present', '$n_house', '$n_house_no', '$n_road', 'nmn', '$n_post_code', '$n_Thana_idThana', '$n_Post_idPost', '$n_Village_idVillage','$nominee_id')")or exit(mysql_error()."dkfjalskdjf");
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
    $employeeID = $_POST['employeeID'];
    //customer education
    $e_ex_name = $_POST['e_ex_name'];
    $e_pass_year = $_POST['e_pass_year'];
    $e_institute = $_POST['e_institute'];
    $e_board = $_POST['e_board'];
    $e_gpa = $_POST['e_gpa'];
    $a = count($e_ex_name);
    mysql_query("START TRANSACTION");
   if($e_ex_name[0] != "")
    {
        for ($i = 0; $i < $a; $i++) {
            $sql_insert_emp_edu = "INSERT INTO `education` ( `exam_name` ,`passing_year` ,`institute_name`,`board`,`gpa`,`education_type`,`cepn_id`) 
                                                    VALUES ('$e_ex_name[$i]', '$e_pass_year[$i]','$e_institute[$i]','$e_board[$i]','$e_gpa[$i]','emp','$employeeID');";
            $emp_edu = mysql_query($sql_insert_emp_edu) or exit('query failed: ' . mysql_error());
        }
    }
    //nominee education
    $result = mysql_query("SELECT * FROM nominee WHERE cep_type = 'emp' AND cep_nominee_id=$employeeID ");
    $nomrow = mysql_fetch_array($result);
    $nomineeID = $nomrow['idNominee'];
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
                                                VALUES ('$n_ex_name[$i]', '$n_pass_year[$i]','$n_institute[$i]','$n_board[$i]','$n_gpa[$i]','nmn','$nomineeID');";
            $nom_edu = mysql_query($sql_insert_nom_edu) or exit('query failed: ' . mysql_error());
        }
    }
    if (($emp_edu) || ($nom_edu)) {
        mysql_query("COMMIT");
        $msg = "তথ্য সংরক্ষিত হয়েছে";
    } else {
        mysql_query("ROLLBACK");
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
     $sql_emp_sel = mysql_query("SELECT * FROM employee_information, employee, cfs_user WHERE 
                                                        Employee_idEmployee= idEmployee AND cfs_user_idUser =idUser AND idUser= $userID") ;
     $employeerow = mysql_fetch_assoc($sql_emp_sel);
     $employeeID = $employeerow['idEmployee'];
     $db_empName = $employeerow['account_name'];
     $db_empAcc = $employeerow['account_number'];
     $db_empMail = $employeerow['email'];
     $db_empRipdMail = $employeerow['ripd_email'];
     $db_empMob = $employeerow['mobile'];
     $db_empFather = $employeerow['employee_fatherName'];
     $db_empMother = $employeerow['employee_motherName'];
     $db_empSpouse = $employeerow['employee_spouseName'];
     $db_empOccu = $employeerow['employee_occupation'];
     $db_empRel = $employeerow['employee_religion'];
     $db_empNation = $employeerow['employee_natonality'];
     $db_empNID = $employeerow['employee_national_ID'];
     $db_empPID = $employeerow['employee_passport'];
     $db_empDOB = $employeerow['employee_date_of_birth'];
     $db_empDOBID = $employeerow['employee_birth_certificate_No'];
     $db_empSig = $employeerow['emplo_scanDoc_signature'];
     $signname = end(explode("-", $db_empSig));
     $db_empPic = $employeerow['emplo_scanDoc_picture'];
     $picname = end(explode("-", $db_empPic));
     $db_empFP = $employeerow['scanDoc_finger_print'];
     $fingername = end(explode("-", $db_empFP));
     
     $sql_emp_adrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='emp' AND adrs_cepng_id=$employeeID AND address_type='Present'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $presentAddrow = mysql_fetch_assoc($sql_emp_adrs_sel);
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
          
     $sql_emp_Padrs_sel = mysql_query("SELECT * FROM address, division, district, thana, post_office, village WHERE address_whom='emp' AND adrs_cepng_id=$employeeID AND address_type='Permanent'
                                                                    AND village_idvillage=idvillage AND post_idpost=idPost_office AND idDivision = Division_idDivision AND idDistrict= District_idDistrict AND idThana=address.Thana_idThana");
     $permenentAddrow = mysql_fetch_assoc($sql_emp_Padrs_sel);
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

// *************************************** for nominee ****************************************************************************** 
     $sql_nomi_sel = mysql_query("SELECT * FROM nominee WHERE cep_type='emp' AND  cep_nominee_id= $employeeID ");
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
     
     // *************************************** for education ****************************************************************************** 
     $p_count =0;
     $sql_Pedu_sel = mysql_query("SELECT * FROM education WHERE education_type='emp' AND cepn_id=$employeeID");
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
     $sql_Nedu_sel = mysql_query("SELECT * FROM education,nominee WHERE cep_nominee_id=$employeeID AND cep_type='emp' 
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
       $sql_scandoc= mysql_query("SELECT * FROM ep_certificate_scandoc_extra WHERE ep_id=$employeeID AND emp_type='emp'");
        $scan_row = mysql_fetch_assoc($sql_scandoc);
        $db_scan_NID = $scan_row['emplo_scanDoc_national_id'];
        $db_scan_DOB = $scan_row['emplo_scanDoc_birth_certificate'];
        $db_scan_CC = $scan_row['emplo_scanDoc_chairman_certificate'];
        $db_scan_ssc = $scan_row['scanDoc_ssc'];
        $db_scan_hsc = $scan_row['scanDoc_hsc'];
        $db_scan_hons = $scan_row['scanDoc_hons'];
         $db_scan_masters = $scan_row['scanDoc_masters'];
        $db_scan_other = $scan_row['scanDoc_other'];
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
                <li class="current"><a href="#01">মূল তথ্য</a></li><li class="current"><a href="#02">পারিবারিক তথ্য</a></li><li class="current"><a href="#03">নমিনির তথ্য</a></li><li class="current"><a href="#04">শিক্ষাগত যোগ্যতা</a></li><li class="current"><a href="#05">প্রয়োজনীয় ডকুমেন্টস</a></li>
            </ul>
        </div>
        
         <div>
            <h2><a name="01" id="01"></a></h2><br/>
            <form method="POST" onsubmit="" enctype="multipart/form-data" action="" id="emp_form1" name="emp_form1">	
                <table  class="formstyle">     
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>কর্মচারীর মূল তথ্য</h1></th></tr>
                    <tr><td colspan="4" ></td>
                        <?php
                        if ($msg != "") {
                            echo '<tr> <td colspan="2" style="text-align: center; color: green; font-size: 15px"><b>' . $msg . '</b></td></tr>';
                        }
                        ?>
                    </tr>
                   <tr>
                        <td>কর্মচারীর নাম</td>
                        <td>:   <input class='box' style="width:220px;" type='text' id='name' readonly name='name' value="<?php echo $db_empName;?>"/>
                            <input type='hidden' name='cfsid' value="<?php echo $userID;?>"/></td>			
                    </tr>
                    <tr>
                        <td >একাউন্ট নাম্বার</td>
                        <td>:   <input class='box' style="width:220px;" type='text' id='acc_num' name='acc_num' readonly value="<?php echo $db_empAcc;?>"/></td>			
                    </tr>
                    <tr>
                        <td>অফিশিয়াল ই মেইল</td>
                        <td>:   <input class='box' style="width:220px;" type='text' id='ripdemail' name='ripdemail' readonly="" value="<?php echo $db_empRipdMail;?>" /></td>			
                    </tr>
                    <tr>
                        <td >ব্যাক্তিগত ই মেইল</td>
                       <td>:   <input class='box' style="width:220px;" type='text' id='email' name='email' onblur='check(this.value)' value="<?php echo $db_empMail;?>" /> <em>ইংরেজিতে লিখুন</em> <span id='error_msg' style='margin-left: 5px'></span></td>			
                    </tr>
                    <tr>
                        <td >মোবাইল</td>
                        <td>:   <input class='box' style="width:220px;" type='text' id='mobile' name='mobile' onkeypress=' return numbersonly(event)' value="<?php echo $db_empMob;?>" /></td>		
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
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>কর্মচারীর ব্যক্তিগত তথ্য</h1></th></tr>
                    <tr><td colspan="4" ></td></tr>
                   <tr>
                        <td >বাবার নাম </td>
                        <td>:  <input class="box" type="text" id="employee_fatherName" name="employee_fatherName" value=<?php show($db_empFather);?> />
                            <input type="hidden" name="employeeID" value="<?php echo $employeeID;?>" /></td>
                        <td>ছবি : </td>
                        <?php
                            if($picname == "") {
                        ?>
                        <td><img src="<?php echo $db_empPic;?>" width="80px" height="80px"/><input type="hidden" name="imagename" value="<?php echo $picname;?>"/> &nbsp;<input class="box" type="file" id="image" name="image" style="font-size:10px;" /></td>
                         <?php }
                            else { ?>
                        <td><img src="<?php echo $db_empPic;?>" width="80px" height="80px"/><input type="hidden" name="imagename" value="<?php echo $picname;?>"/></td>
                        <?php }?>
                    </tr>
                    <tr>
                        <td >মার নাম </td>
                        <td>:  <input class="box" type="text" id="employee_motherName" name="employee_motherName" value=<?php show($db_empMother);?>/></td>
                        <td >স্বাক্ষর: </td>
                        <td><img src="<?php echo $db_empSig;?>" width="80px" height="80px"/></td> 
                    </tr>
                    <tr>
                        <td >দম্পতির নাম  </td>
                        <td>:  <input class="box" type="text" id="employee_spouseName" name="employee_spouseName" value=<?php show($db_empSpouse);?> /> </td>	
                        <td >টিপসই: </td>
                        <td><img src="<?php echo $db_empFP;?>" width="80px" height="80px"/></td>		
                    </tr>
                    <tr>
                        <td >পেশা</td>
                        <td>:  <input class="box" type="text" id="employee_occupation" name="employee_occupation" value=<?php show($db_empOccu);?> /></td>                         
                    </tr>
                    <tr>
                        <td>ধর্ম </td>
                        <td>:  <input  class="box" type="text" id="employee_religion" name="employee_religion" value=<?php show($db_empRel);?>/></td>	                             
                    </tr>
                    <tr>
                        <td >জাতীয়তা</td>
                        <td>:  <input class="box" type="text" id="employee_natonality" name="employee_natonality" value=<?php show($db_empNation);?>/> </td>			
                    </tr>
                    <td>জন্মতারিখ</td>
                        <?php
                            if(($db_empDOB == "") || ($db_empDOB == "0000-00-00")  ) {
                        ?>
                        <td >: <input class="box" type="date" name="dob"  /></td>
                            <?php } else {?>
                        <td >: <input class="box" type="text" name="dob" value=<?php show($db_empDOB);?> /></td>
                            <?php }?>			
                    </tr>
                    <tr>
                    <td >জাতীয় পরিচয়পত্র নং</td>
                    <td>:  <input class="box" type="text" id="employee_national_ID" name="employee_national_ID" value=<?php show($db_empNID);?>/></td>			
                    </tr>
                    <tr>
                        <td >পাসপোর্ট আইডি নং</td>
                        <td>:  <input class="box" type="text" id="employee_passport" name="employee_passport" value=<?php show($db_empPID);?>/></td>			
                    </tr>
                    <tr>
                        <td >জন্ম সনদ নং</td>
                        <td>:  <input class="box" type="text" id="employee_birth_certificate_No" name="employee_birth_certificate_No" value=<?php show($db_empDOBID);?> /></td>			
                    </tr>
                    <tr>
                        <td colspan="4" ><hr /></td>
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
                                    <td >:   <input class="box" type="text" id="e_house" name="e_house" value="<?php echo $preHouse;?>"/></td>
                                </tr>
                                <tr>
                                     <td>বাড়ি নং</td>
                                    <td >:   <input class="box" type="text" id="e_house_no" name="e_house_no" value="<?php echo $preHouseNo;?>" /></td>
                                </tr>
                                <tr>
                                     <td >রোড নং</td>
                                    <td>:   <input class="box" type="text" id="e_road" name="e_road" value="<?php echo $preRode;?>"/> </td>
                                </tr>
                                <tr>
                                    <td >পোষ্ট কোড</td>
                                     <td>:   <input class="box" type="text" id="e_post_code" name="e_post_code" value="<?php echo $prePostCode;?>"/></td>
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
                                        <td >গ্রাম/পাড়া/প্রোজেক্ট</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $preVilname;?> /></td>
                                    </tr>
                    <?php }?>
                            </table>
                        </td>                            
                        <td colspan="2" >
                            <table>
                                 <tr>                       
                                    <td  >বাড়ির নাম / ফ্ল্যাট নং</td>
                                    <td >:   <input class="box" type="text" id="ep_house" name="ep_house" value="<?php echo $perHouse;?>"/></td>
                                </tr>
                                <tr>                      
                                    <td >বাড়ি নং</td>
                                    <td>:   <input class="box" type="text" id="ep_house_no" name="ep_house_no" value="<?php echo $perHouseNo;?>"/></td>
                                </tr>
                                <tr>                       
                                    <td >রোড নং</td>
                                    <td>:   <input class="box" type="text" id="ep_road" name="ep_road" value="<?php echo $perRode;?>" /></td>
                                </tr>
                                <tr>
                                    <td >পোষ্ট কোড</td>
                                    <td>:   <input class="box" type="text" id="ep_post_code" name="ep_post_code" value="<?php echo $perPostCode;?>"/></td>
                                </tr> 
                                <tr>
                                 <?php 
                                    if($perDivID == "") { ?>
                                    <td colspan="2"><?php getArea2($perDivID,$perDisID,$perThanaID,$perPostID,$perVilID); ?></td>
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
                                        <td >গ্রাম/পাড়া/প্রোজেক্ট</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $perVilname;?> /></td>
                                    </tr>
                            <?php }?>
                                </tr>
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
            <form method="POST" onsubmit="" enctype="multipart/form-data" action="" id="emp_form1" name="emp_form1">	
                <table  class="formstyle">     
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>কর্মচারীর নমিনির তথ্য</h1></th></tr>
                    <tr><td colspan="4" ></td>
                    </tr>
                    <tr>
                        <td >নমিনির নাম</td>
                        <td>:  <input class="box" type="text" id="nominee_name" name="nominee_name" value=<?php show($db_nomName);?> /><input type="hidden" name="nomineeID" value="<?php echo $db_nomID?>"/></td>	
                        <td>পাসপোর্ট ছবি </td>
                        <?php
                            if($nompicName == "") { ?>
                        <td >:  <img src="<?php echo $db_nomPic;?>" width="80px" height="80px"/><input type="hidden" name="nomimage" value="<?php echo $nompicName;?>"/> &nbsp;<input class="box" type="file" id="nominee_picture" name="nominee_picture" style="font-size:10px;"/></td>
                        <?php }
                            else { ?>
                        <td >:  <img src="<?php echo $db_nomPic;?>" width="80px" height="80px"/><input type="hidden" name="nomimage" value="<?php echo $nompicName;?>"/> </td>
                        <?php }?>   
                    </tr>     
                    <tr>
                        <td >বয়স</td>
                        <td>:  <input class="box" type="text" id="nominee_age" name="nominee_age" value=<?php show($db_nomAge);?> />
                        <input type='hidden' name='employeeID' value="<?php echo $employeeID;?>" /></td>
                    </tr>     
                    <tr>
                        <td >সম্পর্ক </td>
                        <td>:  <input class="box" type="text" id="nominee_relation" name="nominee_relation" value=<?php show($db_nomRel);?> /> </td>			
                    </tr>
                    <tr>
                        <td >মোবাইল নং</td>
                        <td>:  <input class="box" type="text" id="nominee_mobile" name="nominee_mobile" value=<?php show($db_nomMobl);?>/></td>			
                    </tr>
                    <tr>
                        <td >ইমেইল</td>
                        <td>:  <input class="box" type="text" id="nominee_email" name="nominee_email" value=<?php show($db_nomEmail);?> /></td>			
                    </tr>
                    <tr>
                        <td >জাতীয় পরিচয়পত্র নং</td>
                        <td>:  <input class="box" type="text" id="nominee_national_ID" name="nominee_national_ID" value=<?php show($db_nomNID);?> /></td>			
                    </tr>
                    <tr>
                        <td >পাসপোর্ট আইডি নং</td>
                        <td>:  <input class="box" type="text" id="nominee_passport_ID" name="nominee_passport_ID" value=<?php show($db_nomPID);?> /></td>			
                    </tr> 
                    <tr>
                        <td colspan="4" ><hr /></td>
                    </tr>
                    <tr>	
                        <td  colspan="2" style =" font-size: 14px"><b>বর্তমান ঠিকানা </b></td>                            
                        <td colspan="2" style =" font-size: 14px"><b> স্থায়ী ঠিকানা   </b></td>
                    </tr>
                    <tr>	
                        <td  colspan="2" >
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
                                        <td >গ্রাম/পাড়া/প্রোজেক্ট</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $nompreVilname;?> /></td>
                                    </tr>
                                <?php }?>
                             </table>
                        </td>                            
                        <td colspan="2" >
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
                                        <td >গ্রাম/পাড়া/প্রোজেক্ট</td>
                                        <td>: <input class="box" type="text" readonly value=<?php echo $nomperVilname;?> /></td>
                                    </tr>
                                <?php }?>
                            </table>
                        </td>
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
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>কর্মচারীর প্রয়োজনীয় তথ্য</h1></th></tr>
                    <tr><td colspan="4" ></td>
                    </tr>   
                    <tr>
                        <td colspan="2" > 
                    </tr>
                    <tr>
                        <td colspan="2" >
                            <table width="100%">
                                <tr>	
                                    <td  colspan="2"   style =" font-size: 14px"><b>কর্মচারীর শিক্ষাগত যোগ্যতা</b></td>                                                
                                </tr>
                                <tr>                      
                                    <td><input type='hidden' name='employeeID' value="<?php echo $employeeID;?>" />
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
                                                <td><input class="textfield"  name="e_ex_name[]" type="text" /></td>
                                                <td><input class="box5"  name="e_pass_year[]" type="text" /></td>
                                                <td><input class="textfield" name="e_institute[]" type="text" /></td>
                                                <td><input class="textfield"  name="e_board[]" type="text" /></td>
                                                <td style="padding-right: 45px;"><input class="box5"  name="e_gpa[]" type="text" /></td>                                             
                                                <td  ><input type="button" class="add2" /></td>
                                            </tr>
                                             <?php } else { 
                                                 for($i=0;$i<$p_count;$i++)
                                                                {
                                                                    echo "<tr><td><input class='textfield' readonly  type='text' value='$db_p_xmname[$i]'/></td><td><input class='box5' readonly type='text' value='$db_p_xmyear[$i]'/></td><td><input class='textfield' readonly type='text' value='$db_p_xminstitute[$i]'/>
                                                                                </td><td><input class='textfield' readonly  type='text' value='$db_p_xmboard[$i]'/></td><td><input class='box5' readonly  type='text' value='$db_p_xmgpa[$i]'/></td>";
                                                                   echo "<td></td><td></td></tr>";
                                                                }
                                             } ?>
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
                                    <td  colspan="2"   style =" font-size: 14px"><b> নমিনির শিক্ষাগত যোগ্যতা</b></td>                                                
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
                                                                    echo "<tr><td><input class='textfield' readonly  type='text' value='$db_n_xmname[$i]'/></td><td><input class='box5' readonly  type='text' value='$db_n_xmyear[$i]'/></td><td><input class='textfield' readonly  type='text' value='$db_n_xminstitute[$i]'/>
                                                                                </td><td><input class='textfield' readonly  type='text' value='$db_n_xmboard[$i]'/></td><td><input class='box5' readonly type='text' value='$db_n_xmgpa[$i]'/></td>";
                                                                   echo "<td></td><td></td></tr>";
                                                                }
                                            } ?>
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
                    <tr><th colspan="4" style="text-align: center" ><h1>কর্মচারীর প্রয়োজনীয় তথ্য</h1></th></tr>          
                    <tr>	
                        <td width="184"  style="width: 110px;" font-weight="bold" > এস.এস.সির সার্টিফিকেট</td>
                        <td width="281">:  <img src="<?php echo $db_scan_ssc;?>" width="80px" height="80px"/></td>
                        <td width="198"  font-weight="bold" > জাতীয় পরিচয়পত্র</td>
                        <td width="213">: <img src="<?php echo $db_scan_NID;?>" width="80px" height="80px"/></td>
                    </tr>
                    <tr>	
                        <td  font-weight="bold"  style="width: 112px;">এইচ.এস.সির সার্টিফিকেট</td>
                        <td>: <img src="<?php echo $db_scan_hsc;?>" width="80px" height="80px"/></td>
                        <td  font-weight="bold" >জন্ম সনদ</td>
                        <td>: <img src="<?php echo $db_scan_DOB;?>" width="80px" height="80px"/></td>
                    </tr>
                    <tr>	
                        <td  font-weight="bold" >অনার্সের সার্টিফিকেট</td>
                        <td>: <img src="<?php echo $db_scan_hons;?>" width="80px" height="80px"/></td>
                        <td  font-weight="bold" >চারিত্রিক সনদ</td>
                        <td>: <img src="<?php echo $db_scan_CC;?>" width="80px" height="80px"/></td>
                    </tr>
                    <tr>	
                        <td  font-weight="bold" >মাস্টার্সের  সার্টিফিকেট</td>
                        <td>: <img src="<?php echo $db_scan_masters;?>" width="80px" height="80px"/></td>
                        <td  font-weight="bold" >অন্যান্য </td>
                        <td>: <img src="<?php echo $db_scan_other;?>" width="80px" height="80px"/></td>
                    </tr>
                </table>
            </form>
        </div>
        </div> 
    </div>         
    <?php 
    include_once 'includes/footer.php'; 
    ?>
