<?php                   
            include_once 'ConnectDB.inc';
            include_once 'showTables.php';
            $count = 0;
            $arr_thanaID = array();

            //get thana name
            $district_id = $_GET['tDsId'];
            $division_id = $_GET['tDfId'];
            $gt_methodT = $_GET['mtT'];
            
            if($district_id == "all")
                    {
                        if($division_id != "all")
                        {
                                $thana_sql = mysql_query("SELECT * FROM thana, district,division WHERE District_idDistrict=idDistrict AND Division_idDivision=idDivision
                                                                                AND idDivision = $division_id ORDER BY thana_name ASC");
                        }
                        else
                                $thana_sql = mysql_query("SELECT * FROM thana ORDER BY thana_name ASC");
                    }
            else
                    {
                    $thana_sql = mysql_query("SELECT * FROM  ".$dbname.".thana WHERE District_idDistrict = '".$district_id."' ORDER BY thana_name ASC");
                    }
                   // echo $gt_methodT;
            echo "<select name='thana_id' id='thana_id' class='box2' onChange='$gt_methodT'>
                            <option value='all'>----থানা----</option>";
            while($thana_rows = mysql_fetch_array($thana_sql))
                    {
                    $db_thana_id = $thana_rows['idThana'];
                    $db_thana_name = $thana_rows['thana_name'];
                    $arr_thanaID[$count] = $db_thana_id;
                    $count = $count +1;
                    echo "<option value='$db_thana_id'>$db_thana_name</option>";
                    }
            echo "</select>"; 
?>
