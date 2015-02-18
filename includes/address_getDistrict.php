<?php                   
            include 'ConnectDB.inc';
            //get district name
            $dv_id = $_GET['did'];
            $nod = $_GET['no'];
            $district_id_name = "district_id".$nod;
           // echo "Division_id: ".$dv_id." Nod: ".$nod."district_id_name".$district_id_name;
            $district_sql = mysql_query("SELECT * FROM  $dbname.district WHERE Division_idDivision = '$dv_id' ORDER BY district_name ASC");
            $function = "getThana".$nod."()";
            echo "<select  class='box2' style = 'border: 1px gray inset;' name='$district_id_name' id='$district_id_name' onchange='$function'>
                <option value='all'>-জেলা-</option>";
            while($district_rows = mysql_fetch_array($district_sql))
                    {
                    $db_district_id = $district_rows['idDistrict'];
                    $db_district_name = $district_rows['district_name'];
                    echo "<option value='$db_district_id'>$db_district_name</option>";
                    }
            echo "</select>"; 
?>
