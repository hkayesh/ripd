<?php
error_reporting(0);
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$session_user_id = $_SESSION['userIDUser'];
$g_id= $_GET['id'];
$sql_select_cfs_user= $conn->prepare("SELECT account_name FROM cfs_user WHERE idUser = ?");
$sel_message = $conn->prepare("SELECT * FROM  send_message WHERE idmessage = ?");
$sql_update_notification = $conn->prepare("UPDATE send_message SET status='read' WHERE idmessage=?");

$sel_message->execute(array($g_id));
    $row = $sel_message->fetchAll();
    foreach ($row as $value) {
        $db_sender_id = $value['sender_id'];
        $db_msg = $value['msg'];
        $db_date = $value['sending_date'];
        $db_time = $value['sending_time'];
    }
    $sql_select_cfs_user->execute(array($db_sender_id));
    $row1 = $sql_select_cfs_user->fetchAll();
    foreach ($row1 as $value1) {
        $db_sender_name = $value1['account_name'];
    }
    $sql_update_notification->execute(array($g_id));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css"> @import "css/bush.css";</style>
</head>
    
<body>
    
    <table  class="formstyle" style="margin: 5px 10px 15px 10px; width: 100%; font-family: SolaimanLipi !important;">          
        <tr><th colspan="3" style="text-align: center;">আপনার ক্ষুদে বার্তা</th></tr>
            <tr>
                <td style="width: 20%"><b>প্রেরক</b></td>
                <td style="width: 1%">:</td>
                <td style="width: 55%"><?php echo $db_sender_name;?></td>                                      
            </tr>
        <tr>
                <td style="width: 20%"><b>তারিখ</b></td>
                <td style="width: 1%">:</td>
                <td style="width: 55%" ><?php echo english2bangla(date('d/m/Y',  strtotime($db_date))) ?></td>                                  
            </tr>
        <tr>
                <td style="width: 20%"><b>সময়</b></td>
                <td style="width: 1%">:</td>
                <td style="width: 55%"><?php echo english2bangla(date('h:i a',  strtotime($db_time))) ?></td>                                  
            </tr>
            <tr>
                <td><b>বার্তা</b></td>
                <td>:</td>
                <td><?php echo $db_msg;?></td>
            </tr>
    </table>
</body>
</html>

