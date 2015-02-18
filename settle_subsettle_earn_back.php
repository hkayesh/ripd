<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
?>
<?php
$msgedit = $_GET['editmsg'];
$flagedit = $_GET['editflag'];

function showEditMessage($flagedit, $msgedit) {
    if (!empty($msgedit)) {
        if ($msgedit == '2') {
            $showEditMsg = "এমাউন্টটি সফলভাবে পরিবর্তন হয়েছে";
        } elseif ($msgedit == '3') {
            $showEditMsg = "এমাউন্টটি সফলভাবে স্থগিত হয়েছে";
        } elseif ($msgedit == '4') {
            $showEditMsg = "এমাউন্টটি সফলভাবে পুনরায় চালু হয়েছে";
        } else {
            $showEditMsg = "দুঃখিত, আবার চেষ্টা করুন";
        }
        if ($flagedit == '2') {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:15px;">' . $showEditMsg . '</b></td></tr>';
        } else {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:15px;"><blink>' . $showEditMsg . '</blink></b></td></tr>';
        }
    }
}

function showMessage($flag, $msg) {
    if (!empty($msg)) {
        if ($flag == 'true') {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:15px;">' . $msg . '</b></td></tr>';
        } else {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:15px;"><blink>' . $msg . '</blink></b></td></tr>';
        }
    }
}
?>
<title>সেটল সাব-সেটল আর্ন</title>
<style type="text/css"> @import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<script>
    var fieldName='chkName[]';
    function numbersonly(e)
    {
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8)
        { //if the key isn't the backspace key (which we should allow)
            if (unicode<48||unicode>57) //if not a number
                return false //disable key press
        }
    }


    function checkIt(evt) {
        evt = (evt) ? evt : window.event
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
            status = ""
            return true
        }
        status = "This field accepts numbers only."
        return false
    }
</script>

<?php
//$rowEntry = mysql_query("SELECT * FROM charge");
//$rowNumber = mysql_num_rows($rowEntry);
//$selectCharge = mysql_query("Select * from charge");
//$rows_selected_charge = mysql_num_rows($selectCharge);
if (isset($_POST['submit']) && ($_GET['action'] == 'new')) {

    $new_charge_criteria_name = $_POST['charge_criteria_name'];
    $new_charge_amount = $_POST['charge_amount'];
    $new_charge_status = "Active";
    $newChargeInsert = "INSERT INTO charge (charge_criteria ,charge_amount ,charge_status) values('$new_charge_criteria_name', '$new_charge_amount', '$new_charge_status')";

    if (mysql_query($newChargeInsert)) {
        $msg = "আপনি সফলভাবে " . $new_charge_criteria_name . " নামে নতুন চার্জটি তৈরি করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
    header("Location:charge_making.php");
}
?>      
<div style="padding-top: 10px;">    
    <div style="padding-left: 110px; width: 65%;"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
</div>
<div>
    <table  class='formstyle' style='font-family: SolaimanLipi !important; width: 78%;'>          
        <tr><th colspan='3' style='text-align: center;'>সেটল সাব-সেটল আর্ন</th></tr>
        <tr><form method='POST' onsubmit='' name='' action='edit_charge.php'>
            <td style="width: 25%; text-align: right">কাস্টমার সেটল আর্ন এমাউন্ট</td>
            <td style="width: 30%">: <input class="box" type="text" id="instalment_period" name="instalment_period" /> টাকা</td>
            <td style="width: 45%"><input class='btn' type='submit' id='edit' name='edit' value='পরিবর্তন' style='background: #0099A1 !important;height: 20px !important;width: 100px;'/>
                <input class='btn' type='submit' id='postpond' name='postpond' value='স্থগিত' style='background: red !important;height: 20px !important;width: 100px;'/>
                <input class='btn' type='submit' id='restart' name='restart' value='রিস্টার্ট' style='background: gray !important;height: 20px !important;width: 100px;' disabled='true'/>
            </td>
        </form></tr>


        <tr><form method='POST' onsubmit='' name='' action='edit_charge.php'>
            <td style="width: 25%; text-align: right">অফিস সেটল আর্ন এমাউন্ট</td>
            <td style="width: 30%">: <input class="box" type="text" id="instalment_period" name="instalment_period" /> টাকা</td>
            <td style="width: 45%"><input class='btn' type='submit' id='edit' name='edit' value='পরিবর্তন' style='background: #0099A1 !important;height: 20px !important;width: 100px;'/>
                <input class='btn' type='submit' id='postpond' name='postpond' value='স্থগিত' style='background: red !important;height: 20px !important;width: 100px;'/>
                <input class='btn' type='submit' id='restart' name='restart' value='রিস্টার্ট' style='background: gray !important;height: 20px !important;width: 100px;' disabled='true'/>
            </td>
        </form></tr>
        
        <tr><form method='POST' onsubmit='' name='' action='edit_charge.php'>
            <td style="width: 25%; text-align: right">সেলস স্টোর সেটল আর্ন এমাউন্ট</td>
            <td style="width: 30%">: <input class="box" type="text" id="instalment_period" name="instalment_period" /> টাকা</td>
            <td style="width: 45%"><input class='btn' type='submit' id='edit' name='edit' value='পরিবর্তন' style='background: #0099A1 !important;height: 20px !important;width: 100px;'/>
                <input class='btn' type='submit' id='postpond' name='postpond' value='স্থগিত' style='background: red !important;height: 20px !important;width: 100px;'/>
                <input class='btn' type='submit' id='restart' name='restart' value='রিস্টার্ট' style='background: gray !important;height: 20px !important;width: 100px;' disabled='true'/>
            </td>
        </form></tr>
        
        <tr><form method='POST' onsubmit='' name='' action='edit_charge.php'>
            <td style="width: 25%; text-align: right">কাস্টমার সাব-সেটল আর্ন এমাউন্ট</td>
            <td style="width: 30%">: <input class="box" type="text" id="instalment_period" name="instalment_period" /> টাকা</td>
            <td style="width: 45%"><input class='btn' type='submit' id='edit' name='edit' value='পরিবর্তন' style='background: #0099A1 !important;height: 20px !important;width: 100px;'/>
                <input class='btn' type='submit' id='postpond' name='postpond' value='স্থগিত' style='background: red !important;height: 20px !important;width: 100px;'/>
                <input class='btn' type='submit' id='restart' name='restart' value='রিস্টার্ট' style='background: gray !important;height: 20px !important;width: 100px;' disabled='true'/>
            </td>
        </form></tr>

    </table>
</div>
<?php
include_once 'includes/footer.php';
?>