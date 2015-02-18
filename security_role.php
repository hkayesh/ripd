<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';

$sql_role_ins= $conn->prepare("INSERT INTO security_roles (role_name,role_desc,role_type) VALUES (?, ?, 'emp');");
$sql_role_sel = $conn->prepare("SELECT * FROM security_roles");
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
    $p_rolename = $_POST ['new_role'];
    $p_roledes = $_POST ['role_des'];
    $role_ins = $sql_role_ins->execute(array($p_rolename,$p_roledes));
    if ($role_ins==1) {
        $msg = "আপনি সফলভাবে " . $p_rolename . " নামে নতুন রোল তৈরি করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
?>

<title>রোল / অনুমতি</title>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
  <script type="text/javascript">
 function editRole(id)
	{ TINY.box.show({iframe:'security_role_edit.php?roleid='+id,width:500,height:280,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
function setRole(id)
	{ TINY.box.show({iframe:'security_role_setting.php?roleid='+id,width:700,height:600,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
   
    function beforeSubmit()
{
    if ((document.getElementById('new_role').value !=""))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}

 </script>
<style type="text/css">@import "css/bush.css";</style>
    <?php
if ($_GET['action'] == 'list') {
    ?>
    <div style="padding-top: 10px;font-size: 14px;">    
        <div style="padding-left: 110px; width: 62%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
        <div><a href="security_role.php"> নতুন রোল </a>&nbsp;&nbsp;<a href="security_role.php?action=list">রোল লিস্ট</a></div>
    </div>
<div style="font-size: 14px;font-family: SolaimanLipi !important;">
        <form method="POST">
            <table class="formstyle" style =" width:78%;font-family: SolaimanLipi !important;" >
                <tr>
                    <th>রোল লিস্ট</th>
                </tr>
                <tr>
                    <td>
                        <table style="width: 100%;padding-right: 12px;">                         
                            <tr id = "table_row_odd">
                                <td style="background-color: #89C2FA; width: 50%;text-align: center;" >রোলের নাম</td>
                                <td style="background-color: #89C2FA; width: 50%;text-align: center;">করনীয়</td>
                            </tr>
                            <?php
                            $sql_role_sel->execute();
                                $rolerow = $sql_role_sel->fetchAll();
                                foreach ($rolerow as $row) {
                                $db_rolename = $row['role_name'];
                                $db_roleid = $row['idsecurityrole'];
                                echo "  <tr>
                                <td>$db_rolename</td>
                               <td style='text-align: center ' ><a onclick='editRole($db_roleid)' style='cursor:pointer;color:blue;'><u>এডিট করুন</u></a>
                                   &nbsp;&nbsp;&nbsp;<a onclick='setRole($db_roleid)' style='cursor:pointer;color:yellow;'><u>সেটিং করুন</u></a></td>
                            </tr>";
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
    <form  action="" method="post" style="font-family: SolaimanLipi !important;" onsubmit="return beforeSubmit()">
            <div style="padding-top: 10px;">    
                <div style="padding-left: 110px; width: 62%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
                <div style=" float: left" ><a href="security_role.php"> নতুন রোল </a>&nbsp;&nbsp;<a href="security_role.php?action=list">রোল লিস্ট</a></div>
            </div>
            <table class="formstyle" style =" width:78%;font-family: SolaimanLipi !important;">        
                <tr>
                    <th colspan="2">নতুন রোল</th>
                </tr>
                <?php
                showMessage($flag, $msg);
                ?>
                <tr>
                    <td style="text-align: center; width: 50%;">রোলের নাম</td>
                    <td>: <input  class="box" type="text" name="new_role" id="new_role" value=""/><em2> *</em2></td>   
                </tr>
                <tr>
                    <td style="text-align: center; width: 50%;">রোলের বর্ণনা</td>
                    <td> <textarea  class="box" type="text" name="role_des" value=""></textarea></td>   
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
