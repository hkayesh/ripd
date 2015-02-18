<?php
            include_once 'ConnectDB.inc';
            include_once 'showTables.php';
            
            $count = 0;
            $arr_thanaID = array();

            //get office info
            $district_id = $_GET['dsd'];
            $division_id = $_GET['dvd'];
            $th_id = $_GET['ttid'];
            
            if($th_id > 0 && $th_id != 'all')
                    $thana_sql = mysql_query("SELECT * FROM  ".$dbname.".thana WHERE idThana = '".$th_id."' ORDER BY thana_name ASC");
            else
            {
            if($district_id == "all")
                    {
                    if($division_id == "all")                    
                            $thana_sql = mysql_query("SELECT * FROM ".$dbname.".thana ORDER BY thana_name ASC");
                    else
                            $thana_sql = mysql_query("SELECT * FROM ".$dbname.".thana, ".$dbname.".district, ".$dbname.".division
                                                                    WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision
                                                                            AND idDivision = '" . $division_id . "'ORDER BY thana_name ASC");
                    }
            else
                    {
                    $thana_sql = mysql_query("SELECT * FROM  ".$dbname.".thana WHERE District_idDistrict = '".$district_id."' ORDER BY thana_name ASC");
                    }                
            }
            
            while($thana_rows = mysql_fetch_array($thana_sql))
                    {
                    $db_thana_id = $thana_rows['idThana'];
                    $arr_thanaID[$count] = $db_thana_id;
                    $count = $count +1;
                    }

?>
