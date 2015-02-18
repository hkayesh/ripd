<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';

function getPages() { // for getting directory pages
    echo "<option value=0> -সিলেক্ট করুন- </option>";
    foreach (glob("*.php") as $filename) {
        echo "<option value=" . $filename . ">" . $filename . "</option>";
    }
}

$sql_mod_ins = $conn->prepare("INSERT INTO security_modules (module_name,module_desc,module_page_name) VALUES (?, ?, ?);");
$sql_mod_sel = $conn->prepare("SELECT * FROM security_modules");
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

if (isset($_POST['submit'])) {
    $p_modname = $_POST ['new_module'];
    $p_moddes = $_POST ['module_des'];
    $p_pagename = $_POST['page'];
    $mod_ins = $sql_mod_ins->execute(array($p_modname, $p_moddes, $p_pagename));
    if ($mod_ins == 1) {
        $msg = "আপনি সফলভাবে " . $p_modname . " নামে নতুন মডিউলটি তৈরি করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
?>

<title>মডিউল</title>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
    function editModule(id)
    { TINY.box.show({iframe:'security_module_edit.php?modid='+id,width:500,height:280,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
</script>

<?php
if ($_GET['action'] == 'list') {
    ?>
    <div style="padding-top: 10px;font-size: 14px;">    
        <div style="padding-left: 110px; width: 58%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
        <div><a href="security_module.php"> নতুন মডিউল </a>&nbsp;&nbsp;<a href="security_module.php?action=list">মডিউলের লিস্ট</a></div>
    </div>
    <div style="font-size: 14px;font-family: SolaimanLipi !important;">
        <form method="POST">
            <table class="formstyle" style =" width:78%;font-family: SolaimanLipi !important;" >
                <tr>
                    <th>মডিউল লিস্ট</th>
                </tr>
                <tr>
                    <td>
                        <table style="width: 100%;padding-right: 12px;">                         
                            <tr id = "table_row_odd">
                                <td style="background-color: #89C2FA; width: 6%;" >ক্রম</td>
                                <td style="background-color: #89C2FA; width: 26%;">মডিউলের নাম</td>
                                <td style="background-color: #89C2FA; width: 40%;">বর্ণনা</td>
                                <td style="background-color: #89C2FA; width: 20%;">পেজ</td>
                                <td style="background-color: #89C2FA; width: 8%;">করনীয়</td>
                            </tr>
                            <?php
                            $sl = 1;
                            $sql_mod_sel->execute();
                            $modrow = $sql_mod_sel->fetchAll();
                            foreach ($modrow as $row) {
                                $bnSl = english2bangla($sl);
                                $db_modID = $row['idsecuritymod'];
                                $db_modname = $row['module_name'];
                                $db_moddes = $row['module_desc'];
                                $db_pages = $row['module_page_name'];
                                echo "  <tr>
                                    <td>$bnSl</td>
                                    <td>$db_modname</td>
                                    <td>$db_moddes</td>
                                    <td>$db_pages</td>
                                    <td style='text-align: center ' ><a onclick='editModule($db_modID)' style='cursor:pointer;color:blue;'><u>এডিট</u></a></td>  
                                    </tr>";
                                $sl++;
                            }
                            ?>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php
} else {
    ?>
    <div style="font-size: 14px;">
        <form  action="" method="post" style="font-family: SolaimanLipi !important;">
            <div style="padding-top: 10px;">    
                <div style="padding-left: 110px; width: 58%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
                <div style=" float: left" ><a href="security_module.php"> নতুন মডিউল </a>&nbsp;&nbsp;<a href="security_module.php?action=list">মডিউলের লিস্ট</a></div>
            </div>
            <table class="formstyle" style =" width:78%;font-family: SolaimanLipi !important;">        
                <tr>
                    <th colspan="2">নতুন মডিউল</th>
                </tr>
                <?php
                showMessage($flag, $msg);
                ?>
                <tr>
                    <td style="text-align: center; width: 50%;">মডিউলের নাম</td>
                    <td>: <input  class="box" type="text" name="new_module"  id="new_module" value=""/></td>   
                </tr>
                <tr>
                    <td style="text-align: center; width: 50%;">মডিউলের বর্ণনা</td>
                    <td> <textarea  class="box" type="text" name="module_des"  id="module_des" value=""></textarea></td>   
                </tr>
                <tr>
                    <td style="text-align: center; width: 50%;">পেজের নাম</td>
                    <td>: <select  class="box"  name="page" style="width: 250px; height: 25px;">
    <?php getPages(); ?>
                        </select></td>   
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"></br><input type="submit" class="btn" name="submit" value="সেভ">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
        </form>
    </div>


<?php
}
include_once 'includes/footer.php';
?> 