<?php
//error_reporting(0);
include 'connectionPDO.php';
$g_qty = $_GET['qty'];
$g_inventoryID = $_GET['id'];

$sel_inventory = $conn->prepare("SELECT * FROM inventory WHERE idinventory = ?");
$result = $sel_inventory->execute(array($g_inventoryID));
$allrow = $sel_inventory->fetchAll();
foreach ($allrow  as $row)
{
    $available_qty = $row['ins_how_many'];
}
if($available_qty < $g_qty)
{
    echo 0;
}
else
{
    echo 1;
}

?>
