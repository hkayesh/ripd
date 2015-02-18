<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once './includes/selectQueryPDO.php';
$ins_ons_exp = $conn->prepare("INSERT INTO ons_operational_exp(exp_total_amount ,exp_date ,exp_ons_id, exp_maker_id,exp_making_date) 
                                                         VALUES (?,?,?,?,NOW())");
$ins_ons_exp_details = $conn->prepare("INSERT INTO ons_opexp_details(onsexp_sector ,onsexp_amount, onsexp_description ,onsexp_scandoc, fk_onsopexp_idonsopexp) 
                                                                    VALUES (?,?,?,?,?)");
$ins_daily_inout = $conn->prepare("INSERT INTO acc_ofc_daily_inout (daily_date, daily_onsid, out_amount) VALUES (NOW(),?,?)");

$allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
if (isset($_POST['submit'])) {
    $exp_ons_type = $_SESSION['loggedInOfficeType'];
    $exp_ons_id = $_SESSION['loggedInOfficeID'];
    $exp_maker_id = $_SESSION['userIDUser'];
    
    $sql_select_id_ons_relation->execute(array($exp_ons_type,$exp_ons_id));
    $row = $sql_select_id_ons_relation->fetchAll();
    foreach ($row as $onsrow) {
        $db_onsID = $onsrow['idons_relation'];
    }
    $total_exp = $_POST['totalamount'];
    $indate = $_POST['exp_date'];
    $sub = $_POST['sub'];
    $quan1 = $_POST['quantity1'];
    $desc = $_POST['desc'];
    $n = count($sub);
    $conn->beginTransaction();
    $sqlresult1= $ins_ons_exp->execute(array($total_exp,$indate,$db_onsID,$exp_maker_id));
    $ons_exp_id = $conn->lastInsertId();
    for ($i = 0; $i < $n; $i++) 
    { 
        $namevalue = "cost_scandoc$i";
        $extension = end(explode(".", $_FILES["$namevalue"]["name"]));
        $image_name = "ons-exp-".$indate."-".$_FILES["$namevalue"]["name"];
        $image_path = "scaned/" .$image_name;
        if (($_FILES["$namevalue"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                {
                    move_uploaded_file($_FILES["$namevalue"]["tmp_name"], "scaned/" .$image_name);
                } 
        $sqlresult2 = $ins_ons_exp_details ->execute(array($sub[$i],$quan1[$i],$desc[$i],$image_path,$ons_exp_id));
    }
    
    $insert = $ins_daily_inout->execute(array($db_onsID,$total_exp));
    
    if($sqlresult1  && $sqlresult2 && $insert)
        {
            $conn->commit();
            echo "<script>alert('দৈনিক অফিস খরচ দেয়া হল')</script>";
        }
        else {
            $conn->rollBack();
            echo "<script>alert('দুঃখিত, দৈনিক অফিস খরচ দেয়া হয়নি')</script>";
        }
}
?>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>
<script type="text/javascript">
    $('.del').live('click',function(){
        $(this).parent().parent().remove();
    });
    $('.add').live('click',function()
    {
        var appendTxt= "<tr><td ><input class='inbox'  id='sub' name='sub[]' type='text' style=' width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;' /><em2> *</em2></td><td><input class='inbox' style='text-align: right;width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;' id='quantity1' name='quantity1[]' type='text' onkeypress='return numbersonly(event)' onblur='calculateTotal(this.value)' />\n\
                                        <em2> *</em2> TK</td>\n\
                                         <td><textarea class='textfield' type='text' id='desc' name='desc[]' ></textarea></td><td ><input class='box5' type='file' id='cost_scandoc' name='cost_scandoc' style='font-size:10px;''/></td><td ><input type='button' class='del' /></td><td><input type='button' class='add' /></td><?php
$new++;
echo $new;
?></tr>";
        $("#container_others:last").after(appendTxt);
    })

window.onclick = function()
    {
        new JsDatePick({
            useMode: 2,
            target: "date",
            dateFormat: "%Y-%m-%d"
        });
    }
    
function checkIt(evt) // float value-er jonno***********************
    {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        status = "";
        return true;
    }
    status = "This field accepts numbers only.";
    return false;
}
function calculateTotal(amount)
{
    var taka = Number(amount);
    var existtaka = Number(document.getElementById('totalamount').value);
    var total = existtaka + taka;
    document.getElementById('totalamount').value = total;
}
function validate() {
        var notOK= 0;
        $(".inbox").filter(function() {
         var val = $(this).val();
        if((val == "") || (val == 0))
            {
                 notOK++;
            }
    });
    return notOK;
 }
function beforeSubmit()
{
    var blank = validate();
    if ((document.getElementById('date').value !="") && blank == 0)
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>
<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="office_sstore_management.php"><b>ফিরে যান</b></a></div>
        <div>
            <form method="POST" enctype="multipart/form-data" action="" id="off_form" name="off_form" onsubmit="return beforeSubmit()">
                <table class="formstyle"  style=" width: 92%;" > 
                    <tr><th colspan="6" style="text-align: center" colspan="4"><h1>অফিস খরচ (দৈনিক)</h1></th></tr>
                    <tr>
                        <td colspan="6"><b>খরচের তারিখঃ </b><input class="box" type="text" id="date" placeholder="Date" name="exp_date"/><em2> *</em2></td>     
                    </tr>               
                    <tr>
                        <td>বিষয়  :</td>
                        <td>পরিমান : <em> (ইংরেজিতে লিখুন)</em></td>
                        <td>ব্যাখ্যা  :</td>
                        <td>স্ক্যান ডকুমেন্টস  :</td>
                    </tr>
                    <tr id="container_others">
                        <td><input class="inbox" id="sub" name="sub[]"  type="text" style=" width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;" /><em2> *</em2></td>
                        <td><input class="inbox" style="text-align: right;width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;"" id="quantity1" name="quantity1[]" type="text" onkeypress="return checkIt(event)" onblur="calculateTotal(this.value);" /><em2> *</em2> TK</td>
                        <td><textarea class="textfield" type="text" id="desc" name="desc[]" ></textarea></td>
                        <td><input class="box5" type="file" id="cost_scandoc0" name="cost_scandoc0" style="font-size:10px;"/></td>
                        <td ></td>
                        <td><input type="button" class="add" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" ><hr /></td>
                    </tr>
                    <tr>
                        <td style="text-align: right">মোট :</td>
                        <td><input class="textfield" id="totalamount" name="totalamount"  type="text" readonly="" style="text-align: right;" value="0" /> TK</td>
                    </tr>
                    <tr>                    
                        <td colspan="4" style="padding-left: 320px; " >
                            </br><input class="btn" style =" font-size: 12px " type="submit" name="submit" id="submit" value="সেভ করুন" readonly="" />
                        </td>                           
                    </tr>
                </table>
            </form>                          
        </div>
    </div>  
</div>    
<?php 
include_once 'includes/footer.php'; 
?>