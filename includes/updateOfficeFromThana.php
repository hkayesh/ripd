<?php
            include_once 'getSelectedThana.php';
            $gettype = $_GET['type'];
            $logedinOfficeId = $_SESSION['loggedInOfficeID'];
$sel_office = mysql_query("SELECT * FROM office WHERE idOffice = $logedinOfficeId");
$officerow = mysql_fetch_assoc($sel_office);
$db_selectedOffice = $officerow['office_selection'];
?>

    <span id="office">
        <br /><br />
        <div>
            <table id="office_info_filter" border="1" align="center" width= 100%" cellpadding="5px" cellspacing="0px">
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo "অফিসের নাম"; ?></th>
                        <th><?php echo "অফিসের নাম্বার"; ?></th>
                        <th><?php echo "অফিসের অ্যাকাউন্ট নাম্বার"; ?></th>
                        <th><?php echo "অফিসের ইমেইল"; ?></th>
                        <th><?php echo "অফিসের ঠিকানা"; ?></th>
                        <th><?php echo "করনীয়"; ?></th>
                    </tr>
                </thead>
                <tbody>                    
                    <?php
                    $joinArray = implode(',', $arr_thanaID);
                    if($gettype==1)
                    {
                    $sql_officeTable = "SELECT * from ".$dbname.".office WHERE office_type = 'pwr_head' AND Thana_idThana IN ($joinArray) ORDER BY office_name ASC";
                    $rs = mysql_query($sql_officeTable);
                    }
                    else{
                    $sql_officeTable = "SELECT * from ".$dbname.".office WHERE office_type <> 'pwr_head' AND office_selection= '$db_selectedOffice' AND Thana_idThana IN ($joinArray) ORDER BY office_name ASC";
                    $rs = mysql_query($sql_officeTable);
                    }

                    //echo mysql_num_rows($rs);
                    while ($row_officeNcontact = mysql_fetch_array($rs)) {
                        $db_offName = $row_officeNcontact['office_name'];
                        $db_offNumber = $row_officeNcontact['office_number'];
                        $db_offAN = $row_officeNcontact['account_number'];
                        $db_offAddress = $row_officeNcontact['office_details_address'];
                        $db_offemail = $row_officeNcontact['office_email'];
                        $db_offID = $row_officeNcontact['idOffice'];
                        echo "<tr>";
                        echo "<td>$db_offName</td>";
                        echo "<td>$db_offNumber</td>";
                        echo "<td>$db_offAN</td>";
                        echo "<td>$db_offemail</td>";
                        echo "<td>$db_offAddress</td>";
                        $v = base64_encode($db_offID);
                        echo "<td><a href='update_account_off_pstore.php?id=$v&type=$gettype'>আপডেট</a></td>";
                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>                        
        </div>
    </span>   