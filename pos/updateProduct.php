<?php
error_reporting(0);
session_start();
include_once 'includes/MiscFunctions.php';
include 'includes/connectionPDO.php';
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
$g_proid = $_GET['proid'];
$msg ="";

$sql_inven_sel = $conn->prepare("SELECT * FROM inventory WHERE idinventory = ? AND ins_ons_type= ? AND ins_ons_id = ? AND ins_product_type='general';");
$sql_puchase_sel = $conn->prepare("SELECT * FROM product_purchase WHERE Product_chart_idproductchart = ? AND in_ons_type= ? AND in_onsid = ? ORDER BY in_input_date DESC LIMIT 1");
$upquery_inven = $conn->prepare("UPDATE `inventory` SET ins_buying_price=?, `ins_extra_profit` = ?, `ins_sellingprice` = ?, `ins_profit` = ?,`ins_lastupdate` = NOW()  WHERE `idinventory` =? AND ins_ons_type= ? AND ins_ons_id = ? AND ins_product_type='general' ");

$sqlpv = $conn->prepare("SELECT * FROM running_command;");
$sqlpv->execute();
$pvrow = $sqlpv->fetchAll();
foreach ($pvrow as $row) {
    $unitpv= $row['pv_value'];
}
$sql_inven_sel->execute(array($g_proid,$scatagory,$storeID));
$getresult = $sql_inven_sel->fetchAll();
foreach ($getresult as $row1) {
    $db_productname = $row1['ins_productname'];
    $db_buying = $row1['ins_buying_price'];
    $db_selling = $row1['ins_sellingprice'];
    $db_xtraprofit = $row1['ins_extra_profit'];
    $db_qty = $row1['ins_how_many'];
    $db_profit = $row1['ins_profit'];
    $db_chartID = $row1['ins_productid'];
}
$sql_puchase_sel->execute(array($db_chartID,$scatagory,$storeID));
$result_purchase = $sql_puchase_sel->fetchAll();
foreach ($result_purchase as $row2) {
    $db_purchase_date= $row2['in_input_date'];
    $db_pur_buying = $row2['in_buying_price'];
    $db_pur_selling = $row2['in_sellingprice'];
    $db_pur_xtraprofit = $row2['in_extra_profit'];
    $db_pur_qty = $row2['in_howmany'];
    $db_pur_profit = $row2['in_profit'];
}

if(isset($_POST['update'])) //************************ update query **********************************
{
    $p_proid = $_POST['proid'];
    $p_buying = $_POST['updatedbuying'];
    $p_selling = $_POST['updatedselling'];
    $p_xtraprofit = $_POST['updatedxprofit'];
    $p_profit = $_POST['updatedprofit'];
    $uprslt = $upquery_inven->execute(array($p_buying,$p_xtraprofit,$p_selling,$p_profit,$p_proid,$scatagory,$storeID));
    if ($uprslt ==1)
        {$msg = "প্রোডাক্টের মূল্য আপডেট হয়েছে";}
        else { $msg ="দুঃখিত, আপডেট হয়নি"; }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
<script type="text/javascript">
function checkIt(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        return true;
    }
    return false;
}
function calculate(val)
{ 
    var xprofit = Number(val);
    var buying = Number(document.getElementById("updatedbuying").value);
    var selling = Number(document.getElementById("updatedselling").value);
    var profit = selling - (buying + xprofit);
    if(selling < buying)
        {
            alert("দুঃখিত, বিক্রয়মূল্য <= ক্রয়মূল্য হতে পারবে না\n এবং\n প্রফিট ০ হতে পারবে না");
            document.getElementById("updatedprofit").value = 0;
        }
        else {
                document.getElementById("updatedprofit").value = profit;
        }
}
function beforeSave()
{
   var profit = document.getElementById("updatedprofit").value;
   if(profit !="" && profit!= 0)
       {
           return true;
       }
       else { return false;}
}
function out()
    {
        setTimeout(function(){parent.location.href=parent.location.href;},1000);
    }
</script>
</head>
    
<body>
<div id="maindiv">
<div class="wraper" style="width: 99%;font-family: SolaimanLipi !important;">
   <?php
        if($msg !="")
            { echo " <div class='top' style='width: 100%;height: auto;text-align:center;font-size:18px;'>
                <b><font color='green;'>$msg</font></b></div>"; 
                echo "<script>out();</script>";
            } 
    else { ?>
    <div style="width: 100%;font-family: SolaimanLipi !important;">
        <form method="post" action="" onsubmit="return beforeSave();">
            <table border="1" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="50%"> প্রোডাক্টের নাম : <input type="hidden" name="proid" value="<?php echo $g_proid?>"/><?php echo $db_productname;?></td>
                    <td width="50%"> বর্তমানে পর্যাপ্ত পরিমান : <?php echo english2bangla($db_qty);?></td>
                </tr>
            </table>
            <fieldset style="border-width: 3px;width: 95%;">
                <legend style="color: brown;">প্রোডাক্টের সর্বশেষ ক্রয়ের মূল্য</legend>
                <table border="1" cellpadding="0" cellspacing="0" style="font-family: SolaimanLipi !important;">
                    <tr>
                        <td width="50%">ক্রয়কৃত পরিমান : <?php echo english2bangla($db_pur_qty) ?></td>
                        <td width="50%" style="text-align: left;">ক্রয়ের তারিখ : <?php echo english2bangla(date("d-m-Y",  strtotime($db_purchase_date))); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">ক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" readonly name="buyingprice" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" value="<?php echo $db_pur_buying; ?>" /> টাকা</td>
                    </tr>
                    <tr>
                        <td colspan="2">বিক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" readonly name="sellingprice" value="<?php echo  $db_pur_selling;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /> টাকা</td>
                    </tr>
                    <tr>
                        <td colspan="2">এক্সট্রা প্রফিট : <input type="text" readonly name="xprofit" value="<?php echo $db_pur_xtraprofit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /> টাকা</td>
                    </tr>
                    <tr>
                        <td colspan="2">প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" readonly name="xprofit" value="<?php echo $db_pur_profit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /> টাকা</td>
                    </tr>
                </table>
            </fieldset>
                <table cellpadding="0" cellspacing="0" style="font-family: SolaimanLipi !important;">
                    <tr>
                        <td>
                            <fieldset style="border-width: 2px;width: 90%;">
                                <legend style="color: brown;">প্রোডাক্টের বর্তমান মূল্য</legend>
                                <table border="1" cellpadding="0" cellspacing="0" style="font-family: SolaimanLipi !important;">
                                    <tr>
                                        <td colspan="2">ক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" readonly name="buyingprice" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" value="<?php echo $db_buying; ?>" /> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">বিক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" readonly name="sellingprice" value="<?php echo  $db_selling;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">এক্সট্রা প্রফিট : <input type="text" name="xprofit" readonly value="<?php echo $db_xtraprofit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" readonly name="xprofit" value="<?php echo $db_profit;?>" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" /> টাকা</td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                        <td>
                            <fieldset style="border-width: 2px;width: 90%;">
                                <legend style="color: brown;">আপডেট প্রোডাক্টের মূল্য</legend>
                                <table border="1" cellpadding="0" cellspacing="0" style="font-family: SolaimanLipi !important;">
                                    <tr>
                                        <td colspan="2">ক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name="updatedbuying" id="updatedbuying" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" onkeypress='return checkIt(event)' /> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">বিক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name="updatedselling" id="updatedselling"  style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" onkeypress='return checkIt(event)' /> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">এক্সট্রা প্রফিট : <input type="text" name="updatedxprofit" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" onkeyup="calculate(this.value)" onkeypress='return checkIt(event)' /> টাকা</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name="updatedprofit" id="updatedprofit" style="width: 100px;text-align: right;padding-right: 5px;font-size: 16px;" readonly /> টাকা</td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                </table>
            <input class="btn" type="submit" readonly name="update" value="আপডেট প্রোডাক্ট মূল্য" style="margin-left: 38%;cursor:pointer;width: 200px;" />
        </form>
   </div><?php }?>
</div></br>
</div>
</body>
</html>