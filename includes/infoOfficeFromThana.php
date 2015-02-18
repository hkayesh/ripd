<?php
            include_once 'getSelectedThana.php';
            
            officeTableHead();
            $joinArray = implode(',', $arr_thanaID);
            $office_sql = "SELECT * FROM ".$dbname.".office WHERE Thana_idThana IN ($joinArray) ORDER BY office_name ASC";
            officeNcontactTable($office_sql);
            officeTableEnd();
?>
