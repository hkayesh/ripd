<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
$sql_select_brand = $conn->prepare("SELECT DISTINCT pro_brand_or_grp, pro_brnd_or_grp_code FROM product_chart ORDER BY pro_brand_or_grp");
$sql_select_class = $conn->prepare("SELECT DISTINCT pro_classification, pro_classification_code FROM product_chart ORDER BY pro_classification");
$sql_select_products = $conn->prepare("SELECT * FROM product_chart ORDER BY pro_productname");

?>
<style type="text/css">
    @import "css/bush.css";
    .formstyle td{
        padding: 5px;
    }
    .formstyle table td { border: 1px solid black; text-align: center;}
</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css">
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
function updateBrandName(brandName,brandCode)
{ TINY.box.show({iframe:'product_brand_update.php?brandName='+brandName+'&brandCode='+brandCode,width:500,height:240,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }

function updateClassName(className,classCode)
{ TINY.box.show({iframe:'product_class_update.php?className='+className+'&classCode='+classCode,width:500,height:240,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }

function updateProInfo(proID)
{ TINY.box.show({iframe:'product_info_update.php?proID='+proID,width:700,height:500,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
</script>

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="product_info_management.php"><b>ফিরে যান</b></a></div>
        <div class="domtab">
            <ul class="domtabs">
                <li class="current"><a href="#01">ব্র্যান্ড / গ্রুপ লিস্ট</a></li>
                <li class="current"><a href="#02">প্রকার লিস্ট</a></li>
                <li class="current"><a href="#03">পণ্য তথ্য</a></li>
            </ul>
        </div>   
        <div>
            <h2><a name="01" id="01"></a></h2><br/>
            <from method="post" action="" >
            <table  class="formstyle">          
                <tr><th colspan="7" style="text-align: center;">ব্র্যান্ড / গ্রুপ লিস্ট</th></tr>
                <tr>
                    <td colspan="2">
                        <table style="border: 1px solid #808080">
                            <tr id="table_row_odd">
                                <td><b>নাম</b></td>
                                <td><b>কোড</b></td>
                                <td><b>নাম আপডেট</b></td>
                            </tr>
                            <?php
                                    $sql_select_brand->execute();
                                    $arr_category = $sql_select_brand->fetchAll();
                                    foreach ($arr_category as $catrow) {
                                        echo "<tr>
                                                    <td>".$catrow['pro_brand_or_grp']."</td>
                                                     <td>".$catrow['pro_brnd_or_grp_code']."</td>
                                                    <td><a onclick=updateBrandName('".$catrow['pro_brand_or_grp']."','".$catrow['pro_brnd_or_grp_code']."') style='cursor:pointer;color:green'><u>নাম আপডেট</u></a></td>
                                            </tr>";
                                    }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center"><input type="submit" class="btn" name="catsubmit" value="সেভ">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
          </from>
        </div>
        
        <div>
            <h2><a name="02" id="02"></a></h2><br/>
            <from method="post" action="" >
            <table  class="formstyle">          
                <tr><th colspan="7" style="text-align: center;">প্রকার লিস্ট</th></tr>
                <tr>
                    <td colspan="2">
                        <table style="border: 1px solid #808080">
                            <tr id="table_row_odd">
                                <td><b>নাম</b></td>
                                <td><b>কোড</b></td>
                                <td><b>নাম আপডেট</b></td>
                                
                            </tr>
                            <?php
                                    $sql_select_class->execute();
                                    $arr_type = $sql_select_class->fetchAll();
                                    foreach ($arr_type as $typerow) {
                                        echo "<tr>
                                                    <td>".$typerow['pro_classification']."</td>
                                                    <td>".$typerow['pro_classification_code']."</td>
                                                    <td><a onclick=updateClassName('".$typerow['pro_classification']."','".$typerow['pro_classification_code']."') style='cursor:pointer;color:green'><u>নাম আপডেট</u></a></td>
                                            </tr>";
                                    }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center"><input type="submit" class="btn" name="typesubmit" value="সেভ">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
          </from>
        </div>
        
          <div>
            <h2><a name="03" id="03"></a></h2><br/>
            <from method="post" action="" >
            <table  class="formstyle">          
                <tr><th colspan="7" style="text-align: center;">পণ্য তালিকা</th></tr>
                <tr>
                    <td colspan="2">
                        <table style="border: 1px solid #808080">
                            <tr id="table_row_odd">
                                <td><b>নাম</b></td>
                                <td><b>কোড</b></td>
                                <td><b>আপডেট</b></td>
                            </tr>
                            <?php
                                    $sql_select_products->execute();
                                    $arr_type = $sql_select_products->fetchAll();
                                    foreach ($arr_type as $typerow) {
                                        echo "<tr>
                                                    <td>".$typerow['pro_productname']."</td>
                                                     <td>".$typerow['pro_code']."</td>
                                                    <td><a onclick=updateProInfo('".$typerow['idproductchart']."') style='cursor:pointer;color:green'><u>আপডেট</u></a></td>
                                            </tr>";
                                    }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center"><input type="submit" class="btn" name="typesubmit" value="সেভ">&nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
          </from>
        </div>
        
    </div>
</div>
<?php include_once 'includes/footer.php';?>