<?php
error_reporting(0);
include_once 'ConnectDB.inc';
if (isset($_GET['key']) && $_GET['key'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['key'];
             $location = $_GET['location'];
	$suggest_query = "SELECT * FROM  cfs_user WHERE account_number like('$str_key%') ORDER BY  account_number";
	$reslt= mysql_query($suggest_query);
        if(mysql_num_rows($reslt)<1){echo "দুঃখিত, এই নাম্বারের কোনো একাউন্ট নেই";}
	while($suggest = mysql_fetch_assoc($reslt)){
            $acc_id = $suggest['idUser'];
            $acc_number = $suggest['account_number'];
            $acc_name = $suggest['account_name'];
            
            echo "<form name=\"account_search_submit\" method=\"POST\" action=\"$location\">";
            echo "<input type=\"hidden\" name=\"account_cfs_id\" value=\"$acc_id\" />";
            echo "<input class=\"btn\" style =\" font-size: 12px; width: 100%;\" type=\"submit\" name=\"submit_account\" value=\"$acc_number ($acc_name)\"/>";
        	echo '</form>';             
                }            
}

elseif (isset($_GET['acc']) && $_GET['acc'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['acc'];
	$suggest_query = "SELECT * FROM  cfs_user WHERE account_number='$str_key'";
	$reslt= mysql_query($suggest_query);
                    if(mysql_num_rows($reslt)<1)
                        {echo "<font style='color:red'>দুঃখিত, এই নাম্বারের কোনো একাউন্ট নেই</font>";}
                        
	while($suggest = mysql_fetch_assoc($reslt)){
                            $acc_name = $suggest['account_name'];
                            echo $acc_name;            
                }            
}
?>
