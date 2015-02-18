<?php
include_once 'getSelectedThana.php';
include_once './connectionPDO.php';
$loggedInOfficeType = $_SESSION['loggedInOfficeType'];
$loggedInOfficeId = $_SESSION['loggedInOfficeID'];
$sql_select_id_ons_relation = $conn->prepare("SELECT idons_relation FROM  ons_relation WHERE catagory =  ? AND add_ons_id = ?");
$sql_select_id_ons_relation->execute(array($loggedInOfficeType,$loggedInOfficeId));
$row = $sql_select_id_ons_relation->fetchAll();
foreach ($row as $value) {
    $loggedInOnSid = $value['idons_relation'];
}
?>

<span id="office">
    <br /><br />
    <div>
        <table id="office_info_filter" border="1" align="center" width= 100%" cellpadding="5px" cellspacing="0px">
            <thead>
                <tr align="left" id="table_row_odd">
                    <th><?php echo "কর্মচারীর নাম"; ?></th>
                    <th><?php echo "কর্মচারীর অ্যাকাউন্ট নাম্বার"; ?></th>
                    <th><?php echo "কর্মচারীর ইমেইল"; ?></th>
                    <th><?php echo "কর্মচারীর মোবাইল নং"; ?></th>
                    <th><?php echo "অফিসের নাম"; ?></th>
                    <th><?php echo "করনীয়"; ?></th>
                </tr>
            </thead>
            <tbody>                    
                <?php
                $joinArray = implode(',', $arr_thanaID);
                $sql_officeTable = "SELECT * from cfs_user,employee WHERE emp_ons_id = $loggedInOnSid AND (user_type='employee' OR user_type='presenter' OR user_type='programmer' OR user_type='trainer')
                                                        AND cfs_user_idUser= idUser ORDER BY account_name ASC";
                        $rs = mysql_query($sql_officeTable);
                            while ($row_officeNcontact = mysql_fetch_array($rs)) {
                            $db_Name = $row_officeNcontact['account_name'];
                            $db_accNumber = $row_officeNcontact['account_number'];
                            $db_email = $row_officeNcontact['email'];
                            $db_mobile = $row_officeNcontact['mobile'];
                            $db_empID = $row_officeNcontact['idEmployee'];
                            if($loggedInOfficeType == 'office')
                            {
                                    $off_sel = mysql_query("SELECT * FROM office WHERE idOffice = $loggedInOfficeId AND Thana_idThana IN ($joinArray)");
                                    while ($offrow = mysql_fetch_assoc($off_sel))
                                    {
                                        $onsName = $offrow['office_name'];
                                         echo "<tr>";
                                        echo "<td>$db_Name</td>";
                                        echo "<td>$db_accNumber</td>";
                                        echo "<td>$db_email</td>";
                                        echo "<td>$db_mobile</td>";
                                        echo "<td>$onsName</td>";
                                        $v = base64_encode($db_empID);
                                        echo "<td><a href='update_employee_account_inner.php?id=$v'>আপডেট</a></td>";
                                        echo "</tr>";
                                    }
                            }
                            else 
                                {
                                    $off_sel = mysql_query("SELECT * FROM sales_store WHERE idSales_store = $loggedInOfficeId AND Thana_idThana IN ($joinArray)");
                                    while($offrow = mysql_fetch_assoc($off_sel))
                                    {
                                        $onsName = $offrow['salesStore_name'];
                                        echo "<tr>";
                                        echo "<td>$db_Name</td>";
                                        echo "<td>$db_accNumber</td>";
                                        echo "<td>$db_email</td>";
                                        echo "<td>$db_mobile</td>";
                                        echo "<td>$onsName</td>";
                                        $v = base64_encode($db_empID);
                                        echo "<td><a href='update_employee_account_inner.php?id=$v'>আপডেট</a></td>";
                                        echo "</tr>";
                                    }
                                }
                }
                ?>
            </tbody>
        </table>                        
    </div>
</span>   