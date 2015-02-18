<?php
include_once 'includes/session.inc';
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
    $district_id = $_POST['district_id1'];
    $thana_name = $_POST['thana_name_new'];
    $sql = "insert into thana (thana_name, District_idDistrict) values('$thana_name','$district_id')";
    if (mysql_query($sql)) {
        $msg = "আপনি সফলভাবে ". $thana_name . " নামে নতুন থানাটি তৈরি করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
if (isset($_POST['submit']) && ($_GET['action'] == 'edit')) {
    $thana_id = $_GET['tid'];
    $thana_name = $_POST['thana_name'];
    $sql3 = "update thana set thana_name='$thana_name' where idThana='$thana_id'";
    if (mysql_query($sql3)) {
        $msg = "আপনি সফলভাবে " . $thana_name . " নামে থানা তথ্য পরিবর্তন করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
?>
<title>থানা</title>
<script type="text/javascript" src="javascripts/division_district_thana.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<script type="text/javascript">
    function isBlankThana_edit()
    {
        var x=document.forms["thana"]["thana_name_edit"].value;
        if (x== null || x== "")
        {
            alert(" থানার নাম পূরণ করুন");
            return false;
        }
    }
       
    function isBlankThana_new()
    {
        var y=document.forms["thana"]["thana_name_new"].value;;
        if (y == null || y == "")
        {
            alert("থানার নাম পূরণ করুন");
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
        <div style="padding-left: 110px; width: 66%; float: left"><a href="area_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="thana.php?action=new"> নতুন থানা</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">থানার লিস্ট</a></div>
    </div>
    <div>
        <form name="thana" action="" onsubmit ="return isBlankThana_edit()" method="post">
            <table class="formstyle" style =" width:78%">    
                <tr>
                    <th colspan="2">এডিট থানা</th>
                </tr>
                <tr>             
                <?php
                showMessage($flag, $msg);
                ?>
                    <td>বিভাগ</td>
                    <td>: <?php
                $thana_id = $_GET['tid'];
                $result = mysql_query("SELECT * FROM thana, district, division WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND idThana ='$thana_id'");
                $rows = mysql_fetch_array($result);
                $selected_division_name = $rows['division_name'];
                $selected_district_name = $rows['district_name'];
                $selected_thana_name = $rows['thana_name'];
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
                        $thana_id = $_GET['tid'];
                        $result = mysql_query("SELECT * FROM thana, district, division WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision AND idThana ='$thana_id'");
                        $rows = mysql_fetch_array($result);
                        $selected_division_name = $rows['division_name'];
                        $selected_district_name = $rows['district_name'];
                        $selected_thana_name = $rows['thana_name'];
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
                    <td>থানা নাম</td>
                    <td>:  <input  class ="textfield" type="text" id="thana_name_edit" name="thana_name" value="<?php echo $selected_thana_name; ?>"/></td>
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
        <div style="padding-left: 110px; width: 66%; float: left"><a href="area_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="thana.php?action=new"> নতুন থানা</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">থানার লিস্ট</a></div>
    </div>
    <div>
        <form name="thana" action="" onsubmit ="return isBlankThana_new()" method="post">
            <table class="formstyle" style =" width:78%">    
                <tr>
                    <th colspan="4">নতুন থানা</th>
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
                    <td>থানা নাম</td>
                    <td>:<input  class ="textfield" type="text" id="thana_name_new" name="thana_name_new" /></td>
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
        <div style="padding-left: 110px; width: 66%; float: left"><a href="area_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="thana.php?action=new"> নতুন থানা </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">থানার  লিস্ট</a></div>
    </div>
    <div>
        <form method="POST" onsubmit="">	
            <table class="formstyle"  style=" width: 78%; ">      
                <tr>
                    <th colspan="4"> থানা</th>
                </tr>
                <tr>
                    <td>                
                <tr id = "table_row_odd">
                    <td style="background-color: #89C2FA" >বিভাগ নাম </td>
                    <td style="background-color: #89C2FA" >জেলার নাম </td>
                    <td style="background-color: #89C2FA">থানার  নাম </td>
                    <td style="background-color: #89C2FA " width="25%">অপশন</td>
                </tr>
                <?php
                $result = mysql_query("SELECT * FROM division,district,thana where idDivision=Division_idDivision and idDistrict=District_idDistrict");
                while ($row = mysql_fetch_array($result)) {
                    $division_name = $row['division_name'];
                    $district_name = $row['district_name'];
                    $division_id = $row['Division_idDivision'];
                    $district_id = $row['idDistrict'];
                    $thana_name = $row['thana_name'];
                    $thana_id = $row['idThana'];
                    echo "  <tr>
                        <td>$division_name</td>
                                    <td>$district_name</td>
                                          <td>$thana_name</td>
                        <td style='text-align: center ' > <a href='thana.php?action=edit&tid=$thana_id'> এডিট থানা </a></td>  
                  
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