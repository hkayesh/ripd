<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/selectQueryPDO.php';
$ins_ons_fixed_exp = $conn->prepare("INSERT INTO ons_fixed_expenditure (month, year, ons_rent, ons_current_bill, ons_water_bill, ons_others_total, ons_monthly_total, status, fk_onsid) 
                                                                VALUES (?,?,?,?,?,?,?,'made',? )");
$ins_others_fixed_exp = $conn->prepare("INSERT INTO ons_fixed_exp_others(ons_cost_type ,ons_cost_amount ,ons_fixed_expenditure_idfixexp) VALUES (?,?,?)");
$insert_notification = $conn->prepare("INSERT INTO notification (nfc_tablename,nfc_tableid,nfc_senderid,nfc_receiverid,nfc_message,nfc_actionurl,nfc_date,nfc_status, nfc_type, nfc_catagory) 
                                                            VALUES ('ons_fixed_expenditure',?,?,?,?,?,NOW(),?,?,?)");
$sql_fixed_expenditure = $conn->prepare("SELECT * FROM ons_fixed_expenditure WHERE fk_onsid =? AND month=? AND year= ? ");

$exp_ons_type = $_SESSION['loggedInOfficeType'];
$exp_ons_id = $_SESSION['loggedInOfficeID'];
$exp_maker_id = $_SESSION['userIDUser'];

// parent ons id find --------------------------------
   if($exp_ons_type == 'office') 
 {
     $sql_select_office->execute(array($exp_ons_id));
     $offrow = $sql_select_office->fetchAll();
     foreach ($offrow as $value) {
         $db_parent_id = $value['parent_id'];
         if($db_parent_id == 0)
              {
                   $sql_select_id_ons_relation->execute(array($exp_ons_type,$exp_ons_id));
                     $onsrow = $sql_select_id_ons_relation->fetchAll();
                     foreach ($onsrow as $value) {
                         $db_parent_onsID = $value['idons_relation'];
                     }
              }
                else 
                    {
                            $sql_select_id_ons_relation->execute(array($exp_ons_type,$db_parent_id));
                            $onsrow = $sql_select_id_ons_relation->fetchAll();
                            foreach ($onsrow as $value) {
                                $db_parent_onsID = $value['idons_relation'];
                        }
                    }
         $sql_select_id_ons_relation->execute(array($exp_ons_type,$db_parent_id));
         $onsrow = $sql_select_id_ons_relation->fetchAll();
         foreach ($onsrow as $value) {
             $db_parent_onsID = $value['idons_relation'];
         }
     }    
 }
 else
 {
     $sql_select_sales_store->execute(array($exp_ons_id));
     $offrow = $sql_select_sales_store->fetchAll();
     foreach ($offrow as $value) {
         $db_parent_id = $value['powerstore_officeid'];
         if($db_parent_id == 0)
         {
              $sql_select_id_ons_relation->execute(array($exp_ons_type,$exp_ons_id));
                $onsrow = $sql_select_id_ons_relation->fetchAll();
                foreach ($onsrow as $value) {
                    $db_parent_onsID = $value['idons_relation'];
                }
         }
         else
         {
             $catagory = 'office';
             $sql_select_id_ons_relation->execute(array($catagory,$db_parent_id));
                $onsrow = $sql_select_id_ons_relation->fetchAll();
                foreach ($onsrow as $value) {
                    $db_parent_onsID = $value['idons_relation'];
                }
         }
     }    
 }
 
$sql_select_id_ons_relation->execute(array($exp_ons_type,$exp_ons_id));
$row = $sql_select_id_ons_relation->fetchAll();
foreach ($row as $onsrow) {
    $db_onsID = $onsrow['idons_relation'];
}
$cost = "SELECT * FROM ons_cost WHERE ons_relation_idons_relation=$db_onsID";
$costsql = mysql_query($cost);
while ($cost_row = mysql_fetch_assoc($costsql)) {
    $costid = $cost_row['idons_cost'];
    $rent = $cost_row['rent'];
    $current = $cost_row['current_bill'];
    $water = $cost_row['water_bill'];
}
$totalcost = $rent + $current + $water;
$count = 0;
$othercost = "SELECT * FROM ons_cost_others WHERE ons_cost_idons_cost=$costid";
$othercostsql = mysql_query($othercost);

while ($othercost_row = mysql_fetch_assoc($othercostsql)) {
    $sub[$count] = $othercost_row['cost_type'];
    $quan[$count] = $othercost_row['cost_amount'];
    $totalcost = $totalcost + $quan[$count];
    $count++;
}

if (isset($_POST['submit'])) // ************************ insert query ******************************
{
    $onsID = $_POST['onsID'];
    $monthly_total = $_POST['totalamount'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $rent1 = $_POST['office_rent1'];
    $e_bill1 = $_POST['electicity_bill1'];
    $w_bill1 = $_POST['water_bill1'];
    $sub = $_POST['sub'];
    $quan1 = $_POST['quantity1'];
    $n = count($sub);
    for ($i = 0; $i < $n; $i++) {
        $othertotal = $othertotal + $quan1[$i];
     }
     $sql_fixed_expenditure->execute(array($onsID,$month,$year));
     $num_rows = count($sql_fixed_expenditure->fetchAll());
     if($num_rows > 0)
     {
         echo "<script>alert('দুঃখিত, এই মাসের মাসিক খরচ তৈরি হয়েগেছে')</script>";
     }
     else
     {
        $conn->beginTransaction();
        $sqlresult1 = $ins_ons_fixed_exp->execute(array($month,$year,$rent1,$e_bill1,$w_bill1,$othertotal,$monthly_total,$onsID));
        $ons_fexp_id = $conn->lastInsertId();
       for ($i = 0; $i < $n; $i++) {
          $sqlresult2 = $ins_others_fixed_exp->execute(array($sub[$i],$quan1[$i],$ons_fexp_id));
       }

       $url = "monthly_cost_approval.php?id=".$ons_fexp_id;
       $status = "unread";
       $type="action";
       $nfc_catagory="official";
       $msg = "অফিস / স্টোরের মাসিক খরচ";
       $sqlrslt3 = $insert_notification->execute(array($ons_fexp_id,$exp_maker_id,$db_parent_onsID,$msg,$url,$status,$type,$nfc_catagory));

        if($sqlresult1  && $sqlresult2 && $sqlrslt3)
           {
               $conn->commit();
               echo "<script>alert('মাসিক অফিস খরচের আবেদন করা হল')</script>";
           }
           else {
               $conn->rollBack();
               echo "<script>alert('দুঃখিত, মাসিক অফিস খরচের আবেদন করা হয়নি')</script>";
           }
     }
}
?>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.inbox').blur(function() {
        var total= 0;
        $(".inbox").filter(function() {
         var val = parseFloat($(this).val());
         total = parseFloat(total) + val;
    });
    $('#totalamount').val(total);
  });
});
function calculate()
{
    var total= 0;
        $(".inbox").filter(function() {
         var val = parseFloat($(this).val());
         total = parseFloat(total) + val;
    });
    $('#totalamount').val(total);
}

$('.del').live('click',function(){
        $(this).parent().parent().remove();
       
    });
    $('.add').live('click',function()
    {
        var appendTxt= "<tr><td><input class='textfield'  id='sub' name='sub[]' type='text' /></td><td><input class='inbox' onblur='calculate()' style='text-align: right;width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;' id='quantity1' name='quantity1[]' type='text' onkeypress='return checkIt(event)'  /><em2> *</em2>\n\
                                         TK </td><td><input type='button' class='del' /></td><td>&nbsp;<input type='button' class='add' /></td></tr>";
        $("#container_others:last").after(appendTxt);
    })
    
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

function validate() {
        var notOK= 0;
        $(".inbox").filter(function() {
         var val = $(this).val();
        if((val == ""))
            {
                 notOK++;
            }
    });
    return notOK;
 }
function beforeSubmit()
{
    var blank = validate();
    if ((document.getElementById('month').value != 0) && blank == 0)
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
            <form method="POST" action="" id="off_form" name="off_form" onsubmit="return beforeSubmit()">
                <table class="formstyle"  > 
                    <tr><th colspan="4" style="text-align: center" colspan="2"><h1>অফিস খরচ (মাসিক)</h1></th></tr>                      
                    <tr>                    
                        <td>
                            <b>মাসঃ </b>
                            <select class='box2' name='month' style="width: 100px;" id="month">
                                <?php
                                $inc = 1;
                                $month_array = array(0=>'সিলেক্ট করুন',1=>'জানুয়ারি', 2=>'ফেব্রুয়ারি', 3 =>'মার্চ', 4=>'এপ্রিল', 5=>'মে', 6=> 'জুন', 7=> 'জুলাই', 8=>'আগষ্ট', 9=> 'সেপ্টেম্বর',10=> 'অক্টোবর',11=> 'নভেম্বর',12=> 'ডিসেম্বর');
                                while (list ($inc, $val) = each($month_array))
                                    echo "<option value=$inc>$val</option>";
                                ?>
                            </select><em2> *</em2>
                        </td>                                    
                        <td>
                            <b>বছরঃ </b>
                            <select class='box2' name='year'>
                                <?php
                                    $thisYear = date('Y');
                                    $startYear = '2000';
                                    foreach (range($thisYear, $startYear) as $year) {
                                    echo '<option value='.$year.'>'. $year .'</option>'; }
                                ?>
                            </select><em2> *</em2>
                        </td>  
                    </tr>     
                    <tr>
                        <td>ভাড়া</td>
                        <td >: <input readonly="" class="inbox" style="text-align: right;width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;" type="text" id="office_rent1" name="office_rent1" onkeypress="return checkIt(event)" value="<?php echo $rent; ?>" /> TK
                        </td>
                    </tr>
                    <tr>
                        <td  >কারেন্ট বিল</td>
                        <td >:   <input class="inbox" style="text-align: right;width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;" type="text" id="electicity_bill1" name="electicity_bill1" onkeypress="return checkIt(event)" value="<?php echo $current; ?>" onblur="calculateTotal(this.value);" /><em2> *</em2> TK<em> (ইংরেজিতে লিখুন)</em></td>
                    </tr>
                    <tr>
                        <td >পানি বিল</td>
                        <td>:   <input class="inbox" style="text-align: right;width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;" type="text" id="water_bill1" name="water_bill1" onkeypress="return checkIt(event)" value="<?php echo $water; ?>" onblur="calculateTotal(this.value);" /><em2> *</em2> TK<em> (ইংরেজিতে লিখুন)</em> </td>
                    </tr>                     
                    <tr>
                        <td colspan="2" ><hr /></td>
                    </tr>
                    <tr>
                        <td style="padding-top: 5px;vertical-align: top; width: 25%;"><b>অন্যান্য</b><input type="hidden" name="onsID" value="<?php echo $db_onsID?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table id="container_others">
                                <tr>
                                     <td>বিষয়  :</td>
                                      <td>পরিমান : <em> (ইংরেজিতে লিখুন)</em></td>
                                 </tr>
                                <?php
                                    for ($i = 0; $i < $count; $i++) {
                                        echo "<tr>";
                                        echo "<td style='width:20%;'><input class='textfield' type='text'  id='sub' name='sub[]' value='$sub[$i]' /></td>";
                                        echo"<td style='width:27%;'><input class='inbox' style='text-align: right;width: 135px;border: 1px inset darkblue;padding-left: 1px;-moz-border-radius: 2px;border-radius: 2px;' id='quantity1' name='quantity1[]' type='text' onkeypress='return checkIt(event)' value='$quan[$i]' /><em2> *</em2> TK</td>";
                                        echo "<td><input type='button' class='add' /></td></tr>";
                                    }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" ><hr /></td>
                    </tr>
                    <tr>
                        <td>মোট</td>
                        <td>: <input class="textfield" id="totalamount" name="totalamount"  type="text" readonly="" style="text-align: right;" value="<?php echo $totalcost;?>" /> TK</td>
                    </tr>
                    <tr>                    
                        <td colspan="4" style="padding-left: 300px; " >
                            </br><input class="btn" style =" font-size: 12px " type="submit" name="submit" id="submit" value="সেভ করুন" />
                        </td>                           
                    </tr>
                </table>
            </form>                          
        </div>
    </div>  
</div>    
<?php  include_once 'includes/footer.php'; ?>