<?php                   
            include 'ConnectDB.inc';
            $dv_id = $_GET['did'];
            
            if($dv_id == "all")
                    {
                    $district_sql = mysql_query("SELECT * FROM ".$dbname.".district ORDER BY district_name ASC");
                    }
            else
                    {
                    $district_sql = mysql_query("SELECT * FROM  ".$dbname.".district WHERE Division_idDivision = '".$dv_id."' ORDER BY district_name ASC");
                    }
            echo "<select name='district_id3' id='district_id3' class='box2' onchange='getThana3()'>
                            <option value='all'>-জেলা-</option>";
            while($district_rows = mysql_fetch_array($district_sql))
                    {
                    $db_district_id = $district_rows['idDistrict'];
                    $db_district_name = $district_rows['district_name'];
                    echo "<option value='$db_district_id'>$db_district_name</option>";
                    }
            echo "</select>"; 
?>