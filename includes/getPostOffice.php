<?php
include 'ConnectDB.inc';
            $thana_id = $_GET['ThId'];     
            if($thana_id == "all")
                    {
                    $post_sql = mysql_query("SELECT * FROM post_office ORDER BY post_offc_name ASC");
                    }
            else
                    {
                    $post_sql = mysql_query("SELECT * FROM post_office WHERE Thana_idThana='$thana_id' ORDER BY post_offc_name ASC");
                    }
            echo "<select name='post_id' id='post_id' class='box2' onchange='getVillage();' >
                        <option value='all'>-পোস্টঅফিস-</option>";
            while ($post_rows = mysql_fetch_array($post_sql)) {
                $db_post_id = $post_rows['idPost_office'];
                $db_post_name = $post_rows['post_offc_name'];
                echo "<option value='$db_post_id'>$db_post_name</option>";
            }
        echo "</select>";
?>
