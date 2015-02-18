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
    $thana_id = $_POST['thana_id1'];
    $post_offc_name = $_POST['post_offc_name'];
    $sql = "insert into post_office (post_offc_name, Thana_idThana) values('$post_offc_name','$thana_id')";
    if (mysql_query($sql)) {
        $msg = "আপনি সফলভাবে ". $post_offc_name . " নামে নতুন পোস্ট অফিসটি তৈরি করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
if (isset($_POST['submit']) && ($_GET['action'] == 'edit')) {
    $post_id = $_GET['pid'];
    $post_offc_name = $_POST['post_offc_name'];
    $sql3 = "update post_office set post_offc_name='$post_offc_name' where idPost_office='$post_id'";
    if (mysql_query($sql3)) {
        $msg = "আপনি সফলভাবে " . $post_offc_name . " নামে পোস্ট অফিস তথ্য পরিবর্তন করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
?>
<title>পোস্ট অফিস</title>
<script type="text/javascript">
    function isBlankPost_edit()
    {
        var x=document.forms["post_office"]["post_offc_name"].value;
        if (x== null || x== "")
        {
            alert("পোস্ট অফিসের নাম পূরণ করুন");
            return false;
        }
    }
       
    function isBlankPost_new()
    {
        var y=document.forms["post_office"]["post_offc_name"].value;;
        if (y == null || y == "")
        {
            alert("পোস্ট অফিসের নাম পূরণ করুন");
            return false;
        }
    }
       
</script>
<script type="text/javascript" src="javascripts/division_district_thana.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>

<style type="text/css">
    @import "css/bush.css";
</style>
<?php
if ($_GET['action'] == 'edit') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 54%; float: left"><a href="area_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="post_office.php?action=new"> নতুন পোস্ট অফিস</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">পোস্ট অফিসের লিস্ট</a></div>
    </div>
    <div>
        <form name="post_office" action="" onsubmit ="return isBlankPost_edit()" method="post">
            <table class="formstyle" style =" width:78%">    
                <tr>
                    <th colspan="2">এডিট পোস্ট অফিস</th>
                </tr>
                <?php
                showMessage($flag, $msg);
                ?>
                <tr>
                    <td>বিভাগ</td>
                    <td>: <?php
                $post_id = $_GET['pid'];
                $result = mysql_query("SELECT * FROM post_office, thana, district, division WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND Thana_idThana=idThana AND idPost_office='$post_id'");
                $rows = mysql_fetch_array($result);
                $selected_division_name = $rows['division_name'];
                $selected_district_name = $rows['district_name'];
                $selected_thana_name = $rows['thana_name'];
                $selected_post_name = $rows['post_offc_name'];
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
                        $post_id = $_GET['pid'];
                        $result = mysql_query("SELECT * FROM post_office, thana, district, division WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND Thana_idThana=idThana AND idPost_office='$post_id'");
                        $rows = mysql_fetch_array($result);
                        $selected_division_name = $rows['division_name'];
                        $selected_district_name = $rows['district_name'];
                        $selected_thana_name = $rows['thana_name'];
                        $selected_post_name = $rows['post_offc_name'];
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
                        $post_id = $_GET['pid'];
                        $result = mysql_query("SELECT * FROM post_office, thana, district, division WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND Thana_idThana=idThana AND idPost_office='$post_id'");
                        $rows = mysql_fetch_array($result);
                        $selected_division_name = $rows['division_name'];
                        $selected_district_name = $rows['district_name'];
                        $selected_thana_name = $rows['thana_name'];
                        $selected_post_name = $rows['post_offc_name'];
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
                    <td>:  <input  class ="textfield" type="text" id="post_offc_name" name="post_offc_name" value="<?php echo $selected_post_name; ?>"/></td>
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
        <div style="padding-left: 110px; width: 54%; float: left"><a href="area_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="post_office.php?action=new"> নতুন পোস্ট অফিস</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">পোস্ট অফিসের লিস্ট</a></div>
    </div>
    <div>
        <form name="post_office" action="" onsubmit ="return isBlankPost_new()" method="post">
            <table class="formstyle" style =" width:78%">    
                <tr>
                    <th colspan="4">নতুন পোস্ট অফিস</th>
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
                    <td>:<input  class ="textfield" type="text" id="post_offc_name" name="post_offc_name" /></td>
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
        <div style="padding-left: 110px; width: 54%; float: left"><a href="area_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="post_office.php?action=new"> নতুন পোস্ট অফিস </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">পোস্ট অফিসের  লিস্ট</a></div>
    </div>
    <div>
        <form method="POST" onsubmit="">	
            <table class="formstyle"  style=" width: 78%; ">      
                <tr>
                    <th colspan="5"> পোস্ট অফিস</th>
                </tr>
                <tr>
                    <td>                
                <tr id = "table_row_odd">
                    <td style="background-color: #89C2FA" >বিভাগ নাম </td>
                    <td style="background-color: #89C2FA" >জেলার নাম </td>
                    <td style="background-color: #89C2FA">থানার  নাম </td>
                    <td style="background-color: #89C2FA">পোস্ট অফিসের নাম </td>
                    <td style="background-color: #89C2FA " width="25%">অপশন</td>
                </tr>
                <?php
                $result = mysql_query("SELECT * FROM division,district,thana,post_office where idDivision=Division_idDivision and idDistrict=District_idDistrict AND idThana=Thana_idThana");
                while ($row = mysql_fetch_array($result)) {
                    $division_name = $row['division_name'];
                    $district_name = $row['district_name'];
                    $thana_name = $row['thana_name'];
                    $division_id = $row['Division_idDivision'];
                    $district_id = $row['idDistrict'];
                    $thana_id = $row['idThana'];
                    $post_offc_name = $row['post_offc_name'];
                    $Post_office_id = $row['idPost_office'];
                    echo "  <tr>
                        <td>$division_name</td>
                                    <td>$district_name</td>
                                          <td>$thana_name</td>
                                          <td>$post_offc_name</td>
                        <td style='text-align: center ' > <a href='post_office.php?action=edit&pid=$Post_office_id'> এডিট পোস্ট অফিস </a></td>  
                  
                    </tr>";
                }
                ?>
            </table>
        </form>
    </div>
    <?php
}
include_once 'includes/footer.php';
?>