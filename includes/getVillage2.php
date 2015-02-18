<?php
include 'ConnectDB.inc';
            $post_id = $_GET['PoId'];     
            if($post_id == "all")
                    {
                    $vilg_sql = mysql_query("SELECT * FROM " . $dbname . ".village ORDER BY village_name ASC");
                    }
            else
                    {
                    $vilg_sql = mysql_query("SELECT * FROM " . $dbname . ".village WHERE post_office_idPost_office=$post_id ORDER BY village_name ASC");
                    }
            echo "<select name='vilg_id2' id='vilg_id2' class='box2' >
                        <option value='all'>-গ্রাম-</option>";
                 while ($vilg_rows = mysql_fetch_array($vilg_sql)) {
                $db_vilg_id = $vilg_rows['idvillage'];
                $db_vilg_name = $vilg_rows['village_name'];
                echo "<option value='$db_vilg_id'>$db_vilg_name</option>";
            }
        echo "</select>";
?>
