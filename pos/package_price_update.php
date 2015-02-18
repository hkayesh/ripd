<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';

$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
$check = 0; $msg ="";
$arr_left_qty= array();
$arr_ri8_qty = array();

$inventstmt = $conn->prepare("SELECT * FROM inventory WHERE ins_productid= ? AND ins_ons_type=? AND ins_ons_id =? AND ins_product_type = ? ");
$up_invetory = $conn->prepare("UPDATE inventory SET ins_extra_profit= ?,ins_sellingprice=?, ins_buying_price=? ,ins_profit=? , ins_lastupdate= NOW()
                                                    WHERE ins_product_type='package' AND ins_productid=? AND ins_ons_type=? AND ins_ons_id = ? ");
$selectstmt2 = $conn ->prepare("SELECT * FROM package_details WHERE pckg_infoid = ?");

if(isset($_POST['update']))
{
    $P_updatedpckgbuy = $_POST['updatebuy'];
    $P_updatedpckgsell = $_POST['updatesellprz'];
    $P_updatedpckgprofit = $_POST['updateprofit'];
    $P_updatedpckgxprofit = $_POST['updatexprofit'];
    $P_pckgid = $_POST['pckgID'];
    $yes= $up_invetory->execute(array($P_updatedpckgxprofit,$P_updatedpckgsell,$P_updatedpckgbuy,$P_updatedpckgprofit,$P_pckgid,$scatagory,$storeID));
    if($yes ==1)
    {$msg = "প্যাকেজটি সফলভাবে আপডেট হয়েছে";}
    else { $msg = "দুঃখিত প্যাকেজটি আপডেট হয়নি";}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
<script type="text/javascript">
function numbersonly(e)
   {
        var unicode=e.charCode? e.charCode : e.keyCode
            if (unicode!=8)
            { //if the key isn't the backspace key (which we should allow)
                if (unicode<48||unicode>57) //if not a number
                return false //disable key press
            }
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
function beforeUpdate()
{
    var pv = document.getElementById('updatepv').value;
    if(pv <= 0)
        {
            return false;
        }
        else { return true; }
}
function getUpdate(xprofit) // after update pckg prices
{
   xprofit = Number(xprofit);
   var updatedbuy = Number(document.getElementById('updatebuy').value);
   var updatedsell = Number(document.getElementById('updatesellprz').value);
   var profit = updatedsell - (updatedbuy + xprofit);
   document.getElementById('updateprofit').value = profit;
}
function out()
    {
        setTimeout(function(){parent.location.href=parent.location.href;},1000);
    }
</script>
</head>
    
<body>
 <div id="maindiv">
     <?php if($msg != "") { ?>
        <div align="center" style="color: green;font-size: 26px; font-weight: bold; width: 90%;height: 100px;margin: 0 5% 0 5%;float: none;"><?php echo $msg; echo "<script>out();</script>";?></div></br>
    <?php } else {?>
  <div id="bush" style="width: 99.9%;font-family: SolaimanLipi !important;float: none;border: solid 1px #000;font-size: 14px;">
      <form method="post" action="" onsubmit="return beforeUpdate();">
        <div style="width: 100%;height: auto;float: none;">
            <table>
                <tr>
                    <td>
                        <table style="padding: 0px !important;">
                            <tr>
                                <td colspan="2">
                                    <fieldset style="border-width: 2px;width: 95%;">
                                         <legend style="color: brown;">প্যাকেজ বিবরণ</legend>
                                         <?php
                                                    if(isset($_GET['pckgid']))
                                                    {
                                                        $pckgid = $_GET['pckgid'];
                                                        $type='package';
                                                        $inventstmt->execute(array($pckgid,$scatagory,$storeID,$type));
                                                        $all = $inventstmt->fetchAll();
                                                        foreach($all as $row)
                                                        {
                                                            $db_pckgname= $row['ins_product_code'];
                                                            $db_pckgcode = $row['ins_productname'];
                                                            $db_pckgqty = $row['ins_how_many'];
                                                        }
                                                        $arr_pro_chartid = array();
                                                        $arr_pro_qty = array();
                                                        $selectstmt2->execute(array($pckgid));
                                                        $getall = $selectstmt2->fetchAll();
                                                        foreach($getall as $row2)
                                                        {
                                                            array_push($arr_pro_chartid, $row2['product_chartid']);
                                                            array_push($arr_pro_qty, $row2['product_quantity']);
                                                        }
                                                    }
                                         ?>
                                         <b>প্যাকেজের নাম &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" id="pckgName" name="pckgName" readonly value="<?php echo $db_pckgname;?>"  style="width: 300px;"/><input type="hidden" name="pckgID"  value="<?php echo $pckgid;?>"/></br>
                                         <b>প্যাকেজ কোড &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b> <input type="text" id="pckgCode" name="pckgCode" readonly value="<?php echo $db_pckgcode;?>" style="width: 300px;"/></br>
                                         <b>প্যাকেজের পর্যাপ্ত পরিমান : </b> <input type="text" id="pckgCode" name="pckgCode" readonly value="<?php echo $db_pckgqty;?>" style="width: 300px;"/></br></br>
                                         <table border="1" cellpadding="0" cellspacing="0" style="padding: 0px !important;font-size: 16px;">
                                             <thead style="background-color: #ffcccc">
                                                 <th width="15%">পণ্যের কোড</th>
                                                 <th width="21%">পণ্যের নাম</th>
                                                 <th width="9%">পরিমাণ</th>
                                                  <th width="12%">বর্তমান ক্রয়মূল্য</th>
                                                 <th width="14%">বর্তমান বিক্রয়মূল্য</th>
                                                 <th width="10%">বর্তমান প্রফিট</th>
                                                  <th width="10%">বর্তমান এক্সট্রা প্রফিট</th>
                                             </thead>
                                             <tbody style="font-size: 16px;">
                                             <?php
                                                     $rowcount = count($arr_pro_chartid);
                                                            for($i = 0 ; $i< $rowcount; $i++)
                                                            {
                                                                $prochartid = $arr_pro_chartid[$i];
                                                                $proqty = $arr_pro_qty[$i];
                                                                $type = 'general';
                                                                $inventstmt->execute(array($prochartid,$scatagory,$storeID,$type));
                                                                $all = $inventstmt->fetchAll();
                                                                    foreach($all as $row)
                                                                    {
                                                                        $procode = $row['ins_product_code'];
                                                                        $proname = $row['ins_productname'];
                                                                        $probuy = $row['ins_buying_price'] * $proqty;
                                                                        $prosell = $row['ins_sellingprice'] * $proqty;
                                                                        $proprofit = $row['ins_profit'] * $proqty;
                                                                        $proxprofit = $row['ins_extra_profit'] * $proqty;
                                                                        $buysum = $buysum+$probuy;
                                                                        $sellsum = $sellsum+$prosell;
                                                                        $profitsum = $profitsum+$proprofit;
                                                                        $xprofitsum = $xprofitsum+$proxprofit;
                                                                      }
                                                                   echo "<tr>
                                                                       <td>$procode</td>
                                                                      <td>$proname</td>
                                                                      <td align='center'>$proqty</td>
                                                                      <td>$probuy </td>
                                                                      <td>$prosell</td>
                                                                      <td>$proprofit</td>
                                                                      <td align='center'>$proxprofit </td>
                                                                      </tr>";
                                                                   array_push($arr_left_qty,$proqty);
                                                            }                                         
             ?>
                                             </tbdoy></table></br>         
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <fieldset style="border-width: 3px;width: 90%;">
                                    <legend style="color: brown;">বর্তমানে পণ্যসমূহের মোট মূল্য</legend>
                                         <b>বর্তমান মোট ক্রয়মূল্য &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input name="buyingprz" type="text" readonly style="text-align: right;" value="<?php echo $buysum;?>" /> টাকা</br>
                                         <b>বর্তমান মোট বিক্রয়মূল্য &nbsp;&nbsp;&nbsp;: </b><input type="text" readonly style="text-align: right;" value="<?php echo $sellsum;?>" /> টাকা</br>
                                         <b>বর্তমান মোট প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" readonly style="text-align: right;" value="<?php echo $profitsum;?>"/> টাকা</br>
                                         <b>বর্তমান মোট এক্সট্রা প্রফিট : </b><input type="text" readonly style="text-align: right;" value="<?php echo $xprofitsum;?>" /> টাকা</br>
                                         </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                                $type='package';
                                                        $inventstmt->execute(array($pckgid,$scatagory,$storeID,$type));
                                                        $pckgall = $inventstmt->fetchAll();
                                                        foreach($pckgall as $pckgrow)
                                                        {
                                                           $db_pckgsell = $pckgrow['ins_sellingprice'];
                                                            $db_pckgxprofit = $pckgrow['ins_extra_profit'];
                                                            $db_pckgprofit= $pckgrow['ins_profit'];
                                                            $db_pckgbuy = $pckgrow['ins_buying_price'];
                                                        }
                                    ?>
                                    <fieldset style="border-width: 3px;width: 90%;">
                                    <legend style="color: brown;">বর্তমান প্যাকেজ মূল্য</legend>
                                    <b>বর্তমান প্যাকেজ ক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="currentpckgbuy" name="currentpckgbuy" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgbuy;?>" /> টাকা</br>
                                        <b>বর্তমান প্যাকেজ বিক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="currentpckgprz" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgsell;?>" /> টাকা</br>
                                        <b>বর্তমান প্যাকেজ এক্সট্রা প্রফিট : </b><input id="currentpckgxprft" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgxprofit;?>" /> টাকা</br>
                                        <b>বর্তমান প্যাকেজ প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="currentpckgprft" type="text" readonly style="text-align: right;" value="<?php echo $db_pckgprofit;?>" /> টাকা</br>                                 
                                    </fieldset>
                                </td>
                                <td>
                                    <fieldset style="border-width: 3px;width: 97%;">
                                    <legend style="color: brown;">আপডেট প্যাকেজ মূল্য</legend>
                                         <b>আপডেট প্যাকেজ ক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="updatebuy" name="updatebuy" onkeypress="return checkIt(event)" type="text" style="text-align: right;width: 100px;" value="<?php echo $db_pckgbuy;?>"  /> টাকা</br>
                                         <b>আপডেট প্যাকেজ বিক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="updatesellprz" name="updatesellprz" type="text" onkeypress="return checkIt(event)" style="text-align: right;width: 100px;" value="<?php echo $db_pckgsell;?>"/> টাকা</br>
                                         <b>আপডেট প্যাকেজ এক্সট্রা প্রফিট : </b><input id="updatexprofit" name="updatexprofit" type="text" style="text-align: right;width: 100px;" onkeypress="return checkIt(event)" onblur="getUpdate(this.value)" value="<?php echo $db_pckgxprofit;?>"/> টাকা</br>
                                         <b>আপডেটেট প্যাকেজ প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input id="updateprofit" name="updateprofit" readonly type="text" style="text-align: right;width: 100px;" value="<?php echo $db_pckgprofit;?>"  /> টাকা</br>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2"><input name="update" id="update" type="submit" value="মূল্য আপডেট করুন" style="cursor:pointer;width:120px;height: 25px;font-family: SolaimanLipi !important;" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
</form>
</div>
    <?php }?>
 </div>
</body>
</html>