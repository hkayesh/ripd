<?php
include_once './includes/connectionPDO.php';
include_once './includes/updateQueryPDO.php';
$status = 'read';
$g_url = $_GET['url'];
$g_nfcid = $_GET['nfcid'];
$sql_update_notification->execute(array($status,$g_nfcid));

header("location:$g_url&nfcid=$g_nfcid");

?>
