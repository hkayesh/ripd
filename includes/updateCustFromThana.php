<?php
include_once 'getSelectedThana.php';
?>

    <span id="office">
        <br /><br />
        <div>
            <table id="office_info_filter" border="1" align="center" width= 100%" cellpadding="5px" cellspacing="0px">
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th style="width: 20%"><?php echo "কাস্টমার নাম"; ?></th>
                        <th><?php echo "কাস্টমার অ্যাকাউন্ট নাম্বার"; ?></th>
                        <th><?php echo "কাস্টমার ইমেইল"; ?></th>
                        <th><?php echo "কাস্টমার মোবাইল নং"; ?></th>
                        <th><?php echo "কাস্টমারের থানা"; ?></th>
                        <th><?php echo "করনীয়"; ?></th>
                    </tr>
                </thead>
                <tbody>                    
                    <?php
                    $joinArray = implode(',', $arr_thanaID);
                    $sql_officeTable = "SELECT * from cfs_user,customer_account,address,thana WHERE address_whom='cust' AND address_type='Present' 
                                                        AND adrs_cepng_id= idCustomer_account AND cfs_user_idUser=idUser AND user_type='customer' 
                                                        AND Thana_idThana=idThana AND idThana IN ($joinArray) ORDER BY account_name ASC";
                    $rs = mysql_query($sql_officeTable);
                            while ($row_officeNcontact = mysql_fetch_array($rs)) {
                            $db_Name = $row_officeNcontact['account_name'];
                            $db_accNumber = $row_officeNcontact['account_number'];
                            $db_email = $row_officeNcontact['email'];
                            $db_mobile = $row_officeNcontact['mobile'];
                            $db_thana = $row_officeNcontact['thana_name'];
                            $db_custID = $row_officeNcontact['idCustomer_account'];
                            echo "<tr>";
                            echo "<td>$db_Name</td>";
                            echo "<td>$db_accNumber</td>";
                            echo "<td>$db_email</td>";
                            echo "<td>$db_mobile</td>";
                            echo "<td>$db_thana</td>";
                           $v = base64_encode($db_custID);
                            echo "<td><a href='update_customer_account_inner.php?id=$v'>আপডেট</a></td>";
                            echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>                        
        </div>
    </span>   