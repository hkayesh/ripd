<?php
error_reporting(0);
session_start();
include_once 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
$storeName= $_SESSION['loggedInOfficeName'];
function get_catagory()
{
    echo  "<option value=0> -সিলেক্ট করুন- </option>";
    $catagoryRslt= mysql_query("SELECT DISTINCT pro_catagory, pro_cat_code FROM product_catagory ORDER BY pro_catagory;");
    while($catrow = mysql_fetch_assoc($catagoryRslt))
    {
	echo  "<option value=".$catrow['pro_cat_code'].">".$catrow['pro_catagory']."</option>";
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>পণ্যের তালিকা</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script language="JavaScript" type="text/javascript" src="scripts/productsearch.js"></script>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
 <script src="scripts/tinybox.js" type="text/javascript"></script>
  <script type="text/javascript">
 function productUpdate(id)
	{ TINY.box.show({iframe:'updateProduct.php?proid='+id,width:800,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
 </script>
<script type="text/javascript">
function ShowTime()
{
      var time=new Date()
      var h=time.getHours()
      var m=time.getMinutes()
      var s=time.getSeconds()
  
      m=checkTime(m)
      s=checkTime(s)
      document.getElementById('txt').value=h+" : "+m+" : "+s
      t=setTimeout('ShowTime()',1000)
      if(document.getElementById('pname').value !="")
          { document.getElementById("QTY").disabled = false;}
     else {document.getElementById("QTY").disabled = true;}
     
     if(document.getElementById('tretail').value !="")
          { document.getElementById("cash").disabled = false;}
     else {document.getElementById("cash").disabled = true;}
          
      a=Number(document.abc.QTY.value);
if (a!=0) {document.getElementById("addtoCart").disabled = false;}
  else {document.getElementById("addtoCart").disabled = true;}
  payable = Number(document.getElementById('gtotal').value);
  cash = Number(document.getElementById('cash').value);
  if(cash<payable)
  {document.getElementById("print").disabled = true;}
  else {document.getElementById("print").disabled =false ;}

}
    function checkTime(i)
    {
      if (i<10)
      {
        i="0" + i
      }
      return i
    }

function goBack()
    {
        window.history.go(-1);
    }
    </script>
	
<!--===========================================================================================================================-->
<script>
function showTypes(catagory) // for types dropdown list
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
                document.getElementById('showtype').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcessForAll.php?id=t&catagory="+catagory,true);
        xmlhttp.send();	
}
function showBrands(type) // for brand dropdown list
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
                document.getElementById('brand').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcessForAll.php?id=b&type="+type,true);
        xmlhttp.send();	
}
function showClass(brand,protype) // for product name dropdown list
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
                document.getElementById('classi').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcessForAll.php?id=c&brand="+brand+"&type="+protype,true);
        xmlhttp.send();	
}
function showProduct(productChartId,idbrand,cataID) // show product details from selecting product from dropdown
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
                document.getElementById('resultTable').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcessForAll.php?id=all&chartID="+productChartId+"&idbrand="+idbrand+"&cataID="+cataID,true);
        xmlhttp.send();
}
function showCatProducts(code) // show products from selecting catagory
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
                document.getElementById('resultTable').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcessForAll.php?id=catagory&proCatCode="+code,true);
        xmlhttp.send();
}
function showTypeProducts(proCatID) // show products from selecting types
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
                document.getElementById('resultTable').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcessForAll.php?id=type&proCatID="+proCatID,true);
        xmlhttp.send();
}

function showBrandProducts(brandcode,procatid) // show products from brand
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
                document.getElementById('resultTable').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcessForAll.php?id=brnd&brandCode="+brandcode+"&procatid="+procatid,true);
        xmlhttp.send();
}
</script>  
</head>
    
<body onLoad="ShowTime()">

<div id="maindiv">
    <div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
    <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
        <div style="width: 40%;height: 100%; float: left;"><a onclick="goBack();" style="cursor: pointer;"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
   </div>
    
<div class="wraper" style="width: 80%;font-family: SolaimanLipi !important;">
<fieldset style="border-width: 3px;width: 100%;">
         <legend style="color: brown;">প্রোডাক্ট লিস্ট ফিল্টার</legend>
    <div class="top" style="width: 100%;height: auto;">
    <div style="float: left;width: 25%;"><b>পণ্যের ক্যাটাগরি</b></br>
      <select id="catagorySearch" name="catagorySearch" onchange="showTypes(this.value);showCatProducts(this.value);" style="width: 200px;font-family: SolaimanLipi !important;">
                <?php echo get_catagory(); ?>
            </select>
        </div>
        <div style="float: left;width: 25%;"><b>পণ্যের টাইপ</b></br>
            <span id="showtype">
            <select style="width: 200px;font-family: SolaimanLipi !important;">
                </select></span>
        </div>
        <div style="float: left;width: 25%;"><b>ব্র্যান্ড / গ্রুপ</b></br>
            <span id="brand">
            <select id="brandSearch" name="brandSearch" style="width: 200px;font-family: SolaimanLipi !important;">
            </select></span>
        </div>
        <div style="float: left;width: 25%;"><b>প্রকার</b></br>
            <span id="classi">
            <select id="classification" name="classification"  style="width: 200px;font-family: SolaimanLipi !important;">
                </select></span>
        </div>
    </div>
</fieldset></div>

  <fieldset   style="border-width: 3px;margin:0 20px 50px 20px;font-family: SolaimanLipi !important;">
<legend style="color: brown;">পণ্যের তালিকা</legend>
<div id="resultTable">
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
      <tr>
          <td width="8%"><div align="center"><strong>ক্রমিক নং</strong></div></td>
        <td width="23%"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="30%"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>
        <td width="11%"><div align="center"><strong>একক</strong></div></td>
        <td width="12%"><div align="center"><strong>আর্টিকেল</strong></div></td>
      </tr>
    <?php
//if (isset($_GET['code']))
//     	{	
//                    $G_summaryID = $_GET['code'];
                        $slNo = 1;
                    $result = mysql_query("SELECT * FROM product_chart ORDER BY pro_code ");
                        while ($row = mysql_fetch_assoc($result))
                        {
                            $db_proname=$row["pro_productname"];
                            $db_unit=$row["pro_unit"];
                            $db_article=$row["pro_article"];
                            $db_procode=$row["pro_code"];
                            echo '<tr>';
                            echo '<td><div align="center">'.english2bangla($slNo).'</div></td>';
                            echo '<td><div align="left">'.$db_procode.'</div></td>';
                              echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                              echo '<td><div align="center">'.$db_unit.'</div></td>';
                              echo '<td><div align="center">'.$db_article.'</div></td>';
                              echo '</tr>';
                              $slNo++;
                        }
?>
</table>
</div>
</fieldset>

<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
  </div>
</body>
</html>
