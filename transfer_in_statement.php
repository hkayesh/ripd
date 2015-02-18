<?php
//include 'includes/session.inc';
include_once 'includes/header.php';
$userID = $_SESSION['userIDUser'];
$arr_trans =  array('sender'=>'প্রেরক','receiver'=>'প্রাপক','paid'=>'দেয়া হয়েছে','unpaid'=>'দেয়া হয়নি','transfer'=>'ট্রান্সফার করা হয়েছে','cancel'=>'বাতিল');

$sel_send_amount = $conn->prepare("SELECT * FROM acc_user_amount_transfer  JOIN cfs_user ON trans_senderid = idUser 
                                                                WHERE trans_type = 'transfer' AND trans_receiverid = ? ORDER BY trans_date_time");
$sel_selected_send_amount = $conn->prepare("SELECT * FROM acc_user_amount_transfer JOIN cfs_user ON trans_senderid = idUser
                                                                WHERE trans_type = 'transfer'
                                                                AND trans_receiverid = ? AND trans_date_time BETWEEN ? AND ? ORDER BY trans_date_time");
?>

<style type="text/css">@import "css/bush.css";</style>

<div class="main_text_box">
    <div style="padding-left: 112px;"><a href="personal_reporting.php"><b>ফিরে যান</b></a></div>
    <div>
        <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 80%;">          
            <tr><th style="text-align: center" colspan="2"><h1>ট্রান্সফার স্টেটমেন্ট</h1></th></tr>
                <tr>
                    <td id="noprint">
                        <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">সার্চ</legend>
                            <form method="POST" action="">	
                            <table>
                                <tr>
                                    <td style="padding-left: 0px; text-align: left;" ><b>শুরুর তারিখঃ</b></td>
                                    <td style="text-align: left"><input class="box" type="date" name="startDate" /></td>	 
                                    <td style="padding-left: 0px; text-align: left;"><b>শেষের তারিখঃ</b></td>
                                    <td style=" text-align: left"><input class="box" type="date" name="lastDate" /></td>
                                    <td style="padding-left: 50px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সার্চ" /></td>
                                </tr>
                            </table>
                           </form>
                        </fieldset>
                    </td> 
                </tr>
            <tr>
                <td>
                    <fieldset style="border: 3px solid #686c70 ; width: 99%;font-family: SolaimanLipi !important;">
                            <legend style="color: brown;font-size: 14px;">ট্রান্সফার স্টেটমেন্ট</legend>
                    <table style="margin: 0 auto;" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr id="table_row_odd">
                                <td width="7%" style="border: solid black 1px;"><div align="center"><strong>ক্রম</strong></div></td>
                                <td width="15%"  style="border: solid black 1px;"><div align="center"><strong>তারিখ</strong></div></td>
                                <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>প্রেরকের নাম</strong></div></td>
                                <td width="15%"  style="border: solid black 1px;"><div align="center"><strong>চার্জ মাধ্যম</strong></div></td>
                                <td width="15%"  style="border: solid black 1px;"><div align="center"><strong>চার্জ (টাকা)</strong></div></td>
                                <td width="15%" style="border: solid black 1px;"><div align="center"><strong>প্রেরিত এমাউন্ট (টাকা)</strong></div></td>
                                <td width="15%" style="border: solid black 1px;"><div align="center"><strong>প্রাপ্ত এমাউন্ট (টাকা)</strong></div></td>
                                <td width="15%" style="border: solid black 1px;"><div align="center"><strong>ট্রান্সফারের কারন</strong></div></td>
                            </tr>
                        </thead>
                        <tbody style="background-color: #FCFEFE">
                            <?php
                                    if(isset($_POST['submit']))
                                        {
                                            $slNo = 1;
                                            $p_startdate = $_POST['startDate'];
                                            $p_lastDate = $_POST['lastDate'];
                                            $sel_selected_send_amount->execute(array($userID,$p_startdate,$p_lastDate));
                                                $row1 = $sel_selected_send_amount->fetchAll();
                                                foreach ($row1 as $value) {
                                                $db_send_date = $value["trans_date_time"];
                                                $db_recver_name = $value["account_name"];
                                                $db_charger = $value["chrg_givenby"];
                                                $db_charge = $value["trans_servicecharge"];
                                                $db_send_amount = $value['trans_amount'];
                                                $db_status = $value['trans_purpose'];
                                                $db_get_amount = $value['reciever_get'];
                                                echo '<tr>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($slNo) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="left">' . english2bangla(date('d/m/Y',strtotime($db_send_date))) . '</div></td>';
                                                echo "<td  style='border: solid black 1px;'>".$db_recver_name."</td>";
                                                echo '<td  style="border: solid black 1px;"><div align="center">' .$arr_trans[$db_charger]. '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($db_charge) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($db_send_amount).'</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($db_get_amount).'</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.$db_status.'</div></td>';                                              
                                                echo '</tr>';
                                                $slNo++;
                                            }
                                        }
                                        else
                                        {          
                                            $slNo = 1;                                            
                                            $sel_send_amount->execute(array($userID));
                                                $row1 = $sel_send_amount->fetchAll();
                                                foreach ($row1 as $value) {
                                                $db_send_date = $value["trans_date_time"];
                                                $db_recver_name = $value["account_name"];
                                                $db_charger = $value["chrg_givenby"];
                                                $db_charge = $value["trans_servicecharge"];
                                                $db_send_amount = $value['trans_amount'];
                                                $db_status = $value['trans_purpose'];
                                                $db_get_amount = $value['reciever_get'];
                                                echo '<tr>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($slNo) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="left">' . english2bangla(date('d/m/Y',strtotime($db_send_date))) . '</div></td>';
                                                echo "<td  style='border: solid black 1px;'>".$db_recver_name."</td>";
                                                echo '<td  style="border: solid black 1px;"><div align="center">' .$arr_trans[$db_charger]. '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($db_charge) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($db_send_amount).'</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($db_get_amount).'</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">'.$db_status.'</div></td>';                                              
                                                echo '</tr>';
                                                $slNo++;
                                            }
                                        }
                            ?>
                        </tbody>
                    </table>
                   </fieldset>
                </td>
            </tr>
        </table>
    </div>
</div>   
<?php include_once 'includes/footer.php'; ?>