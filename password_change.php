<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/header.php';
include_once 'includes/columnViewAccount.php';
include_once 'includes/updateQueryPDO.php';
session_start();

$flag = 'false';
function showMessage($flag, $msg) 
        {
        if (!empty($msg)) 
                {
                if ($flag == 'true') 
                    {
                    echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:green;font-size:20px;">' . $msg . '</b></td></tr>';
                    }
                else 
                    {
                    echo '<tr><td colspan="2" height="30px" style="text-align:center;"><b><span style="color:red;font-size:20px;"><blink>' . $msg . '</blink></b></td></tr>';
                    }
                }
        }
if(isset($_POST['submit']))
        {
        $cfs_user_id = $_SESSION['userIDUser'] ;
        $password = md5($_POST['new_password']);
        $sql_update_password->execute(array($password, $cfs_user_id));
        $msg = "পাসওয়ার্ড সঠিকভাবে পরিবর্তন করা হয়েছে";
        $flag = "true";
        }
?>

<title>পাসওয়ার্ড পরিবর্তন</title>
<style type="text/css">@import "css/bush.css";</style>

<script type="text/javascript">
function checkPass(passvalue) // check password in repeat
        {
        var password = document.getElementById('new_password').value;
        if(password != passvalue)
                {
                document.getElementById('new_password2').focus();
                document.getElementById('passcheck').style.color='red';
                document.getElementById('passcheck').innerHTML = "পাসওয়ার্ড সঠিক হয় নি";
                document.getElementById('submit').style.backgroundColor='gray';
                document.getElementById('submit').disabled= true;
                }
        else
                {
                var oldPassCheck = document.getElementById("showError").innerHTML;
                if(oldPassCheck == "পাসওয়ার্ড সঠিক")
                        {
                        document.getElementById('passcheck').style.color='green';
                        document.getElementById('passcheck').innerHTML="পাসওয়ার্ড মিলেছে";
                        document.getElementById('submit').style.backgroundColor='';
                        document.getElementById('submit').disabled= false;
                        }
                else
                        {
                        document.getElementById('passcheck').style.color='red';
                        document.getElementById('passcheck').innerHTML="পুরনো পাসওয়ার্ড ম্যাচ করেনি";
                        }
                }
        }
        
function blankRePass()
        {
        document.getElementById('new_password2').value='';
        document.getElementById('submit').disabled= true;
        }

function  checkCorrectPass() // match password with account
        {
        var pass = document.getElementById('old_password').value;
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
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                        {
                        var flagError = xmlhttp.responseText;
                        if(flagError == 1)
                            {
                            document.getElementById('showError').style.color='red';
                            document.getElementById("showError").innerHTML= 'দুঃখিত, আপনার পাসওয়ার্ডটি ম্যাচ হয়নি';
                            document.getElementById('submit').disabled= true;
                            }
                        else
                            {
                            document.getElementById('showError').style.color='green';
                            document.getElementById("showError").innerHTML= 'পাসওয়ার্ড সঠিক';
                            }
                        }
                }
        xmlhttp.open("GET","includes/matchPassword.php?pass="+pass,true);
        xmlhttp.send();
        }
</script>
 
 <div class="columnSubmodule" style="font-size: 14px;">
    <form  action="" id="passwordChange" method="post" style="font-family: SolaimanLipi !important;">
            <table class="formstyle" style ="width: 100%; margin-left: 0px; font-family: SolaimanLipi !important;">        
                <tr>
                    <th colspan="2">পাসওয়ার্ড পরিবর্তন</th>
                </tr>
                <?php showMessage($flag, $msg);?>
                <tr>
                    <td style="text-align: right; width: 35%;">পুরানো পাসওয়ার্ড</td>
                    <td>: <input  class="box" type="password" name="old_password"  id="old_password" onblur='checkCorrectPass();'/><span id='showError'></span></td>   
                </tr>
                <tr>
                    <td style="text-align: right;">নতুন পাসওয়ার্ড</td>
                    <td>: <input  class="box" type="password" name="new_password"  id="new_password" onkeyup='blankRePass();'/></td>   
                </tr>
                 <tr>
                    <td style="text-align: right;">নতুন পাসওয়ার্ড(পুনরায়)</td>
                    <td>: <input  class="box" type="password" name="new_password2"  id="new_password2" onkeyup='checkPass(this.value); '/><span id="passcheck"></span></td>   
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"></br><input type="submit" style="background-color: gray;" class="btn" name="submit" id="submit" disabled value="ঠিক আছে"></td>
                </tr>
                    <tr>
                    <td colspan="2" id="passwordbox"></td>
                </tr>
            </table>
        </form>
    </div>

<?php
include_once 'includes/footer.php';
?> 