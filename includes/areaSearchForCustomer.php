<?php
function getArea($getMethod_name) 
    {
    //$dbname = $_SESSION['DatabaseName'];
    ?>            
    <select name="division_id" id="division_id" class="box2" onChange="getDistrict(); getThana();<?php echo $getMethod_name; ?>" >
        <option value="all" selected="selected">----বিভাগ----</option>
        <?php
        $division_sql = mysql_query("SELECT * FROM division ORDER BY division_name ASC");
        while ($division_rows = mysql_fetch_array($division_sql)) {
            $db_division_id = $division_rows['idDivision'];
            $db_division_name = $division_rows['division_name'];
            echo "<option value='$db_division_id'>$db_division_name</option>";
        }
        ?>
    </select> &nbsp;&nbsp;
    <span id="did">
        <select name="district_id"  id="district_id" class="box2" onChange="getThana();getVillage();<?php echo $getMethod_name; ?>">
            <option value="all">----জেলা----</option>
            <?php
            $district_sql = mysql_query("SELECT * FROM district ORDER BY district_name ASC");
            while ($district_rows = mysql_fetch_array($district_sql)) {
                $db_district_id = $district_rows['idDistrict'];
                $db_district_name = $district_rows['district_name'];
                echo "<option value='$db_district_id'>$db_district_name</option>";
            }
            ?>
        </select>
    </span> &nbsp;&nbsp;
    <span id="tid">
        <select name='thana_id' id='thana_id' class="box2" onChange="getPostOffice();getVillage();<?php echo $getMethod_name; ?>">
            <option value="all">----থানা----</option>
            <?php
            $thana_sql = mysql_query("SELECT * FROM thana ORDER BY thana_name ASC");
            while ($thana_rows = mysql_fetch_array($thana_sql)) {
                $db_thana_id = $thana_rows['idThana'];
                $db_thana_name = $thana_rows['thana_name'];
                echo "<option value='$db_thana_id'>$db_thana_name</option>";
            }
            ?>
        </select>
    </span> &nbsp;&nbsp; &nbsp;&nbsp;
    <span id="pid">
        <select name='post_id' id='post_id' class="box2" onchange="getVillage();<?php echo $getMethod_name; ?>" >
            <option value="all">-পোস্টঅফিস-</option>
            <?php
            $post_sql = mysql_query("SELECT * FROM post_office ORDER BY post_offc_name ASC");
            while ($post_rows = mysql_fetch_array($post_sql)) {
                $db_post_id = $post_rows['idPost_office'];
                $db_post_name = $post_rows['post_offc_name'];
                if($db_post_id==$p)
                {
                    echo "<option value='$db_post_id' selected>$db_post_name</option>";
                }
                else {echo "<option value='$db_post_id'>$db_post_name</option>";}
            }
            ?>
        </select>
    </span> &nbsp;&nbsp; &nbsp;&nbsp;
    <span id="vid">
         <select name='vilg_id' id='vilg_id' class="box2" onchange="<?php echo $getMethod_name; ?>" >
            <option value="all">-গ্রাম/পাড়া/প্রোজেক্ট-</option>
            <?php
            $vilg_sql = mysql_query("SELECT * FROM village ORDER BY village_name ASC");
            while ($vilg_rows = mysql_fetch_array($vilg_sql)) {
                $db_vilg_id = $vilg_rows['idvillage'];
                $db_vilg_name = $vilg_rows['village_name'];
                if($db_vilg_id==$v)
                {
                    echo "<option value='$db_vilg_id' selected>$db_vilg_name</option>";
                }
                else {echo "<option value='$db_vilg_id'>$db_vilg_name</option>";}
            }
            ?>
        </select>
    </span> &nbsp;&nbsp; &nbsp;&nbsp;
<?php
    }
?>
