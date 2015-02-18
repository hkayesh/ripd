<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/updateQueryPDO.php';
$msg = "";
$edit_awardlD = $_GET['editID'];
if (isset($_POST['award_submit'])) {
    $awd_id = $_POST['awd_id'];
    $awd_name = $_POST['awd_name'];
    $awd_date = $_POST['awd_date'];
    $awd_pro = $_POST['awd_pro'];
    $awd_des = $_POST['awd_des'];
    $old_award_img = $_POST['old_award_img'];
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
    }else{
        $image_path = $old_award_img;
    }
    $arr_awd =  $sql_update_award->execute(array($awd_name, $awd_pro, $awd_des, $awd_date, $image_path,
                                       $awd_rec_type, $awd_rec_name, $user_id, $awd_id));
    if ($arr_awd > 0) {
        $msg = "আপনি সফলভাবে " . $awd_name . " নামে এওয়ার্ড এডিট করেছেন";
        $flag = 'true';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন";
        $flag = 'false';
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css"> @import "css/bush.css";</style>
        <link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
        <script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
        <script src="javascripts/tinybox.js" type="text/javascript"></script>
        <script type="text/javascript">
            window.onclick = function()
            {
                new JsDatePick({
                    useMode: 2,
                    target: "date",
                    dateFormat: "%Y-%m-%d"
                });
            }
        </script>
    </head>
    <body>

        <form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">	
            <table  class="formstyle" style="margin: 5px 10px 15px 10px; width: 100%; font-family: SolaimanLipi !important;">          
                <tr><th colspan="3" style="text-align: center;">এডিট এওয়ার্ড</th></tr>
                <?php
                if ($msg == "") {
                    $sql_select_award_id->execute(array($edit_awardlD));
                    $arr_awd = $sql_select_award_id->fetchAll();
                    foreach ($arr_awd as $row) {
                        $db_awrd_name = $row['awd_name'];
                        $db_awd_provider_name = $row['awd_provider_name'];
                        $db_awd_des = $row['awd_description'];
                        $db_awd_date = $row['awd_date'];
                        $db_rec_type = $row['awd_receivers_type'];
                        $db_rec_name = $row['awd_receivers_name'];
                        $db_awd_pic = $row['awd_image'];
                        ?>
                        <tr>
                            <td >এওয়ার্ড নাম</td>
                            <td>: </td>
                            <td><input class="textfield" type="text" value="<?php echo $db_awrd_name; ?>" name="awd_name" id="awd_name" style="width: 250px"></input>
                                <input name="awd_id" value="<?php echo $edit_awardlD; ?>" type="hidden"/></td>                                      
                        </tr>
                        <tr>
                            <td >এওয়ার্ড প্রদানকারীর নাম</td>
                            <td>: </td>
                            <td><input class="textfield" type="text" value="<?php echo $db_awd_provider_name; ?>" name="awd_pro" id="awd_pro" style="width: 250px"></input></td>                                      
                        </tr>
                        <tr>
                            <td >এওয়ার্ড বর্ণনা</td>
                            <td>: </td>
                            <td><textarea name="awd_des" id="awd_des" style="width: 250px"><?php echo $db_awd_des; ?></textarea></td>                                      
                        </tr>
                        <tr>
                            <td >এওয়ার্ড তারিখ</td>
                            <td>: </td>
                            <td><input class="textfield" type="date" id="date" placeholder="Date" name="awd_date" style="width: 250px" id="awd_id" value="<?php echo $db_awd_date; ?>"/></td>	  
                        </tr>
                        <tr>
                            <td >এওয়ার্ড ছবি</td>
                            <td>: </td>
                            <td><img src='<?php echo $db_awd_pic; ?>' width='250px' height='140px'/></br>
                                <input class="box" type="file" id="awardscan" name="awardscan" style="font-size:10px;" style="width: 350px"/>
                                <input type="hidden" name="old_award_img" id="old_award_img" value="<?php echo $db_awd_pic; ?>" /></td>
                        </tr>
                        <tr>
                            <td>গ্রহণকারীর ধরণ</td>
                            <td>: </td>
                            <td><select class="box2" id="awd_rec_type" name="awd_rec_type" style="width: 250px"/>
                                <option>----সিলেক্ট করুন----</option>
                                <option value="company" <?php if($db_rec_type=='company') echo 'selected="selected"';?>>কোম্পানি</option>
                                <option value="employee" <?php if($db_rec_type=='employee') echo 'selected="selected"';?>>কর্মচারী</option>
                                <option value="customer" <?php if($db_rec_type=='customer') echo 'selected="selected"';?>>কাস্টমার</option>
                                <option value="others" <?php if($db_rec_type=='others') echo 'selected="selected"';?>>অন্যান্য</option>
                            </td>
                        </tr>
                        <tr>
                            <td>গ্রহণকারীর নাম</td>
                            <td>: </td>
                            <td><input  class ="textfield" type="text" id="awd_rec_name" name="awd_rec_name" value="<?php echo $db_rec_name; ?>" style="width: 250px" /></td>
                        </tr>
                        <tr>                    
                            <td colspan="3" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="award_submit" value="এডিট করুন" />
                                <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                        </tr>   
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="2" style="text-align: center; font-size: 16px;color: green;"><?php echo $msg; ?></td>          
                    </tr>
                    <?php
//                                                echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
//                                                echo "<!--\n";
//                                                //echo "onload=\"javscript:self.parent.location.href = 'close_account.php';\"";
//                                                echo "top.location.href = 'close_account.php';\n";
//                                                echo "//-->\n";
//                                                echo "</script>\n";
                }
                ?>
            </table>
        </form>
    </body>
</html>

