<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
$loginUSERid = $_SESSION['userIDUser'];

$sql_select_cfs_user= $conn->prepare("SELECT account_name FROM cfs_user WHERE idUser = ?");
$sel_personal_notification = $conn->prepare("SELECT * FROM send_message WHERE receiver_id = ? 
                                                                         ORDER BY sending_date,sending_time DESC LIMIT 10");
$sel_personal_notification_selected = $conn->prepare("SELECT * FROM send_message WHERE receiver_id = ? 
                                                                        AND sending_date BETWEEN ? AND ? ORDER BY sending_date,sending_time DESC LIMIT 10");
?>

<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
    function send_message()
    {
        TINY.box.show({iframe:'send_message.php',width:650,height:300,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'});
    }
    function message_details(id)
    {
        TINY.box.show({iframe:'show_message.php?id='+id,width:650,height:300,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'});
    }
</script>
 
 <div class="columnSubmodule" style="font-size: 14px;">
            <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;" cellspacing="0">        
                <tr><th colspan="3">ক্ষুদে বার্তা</th></tr>
                <tr>
                    <td colspan="2">
                            <fieldset style="border: #686c70 solid 3px;width: 98%;margin-left:1%;">
                                <legend style="color: brown">সার্চ</legend>
                                <form method="POST"  action="">	
                                <table>
                                    <tr>
                                        <td><b>শুরু :</b><input class="box" type="date" name="startdate" /></td>
                                        <td><b>শেষ :</b><input class="box" type="date" name="enddate" /></td>
                                        <td><input class="btn" style="width: 50px;" type="submit" name="submit" value="সার্চ" /></td>
                                    </tr>
                                </table>
                                </form>
                            </fieldset>
                        </td>
                        <td style="text-align: center;"><a onclick="send_message();" style="cursor: pointer;"><img src="images/mail_send.png" style="width: 50px;height: 50px;" /><br/><font style="color:green"><b>বার্তা পাঠান</b></font></a></td>
                </tr>
                <tr><td colspan="3" style="text-align: center"><br/><font style="color: green;"><b>প্রাপ্ত ক্ষুদে বার্তা</b></font><hr><br/></td></tr>
                <tr id="table_row_odd">
                    <td style="width: 20%;border-bottom:1px solid black"><b><?php echo "প্রেরক";?></b></td>
                    <td style="width: 60%;text-align: center;border-bottom:1px solid black"><b><?php echo "বার্তা";?></b></td>               
                    <td style="width: 20%;text-align: center;border-bottom:1px solid black"><b><?php echo "তারিখ";?></b></td>
                            
                </tr>
                <tbody>
                    <?php
                    if(isset($_POST['submit']))
                    {
                       $startdate = $_POST['startdate'];
                       $enddate = $_POST['enddate'];
                        $sel_personal_notification_selected ->execute(array($loginUSERid,$startdate,$enddate));
                        $notificationrow = $sel_personal_notification_selected->fetchAll();
                        $countrow = count($notificationrow);
                        if($countrow == 0)
                        {
                            echo "<tr><td colspan = '3' style='color:red;text-align:center;'> আপনার জন্য কোন বার্তা নেই</td></tr>";
                        }
                        else 
                        {
                            foreach ($notificationrow as $value)
                                 {
                                    $db_nfc_id = $value['idmessage'];
                                    $db_sender_id = $value['sender_id'];
                                    $db_status = $value['status'];
                                    $sql_select_cfs_user->execute(array($db_sender_id));
                                    $row = $sql_select_cfs_user->fetchAll();
                                    foreach ($row as $value1) {
                                        $db_sender_name = $value1['account_name'];
                                    }
                                    $db_msg = $value['msg'];
                                    $rest = $rest = substr($db_msg, 0,50); 
                                    $db_date = $value['sending_date'];
                                    if($db_status == 'send')
                                    {
                                        echo "<tr style='background-color:#ffcc99'>";
                                    }
                                    else {
                                     echo "<tr>";   
                                    } 
                                     echo "<td style=';border-bottom:1px solid black'>$db_sender_name</td>";
                                    echo "<td style='border-bottom:1px solid black'><a onclick=message_details(".$db_nfc_id.") style='cursor:pointer;' >$rest ...</a></td>";                                 
                                    echo "<td style='text-align: center;border-bottom:1px solid black'>".english2bangla(date('d/m/Y', strtotime($db_date)))."</td>";
                                    echo "</tr>";
                                  }
                        }
                    }
                    else
                    {
                        $sel_personal_notification ->execute(array($loginUSERid));
                        $notificationrow = $sel_personal_notification->fetchAll();
                        $countrow = count($notificationrow);
                        if($countrow == 0)
                        {
                            echo "<tr><td colspan = '3' style='color:red;text-align:center;'> এই মুহূর্তে আপনার জন্য কোন বার্তা নেই</td></tr>";
                        }
                        else 
                        {
                            foreach ($notificationrow as $value)
                                 {
                                    $db_nfc_id = $value['idmessage'];
                                    $db_sender_id = $value['sender_id'];
                                    $db_status = $value['status'];
                                    $sql_select_cfs_user->execute(array($db_sender_id));
                                    $row = $sql_select_cfs_user->fetchAll();
                                    foreach ($row as $value1) {
                                        $db_sender_name = $value1['account_name'];
                                    }
                                    $db_msg = $value['msg'];
                                    $rest = $rest = substr($db_msg, 0,50); 
                                    $db_date = $value['sending_date'];
                                    if($db_status == 'send')
                                    {
                                        echo "<tr style='background-color:#ffcc99'>";
                                    }
                                    else {
                                     echo "<tr>";   
                                    }
                                    echo "<td style='border-bottom:1px solid black'>$db_sender_name</td>";            
                                    echo "<td style='border-bottom:1px solid black'><a onclick=message_details(".$db_nfc_id.") style='cursor:pointer;' >$rest...</a></td>";
                                    echo "<td style='text-align: center;border-bottom:1px solid black'>".english2bangla(date('d/m/Y', strtotime($db_date)))."</td>";
                                    echo "</tr>";
                                  }
                        }
                    }
                        
                    ?>
                </tbody>          
            </table>
    </div>
<?php include_once 'includes/footer.php'; ?> 