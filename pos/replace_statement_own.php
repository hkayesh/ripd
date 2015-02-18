<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$storeName = $_SESSION['loggedInOfficeName'];
$office_id = $_SESSION['loggedInOfficeID'];
$office_type = $_SESSION['loggedInOfficeType'];
$sql_select_replace = $conn->prepare("SELECT * FROM replace_product_summary, cfs_user
                                                WHERE cfs_userid = idUser AND reprosum_store_type = ?
                                                AND reprosum_storeid = ? ORDER BY reprosum_replace_date");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<title>পণ্যের তালিকা</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"/>
<script language="JavaScript" type="text/javascript" src="productsearch.js"></script>
 <script src="scripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
function details_show(id)
      { TINY.box.show({url:'replace_details.php?rep_id='+id,width:900,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
</script>
<link rel="stylesheet" href="css/css.css" type="text/css" media="screen" />
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
        xmlhttp.open("GET","includes/searchProcess.php?id=t&catagory="+catagory,true);
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
        xmlhttp.open("GET","includes/searchProcess.php?id=b&type="+type,true);
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
        xmlhttp.open("GET","includes/searchProcess.php?id=c&brand="+brand+"&type="+protype,true);
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
        xmlhttp.open("GET","includes/searchProcess.php?id=all&chartID="+productChartId+"&idbrand="+idbrand+"&cataID="+cataID,true);
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
        xmlhttp.open("GET","includes/searchProcess.php?id=catagory&proCatCode="+code,true);
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
        xmlhttp.open("GET","includes/searchProcess.php?id=type&proCatID="+proCatID,true);
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
        xmlhttp.open("GET","includes/searchProcess.php?id=brnd&brandCode="+brandcode+"&procatid="+procatid,true);
        xmlhttp.send();
    }
</script>  
</head>

<body>
<div id="maindiv">
    <div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
    <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
        <div style="width: 40%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
        <div style="width: 60%;height: 100%;float: left;font-family: SolaimanLipi !important;text-align: left;font-size: 36px;"><?php echo $storeName; ?></div></br>
    </div>
    <div id="show_table">
        <form method="post">
        <table width='100%' border='1' cellspacing='0' cellpadding='0' style='border-color:#000000; border-width:thin; font-size:18px;'>
            <tr>
                <td style='color: blue; font-size: 20px'><div align='center'><strong>তারিখ</strong></div></td>
                <td style='color: blue; font-size: 20px'><div align='center'><strong>চালান নং</strong></div></td>
                <td style='color: blue; font-size: 20px'><div align='center'><strong>রিপ্লেসের পরিমাণ(টাকা)</strong></div></td>
                <td style='color: blue; font-size: 20px'><div align='center'><strong>রিপ্লেসকারী</strong></div></td>
                <td style='color: blue; font-size: 20px'><div align='center'><strong></strong></div></td>
            </tr>
            <?php 
            $sql_select_replace->execute(array($office_type, $office_id));
            $replace = $sql_select_replace->fetchAll();
            foreach($replace as $row){
                $db_reprosum_replace_date = english2bangla(date('d-m-Y', strtotime($row["reprosum_replace_date"])));
                $db_account_name = $row['account_name'];
                $db_reprosum_invoiceno = $row['reprosum_invoiceno'];
                $db_reprosum_total_amount = $row['reprosum_total_amount'];
                ?>
            <tr>
                <td ><div align='center'><?php echo $db_reprosum_replace_date ?></div></td>
                <td ><div align='center'><?php echo $db_reprosum_invoiceno ?></div></td>
                <td ><div align='center'><?php echo $db_reprosum_total_amount ?></div></td>
                <td ><div align='center'><?php echo $db_account_name ?></div></td>
                <td ><div align='center'><input type="button" name="details" value="বিস্তারিত" onclick="details_show(<?php echo $row['idreproductsum'] ?>)"></input></div></td>
            </tr>
            <?php
            }
            ?>
        </table>
       </form>
    </div>
<div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
    <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
    RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
</div>
</div>
</body>
</html>
