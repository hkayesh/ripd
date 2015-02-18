<?php
error_reporting(0);
session_start();
include_once 'includes/ConnectDB.inc';
include_once './includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';

$storeName= $_SESSION['loggedInOfficeName'];
$sel_current_pv = $conn->prepare("SELECT pv_value FROM running_command");
$sel_current_pv->execute();
$arr_rslt = $sel_current_pv->fetchAll();
foreach ($arr_rslt as $value) {
    $running_pv = $value['pv_value'];
}
$sel_pv_view = mysql_query("SELECT * FROM view_pv_view WHERE cust_type = 'no_acc' AND sales_type= 'whole' AND account_type_id= 0");

while($row = mysql_fetch_assoc($sel_pv_view)) {
    $less = $row['less_amount'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>হোলসেল কার্যক্রম</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script language="JavaScript" type="text/javascript" src="scripts/suggest.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/productsearch.js"></script>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
 <script src="scripts/tinybox.js" type="text/javascript"></script>
 <script src="scripts/jquery-1.4.3.min.js" type="text/javascript"></script>
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
<!--===========================================================================================================================-->
<script language="javascript" type="text/javascript">
        $(document).ready(function(){
    $("#barcode").keydown(function(e){
        if(e.which==17 || e.which==74){
            var code = $('#barcode').val();
            readBarcode(code,'wholesale.php');
            e.preventDefault();
        }else{
            console.log(e.which);
        }
    })
});

function multiply(){
    a=Number(document.abc.QTY.value);
    b=Number(document.abc.PPRICE.value);
    c=a*b;
    document.abc.TOTAL.value=c;
    
    var less_percent = <?php echo $less?>;

    z=Number(document.abc.ProPV.value);
    pv=a*z;
    document.abc.SubTotalPV.value=pv;
    
    profit = Number(document.abc.Profit.value);
    subtotalprofit = profit * a;
    maxprofitless = (subtotalprofit * less_percent) / 100;
    document.abc.maxprofitless.value= maxprofitless;
    //document.abc.subprofit.value= subtotalprofit;

    xtraprofit = Number(document.abc.XProfit.value);
    subtotalXtraprofit = xtraprofit * a;
    document.abc.subxtraProfit.value= subtotalXtraprofit;

    if (a!=0) // some logic to determine if it is ok to go
        {document.getElementById("addtoCart").disabled = false;}
      else // in case it was enabled and the user changed their mind
        {document.getElementById("addtoCart").disabled = true;}

}
</script>
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

function checkLimit(lessprofit)
{
    var maxprofitless =  Number(document.getElementById('maxprofitless').value);
    if(Number(lessprofit) > maxprofitless)
        {
            alert("দুঃখিত, এই পরিমান প্রফিট লেস দেয়া যাবে না");
        }
}
function minus(){
a=Number(document.mn.cash.value);
w=Number(document.mn.gtotal.value);
c=a-w;
document.mn.change.value= c.toFixed(2);
if(c >= 0)
    {
        document.getElementById('checkField').value=1;
        if( c % 1 !== 0)
                {
                    document.getElementById('floorvalue').value= Math.floor(c);
                    document.getElementById('floor').innerHTML=Math.floor(c);
                    document.getElementById('ceilingvalue').value=Math.ceil(c);
                    document.getElementById('ceiling').innerHTML=Math.ceil(c);
                }
              else
                {
                    document.getElementById('floorvalue').value= Math.floor(c);
                    document.getElementById('floor').innerHTML=Math.floor(c);
                    document.getElementById('ceilingvalue').value=Math.ceil(c);
                    document.getElementById('ceiling').innerHTML=Math.ceil(c);
                }
    }
    else { document.getElementById('checkField').value=0; }
}
function beforeSave()
{
    if((document.getElementById('checkField').value != 0))
    {
        document.getElementById('print').readonly = false; 
        return true; 
    }
    else { return false; }        
}
</script>
<script>
function getXMLHTTP() { 
		var xmlhttp=false;	
		try{ xmlhttp=new XMLHttpRequest();}
		catch(e){		
			try{xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");}
			catch(e){
                                                                        try{xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");}
				catch(e1){xmlhttp=false;}
                                                                    }
                                                  }
		 return xmlhttp;
}
function checkQty(qty)
{
    var inventoryid = document.getElementById('inventoryID').value;
   var reqst = getXMLHTTP();		
	if (reqst) 
	{
                    reqst.onreadystatechange = function()
		{
		if (reqst.readyState == 4) 
			{			
                                                        if (reqst.status == 200)
				{
                                                                            var jc= document.getElementById('checkresult').innerHTML=reqst.responseText;
                                                                            if(jc == 1) {multiply();}
                                                                                else {                                                                                     
                                                                                    document.getElementById('TOTAL').value=0;
                                                                                    document.getElementById("QTY").value = 0;
                                                                                    alert("দুঃখিত, পর্যাপ্ত পরিমান প্রোডাক্ট নেই");
                                                                                   
                                                                                }
                                                                         } 
				else 
				{alert("There was a problem while using XMLHTTP:\n" + reqst.statusText);}
			}				
		 }			
		 reqst.open("GET","includes/checkProductQty.php?qty="+qty+"&id="+inventoryid, true);
		 reqst.send(null);
	}	
}
function showCustInfo(custType)
{
    var reqst = getXMLHTTP();		
	if (reqst) 
	{
                    reqst.onreadystatechange = function()
		{
		if (reqst.readyState == 4) 
			{			
                                                        if (reqst.status == 200)
				{ document.getElementById('customerInfo').innerHTML=reqst.responseText;} 
				else 
				{alert("There was a problem while using XMLHTTP:\n" + reqst.statusText);}
			}				
		 }			
		 reqst.open("GET","includes/showCustomerInfo.php?type="+custType+"&selltype=2", true);
		 reqst.send(null);
	}		
}
function showPayType(payType)
{
var reqst = getXMLHTTP();		
	if (reqst) 
	{
                    reqst.onreadystatechange = function()
		{
		if (reqst.readyState == 4) 
			{			
                                                        if (reqst.status == 200)
				{ document.getElementById('payInfo').innerHTML=reqst.responseText;} 
				else 
				{alert("There was a problem while using XMLHTTP:\n" + reqst.statusText);}
			}				
		 }			
		 reqst.open("GET","includes/showPayInfo.php?type="+payType+"&selltype=2", true);
		 reqst.send(null);
	}		
}
function showStoreName(acNo)
{
var reqst = getXMLHTTP();		
	if (reqst) 
	{
                    reqst.onreadystatechange = function()
		{
		if (reqst.readyState == 4) 
			{			
                                                        if (reqst.status == 200)
				{ document.getElementById('storeName').value=reqst.responseText;} 
				else 
				{alert("There was a problem while using XMLHTTP:\n" + reqst.statusText);}
			}				
		 }			
		 reqst.open("GET","includes/getAccountInfo.php?acno="+acNo+"&type=store", true);
		 reqst.send(null);
	}		
}
function showOffName(acNo)
{
    var reqst = getXMLHTTP();		
	if (reqst) 
	{
                    reqst.onreadystatechange = function()
		{
		if (reqst.readyState == 4) 
			{			
                                                        if (reqst.status == 200)
				{ document.getElementById('offName').value=reqst.responseText;} 
				else 
				{alert("There was a problem while using XMLHTTP:\n" + reqst.statusText);}
			}				
		 }			
		 reqst.open("GET","includes/getAccountInfo.php?acno="+acNo+"&type=off", true);
		 reqst.send(null);
	}	
}

function readBarcode(code,location) {
    var reqst = getXMLHTTP();		
        if (reqst) 
        {
            
            reqst.onreadystatechange = function()
            {
                if (reqst.readyState == 4) 
                {			
                    if (reqst.status == 200)
                    { 
                        var id =reqst.responseText;
                        window.location=location+"?code="+id;
                    } 
                    else 
                    {alert("There was a problem while using XMLHTTP:\n" + reqst.statusText);}
                }				
            }			
            reqst.open("GET", "searchsuggest2.php?code="+code, true);
            reqst.send(null);
        }	
}   

function addToCart() // to add into temporary array*******************
{
        var id = document.getElementById("inventoryID").value;
        var name = document.getElementById("pname").value;
        var code = document.getElementById("procode").value;
        var qty = Number(document.getElementById("QTY").value);
        var totalamount = Number(document.getElementById("TOTAL").value);
        var sell = Number(document.getElementById("PPRICE").value);
        var buy = Number(document.getElementById("buyprice").value) * (qty); 
        var totalpv = Number(document.getElementById("SubTotalPV").value);
        var profitless = Number(document.getElementById("lessProfit").value);
        var profit = Number(document.getElementById("Profit").value);
        var xprofit = Number(document.getElementById("XProfit").value);
        if(qty != 0)
            {
              var reqst = getXMLHTTP();		
	if (reqst) 
	{
                    reqst.onreadystatechange = function()
		{
		if (reqst.readyState == 4) 
			{			
                                                        if (reqst.status == 200)
				{ location.reload(); } 
				else 
				{alert("There was a problem while using XMLHTTP:\n" + reqst.statusText);}
			}				
		 }			
		 reqst.open("GET","addorder.php?selltype=2&id="+id+"&code="+code+"&name="+name+"&qty="+qty+"&total="+totalamount+"&selling="+sell+"&buying="+buy+"&totalpv="+totalpv+"&lessProfit="+profitless+"&profit="+profit+"&xprofit="+xprofit, true);
		 reqst.send(null);
	}	
            }
            else { alert("দুঃখিত, পরিমান অথবা ক্রয়মূল্য ০ হতে পারবে না") ;}
}
</script>  
 <script type="text/javascript">
 function pinGenerate()
	{ TINY.box.show({url:'pinGenerator.php',animate:true,close:true,boxid:'error',top:100,width:400,height:100}); }
 </script>   
</head>
    
<body>
<div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
<div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" onclick="javasrcipt:window.open('product_list.php');return false;"><img src="images/productList.png" style="width: 100px;height: 70px;"/></br>প্রোডাক্ট লিস্ট</a></div>
</div>
</br>
        <form action="" method="post" name="abc">
     <fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
         <legend style="color: brown;">পণ্যের বিবরণী</legend>
    <div class="top" style="width: 100%;">
        <div class="topleft" style="float: left;width: 25%;">
            <b>বার কোড :</b><br/>
            <input type="text" id="barcode" name="barcode"/><br/>
            <b>প্রোডাক্ট কোড:</b></br>
      <input type="text" id="amots" name="amots" onKeyUp="bleble('wholesale.php');" autocomplete="off"/>
      <div id="layer2"style="width:400px;position:absolute;top:53%;left:8%;z-index:1;padding:5px;border: 1px solid #000000; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" ></div></br>
      <b>প্রোডাক্ট নাম:</b>
      <input type="text" id="allsearch" name="allsearch" onKeyUp="searchProductAll('wholesale.php');" autocomplete="off"/>
      <div  id="searchResult"style="position:absolute;top:61.5%;left:8%;width:350px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" ></div>
    </div>
    <div class="topright" style="float:left; width: 75%;">
<?php
	if (isset($_GET['code']))
     	{
                        $G_inventoryID = $_GET['code'];
                        $row = $_SESSION['pro_inventory_array'][$G_inventoryID];
                        $db_proname=$row["ins_productname"];
                        $db_price=$row["ins_sellingprice"];
                        $db_inventoryid=$row["idinventory"];
                        $db_procode=$row["ins_product_code"];
                        $db_profit=$row["ins_profit"];
                        $db_proPV = $db_profit * $running_pv;
                        $db_xtraProfit=$row["ins_extra_profit"];
                        $db_buyingprice = $row['ins_buying_price'];                     
                    }
?>
<table width="100%" cellspacing="0"  cellpadding="0" style="border: #000000 inset 1px; font-size:20px;">
  <tr>
      <td colspan="2"><span style="color: #03C;"> প্রোডাক্টের নাম: </span><input name="PNAME" id="pname" type="text" value="<?php echo $db_proname; ?>" style="border:0px;font-size: 18px;width: 400px;" readonly/>
           <input name="inventoryID" id="inventoryID" type="hidden" value="<?php echo $db_inventoryid; ?>"/>      
           <input name="procode" id="procode" type="hidden" value="<?php echo $db_procode; ?>"/><input name="propv" id="ProPV" type="hidden" value="<?php echo $db_proPV; ?>"/>
           <input name="profit" id="Profit" type="hidden" value="<?php echo $db_profit; ?>"/>
           <input name="xtraprofit" id="XProfit" type="hidden" value="<?php echo $db_xtraProfit; ?>"/>
           <input name="less" type="hidden"/>
      </td>
      <td><span style="color: #03C;">প্রোডাক্টের মূল্য: </span><input name="PPRICE" id="PPRICE" type="text" value="<?php echo $db_price ;?>" style="border:0px;font-size: 18px;width: 100px;text-align: right;"/> টাকা<input name="buyprice" id="buyprice" type="hidden" value="<?php echo $db_buyingprice; ?>"/></td>
  </tr>
  <tr>
      <td ><span style="color: #03C;"> পরিমাণ</span> <input name="QTY" id="QTY" type="text" onkeyup="checkQty(this.value);" onkeypress="return checkIt(event)" style="width:100px;"/><input type="hidden" id="checkresult" value=""/></td>
        <td ><span style="color: #03C;"> প্রফিটে সর্বোচ্চ ছাড় </span><input name="maxprofitless" id="maxprofitless" type="text"  readonly style="width:100px;text-align: right;"/> টাকা</td>     
      <td  rowspan="2"><input type="button" onclick="addToCart();" name="addButton" style="height:100px; width: 100px;background-image: url('images/add to cart.jpg');background-repeat: no-repeat;background-size:100% 100%;cursor:pointer;" id="addtoCart" value="" /></td>
    </tr>
  <tr>
      <td><span style="color: #03C;"> মোট</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="TOTAL" id="TOTAL" type="text" readonly="readonly" style="width:100px;text-align: right;"/> টাকা<input name="subTotalpv" id="SubTotalPV"type="hidden"/></td>
      <td ><span style="color: #03C;"> প্রফিটে ছাড় </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="lessProfit" id="lessProfit" type="text" onkeyup="checkLimit(this.value)" onkeypress="return checkIt(event)" style="width:100px;text-align: right;"/> টাকা</td>
    <td></td>
  </tr>
</table>
</div>
</div>
</fieldset></form>

<fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
<legend style="color: brown;">ক্রয়কৃত পণ্যের তালিকা</legend>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
      <tr>
        <td width="15%"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="23%"><div align="center"><strong><span style="width:130px;">প্রোডাক্টের নাম</span></strong></div></td>
        <td width="7%"><div align="center"><strong>পরিমাণ</strong></div></td>
        <td width="11%"><div align="center"><strong>একক বিক্রয়মূল্য</strong></div></td>
        <td width="11%"><div align="center"><strong>মোট বিক্রয়মূল্য</strong></div></td>
        <td width="11%"><div align="center"><strong>প্রফিটে ছাড়</strong></div></td>
        <td width="13%"><div align="center"><strong>মোট টাকা</strong></div></td>
        <td width="5%">&nbsp;</td>
      </tr>
    <?php
        foreach($_SESSION['arrSellTemp'] as $key => $row) 
            {
                echo '<tr>';
                echo '<td><div align="left">'.$row[0].'</div></td>';
                  echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$row[1].'</div></td>';
                  echo '<td><div align="center">'.english2bangla($row[4]).'</div></td>';
                  echo '<td><div align="center">'.english2bangla($row[3]).'</div></td>';
                  echo '<td><div align="center">'.english2bangla($row[3] * $row[4]).'</div></td>';
                  echo '<td><div align="center">'.english2bangla($row[7]).'</div></td>';
                  echo '<td><div align="center">'.english2bangla($row[5]).'</div></td>';
                  echo '<td style="text-align:center"><a href=delete.php?selltype=wholesale.php&id='.$key.'><img src="images/del.png" style="cursor:pointer;" width="20px" height="20px" /></a></td>';
                  echo '</tr>';
}
?>
    </table>
</fieldset>
<form action="preview2.php" method="post" name="mn" id="suggestSearch">
<div align="right" style="margin-top:10px;margin-right:100px;font-family: SolaimanLipi !important;">
    <?php
        $finalTotal =0; $finalProfitless = 0; $totalsellingprice = 0;
             foreach($_SESSION['arrSellTemp'] as $key => $row) {
                   $finalTotal = $finalTotal + $row[5];
                   $finalProfitless= $finalProfitless+ $row[7];
                   $totalsellingprice = $totalsellingprice + ($row[3] * $row[4]);
              }
    ?>
    <b>মোট বিক্রয়মূল্য&nbsp;:</b> <?php echo english2bangla($totalsellingprice);?> টাকা</br>
    <b>মোট প্রফিট ছাড়&nbsp;:</b> <input name="totalprofiless" type="hidden" id="totalprofitless" size="20"  readonly style="text-align:right;" value="<?php echo $finalProfitless;?>"/><?php echo english2bangla($finalProfitless);?> টাকা</br>
    <b>সর্বমোট : </b><input name="tretail" type="hidden" id="tretail" size="20" style="text-align:right;" value="<?php echo $finalTotal;?>" readonly/><?php echo english2bangla($finalTotal);?> টাকা</br>
    <b>প্রদেয় টাকা : </b><input name="gtotal" type="hidden" id="gtotal" size="20" value="<?php echo $finalTotal;?>" readonly style="text-align:right;" /><?php echo english2bangla($finalTotal);?> টাকা
</div>
    
<fieldset style="border-width: 3px;padding-bottom:50px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
<legend style="color: brown;">মূল্য পরিশোধ এবং ক্রেতার তথ্য</legend>
<b>কাস্টমার টাইপ :</b>
&nbsp;&nbsp;<input type="radio" name="customerType" id="customerType" onclick="showCustInfo(1)" checked value="1" />নন-রেজিস্টার কাস্টমার
&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="customerType" id="customerType" onclick="showCustInfo(2)" value="2" />সেলস স্টোর
&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="customerType" id="customerType" onclick="showCustInfo(3)" value="3" />অফিস
</br>
<div id="customerInfo" style="width: 100%; margin-top: 20px;">
    <table width='100%' cellspacing='0' cellpadding='0' style='border: #000000 inset 1px; font-size:20px;'><tr>
            <td>কাস্টমারের নামঃ <input id='custName' name='custName' /><em style='font-size: 10px;color:#03C;'>* অবশ্য পূরণীয়</em></td>
           <td>কাস্টমারের মোবাইল নং :<input id='custMbl' name='custMbl' onkeypress='return checkIt(event)' /><em style='font-size: 10px;color:#03C;'>* অবশ্য পূরণীয়</em></td>
            <td>কাস্টমারের পেশাঃ <input id='custOccupation' name='custOccupation' /></td>
           </tr><tr><td colspan ='4'>&nbsp;&nbsp;</td></tr>
            <tr><td colspan='4'>কাস্টমারের ঠিকানাঃ <input id='custAdrss' name='custAdrss' style='width:600px;'/></td></tr>
            </table>
</div>
</br>
<b>পেমেন্ট টাইপ :</b>
&nbsp;&nbsp;<input type="radio" name="payType" id="payType" onclick="showPayType(1)" checked value="1" />ক্যাশ
&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="payType" id="payType" onclick="showPayType(2)" value="2" />অ্যাকাউন্ট
</br>
  <div id="payInfo" class="text" style="margin-top: 10px;">
      <label style='margin-left:20px;'><b>টাকা গ্রহন&nbsp;&nbsp;:</b>
	  <input name='cash' id='cash' type='text' onkeypress='return checkIt(event)' onkeyup='minus()' /> টাকা</label>
      <label style='margin-left: 63px;'><b>টাকা ফেরত : </b>
	  <input name='change' id='change' type='text' readonly/> টাকা <input type='hidden' id='checkField' value='0' /></label>
      <label style='margin-left: 63px;'><b>প্রকৃত ফেরত : </b>
                <input name='actualChange' id='floorvalue' type='radio' checked /><span id="floor"></span> &nbsp;&nbsp;
                 <input name='actualChange' id='ceilingvalue' type='radio' /><span id="ceiling"></span> 
      </label>
  </div></br></br>
<input class="btn" name="print" id="print" onclick="return beforeSave()" readonly  type="submit" value="বিক্রয় করুন" style="cursor:pointer;margin-left:45%;font-family: SolaimanLipi !important;" />
    </fieldset>
  </form>
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
  </div>
</body>
</html>
