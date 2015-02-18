<?php
error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/updateQueryPDO.php';
include_once 'includes/insertQueryPDO.php';
include_once 'includes/MiscFunctions.php';

$sql_current_command->execute();
$arr_curr_command = $sql_current_command->fetchAll();
foreach ($arr_curr_command as $value) $current_command_id = $value['commandno'];

if($_POST['curr_command'])
        {
        $p_command_id = $_POST['curr_command_id'];
        $conn->beginTransaction();
        $sql_update_prev_command->execute(array($current_command_id));
        $sql_insert_curr_command->execute(array($p_command_id));
        $conn->commit();     
        $current_command_id = $p_command_id;
        }
?>

<title>কমান্ড লিস্ট</title>
<style type="text/css">@import "css/bush.css";</style>
 
<div style="font-size: 14px;">
        <form  action="" method="post">
                <div style="padding-top: 10px;">    
                    <div style="padding-left: 5%; width: 58%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
                </div>
                <table class="formstyle" style =" width:90%; margin-left: 5%;">        
                    <tr>
                        <th colspan="6">কমান্ড লিস্ট ও পি,ভি এর মান</th>
                    </tr>
                    <tr>
                        <th>কমান্ড নং</th>
                        <th>কমান্ডের বর্ণনা</th>
                        <th>১ পিভির সমমূল্য টাকা</th>
                        <th>১ টাকার সমমূল্য পিভি</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php
                    $sql_select_command->execute();
                    $arr_command_details = $sql_select_command->fetchAll();
                    foreach ($arr_command_details as $acd_key)
                            {
                            $acd_command_id = $acd_key['idcommand'];
                            $acd_command_no = $acd_key['commandno'];
                            $acd_command_no_ban = english2bangla($acd_command_no);
                            $acd_command_desc = $acd_key['command_desc'];
                            $acd_pv_value = $acd_key['pv_value'];
                            $pv_value2taka = english2bangla(round(1/$acd_pv_value, 6));
                            $acd_pv_value = english2bangla($acd_pv_value);
                            echo
                            "<form action='' method='POST'>";
                            if($acd_command_no == $current_command_id) echo "<tr bgcolor='#F2EFEF'>";
                            else echo "<tr>";
                            echo
                                    "<td>কমান্ড - $acd_command_no_ban<input type='hidden' value='$acd_command_no' name='curr_command_id'/></td>
                                    <td>$acd_command_desc</td>
                                    <td>$pv_value2taka টাকা</td>
                                    <td>$acd_pv_value পিভি</td>
                                    <td><a href='command_details.php?id=$acd_command_id&no=$acd_command_no'>বিস্তারিত দেখুন</a></td>
                                    <td><input type='submit' class='btn' name='curr_command' value='কার্যকর করুন'/></td>
                                </tr>
                            </form>"; 
                            }
                    ?>    
                </table>
        </form>
    </div>

<?php
        include_once 'includes/footer.php';
?> 
