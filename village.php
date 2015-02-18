<?php
include 'includes/session.inc';
include_once 'includes/header.php';
$flag = 'false';

function showMessage($flag, $msg) {
    if (!empty($msg)) {
        if ($flag == 'true') {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:20px;">' . $msg . '</b></td></tr>';
        } else {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:20px;"><blink>' . $msg . '</blink></b></td></tr>';
        }
    }
}
if (isset($_POST['submit']) && ($_GET['action'] == 'new')) {
    $post_id = $_POST['post_id1'];
    $village_name = $_POST['village_name'];
    $sql = "insert into village (village_name, post_office_idPost_office) values('$village_name','$post_id')";
    if (mysql_query($sql)) {
        $msg = "আপনি সফলভাবে ". $village_name . " নামে নতুন গ্রাম/পাড়া/প্রোজেক্ট তৈরি করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
if (isset($_POST['submit']) && ($_GET['action'] == 'edit')) {

    $village_id = $_GET['vid'];
    $village_name = $_POST['village_name'];
    $sql3 = "update village set village_name='$village_name' where idvillage='$village_id'";
    if (mysql_query($sql3)) {
        $msg = "আপনি সফলভাবে " . $village_name . " নামে গ্রাম/পাড়া/প্রোজেক্ট তথ্য পরিবর্তন করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
?>
<title>গ্রাম/পাড়া/প্রোজেক্ট</title>
<script type="text/javascript" src="javascripts/division_district_thana.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<script type="text/javascript">
    function isBlankVillage_edit()
    {
        var x=document.forms["village"]["village_name"].value;
        if (x== null || x== "")
        {
            alert("গ্রাম/পাড়া/প্রোজেক্ট নাম পূরণ করুন");
            return false;
        }
    }
       
    function isBlankVillage_new()
    {
        var y=document.forms["village"]["village_name"].value;;
        if (y == null || y == "")
        {
            alert("গ্রাম/পাড়া/প্রোজেক্ট নাম পূরণ করুন");
            return false;
        }
    }     
</script>
<style type="text/css">
    @import "css/bush.css";
</style>
<?php
if ($_GET['action'] == 'edit') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 52%; float: left"><a href="area_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="village.php?action=new">নতুন গ্রাম/পাড়া/প্রোজেক্ট</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">গ্রাম/পাড়া/প্রোজেক্ট লিস্ট</a></div>
    </div>
    <div>
        <form name="village" action="" onsubmit ="return isBlankVillage_edit()" method="post">
            <table class="formstyle" style =" width:78%">    
                <tr>
                    <th colspan="2">এডিট গ্রাম/পাড়া/প্রোজেক্ট</th>
                </tr>
                <?php
                showMessage($flag, $msg);
                ?>
                <tr>
                    <td>বিভাগ</td>
                    <td>: <?php
    $village_id = $_GET['vid'];
    $result = mysql_query("SELECT * FROM village, post_office, thana, district, division WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND Thana_idThana=idThana AND post_office_idPost_office=idPost_office AND idvillage ='$village_id'");
    $rows = mysql_fetch_array($result);
    $selected_division_name = $rows['division_name'];
    $selected_district_name = $rows['district_name'];
    $selected_thana_name = $rows['thana_name'];
    $selected_post_name = $rows['post_offc_name'];
    $selected_village_name = $rows['village_name'];
    $division_sql = mysql_query("SELECT * FROM " . $dbname . ".division ORDER BY division_name ASC");
    while ($division_rows = mysql_fetch_array($division_sql)) {
        $db_division_id = $division_rows['idDivision'];
        $db_division_name = $division_rows['division_name'];

        if ($db_division_name == $selected_division_name) {
            echo "$db_division_name";
        }
    }
    ?>
                    </td>                                      
                </tr>
                <tr>
                    <td>জেলা নাম</td>
                    <td>:
                        <?php
                        $village_id = $_GET['vid'];
                        $result = mysql_query("SELECT * FROM village, post_office, thana, district, division WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND Thana_idThana=idThana AND post_office_idPost_office=idPost_office AND idvillage ='$village_id'");
                        $rows = mysql_fetch_array($result);
                        $selected_division_name = $rows['division_name'];
                        $selected_district_name = $rows['district_name'];
                        $selected_thana_name = $rows['thana_name'];
                        $selected_post_name = $rows['post_offc_name'];
                        $selected_village_name = $rows['village_name'];
                        $district_res = mysql_query("SELECT * FROM " . $dbname . ".district ORDER BY district_name ASC");
                        while ($district_rows = mysql_fetch_array($district_res)) {
                            $db_district_id = $district_rows['idDistrict'];
                            $db_district_name = $district_rows['district_name'];
                            if ($db_district_name == $selected_district_name) {
                                echo "$db_district_name";
                            }
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>উপজেলা / থানা</td>
                    <td>:
                        <?php
                        $village_id = $_GET['vid'];
                        $result = mysql_query("SELECT * FROM village, post_office, thana, district, division WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND Thana_idThana=idThana AND post_office_idPost_office=idPost_office AND idvillage ='$village_id'");
                        $rows = mysql_fetch_array($result);
                        $selected_division_name = $rows['division_name'];
                        $selected_district_name = $rows['district_name'];
                        $selected_thana_name = $rows['thana_name'];
                        $selected_post_name = $rows['post_offc_name'];
                        $selected_village_name = $rows['village_name'];
                        $thana_res = mysql_query("SELECT * FROM " . $dbname . ".thana ORDER BY thana_name ASC");
                        while ($thana_rows = mysql_fetch_array($thana_res)) {
                            $db_thana_id = $thana_rows['idThana'];
                            $db_thana_name = $thana_rows['thana_name'];
                            if ($db_thana_name == $selected_thana_name) {
                                echo "$db_thana_name";
                            }
                        }
                        ?>
                    </td>  
                </tr>
                <tr>
                    <td>পোস্ট অফিস</td>
                    <td>:
                        <?php
                        $village_id = $_GET['vid'];
                        $result = mysql_query("SELECT * FROM village, post_office, thana, district, division WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND Thana_idThana=idThana AND post_office_idPost_office=idPost_office AND idvillage ='$village_id'");
                        $rows = mysql_fetch_array($result);
                        $selected_division_name = $rows['division_name'];
                        $selected_district_name = $rows['district_name'];
                        $selected_thana_name = $rows['thana_name'];
                        $selected_post_name = $rows['post_offc_name'];
                        $selected_village_name = $rows['village_name'];
                        $thana_res = mysql_query("SELECT * FROM " . $dbname . ".thana ORDER BY thana_name ASC");
                        while ($thana_rows = mysql_fetch_array($thana_res)) {
                            $db_thana_id = $thana_rows['idThana'];
                            $db_thana_name = $thana_rows['thana_name'];
                            if ($db_thana_name == $selected_thana_name) {
                                echo "$db_thana_name";
                            }
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>গ্রাম/পাড়া/প্রোজেক্ট</td>
                    <td>:  <input  class ="textfield" type="text" id="village_name" name="village_name" value="<?php echo $selected_village_name; ?>"/></td>
                </tr>
                <tr>                    
                    <td colspan="4" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" />
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                </tr>
            </table>
        </form>
    </div>
    <?php
} elseif ($_GET['action'] == 'new') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 52%; float: left"><a href="area_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="village.php?action=new">নতুন গ্রাম/পাড়া/প্রোজেক্ট</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">গ্রাম/পাড়া/প্রোজেক্ট লিস্ট</a></div>
    </div>
    <div>
        <form name="village" action="" onsubmit ="return isBlankVillage_new()" method="post">
            <table class="formstyle" style =" width:78%">    
                <tr>
                    <th colspan="4">নতুন গ্রাম/পাড়া/প্রোজেক্ট</th>
                </tr>
                <?php
                showMessage($flag, $msg);
                ?>
                <tr>
                    <td >বিভাগ</td>
                    <td>:  <select class="box2" type="text" id="division_id_1" name="division_id_1" onChange="getDistrict1()" />
                <option value=1>-বিভাগ-</option>
                <?php
                $division_sql = mysql_query("SELECT * FROM " . $dbname . ".division ORDER BY division_name ASC");
                while ($division_rows = mysql_fetch_array($division_sql)) {
                    $db_division_id = $division_rows['idDivision'];
                    $db_division_name = $division_rows['division_name'];
                    echo'<option style="width: 96%" value=' . $db_division_id . '>' . $db_division_name . '</option>';
                }
                ?>
                </select></td>                                      
                </tr>
                <tr>
                    <td >জেলা</td>
                    <td>: <span id="did"></span></td>
                </tr>  
                <tr>
                    <td>থানা</td>
                    <td>: <span id="tidd"></span></td>   
                </tr> 
                <tr>
                    <td>পোস্ট অফিস</td>
                        <td>: <span id="pidd"></span></td> 
                </tr>
                <tr>
                    <td>গ্রাম/পাড়া/প্রোজেক্ট</td>
                    <td>:<input  class ="textfield" type="text" id="village_name" name="village_name" /></td>
                </tr>
                <tr>                    
                    <td colspan="4" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" />
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                </tr>
            </table>
        </form>
    </div>
    <?php
} else {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 52%; float: left"><a href="area_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="village.php?action=new">নতুন গ্রাম/পাড়া/প্রোজেক্ট</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">গ্রাম/পাড়া/প্রোজেক্ট লিস্ট</a></div>
    </div>
    <div>
        <form method="POST" onsubmit="">	
            <table class="formstyle"  style=" width: 78%; ">      
                <tr>
                    <th colspan="6">গ্রাম/পাড়া/প্রোজেক্ট</th>
                </tr>
                <tr>
                    <td>                
                <tr id = "table_row_odd">
                    <td style="background-color: #89C2FA" >বিভাগ নাম </td>
                    <td style="background-color: #89C2FA" >জেলার নাম </td>
                    <td style="background-color: #89C2FA">থানার  নাম </td>
                    <td style="background-color: #89C2FA">পোস্ট অফিসের নাম </td>
                    <td style="background-color: #89C2FA">গ্রাম/পাড়া/প্রোজেক্ট</td>
                    <td style="background-color: #89C2FA">অপশন</td>
                </tr>
                <?php
                $result = mysql_query("SELECT * FROM division,district,thana,post_office,village where idDivision=Division_idDivision and idDistrict=District_idDistrict AND idThana=Thana_idThana AND idPost_office=post_office_idPost_office");
                while ($row = mysql_fetch_array($result)) {
                    $division_name = $row['division_name'];
                    $district_name = $row['district_name'];
                    $thana_name = $row['thana_name'];
                    $division_id = $row['Division_idDivision'];
                    $district_id = $row['idDistrict'];
                    $thana_id = $row['idThana'];
                    $post_offc_name = $row['post_offc_name'];
                    $Post_office_id = $row['idPost_office'];
                    $village_name = $row['village_name'];
                    $village_id = $row['idvillage'];
                    echo "  <tr>
                        <td>$division_name</td>
                                    <td>$district_name</td>
                                          <td>$thana_name</td>
                                          <td>$post_offc_name</td>
                                          <td>$village_name</td>
                        <td style='text-align: center ' > <a href='village.php?action=edit&vid=$village_id'>এডিট</a></td></tr>";
                }
                ?>
            </table>
        </form>
    </div>
    <?php
}
include_once 'includes/footer.php';
?>