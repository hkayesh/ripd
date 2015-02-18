<?php
//include 'includes/session.inc';
include_once 'includes/header.php';
$userID = $_SESSION['userIDUser'];

$sel_cash_in = $conn->prepare("SELECT * FROM acc_user_cheque WHERE cheque_makerid = ?
                                                            AND cheque_type='in' AND cheque_status='in_amount' ORDER BY cheque_mak_datetime");
$sel_selected_cash_in = $conn->prepare("SELECT * FROM acc_user_cheque WHERE cheque_makerid = ?
                                                                    AND cheque_type='in' AND cheque_status='in_amount' 
                                                                    AND cheque_mak_datetime BETWEEN ? AND ? ORDER BY cheque_mak_datetime");
?>

<style type="text/css">@import "css/bush.css";</style>

<div class="main_text_box">
    <div style="padding-left: 112px;"><a href="personal_reporting.php"><b>ফিরে যান</b></a></div>
    <div>
        <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 80%;">          
            <tr><th style="text-align: center" colspan="2"><h1>ক্যাশ ইন স্টেটমেন্ট</h1></th></tr>
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
                            <legend style="color: brown;font-size: 14px;">ক্যাশ ইন স্টেটমেন্ট</legend>
                    <table style="margin: 0 auto;" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr id="table_row_odd">
                                <td width="7%" style="border: solid black 1px;"><div align="center"><strong>ক্রম</strong></div></td>
                                <td width="15%"  style="border: solid black 1px;"><div align="center"><strong>ক্যাশ ইনের তারিখ</strong></div></td>
                                <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>চেক নাম্বার</strong></div></td>
                                <td width="15%"  style="border: solid black 1px;"><div align="center"><strong>ইনের পরিমান (টাকা)</strong></div></td>
                                <td width="15%"  style="border: solid black 1px;"><div align="center"><strong>ইনের কারন</strong></div></td>
                            </tr>
                        </thead>
                        <tbody style="background-color: #FCFEFE">
                            <?php
                                    if(isset($_POST['submit']))
                                        {
                                            $slNo = 1;
                                            $p_startdate = $_POST['startDate'];
                                            $p_lastDate = $_POST['lastDate'];
                                            $sel_selected_cash_in->execute(array($userID,$p_startdate,$p_lastDate));
                                                $row1 = $sel_selected_cash_in->fetchAll();
                                                foreach ($row1 as $value) {
                                               $db_date = $value["cheque_mak_datetime"];
                                                $db_cheque = $value["cheque_num"];
                                                $db_reason = $value["cheque_description"];
                                                $db_amount = $value["cheque_amount"];
                                                echo '<tr>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($slNo) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="left">' . english2bangla(date('d/m/Y',strtotime($db_date))) . '</div></td>';
                                                echo "<td  style='border: solid black 1px;'>".$db_cheque."</td>";
                                                echo '<td  style="border: solid black 1px;"><div align="center">' .english2bangla($db_amount). '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' .$db_reason. '</div></td>';                                          
                                                echo '</tr>';
                                                $slNo++;
                                            }
                                        }
                                        else
                                        {          
                                            $slNo = 1;                                            
                                            $sel_cash_in->execute(array($userID));
                                                $row1 = $sel_cash_in->fetchAll();
                                                foreach ($row1 as $value) {
                                                $db_date = $value["cheque_mak_datetime"];
                                                $db_cheque = $value["cheque_num"];
                                                $db_reason = $value["cheque_description"];
                                                $db_amount = $value["cheque_amount"];
                                                echo '<tr>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($slNo) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="left">' . english2bangla(date('d/m/Y',strtotime($db_date))) . '</div></td>';
                                                echo "<td  style='border: solid black 1px;'>".$db_cheque."</td>";
                                                echo '<td  style="border: solid black 1px;"><div align="center">' .english2bangla($db_amount). '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' .$db_reason. '</div></td>';                                          
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