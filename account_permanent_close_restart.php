<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
$user_id = $_SESSION['userIDUser'];
//echo "$loginUSERname";

$msg = "";
$account_cfs_user = $_GET['acc_cfs_user'];

$acc_close_info_query = mysql_query("SELECT * FROM account_close_restart, cfs_user WHERE account_cfs_userid = '$account_cfs_user' AND account_cfs_userid=idUser");
while ($acc_close_info_result = mysql_fetch_array($acc_close_info_query)) {
    $db_acc_name = $acc_close_info_result['account_name'];
    $db_acc_number = $acc_close_info_result['account_number'];
    $db_acc_status = $acc_close_info_result['cfs_account_status'];
    $db_acc_mobile = $acc_close_info_result['mobile'];
    $db_user_type = $acc_close_info_result['user_type'];
    if ($db_user_type == 'customer') {
        $sql_cust_info = mysql_query("Select * from customer_account where cfs_user_idUser = $accountCfsid");
        $resull_cust_info = mysql_fetch_array($sql_cust_info);
        $db_account_holder_picture = $resull_cust_info['scanDoc_picture'];
    } elseif ($db_user_type == "employee" or $db_user_type == "presenter" or $db_user_type == "trainer" or $db_user_type == "programmer") {
        $sql_employee_info = mysql_query("Select * from employee, employee_information where cfs_user_idUser = $accountCfsid And Employee_idEmployee = idEmployee");
        $resull_employee_info = mysql_fetch_array($sql_employee_info);
        $db_account_holder_picture = $resull_employee_info['emplo_scanDoc_picture'];
    }
}

if (isset($_POST['submit_close_restart'])) {
    $account_number = $_POST['account_number'];
    $account_status = $_POST['acc_action_type'];
    $cause = $_POST['cause'];
    $scan_document = "";
    $cfs_account_number = 4; //need to delete after completion
    $acc_cfs_user = $_POST['account_cfs_user'];
    //print_r($_POST);
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG", "pdf");
    //$file_name1 = $_FILES['scan_document_action']['name'];
    $extension = end(explode(".", $_FILES['scan_document_action']['name']));
    $scan_doc_name = $account_number . "_" . $_FILES['scan_document_action']['name'];
    $scan_doc_path_temp = "images/scan_doc_closed_postpond/" . $scan_doc_name;
    if (($_FILES['scan_document_action']['size'] < 999999999999) && in_array($extension, $allowedExts)) {
        move_uploaded_file($_FILES['scan_document_action']['tmp_name'], $scan_doc_path_temp);
        $scan_document = $scan_doc_path_temp;
    } else {
        echo "Invalid file format.";
    }

    $sql_insert_acc_close_restart = "INSERT INTO account_close_restart (account_status, action_date, action_userID, coz_of_account_close, scan_doc, cfs_account_number, account_cfs_userid) 
                                                    VALUES ('$account_status', Now(), '$user_id', '$cause', '$scan_document', '$cfs_account_number', '$acc_cfs_user')";
    if (mysql_query($sql_insert_acc_close_restart)) {
        $msg = $account_number . " একাউন্ট নাম্বারটি সফলভাবে " . $account_status . " হয়েছে";
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন .........";
    }
    //echo $msg;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css"> @import "css/bush.css";</style>
        <script src="javascripts/tinybox.js" type="text/javascript"></script>
        <script>
            function validateForm()
            {
                var account_id=document.forms["account_close_restart_form"]["account_number"].value;
                if (account_id==null || account_id=="")
                {
                    alert("You Should Give An Account Number");
                    return false;
                }
                var action_type = "";
                var len=document.forms["account_close_restart_form"]["acc_action_type"].length;
                for (i = 0; i < len; i++) {

                    if ( document.forms["account_close_restart_form"].acc_action_type[i].checked ) {

                        action_type = document.forms["account_close_restart_form"].acc_action_type[i].value;
                        break;

                    }

                }        
                if(action_type==null || action_type==""){
                    //document.write(action_type);
                    alert("যে কোনো একটি ধরন সিলেক্ট করুন");
                    return false;
                }
                var fup = document.getElementById('scan_document_action');
                var fileName = fup.value;
                if(fileName==null || fileName==""){
                    alert("আপনি কোনো স্ক্যান ডকুমেন্ট আপলোড করেন নাই। Please, Upload pdf, doc, Gif or Jpg content");
                    fup.focus();
                    return false;
                }else{
                    var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
                    if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "doc" || ext == "pdf")
                    {
                        return true;
                    } 
                    else
                    {
                        alert("Please, Upload pdf, doc, Gif or Jpg content");
                        fup.focus();
                        return false;
                    }
                }
            }
        </script>
    </head>
    <body>

        <form name="account_close_restart_form" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">	
            <table  class="formstyle" style="margin: 5px 10px 15px 10px; width: 100%; font-family: SolaimanLipi !important;">          
                <tr><th colspan="2" style="text-align: center;">স্থায়ী বন্ধ অথবা পুনরায় চালু</th></tr>
                <?php
                if ($msg == "") {
                    ?>
                    <tr>
                        <td>
                            <table>

                                <tr>
                                    <td style="width: 20%">একাউন্ট নাম্বার</td>
                                    <td style="width: 1%">:</td>
                                    <td style="width: 55%">
                                        <input  class ="box" type="text" id="account_number" name="account_number" readonly="" value="<?php if ($db_acc_status == "temporarily_closed") echo $db_acc_number; ?>"/>
                                        <input type="hidden" name="account_cfs_user" id="account_cfs_user" value="<?php echo $account_cfs_user; ?>"/>
                                    </td>                                      
                                </tr>
                                <tr>
                                    <td>ধরন</td>
                                    <td>:</td>
                                    <td><input type="radio" name="acc_action_type" value="restarted">পুনরায় চালু<input type="radio" name="acc_action_type" value="permanently_closed">স্থায়ী বন্ধ</td>
                                                </tr>
                                                <tr>
                                                    <td>কারন</td>
                                                    <td>:</td>
                                                    <td style="padding-left: 0px"><textarea id="cause" name="cause" ></textarea>
                                                </tr>
                                                <tr>
                                                    <td>স্ক্যান ডকুমেন্ট</td>
                                                    <td>:</td>
                                                    <td> <input class="box" type="file" id="scan_document_action" name="scan_document_action" style="font-size:10px;"/></td>
                                                </tr>
                                                </table>
                                                </td>
                                                <td width="40%">
                                                    <table>
                                                        <tr>
                                                            <td> একাউন্ট ইনফরমেশন</td>
                                                        </tr>
                                                        <tr><td>একাউন্টধারীর ছবিঃ <img border="0" src="<?php echo $db_account_holder_picture; ?>" alt="account_holder_pic" width="100" height="100"></td></tr>
                                                        <tr><td>একাউন্টধারীর নামঃ <?php echo $db_acc_name; ?></td></tr>
                                                        <tr><td>একাউন্ট নাম্বারঃ <?php echo $db_acc_number; ?></td></tr>
                                                        <tr><td>মোবাইলঃ <?php echo $db_acc_mobile; ?></td></tr>
                                                        <tr><td>একাউন্ট ধরণঃ <?php echo $db_acc_type; ?></td></tr>
                                                    </table></td>
                                                </tr>
                                                <tr>                    
                                                    <td colspan="2" style="padding-left: 25%; " >
                                                        <?php
                                                        if ($db_acc_status == "temporarily_closed") {
                                                            echo '<input class="btn" style =" font-size: 12px; " type="submit" name="submit_close_restart" value="সেভ করুন"/>';
                                                        } else {
                                                            echo '<input class="btn" style =" font-size: 12px; background-color:gray;" type="submit" name="submit" value="এডিট করুন" disabled />';
                                                        }
                                                        ?>
                                                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                        
                                                </tr>    
                                                <?php
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="2" style="text-align: center; font-size: 16px;color: green;"><?php echo $msg; ?></td>          
                                                </tr>
                                                <?php
                                                echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
                                                echo "<!--\n";
                                                //echo "onload=\"javscript:self.parent.location.href = 'close_account.php';\"";
                                                echo "top.location.href = 'close_account.php';\n";
                                                echo "//-->\n";
                                                echo "</script>\n";
                                            }
                                            ?>
                                            </table>
                                            </form>
                                            </body>
                                            </html>


