<?php
error_reporting(0);
            include_once 'ConnectDB.inc';
            //get district name
            $dv_id = $_GET['did'];
            $gt_methodD = $_GET['mtD'];
            
            if($dv_id == "all")
                    {
                    $district_sql = mysql_query("SELECT * FROM district ORDER BY district_name ASC");
                    }
            else
                    {
                    $district_sql = mysql_query("SELECT * FROM  district WHERE Division_idDivision = '".$dv_id."' ORDER BY district_name ASC");
                    }
            echo "<select name='district_id' id='district_id' class='box2' onchange='getThana(),$gt_methodD'>
                            <option value='all'>----জেলা-----</option>";
            while($district_rows = mysql_fetch_array($district_sql))
                    {
                    $db_district_id = $district_rows['idDistrict'];
                    $db_district_name = $district_rows['district_name'];
                    echo "<option value='$db_district_id'>$db_district_name</option>";
                    }
            echo "</select>"; 
?>
