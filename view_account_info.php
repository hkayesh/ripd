<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include_once 'includes/ConnectDB.inc';
include_once 'includes/header.php';
?>
<title>ভিউ একাউন্ট</title>
<style type="text/css">@import "css/bush.css";</style>
<script src="javascripts/jquery.min.js"></script>
<script src="javascripts/jquery.editable.js"></script>
<script type="text/javascript">
    $(function(){
        // editbale in div#group2
        // these samples are with 2 way connection for updating
        $('#iftee').editables( 
        { 
            beforeEdit: function(field){
                field.val(this.text());
            },
            beforeFreeze: function(display){ 
                display.text(this.val());
            }
        } );
    });
</script>
<div class="column6">
    <div class="main_text_box">	      
        <div>  
            <div style="padding-left: 110px;"><a href="account_management.php"><b>ফিরে যান</b></a></div>
              <div id='iftee'>
            <form method="POST" enctype="multipart/form-data" action="" style=" width: 100%; " id="cust_form" name="cust_form">	
                    <?php
                    $session_user_id = $_SESSION['userIDUser'];
                    $result0 = mysql_query("Select  * from $dbname.cfs_user where idUser=$session_user_id");
                    $row1 = mysql_fetch_array($result0);

                    $account_name = $row1['account_name'];
                    $mobile = $row1['mobile'];
                    $email = $row1['email'];
                    $result = mysql_query("Select  * from $dbname.customer_account where cfs_user_idUser =$session_user_id");
                    $row = mysql_fetch_array($result);

                    $cust_photo = $row['scanDoc_picture'];
                    //$cust_sign = $row['scanDoc_signature'];
                    $cust_finger = $row['scanDoc_finger_print'];
                    $cust_father_name = $row['cust_father_name'];
                    $cust_mother_name = $row['cust_mother_name'];
                    $cust_spouse_name = $row['cust_spouse_name'];
                    $cust_family_member = $row['cust_family_member'];
                    $cust_son_no = $row['cust_son_no'];
                    $cust_daughter_no = $row['cust_daughter_no'];
                    $cust_son_student_no = $row['cust_son_student_no'];
                    $cust_daughter_student_no = $row['cust_daughter_student_no'];
                    $scanDoc_picture = $row['scanDoc_picture'];
                    $cust_occupation = $row['cust_occupation'];
                    $scanDoc_signature = $row['scanDoc_signature'];
                    $cust_religion = $row['cust_religion'];
                    $cust_nationality = $row['cust_nationality'];
                    $cust_mobile = $row['cust_mobile'];
                    $cust_email = $row['cust_email'];
                    $cust_nationalID_no = $row['cust_nationalID_no'];
                    $cust_passportID_no = $row['cust_passportID_no'];
                    $birth_certificate_no = $row['birth_certificate_no'];
                    $cust_education = $row['cust_education'];
                    $house = $row['house'];
                    $village = $row['village'];
                    $road = $row['road'];
                    $post_code = $row['post_code'];
                    $thana_name = $row['thana_name'];
                    $district_name = $row['district_name'];
                    $division_name = $row['division_name'];
                    $cust_gurdian_name = $row['cust_gurdian_name'];
                    $cust_gurd_scanpic = $row['cust_gurd_scanpic'];
                    $cust_gurdian_relation = $row['cust_gurdian_relation'];
                    $cust_gurdian_mobile = $row['cust_gurdian_mobile'];
                    $cust_gurdian_email = $row['cust_gurdian_email'];
                    $cust_gurdian_education = $row['cust_gurdian_education'];
                    $cust_gurdian_nationalID_no = $row['cust_gurdian_nationalID_no'];
                    $cust_gurdian_passportID_no = $row['cust_gurdian_passportID_no'];
                    $cust_date_of_birth = $row['cust_date_of_birth'];
                    echo "<table  class='formstyle' style='float: left;'>";
                    echo "<tr>
                                <th colspan='7' style='text-align: center'><h2><font color=\"red\">$account_name </font>'র একাউন্ট</h2></th>
                            <div style='width: 80%; float: left;'>  
                               <tr>
                                    <td ><font color=\"#3933CC\"><b>ব্যক্তিগত তথ্য</b></font></td>		
                                </tr>
                                <tr>
                                    <td>একাউন্টধারীর নাম </td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_name'>$account_name</label><input class='textfield' id='p_name' name='p_name' value='$account_name'/></td>         
                                    <td  colspan='2'> </td>
                                    <td rowspan='5'><label><img src=$cust_photo width='140px' height='140px'/></label> </td>           
                                </tr>
                                <tr>
                                    <td >বাবার নাম </td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_cust_father_name'> $cust_father_name</label><input class='textfield' id='p_cust_father_name' name='p_cust_father_name' value='$cust_father_name'/></td>
                                </tr>
                                <tr>
                                    <td>মার নাম </td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_cust_mother_name'>  $cust_mother_name</label><input class='textfield' id='p_cust_mother_name' name='p_cust_mother_name' value='$cust_mother_name'/></td>         
                                </tr>
                                <tr>
                                    <td>স্বামী/স্ত্রীর নাম </td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_cust_spouse_name'> $cust_spouse_name</label><input class='textfield' id='p_cust_spouse_name' name='p_cust_spouse_name' value='$cust_spouse_name'/></td>             
                                </tr>
                                <tr>
                                    <td >পেশা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_cust_occupation'>$cust_occupation</label><input class='textfield' id='p_cust_occupation' name='p_cust_occupation' value='$cust_occupation'/></td>                             
                                </tr>
                                <tr>
                                    <td>ধর্ম </td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_cust_religion'> $cust_religion</label><input class='textfield' id='p_cust_religion' name='p_cust_religion' value='$cust_religion'/></td>
                                    <td colspan='2'></td>
                                    <td  rowspan='3'><label><img src=$cust_finger width='140px' height='70px'/> </label></td>                  
                                </tr>
                                <tr>
                                    <td >জাতীয়তা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_cust_nationality'> $cust_nationality</label><input class='textfield' id='p_cust_nationality' name='p_cust_nationality' value='$cust_nationality'/></td>			
                                </tr>
                                <tr>
                                    <td >মোবাইল নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_mobile'> $mobile</label><input class='textfield' id='p_mobile' name='p_mobile' value='$mobile'/></td>			
                                </tr>
                                <tr>
                                    <td >ইমেল</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_email'>$email</label><input class='textfield' id='p_email' name='p_email' value='$email'/></td>
                                    <td colspan='2'></td>				
                                </tr>
                                <tr>
                                    <td >জন্মতারিখ</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_cust_date_of_birth'> $cust_date_of_birth</label><input class='textfield' id='p_cust_date_of_birth' name='p_cust_date_of_birth' value='$cust_date_of_birth'/></td>		
                                </tr>
                                    <td >জাতীয় পরিচয়পত্র নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_cust_nationalID_no'>$cust_nationalID_no</label><input class='textfield' id='p_cust_nationalID_no' name='p_cust_nationalID_no' value='$cust_nationalID_no'/></td>			
                                </tr>
                                <tr>
                                    <td >পাসপোর্ট আইডি নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_cust_passportID_no'>$cust_passportID_no </label><input class='textfield' id='p_cust_passportID_no' name='p_cust_passportID_no' value='$cust_passportID_no'/></td>		
                                </tr>
                                <tr>
                                    <td >জন্ম সনদ নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_birth_certificate_no'>$birth_certificate_no </label><input class='textfield' id='p_birth_certificate_no' name='p_birth_certificate_no' value='$birth_certificate_no'/></td>			
                                </tr>";

                    $result3 = mysql_query("SELECT * FROM $dbname.education WHERE cepn_id='1' and education_type='cust' ");
                    echo "<tr>
                                    <td ><font color=\"#3933CC\"><b>শিক্ষাগত যোগ্যতা</b></font></td>		
                                </tr>
                                <tr>
                                    <td>পরীক্ষার নাম / ডিগ্রী </td>
                                    <td>পশের সাল</td>
                                    <td>প্রতিষ্ঠানের নাম </td>
                                    <td>বোর্ড / বিশ্ববিদ্যালয়</td>
                                    <td>জি.পি.এ / বিভাগ </td>
                                </tr>";
                    while ($row = mysql_fetch_array($result3)) {
                        $exam_name = $row['exam_name'];
                        $gpa = $row['gpa'];
                        $board = $row['board'];
                        $passing_year = $row['passing_year'];
                        $institute_name = $row['institute_name'];

                        echo "<tr>
                                    <td><label data-type='editable' data-for='#p_exam_name'>$exam_name </label><input class='textfield' id='p_exam_name' name='p_exam_name' value='$exam_name'/></td>
                                    <td><label data-type='editable' data-for='#p_passing_year'>$passing_year</label><input class='textfield' id='p_passing_year' name='p_passing_year' value='$passing_year'/></td>
                                    <td><label data-type='editable' data-for='#p_institute_name'>$institute_name</label><input class='textfield' id='p_institute_name' name='p_institute_name' value='$institute_name'/></td>
                                    <td><label data-type='editable' data-for='#p_board'>$board</label><input class='textfield' id='p_board' name='p_board' value='$board'/></td>
                                    <td><label data-type='editable' data-for='#p_gpa'>$gpa </label><input class='textfield' id='p_gpa' name='p_gpa' value='$gpa'/></td>
                                </tr>";
                    }
                    echo "<tr>
                                    <td ><font color=\"#3933CC\"><b>পরিবারিক তথ্য</b></font></td>		
                                </tr>                             
                                <tr>
                                    <td >পরিবারের সদস্য সংখ্যা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_cust_family_member'>$cust_family_member</label><input class='textfield' id='p_cust_family_member' name='p_cust_family_member' value='$cust_family_member'/></td>			
                                </tr>
                                <tr>
                                    <td >ছেলের সন্তানের সংখ্যা</td>
                                    <td colspan='2'>:<label data-type='editable' data-for='#p_cust_son_no'> $cust_son_no</label><input class='textfield' id='p_cust_son_no' name='p_cust_son_no' value='$cust_son_no'/></td>
                                    <td >মেয়ের সন্তানের সংখ্যা </td>
                                    <td colspan='2'>:<label data-type='editable' data-for='#p_cust_daughter_no'> $cust_daughter_no</label><input class='textfield' id='p_cust_daughter_no' name='p_cust_daughter_no' value='$cust_daughter_no'/></td>			
                                </tr>
                                <tr>
                                    <td >ছেলে  ষ্টুডেন্ট</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_cust_son_student_no'> $cust_son_student_no</label><input class='textfield' id='p_cust_son_student_no' name='p_cust_son_student_no' value='$cust_son_student_no'/></td>
                                    <td >মেয়ে  ষ্টুডেন্ট</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_cust_daughter_student_no'> $cust_daughter_student_no</label><input class='textfield' id='p_cust_daughter_student_no' name='p_cust_daughter_student_no' value='$cust_daughter_student_no'/></td>		
                                </tr>";

                    $result5 = mysql_query("SELECT * FROM $dbname.children WHERE Customer_account_idCustomer_account='2' and type='M'");
                    while ($row = mysql_fetch_array($result5)) {
                        $children_age = $row['children_age'];
                        $children_class = $row['children_class'];

                        echo "<tr>
                                    <td >ছেলে সন্তানের বয়স</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_children_age'> $children_age বছর</label><input class='textfield' id='p_children_age' name='p_children_age' value='$children_age'/></td>
                                    <td >অধ্যয়ণরত শ্রেণী</td>	
                                    <td >: <label data-type='editable' data-for='#p_children_class'> $children_class</label><input class='textfield' id='p_children_class' name='p_children_class' value='$children_class'/></td>
                                </tr>";
                    }
                    $result6 = mysql_query("SELECT * FROM $dbname.children WHERE Customer_account_idCustomer_account='2' and type='F'");
                    while ($row = mysql_fetch_array($result6)) {
                        $children_age = $row['children_age'];
                        $children_class = $row['children_class'];

                        echo "<tr>
                                    <td >মেয়ে সন্তানের বয়স</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_p_children_age'> $children_age বছর</label><input class='textfield' id='p_p_children_age' name='p_p_children_age' value='$children_age'/></td>
                                    <td >অধ্যয়ণরত শ্রেণী</td>	
                                    <td >: <label data-type='editable' data-for='#p_p_children_class'>$children_class</label><input class='textfield' id='p_p_children_class' name='p_p_children_class' value='$children_class'/></td>	
                                </tr>";
                    }
                    $result7 = mysql_query("SELECT * FROM $dbname.address WHERE adrs_cepng_id='1' and address_whom='cust' and address_type='Present'");
                    $row = mysql_fetch_array($result7);
                    $address_type = $row['address_type'];
                    $house = $row['house'];
                    $house_no = $row['house_no'];
                    $road = $row['road'];
                    $post_code = $row['post_code'];
                    $address_whom = $row['address_whom'];
                    $thana_id1 = $row['Thana_idThana'];
                    $village_id = $row['village_idvillage'];
                    $post_office_id = $row['post_idpost'];
                    $result12 = mysql_query("SELECT * FROM $dbname.thana, $dbname.district, $dbname.division,$dbname.village,$dbname.post_office WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND idThana ='$thana_id1' AND idPost_office = '$post_office_id' AND idvillage= '$village_id'");
                    $rows = mysql_fetch_array($result12);

                    $selected_division_name = $rows['division_name'];
                    $selected_district_name = $rows['district_name'];
                    $selected_thana_name = $rows['thana_name'];
                    $selected_post_offc_name = $rows['post_offc_name'];
                    $selected_village_name = $rows['village_name'];
                    echo "<tr>
                                    <td ><font color=\"#3933CC\"><b>বর্তমান ঠিকানা</b></font></td>
                                    <td colspan='2'> </td>
                                </tr>
                                <tr>
                                    <td >বাড়ির নাম / ফ্ল্যাট নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_house'> $house</label><input class='textfield' id='p_house' name='p_house' value='$house'/></td>
                                    <td >বাড়ি নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_house_no'> $house_no</label><input class='textfield' id='p_house_no' name='p_house_no' value='$house_no'/></td>		
                                </tr>
                                <tr>
                                    <td >রোড নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_road'> $road</label><input class='textfield' id='p_road' name='p_road' value='$road'/></td>
                                    <td >পোষ্ট কোড</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_post_code'> $post_code</label><input class='textfield' id='p_post_code' name='p_post_code' value='$post_code'/></td>		
                                </tr>
                                <tr>
                                    <td >গ্রাম</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_selected_village_name'>$selected_village_name</label><input class='textfield' id='p_selected_village_name' name='p_selected_village_name' value='$selected_village_name'/></td>	
                                    <td >পোষ্ট অফিস </td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_selected_post_offc_name'>$selected_post_offc_name</label><input class='textfield' id='p_selected_post_offc_name' name='p_selected_post_offc_name' value='$selected_post_offc_name'/></td>	
                                </tr>
                                <tr>
                                    <td >উপজেলা / থানা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_selected_thana_name'>$selected_thana_name</label><input class='textfield' id='p_selected_thana_name' name='p_selected_thana_name' value='$selected_thana_name'/></td>
                                    <td >জেলা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_selected_district_name'> $selected_district_name</label><input class='textfield' id='p_selected_district_name' name='p_selected_district_name' value='$selected_district_name'/></td>	
                                </tr>
                                <tr>
                                    <td >বিভাগ</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_selected_division_name'>$selected_division_name</label><input class='textfield' id='p_selected_division_name' name='p_selected_division_name' value='$selected_division_name'/></td>	
                                </tr> ";

                    $result8 = mysql_query("SELECT * FROM $dbname.address WHERE  adrs_cepng_id='1' and address_whom='cust' and address_type='Permanent'");
                    $row = mysql_fetch_array($result8);
                    $address_type = $row['address_type'];
                    $house = $row['house'];
                    $house_no = $row['house_no'];
                    $village = $row['village'];
                    $post_office = $row['post_office'];
                    $road = $row['road'];
                    $address_whom = $row['address_whom'];
                    $post_code = $row['post_code'];
                    $thana_id1 = $row['Thana_idThana'];
                    $village_id = $row['village_idvillage'];
                    $post_office_id = $row['post_idpost'];
                    $result13 = mysql_query("SELECT * FROM $dbname.thana, $dbname.district, $dbname.division,$dbname.village,$dbname.post_office WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND idThana ='$thana_id1' AND idPost_office = '$post_office_id' AND idvillage= '$village_id'");
                    $rows = mysql_fetch_array($result13);

                    $selected_division_name = $rows['division_name'];
                    $selected_district_name = $rows['district_name'];
                    $selected_thana_name = $rows['thana_name'];
                    $selected_post_offc_name = $rows['post_offc_name'];
                    $selected_village_name = $rows['village_name'];

                    echo "<tr>
                                    <td ><font color=\"#3933CC\"><b>স্থায়ী ঠিকানা</b></font></td>
                                    <td colspan='2'> </td>
                                </tr>
                                <tr>
                                    <td >বাড়ির নাম / ফ্ল্যাট নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_p_house'>$house</label><input class='textfield' id='p_p_house' name='p_p_house' value='$house'/></td>
                                    <td >বাড়ি নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_p_house_no'> $house_no</label><input class='textfield' id='p_p_house_no' name='p_p_house_no' value='$house_no'/></td>	
                                </tr>
                                <tr>
                                    <td >রোড নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_p_road'> $road</label><input class='textfield' id='p_p_road' name='p_p_road' value='$road'/></td>
                                    <td >পোষ্ট কোড</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_p_post_code'> $post_code</label><input class='textfield' id='p_p_post_code' name='p_p_post_code' value='$post_code'/></td>	
                                </tr>
                                <tr>
                                    <td >গ্রাম</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_p_selected_village_name'> $selected_village_name</label><input class='textfield' id='p_p_selected_village_name' name='p_p_selected_village_name' value='$selected_village_name'/></td>
                                    <td >পোষ্ট অফিস </td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_p_selected_post_offc_name'> $selected_post_offc_name</label><input class='textfield' id='p_p_selected_post_offc_name' name='p_p_selected_post_offc_name' value='$selected_post_offc_name'/></td>
                                </tr>
                                <tr>
                                    <td >উপজেলা / থানা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_p_selected_thana_name'>$selected_thana_name</label><input class='textfield' id='p_p_selected_thana_name' name='p_p_selected_thana_name' value='$selected_thana_name'/></td>
                                    <td >জেলা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_p_selected_district_name'>$selected_district_name</label><input class='textfield' id='p_p_selected_district_name' name='p_p_selected_district_name' value='$selected_district_name'/></td>	
                                </tr>
                                <tr>
                                    <td >বিভাগ</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#p_p_selected_division_name'> $selected_division_name</label><input class='textfield' id='p_p_selected_division_name' name='p_p_selected_division_name' value='$selected_division_name'/></td>	
                                </tr> ";

                    echo "<tr>
                                    <td colspan='6' ><hr /></td>
                                </tr>
                                <tr>
                                    <td ><font color=\"#3933CC\"><b>অভিভাবকের তথ্য</b></font></td>		
                                </tr>                              
                                <tr>
                                    <td >অভিভাবকের নাম</td>
                                    <td>: <label data-type='editable' data-for='#p_cust_gurdian_name'>$cust_gurdian_name</label><input class='textfield' id='p_cust_gurdian_name' name='p_cust_gurdian_name' value='$cust_gurdian_name'/></td>		
                                    <td colspan='2'></td>
                                    <td  rowspan='5'><label><img src=$cust_gurd_scanpic width='140px' height='140px'/> </label></td>		
                                </tr>
                                <tr>
                                    <td >সম্পর্ক</td>
                                    <td>: <label data-type='editable' data-for='#p_cust_gurdian_relation'>$cust_gurdian_relation</label><input class='textfield' id='p_cust_gurdian_relation' name='p_cust_gurdian_relation' value='$cust_gurdian_relation'/></td>				
                                </tr>
                                <tr>
                                    <td >মোবাইল নং</td>
                                    <td>: <label data-type='editable' data-for='#p_cust_gurdian_mobile'>$cust_gurdian_mobile</label><input class='textfield' id='p_cust_gurdian_mobile' name='p_cust_gurdian_mobile' value='$cust_gurdian_mobile'/></td>			
                                </tr>
                                <tr>
                                    <td >ইমেইল</td>
                                    <td>: <label data-type='editable' data-for='#p_cust_gurdian_email'> $cust_gurdian_email </label><input class='textfield' id='p_cust_gurdian_email' name='p_cust_gurdian_email' value='$cust_gurdian_email'/></td>			
                                </tr>
                                <tr>
                                    <td >জাতীয় পরিচয়পত্র নং</td>
                                    <td>: <label data-type='editable' data-for='#p_cust_gurdian_nationalID_no'> $cust_gurdian_nationalID_no</label><input class='textfield' id='p_cust_gurdian_nationalID_no' name='p_cust_gurdian_nationalID_no' value='$cust_gurdian_nationalID_no'/></td>		
                                </tr>
                                <tr>
                                    <td >পাসপোর্ট আইডি নং</td>
                                    <td>: <label data-type='editable' data-for='#p_cust_gurdian_passportID_no'>$cust_gurdian_passportID_no</label><input class='textfield' id='p_cust_gurdian_passportID_no' name='p_cust_gurdian_passportID_no' value='$cust_gurdian_passportID_no'/></td>			
                                </tr>
                                <tr>
                                    <td >শিক্ষাগত যোগ্যতা</td>
                                    <td>: <label data-type='editable' data-for='#p_cust_gurdian_education'>$cust_gurdian_education </label><input class='textfield' id='p_cust_gurdian_education' name='p_cust_gurdian_education' value='$cust_gurdian_education'/></td>			
                                </tr>";
                    $result10 = mysql_query("SELECT * FROM $dbname.address WHERE  adrs_cepng_id='1' and address_whom='cust_prnt' and address_type='Present'");
                    $row = mysql_fetch_array($result10);
                    $address_type = $row['address_type'];
                    $house = $row['house'];
                    $house_no = $row['house_no'];
                    $village = $row['village'];
                    $post_office = $row['post_office'];
                    $road = $row['road'];
                    $address_whom = $row['address_whom'];
                    $post_code = $row['post_code'];
                    $thana_id1 = $row['Thana_idThana'];
                    $village_id = $row['village_idvillage'];
                    $post_office_id = $row['post_idpost'];
                    $result13 = mysql_query("SELECT * FROM $dbname.thana, $dbname.district, $dbname.division,$dbname.village,$dbname.post_office WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND idThana ='$thana_id1' AND idPost_office = '$post_office_id' AND idvillage= '$village_id'");
                    $rows = mysql_fetch_array($result13);

                    $selected_division_name = $rows['division_name'];
                    $selected_district_name = $rows['district_name'];
                    $selected_thana_name = $rows['thana_name'];
                    $selected_post_offc_name = $rows['post_offc_name'];
                    $selected_village_name = $rows['village_name'];
                   echo "<tr>
                                    <td ><font color=\"#3933CC\"><b>বর্তমান ঠিকানা</b></font></td>
                                    <td colspan='2'> </td>
                                </tr>
                                <tr>
                                    <td >বাড়ির নাম / ফ্ল্যাট নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_house'> $house</label><input class='textfield' id='g_house' name='g_house' value='$house'/></td>
                                    <td >বাড়ি নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_house_no'> $house_no</label><input class='textfield' id='g_house_no' name='g_house_no' value='$house_no'/></td>		
                                </tr>
                                <tr>
                                    <td >রোড নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_road'> $road</label><input class='textfield' id='g_road' name='g_road' value='$road'/></td>
                                    <td >পোষ্ট কোড</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_post_code'> $post_code</label><input class='textfield' id='g_post_code' name='g_post_code' value='$post_code'/></td>		
                                </tr>
                                <tr>
                                    <td >গ্রাম</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_selected_village_name'>$selected_village_name</label><input class='textfield' id='g_selected_village_name' name='g_selected_village_name' value='$selected_village_name'/></td>	
                                    <td >পোষ্ট অফিস </td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_selected_post_offc_name'>$selected_post_offc_name</label><input class='textfield' id='g_selected_post_offc_name' name='g_selected_post_offc_name' value='$selected_post_offc_name'/></td>	
                                </tr>
                                <tr>
                                    <td >উপজেলা / থানা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_selected_thana_name'>$selected_thana_name</label><input class='textfield' id='g_selected_thana_name' name='g_selected_thana_name' value='$selected_thana_name'/></td>
                                    <td >জেলা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_selected_district_name'> $selected_district_name</label><input class='textfield' id='g_selected_district_name' name='g_selected_district_name' value='$selected_district_name'/></td>	
                                </tr>
                                <tr>
                                    <td >বিভাগ</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_selected_division_name'>$selected_division_name</label><input class='textfield' id='g_selected_division_name' name='g_selected_division_name' value='$selected_division_name'/></td>	
                                </tr> ";
                    $result9 = mysql_query("SELECT * FROM $dbname.address WHERE  adrs_cepng_id='1' and address_whom='cust_prnt' and address_type='Permanent'");
                    $row = mysql_fetch_array($result9);
                    $address_type = $row['address_type'];
                    $house = $row['house'];
                    $house_no = $row['house_no'];
                    $village = $row['village'];
                    $post_office = $row['post_office'];
                    $road = $row['road'];
                    $address_whom = $row['address_whom'];
                    $post_code = $row['post_code'];
                    $thana_id1 = $row['Thana_idThana'];
                    $village_id = $row['village_idvillage'];
                    $post_office_id = $row['post_idpost'];
                    $result13 = mysql_query("SELECT * FROM $dbname.thana, $dbname.district, $dbname.division,$dbname.village,$dbname.post_office WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND idThana ='$thana_id1' AND idPost_office = '$post_office_id' AND idvillage= '$village_id'");
                    $rows = mysql_fetch_array($result13);

                    $selected_division_name = $rows['division_name'];
                    $selected_district_name = $rows['district_name'];
                    $selected_thana_name = $rows['thana_name'];
                    $selected_post_offc_name = $rows['post_offc_name'];
                    $selected_village_name = $rows['village_name'];
                    echo "<tr>
                                    <td ><font color=\"#3933CC\"><b>স্থায়ী ঠিকানা</b></font></td>
                                    <td colspan='2'> </td>
                                </tr>
                                <tr>
                                    <td >বাড়ির নাম / ফ্ল্যাট নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_p_house'>$house</label><input class='textfield' id='g_p_house' name='g_p_house' value='$house'/></td>
                                    <td >বাড়ি নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_p_house_no'> $house_no</label><input class='textfield' id='g_p_house_no' name='g_p_house_no' value='$house_no'/></td>	
                                </tr>
                                <tr>
                                    <td >রোড নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_p_road'> $road</label><input class='textfield' id='g_p_road' name='g_p_road' value='$road'/></td>
                                    <td >পোষ্ট কোড</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_p_post_code'> $post_code</label><input class='textfield' id='g_p_post_code' name='g_p_post_code' value='$post_code'/></td>	
                                </tr>
                                <tr>
                                    <td >গ্রাম</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_p_selected_village_name'> $selected_village_name</label><input class='textfield' id='g_p_selected_village_name' name='g_p_selected_village_name' value='$selected_village_name'/></td>
                                    <td >পোষ্ট অফিস </td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_p_selected_post_offc_name'> $selected_post_offc_name</label><input class='textfield' id='g_p_selected_post_offc_name' name='g_p_selected_post_offc_name' value='$selected_post_offc_name'/></td>
                                </tr>
                                <tr>
                                    <td >উপজেলা / থানা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_p_selected_thana_name'>$selected_thana_name</label><input class='textfield' id='g_p_selected_thana_name' name='g_p_selected_thana_name' value='$selected_thana_name'/></td>
                                    <td >জেলা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_p_selected_district_name'>$selected_district_name</label><input class='textfield' id='g_p_selected_district_name' name='g_p_selected_district_name' value='$selected_district_name'/></td>	
                                </tr>
                                <tr>
                                    <td >বিভাগ</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#g_p_selected_division_name'> $selected_division_name</label><input class='textfield' id='g_p_selected_division_name' name='g_p_selected_division_name' value='$selected_division_name'/></td>	
                                </tr> ";
                    $result_nominee = mysql_query("SELECT * FROM $dbname.nominee WHERE cep_nominee_id = '1'");
                    while ($row = mysql_fetch_array($result_nominee)) {
                        $nominee_name = $row['nominee_name'];
                        $nominee_relation = $row['nominee_relation'];
                        $nominee_mobile = $row['nominee_mobile'];
                        $nominee_email = $row['nominee_email'];
                        $nominee_educational_background = $row['nominee_educational_background'];
                        $nominee_national_ID = $row['nominee_national_ID'];
                        $nominee_passport_ID = $row['nominee_passport_ID'];
                        $nominee_age = $row['nominee_age'];
                        $nominee_picture = $row['nominee_picture'];
                        echo "<tr>
                                        <td colspan='6' ><hr /></td>
                                    </tr>
                                <tr>
                                    <td ><font color=\"#3933CC\"><b>নমিনির তথ্য</b></font></td>		
                                </tr>
                                    <tr>
                                        <td >নমিনির নাম</td>
                                        <td>: <label data-type='editable' data-for='#p_nominee_name'> $nominee_name</label><input class='textfield' id='p_nominee_name' name='p_nominee_name' value='$nominee_name'/></td>
                                    <td colspan='2'></td>
                                    <td  rowspan='5'><label><img src=$nominee_picture width='140px' height='140px'/></label> </td>	
                                    </tr>
                                    <tr>
                                        <td >বয়স</td>
                                        <td>: <label data-type='editable' data-for='#p_nominee_age'> $nominee_age</label><input class='textfield' id='p_nominee_age' name='p_nominee_age' value='$nominee_age'/></td>			
                                    </tr>
                                    <tr>
                                        <td >সম্পর্ক</td>
                                        <td>: <label data-type='editable' data-for='#p_nominee_relation'>$nominee_relation</label><input class='textfield' id='p_nominee_relation' name='p_nominee_relation' value='$nominee_relation'/></td>			
                                    </tr>
                                    <tr>
                                        <td >মোবাইল নং</td>
                                        <td>: <label data-type='editable' data-for='#p_nominee_mobile'> $nominee_mobile</label><input class='textfield' id='p_nominee_mobile' name='p_nominee_mobile' value='$nominee_mobile'/></td>			
                                    </tr>
                                    <tr>
                                        <td >ইমেইল</td>
                                        <td>: <label data-type='editable' data-for='#p_nominee_email'> $nominee_email</label><input class='textfield' id='p_nominee_email' name='p_nominee_email' value='$nominee_email'/></td>			
                                    </tr>
                                    <tr>
                                        <td >জাতীয় পরিচয়পত্র নং</td>
                                        <td>: <label data-type='editable' data-for='#p_nominee_national_ID'> $nominee_national_ID</label><input class='textfield' id='p_nominee_national_ID' name='p_nominee_national_ID' value='$nominee_national_ID'/></td>			
                                    </tr>
                                    <tr>
                                        <td >পাসপোর্ট আইডি নং</td>
                                        <td>: <label data-type='editable' data-for='#p_nominee_passport_ID'>$nominee_passport_ID</label><input class='textfield' id='p_nominee_passport_ID' name='p_nominee_passport_ID' value='$nominee_name'/></td>			
                                    </tr>";

                        $result4 = mysql_query("SELECT * FROM $dbname.education WHERE cepn_id='1' and education_type='nmn' ");
                        echo "<tr>
                                    <td ><font color=\"#3933CC\"><b>শিক্ষাগত যোগ্যতা</b></font></td>		
                                </tr>
                                <tr>
                                    <td>পরীক্ষার নাম / ডিগ্রী </td>
                                    <td>পশের সাল</td>
                                    <td>প্রতিষ্ঠানের নাম </td>
                                    <td>বোর্ড / বিশ্ববিদ্যালয়</td>
                                    <td>জি.পি.এ / বিভাগ </td>
                                </tr>";
                        while ($row = mysql_fetch_array($result4)) {
                            $exam_name = $row['exam_name'];
                            $gpa = $row['gpa'];
                            $board = $row['board'];
                            $passing_year = $row['passing_year'];
                            $institute_name = $row['institute_name'];

                            echo "<tr>
                                    <td><label>$exam_name</label> </td>
                                    <td><label>$passing_year</label></td>
                                    <td><label>$institute_name</label></td>
                                    <td><label>$board</label></td>
                                    <td><label>$gpa</label> </td>
                                </tr>";
                        }
                        $result13 = mysql_query("SELECT * FROM $dbname.address WHERE  adrs_cepng_id='1' and address_whom='nmn' and address_type='Present'");
                        $row = mysql_fetch_array($result13);
                        $address_type = $row['address_type'];
                        $house = $row['house'];
                        $house_no = $row['house_no'];
                        $village = $row['village'];
                        $post_office = $row['post_office'];
                        $road = $row['road'];
                        $address_whom = $row['address_whom'];
                        $post_code = $row['post_code'];
                        $post = $row['post'];
                        $thana_id1 = $row['Thana_idThana'];
                        $village_id = $row['village_idvillage'];
                        $post_office_id = $row['post_idpost'];
                        $result13 = mysql_query("SELECT * FROM $dbname.thana, $dbname.district, $dbname.division,$dbname.village,$dbname.post_office WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND idThana ='$thana_id1' AND idPost_office = '$post_office_id' AND idvillage= '$village_id'");
                        $rows = mysql_fetch_array($result13);

                        $selected_division_name = $rows['division_name'];
                        $selected_district_name = $rows['district_name'];
                        $selected_thana_name = $rows['thana_name'];
                        $selected_post_offc_name = $rows['post_offc_name'];
                        $selected_village_name = $rows['village_name'];
                        echo "<tr>
                                    <td ><font color=\"#3933CC\"><b>বর্তমান ঠিকানা</b></font></td>
                                    <td colspan='2'> </td>
                                </tr>
                                <tr>
                                    <td >বাড়ির নাম / ফ্ল্যাট নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_house'> $house</label><input class='textfield' id='n_house' name='n_house' value='$house'/></td>
                                    <td >বাড়ি নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_house_no'> $house_no</label><input class='textfield' id='n_house_no' name='n_house_no' value='$house_no'/></td>		
                                </tr>
                                <tr>
                                    <td >রোড নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_road'> $road</label><input class='textfield' id='n_road' name='n_road' value='$road'/></td>
                                    <td >পোষ্ট কোড</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_post_code'> $post_code</label><input class='textfield' id='n_post_code' name='n_post_code' value='$post_code'/></td>		
                                </tr>
                                <tr>
                                    <td >গ্রাম</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_selected_village_name'>$selected_village_name</label><input class='textfield' id='n_selected_village_name' name='n_selected_village_name' value='$selected_village_name'/></td>	
                                    <td >পোষ্ট অফিস </td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_selected_post_offc_name'>$selected_post_offc_name</label><input class='textfield' id='n_selected_post_offc_name' name='n_selected_post_offc_name' value='$selected_post_offc_name'/></td>	
                                </tr>
                                <tr>
                                    <td >উপজেলা / থানা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_selected_thana_name'>$selected_thana_name</label><input class='textfield' id='n_selected_thana_name' name='n_selected_thana_name' value='$selected_thana_name'/></td>
                                    <td >জেলা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_selected_district_name'> $selected_district_name</label><input class='textfield' id='n_selected_district_name' name='n_selected_district_name' value='$selected_district_name'/></td>	
                                </tr>
                                <tr>
                                    <td >বিভাগ</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_selected_division_name'>$selected_division_name</label><input class='textfield' id='n_selected_division_name' name='n_selected_division_name' value='$selected_division_name'/></td>	
                                </tr> ";
                        $result14 = mysql_query("SELECT * FROM $dbname.address WHERE  adrs_cepng_id='1' and address_whom='nmn' and address_type='Permanent'");
                        $row = mysql_fetch_array($result14);
                        $address_type = $row['address_type'];
                        $house = $row['house'];
                        $house_no = $row['house_no'];
                        $village = $row['village'];
                        $post_office = $row['post_office'];
                        $road = $row['road'];
                        $address_whom = $row['address_whom'];
                        $post_code = $row['post_code'];
                        $thana_id1 = $row['Thana_idThana'];
                        $village_id = $row['village_idvillage'];
                        $post_office_id = $row['post_idpost'];
                        $result13 = mysql_query("SELECT * FROM $dbname.thana, $dbname.district, $dbname.division,$dbname.village,$dbname.post_office WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND idThana ='$thana_id1' AND idPost_office = '$post_office_id' AND idvillage= '$village_id'");
                        $rows = mysql_fetch_array($result13);

                        $selected_division_name = $rows['division_name'];
                        $selected_district_name = $rows['district_name'];
                        $selected_thana_name = $rows['thana_name'];
                        $selected_post_offc_name = $rows['post_offc_name'];
                        $selected_village_name = $rows['village_name'];
                       echo "<tr>
                                    <td ><font color=\"#3933CC\"><b>স্থায়ী ঠিকানা</b></font></td>
                                    <td colspan='2'> </td>
                                </tr>
                                <tr>
                                    <td >বাড়ির নাম / ফ্ল্যাট নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_p_house'>$house</label><input class='textfield' id='n_p_house' name='n_p_house' value='$house'/></td>
                                    <td >বাড়ি নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_p_house_no'> $house_no</label><input class='textfield' id='n_p_house_no' name='n_p_house_no' value='$house_no'/></td>	
                                </tr>
                                <tr>
                                    <td >রোড নং</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_p_road'> $road</label><input class='textfield' id='n_p_road' name='n_p_road' value='$road'/></td>
                                    <td >পোষ্ট কোড</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_p_post_code'> $post_code</label><input class='textfield' id='n_p_post_code' name='n_p_post_code' value='$post_code'/></td>	
                                </tr>
                                <tr>
                                    <td >গ্রাম</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_p_selected_village_name'> $selected_village_name</label><input class='textfield' id='n_p_selected_village_name' name='n_p_selected_village_name' value='$selected_village_name'/></td>
                                    <td >পোষ্ট অফিস </td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_p_selected_post_offc_name'> $selected_post_offc_name</label><input class='textfield' id='n_p_selected_post_offc_name' name='n_p_selected_post_offc_name' value='$selected_post_offc_name'/></td>
                                </tr>
                                <tr>
                                    <td >উপজেলা / থানা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_p_selected_thana_name'>$selected_thana_name</label><input class='textfield' id='n_p_selected_thana_name' name='n_p_selected_thana_name' value='$selected_thana_name'/></td>
                                    <td >জেলা</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_p_selected_district_name'>$selected_district_name</label><input class='textfield' id='n_p_selected_district_name' name='n_p_selected_district_name' value='$selected_district_name'/></td>	
                                </tr>
                                <tr>
                                    <td >বিভাগ</td>
                                    <td colspan='2'>: <label data-type='editable' data-for='#n_p_selected_division_name'> $selected_division_name</label><input class='textfield' id='n_p_selected_division_name' name='n_p_selected_division_name' value='$selected_division_name'/></td>	
                                </tr> ";
                    }
                    ?>
                    </div>
                </table>
            </form>
            </div>
        </div>
    </div>
    <?php
    include_once 'includes/footer.php';
    ?>