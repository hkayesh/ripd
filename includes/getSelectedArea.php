<?php
            include_once 'ConnectDB.inc';
            include_once 'showTables.php';
            
            $arr_thanaID = array();
            $arr_postID = array();
            $arr_vilgID = array();

            $district_id = $_GET['dsd'];
            $division_id = $_GET['dvd'];
            $th_id = $_GET['ttid'];
            $post_id = $_GET['pid'];
            $vilg_id = $_GET['vid'];
            
            if($post_id > 0 && $post_id != 'all')
            {
                    $post_sql = mysql_query("SELECT idPost_office FROM  post_office WHERE idPost_office = '$post_id' ");
            }
            
           if($vilg_id > 0 && $vilg_id != 'all')
            {
                    $vilg_sql = mysql_query("SELECT idvillage FROM  village WHERE idvillage = '$vilg_id' ");
            } 
            
            if($th_id > 0 && $th_id != 'all')
            {
                    $thana_sql = mysql_query("SELECT idThana FROM  thana WHERE idThana = '$th_id' ORDER BY thana_name ASC");
            }
            else
            {
                if($district_id == "all")
                        {
                        if($division_id == "all")                    
                                $thana_sql = mysql_query("SELECT * FROM thana ORDER BY thana_name ASC");
                        else
                                $thana_sql = mysql_query("SELECT * FROM thana, district, division
                                                                            WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision
                                                                            AND idDivision = $division_id ORDER BY thana_name ASC");
                        }
                else
                        {
                        $thana_sql = mysql_query("SELECT * FROM  thana WHERE District_idDistrict = '$district_id' ORDER BY thana_name ASC");
                        }                
            }
            
            while($thana_rows = mysql_fetch_array($thana_sql))
                    {
                        $db_thana_id = $thana_rows['idThana'];
                        array_push($arr_thanaID, $db_thana_id);
                    }
            while($post_rows = mysql_fetch_assoc($post_sql))
            {
                $db_post_id = $post_rows['idPost_office'];
                array_push($arr_postID, $db_post_id);
            }
            while($vilg_rows = mysql_fetch_assoc($vilg_sql))
            {
                $db_vilg_id = $vilg_rows['idvillage'];
                array_push($arr_vilgID, $db_vilg_id);
            }

?>
