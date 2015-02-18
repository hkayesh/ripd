<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
function get_modules()
{
    echo  "<option value=0> -সিলেক্ট করুন- </option>";
    $modRslt= mysql_query("SELECT * FROM security_modules ORDER BY module_name;");
    while($modrow = mysql_fetch_assoc($modRslt))
    {
	echo  "<option value=".$modrow['idsecuritymod'].">".$modrow['module_name']."</option>";
    }
}
$sql_submod_ins= $conn->prepare("INSERT INTO securiy_submodules (submod_name,submod_desc,security_module_idsecuritymod) VALUES (?, ?, ?);");
$sql_submod_sel = $conn->prepare("SELECT * FROM securiy_submodules");
$sql_mod_sel = $conn->prepare("SELECT * FROM security_modules WHERE 	idsecuritymod = ?");
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
    $p_parentmod = $_POST ['parent_module'];
    $p_submodname = $_POST ['new_submodule'];
    $p_submoddes = $_POST ['submodule_des'];
    $submod_ins = $sql_submod_ins->execute(array($p_submodname,$p_submoddes, $p_parentmod));
    if ($submod_ins==1) {
        $msg = "আপনি সফলভাবে " . $p_submodname . " নামে নতুন সাবমডিউলটি তৈরি করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
?>

<title>সাব-মডিউল</title>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
  <script type="text/javascript">
 function editSubModule(id)
	{ TINY.box.show({iframe:'security_submodule_edit.php?submodid='+id,width:500,height:240,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
 </script>
    <?php
if ($_GET['action'] == 'list') {
    ?>
    <div style="padding-top: 10px;font-size: 14px;">    
        <div style="padding-left: 110px; width: 52%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
        <div><a href="security_submodule.php"> নতুন সাব-মডিউল </a>&nbsp;&nbsp;<a href="security_submodule.php?action=list">সাব-মডিউলের লিস্ট</a></div>
    </div>
<div style="font-size: 14px;font-family: SolaimanLipi !important;">
        <form method="POST">
            <table class="formstyle" style =" width:78%;font-family: SolaimanLipi !important;" >
                <tr>
                    <th>সাব-মডিউল লিস্ট</th>
                </tr>
                <tr>
                    <td>
                        <table style="width: 100%;padding-right: 12px;">                         
                            <tr id = "table_row_odd">
                                <td style="background-color: #89C2FA; width: 10%;" >ক্রম</td>
                                <td style="background-color: #89C2FA; width: 20%;">সাব-মডিউলের নাম</td>
                                <td style="background-color: #89C2FA; width: 40%;">বর্ণনা</td>
                                <td style="background-color: #89C2FA; width: 20%;">মডিউলের নাম</td>
                                <td style="background-color: #89C2FA; width: 10%;">করনীয়</td>
                            </tr>
                            <?php
                                $sl = 1;
                                $sql_submod_sel->execute();
                                $submodrow = $sql_submod_sel->fetchAll();
                                foreach ($submodrow as $row) {
                                    $bnSl = english2bangla($sl);
                                $submodID = $row['idsecuritysubmod'];
                                $db_submodname = $row['submod_name'];
                                $db_submoddes = $row['submod_desc'];
                                $db_modid = $row['security_module_idsecuritymod'];
                                $sql_mod_sel->execute(array($db_modid));
                                $modrow = $sql_mod_sel->fetchAll();
                                foreach ($modrow as $value) {
                                    $db_modulename = $value['module_name'];
                                }
                                echo "  <tr>
                                    <td>$bnSl</td>
                                <td>$db_submodname</td>
                                <td>$db_submoddes</td>
                                <td>$db_modulename</td>
                                <td style='text-align: center ' ><a onclick='editSubModule($submodID)' style='cursor:pointer;color:blue;'><u>এডিট</u></a></td>  
                            </tr>"; $sl++;
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
    <form  action="" onsubmit="return isBlankDivision_new()" method="post" style="font-family: SolaimanLipi !important;">
            <div style="padding-top: 10px;">    
                <div style="padding-left: 110px; width: 52%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
                <div style=" float: left" ><a href="security_submodule.php"> নতুন সাব-মডিউল </a>&nbsp;&nbsp;<a href="security_submodule.php?action=list">সাব-মডিউলের লিস্ট</a></div>
            </div>
            <table class="formstyle" style =" width:78%;font-family: SolaimanLipi !important;">        
                <tr>
                    <th colspan="2">নতুন সাব-মডিউল</th>
                </tr>
                <?php
                showMessage($flag, $msg);
                ?>
                 <tr>
                    <td style="text-align: center; width: 50%;">মডিউলের নাম</td>
                    <td>: <select  class="box"  name="parent_module"  id="parent_module" style="height: 25px;width: 168px;" >
                            <?php get_modules();?>
                        </select></td>   
                </tr>
                <tr>
                    <td style="text-align: center; width: 50%;">সাব-মডিউলের নাম</td>
                    <td>: <input  class="box" type="text" name="new_submodule"  id="new_submodule" value=""/></td>   
                </tr>
                <tr>
                    <td style="text-align: center; width: 50%;">সাব-মডিউলের বর্ণনা</td>
                    <td> <textarea  class="box" type="text" name="submodule_des"  id="submodule_des" value=""></textarea></td>   
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
