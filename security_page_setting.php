<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
function getPages()
{ 
    $myarray = array();
    $sel_usedpages = mysql_query("SELECT page_name FROM security_pages ORDER BY page_name");
    while($arr_pages = mysql_fetch_assoc($sel_usedpages))
    {
        $pagename = $arr_pages['page_name'];
        array_push($myarray, $pagename);
    }
   echo  "<option value=0> -সিলেক্ট করুন- </option>";
     foreach (glob("*.php") as $filename) {
         if(in_array($filename, $myarray))
         {
         }
        else {
            echo  "<option value=".$filename.">".$filename."</option>";
        }
    }
}
function getPOSPages()
{ 
    $myarray = array();
    $sel_usedpages = mysql_query("SELECT page_name FROM security_pages ORDER BY page_name");
    while($arr_pages = mysql_fetch_assoc($sel_usedpages))
    {
        $pagename = $arr_pages['page_name'];
        array_push($myarray, $pagename);
    }
    echo  "<option value=0> -সিলেক্ট করুন- </option>";
     foreach (glob("pos/*.php") as $filename) {
        if(in_array($filename, $myarray))
             {
             }
            else {
                echo  "<option value=".$filename.">".end(explode("/",$filename))."</option>";
            }
    }
}
function getSubmodules()
{
    echo  "<option value=0> -সিলেক্ট করুন- </option>";
    $modRslt= mysql_query("SELECT * FROM securiy_submodules ORDER BY submod_name;");
    while($modrow = mysql_fetch_assoc($modRslt))
    {
	echo  "<option value=".$modrow['idsecuritysubmod'].">".$modrow['submod_name']."</option>";
    }
}
$sql_page_ins= $conn->prepare("INSERT INTO security_pages (page_name, page_view_name, page_desc, page_create_date, security_submodule_idsecuritysubmod) VALUES (?, ?, ?, NOW() ,?);");
$sql_page_sel = $conn->prepare("SELECT * FROM security_pages");
$sql_sel = $conn->prepare("SELECT * FROM security_modules,securiy_submodules WHERE idsecuritymod = security_module_idsecuritymod AND idsecuritysubmod = ?");
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
    $p_parentsubmod = $_POST ['sub_module'];
    $p_pagename = $_POST ['page'];
    $p_pageviewname = $_POST ['page_view'];
    $p_pagedes = $_POST ['pagedescription'];
    $submod_ins = $sql_page_ins->execute(array($p_pagename,$p_pageviewname, $p_pagedes,$p_parentsubmod));
    if ($submod_ins==1) {
        $msg = "ঠিক আছে";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
?>

<title>পেজ সেটিং</title>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
  <script type="text/javascript">
 function editPage(id)
	{ TINY.box.show({iframe:'security_page_edit.php?pageid='+id,width:500,height:310,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
 </script>
<script>
    function showRIPD()
    {
        var showcase = ": <select  class='box'  name='page' style='width: 250px; height: 25px;'><?php getPages();?></select>";
        document.getElementById('selectbox').innerHTML = showcase;
    }
    function showPOS()
    {
        var showcase = ": <select  class='box'  name='page' style='width: 250px; height: 25px;'><?php getPOSPages();?></select>";
        document.getElementById('selectbox').innerHTML = showcase;
    }
</script>
    <?php
if ($_GET['action'] == 'list') {
    ?>
    <div style="padding-top: 10px;font-size: 14px;">    
        <div style="padding-left: 110px; width: 62%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
        <div><a href="security_page_setting.php"> নতুন পেজ </a>&nbsp;&nbsp;<a href="security_page_setting.php?action=list">পেজ লিস্ট</a></div>
    </div>
<div style="font-size: 14px;font-family: SolaimanLipi !important;">
        <form method="POST">
            <table class="formstyle" style =" width:78%;font-family: SolaimanLipi !important;" >
                <tr>
                    <th>পেজ লিস্ট</th>
                </tr>
                <tr>
                    <td>
                        <table style="width: 100%;padding-right: 12px;">                         
                            <tr id = "table_row_odd">
                                <td style="background-color: #89C2FA; width: 30%;" >পেজের নাম</td>
                                <td style="background-color: #89C2FA; width: 20%;">পেজভিউ নাম</td>
                                <td style="background-color: #89C2FA; width: 20%;">সাব-মডিউলের নাম</td>
                                <td style="background-color: #89C2FA; width: 20%;">মডিউলের নাম</td>
                                <td style="background-color: #89C2FA; width: 10%;">করনীয়</td>
                            </tr>
                            <?php
                                  $sql_page_sel->execute();
                                $pagerow = $sql_page_sel->fetchAll();
                                foreach ($pagerow as $row) {
                                $pageID = $row['idsecuritypage'];
                                $db_pagename = $row['page_name'];
                                $db_pageviewname = $row['page_view_name'];
                                $db_submodid = $row['security_submodule_idsecuritysubmod'];
                                $sql_sel->execute(array($db_submodid));
                                $modrow = $sql_sel->fetchAll();
                                foreach ($modrow as $value) {
                                    $db_modulename = $value['module_name'];
                                    $db_submodulename = $value['submod_name'];
                                }
                                echo "  <tr>
                                <td>$db_pagename</td>
                                <td>$db_pageviewname</td>
                                <td>$db_submodulename</td>
                                <td>$db_modulename</td>
                                <td style='text-align: center ' ><a onclick='editPage($pageID)' style='cursor:pointer;color:blue;'><u>এডিট</u></a></td>  
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
    <form  action="" method="post" style="font-family: SolaimanLipi !important;">
            <div style="padding-top: 10px;">    
                <div style="padding-left: 110px; width: 62%; float: left"><a href="command_system_management.php"><b>ফিরে যান</b></a></div>
                <div style=" float: left" ><a href="security_page_setting.php"> নতুন পেজ </a>&nbsp;&nbsp;<a href="security_page_setting.php?action=list">পেজ লিস্ট</a></div>
            </div>
            <table class="formstyle" style =" width:78%;font-family: SolaimanLipi !important;">        
                <tr>
                    <th colspan="2">নতুন পেজ</th>
                </tr>
                <?php
                showMessage($flag, $msg);
                ?>
                <tr>
                    <td style="text-align: center; width: 50%;"><input type="radio" name="dirselect" onclick="showRIPD()" />RIPD</td>
                    <td><input type="radio" name="dirselect" onclick="showPOS()"  />POS</td>   
                </tr>
                 <tr>
                    <td style="text-align: center; width: 50%;">পেজের নাম</td>
                    <td id="selectbox">: 
<!--                        <select  class="box"  name="page" style="width: 250px; height: 25px;">
                            <?php getPOSPages();?>
                        </select>-->
                    </td>   
                </tr>
                <tr>
                    <td style="text-align: center; width: 50%;">পেজের ভিউ নাম</td>
                    <td>: <input  class="box" type="text" name="page_view"></td>   
                </tr>
                <tr>
                    <td style="text-align: center; width: 50%;">পেজের বর্ণনা</td>
                    <td> <textarea  class="box" type="text" name="pagedescription"></textarea></td>   
                </tr>
                <tr>
                    <td style="text-align: center; width: 50%;">সাব-মডিউলের নাম</td>
                    <td>:  <select  class="box"  name="sub_module"  style="height: 25px;" >
                            <?php echo getSubmodules();?>
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