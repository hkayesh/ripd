<?php
include_once 'includes/header.php';
$logedinOfficeId = $_SESSION['loggedInOfficeID'];
$logedinOfficeType = $_SESSION['loggedInOfficeType'];
$sql_update_notification = $conn->prepare("UPDATE notification SET nfc_status='read' WHERE idnotification=? ");
?>
<link rel="stylesheet" href="css/tinybox.css" type="text/css">
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
    function detailsNotice(url)
    { 
        TINY.box.show({url:url,width:550,height:200,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); 
    }
</script>
<div class="page_header_div">
    <div class="page_header_title">অফিসিয়াল নোটিফিকেশন</div>
</div>
<div>
    <table id="office_info_filter" border="1" align="center" width= 98%" cellpadding="5px" cellspacing="0px" style="margin-left: 10px;">
                    <thead>
                        <tr align="left" id="table_row_odd">
                            <th><?php echo "ক্রম";?></th>
                            <th><?php echo "নোটিফিকেশন";?></th>
                            <th><?php echo "করনীয়";?></th>                   
                        </tr>
                    </thead>
                    <tbody>
<?php        
                    $db_slNo = 1;
                    $catagory='official';
                    $sel_official_notification = $conn->prepare("SELECT * FROM ons_relation, notification WHERE catagory=? AND add_ons_id=?
                                                                                            AND idons_relation=nfc_receiverid AND nfc_status !='complete' AND nfc_catagory =?");
                    $sel_official_notification ->execute(array($logedinOfficeType,$logedinOfficeId,$catagory));
                    $notificationrow = $sel_official_notification->fetchAll();
                    $countrow = count($notificationrow);
                    if($countrow == 0)
                    {
                        echo "<tr><td colspan = '3' style='color:red;text-align:center;'> এই মুহূর্তে কোন অফিসিয়াল নোটিফিকেশন নেই</td></tr>";
                    }
                    else 
                    {
                        foreach ($notificationrow as $value)
                             {
                                $db_nfc_id = $value['idnotification'];
                                $db_msg = $value['nfc_message'];
                                $db_status = $value['nfc_status'];
                                $db_url = $value['nfc_actionurl'];
                                $db_type = $value['nfc_type'];
                                if($db_status == 'unread')
                                {
                                    echo "<tr style='background-color:#ffcc99'>";
                                }
                                else {
                                 echo "<tr>";   
                                }
                                echo "<td>".english2bangla($db_slNo)."</td>";
                                echo "<td>$db_msg</td>";
                                if($db_type == 'action')
                                {
                                    echo "<td><a href='notification_gateway.php?url=$db_url&nfcid=$db_nfc_id' ><b>দেখুন</b></a></td>";
                                }
                                else
                                {
                                    echo "<td><a onclick= detailsNotice('$db_url') style='cursor:pointer;' ><b><u>বিস্তারিত</u></b></a></td>";
                                    $sql_update_notification->execute(array($db_nfc_id));
                                }
                                echo "</tr>";
                                $db_slNo++;
                             }
                    }
?>
                    </tbody>
            </table>                        
            </div>

<?php include_once 'includes/footer.php';?>