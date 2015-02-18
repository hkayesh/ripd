<?php                   
            include 'ConnectDB.inc';
            //get district name
            $dis_id = $_GET['tid'];
            $not = $_GET['no'];
            $thana_id_name = "thana_id".$not;
            //echo $dis_id;
            $thana_sql = mysql_query("SELECT * FROM  $dbname.thana WHERE District_idDistrict = '$dis_id' ORDER BY thana_name ASC");
            $function = "getPost_offc".$not."()";
            echo "<select  class='box2' style = 'border: 1px gray inset;' name='$thana_id_name' id='$thana_id_name' onchange='$function'>
            <option value='all'>-থানা-</option>";
            while($thana_rows = mysql_fetch_array($thana_sql))
                    {
                    $db_thana_id = $thana_rows['idThana'];
                    $db_thana_name = $thana_rows['thana_name'];
                    echo "<option value='$db_thana_id'>$db_thana_name</option>";
                    }
            echo "</select>"; 
?>
