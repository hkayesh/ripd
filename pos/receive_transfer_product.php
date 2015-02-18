<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';

$g_transferID = $_GET['id'];
$g_nfcid = $_GET['nfcid'];

if (!isset($_SESSION['chalanNO'])) { $_SESSION['chalanNO'] = get_time_random_no(10); }
if (!isset($_SESSION['arrProductTemp']))
{
 $_SESSION['arrProductTemp'] = array();
}
$storeName= $_SESSION['loggedInOfficeName'];

$sel_product_chart = $conn->prepare("SELECT * FROM product_chart WHERE idproductchart = ? ");
$sel_transfer_product = $conn->prepare("SELECT * FROM product_transfer WHERE idprotransfer = ? ");
$sel_sales_store = $conn->prepare("SELECT * FROM sales_store WHERE idSales_store= ?");
$sel_office = $conn->prepare("SELECT * FROM office WHERE idOffice= ?");

if(isset($_GET['id']))
{
    $sel_transfer_product->execute(array($g_transferID));
    $row = $sel_transfer_product->fetchAll();
    foreach ($row as $value) {
        $db_trasferNo = $value['pt_transfer_id'];
        $db_sendertype = $value['pt_sender_type'];
        $db_senderid = $value['pt_sender_id'];
        $db_productid = $value['fk_product_chart_id'];
        $db_qty = $value['pt_qty'];
        $db_buyingprice = $value['pt_total_buying'];
        $db_xtraprofit = $value['pt_total_xtraprofit'];
        $db_sendingdate = $value['pt_sending_date'];
        $total_buyingprice = $db_buyingprice + $db_xtraprofit;
        $sub_unitprice = $total_buyingprice / $db_qty;
    }
    $sel_product_chart->execute(array($db_productid));
    $prorow = $sel_product_chart->fetchAll();
    foreach ($prorow as $value) {
        $db_product_name = $value['pro_productname'];
        $db_product_code = $value['pro_code'];
    }
     if($db_sendertype=='s_store')
        {
            $sel_sales_store->execute(array($db_senderid));
            $storereslt = $sel_sales_store->fetchAll();
            foreach ($storereslt as $storerow) {
                $db_storename = $storerow['salesStore_name'];
                $db_storeacc = $storerow['account_number'];
            }
        }
        elseif($db_sendertype=='office')
        {
            $sel_office->execute(array($db_senderid));
            $storereslt = $sel_office->fetchAll();
            foreach ($storereslt as $storerow) {
                $db_storename = $storerow['office_name'];
                $db_storeacc = $storerow['account_number'];
            }
        }
        $arr_temp = array($db_product_name,$db_product_code,$db_qty,$total_buyingprice,$sub_unitprice);
        $_SESSION['arrProductTemp'][$db_productid] = $arr_temp;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>প্রোডাক্ট গ্রহন</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
<style type="text/css">
.prolinks:focus{
    background-color: cadetblue;
    color: yellow !important;
}
.prolinks:hover{
    background-color: cadetblue;
    color: yellow !important;
}
</style>
<script type="text/javascript" src="scripts/jquery-1.4.3.min.js"></script>
<!--===========================================================================================================================-->
<script LANGUAGE="JavaScript">
function checkIt(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        status = ""
        return true
    }
    status = "This field accepts numbers only."
    return false
}
function numbersonly(e)
{
        var unicode=e.charCode? e.charCode : e.keyCode
            if (unicode!=8)
            { //if the key isn't the backspace key (which we should allow)
                if (unicode<48||unicode>57) //if not a number
                return false //disable key press
            }
}
function showbox()
{
     elements = $('.both_box');
    elements.each(function() { 
        $(this).css("visibility","visible"); 
    });
}
function hidebox()
{
    elements = $('.both_box');
    elements.each(function() { 
        $(this).css("visibility","hidden"); 
    });
}

function beforeSave()
{
      var a=document.getElementById('transportCost').value;
      var radiocheck = 0;
      var radios = document.getElementsByName("purchaseType");
      for(var i=0; i<radios.length; i++){
	if(radios[i].checked) { radiocheck = 1; }
	}
    if ((a != "") && (radiocheck == 1)) 
    { return true; }
    else { alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false;  }
 }
</script>
<script>
var  state="";
function checkbalan(reuse) // to check balance for reuse*******************
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
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                state = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/inProductTemporary.php?check=1&reuseamount="+reuse,false);
        xmlhttp.send();    
}
function calculateInvest(reuse)
{
    checkbalan(reuse);
    if(state == '1')
        {
            var total = Number(document.getElementById('totalBuyingPrice').value) + Number(document.getElementById('transportCost').value);
            var invest = total - Number(reuse);
            document.getElementById('investAmount').value = invest;
        }
        else if(state == '0'){
            alert('দুঃখিত, এই পরিমান টাকা রিইউজ করতে পারবেন না');
            document.getElementById('reuseAmount').value = 0;
             document.getElementById('investAmount').value = 0;
        }
}

</script>  
</head>
    
<body>
<div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
<div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="../notification.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    
</div>
</br>
<fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
         <legend style="color: brown;">ট্রান্সফারকৃত পণ্যের বিবরণ</legend>
         <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
             <tr>
                 <td width="30%"><b>ট্রান্সফার চালান নং</b></td>
                 <td><?php echo $db_trasferNo;?></td>
             </tr>
             <tr>
                 <td><b>পণ্যের কোড</b></td>
                 <td><?php echo $db_product_code;?></td>
             </tr>
             <tr>
                 <td><b>পণ্যের নাম</b></td>
                 <td><?php echo $db_product_name;?></td>
             </tr>
             <tr>
                 <td><b>ট্রান্সফারকৃত পরিমান</b></td>
                 <td><?php echo $db_storename;?></td>
             </tr>
             <tr>
                 <td><b>ট্রান্সফারের তারিখ</b></td>
                 <td><?php echo english2bangla(date("d/m/Y",  strtotime($db_sendingdate)));?></td>
             </tr>
             <tr>
                 <td><b>ট্রান্সফারকারী অফিস / সেলসস্টোর</b></td>
                 <td><?php echo $db_storename;?></td>
             </tr>
         </table>
</fieldset>
<form action="productIN_details.php?back=1&nfcid=<?php echo $g_nfcid;?>&ptID=<?php echo $g_transferID?>" method="post" enctype="multipart/form-data" >
  <fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
    <legend style="color: brown;">প্রবেশকৃত পণ্যের বর্ণনা</legend>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
      <tr>
          <td width="3%" style="color: #0000cc;text-align: center;"><strong>ক্রম</strong></td>
          <td width="19%" style="color: #0000cc;text-align: center;"><strong>প্রোডাক্ট কোড</strong></td>
        <td width="37%" style="color: #0000cc;text-align: center;"><strong>প্রোডাক্টের নাম</strong></td>
        <td width="8%" style="color: #0000cc;text-align: center;"><strong>পরিমান</strong></td>
        <td width="13%" style="color: #0000cc;text-align: center;"><strong>সর্বমোট মূল্য (টাকা)</strong></td>
        <td width="14%" style="color: #0000cc;text-align: center;"><strong>প্রতি একক মূল্য (টাকা)</strong></td>
      </tr>
        <tbody id="tablebody">
        <?php
            $sl = 1;
            foreach($_SESSION['arrProductTemp'] as $key => $proinfo) {
                $slNo = english2bangla($sl);
                echo '<tr>
                        <td style="text-align: center;">'.$slNo.'</td>
                        <td style="text-align: left;padding-left:2px;">'.$proinfo['1'].'</td>
                        <td style="text-align: left;">'.$proinfo['0'].'</td>
                        <td style="text-align: center;">'.english2bangla($proinfo['2']).'</td>
                        <td style="text-align: right;padding-right:2px;">'.english2bangla($proinfo['3']).'</td>
                        <td style="text-align: right;padding-right:2px;">'.english2bangla($proinfo['4']).'</td>';
                $sl ++;
            }
        ?>
        </tbody>
</table>
    <table width="100%" cellspacing="0" cellpadding="0" style="border: 1px solid black;  font-size:18px;">
        <?php
             if(isset($_SESSION['chalanArray']))
             {
                 $totalTransportCost =$_SESSION['chalanArray'][1];
                 $comment =$_SESSION['chalanArray'][2];
                 $totalOtherCost =$_SESSION['chalanArray'][3];
             }
        ?>
        <tr>
            <td>সর্বমোট ক্রয়মূল্য</td>
            <td>: <input type="text" id="totalBuyingPrice" name="totalBuyingPrice" style="text-align: right;" readonly value="<?php echo $total_buyingprice?>" /> টাকা</td>
        </tr>
        <tr>
            <td>পরিবহন খরচ</td>
            <td>: <input type="text" id="transportCost" name="transportCost" style="text-align: right;" onkeypress="return checkIt(event)" value="<?php echo $totalTransportCost;?>" /> টাকা <em>*</em></td>
            <td rowspan="3">মন্তব্য</br><textarea name="transportComment"><?php echo $comment;?></textarea></td>
        </tr>
        <tr>
            <td>অন্যান্য খরচ</td>
            <td>: <input type="text" id="otherCost" name="otherCost" style="text-align: right;" onkeypress="return checkIt(event)" value="<?php echo $totalOtherCost;?>" /> টাকা</td>
        </tr>
        <tr>
            <td>চালান কপি</td>
            <td>: <input type="file" name="chalanCopy" /></td>
        </tr>
        <tr>
            <td><input type="radio" name="purchaseType" value="invest" onclick="hidebox()" />ইনভেস্ট</td>
            <td><input type="radio" name="purchaseType" value="reuse" onclick="hidebox()" />রিইউজ</td>
            <td><input type="radio" name="purchaseType" value="both" onclick="showbox();" />ইনভেস্ট এন্ড রিইউজ</td>
        </tr>
        <tr class="both_box" style="visibility: hidden;">
            <td colspan="2" style="text-align: right;">রিইউজের পরিমান : <input type="text" id="reuseAmount" name="reuseAmount" style="text-align: right;" onkeypress="return checkIt(event)" onkeyup="calculateInvest(this.value);"  /> টাকা</td>
            <td style="text-align: right;">ইনভেস্টের পরিমান : <input type="text" id="investAmount" name="investAmount" style="text-align: right;" readonly /> টাকা</td>
        </tr>
    </table>
</fieldset>
    <input class="btn" onclick="return beforeSave();" name="next" id="next" type="submit" value="বিস্তারিত দেখুন" style="cursor:pointer;margin-left:45%;font-family: SolaimanLipi !important;" /></br></br>
</form>
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
  </div>
</body>
</html>