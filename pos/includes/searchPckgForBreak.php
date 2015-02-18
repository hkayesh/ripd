<?php
error_reporting(0);
include 'ConnectDB.inc'; 
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
    if (isset($_GET['searchKey']) && $_GET['searchKey'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchKey'];
	$suggest_query = "SELECT * FROM package_info WHERE pckg_code LIKE('" .$str_key ."%') ORDER BY pckg_code";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) 
                    {
                                $pckgid = $suggest['idpckginfo'];
                                $query = mysql_query("SELECT * FROM package_inventory WHERE pckg_infoid=$pckgid  AND ons_type='$scatagory' AND ons_id=$storeID;");
                                $result = mysql_fetch_assoc($query);
                                if(count($result)!=1)
                                {
                                    echo "<a  class='prolinks' style='text-decoration:none;color:brown;display:block;' href=package_breaking.php?id=" . $suggest['idpckginfo'] . ">" . $suggest['pckg_code'] ." ".$suggest['pckg_name']. "</a>";
                                }
                      }
}
?>

