<?php                   
            include 'ConnectDB.inc';
            //get district name
            $thana_id = $_GET['pid'];
            $nop = $_GET['no'];
            $post_id_name = "post_id".$nop;
            $post_sql = mysql_query("SELECT * FROM  $dbname.post_office WHERE Thana_idThana = '$thana_id' ORDER BY post_offc_name ASC");
            $function = "getVillage".$nop."()";
            echo "<select class='box2' style = 'border: 1px gray inset;' name='$post_id_name' id='$post_id_name' onchange='$function'>
            <option value='all'>-পোস্ট অফিস-</option>";
            while($post_rows = mysql_fetch_array($post_sql))
                    {
                    $db_post_id = $post_rows['idPost_office'];
                    $db_post_name = $post_rows['post_offc_name'];
                    echo "<option value='$db_post_id'>$db_post_name</option>";
                    }
            echo "</select>"; 
?>
