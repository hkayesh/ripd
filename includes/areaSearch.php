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
        <select name="district_id"  id="district_id" class="box2" onChange="getThana();<?php echo $getMethod_name; ?>">
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
        <select name='thana_id' id='thana_id' class="box2" onChange="<?php echo $getMethod_name; ?>">
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
<?php
    }
?>
