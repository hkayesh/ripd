<?php
error_reporting(0);
session_start();
include 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$storeName= $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
$msg ="";
$sql_runningpv = $conn->prepare("SELECT * FROM running_command ;");
$sql_runningpv->execute();
$pvrow = $sql_runningpv->fetchAll();
foreach ($pvrow as $value) {
    $current_pv = $value['pv_value'];
}
 $insstmt = $conn ->prepare("INSERT INTO package_inventory(pckg_infoid ,pckg_quantity , pckg_selling_price ,pckg_buying_price, pckg_original_buying_price, pckg_profit, pckg_extraprofit, making_date, pckg_makerid, pckg_type, ons_type, ons_id) VALUES (?, ?, ?, ?, ?, ?, ?, ? ,?, ?, ?, ?)");
 $selectstmt = $conn ->prepare("SELECT * FROM inventory WHERE ins_productid= ? AND ins_ons_type=? AND ins_ons_id =? AND ins_product_type = 'general'");

 if(isset($_POST['ok']))
{
    $P_pckgqty = $_POST['pckgQty'];
    $P_pckgName = $_POST['pckgName'];
    $P_pckgCode = $_POST['pckgCode'];
    $P_pckgID = $_POST['pckgID'];
    $str_chart = $_POST['pckgproid'];
    $str_qty = $_POST['pckgqty'];
    $arr_chart = explode(',', $str_chart);
    $arr_qty = explode(',', $str_qty);
}
if(isset($_POST['entry']))
{
    $P_pckgqty = $_POST['pckgQty'];
    $P_pckgName = $_POST['pckgName'];
    $P_pckgCode = $_POST['pckgCode'];
    $P_pckgID = $_POST['pckgID'];
    $P_pckgbuying = $_POST['pckgbuying'];
    $pckgprofit = $_POST['pckgprofitless'];
    $pckgxprofit = $_POST['pckgxprofitless'];
    $P_pckgselling = $_POST['pckgsellprz'];
     $timestamp=time(); //current timestamp
     $date=date("Y/m/d", $timestamp);  
     $pckgtype = "making";
     $x = $insstmt->execute(array($P_pckgID, $P_pckgqty,$P_pckgselling, $P_pckgbuying,$P_pckgbuying, $pckgprofit, $pckgxprofit, $date, $cfsID, $pckgtype, $scatagory, $storeID));
     
    if($x == 1)
       {
           $msg = "প্যাকেজটি সফলভাবে এন্ট্রি হয়েছে";
        }
    else { $msg = "দুঃখিত প্যাকেজটি এন্ট্রি হয়নি";}
         
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>প্যাকেজের দাম নির্ধারণ</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
<script type="text/javascript">
function getPrice(xprofitless)
{
    var totalsell = Number(document.getElementById('totalsellprz').value);
    var totalxtra = Number(document.getElementById('totalxprofit').value);
    var buy = Number(document.getElementById('pckgbuying').value);
    var sell = Number(document.getElementById('pckgsellprz').value);
    if((sell < totalsell) || (Number(xprofitless) < totalxtra))
        {
            var pckgprofit = sell - (buy + Number(xprofitless)); 
            pckgprofit = (pckgprofit).toFixed(5);
            document.getElementById('pckgprofitless').value = pckgprofit;
    }
    else
        {
            document.getElementById('pckgprofitless').value = 0;
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
function beforeSave()
{
    var pckgpv = document.getElementById('pckgprofitless').value;
    if((pckgpv != 0) && (pckgpv != ""))
        {
            return true;
        }
        else { return false; }
}
</script>
</head>
    
<body>
    <div id="maindiv">
        <div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
<?php
    if($msg != "")
    { ?>
        <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" style="text-decoration: none;" onclick="javasrcipt:window.open('package_list.php');return false;"><img src="images/packagelist.png" style="width: 100px;height: 70px;"/></br>প্যাকেজ লিস্ট</a></div>
</div></br>
<div align="center" style="color: green;font-size: 26px; font-weight: bold; width: 90%;height: 20px;margin: 0 5% 0 5%;float: none;"><?php if($msg != "") echo $msg;?></div></br>
    <?php } 
    else { ?>
    <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?>
    </div></br>
    <form method="post" action="package_price_entry.php" onsubmit="return beforeSave();">
    <div style="width: 100%;float: none;font-family: SolaimanLipi !important;">
        <fieldset style="border-width: 3px;width: 96%;">
         <legend style="color: brown;">প্যাকেজের দাম নির্ধারণ</legend>
         <b>প্যাকেজের নাম&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" id="pckgName" name="pckgName" readonly value="<?php echo $P_pckgName;?>" style="width: 300px;"/></br>
         <b>প্যাকেজ কোড&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" id="pckgCode" name="pckgCode" readonly value="<?php echo $P_pckgCode;?>" style="width: 300px;"/></br>
         <b>প্যাকেজের পরিমাণ : </b><input type="text" id="pckgQty" name="pckgQty" readonly value="<?php echo $P_pckgqty;?>" style="width: 300px;"/>
         <input type="hidden" name="pckgID" readonly value="<?php echo $P_pckgID;?>"/></br></br>
         <table border="1" cellpadding="0" cellspacing="0" >
             <thead style="background-color: #ffcccc">
                 <th width="20%">পণ্যের কোড</th>
                 <th width="30%">পণ্যের নাম</th>
                 <th width="5%">পরিমাণ</th>
                 <th width="10%">ক্রয় মূল্য</th>
                 <th width="10%">বিক্রয় মূল্য</th>
                 <th width="10%">প্রফিট</th>
                 <th width="5%">এক্সট্রা প্রফিট</th>
             </thead>
             <tbody>
             <?php
                         $rowcount = count($arr_chart);
                                                            for($i = 0 ; $i< $rowcount; $i++)
                                                            {
                                                                $prochartid = $arr_chart[$i];
                                                                $proqty = $arr_qty[$i];
                                                                $selectstmt->execute(array($prochartid,$scatagory,$storeID));
                                                                $all = $selectstmt->fetchAll();
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
                                                                      <td>$procode </td>
                                                                      <td>$proname</td>
                                                                      <td align='center'>$proqty</td>
                                                                      <td align='center'>$probuy </td>
                                                                      <td align='center'>$prosell</td>
                                                                      <td align='center'>$proprofit</td>
                                                                      <td align='center'>$proxprofit </td>
                                                                      </tr>";
                                                            }                                         
             ?>
             </tbody>
    </table>
         <div style="font-family: SolaimanLipi !important;width: 100%">
             <div style="width: 48%;font-family: SolaimanLipi !important;float: left;">
                 <fieldset style="border-width: 3px;width: 90%;">
                 <legend style="color: brown;">প্যাকেজ পণ্যসমূহের মোট মূল্য</legend>
                    <b>মোট ক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b><input name="totalbuyprz" type="hidden" id="totalbuyprz" size="20" style="text-align:right;" value="<?php echo $buysum;?>" readonly /> <?php echo english2bangla($buysum);?> টাকা</br>
                    <b>মোট বিক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;:</b><input name="totalsellprz" type="hidden" id="totalsellprz" size="20" style="text-align:right;" value="<?php echo $sellsum;?>" readonly/> <?php echo english2bangla($sellsum);?> টাকা</br>
                     <b>মোট এক্সট্রা প্রফিট :</b><input name="totalxprofit" type="hidden" id="totalxprofit" size="20" style="text-align:right;" value="<?php echo $xprofitsum;?>" readonly/> <?php echo english2bangla($xprofitsum);?> টাকা</br>
                    <b>মোট প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> <input name="totalprofit" type="hidden" id="totalprofit" size="20" readonly style="text-align:right;" value="<?php echo $profitsum;?>"/> <?php echo english2bangla($profitsum);?> টাকা</br>
                    <input type="hidden" name="pckgBuy" readonly value="<?php echo $probuy;?>"/>
                </fieldset>
             </div>
             
             <div style="float: left;width: 48%;">
                 <fieldset style="border-width: 3px;width: 90%;">
                 <legend style="color: brown;">প্যাকেজের মূল্য নির্ধারণ</legend>
                    <b>প্যাকেজ ক্রয়মূল্য&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b> <input name="pckgbuying" type="text" id="pckgbuying" readonly size="20" style="text-align:right;" value="<?php echo $buysum;?>" /> টাকা</br>
                    <b>প্যাকেজ বিক্রয়মূল্য&nbsp;&nbsp;&nbsp; :</b> <input name="pckgsellprz" type="text" id="pckgsellprz" size="20" style="text-align:right;" onkeypress="return checkIt(event)" /> টাকা</br>
                    <b>প্যাকেজ এক্সট্রা প্রফিট :</b> <input name="pckgxprofitless" type="text" id="pckgxprofitless" onkeypress="return checkIt(event)" onblur="getPrice(this.value)" size="20" style="text-align:right;" /> টাকা</br>
                    <b>প্যাকেজ প্রফিট&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b><input name="pckgprofitless" type="text" id="pckgprofitless" readonly size="20" style="text-align:right;" /> টাকা</br>    
                 </fieldset>
            </div>
         </div> 
    </fieldset>
 </div>
        <input name="entry" id="entry" readonly type="submit" value="সেভ করুন"style="cursor:pointer;margin-left:45%;width:80px;height: 25px;font-family: SolaimanLipi !important;" /></br></br>
    </from> <?php }?>
</div>
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
   
</body>
</html>
