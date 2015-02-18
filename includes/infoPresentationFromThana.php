<?php
$date_from = $_GET['df'];
$date_to = $_GET['dt'];

include_once 'getSelectedThana.php';
?>

<span id="office">
    <br /><br />
    <div>
        <table id="office_info_filter" border="1" align="center" width= 100%" cellpadding="5px" cellspacing="0px">
            <thead>
                <tr align="left" id="table_row_odd">
                    <th><?php echo "ক্রম"; ?></th>
                    <th><?php echo "প্রেজেন্টেশন নাম"; ?></th>
                    <th><?php echo "প্রেজেন্টেশন নম্বর"; ?></th>
                    <th><?php echo "উপস্থাপক"; ?></th>                            
                    <th><?php echo "লোকেশন"; ?></th>
                    <th><?php echo "বিষয়" ?></th>
                    <th><?php echo "তারিখ"; ?></th>
                    <th><?php echo "সময়"; ?></th>
                </tr>
            </thead>
            <tbody>

                <?php
                $joinArray = implode(',', $arr_thanaID);

                if ($date_from == null || $date_from == "")
                    $date_from = "curdate()";
                else
                    $date_from = '\'' . $date_from . '\'';
                if ($date_to == null || $date_to == "")
                    $date_to = "2099-12-31";

                $sql_salesStoreTable = "SELECT * from " . $dbname . ".program, " . $dbname . ".office
                                                        WHERE program_type = 'presentation' AND program_location=idOffice AND Thana_idThana IN ($joinArray) 
                                                            AND program_date between $date_from and '$date_to'
                                                                ORDER BY program_date ASC";
                $db_slNo = 0;
                $rs = mysql_query($sql_salesStoreTable);

                //echo mysql_num_rows($rs);
                while ($row = mysql_fetch_array($rs)) {
                    $db_slNo = $db_slNo + 1;
                    $db_programName = $row['program_name'];
                    $db_programNumber = $row['program_no'];
                    $db_program_host_id = $row['Employee_idEmployee'];
                    //$db_programLocation = $row['program_location'];
                    $db_program_location = $row['office_details_address'];
                    $db_programDate = $row['program_date'];
                    $db_programTime = $row['program_time'];
                    ///////////////////////////////////
                    $sql_program_host_name = "SELECT employee_name FROM " . $dbname . ".employee_information WHERE Employee_idEmployee = $db_program_host_id";
                    $rs_host_name = mysql_query($sql_program_host_name);
                    $rowName = mysql_fetch_array($rs_host_name);
                    $db_program_host_name = $rowName['employee_name'];
                    ///////////////////////////////////
                    // $sql_location = "SELECT office_name, office_details_address FROM ".$dbname.".office where idOffice = $db_programLocation";
                    //$rs_location = mysql_query($sql_location);
                    //$row_location = mysql_fetch_array($rs_location);
                    //$db_program_location = $row_location['office_details_address'];
                    ///////////////////////////////////
                    $db_programSubject = $row['subject'];
                    //$db_programTime = $row['program_schedule'];
                    echo "<tr>";
                    echo "<td>$db_slNo</td>";
                    echo "<td>$db_programName</td>";
                    echo "<td>$db_programNumber</td>";
                    echo "<td>$db_program_host_name</td>";
                    echo "<td>$db_program_location</td>";
                    echo "<td>$db_programSubject</td>";
                    echo "<td>$db_programDate</td>";
                    echo "<td>$db_programTime</td>";
                    echo "</tr>";
                }
                ?>

            </tbody>
        </table>                        
    </div>
</span>