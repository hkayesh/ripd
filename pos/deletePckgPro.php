<?php
include 'includes/ConnectDB.inc';
if (isset($_GET['pckgcode']))
{
       $dltItem = $_GET['code'];
        $dlpckg = $_GET['pckgcode'];
       mysql_query("DELETE FROM package_temp WHERE pckg_code='$dlpckg' AND pckg_pro_code='$dltItem';") or exit("could not delete item");
       header("location: create_package.php");
}

?>
