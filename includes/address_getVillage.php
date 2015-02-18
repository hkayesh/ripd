<?php                   
            include 'ConnectDB.inc';
            //get post office name
            $post_id = $_GET['vid'];
            $nov = $_GET['no'];
            $village_id_name = "village_id".$nov;
            $village_sql = mysql_query("SELECT * FROM  $dbname.village WHERE post_office_idPost_office = '$post_id' ORDER BY village_name ASC");
            echo "<select  class='box2' style = 'border: 1px gray inset;' name='$village_id_name' id='$village_id_name'>
            <option value='all'>-গ্রাম-</option>";
            while($village_rows = mysql_fetch_array($village_sql))
                    {
                    $db_village_id = $village_rows['idvillage'];
                    $db_village_name = $village_rows['village_name'];
                    echo "<option value='$db_village_id'>$db_village_name</option>";
                    }
            echo "</select>"; 
?>