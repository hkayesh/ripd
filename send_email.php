<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';

$msg = "";
$receiver_office_sstore_email = $_GET['office_sstore_mail'];

if (isset($_POST['submit_email'])) {
    $sender_name = $_POST['name'];
    $sender_email = $_POST['email'];
    $sender_mobile = $_POST['mobile'];
    $sender_message = $_POST['message'];
    $sender_msg_subject = $_POST['subject'];
    $receiver_email = $_POST['office_store_email'];
    
    $affiliation= "Dear Admin,";
    $sender_moblie_number = "My Contact Number: ".$sender_mobile;

    //echo "Sender Name: " . $sender_name . " Email: " . $sender_email . "Mobile " . $sender_mobile . "Subject " . $sender_msg_subject . "Message " . $sender_message . "R-email: " . $receiver_email . "<br/>";

    //mail($receiver_email, "Subject: $sender_msg_subject", $sender_message, "From: $sender_email");
    //$headers .= 'MIME-Version: 1.0' . "\r\n";
    //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    //$sendMailValue = mail($receiver_email, $sender_msg_subject, $sender_message, "$headers \r\n From: $sender_email");
    
    $sendMailValue = mail($receiver_email, $sender_msg_subject, "$affiliation \n $sender_moblie_number \n\n $sender_message", "From: $sender_email");
    if ($sendMailValue){
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
function check(str) // for currect email address form checking
{
if (str.length==0)
  {
  document.getElementById("error_msg").innerHTML=""; 
  document.getElementById("error_msg").style.border="0px";
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
    document.getElementById("error_msg").innerHTML=xmlhttp.responseText;
    document.getElementById("error_msg").style.display = "inline";
    }
  }
xmlhttp.open("GET","includes/check.php?x="+str,true);
xmlhttp.send();
}
function beforeSubmit()
{
    if ((document.getElementById('name').value !="") 
        && (document.getElementById('email').value != "")
        && (document.getElementById('mobile').value != "")
        && (document.getElementById('subject').value != "")
        && (document.getElementById('message').value != "")
        && (document.getElementById('error_msg').innerHTML == ""))
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
        <tr><th colspan="3" style="text-align: center;">Send Your Message in Mail</th></tr>
        <?php
        if ($msg == "") {
            ?>
            <tr>
                <td style="width: 20%">Name</td>
                <td style="width: 1%">:</td>
                <td style="width: 55%">
                    <input type="text"  name="name" id="name" value="<?php echo $sender_name; ?>" placeholder="Type your Name"/><em2>*</em2>
                    <input type="hidden" name="office_store_email" id="office_store_email" value="<?php echo $receiver_office_sstore_email; ?>"/>
                </td>                                      
            </tr>
            <tr>
                <td>E-mail</td>
                <td>:</td>
                <td><input type="text"  name="email" id="email" value="<?php echo $sender_email; ?>" placeholder="Type your email address" onblur="check(this.value)"/><em2>*</em2><div id="error_msg" style="margin-left: 5px"></div></td>
            </tr>                
            <tr>
                <td>Mobile</td>
                <td>:</td>
                <td> <input type="text"  name="mobile" id="mobile" value="<?php echo $sender_mobile; ?>" placeholder="Type your mobile number"/></td>
            </tr>
            <tr>
                <td>Subject</td>
                <td>:</td>
                <td><input type="text"  name="subject" id="subject" value="<?php echo $sender_msg_subject; ?>" placeholder="Type your message Subject"/><em2>*</em2>  </td>                            
            </tr>
            <tr>
                <td>Message</td>
                <td>:</td>
                <td><textarea id='message' name='message' style='width: 90%;'><?php echo $sender_message; ?></textarea><em2>*</em2>
            </tr>
            <tr>                    
                <td colspan="3" style="text-align:center;">                            
                      <input class="btn" style =" font-size: 12px; " type="submit" name="submit_email" value="সেন্ড করুন"/>
                      <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" />
                </td>                        
            </tr>    
            <?php
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

