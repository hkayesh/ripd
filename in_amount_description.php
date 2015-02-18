<?php
//include 'includes/session.inc';
include_once 'includes/header.php';
$msg = "";

function get_catagory() {
    echo "<option value=0> -সিলেক্ট করুন- </option>";
    $catagoryRslt = mysql_query("SELECT DISTINCT pro_catagory, pro_cat_code FROM product_catagory ORDER BY pro_catagory;");
    while ($catrow = mysql_fetch_assoc($catagoryRslt)) {
        echo "<option value=" . $catrow['pro_cat_code'] . ">" . $catrow['pro_catagory'] . "</option>";
    }
}
?>
<title>payment statement chart</title>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css">
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
    function detailsWithPrice()
    { TINY.box.show({url:'includes/ripd_product_details_price.php',width:550,height:530,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
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
        xmlhttp.open("GET","pos/includes/searchProcessForAll.php?id=t&catagory="+catagory,true);
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
        xmlhttp.open("GET","pos/includes/searchProcessForAll.php?id=b&type="+type,true);
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
        xmlhttp.open("GET","pos/includes/searchProcessForAll.php?id=c&brand="+brand+"&type="+protype,true);
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
        xmlhttp.open("GET","pos/includes/searchProcessForAll.php?id=all&chartID="+productChartId+"&idbrand="+idbrand+"&cataID="+cataID,true);
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
        xmlhttp.open("GET","pos/includes/searchProcessForAll.php?id=catagory&proCatCode="+code,true);
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
        xmlhttp.open("GET","pos/includes/searchProcessForAll.php?id=type&proCatID="+proCatID,true);
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
        xmlhttp.open("GET","pos/includes/searchProcessForAll.php?id=brnd&brandCode="+brandcode+"&procatid="+procatid,true);
        xmlhttp.send();
    }
</script>  

<div class="main_text_box">
    <div style="padding-left: 112px;"><a href="personal_reporting.php"><b>ফিরে যান</b></a></div>
    <div>
        <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 80%;">          
            <tr><th style="text-align: center" colspan="2"><h1>ইন ডেসক্রিপশন</h1></th></tr>
            <?php
            if ($msg != "") {
                echo '<tr><td colspan="2" style="text-align: center;font-size: 16px;color: green;">' . $msg . '</td></tr>';
            }
            ?>
            <tr>
                <td style="text-align: right;padding-right: 1%;margin-bottom: 5px;">সার্চ/খুঁজুন:<input type = "text" id ="search_box_filter">
                </td>
            </tr>
            <tr>
                <td>
                    <table style="margin: 0 auto;" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr id="table_row_odd">
                                <td width="11%" style="border: solid black 1px;"><div align="center"><strong>ক্রমিক নং</strong></div></td>
                                <td width="18%"  style="border: solid black 1px;"><div align="center"><strong>তারিখ</strong></div></td>
                                <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>সময়</strong></div></td>
                                <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>এমাউন্ট</strong></div></td>
                                <td width="12%" style="border: solid black 1px;"><div align="center"><strong>মাধ্যম</strong></div></td>
                                <td width="12%" style="border: solid black 1px;"><div align="center"><strong>ট্যাক্স / চার্জ</strong></div></td>
                            </tr>
                        </thead>
                        <tbody style="background-color: #FCFEFE">
                        </tbody>
                    </table>
            </tr>
        </table>
    </div>
</div>   

<?php include_once 'includes/footer.php'; ?>