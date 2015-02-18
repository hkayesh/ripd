<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';

$storeName= $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
$msg = "";

$infostmt = $conn->prepare("INSERT INTO package_info(pckg_name ,pckg_code ,pckg_image ,pckg_makedate ,pckg_makerid) VALUES (?, ?, ?, ?, ?)");
$sel_pckg_info = $conn->prepare("SELECT pckg_code FROM `package_info` ORDER BY idpckginfo DESC LIMIT 1");
$insstmt = $conn->prepare("INSERT INTO package_details(pckg_infoid, product_chartid, product_quantity) VALUES (?, ?, ?)");
$sel_product_chart = $conn->prepare("SELECT * FROM product_chart WHERE idproductchart = ? ");

// ********************* package_info-e entry হওয়ার জন্য*******************************************
if(isset($_POST['ok']))
{
    $P_pckgname=$_POST['pckg_name'];
     $P_pckgcode=$_POST['pckg_code'];
     $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
        $extension = end(explode('.', $_FILES["pckg_pic"]["name"]));
        $image_name = $P_pckgcode."_".$_FILES["pckg_pic"]["name"];
        $image_path = "package/" . $image_name;
        if (($_FILES["pckg_pic"]["size"] < 999999999999) && in_array($extension, $allowedExts)) 
                {
                    move_uploaded_file($_FILES["pckg_pic"]["tmp_name"], "package/" . $image_name);
                } 
    $timestamp=time(); //current timestamp
    $date=date("Y/m/d", $timestamp);      
    $infostmt->execute(array($P_pckgname, $P_pckgcode,$image_path, $date, $cfsID));
    $pckg_infoid = $conn->lastInsertId('idpckginfo'); 
    $_SESSION['pckgname'] = $P_pckgname;
    $_SESSION['pckgcode'] = $P_pckgcode;
    $_SESSION['pckgid'] = $pckg_infoid;
}
// ******************* package code update***************************    
$sel_pckg_info->execute();
$sqlpckgrow = $sel_pckg_info->fetchAll();
if(count($sqlpckgrow) < 1)
{
    $pckgCode = "pckg-0000";
}
else
{
    foreach ($sqlpckgrow as $value) {
        $db_str_pckgCode = $value['pckg_code'];
    }
    $code = end(explode('-', $db_str_pckgCode));
    $y = (int)$code;
    $y=$y+1;
    $str_y= (string)$y;
    $yUpdate= str_pad($str_y,4, "0", STR_PAD_LEFT);
    $pckgCode = "pckg-".$yUpdate;
}
// ********************* package_details-e entry হওয়ার জন্য*******************************************
if(isset($_POST['entry']))
{
    $pckginfoid= $_SESSION['pckgid'];
    foreach($_SESSION['arrProductTemp'] as $key =>  $row )
    {
        $productchartid= $key;
        $proQTY = $row[2];
        $insstmt->execute(array($pckginfoid,$productchartid,$proQTY));
        if($insstmt == 1)
        {
            $msg = "প্যাকেজ সফলভাবে এন্ট্রি হয়েছে";
        }
        else { 
            $msg = "দুঃখিত প্যাকেজ এন্ট্রি হয়নি";
        }
      }
            unset($_SESSION['pckgname']); 
            unset($_SESSION['pckgcode']); 
            unset($_SESSION['pckgid']);
            unset($_SESSION['arrProductTemp']);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>প্যাকেজ তৈরি</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script language="JavaScript" type="text/javascript" src="scripts/suggest.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/productsearch.js"></script>
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
function beforeSave()
{
    var pckgName = document.getElementById('pckg_name').value;
    if(pckgName != "")
        {
             return true;
        }
        else { return false; }
}
</script>
<script>
function searchCode(where) // productlist-er code search box
{
   var xmlhttp;
   var str_key = document.getElementById('amots').value;
   
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
                if(str_key.length ==0)
                {
                   document.getElementById('layer2').style.display = "none";
               }
                else
                    {document.getElementById('layer2').style.display = "inline"; 
                    document.getElementById('layer2').innerHTML=xmlhttp.responseText;
                }
            }
        }
        xmlhttp.open("GET","searchsuggest.php?searchcode="+str_key+"&where="+where,true);
        xmlhttp.send();
    
}
function searchName(where) // productlist-er name search box
{
   var xmlhttp;
   var str_key = document.getElementById('allsearch').value;
   
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
                if(str_key.length ==0)
                {
                   document.getElementById('searchResult').style.display = "none";
               }
                else
                    {document.getElementById('searchResult').style.display = "inline"; }
                document.getElementById('searchResult').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","searchsuggest.php?searchname="+str_key+"&where="+where,true);
        xmlhttp.send();
    
}
function addToPckgList() // to add into temporary package array*******************
   {
       var id = document.getElementById("proChartID").value;
        var name = document.getElementById("pname").value;
        var code = document.getElementById("pcode").value;
        var totalqty = Number(document.getElementById("QTY").value);
        if((totalqty != 0) && (code != ""))
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
                         location.reload();
                     }
                 }
                 xmlhttp.open("GET","addProInPckg.php?name="+name+"&code="+code+"&totalQty="+totalqty+"&chartID="+id,true);
                 xmlhttp.send();
            }
            else { alert("দুঃখিত, পরিমান ০ হতে পারবে না") ;}
  }
  
function deleteProduct(id) // to add into temporary array*******************
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
                location.reload();
            }
        }
        xmlhttp.open("GET","addProInPckg.php?type=del&chartID="+id,true);
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
    <div style="width: 33%;height: 100%;float: left;text-align: right;font-family: SolaimanLipi !important;"><a href="" onclick="javasrcipt:window.open('package_list.php');return false;"><img src="images/packagelist.png" style="width: 100px;height: 70px;"/></br>প্যাকেজ লিস্ট</a></div>
</div>
</br>
<div align="center" style="color: green;font-size: 26px; font-weight: bold; width: 90%;height: 20px;margin: 0 5% 0 5%;float: none;"><?php if($msg != "") echo $msg;?></div></br>
<?php
    if(!isset($_SESSION['pckgcode']))
    {
?>
<form action="create_package.php" enctype="multipart/form-data" method="post" name="abc" onsubmit="return beforeSave();">
          <fieldset style="width:70%;border-width: 3px;margin:0 20px 0 200px;font-family: SolaimanLipi !important;">
              <legend style="color: brown;">প্যাকেজ তৈরি</legend>
              <div style="width: 100%;">
                  <b>প্যাকেজের নাম&nbsp;&nbsp; : </b><input type="text" name="pckg_name" id="pckg_name" style="width: 200px;"/></br>
                  <b>প্যাকেজ কোড&nbsp;&nbsp;&nbsp;&nbsp;: </b><input type="text" name="pckg_code" readonly value="<?php echo $pckgCode;?>" style="width: 200px;"/></br>
                  <b>প্যাকেজ ছবি&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </b><input type="file" name="pckg_pic" style="width: 200px;"/>
              </div>
              <input name="ok" id="ok" type="submit" readonly value="ঠিক আছে" style="cursor:pointer;margin-left:45%;width:80px;height: 25px;font-family: SolaimanLipi !important;" /></br>
           </fieldset>
        </br></br></br></br></br></br></br></br>
    </form>
    <?php }
    else
    { ?>
    <form action="" method="post" name="abc">
     <fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
         <legend style="color: brown;">প্যাকেজে পণ্য প্রবেশ</legend>
    <div class="top" style="width: 100%;">
        <div  style="width: 100%;">
            <b>প্যাকেজের নাম : </b><input type="text" name="pckg_name" readonly value="<?php echo $_SESSION['pckgname'];?>" style="width: 200px;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <b>প্যাকেজ কোড : </b><input type="text" name="pckg_code" readonly value="<?php echo $_SESSION['pckgcode'];?>" style="width: 200px;"/>
        </div></br>
        <div class="topleft" style="float: left;width: 25%;">
            <b>প্রোডাক্ট কোড</b></br><input type="text" id="amots" name="amots" onKeyUp="searchCode('create_package.php');" autocomplete="off" style="width: 200px;"/>
            <div id="layer2"style="width:500px;position:absolute;top:60.5%;left:8%;z-index:1;padding:5px;border: 1px solid #000000; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" ></div></br></br>
            <b>প্রোডাক্ট নাম&nbsp;&nbsp;  </b><input type="text" id="allsearch" name="allsearch" onKeyUp="searchName('create_package.php');" autocomplete="off" style="width: 200px;"/>
            <div  id="searchResult"style="position:absolute;top:72.5%;left:8%;width:400px;z-index:10;padding:5px;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;display: none;" ></div>
    </div>
    <div class="topright" style="float:left; width: 75%;">
<?php
	if (isset($_GET['code']))
     	{
                    $G_proChartID = $_GET['code'];
                    $sel_product_chart->execute(array($G_proChartID));
                    $result = $sel_product_chart->fetchAll();
                    foreach ($result as $row) {
                        $db_proname=$row["pro_productname"];
                       $db_procode=$row["pro_code"];
                       $db_prounit=$row["pro_unit"];
                 }
        }
?>
<table width="100%" cellspacing="0"  cellpadding="0" style="border: #000000 inset 1px; font-size:20px;">
  <tr>
      <td colspan="2"><span style="color: #03C;"> প্রোডাক্টের নাম: </span><input name="pname" id="pname" type="text" value="<?php echo $db_proname; ?>" style="border:0px;font-size: 20px;width: 400px;" readonly/></td>   
  </tr>
  <tr>
      <td><span style="color: #03C;"> প্রোডাক্টের কোড: </span><input name="pcode" id="pcode" type="text" value="<?php echo $db_procode; ?>" style="border:0px;font-size: 18px;width: 250px;" readonly/>
       <input name="proChartID" id="proChartID" type="hidden" value="<?php echo $G_proChartID; ?>"/></td>
      <td><span style="color: #03C;"> পরিমাণ :</span> <input name="QTY" id="QTY" type="text" onkeypress=' return numbersonly(event)'  style="width:100px;"/></td>
      <td rowspan="2"><input type="button" onclick="addToPckgList()" style="height:100px; width: 100px;background-image: url('images/addToInventory.jpeg');background-repeat: no-repeat;background-size:100% 100%;cursor:pointer;" id="addtoCart" value="" /></td>
  </tr>
  <tr>   
      <td colspan="2"><span style="color: #03C;"> প্রোডাক্টের একক:</span><input name="unit" id="unit" type="text" readonly="readonly" style="border:0px;font-size: 18px;width: 250px;" value="<?php echo $db_prounit;?>"/></td>
        <td></td>
   </tr>
</table>
</div>
</div>
</fieldset></form>

<fieldset style="border-width: 3px;margin:0 20px 0 20px;font-family: SolaimanLipi !important;">
    <legend style="color: brown;">প্যাকেজে প্রবেশকৃত পণ্যের তালিকা</legend>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#000000; border-width:thin; font-size:18px;">
      <tr>
        <td width="13%"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width="19%"><div align="center"><strong>প্রোডাক্টের নাম</strong></div></td>
         <td width="8%"><div align="center"><strong>পরিমাণ</strong></div></td>
        <td width="8%">&nbsp;</td>
      </tr>
    <?php
        foreach($_SESSION['arrProductTemp'] as $key =>  $row) 
          {
              echo '<tr>';
                echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$row[0].'</div></td>';
                echo '<td><div align="center">'.$row[1].'</div></td>';
                 echo '<td><div align="center">'.$row[2].'</div></td>';
                echo '<td style="text-align: center;"><img src="images/del.png" style="cursor:pointer;" width="20px" height="20px" onclick="deleteProduct('.$key.')" /></td>';
                echo '</tr>';
        }
?>
</table>
</fieldset>
<form action="create_package.php" method="post" >
<input name="entry" id="entry" type="submit" value="এন্ট্রি করুন" style="cursor:pointer;margin-left:45%;width:80px;height: 25px;font-family: SolaimanLipi !important;" /></br></br>
</form>
    <?php }?>
    </div>
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;width: 82%; margin: 0 auto;" >
     <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
         RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
</body>
</html>