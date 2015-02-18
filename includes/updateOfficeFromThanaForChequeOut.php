<?php
            include_once 'getSelectedThana.php';
?>
<span id="office">
                            <table style="border: black solid 1px;" align="center" width= 90%" cellpadding="1px" cellspacing="1px">
                                <thead>
                                    <tr align="left" id="table_row_odd">
                                    <th>ক্রম</th>
                                    <th>অফিসের নাম</th>
                                    <th>অফিসের নাম্বার</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                   $joinArray = implode(',', $arr_thanaID);
                                    $sql_officeTable = "SELECT * from ".$dbname.".office WHERE Thana_idThana IN ($joinArray) ORDER BY office_name ASC";
                                    $rs = mysql_query($sql_officeTable);

                                    while ($row_officeNcontact = mysql_fetch_assoc($rs)) 
                                    {
                                        $db_slNo = $db_slNo + 1;
                                        $db_offName = $row_officeNcontact['office_name'];
                                        $db_offNumber = $row_officeNcontact['office_number'];
                                        $db_offID = $row_officeNcontact['idOffice'];
                                        echo "<tr style='border: black solid 1px;'>";
                                        echo "<td>$db_slNo</td>";
                                        echo "<td>$db_offName</td>";
                                        echo "<td>$db_offNumber<input type='hidden'  name='officelist[]' value= $db_offID  /></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
</span>  
