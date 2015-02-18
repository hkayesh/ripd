<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
$loginUSERid = $_SESSION['userIDUser'];
$sql_update_notification = $conn->prepare("UPDATE notification SET nfc_status='read' WHERE idnotification=?");
?>

<title>নোটিফিকেশন</title>
<style type="text/css">@import "css/bush.css";</style>
 
 <div class="columnSubmodule" style="font-size: 14px;">
            <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;" cellspacing="0">        
                <tr>
                    <th colspan="3">নোটিফিকেশন</th>
                </tr>
                <tr id="table_row_odd">
                    <td style="width: 10%"><b><?php echo "ক্রম";?></b></td>
                    <td style="width: 70%"><b><?php echo "নোটিফিকেশন";?></b></td>
                    <td style="width: 20%"><b><?php echo "তারিখ";?></b></td>                   
                </tr>
                <tbody>
                    <?php        
                        $db_slNo = 1;
                        $catagory='personal';
                        $sel_personal_notification = $conn->prepare("SELECT * FROM notification WHERE nfc_receiverid = ? 
                            AND nfc_status !='complete' AND nfc_catagory =? ORDER BY nfc_date DESC");
                        $sel_personal_notification ->execute(array($loginUSERid,$catagory));
                        $notificationrow = $sel_personal_notification->fetchAll();
                        $countrow = count($notificationrow);
                        if($countrow == 0)
                        {
                            echo "<tr><td colspan = '3' style='color:red;text-align:center;'> এই মুহূর্তে আপনার কোন নোটিফিকেশন নেই</td></tr>";
                        }
                        else 
                        {
                            foreach ($notificationrow as $value)
                                 {
                                    $db_nfc_id = $value['idnotification'];
                                    $db_msg = $value['nfc_message'];
                                    $db_status = $value['nfc_status'];
                                    $db_date = $value['nfc_date'];
                                    if($db_status == 'unread')
                                    {
                                        echo "<tr style='background-color:#ffcc99'>";
                                    }
                                    else {
                                     echo "<tr>";   
                                    }
                                    echo "<td>".english2bangla($db_slNo)."</td>";
                                    echo "<td>$db_msg</td>";
                                    echo "<td>".  english2bangla(date('d/m/Y',  strtotime($db_date)))."</td>";
                                        $sql_update_notification->execute(array($db_nfc_id));
                                        echo "</tr>";
                                    $db_slNo++;
                                    }
                        }
                    ?>
                </tbody>          
            </table>
    </div>

<?php include_once 'includes/footer.php'; ?> 