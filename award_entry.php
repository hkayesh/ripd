<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/insertQueryPDO.php';
$flag = 'false';
$msg = "";

function showMessage($flag, $msg) {
    if (!empty($msg)) {
        if ($flag == 'true') {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:20px;">' . $msg . '</b></td></tr>';
        } else {
            echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:20px;"><blink>' . $msg . '</blink></b></td></tr>';
        }
    }
}

if (isset($_POST['award_submit'])) {
    $awd_name = $_POST['awd_name'];
    $awd_date = $_POST['awd_date'];
    $awd_pro = $_POST['awd_pro'];
    $awd_des = $_POST['awd_des'];
    $awd_rec_name = $_POST['awd_rec_name'];
    $awd_rec_type = $_POST['awd_rec_type'];
    $user_id = $_SESSION['userIDUser'];
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["awardscan"]["name"]));
    $image_name = $_FILES["awardscan"]["name"];
    if ($image_name != "") {
        $image_name = "aw-" . $awd_date . "-" . $_FILES["awardscan"]["name"];
        $image_path = "awards/" . $image_name;
        if (($_FILES["awardscan"]["size"] < 999999999999) && in_array($extension, $allowedExts)) {
            move_uploaded_file($_FILES["awardscan"]["tmp_name"], "awards/" . $image_name);
        } else {
            echo "Invalid file format.";
        }
    }
   $arr_awd =  $sql_insert_award->execute(array($awd_name, $awd_pro, $awd_des, $awd_date, $image_path,
                                       $awd_rec_type, $awd_rec_name, $user_id));
    if ($arr_awd > 0) {
        $msg = "আপনি সফলভাবে " . $awd_name . " নামে নতুন এওয়ার্ড তৈরি করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
?>
<title>এওয়ার্ড</title>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" />
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
    function edit_award(id)
    {
        TINY.box.show({iframe:'edit_award.php?editID='+id,width:800,height:490,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'});
    }
</script>
<script type="text/javascript">
    window.onclick = function()
    {
        new JsDatePick({
            useMode: 2,
            target: "date",
            dateFormat: "%Y-%m-%d"
        });
    }
    function beforeSubmit()
    {
    if ((document.getElementById('awd_name').value !="") 
        && (document.getElementById('awd_pro').value != "")
        && (document.getElementById('awd_date').value != "")
        && (document.getElementById('awd_rec_type').value != "")
        && (document.getElementById('awd_rec_name').value != ""))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>
<style type="text/css">
    @import "css/bush.css";
</style>
<?php
if ($_GET['action'] == 'new') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 50px; width: 73%; float: left"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="award_entry.php?action=new"> নতুন এওয়ার্ড</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">এওয়ার্ড এর লিস্ট</a></div>
    </div>
    <div>
        <form name="awd" action="" enctype="multipart/form-data"  method="post" onsubmit="return beforeSubmit()">
            <table class="formstyle" style =" width:90%; margin-left: 50px">    
                <tr>
                    <th colspan="2">নতুন এওয়ার্ড প্রদান</th>
                </tr>                
                <?php
                showMessage($flag, $msg);
                ?>
                <tr>
                    <td >এওয়ার্ড নাম</td>
                    <td>: <input class="textfield" type="text" name="awd_name" id="awd_name" style="width: 250px"><em2> *</em2></td>                                      
                </tr>
                <tr>
                    <td >এওয়ার্ড প্রদানকারীর নাম</td>
                    <td>: <input class="textfield" type="text" name="awd_pro" id="awd_pro" style="width: 250px"><em2> *</em2></td>                                      
                </tr>
                <tr>
                    <td >এওয়ার্ড বর্ণনা</td>
                    <td><textarea name="awd_des" id="awd_des"></textarea></td>                                      
                </tr>
                <tr>
                    <td >এওয়ার্ড তারিখ</td>
                    <td>: <input class="textfield" type="date" name="awd_date" id="awd_date" value=""style="width: 250px"/><em2> *</em2></td>	  
                </tr>
                <tr>
                    <td >এওয়ার্ড ছবি</td>
                    <td>: <input class="box" type="file" id="awardscan" name="awardscan" style="font-size:10px; width: 250px"/></td>
                </tr>
                <tr>
                    <td >এওয়ার্ড গ্রহণকারীর ধরণ</td>
                    <td>: <select class="box2" name="awd_rec_type" id="awd_rec_type" style="width: 250px"/>
                    <option value="">----সিলেক্ট করুন----</option>
                                <option value="company">কোম্পানি</option>
                                <option value="employee">কর্মচারী</option>
                                <option value="customer">কাস্টমার</option>
                                <option value="others">অন্যান্য</option></select><em2> *</em2>
                </td>
                </tr>
                <tr>
                    <td>গ্রহণকারীর নাম</td>
                    <td>: <input  class ="textfield" type="text" id="awd_rec_name" name="awd_rec_name" style="width: 250px" /><em2> *</em2></td>
                </tr>
                <tr>                    
                    <td colspan="4" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="award_submit" value="সেভ করুন" />
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                </tr>
            </table>
        </form>
    </div>
    <?php
} else {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 50px; width: 73%; float: left"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
        <div ><a href="award_entry.php?action=new"> নতুন এওয়ার্ড </a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">এওয়ার্ড এর  লিস্ট</a></div>
    </div>
    <div>	
            <table class="formstyle"  style="width: 90%; margin-left: 50px;">      
                <tr>
                    <th colspan="9">প্রদানকৃত এওয়ার্ড তালিকা</th>
                </tr>           
                <tr id="table_row_odd">
                    <th style="background-color: #89C2FA; text-align: center" >ক্রম</th>
                    <th style="background-color: #89C2FA; text-align: center" >এওয়ার্ড নাম</th>
                    <th style="background-color: #89C2FA; text-align: center" >প্রদানকারীর নাম</th>
                    <th style="background-color: #89C2FA; text-align: center">এওয়ার্ড বর্ণনা</th>
                    <th style="background-color: #89C2FA; text-align: center">তারিখ</th>
                    <th style="background-color: #89C2FA; text-align: center">গ্রহণকারীর ধরণ</th>
                    <th style="background-color: #89C2FA; text-align: center">এওয়ার্ড গ্রহণকারী</th>
                    <th style="background-color: #89C2FA; text-align: center">এওয়ার্ড ছবি</th>
                    <th style="background-color: #89C2FA; text-align: center;">অপশন</th>
                </tr>
                <?php
                $count = 0;

                $sql_select_award_all->execute();
                $arr_awd = $sql_select_award_all->fetchAll();
                foreach ($arr_awd as $row) {
                    $count++;
                    $showCount = english2bangla($count);
                    $db_awrd_name = $row['awd_name'];
                    $db_awd_provider_name = $row['awd_provider_name'];
                    $db_awd_des = $row['awd_description'];
                    $db_awd_id = $row['idaward'];
                    $db_awd_date = $row['awd_date'];
                    $showDate = english2bangla($db_awd_date);
                    $db_rec_type = getAwardReceiverType($row['awd_receivers_type']);
                    $db_rec_name = $row['awd_receivers_name'];
                    $db_awd_pic = $row['awd_image'];
                    echo "<tr>
                        <td style='text-align: center'>$showCount</td>
                        <td style='text-align: center'>$db_awrd_name</td>
                            <td style='text-align: center'>$db_awd_provider_name</td>
                                    <td style='text-align: center'>$db_awd_des</td>
                                        <td style='text-align: center'>$showDate</td>
                                            <td style='text-align: center'>$db_rec_type</td>
                                                <td style='text-align: center'>$db_rec_name</td>
                                                    <td><img src='$db_awd_pic' alt='No Image' class='resize_award_img'/></td>
                        <td style='text-align: center ' ><a onclick='edit_award(" . $db_awd_id . ")' style='cursor:pointer;color:blue;'><u>এডিট</u></a></td>
                    </tr>";
                }
                ?>
            </table>
    </div>
    <?php
}
include_once 'includes/footer.php';
?>