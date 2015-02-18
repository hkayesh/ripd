<?php
//error_reporting(0);
include 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
$sql = $conn->prepare("SELECT * FROM main_fund ORDER BY fund_name");
$ins_ripd_invest = $conn->prepare("INSERT INTO ripd_investment (invest_amount, invest_desc, invest_scandoc, invest_date,fk_fund_idfund) 
                                                            VALUES (?,?,?,NOW(),?)");
function getFunds($sql)
{
    echo "<option value= 0> -সিলেক্ট করুন- </option>";
    $sql->execute(array());
    $arr_fund = $sql->fetchAll();
    foreach ($arr_fund as $fundrow) {
        echo "<option value=".$fundrow['idmainfund'].">". $fundrow['fund_name'] ."</option>";
    }
}
if(isset($_POST['submit']))
{
    $p_fundid = $_POST['fund'];
    $p_amount = $_POST['t_in_amount'];
    $p_description = $_POST['inDescription'];
    $randomno = get_time_random_no(4);
    $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
    $extension = end(explode(".", $_FILES["scanDoc"]["name"]));
    $image_name = $_FILES["scanDoc"]["name"];
    if ($image_name != "") {
        $image_name = "invest-". $randomno .".".$extension;
        $image_path = "scaned/" . $image_name;
        if (($_FILES["scanDoc"]["size"] < 999999999999) && in_array($extension, $allowedExts)) {
            move_uploaded_file($_FILES["scanDoc"]["tmp_name"], "scaned/" . $image_name);
        } 
    }
    $image_path="";
    $sqlresult = $ins_ripd_invest->execute(array($p_amount,$p_description,$image_path,$p_fundid));
     if($sqlresult)
     {
         echo "<script>alert('ইনভেস্ট হয়েছে')</script>";
     }
     else {
                echo "<script>alert('দুঃখিত,ইনভেস্ট হয়নি')</script>";
            }
}
?>
<style type="text/css"> @import "css/bush.css";</style>
<script>
function numbersonly(e)
    {
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8)
        { //if the key isn't the backspace key (which we should allow)
            if (unicode<48||unicode>57) //if not a number
                return false //disable key press
        }
    }
function beforeSubmit()
{
    if ((document.getElementById('fund').value != "0") 
            && (document.getElementById('t_in_amount').value != "")
            && (document.getElementById('t_in_amount').value != "0"))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>

<div class="columnSld" style=" padding-left: 50px;">
    <div class="main_text_box">
        <div style="padding-left: 9px;"><a href="accounting_sys_management.php"><b>ফিরে যান</b></a></div>
        <div>           
            <form method="POST" onsubmit="return beforeSubmit();" action="">	
                <table  class="formstyle" style="width: 90%; margin: 1px 1px 1px 1px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 22px;">রিপড হেড অফিস ইনভেস্ট</th></tr>
                    <tr>
                        <td >টোটাল ইন এ্যামাউন্ট</td>
                        <td>: <input class="box" type="text" id="t_in_amount" name="t_in_amount" style="text-align: right;" onkeypress=' return numbersonly(event)' /><em2> *</em2> TK</td>          
                    </tr>
                    <tr>
                        <td >ফান্ড</td>
                        <td>: <select class="box" name="fund" id="fund">
                                <?php getFunds($sql);?>
                            </select><em2> *</em2></td>          
                    </tr> 
                    <tr> 
                        <td>কারন</td>
                        <td> <textarea name="inDescription" ></textarea></td>           
                    </tr>
                    <tr> 
                        <td>স্ক্যান ডকুমেন্ট</td>
                        <td>: <input type="file" name="scanDoc" /></td>           
                    </tr>
                    <tr>                    
                        <td colspan="2" style="text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="ইনভেস্ট করুন" /></td>                           
                    </tr>    
                </table>
            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>