<?php

error_reporting(0);
include_once 'ConnectDB.inc';
if (isset($_GET['key']) && $_GET['key'] != '') {

    $location = $_GET['location'];
    $suggest_array = array();
    $reslt = mysql_query("SELECT idUser, account_number FROM cfs_user ORDER BY account_number");
    if (mysql_num_rows($reslt) < 1) {
        echo "দুঃখিত, এই নাম্বারের কোনো একাউন্ট নেই";
    }
    while ($suggest = mysql_fetch_assoc($reslt))
        $suggest_array[] = $suggest;

    $findme = $_GET['key'];
    $loop = 0;
        //print_r($suggest_array);
    foreach ($suggest_array as $k => $v) {
        //echo "id=" . $v['1'] . " number: " .$v['account_number']."<br />";
        if (stripos($v['account_number'], $findme) !== false) {
            echo "<a style='text-decoration:none;color:brown;'href=" . $location . "?id=" . $v['idUser'] . ">" . $v['account_number'] . "</a></br>";
            //echo "id={$v[id]} text={$v[text]}<br />"; // do something $newdata=array($v[id]=>$v[text])
        }
        $loop += 1;
    }
}
?>
