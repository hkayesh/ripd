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
                            <th><?php echo "নাম";?></th>
                            <th><?php echo "অফিস ধরন";?></th>
                            <th><?php echo "ব্রাঞ্চ নাম";?></th>
                            <th><?php echo "ঠিকানা";?></th>
                            <th><?php echo "ই-মেইল";?></th>     
                            <th><?php echo "";?></th>                    
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
                         $db_officeType = $row_officeNcontact['office_type'];
                         $db_officeBranch = $row_officeNcontact['branch_name'];
                         $db_officeAddress = $row_officeNcontact['office_details_address'];
                         $db_officeEmail = $row_officeNcontact['office_email'];
                         echo "<tr>";
                         echo "<td>$db_officeName</td>";
                         echo "<td>$db_officeType</td>";
                         echo "<td>$db_officeBranch</td>";
                         echo "<td>$db_officeAddress</td>";
                         echo "<td>$db_officeEmail</td>";
                         echo "<td><a onclick=send_mail('$db_officeEmail') style='cursor:pointer;color:blue;'>ই-মেইল করুন</a></td>";
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
