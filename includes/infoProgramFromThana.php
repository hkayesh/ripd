<?php
include_once 'getSelectedThana.php';
$date_from = $_GET['df'];
$date_to = $_GET['dt'];
$type = $_GET['type'];
$typeinbangla = getProgramType($type);
$whoinbangla = getProgramer($type);
?>
<span id="office">
<br /><br />
<div>
    <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
        <thead>
            <tr align="left" id="table_row_odd">
                <th><?php echo $typeinbangla."-এর নাম"; ?></th>                      
                <th><?php echo "লোকেশন"; ?></th>
                <th><?php echo "বিষয়" ?></th>
                <th><?php echo "তারিখ"; ?></th>
                <th><?php echo "সময়"; ?></th>
                <th><?php echo $whoinbangla; ?></th>      
                <th><?php echo "অফিস নাম"; ?></th>
                <th><?php echo "অফিস ঠিকানা"; ?></th>
            </tr>
        </thead>
        <tbody>
<?php
        $joinArray = implode(',', $arr_thanaID);

        if($date_from == null || $date_from == ""){$date_from = date("Y-m-d");}
        if($date_to == null || $date_to == ""){$date_to = "2099-12-31";};
        $sql_salesStoreTable = "SELECT * FROM program, office
                                            WHERE program_type = '$type' AND Office_idOffice=idOffice AND Thana_idThana IN ($joinArray) 
                                            AND program_date BETWEEN '$date_from' AND '$date_to' ORDER BY program_date ASC";
        $db_slNo = 1;
        $rs = mysql_query($sql_salesStoreTable);
        while ($row = mysql_fetch_array($rs)) {
            $db_programName = $row['program_name'];
            $db_programLocation = $row['program_location'];
            $db_office_name = $row['office_name'];
            $db_office_address = $row['office_details_address'];
            $db_programDate = $row['program_date'];
            $db_programTime = $row['program_time'];
            $db_programId = $row['idprogram'];
            $db_programSubject = $row['subject'];
            $demonastrators = '';
            $sql_demonastrators_name = "SELECT * FROM presenter_list, employee, cfs_user WHERE fk_idprogram = '$db_programId' AND fk_Employee_idEmployee = idEmployee AND cfs_user_idUser = idUser";
            $row_demonastrators_name = mysql_query($sql_demonastrators_name);
            while ($row_names = mysql_fetch_array($row_demonastrators_name)){
                $db_demons_name = $row_names['account_name'];
                $demonastrators = $db_demons_name.", ".$demonastrators;
            }
            echo "<tr>";
            echo "<td>$db_programName</td>";
            echo "<td>$db_programLocation</td>";
            echo "<td>$db_programSubject</td>";
            echo "<td>".english2bangla(date("d/m/Y",  strtotime($db_programDate)))."</td>";
            echo "<td>".english2bangla(date('g:i a' , strtotime($db_programTime)))."</td>";
            echo "<td>$demonastrators</td>";
            echo "<td>$db_office_name</td>";
            echo "<td>$db_office_address</td>";
            echo "</tr>";
        }
?>
            </tbody>
        </table>                        
</div>
</span>    
