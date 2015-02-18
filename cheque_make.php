<?php
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
?>
<?php

function convert_number($number) {
    if (($number < 0) || ($number > 999999999)) {
        throw new Exception("Number is out of range");
    }

    $Gn = floor($number / 100000);  /* Millions (giga) */
    $number -= $Gn * 100000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10;               /* Ones */

    $res = "";

    if ($Gn) {
        $res .= convert_number($Gn) . " Lac";
    }

    if ($kn) {
        $res .= (empty($res) ? " " : " ") .
                convert_number($kn) . " Thousand";
    }

    if ($Hn) {
        $res .= (empty($res) ? " " : " ") .
                convert_number($Hn) . " Hundrad";
    }

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");

    if ($Dn || $n) {
        if (!empty($res)) {
            $res .= " and ";
        }

        if ($Dn < 2) {
            $res .= $ones[$Dn * 10 + $n];
        } else {
            $res .= $tens[$Dn];

            if ($n) {
                $res .= "-" . $ones[$n];
            }
        }
    }
    if (empty($res)) {
        $res = "zero";
    }

    return $res;
}

function showOffices($inp_offID, $inp_mainCheque) {
    echo "<table cellpadding=2 cellspacing=0 style='background-color:#CCCCCC; border: black solid 1px; width: 90%; margin: 0 auto;'><tr style='background-color:#0883FF;' >";
    echo "<td style='border: black solid 1px;'>অফিসের নাম</td>";
    echo "<td style='border: black solid 1px;'>অফিসের অ্যাকাউন্ট নাম্বার</td>";
    echo "<td style='border: black solid 1px;'>অফিস চেক দেখুন</td>";
    echo "<tr>";
    foreach ($inp_offID as $ID) {
        $psql = "SELECT * FROM office WHERE idOffice = $ID ";
        $result = mysql_query($psql) or exit('query failed?????: ' . mysql_error());
        $row = mysql_fetch_assoc($result);
        $off_name = $row['office_name'];
        $off_no = $row['account_number'];
        echo "<tr>";
        echo "<td style='border-bottom: black solid 1px;border-right: black solid 1px;'>$off_name</td>";
        echo "<td style='border-bottom: black solid 1px;border-right: black solid 1px;'>$off_no</td>";
        echo '<td style="border-bottom: black solid 1px;"><a href="" onclick="openCheque(' . $ID . ',\' ' . $inp_mainCheque . '\');return false;">চেক দেখুন</a></td>';
        echo "</tr>";
    }
    echo "</table>";
}
?>
<?php
if (isset($_POST['make_cheque'])) {
    $P_in_type = $_POST['in_type'];
    $str_checque_no = $P_in_type;
    for ($i = 0; $i < 4; $i++) {
        $str_random_no = (string) mt_rand(0, 9999);
        $str_cheque = str_pad($str_random_no, 4, "0", STR_PAD_LEFT);
        $str_checque_no = $str_checque_no . "-" . $str_cheque;
    }
    $P_totalTaka = $_POST['t_in_amount'];
    $totalTaka_inWords = convert_number($P_totalTaka);
    $P_arr_checkbox = $_POST['chkName'];
}
?>
<style type="text/css"> @import "css/bush.css";</style>
<link href="css/print.css" rel="stylesheet" type="text/css" media="print"/>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div id="noprint" style="padding-left: 110px;"><a href="cheque_making_for_in.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="" name="cheque" action="">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;">চেক মেইকিং ফর ইন</th></tr>
                    <tr>
                        <td>
                            <div id="cheque" style="width: 574px; height: 280px; border: blue solid 2px; margin: 0 auto; background-color:ghostwhite;">
                                <div style="width: 558px;height: 70px;float: left;padding-left: 15px; background-image: url(images/background.gif);background-repeat: no-repeat;background-size:100% 70px;"></div>
                                <div id="cheque_body" style=" width: 570px;float: left;padding-left: 2px;">
                                    <div style="width: 570px;float: left;">
                                        <div id="cheque_dateTime" style="text-align:left; width: 280px;float: left">তারিখঃ <?php echo date("d.m.y"); ?>&nbsp;&nbsp;&nbsp;&nbsp;সময়ঃ <?php print date('g:i a', strtotime('+4 hour')) ?></div>
                                        <div id="cheque_no" style="text-align: right;width: 290px;float: left;">চেক নাম্বার : <input type="text" readonly="" style="width: 200px;" value="<?php echo $str_checque_no; ?>" /></div>
                                    </div></br></br>
                                    <div style="text-align: right;"><span>টাকার পরিমাণ : <input type="text" readonly="" style="width:200px;" value="<?php echo $P_totalTaka; ?>" />TK</span></div>
                                    <div id="amount_in_words"><span>টাকার পরিমাণ (কথায়) :</span><?php echo $totalTaka_inWords; ?> Taka only.</div></br>
                                    <div><span>অ্যাকাউন্টধারীর অ্যাকাউন্ট নং  : </span><input type="text" readonly width="400px" /></div>
                                    <div style="float: right;height: 20px;padding-top: 10px;text-align: right;"><input type="text" readonly width="200px" /><hr style="width:230px; height: 2px; background-color: black;"/> এখানে স্বাক্ষর করুন&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                </div>
                            </div></br>
                        </td>   
                    </tr>
                    <tr>
                        <td id="noprint">
                            <span style="padding-left: 33px;"><b>যে সকল অফিসের ফান্ডে টাকা ইন করা হলঃ </b></span></br>
                            <div id="selectedOffice"><?php showOffices($P_arr_checkbox, $str_checque_no); ?></div>
                        </td>
                    </tr>
                    <tr>                    
                        <td id="noprint" colspan="2" style="padding-left: 280px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="save_cheque" value="সেভ এন্ড প্রিন্ট " /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<script>
    function openCheque(ID,mainNo) 
    { window.open("view_cheque.php?id="+ID+"&maincheque="+mainNo);}  
</script>

<?php
include 'includes/footer.php';
?>