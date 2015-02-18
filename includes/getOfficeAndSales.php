<?php
//error_reporting(0);
            include_once 'ConnectDB.inc';
            //get district name
            $g_id = $_GET['thanaid'];
            echo "<select class='box' id='offNsales' name='offNsales' style='width: 200px;font-family: SolaimanLipi !important;' onchange='showProductsForOnS(this.value)'>
                     <option value='0'>-- অফিস / সেলসস্টোর --</option>";
            $sel_store_by_thana = mysql_query("SELECT * FROM  sales_store WHERE Thana_idThana = $g_id ORDER BY salesStore_name ASC");
            while($store_rows = mysql_fetch_array($sel_store_by_thana))
                    {
                        $db_store_id = $store_rows['idSales_store'];
                        $db_store_name = $store_rows['salesStore_name'];
                        $str_store = "s_store,".$db_store_id;
                        echo "<option value='$str_store'>$db_store_name</option>";
                    }
           $sel_office_by_thana = mysql_query("SELECT * FROM office WHERE Thana_idThana = $g_id ORDER BY office_name ASC");
            while($office_rows = mysql_fetch_array($sel_office_by_thana))
                    {
                        $db_office_id = $office_rows['idOffice'];
                        $db_office_name = $office_rows['office_name'];
                        $str_office = "office,".$db_office_id;
                        echo "<option value='$str_office'>$db_office_name</option>";
                    }
            echo "</select>"; 
?>
