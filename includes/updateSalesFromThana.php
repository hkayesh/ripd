<?php
            include_once 'getSelectedThana.php';
?>

    <span id="office">
        <br /><br />
        <div>
            <table id="office_info_filter" border="1" align="center" width= 100%" cellpadding="5px" cellspacing="0px">
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo "সেলস স্টোরের নাম"; ?></th>
                        <th><?php echo "সেলস স্টোর নম্বর"; ?></th>
                        <th><?php echo "একাউন্ট নম্বর"; ?></th>
                         <th><?php echo "ইমেইল"; ?></th>
                        <th><?php echo "ঠিকানা"; ?></th>
                        <th><?php echo "করনীয়"; ?></th>
                        </tr>
                </thead>
                <tbody>                    
                    <?php
                    $joinArray = implode(',', $arr_thanaID);
                    $sql_salesStoreTable = "SELECT * from ".$dbname.".sales_store WHERE Thana_idThana IN ($joinArray) ORDER BY salesStore_name ASC";
                    $rs = mysql_query($sql_salesStoreTable);
                   
                    while ($row_officeNcontact = mysql_fetch_array($rs)) {
                        $db_salesStoreName = $row_officeNcontact['salesStore_name'];
                        $db_salesStoreNumber = $row_officeNcontact['salesStore_number'];
                        $db_salesStoreAN = $row_officeNcontact['account_number'];
                        $db_salesStoreAddress = $row_officeNcontact['salesStore_details_address'];
                        $db_salesStoreEmail = $row_officeNcontact['salesStore_email'];
                        $db_salesID = $row_officeNcontact['idSales_store'];
                        echo "<tr>";
                         echo "<td>$db_salesStoreName</td>";
                        echo "<td>$db_salesStoreNumber</td>";
                        echo "<td>$db_salesStoreAN</td>";
                        echo "<td>$db_salesStoreEmail</td>";
                        echo "<td>$db_salesStoreAddress</td>";
                        $v = base64_encode($db_salesID);
                        echo "<td><a href='update_salesStore.php?id=$v'>আপডেট</a></td>";
                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>                        
        </div>
    </span>   