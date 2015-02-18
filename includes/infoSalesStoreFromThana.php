<?php
            include_once 'getSelectedThana.php';
?>
    <span id="office">
        <br /><br />
        <div>
            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo "সেলস স্টোর নং"; ?></th>
                        <th><?php echo "সেলস স্টোর নেইম"; ?></th>
                        <th><?php echo "ঠিকানা"; ?></th>
                        <th><?php echo "ই-মেইল"; ?></th>
                        <th><?php echo ""; ?></th>
                    </tr>
                </thead>
                <tbody>                    
                    <?php
                    $joinArray = implode(',', $arr_thanaID);
                    $sql_salesStoreTable = "SELECT * from ".$dbname.".sales_store WHERE Thana_idThana IN ($joinArray) ORDER BY salesStore_name ASC";
                    $db_slNo = 0;
                    $rs = mysql_query($sql_salesStoreTable);

                    //echo mysql_num_rows($rs);
                    while ($row_officeNcontact = mysql_fetch_array($rs)) {
                        $db_slNo = $db_slNo + 1;
                        $db_salesStoreName = $row_officeNcontact['salesStore_name'];
                        $db_salesStoreNumber = $row_officeNcontact['salesStore_number'];
                        $db_salesStoreAN = $row_officeNcontact['account_number'];
                        $db_salesStoreAddress = $row_officeNcontact['salesStore_detailsAddress'];
                        $db_salesStoreEmail = $row_officeNcontact['salesStore_email'];
                        echo "<tr>";
                        echo "<td>$db_slNo</td>";
                        echo "<td>$db_salesStoreName</td>";
                        echo "<td>$db_salesStoreAddress</td>";
                        echo "<td>$db_salesStoreEmail</td>";
                        echo "<td><a onclick=send_mail('$db_salesStoreEmail') style='cursor:pointer;color:blue;'>Send Mail</a></td>";
                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>                        
        </div>
    </span>   