<?php
//include 'includes/session.inc';
include_once 'includes/header.php';
$userID = $_SESSION['userIDUser'];

$sel_pv_in = $conn->prepare("SELECT * FROM cust_pv_child_date WHERE cust_own_id= ? ORDER BY date");
$sel_selected_pv_in = $conn->prepare("SELECT * FROM cust_pv_child_date WHERE cust_own_id= ?
                                                                    AND date BETWEEN ? AND ? ORDER BY date");

$sel_current_pv = $conn->prepare("SELECT pv_value FROM running_command");
$sel_current_pv->execute();
$arr_rslt = $sel_current_pv->fetchAll();
foreach ($arr_rslt as $value) {
    $running_pv = $value['pv_value'];
}
?>

<style type="text/css">@import "css/bush.css";</style>

<div class="main_text_box">
    <div style="padding-left: 112px;"><a href="personal_reporting.php"><b>ফিরে যান</b></a></div>
    <div>
        <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 80%;">          
            <tr><th style="text-align: center" colspan="2"><h1>পিভি আর্ন স্টেটমেন্ট</h1></th></tr>
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
                            <legend style="color: brown;font-size: 14px;">পিভি আর্ন স্টেটমেন্ট</legend>
                    <table style="margin: 0 auto;" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr id="table_row_odd">
                                <td width="7%" style="border: solid black 1px;"><div align="center"><strong>ক্রম</strong></div></td>
                                <td width="15%"  style="border: solid black 1px;"><div align="center"><strong>পিভি আর্নের তারিখ</strong></div></td>
                                <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>পিভির পরিমান</strong></div></td>
                                <td width="15%"  style="border: solid black 1px;"><div align="center"><strong>পিভির বর্তমান মূল্য (টাকা)</strong></div></td>
                            </tr>
                        </thead>
                        <tbody style="background-color: #FCFEFE">
                            <?php
                                    if(isset($_POST['submit']))
                                        {
                                            $slNo = 1;
                                            $total_pv_value = 0;
                                            $total_pv = 0;
                                            $p_startdate = $_POST['startDate'];
                                            $p_lastDate = $_POST['lastDate'];
                                            $sel_selected_pv_in->execute(array($userID,$p_startdate,$p_lastDate));
                                                $row1 = $sel_selected_pv_in->fetchAll();
                                                foreach ($row1 as $value) {
                                                $db_date = $value["date"];
                                                $pv_value = $value["cust_own_pv"] + $value["cust_c1"] + $value["cust_c2"] + $value["cust_c3"] + $value["cust_c4"] + $value["cust_c5"];
                                                $pv = $pv_value * $running_pv;
                                                echo '<tr>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($slNo) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="left">' . english2bangla(date('d/m/Y',strtotime($db_date))) . '</div></td>';
                                                echo "<td  style='border: solid black 1px;'>".english2bangla($pv)."</td>";
                                                echo '<td  style="border: solid black 1px;"><div align="right">' .english2bangla($pv_value). '</div></td>';                                   
                                                echo '</tr>';
                                                $total_pv_value+= $pv_value;
                                                $total_pv+= $pv;
                                                $slNo++;
                                            }
                                        }
                                        else
                                        {          
                                            $slNo = 1;
                                            $total_pv_value = 0;
                                            $total_pv = 0;
                                            $sel_pv_in->execute(array($userID));
                                                $row1 = $sel_pv_in->fetchAll();
                                                foreach ($row1 as $value) {
                                                $db_date = $value["date"];
                                                $pv_value = $value["cust_own_pv"] + $value["cust_c1"] + $value["cust_c2"] + $value["cust_c3"] + $value["cust_c4"] + $value["cust_c5"];
                                                $pv = $pv_value * $running_pv;
                                                echo '<tr>';
                                                echo '<td  style="border: solid black 1px;"><div align="center">' . english2bangla($slNo) . '</div></td>';
                                                echo '<td  style="border: solid black 1px;"><div align="left">' . english2bangla(date('d/m/Y',strtotime($db_date))) . '</div></td>';
                                                echo "<td  style='border: solid black 1px;'>".english2bangla($pv)."</td>";
                                                echo '<td  style="border: solid black 1px;"><div align="right">' .english2bangla($pv_value). '</div></td>';                                   
                                                echo '</tr>';
                                               $total_pv_value+= $pv_value;
                                               $total_pv+= $pv;
                                                $slNo++;
                                            }
                                        }
                                        echo "<tr>
                                                <td colspan='2' style='text-align:right;border: solid black 1px;'><b>মোট</b></td>
                                                <td style='text-align:left;border: solid black 1px;'>".english2bangla($total_pv)." পিভি</td>
                                                <td style='text-align:right;border: solid black 1px;'>".english2bangla($total_pv_value)." টাকা</td>
                                                </tr>";
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