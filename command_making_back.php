<?php
error_reporting(0);
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/insertQueryPDO.php';

if($_POST['submit_command'])
        {
        $p_commman_no = $_POST['command_no'];
        $p_commman_desc = $_POST['command_desc'];
        $p_pv_value_in_100 = $_POST['pv_100'];
        $p_pv_value_in_1 = $_POST['pv_1'];
        $pv_value = round($p_pv_value_in_100/100, 3);
        if($pv_value == $p_pv_value_in_1)
                {
                $sql_insert_command->execute(array($p_commman_no, $p_commman_desc, $pv_value));
                }
        else echo "পি,ভি এর মান সমান হয়নি।";
        }
?>
<?php
$flag = 'false';

function showMessage($flag, $msg) {
    if (!empty($msg)) {
        if ($flag == 'true') {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:20px;">' . $msg . '</b></td></tr>';
        } else {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:20px;"><blink>' . $msg . '</blink></b></td></tr>';
        }
    }
}

if (isset($_POST['submit']) && ($_GET['action'] == 'new')) {
    $division = $_POST ['new_division'];
    $sql = "insert into division (division_name) values('$division')";
    if (mysql_query($sql)) {
        $msg = "আপনি সফলভাবে " . $division . " নামে নতুন বিভাগটি তৈরি করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
if (isset($_POST['submit']) && ($_GET['action'] == 'edit')) {
    $division_id = $_GET['id'];
    $division_name = $_POST ['division_name'];
    $sql = "update division set division_name='$division_name' where idDivision='$division_id'";
    if (mysql_query($sql)) {
        $msg = "আপনি সফলভাবে " . $division_name . " বিভাগ নামে তথ্য পরিবর্তন করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
?>
<title>কমান্ড অপশন</title>
<style type="text/css">@import "css/bush.css";</style>
 
<div style="font-size: 14px;">
        <form  action="" method="post">
                <div style="padding-top: 10px;">    
                    <div style="padding-left: 110px; width: 58%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
                </div>
                <table class="formstyle" style =" width:78%;">        
                    <tr>
                        <th colspan="2">কমান্ড তৈরি করুন</th>
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">কমান্ড নম্বর</td>
                        <td>: <input  class="box" type="text" name="command_no"/></td>   
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">কমান্ড বর্ণনা</td>
                        <td><textarea  class="box" name="command_desc"></textarea></td>   
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">১০০ টাকা </td>
                        <td>=<input  class="box" type="text" name="pv_100" /> পি,ভি</td>   
                    </tr>     
                    <tr>
                        <td style="text-align: right; width: 40%;">১ টাকা </td>
                        <td>=<input  class="box" type="text" name="pv_1" /> পি,ভি</td>   
                    </tr>             
                    <tr>
                        <td colspan="2" style="text-align: center;"></br><input type="submit" class="btn" name="submit_command" id="submit_command" value="ঠিক আছে">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                    </tr>
                </table>
        </form>
    </div>

<?php
        include_once 'includes/footer.php';
?> 
