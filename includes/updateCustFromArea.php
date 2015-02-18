<?php include_once 'getSelectedArea.php'; ?>
<tbody>                    
    <?php
    $joinArray = implode(',', $arr_thanaID);
    $postArray = implode(',', $arr_postID);
    $vilgArray = implode(',', $arr_vilgID);
    if(count($arr_postID) == 0 && count($arr_vilgID) == 0)
    { 
        $sql_officeTable = "SELECT * FROM cfs_user,customer_account,address,thana,post_office,village WHERE address_whom='cust' AND address_type='Permanent' 
                                        AND adrs_cepng_id= idCustomer_account AND cfs_user_idUser=idUser AND user_type='customer' 
                                        AND address.Thana_idThana=idThana AND idThana IN ($joinArray) 
                                        AND village_idvillage = idvillage AND post_idpost = idPost_office ORDER BY account_name ASC";
    }
    elseif (count($arr_postID) != 0 && count($arr_vilgID) == 0) 
        { 
            $sql_officeTable = "SELECT * FROM cfs_user,customer_account,address,thana,post_office,village WHERE address_whom='cust' AND address_type='Permanent' 
                                        AND adrs_cepng_id= idCustomer_account AND cfs_user_idUser=idUser AND user_type='customer'
                                        AND address.Thana_idThana = idThana AND village_idvillage = idvillage
                                        AND post_idpost = idPost_office AND idPost_office IN ($postArray) ORDER BY account_name ASC";
        }
   else{ 
            $sql_officeTable = "SELECT * FROM cfs_user,customer_account,address,thana,post_office,village WHERE address_whom='cust' AND address_type='Permanent' 
                                        AND adrs_cepng_id= idCustomer_account AND cfs_user_idUser=idUser AND user_type='customer' 
                                        AND address.Thana_idThana = idThana AND post_idpost = idPost_office
                                        AND village_idvillage = idvillage AND idvillage IN ($vilgArray) ORDER BY account_name ASC";
        }
    $rs = mysql_query($sql_officeTable);
            while ($row_officeNcontact = mysql_fetch_array($rs)) {
            $db_Name = $row_officeNcontact['account_name'];
            $db_accNumber = $row_officeNcontact['account_number'];
            $db_mobile = $row_officeNcontact['mobile'];
            $db_thana = $row_officeNcontact['thana_name'];
            $db_post = $row_officeNcontact['post_offc_name'];
            $db_vilg = $row_officeNcontact['village_name'];
            $db_custID = $row_officeNcontact['idCustomer_account'];
            echo "<tr>";
            echo "<td style='border: 1px solid #969797;'>$db_Name</td>";
            echo "<td style='border: 1px solid #969797;'>$db_accNumber</td>";
            echo "<td style='border: 1px solid #969797;'>$db_mobile</td>";
            echo "<td style='border: 1px solid #969797;'>$db_thana</td>";
            echo "<td style='border: 1px solid #969797;'>$db_post</td>";
            echo "<td style='border: 1px solid #969797;'>$db_vilg</td>";
           $v = base64_encode($db_custID);
            echo "<td style='border: 1px solid #969797;'><a href='customer_list.php?id=$v'>বিস্তারিত</a></td>";
            echo "</tr>";
    }
    ?>
</tbody>