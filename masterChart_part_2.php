<?php 
    include_once 'includes/header.php';
    include_once './includes/selectQueryPDO.php';
    $g_catID = $_GET['type'];

    function showType($sql,$id)
    {
         echo  "<option value=0> -সিলেক্ট করুন- </option>";
        $sql->execute(array($id));
        $arr_catagoryRslt = $sql->fetchAll();
        foreach ($arr_catagoryRslt as $catrow) {
            echo  "<option value=".$catrow['idproduct_catagory'].">".$catrow['pro_type']."</option>";
        }
    }
 function showBrand($sql)
    {
         echo  "<option value=0> -সিলেক্ট করুন- </option>";
        $sql->execute(array());
        $arr_brandRslt = $sql->fetchAll();
        foreach ($arr_brandRslt as $brandrow) {
            echo  "<option value=".$brandrow['pro_brnd_or_grp_code'].">".$brandrow['pro_brand_or_grp']."</option>";
        }
    }
?>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/jquery-1.9.1.js"></script>
<script src="javascripts/jquery-ui.js"></script>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<style type="text/css">
.toggler {
width: 260px;
height: auto;
margin: 5px 10px;
}
.effect {
position: relative;
width: 250px;
height: auto;
padding: 0.4em;
}
.detailsLinks {
    display:block;
    text-decoration: none;
    text-align:center;
    cursor:pointer;
    color:green;
    background-color:greenyellow;
    margin:3px 0px;
    border:1px solid black;
    border-radius: 5px;
}
.detailsLinks:hover {
    background-color:#00CCFF ;
}
h3 {
    text-align: center;
    width: 255px !important;
    cursor: pointer;
    padding: 2px !important;
}
h3:hover,
h3:active {
    background: #c2bdbd;
    border: 1px solid black;
}
</style>
<script type="text/javascript">
$(function() {
//$( ".effect" ).hide();
$( ".h3button" ).click(function() {
var selectedEffect = 'blind';
var content = $(this).next();
  $(content).toggle( selectedEffect, 500 );
  $(content).next().toggle( selectedEffect, 500 );
return false;
    });
});
</script>
<script type="text/javascript">
    function showDetails(proID)
    { TINY.box.show({iframe:'includes/product_details.php?proID='+proID,width:800,height:300,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
</script>
<!-- ################### ajax ####################################-->
<script>
    function showSpecificProduct(type) // for specific type
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
                document.getElementById('productShowcage').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/masterChartIncludes.php?type="+type,true);
        xmlhttp.send();	
}

function showProductForBrand(brand) 
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
                document.getElementById('productShowcage').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/masterChartIncludes.php?probrand="+brand,true);
        xmlhttp.send();	
}
</script>
<div class="page_header_div">
    <div class="page_header_title">মূল পণ্য তালিকা (মাস্টার চার্ট)</div>
</div>
<div style="padding-left: 10px;"><a href="masterChart_part_1.php" style="width: 50px;height: 30px;"><img src="images/go_previous_blue.png" style="width: 50px;height:30px;" /></a></div>
<div>
    <table>
        <tr>
            <td style="text-align: right;color: #000099;font-size:14px;">টাইপ :
                <select class="box" onchange= "showSpecificProduct(this.value)">
                    <?php showType($sql_select_all_type_by_cat,$g_catID)?>
                </select>
            </td>
            <td style="text-align: center;color: red;"> <b> অথবা </b></td>
            <td style="color: #000099;font-size:14px;">ব্র্যান্ড / গ্রুপ :
                <select class="box" onchange='showProductForBrand(this.value)'>
                    <?php showBrand($sql_select_all_brand)?>
                </select>            
            </td>
        </tr>
        <tr>
            <td colspan="3" style="border: 1px inset #555;">
                        <div id="productShowcage" style="width: 100%;height: auto;" >
                            <?php
                                    // ******************************** type ****************************
                                    $sql_select_product_by_type->execute(array($g_catID));
                                    $arr_product = $sql_select_product_by_type->fetchAll();
                                    foreach ($arr_product as $value) {
                                    $db_proName = $value['pro_productname'];
                                    $db_proCode = $value['pro_code'];
                                    $db_proBrand = $value['pro_brand_or_grp'];
                                    $db_proArticle = $value['pro_article'];
                                    $db_proUnit = $value['pro_unit'];
                                    $db_proImage = $value['pro_picture'];
                                    $db_proChartID = $value['idproductchart'];
                            ?>
                        <div class="toggler" style="float: left; ">
                                <h3 class="ui-state-default ui-corner-all h3button" ><?php echo $db_proName;?></h3>
                               <div  class="ui-widget-content ui-corner-all effect">
                                   <table style="margin-left: 0px;">
                                       <tr>
                                           <td>ব্র্যান্ড</td>
                                           <td>: <?php echo $db_proBrand;?></td>
                                       </tr>
                                       <tr>
                                           <td>একক</td>
                                           <td>: <?php echo $db_proUnit;?></td>
                                       </tr>
                                       <tr>
                                           <td>কোড</td>
                                           <td>: <?php echo $db_proCode;?></td>
                                       </tr>
                                       <tr>
                                           <td>আর্টিকেল</td>
                                           <td>: <?php echo $db_proArticle;?></td>
                                       </tr>
                                       <tr>
                                           <td colspan="2" style="text-align: center" ><img src="<?php echo $db_proImage;?>" width="100px" height="100px"/></td>
                                       </tr>
                                       <tr>
                                           <td colspan="2" style="text-align: center"><a class='detailsLinks' onclick="showDetails('<?php echo $db_proChartID?>')">বিস্তারিত</a></td>
                                       </tr>
                                   </table>
                               </div>
                           </div>
                                <?php }?>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php include_once 'includes/footer.php';?>


