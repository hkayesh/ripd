<?php
include_once 'includes/header.php';
include_once 'includes/showTables.php';
$userID = $_SESSION['userIDUser'];

$sel_pv_in = $conn->prepare("SELECT * FROM cust_pv_child_date WHERE cust_own_id= ? ORDER BY date");
$sel_current_pv = $conn->prepare("SELECT pv_value FROM running_command");
$sel_current_pv->execute();
$arr_rslt = $sel_current_pv->fetchAll();
foreach ($arr_rslt as $value) {
    $running_pv = $value['pv_value'];
}
?>
<style type="text/css">@import "css/bush.css";</style>

<div class="main_text_box" >
    <div style="padding-left: 80px;"><a href="personal_reporting.php"><b>ফিরে যান</b></a></div>
    <div>           
            <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 90%; margin-left: 80px">          
                <tr><th style="text-align: center" colspan="2"><h1>টোটাল বায়িং ডেসক্রিপশন উইথ রেফারার পিভি</h1></th></tr>
                <?php
                if ($msg != "") {
                    echo '<tr><td colspan="2" style="text-align: center;font-size: 16px;color: green;">' . $msg . '</td></tr>';
                }
                ?>             
                <tr>
                    <td>
                        <fieldset   style="border: 3px solid #686c70 ; width: 99%;font-family: SolaimanLipi !important;">
                            <legend style="color: brown;font-size: 14px;">টোটাল বায়িং ডেসক্রিপশন উইথ রেফারার পিভি</legend>
                                <table style="width: 98%;margin: 0 auto;" cellspacing="0" cellpadding="0">         
                                    <thead>
                                        <tr align="left" id="table_row_odd">
                                            <td style="border: solid black 1px;">তারিখ</td>
                                            <td colspan="2" style="border: solid black 1px;">ব্যাক্তিগত ক্রয়</td>
                                            <td colspan="2" style="border: solid black 1px;">R1</td>
                                            <td colspan="2" style="border: solid black 1px;">R2</td>
                                            <td colspan="2" style="border: solid black 1px;">R3</td>
                                            <td colspan="2" style="border: solid black 1px;">R4</td>
                                            <td colspan="2" style="border: solid black 1px;">R5</td>
                                            <td colspan="2" style="border: solid black 1px;">মোট</td>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td style="border: solid black 1px;"></td>
                                        <td style="border: solid black 1px;">পিভি</td>
                                        <td style="border: solid black 1px;">টাকা</td>
                                        <td style="border: solid black 1px;">পিভি</td>
                                        <td style="border: solid black 1px;">টাকা</td>
                                        <td style="border: solid black 1px;">পিভি</td>
                                        <td style="border: solid black 1px;">টাকা</td>
                                        <td style="border: solid black 1px;">পিভি</td>
                                        <td style="border: solid black 1px;">টাকা</td>
                                        <td style="border: solid black 1px;">পিভি</td>
                                        <td style="border: solid black 1px;">টাকা</td>
                                        <td style="border: solid black 1px;">পিভি</td>
                                        <td style="border: solid black 1px;">টাকা</td>
                                        <td style="border: solid black 1px;">পিভি</td>
                                        <td style="border: solid black 1px;">টাকা</td>
                                    </tr>
                                    <?php       
                                            $total_pv_value = 0;
                                            $total_pv = 0;
                                            $sel_pv_in->execute(array($userID));
                                                $row1 = $sel_pv_in->fetchAll();
                                                foreach ($row1 as $value) {
                                                $db_date = $value["date"];
                                                $pv_value = $value["cust_own_pv"] + $value["cust_c1"] + $value["cust_c2"] + $value["cust_c3"] + $value["cust_c4"] + $value["cust_c5"];
                                                $pv = $pv_value * $running_pv;
                                                echo '<tr>';
                                                echo '<td style="border: solid black 1px;">'.  english2bangla(date("d/m/Y",  strtotime($db_date))).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round((($value["cust_own_pv"])*$running_pv),4)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round(($value["cust_own_pv"]),2)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round((($value["cust_c1"])*$running_pv),4)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round(($value["cust_c1"]),2)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round((($value["cust_c2"])*$running_pv),4)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round(($value["cust_c2"]),2)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round((($value["cust_c3"])*$running_pv),4)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round(($value["cust_c3"]),2)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round((($value["cust_c4"])*$running_pv),4)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round(($value["cust_c4"]),2)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round((($value["cust_c5"])*$running_pv),4)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round(($value["cust_c5"]),2)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round($pv,4)).'</td>
                                                        <td style="border: solid black 1px;">'.english2bangla(round($pv_value,2)).'</td>';                                   
                                                echo '</tr>';
                                               $total_pv_value+= $pv_value;
                                               $total_pv+= $pv;
                                            }
                                    ?>
                                    <tr>
                                        <td colspan="13" style="text-align: right">সর্বমোট</td>
                                        <td style="border: solid black 1px;"><?php echo english2bangla(round($total_pv,4));?></td>
                                        <td style="border: solid black 1px;"><?php echo english2bangla(round($total_pv_value,2));?></td>
                                    </tr>
                                </table>
                        </fieldset>
                    </td>
                </tr>
            </table>
    </div>
</div>   
<?php include_once 'includes/footer.php'; ?>