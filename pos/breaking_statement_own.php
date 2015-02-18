<?php
error_reporting(0);
session_start();
include_once 'includes/connectionPDO.php';
include_once 'includes/MiscFunctions.php';
$storeName = $_SESSION['loggedInOfficeName'];
$cfsID = $_SESSION['userIDUser'];
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory = $_SESSION['loggedInOfficeType'];
$date = date("Y-m-d");
$sql_select_today_product_sell = $conn->prepare("SELECT quantity, ins_productname, ins_product_code, sales_amount
                                                                                    FROM sales, inventory, sales_summary
                                                                                    WHERE inventory.idinventory = sales.inventory_idinventory
                                                                                    AND sales.sales_summery_idsalessummery = sales_summary.idsalessummary
                                                                                    AND AND sales_amount = ?
                                                                                    AND ins_ons_id = ?
                                                                                    AND ins_ons_type = ?");
$sql_select_category = $conn->prepare("SELECT DISTINCT pro_catagory, pro_cat_code FROM product_catagory ORDER BY pro_catagory");

function get_catagory() {
    echo "<option value=0> -সিলেক্ট করুন- </option>";
    $sql_select_category->execute();
    $arr_category = $sql_select_category->fetchAll();
    foreach ($arr_category as $catrow) {
        echo "<option value=" . $catrow['pro_cat_code'] . ">" . $catrow['pro_catagory'] . "</option>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
        <link rel="icon" type="image/png" href="images/favicon.png" />
        <title>পণ্যের তালিকা</title>
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
            function resetForm(id){
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
                        document.getElementById('show_table').innerHTML=xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET","includes/breaking_chart.php?type="+id,true);
                xmlhttp.send();
            }
        </script>  
    </head>

    <body onLoad="ShowTime()">

        <div id="maindiv">
            <div id="header" style="width:100%;height:100px;background-image: url(../images/sara_bangla_banner_1.png);background-repeat: no-repeat;background-size:100% 100%;margin:0 auto;"></div></br>
            <div style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none;">
                <div style="width: 40%;height: 100%; float: left;"><a href="../pos_management.php"><img src="images/back.png" style="width: 70px;height: 70px;"/></a></div>
                <div style="width: 60%;height: 100%;float: left;font-family: SolaimanLipi !important;text-align: left;font-size: 36px;"><?php echo $storeName; ?></div></br>
            </div>
        <div id="radio_button" style="width: 90%;height: 70px;margin: 0 5% 0 5%;float: none; text-align: center">
            <input type='radio' name='breaking'  value="product" onclick="resetForm('pro_breaking');"/> প্রোডাক্ট ব্রেকিং &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type='radio' name='breaking'  value="package" onclick="resetForm('package_breaking');"/> প্যাকেজ ব্রেকিং
        </div>
        <div id="show_table"></div>
            <div style="background-color:#f2efef;border-top:1px #eeabbd dashed;padding:3px 50px;">
                <a href="http://www.comfosys.com" target="_blank"><img src="images/footer_logo.png"/></a> 
                RIPD Universal &copy; All Rights Reserved 2013 - Designed and Developed By <a href="http://www.comfosys.com" target="_blank" style="color:#772c17;">comfosys Limited<img src="images/comfosys_logo.png" style="width: 50px;height: 40px;"/></a>
            </div>
        </div>
    </body>
</html>
