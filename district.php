<?php
include 'includes/session.inc';
include_once 'includes/header.php';
?>
<?php
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
    $division_id = $_POST['division'];
    $district_name = $_POST['district_name'];
    $sql = "insert into district (district_name, Division_idDivision) values('$district_name','$division_id')";
    if (mysql_query($sql)) {
        $msg = "আপনি সফলভাবে ". $district_name . " নামে নতুন জেলাটি তৈরি করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
if (isset($_POST['submit']) && ($_GET['action'] == 'edit')){
    $district_id = $_GET['did'];
    $district_name = $_POST ['district_name'];
    $sql12 = "update district set district_name='$district_name' where idDistrict='$district_id'";
    if (mysql_query($sql12)) {
        $msg = "আপনি সফলভাবে " . $district_name . " নামে জেলা তথ্য পরিবর্তন করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
?>
<title>জেলা</title>
<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<script type="text/javascript">
    function isBlankDistrict_edit()
    {
        var x=document.forms["district"]["district_name_edit"].value;
        if (x== null || x== "")
        {
            alert("জেলার নাম পূরণ করুন");
            return false;
        }
    }
       
    function isBlankDistrict_new()
    {
        var y = document.forms["district"]["district_name_new"].value;
        if (y== null || y== "")
        {
            alert("জেলার  নাম পূরণ করুন");
            return false;
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
</script>

<?php
if ($_GET['action'] == 'edit') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 64%; float: left"><a href="area_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="district.php?action=new"> নতুন জেলা  </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">জেলার লিস্ট</a></div>
    </div>
    <div>
        <form name="district" action="" onsubmit ="return isBlankDistrict_edit()" method="post">
            <table class="formstyle" style =" width:78%">    
                <tr>
                    <th colspan="2">এডিট জেলা </th>
                </tr>                
                <?php
                showMessage($flag, $msg);
                ?>
                <tr>
                    <td>বিভাগ</td>
                    <td>: <select name="division_id" id="division_id" class="box2" onChange="getDistrict()" >
                            <option value="all">- বিভাগ -</option>
                            <?php
                            $district_id = $_GET['did'];
                            $result = mysql_query("SELECT *FROM district, division WHERE idDistrict ='$district_id' AND  Division_idDivision = idDivision");
                            $rows = mysql_fetch_array($result);
                            $selected_division_name = $rows['division_name'];
                            $selected_district_name = $rows['district_name'];

                            $division_sql = mysql_query("SELECT * FROM division ORDER BY division_name ASC");
                            while ($division_rows = mysql_fetch_array($division_sql)){
                                $db_division_id = $division_rows['idDivision'];
                                $db_division_name = $division_rows['division_name'];
                                if ($db_division_name == $selected_division_name) {
                                    echo "<option value='$db_division_id' selected=\"selected\">$db_division_name</option>";
                                } else {
                                    echo "<option value='$db_division_id' >$db_division_name</option>";
                                }
                            }
                            ?>
                        </select>    
                    </td>                                      
                </tr>
                <tr>
                    <td>জেলা নাম</td>
                  
                    <td>:  <input  class ="textfield" type="text" id="district_name_edit" name="district_name" value="<?php echo $selected_district_name; ?>"/>
                            <?php
                                $district_res = mysql_query("SELECT * FROM district ORDER BY district_name ASC");
                                while ($district_rows = mysql_fetch_array($district_res)) {
                                    $db_district_id = $district_rows['idDistrict'];
                                    $db_district_name = $district_rows['district_name'];
                                }
                                ?>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"><input type="submit" class="btn" name="submit" value="সেভ">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
        </form>
    </div>
    <?php
} elseif ($_GET['action'] == 'new') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 64%; float: left"><a href="area_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="district.php?action=new"> নতুন জেলা   </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">জেলার লিস্ট</a></div>
    </div>
    <div>           
        <form name="district" action="" onsubmit="return isBlankDistrict_new()" method="post">	
            <table class="formstyle"  style=" width: 78%; ">          
                <tr><th style="text-align: center" colspan="2"><h1>নতুন জেলা </h1></th></tr>
                <tr><td colspan="2"></td></tr>
                <?php
                showMessage($flag, $msg);
                ?>
                <tr>
                    <td>বিভাগ</td>
                    <td>: <select class="box2" name="division" style="width: 150px;">
                            <?php
                            $result = mysql_query("SELECT * FROM division");
                            while ($row = mysql_fetch_array($result)) {
                                $division = $row['idDivision'];
                                $division_name = $row['division_name'];
                                echo "<option value='$division'>$division_name</option>";
                            }
                            ?>                               
                        </select>    
                    </td>                                      
                </tr>
                <tr>
                    <td>জেলা নাম</td>
                    <td>:   <input  class="box" type="text" name="district_name" id="district_name_new" /> </td>
                </tr>
                <tr>                    
                    <td colspan="2" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" />
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                </tr>
            </table>
        </form>
    </div>
    <?php
} else {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width:64%; float: left"><a href="area_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="district.php?action=new"> নতুন জেলা</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">জেলার  লিস্ট</a></div>
    </div>
    <div>
        <form method="POST" onsubmit="">	
            <table class="formstyle"  style=" width: 78%;" >      
                <tr>
                    <th colspan="4"> জেলা</th>
                </tr>
                <tr>
                    <td>
                <tr id = "table_row_odd"style="text-align: center" >
                    <td style="background-color: #89C2FA" >বিভাগ নাম </td>
                    <td style="background-color: #89C2FA" >জেলার নাম </td>
                    <td style="background-color: #89C2FA " width="25%">অপশন</td>
                </tr>
                <?php
                $result = mysql_query("SELECT *FROM division,district where idDivision=Division_idDivision");
                while ($row = mysql_fetch_array($result)) {
                    $division_name = $row['division_name'];
                    $division_id = $row['Division_idDivision'];
                    $district_name = $row['district_name'];
                    $district_id = $row['idDistrict'];
                    echo "  <tr>
                        <td>$division_name</td>
                                    <td>$district_name</td>
                        <td style='text-align: center '><a href='district.php?action=edit&did=$district_id'>এডিট জেলা</a></td>  
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
