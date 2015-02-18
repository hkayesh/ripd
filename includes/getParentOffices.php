<?php
error_reporting(0);
include_once 'ConnectDB.inc';
if (isset($_GET['searchkey']) && $_GET['searchkey'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchkey'];
                  $type = $_GET['officetype'];
	$suggest_query = "SELECT * FROM  office WHERE account_number like('$str_key%') AND office_selection= '$type' ORDER BY account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $acc = $suggest['account_number'];
                    $id = $suggest['idOffice'];
	            echo "<u><a onclick=setParent('$acc','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['office_name'].")</a></u></br>";
        	}
                
}
elseif (isset($_GET['search']) && ($_GET['search'] != '') && ($_GET['office'] == 1)) {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['search'];
	$suggest_query = "SELECT * FROM  office WHERE account_number like('$str_key%') AND office_selection= 'ripd' ORDER BY account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $acc = $suggest['account_number'];
                    $id = $suggest['idOffice'];
	            echo "<u><a onclick=setOffice('$acc','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['office_name'].")</a></u></br>";
        	}
                
}
elseif (isset($_GET['key']) && ($_GET['key'] != '') && ($_GET['pwr']==1)) {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['key'];
	$suggest_query = "SELECT * FROM  office WHERE account_number like('$str_key%') AND office_selection= 'pwr' ORDER BY account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $acc = $suggest['account_number'];
                    $id = $suggest['idOffice'];
	            echo "<u><a onclick=setPwr('$acc','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['office_name'].")</a></u></br>";
        	}
                
}
elseif (isset($_GET['search']) && ($_GET['search'] != '') && ($_GET['alloffice'] == 1)) {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['search'];
	$suggest_query = "SELECT * FROM  office WHERE account_number like('$str_key%') ORDER BY account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $acc = $suggest['account_number'];
                    $id = $suggest['idOffice'];
	            echo "<u><a onclick=setOffice('$acc','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['office_name'].")</a></u></br>";
        	}
                
}
elseif (isset($_GET['key']) && ($_GET['key'] != '') && ($_GET['off']==1)) {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['key'];
                   	$suggest_query = "SELECT * FROM  office WHERE account_number like('$str_key%') AND office_selection= 'ripd' ORDER BY account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $acc = $suggest['account_number'];
                     $id = $suggest['idOffice'];
	            echo "<u><a onclick=setRipd('$acc','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['office_name'].")</a></u></br>";
        	}
                
}
elseif (isset($_GET['office'])) {
	//Add slashes to any quotes to avoid SQL problems.
	$offid = $_GET['office'];
                   $suggest_query = "SELECT * FROM  office WHERE idOffice= $offid";
	$reslt= mysql_query($suggest_query);
	$suggest = mysql_fetch_assoc($reslt);
                  $db_address = $suggest['office_details_address'];
        	echo $db_address;
}
elseif (isset($_GET['key']) && ($_GET['key'] != '') && isset($_GET['type'])) {
	$str_key = $_GET['key'];
                    $g_type = $_GET['type'];
                  $suggest_query = "SELECT * FROM  cfs_user,employee WHERE account_number like('$str_key%') AND user_type= '$g_type' AND cfs_user_idUser= idUser ORDER BY account_number";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $acc = $suggest['account_number'];
                    $name = $suggest['account_name'];
                    $mbl = $suggest['mobile'];
                    $eID = $suggest['idEmployee'];
	            echo "<u><a onclick=addToList('$acc','$name','$mbl','$eID'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $suggest['account_number'] . " (".$suggest['account_name'].")</a></u></br>";
        	}
                
}
elseif (isset($_GET['acc']) && isset($_GET['name'])) {
    if (!isset($_SESSION['arrPresenters']))
    {
     $_SESSION['arrPresenters'] = array();
     $_SESSION['arrProgram'] = array();
    }
    $g_acc = $_GET['acc'];
    $g_name = $_GET['name'];
    $g_mbl = $_GET['mbl'];
    $g_eid = $_GET['eID'];
    $arr_temp = array($g_acc,$g_name,$g_mbl);
    $_SESSION['arrPresenters'][$g_eid] = $arr_temp;
    $g_pname = $_GET['pname'];
    $g_offid = $_GET['parentid'];
    $g_offname = $_GET['offname'];
    $g_place = $_GET['place'];
    $g_pdate = $_GET['pdate'];
    $g_ptime = $_GET['ptime'];
    $arr_temp1 = array($g_pname,$g_offid,$g_offname,$g_place,$g_pdate,$g_ptime);
    $_SESSION['arrProgram'][0] = $arr_temp1;
}
elseif (isset($_GET['delete']) && isset($_GET['id'])) {
    $g_id = $_GET['id'];
    $g_url = urldecode($_GET['url']);
    unset($_SESSION['arrPresenters'][$g_id]);
    header("location: $g_url");
                
}
?>