<?php
error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/insertQueryPDO.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/updateQueryPDO.php';
include_once 'includes/MiscFunctions.php';
$msg = "";
if ($_POST['submit_command']) {
    $p_commman_no = $_POST['command_no'];
    $p_commman_desc = $_POST['command_desc'];
    $p_pv_value_in_100 = $_POST['pv_100'];
    $p_pv_value_in_1 = $_POST['pv_1'];
    $pv_value = round($p_pv_value_in_100 / 100, 3);
    if ($pv_value == $p_pv_value_in_1) {
        $sql = $sql_insert_command->execute(array($p_commman_no, $p_commman_desc, $pv_value));
        if($sql == 1)
       $msg = "সফলভাবে সেভ হয়েছে";
        else
            $msg = "দুঃখিত, আবার চেষ্টা করুন";
    }
    else
        $msg = "পি,ভি এর মান সমান হয়নি।";
}
else if ($_POST['edit_command']){
    $p_id_command = $_POST['idcommand'];
    $p_commman_no = $_POST['command_no'];
    $p_commman_desc = $_POST['command_desc'];
    $p_pv_value_in_100 = $_POST['pv_100'];
    $p_pv_value_in_1 = $_POST['pv_1'];
    $pv_value = round($p_pv_value_in_100 / 100, 3);
    if ($pv_value == $p_pv_value_in_1) {
        $sql = $sql_update_command->execute(array($p_commman_no, $p_commman_desc, $pv_value, $p_id_command));
         if ($sql == 1) {
        $msg = "আপনি সফলভাবে " . english2bangla($p_commman_no) . " কমান্ড নামের তথ্য পরিবর্তন করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
    }
    else
        echo "পি,ভি এর মান সমান হয়নি।";
}
?>

<title>কমান্ড</title>
<style type="text/css">
    @import "css/bush.css";
</style>
<script type="text/javascript">
    function  isBlankDivision_new()
    {
        var y=document.forms["division"]["division_name_new"].value;
        if (y == null || y == "")
        {
            alert("বিভাগের নাম পূরন করুন");
            return false;
        }
    }
    function isBlankDivision_edit()
    {
        var x=document.forms["division"]["division_name_edit"].value;
        if (x== null || x== "")
        {
            alert("বিভাগের নাম পূরন করুন");
            return false;
        }
       
    }
</script>
<?php
if ($_GET['action'] == 'edit') {
    $command_id = $_GET['id'];
    $command_idShow = english2bangla($command_id);
    $sql_select_commandEdit->execute(array($command_id));
    $arr_command_details = $sql_select_commandEdit->fetchAll();
    foreach ($arr_command_details as $acd_key) {
        $pv_value_100 = 100 * $acd_key['pv_value'];
        ?>
        <div style="padding-top: 10px;">    
            <div style="padding-left: 110px; width: 63%; float: left"><a href="command_making.php"><b>ফিরে যান</b></a></div>
            <div ><a href="command_making.php?action=new"> নতুন কমান্ড  </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>"> কমান্ড লিস্ট</a></div>
        </div>
        <div>
            <form  name="division" action="" onsubmit="return isBlankDivision_edit()" method="post">
                <table class="formstyle" style =" width:78%;">        
                    <tr>
                        <th colspan="2">কমান্ড নং <?php echo $command_idShow;?></th>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center"><b><?php echo $msg;?></b></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">কমান্ড নম্বর</td>
                        <td>: <input  class="box" type="text" name="command_no" value="<?php echo $acd_key['commandno']; ?>" /></td>   
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">কমান্ড বর্ণনা</td>
                        <td> : <textarea  class="box" name="command_desc"><?php echo $acd_key['command_desc']; ?></textarea></td>   
                    </tr>
                    <tr>
                        <td style="text-align: right; width: 40%;">১০০ টাকা </td>
                        <td>=<input  class="box" type="text" name="pv_100" value="<?php echo $pv_value_100; ?>"/> পি,ভি</td>   
                    </tr>     
                    <tr>
                        <td style="text-align: right; width: 40%;">১ টাকা </td>
                        <td>=<input  class="box" type="text" name="pv_1" value="<?php echo $acd_key['pv_value']; ?>"/> পি,ভি</td>   
                    </tr>             
                    <tr>
                        <td><input type="hidden" class="text" name="idcommand"  value="<?php echo $acd_key['idcommand']; ?>"></td>
                        <td style="text-align: left;"><input type="submit" class="btn" name="edit_command" id="edit_command" value="আপডেট"></td>
                    </tr>
                </table>
            </form>
        </div>

        <?php
    }
} elseif ($_GET['action'] == 'new') {
    ?>
    <div style="font-size: 12px;">
        <form method="post" action="">
            <div style="padding-top: 10px;">    
                <div style="padding-left: 110px; width: 63%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
                <div  ><a href="command_making.php?action=new"> নতুন কমান্ড </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">কমান্ড লিস্ট</a></div>
            </div>
            <table class="formstyle" style =" width:78%;">        
                <tr>
                    <th colspan="2">কমান্ড তৈরি করুন</th>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"><b><?php echo $msg; ?></b></td>
                </tr>
                <tr>
                    <td style="text-align: right; width: 40%;">কমান্ড নম্বর</td>
                    <td>: <input  class="box" type="text" name="command_no"/></td>   
                </tr>
                <tr>
                    <td style="text-align: right; width: 40%;">কমান্ড বর্ণনা</td>
                    <td> : <textarea  class="box" name="command_desc"></textarea></td>   
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
} else {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 63%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
        <div><a href="command_making.php?action=new"> নতুন কমান্ড </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">কমান্ড লিস্ট</a></div>
    </div>
    <div>
        <form method="POST">
            <table class="formstyle" style =" width:78%;">        
                <tr>
                    <th colspan="6">কমান্ড লিস্ট ও পি,ভি এর মান</th>
                </tr>
                <tr>
                    <th>কমান্ড নং</th>
                    <th>কমান্ডের বর্ণনা</th>
                    <th>১ পিভির সমমূল্য টাকা</th>
                    <th>১ টাকার সমমূল্য পিভি</th>
                    <th></th>
                </tr>
                <?php
                $sql_select_command->execute();
                $arr_command_details = $sql_select_command->fetchAll();
                foreach ($arr_command_details as $acd_key) {
                    $acd_command_id = $acd_key['idcommand'];
                    $acd_command_no = $acd_key['commandno'];
                    $acd_command_no_ban = english2bangla($acd_command_no);
                    $acd_command_desc = $acd_key['command_desc'];
                    $acd_pv_value = $acd_key['pv_value'];
                    $pv_value2taka = english2bangla(round(1 / $acd_pv_value, 6));
                    $acd_pv_value = english2bangla($acd_pv_value);
                    echo
                    "<form action='' method='POST'>";
                    if ($acd_command_no == $current_command_id)
                        echo "<tr bgcolor='#F2EFEF'>";
                    else
                        echo "<tr>";
                    echo
                    "<td>কমান্ড - $acd_command_no_ban<input type='hidden' value='$acd_command_no' name='curr_command_id'/></td>
                                    <td>$acd_command_desc</td>
                                    <td>$pv_value2taka টাকা</td>
                                    <td>$acd_pv_value পিভি</td>
                                    <td style='text-align: center ' ><a href='command_making.php?action=edit&id=$acd_command_id'>এডিট কমান্ড</a></td>  
                                </tr>
                            </form>";
                }
                ?>    
            </table>
        </form>
    </div>

    <?php
}
include_once 'includes/footer.php';
?> 

