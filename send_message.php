<?php
error_reporting(0);
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$session_user_id = $_SESSION['userIDUser'];

$sql_select_cfs_user= $conn->prepare("SELECT idUser FROM cfs_user WHERE account_number = ?");
$ins_msg = $conn->prepare("INSERT INTO send_message (sender_id,receiver_id,msg,status,sending_date,sending_time) VALUES (?,?,?,'send',NOW(),NOW())");
$msg = "";

if (isset($_POST['submit_message'])) {
    $p_accNo= $_POST['acc_no'];
    $sender_message = $_POST['message'];
    $sql_select_cfs_user->execute(array($p_accNo));
    $idrow = $sql_select_cfs_user->fetchAll();
    foreach ($idrow as $value) {
        $receiver_id = $value['idUser'];
    }
    $result = $ins_msg->execute(array($session_user_id,$receiver_id,$sender_message));
    if ($result){
        $msg = "আপনার মেসেজটি সফলভাবে পাঠানো হয়েছে";
    } else {
        $msg = "দুঃখিত, আপনার মেসেজটি পাঠানো যাচ্ছে না।";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css"> @import "css/bush.css";</style>
<script>
function check_accNo(str) // for currect email address form checking
{
if (str.length==0)
  {
  document.getElementById("acc_name").innerHTML=""; 
  return;
  }
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
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        document.getElementById("acc_name").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","includes/accountSearch.php?acc="+str,true);
xmlhttp.send();
}
function beforeSubmit()
{
    if ((document.getElementById('acc_no').value !="") 
        && (document.getElementById('message').value != ""))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>
</head>
<body>
<form method="POST" onsubmit="return beforeSubmit();" name="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">	
    <table  class="formstyle" style="margin: 5px 10px 15px 10px; width: 100%; font-family: SolaimanLipi !important;">          
        <tr><th colspan="3" style="text-align: center;">ক্ষুদে বার্তা পাঠানো</th></tr>
        <?php
        if ($msg == "") {
            ?>
            <tr>
                <td style="width: 20%">প্রাপকের একাউন্ট নাম্বার</td>
                <td style="width: 1%">:</td>
                <td style="width: 55%"><input class="box" type="text"  name="acc_no" id="acc_no" placeholder="প্রাপকের একাউন্ট নাম্বার" maxlength="15" onblur="check_accNo(this.value)"/><em2>*</em2></td>                                      
            </tr>
        <tr>
                <td style="width: 20%">প্রাপকের নাম</td>
                <td style="width: 1%">:</td>
                <td style="width: 55%"  id="acc_name"></td>                                  
            </tr>
            <tr>
                <td> বার্তা</td>
                <td>:</td>
                <td><textarea id='message' name='message' style='width: 90%;'></textarea><em2>*</em2></td>
            </tr>
            <tr>                    
                <td colspan="3" style="text-align:center;">                            
                      <input class="btn" style =" font-size: 12px; " type="submit" name="submit_message" value="সেন্ড করুন"/>
                </td>                        
            </tr>    
            <?php
        } else {
            ?>
            <tr>
                <td colspan="2" style="text-align: center; font-size: 16px;color: green;"><?php echo $msg; ?></td>          
            </tr>
            <?php }?>
    </table>
</form>
</body>
</html>

