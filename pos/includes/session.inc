<?php
error_reporting(0);
include 'ConnectDB.inc';
$current_page_name = basename($_SERVER["SCRIPT_NAME"]);
$sql = "select * FROM " . $dbname . ".page_security WHERE page_name='$current_page_name'";
$rs = mysql_query($sql);
if (mysql_num_rows($rs) != 1) {
    //echo "403--Access Denied";
    header('Location: index.php?apps=NoAccess');
    exit();
} else {
    $row = mysql_fetch_array($rs);
    $current_page_number = $row['idPage_security'];

    if (!in_array($current_page_number, $_SESSION['overallAccess'])) {
        header('Location: index.php?apps=NoAccess');
        exit();
    }
}
/*
  if (mysql_num_rows($rs) == 1) {
  $row = mysql_fetch_array($rs);
  $current_page_number = $row['idPage_security'];

  if (in_array($current_page_number, $_SESSION['overallAccess'])) {
  echo "Show page";
  } else {
  echo "403--Access Denied";
  exit();
  }
  } else {
  //echo "<pre>";
  //print_r($row);
  //echo "</pre>";
  //echo "<pre>";
  //echo $_SESSION;
  //print_r($_SESSION['overallAccess']);
  //echo "</pre>";
  //echo $current_page_number;
  echo "403--Access denied!!!!";
  exit();
  }
 */
?>