<?php
        error_reporting(0);
        function officeTableHead()
                {
?>
                <br /><br />
                <div>
                <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                    <thead>
                        <tr align="left" id="table_row_odd">
                            <th><?php echo "অফিস নং";?></th>
                            <th><?php echo "অফিস নেইম";?></th>
                            <th><?php echo "অফিস নম্বর";?></th>
                            <th><?php echo "ব্রাঞ্চ নেইম";?></th>
                            <th><?php echo "ই-মেইল";?></th>                  
                        </tr>
                    </thead>
                    <tbody>
<?php
                }
        
        function officeNcontactTable($sql_officeNcontact)
                {
                $db_slNo = 0;
                    $rs_officeNcontact = mysql_query($sql_officeNcontact);
                    while($row_officeNcontact = mysql_fetch_assoc($rs_officeNcontact))
                         {
                         $db_slNo = $db_slNo + 1;
                         $db_officeName = $row_officeNcontact['office_name'];
                         $db_officeNumber = $row_officeNcontact['office_number'];
                         $db_officeAddress = $row_officeNcontact['branch_name'];
                         $db_officeEmail = $row_officeNcontact['office_email'];
                         echo "<tr>";
                         echo "<td>$db_slNo</td>";
                         echo "<td>$db_officeName</td>";
                         echo "<td>$db_officeNumber</td>";
                         echo "<td>$db_officeAddress</td>";
                         echo "<td>$db_officeEmail</td>";
                         echo "</tr>";
                         }
                //if(mysql_num_rows($rs_officeNcontact)==0) echo "এখানে কোন অফিসের ঠিকানা পাওয়া যাচ্ছে না";
                }               
                
        function officeTableEnd()
                {
?>
                    </tbody>
            </table>                        
            </div>
        <?php } ?>
