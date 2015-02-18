<?php
error_reporting(0);
include 'connectionPDO.php';
if($_GET['type']=='cust')
{
    $G_account = $_GET['acno'];
    $sql = "SELECT * FROM cfs_user WHERE account_number = ? AND cfs_account_status = 'active' ";
    $selectstmt = $conn ->prepare($sql);
    $selectstmt->execute(array($G_account));
    $all = $selectstmt->fetchAll();
    foreach($all as $row)
    {echo $row['account_name'];} 
}
elseif($_GET['type']=='emp')
{
    $G_account = $_GET['acno'];
    $sql = "SELECT * FROM cfs_user WHERE account_number = ? AND cfs_account_status = 'active' ";
    $selectstmt = $conn ->prepare($sql);
    $selectstmt->execute(array($G_account));
    $all = $selectstmt->fetchAll();
    foreach($all as $row)
    {echo $row['account_name'];}
}
elseif($_GET['type']=='store')
{
    $G_account = $_GET['acno'];
    $sql = "SELECT * FROM sales_store WHERE account_number = ? ";
    $selectstmt = $conn ->prepare($sql);
    $selectstmt->execute(array($G_account));
    $all = $selectstmt->fetchAll();
    foreach($all as $row)
    {echo $row['salesStore_name'];}
}
elseif($_GET['type']=='off')
{
    $G_account = $_GET['acno'];
    $sql = "SELECT * FROM office WHERE account_number = ? ";
    $selectstmt = $conn ->prepare($sql);
    $selectstmt->execute(array($G_account));
    $all = $selectstmt->fetchAll();
    foreach($all as $row)
    {echo $row['office_name'];}
}
elseif(isset ($_GET['AcNo']))
{
    $g_accountNo = $_GET['AcNo'];
    $selectstmt1 = $conn ->prepare("SELECT * FROM cfs_user, acc_user_balance WHERE cfs_user_iduser= idUser AND account_number = ? ");
    $selectstmt1->execute(array($g_accountNo));
    $all1 = $selectstmt1->fetchAll();
    foreach($all1 as $row)
    {
        $db_balance = $row['total_balanace'];
        echo $db_balance;
    }
}

?>
