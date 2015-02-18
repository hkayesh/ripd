<?php
error_reporting(0);
include_once 'ConnectDB.inc';
if (isset($_GET['key']) && $_GET['key'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['key'];
	$suggest_query = "SELECT * FROM  cfs_user WHERE account_number like('$str_key%') ORDER BY  account_number";
	$reslt= mysql_query($suggest_query);
        if(mysql_num_rows($reslt)<1){echo "দুঃখিত, এই নাম্বারের কোনো একাউন্ট নেই";}
        else 
        {
            while($suggest = mysql_fetch_assoc($reslt)) {
            $cfsid = $suggest['idUser'];
            $accType = $suggest['user_type'];
            if($accType == 'owner')
            {
                $sql = mysql_query("SELECT * FROM proprietor_account WHERE cfs_user_idUser = $cfsid");
                $row = mysql_fetch_assoc($sql);
                $imagesrc = $row['prop_scanDoc_picture'];
            }
            elseif($accType == 'customer')
            {
                $sql = mysql_query("SELECT * FROM customer_account WHERE cfs_user_idUser = $cfsid");
                $row = mysql_fetch_assoc($sql);
                $imagesrc = $row['scanDoc_picture'];
            }
            else
            {
                $sql = mysql_query("SELECT * FROM employee,employee_information WHERE Employee_idEmployee= idEmployee AND cfs_user_idUser = $cfsid");
                $row = mysql_fetch_assoc($sql);
                $imagesrc = $row['emplo_scanDoc_picture'];
            }
            $acc = $suggest['account_number'];
            $name =  urlencode($suggest['account_name']);
            $mbl = $suggest['mobile'];
	            echo "<a onclick=setBuyer('$acc','$name','$mbl','$imagesrc','$cfsid'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['account_name'].")</a></br>";
        	}
        }
}
