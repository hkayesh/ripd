<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
//$loginUSERname = $_SESSION['UserID'];
$user_id = $_SESSION['userIDUser'];
//echo "$loginUSERname";
$msg = "";
?>
<?php
if (isset($_POST['submit_new'])) {

    $account_number = $_POST['account_number'];
    $account_status = $_POST['acc_action_type'];
    $cause = $_POST['cause'];
    $scan_document = "";
    $cfs_account_number = 4; //need to delete after completion
    $acc_cfs_userid = $_POST['account_cfs_userid'];
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
                                                    VALUES ('$account_status', Now(), '$user_id', '$cause', '$scan_document', '$cfs_account_number', '$acc_cfs_userid')";
    if (mysql_query($sql_insert_acc_close_restart)) {
        $msg = $account_number . " একাউন্ট নাম্বারটি সফলভাবে " . $account_status . " হয়েছে";
        unset($_GET['id']);
        $_GET['action'] = 'new';
    } else {
        $msg = "দুঃখিত, আবার চেষ্টা করুন .........";
    }
    // echo $msg;
}

//print_r($_POST);
//echo "account_number: ".$account_number." Cause: ".$cause." scan_document:".$scan_document." account_number_id: ".$account_number_id." postpone_type: ".$postpone_type;
//Check in account_close_restart Table
?>

<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
    function update(id)
    { TINY.box.show({iframe:'account_permanent_close_restart.php?acc_cfs_user='+id,width:600,height:300,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
</script>
<script>
    function getAccount(keystr) //search employee by account number***************
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if(keystr.length ==0)
            {
                document.getElementById('accountfound').style.display = "none";
            }
            else
            {document.getElementById('accountfound').style.visibility = "visible";
                document.getElementById('accountfound').setAttribute('style','position:absolute;top:43%;left:63.5%;width:225px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
            }
            document.getElementById('accountfound').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/accountSearch_1.php?key="+keystr+"&location=account_close_restart.php",true);
        xmlhttp.send();	
    }
</script>
<script>
   
    function validateForm()
    {
        var account_id=document.forms["account_close_form"]["account_number"].value;
        if (account_id==null || account_id=="")
        {
            alert("You Should Give An Account Number");
            return false;
        }
        var action_type = "";
        var len=document.forms["account_close_form"]["acc_action_type"].length;
        for (i = 0; i < len; i++) {

            if ( document.forms["account_close_form"].acc_action_type[i].checked ) {

                action_type = document.forms["account_close_form"].acc_action_type[i].value;
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
<?php
if ($_GET['action'] == 'new' or isset($_GET['id'])) {
    $account_msg = '';
    $account_status = '';
    //if($inserted_success_msg!=""){}
    //echo "Account Status: ".$account_status;
    if (isset($_GET['id'])) {
        $accountCfsid = $_GET['id'];
        $selreslt = mysql_query("SELECT * FROM  cfs_user WHERE idUser = $accountCfsid");
        $getrow = mysql_fetch_assoc($selreslt);
        $db_accountname = $getrow['account_name'];
        $db_accountnumber = $getrow['account_number'];
        $db_accountmobile = $getrow['mobile'];
        $db_user_type = $getrow['user_type'];
        $db_account_status = $getrow['cfs_account_status'];
        $account_status = $db_account_status;
        if ($db_account_status != "active") {
            $account_msg = "এই একাউন্টটি already " . $db_account_status . " আছে";
        }
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
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 48%; float: left"><a href="crm_management.php"><b>ফিরে যান</b></a></div>
        <div style="text-align: right;padding-right: 35px;"><a href="account_close_restart.php?action=new"> একাউন্ট বন্ধ-করন</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">বন্ধ একাউন্ট লিস্ট</a></div>
    </div>
    <div>           
        <form name="account_close_form" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">	
            <table class="formstyle"  style=" width: 85%; ">          
                <tr><th style="text-align: center" colspan="2"><h1>একাউন্ট বন্ধ-করণ</h1></th></tr>
                <tr>
                    <td colspan="3" height="25px" style="text-align: center;"><b>
                            <span style="color:gray;font-size:16px;">
                                <blink><?php
    if (!empty($account_msg)) {
        echo $account_msg;
    }if (!empty($msg)) {
        echo $msg;
    }
    ?></blink></span></b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td style="width: 20%">একাউন্ট নাম্বার</td>
                                <td style="width: 1%">:</td>
                                <td style="width: 55%">
                                    <input  class ="box" type="text" id="account_number" name="account_number" readonly="" value="<?php if ($account_status == "active") echo $db_accountnumber; ?>"/>
                                    <input type="hidden" name="account_cfs_userid" id="account_cfs_userid" value="<?php echo $accountCfsid; ?>"/>
                                </td>                                      
                            </tr>
                            <tr>
                                <td>বন্ধের ধরন</td>
                                <td>:</td>
                                <td><input type="radio" name="acc_action_type" value="temporarily_closed">সাময়িক বন্ধ <input type="radio" name="acc_action_type" value="permanently_closed">স্থায়ী বন্ধ</td>
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
                                <td colspan="">খুঁজুন:  <input type="text" class="box" style="width: 230px;" id="accountsearch" name="accountsearch" onkeyup="getAccount(this.value)"/>
                                    <div id="accountfound"></div></td>
                            </tr>
                            <?php
                            if (isset($_GET['id'])) {
                                ?>
                                <tr><td>একাউন্টধারীর ছবিঃ <img border="0" src="<?php echo $db_account_holder_picture; ?>" alt="account_holder_pic" width="100" height="100"></td></tr>
                                <tr><td>একাউন্টধারীর নামঃ <?php echo $db_accountname; ?></td></tr>
                                <tr><td>একাউন্ট নাম্বারঃ <?php echo $db_accountnumber; ?></td></tr>
                                <tr><td>মোবাইলঃ <?php echo $db_accountmobile; ?></td></tr>
                                <tr><td>একাউন্ট ধরণঃ <?php echo $db_user_type; ?></td></tr>
                            <?php } ?>
                        </table></td>
                </tr>

                <tr>                    
                    <td colspan="2" style="padding-left: 250px; " ><?php
                        if ($account_status == 'active') {
                            echo '<input class="btn" style =" font-size: 12px; " type="submit" name="submit_new" value="সেভ করুন"/>';
                        } else {
                            echo '<input class="btn" style =" font-size: 12px; background-color:gray;" type="submit" name="submit" value="সেভ করুন" disabled />';
                        }
                            ?>
                        <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" />
                    </td>                           
                </tr>
            </table>
        </form>
    </div>
    <?php
} else {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 48%; float: left"><a href="crm_management.php"><b>ফিরে যান</b></a></div>
        <div style="text-align: right;padding-right: 35px;"><a href="account_close_restart.php?action=new"> একাউন্ট বন্ধ-করন</a>&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">বন্ধ একাউন্ট লিস্ট</a></div>
    </div>
    <div>           
        <form name="" method="POST">	
            <table class="formstyle"  style=" width: 85%; ">   
                <tr>
                    <th colspan="6">বন্ধ একাউন্ট লিস্ট</th>
                </tr>
                <tr id = "table_row_even" style="text-align: center" >
                    <td style="background-color: #89C2FA" >একাউন্ট নাম</td>
                    <td style="background-color: #89C2FA" >একাউন্ট নাম্বার</td> 
                    <td style="background-color: #89C2FA" >কারন</td>
                    <td style="background-color: #89C2FA" >স্ক্যান ডকুমেন্ট</td>
                    <td style="background-color: #89C2FA" >অ্যাকশন তারিখ</td>
                    <td style="background-color: #89C2FA">অপশন</td>
                </tr>
                <?php
                $sql_closed_account_list = mysql_query("SELECT * from $dbname.cfs_user WHERE cfs_account_status !='active'");
                while ($row_closed_account_list = mysql_fetch_array($sql_closed_account_list)) {
                    $db_account_cfs_id = $row_closed_account_list['idUser'];

                    $show_closed_account_info = mysql_query("Select * From cfs_user, account_close_restart Where account_cfs_userid = $db_account_cfs_id And idUser = account_cfs_userid order by action_date DESC Limit 1");
                    $info_result = mysql_fetch_array($show_closed_account_info);
                    $account_holder_name = $info_result['account_name'];
                    $account_status = $info_result['account_status'];
                    $account_number = $info_result['account_number'];
                    $coz_of_account_close = $info_result['coz_of_account_close'];
                    $scan_doc = $info_result['scan_doc'];
                    $action_date = $info_result['action_date'];
                    $account_cfs_userid = $info_result['account_cfs_userid'];
                    echo "<tr>
                        <td>$account_holder_name</td>
                        <td>$account_number</td>
                        <td><textarea style=\"height: 30px; width: 150px; margin:0px\" id=\"cause\" name=\"cause\" readonly>$coz_of_account_close</textarea></td>
                        <td><a href=\"$scan_doc\" target=\"_blank\">স্ক্যান ডকুমেন্ট</a></td>
                        <td>$action_date</td>";
                    if ($account_status == "temporarily_closed") {
                        echo "<td><a onclick='update($account_cfs_userid)' style='cursor:pointer;color:blue;'>স্থায়ী বন্ধ/পুনরায় চালু</a></td></tr>";
                    } else {
                        echo "<td>একাউন্টটি বন্ধ</td></tr>";
                    }
                }
                if (mysql_num_rows($sql_closed_account_list) < 1) {
                    echo "<tr><td colspan = '5' style='text-align: center; color: red;'>এই মূহুর্তে কোনো একাউন্ট বন্ধ নেই</td></tr>";
                }
                ?>
            </table>
        </form>
    </div>    
    <?php
}
include_once 'includes/footer.php';
?> 
