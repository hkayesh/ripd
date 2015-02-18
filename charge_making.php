<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
?>
<script>
function confirmFunction(name)
{ 
return confirm("Do you want to -" + name + "- this charge?");
}
</script>
<?php
$msgedit = $_GET['editmsg'];
$flagedit = $_GET['editflag'];
//echo "MSG: ".$msgedit. " Flag : ".$flagedit;

function showEditMessage($flagedit, $msgedit) {
    if (!empty($msgedit)) {
        if($msgedit=='2'){
            $showEditMsg = "চার্জটি সফলভাবে পরিবর্তন হয়েছে";
        }elseif ($msgedit=='3') {
            $showEditMsg = "চার্জটি সফলভাবে স্থগিত হয়েছে";
        }elseif ($msgedit=='4') {
            $showEditMsg = "চার্জটি সফলভাবে পুনরায় চালু হয়েছে";
        }  else {
            $showEditMsg = "দুঃখিত, আবার চেষ্টা করুন";
        }
        if ($flagedit == '2') {
            echo '<tr><td colspan="3" height="30px" style="text-align:center;"><b><span style="color:green;font-size:15px;">' . $showEditMsg . '</b></td></tr>';
        } else {
            echo '<tr><td colspan="3" height="30px" style="text-align:center;"><b><span style="color:red;font-size:15px;"><blink>' . $showEditMsg . '</blink></b></td></tr>';
        }
    }
}
?>
<title>চার্জ পরিবর্তন</title>
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

    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 100%;"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
        <div></div>
    </div>
    <div>
        <table  class='formstyle' style='font-family: SolaimanLipi !important; width: 78%;'>          
            <tr><th colspan='3' style='text-align: center;'>চার্জ তালিকা</th></tr>
            <?php 
            showEditMessage($flagedit, $msgedit);
            ?>
            <?php
            $selectCharge = mysql_query("Select * from charge");
            while ($selectChargeRow = mysql_fetch_array($selectCharge)) {
                $db_charge_id_selected = $selectChargeRow['idcharge'];
                $db_charge_name_selected = $selectChargeRow['charge_name'];
                $db_charge_type_selected = $selectChargeRow['charge_type'];
                $db_charge_amount_selected = $selectChargeRow['charge_amount'];
                $db_charge_status_selected = $selectChargeRow['charge_status'];
                if($db_charge_type_selected=='fixed'){
                    $charege_type = 'টাকা';
                }else{
                    $charege_type = '%';
                }
                echo "<form method='POST' name='' action='includes/edit_charge.php' onsubmit=''>";
                echo " <tr>
                        <td style='width:30%; text-align:left;padding-left:5%;'><b>$db_charge_name_selected</b></td>
                            <input type='hidden' id='charge_criteria_id' name='charge_criteria_id' value='$db_charge_id_selected'/>";

                if ($db_charge_status_selected == 'active') {
                    echo"<td>: <input class='box5' type='text' id='charge_criteria_amount' name='charge_criteria_amount' value='$db_charge_amount_selected'/> $charege_type</td><td>
                                  <input class='btn' type='submit' id='edit' name='edit' value='পরিবর্তন' style='background: #0099A1 !important;height: 20px !important;width: 100px;' onclick='return confirmFunction(\"Edit\")'/>
                                  <input class='btn' type='submit' id='postpond' name='postpond' value='স্থগিত' style='background: red !important;height: 20px !important;width: 100px;' onclick='return confirmFunction(\"Postpond\")'/>
                                  <input class='btn' type='submit' id='restart' name='restart' value='রিস্টার্ট' style='background: gray !important;height: 20px !important;width: 100px;' disablaed='true'/>";
                } else {
                    echo"<td>: <input class='box5' type='text' id='charge_criteria_amount' name='charge_criteria_amount' value='$db_charge_amount_selected' disabled='true' /> $charege_type</td><td>
                                    <input class='btn' type='submit' id='edit' name='edit' value='পরিবর্তন' style='background: gray !important;height: 20px !important;width: 100px;' disabled='true'/>
                                    <input class='btn' type='submit' id='postpond' name='postpond' value='স্থগিত' style='background: gray !important;height: 20px !important;width: 100px;' disabled='true'/>
                                    <input class='btn' type='submit' id='restart' name='restart' value='রিস্টার্ট' style='background: green !important;height: 20px !important;width: 100px;' onclick='return confirmFunction(\"Restart\")'/>";
                }
                echo "</td> 
                </tr></form>";
            }
            ?>   
        </table>
    </div>
<?php
include_once 'includes/footer.php';
?>