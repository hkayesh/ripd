<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$storeName= $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
$msg ="";

$sel_inventory = $conn->prepare("SELECT * FROM inventory,product_chart WHERE idproductchart= ins_productid AND ins_product_type = 'general' AND idinventory = ?");
$sel_prochart = $conn->prepare("SELECT * FROM product_chart WHERE idproductchart=?");
$sel_inventory2 = $conn->prepare("SELECT * FROM inventory WHERE ins_ons_id= ? AND ins_ons_type=? AND ins_product_type='general' AND ins_productid=?");
$ins_product_breaking = $conn->prepare("INSERT INTO product_breaking (ons_id, ons_type, breaking_date, breaking_pro_id, breaking_qty, converted_pro_id, converted_qty, original_buying_price, buying_price, selling_price, xtra_profit, profit, cfs_user_id)
                                                                    VALUES (?,?,NOW(),?,?,?,?,?,?,?,?,?,?)");
$sqlpv = $conn->prepare("SELECT * FROM running_command;");
$sqlpv->execute();
$pvrow = $sqlpv->fetchAll();
foreach ($pvrow as $row) {
    $unitpv= $row['pv_value'];
}

if(isset($_POST['break']))
{
    $p_breakingqty = $_POST['breakingQty'];
    $p_breakingID = $_POST['breakingCode'];
    $p_chartID = $_POST['proCode'];
    $sel_inventory->execute(array($p_breakingID));
    $all1 = $sel_inventory->fetchAll();
    foreach ($all1 as $row1) {
        $db_breakingProUnit = $row1['pro_unit'];
        $db_breakingChartID = $row1['idproductchart'];
    }
    
    $sel_prochart->execute(array($p_chartID));
    $all2 = $sel_prochart->fetchAll();
    foreach ($all2 as $row2) {
        $db_ProUnit = $row2['pro_unit'];
    }
    $sel_inventory2->execute(array($storeID,$scatagory,$p_chartID));
        $all3 = $sel_inventory2->fetchAll();
        if(count($all3) > 0 ) {
        foreach ($all3 as $row3) {
            $db_buyingprice = $row3['ins_buying_price'];
            $db_sellingprice = $row3['ins_sellingprice'];
            $db_xtraprofit = $row3['ins_extra_profit'];
            $db_profit = $row3['ins_profit'];
        }
    }
    else 
    {
        $db_buyingprice = 0;
        $db_sellingprice = 0;
        $db_xtraprofit = 0;
        $db_profit = 0;
    }
}

if(isset($_POST['entry'])) // ********************* final entry ********************************
{
    $p_breakingid = $_POST['breakingID'];
    $p_breakingQty = $_POST['breakingqty'];
    $p_makingID = $_POST['makingChartID'];
    $p_makingQty = $_POST['totalqty'];
    $p_originalBuying = $_POST['actualBuying'];
    $p_buying = $_POST['newBuyingPrice'];
    $p_selling = $_POST['newSellingPrice'];
    $p_xtraprofit = $_POST['newXtraprofit'];
    $p_profit = $_POST['newProfit'];
    $yes= $ins_product_breaking->execute(array($storeID,$scatagory,$p_breakingid,$p_breakingQty,$p_makingID,$p_makingQty,$p_originalBuying,$p_buying,$p_selling,$p_xtraprofit,$p_profit,$cfsID));
    if($yes ==1)
    {
       $msg = "প্রোডাক্টটি সফলভাবে ব্রেক হয়েছে";}
                    else { $msg = "দুঃখিত প্রোডাক্টটি ব্রেক হয়নি";}
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>প্রোডাক্ট ব্রেক</title>
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
function checkIt(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        return true;
    }
    return false;
}
function setBreakingProduct(getstring1)
{ 
    var array1 = getstring1.split(',');
    document.getElementById('code1').innerHTML = array1[0];
    document.getElementById('name1').innerHTML = array1[1];
    document.getElementById('unit1').innerHTML = array1[2];
    document.getElementById('qty1').innerHTML = array1[3];
    document.getElementById('breakingCode').value = array1[4];
}
function setProduct(getstring2)
{
    var array2 = getstring2.split(',');
    var n = decodeURIComponent(array2[3]);
    var qty = n.replace(/\+/g," ");
    document.getElementById('code2').innerHTML = array2[0];
    document.getElementById('name2').innerHTML = array2[1];
    document.getElementById('unit2').innerHTML = array2[2];
    document.getElementById('qty2').innerHTML = qty;
    document.getElementById('proCode').value = array2[4];
}
function checkQty(qty)
{
    var availableqty = Number(document.getElementById('qty1').innerHTML);
     var proqty = Number(document.getElementById('qty2').innerHTML);
     if((qty <= availableqty) && (qty !=""))
        {
            document.getElementById('break').disabled = false;
        }
        else{
            document.getElementById('break').disabled = true;
        }
}
function calculate1(convertedQty, breakingqty)
{
    var unitQty = Number(document.getElementById('breakingunit').value);
    var totalqty = (breakingqty * unitQty) / convertedQty;
    document.getElementById('totalqty').value = totalqty;
    var procode = '<?php echo $p_breakingID;?>';
    getValues(procode);
}
function setNewValues(getstring3)
{
    var array3 = getstring3.split(',');
    document.getElementById('actualBuying').value = array3[0];
    document.getElementById('newBuyingPrice').value = array3[0];
    document.getElementById('newSellingPrice').value = array3[1];
    document.getElementById('newProfit').value = array3[2];
    document.getElementById('newXtraprofit').value = array3[3];
}
function calculate(val)
{ 
    var xprofit = Number(val);
    var buying = Number(document.getElementById("newBuyingPrice").value);
    var selling = Number(document.getElementById("newSellingPrice").value);
    var profit = selling - (buying + xprofit);
    if(selling <= buying)
        {
            alert("দুঃখিত, বিক্রয়মূল্য <= ক্রয়মূল্য হতে পারবে না\n এবং\n প্রফিট ০ হতে পারবে না");
            document.getElementById("newProfit").value = 0;
        }
        else {
                document.getElementById("newProfit").value = profit;
        }
}
function beforeSave()
{
   var profit = document.getElementById("newProfit").value;
   if(profit !="" && profit!= 0)
       {
           return true;
       }
       else { return false;}
}
</script>
<!--===========================================================================================================================-->
<script>
function searchInventoryProduct(str_key) // for searching product from own inventory
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
            if(str_key.length ==0)
                {
                   document.getElementById('searchResult1').style.display = "none";
               }
                else
                    {   document.getElementById('searchResult1').style.visibility = "visible";
                         document.getElementById('searchResult1').setAttribute('style','position:absolute;top:49%;left:17.5%;width:400px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:110px; background-color:#F5F5FF;');
                    }
                document.getElementById('searchResult1').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/searchProductForBreak.php?searchKey1="+str_key,true);
        xmlhttp.send();	
}
function inventoryProductInfo(id1) // for getting & setting product info
{
    document.getElementById('searchResult1').style.display = "none";
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
          var get1=xmlhttp.responseText;
          setBreakingProduct(get1);
        }
        xmlhttp.open("GET","includes/searchProductForBreak.php?id1="+id1,true);
        xmlhttp.send();	
}
function searchProduct1(str_key) // for searching products from product chart
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
            if(str_key.length ==0)
                {
                   document.getElementById('searchResult2').style.display = "none";
               }
                else
                    {   document.getElementById('searchResult2').style.visibility = "visible";
                         document.getElementById('searchResult2').setAttribute('style','position:absolute;top:49%;left:52.5%;width:400px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:110px; background-color:#F5F5FF;');
                    }
                document.getElementById('searchResult2').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/searchProductForBreak.php?searchKey2="+str_key,true);
        xmlhttp.send();	
}
function ProductInfo(id2) // for searching packages from own inventory
{
    document.getElementById('searchResult2').style.display = "none";
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
          var get2=xmlhttp.responseText;
          setProduct(get2);
        }
        xmlhttp.open("GET","includes/searchProductForBreak.php?id2="+id2,true);
        xmlhttp.send();	
}

function checkqty(qty,left,ri8)
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
               document.getElementById('check').value=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/checkPckgQty.php?pckgqty="+qty+"&leftstr="+left+"&ri8str="+ri8,true);
        xmlhttp.send();
}

function getValues(procode)
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
          var get3=xmlhttp.responseText;
          setNewValues(get3);
        }
        var qty1 = document.getElementById('breakingunit').value;
        var qty2 = document.getElementById('tobreakunit').value;
        xmlhttp.open("GET","includes/searchProductForBreak.php?code="+procode+"&qty1="+qty1+"&qty2="+qty2,true);
        xmlhttp.send();	
}
</script>  
</head>    

<body>
<div id="maindiv">
<div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
    <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
    <div style="width: 33%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
    <div style="width: 33%;height: 100%; float: left;font-family: SolaimanLipi !important;text-align: center;font-size: 36px;"><?php echo $storeName;?></div>
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a style="cursor: pointer;" onclick="javasrcipt:window.open('product_list.php');return false;"><img src="images/productList.png" style="width: 100px;height: 70px;"/></br>প্রোডাক্ট লিস্ট</a></div>
</div>
</br>
<div class="wraper" style="width: 80%;font-family: SolaimanLipi !important;float: none;">
     <?php
        if($msg !="")
            { echo "<div class='top' style='width: 100%;height: auto;text-align:center;font-size:26px; color:#009933;'><b>$msg</b></div></br>"; } 
       else
       { if(($_GET['step'] == 2)) {?>
    <form method="POST"  action="" onsubmit="return beforeSave();">
        <table border="1">
            <tr>
                <td width="100%" colspan="2">
                    <fieldset style="border-width: 3px;width: 95%;">
                        <legend style="color: brown;">প্রোডাক্ট রূপান্তর</legend>
                        <table width="100%" align="center" >
                        <tr>
                            <td width="45%" style="border: 1px black solid;text-align:right;">রূপান্তরযোগ্য প্রোডাক্টের <?php echo $db_breakingProUnit;?></td>
                            <td width="10%" style="border: 1px black solid;text-align: center;"> = </td>
                            <td width="45%" style="border: 1px black solid;"><input type="text" name="breakingunit" id="breakingunit" /> একক</td>
                        </tr>
                        <tr>
                            <td  style="border: 1px black solid;text-align:right;">রূপান্তরিত প্রোডাক্টের ১ <?php echo $db_ProUnit;?></td>
                            <td  style="border: 1px black solid;text-align: center;"> = </td>
                            <td style="border: 1px black solid;"><input type="text" id="tobreakunit" name="tobreakunit" onkeyup="calculate1(this.value,'<?php echo $p_breakingqty?>');"/> একক</td>
                        </tr>
                        <tr>
                            <td  style="border: 1px black solid;text-align:right;">রূপান্তরযোগ্য প্রোডাক্টের  <?php echo $p_breakingqty." টি " ; echo $db_breakingProUnit;?></td>
                             <td  style="border: 1px black solid;text-align: center;"> = </td>
                             <td style="border: 1px black solid;"><input readonly id="totalqty" name="totalqty" /> টি রূপান্তরিত প্রোডাক্ট</td>
                        </tr>
                    </table>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <fieldset style="border-width: 3px;width: 90%;">
                        <legend style="color: brown;">রূপান্তরিত প্রোডাক্টের চলমান মূল্যতালিকা</legend>
                            <table width="100%" align="center" >
                            <tr>
                                <td width="50%" style="border: 1px black solid;text-align:right;">ক্রয়মূল্য <input type="hidden"  name="makingChartID" value="<?php echo $p_chartID?>" /></td>
                                <td width="50%" style="border: 1px black solid;text-align: center;"><input type="text" style="text-align: right;" readonly value="<?php echo $db_buyingprice?>" /></td>
                            </tr>
                            <tr>
                                <td width="50%" style="border: 1px black solid;text-align:right;">বিক্রয়মূল্য </td>
                                <td width="50%" style="border: 1px black solid;text-align: center;"><input type="text" readonly style="text-align: right;" value="<?php echo $db_sellingprice?>" /></td>
                            </tr>
                            <tr>
                                <td width="50%" style="border: 1px black solid;text-align:right;">এক্সট্রা প্রফিট </td>
                                <td width="50%" style="border: 1px black solid;text-align: center;"><input type="text" readonly style="text-align: right;" value="<?php echo $db_xtraprofit?>" /></td>
                            </tr>
                            <tr>
                                <td width="50%" style="border: 1px black solid;text-align:right;">প্রফিট </td>
                                <td width="50%" style="border: 1px black solid;text-align: center;"><input type="text" readonly style="text-align: right;" value="<?php echo $db_profit?>" /></td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
                <td width="50%">
                     <fieldset style="border-width: 3px;width: 90%;">
                        <legend style="color: brown;">রূপান্তরিত প্রোডাক্টের হিসাবকৃত মূল্যতালিকা</legend>
                            <table width="100%" align="center" >
                                <tr>
                                    <td width="50%" style="border: 1px black solid;text-align:right;">একক ক্রয়মূল্য <input type="hidden" id="actualBuying" name="actualBuying" /></td>
                                    <td width="50%" style="border: 1px black solid;text-align: center;"><input type="text" style="text-align: right;" name="newBuyingPrice" id="newBuyingPrice" onkeypress='return checkIt(event)' /></td>
                                </tr>
                                <tr>
                                    <td width="50%" style="border: 1px black solid;text-align:right;">একক বিক্রয়মূল্য <input type="hidden"  name="breakingqty" value="<?php echo $p_breakingqty?>" /></td>
                                    <td width="50%" style="border: 1px black solid;text-align: center;"><input type="text" style="text-align: right;" name="newSellingPrice" id="newSellingPrice" onkeypress='return checkIt(event)' /></td>
                                </tr>
                                <tr>
                                    <td width="50%" style="border: 1px black solid;text-align:right;">একক এক্সট্রা প্রফিট <input type="hidden"  name="breakingID" value="<?php echo $db_breakingChartID?>" /></td>
                                    <td width="50%" style="border: 1px black solid;text-align: center;"><input type="text" style="text-align: right;" name="newXtraprofit" id="newXtraprofit" onkeypress='return checkIt(event)' onblur="calculate(this.value)" /></td>
                                </tr>
                                <tr>
                                    <td width="50%" style="border: 1px black solid;text-align:right;">একক প্রফিট </td>
                                    <td width="50%" style="border: 1px black solid;text-align: center;"><input type="text" readonly style="text-align: right;" name="newProfit" id="newProfit"  /></td>
                                </tr>
                            </table>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="2">
                    <input class="btn" name="entry" id="entry" readonly type="submit" value="এন্ট্রি করুন" style="cursor:pointer;width:80px;height: 25px;font-family: SolaimanLipi !important;" /></br></br>
                </td>
            </tr>
        </table>
  </form>
    <?php } else {?>
  <form method="POST"  action="product_breaking.php?step=2">
    <table border="1">
        <tr>
            <td style="width: 50%">
                <fieldset style="border-width: 3px;width: 90%;">
                    <legend style="color: brown;">যে প্রোডাক্ট কে ব্রেক করতে চাই</legend>
                    <table width="100%" cellspacing="0">
                        <thead>
                            <td colspan="2">
                                প্রোডাক্ট কোড : <input type="text" id="searchInProduct" name="searchInProduct" onKeyUp="searchInventoryProduct(this.value)" autocomplete="off" style="width: 300px;"/></br>
                                <div id="searchResult1"></div>
                            </td>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px black solid;width:30%;">প্রোডাক্ট কোড<input type="hidden" id="breakingCode" name="breakingCode" value=""/></td>
                                <td id="code1" style="border: 1px black solid;width: 60%;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px black solid;">প্রোডাক্টের নাম</td>
                                <td id="name1" style="border: 1px black solid;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px black solid;">প্রোডাক্টের একক</td>
                                <td id="unit1" style="border: 1px black solid;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px black solid;">পরিমান</td>
                                <td id="qty1" style="border: 1px black solid;"></td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>
            </td>
            <td>
                <fieldset style="border-width: 3px;width: 90%;">
                    <legend style="color: brown;">যেই প্রোডাক্ট-এ পরিবর্তন করতে চাই</legend>
                    <table width="100%" cellspacing="0">
                        <thead><td colspan="2">
                                প্রোডাক্ট কোড : <input type="text" id="searchProduct" name="searchProduct" onKeyUp="searchProduct1(this.value);" autocomplete="off" style="width: 300px;"/></br>
                                <div id="searchResult2"></div>
                            </td></thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px black solid;width: 30%;">প্রোডাক্ট কোড<input type="hidden" id="proCode" name="proCode" value=""/></td>
                                <td id="code2" style="border: 1px black solid;width: 60%;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px black solid;">প্রোডাক্টের নাম</td>
                                <td id="name2" style="border: 1px black solid;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px black solid;">প্রোডাক্টের একক</td>
                                <td id="unit2" style="border: 1px black solid;"></td>
                            </tr>
                            <tr>
                                <td style="border: 1px black solid;">পরিমান</td>
                                <td id="qty2" style="border: 1px black solid;"></td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <b>যতটা প্রোডাক্ট ভাঙতে চাই : </b> <input type="text" id="breakingQty" name="breakingQty" onkeypress=' return numbersonly(event);' onkeyup="checkQty(this.value);" style="width: 200px;"/></br></br>
                <input name="break" id="break" disabled type="submit" value="ব্রেক" style="cursor:pointer;width:80px;height: 25px;font-family: SolaimanLipi !important;" /></br></br>
            </td>
        </tr>
    </table>
  </form>
       <?php } }?>
</div>
    
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
</div>
</body>
</html>