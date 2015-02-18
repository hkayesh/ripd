<?php
include 'ConnectDB.inc';
            $post_id = $_GET['PoId'];
            $gt_methodT = $_GET['mtT'];
            if($post_id == "all")
                    {
                    $vilg_sql = mysql_query("SELECT * FROM village ORDER BY village_name ASC");
                    }
            else
                    {
                    $vilg_sql = mysql_query("SELECT * FROM village WHERE post_office_idPost_office=$post_id ORDER BY village_name ASC");
                    }
            echo "<select name='vilg_id' id='vilg_id' class='box2' onchange='$gt_methodT'>
                        <option value='all'>-গ্রাম/পাড়া/প্রোজেক্ট-</option>";
                 while ($vilg_rows = mysql_fetch_array($vilg_sql)) {
                $db_vilg_id = $vilg_rows['idvillage'];
                $db_vilg_name = $vilg_rows['village_name'];
                echo "<option value='$db_vilg_id'>$db_vilg_name</option>";
            }
        echo "</select>";
?>
