<?php
include_once 'ConnectDB.inc';
error_reporting(0);
//get product type
$pc_id = $_GET['pcid'];
if ($pc_id != null) {
    $product_type_sql = mysql_query("SELECT DISTINCT pro_type, idproduct_catagory FROM product_catagory where pro_cat_code='$pc_id' ");
    $function = "getproduct_brand();getproduct_class();";
    echo "<select  class='box2' style = 'border: 1px gray inset;width: 150px;' name='product_type' id='product_type' onchange='$function'>
                    <option value='all'>- প্রোডাক্ট টাইপ -</option>";
    while ($product_type_rows = mysql_fetch_array($product_type_sql)) {
        $db_product_category_id = $product_type_rows['idproduct_catagory'];
        $db_product_type_name = $product_type_rows['pro_type'];
        echo'<option style="width: 96%" value=' . $db_product_category_id . '>' . $db_product_type_name . '</option>';
    }
    echo "</select>";
}
//get product brand
$pt_id = $_GET['ptid'];
if ($pt_id != null) {
    $function = "getproduct_unit()";
    $product_brand_sql = mysql_query("SELECT DISTINCT pro_brand_or_grp FROM product_chart");
   
    echo ": <select  class='box2' style = 'border: 1px gray inset;width: 150px;' name='product_brand_name' id='product_brand_name' onchange='$function'>
                    <option value='0'>- ব্র্যান্ড/গ্রুপ -</option>";
    while ($product_brand_rows = mysql_fetch_array($product_brand_sql)) {
        $db_product_brand_name = $product_brand_rows['pro_brand_or_grp'];
        echo'<option style="width: 96%" value=' . $db_product_brand_name . '>' . $db_product_brand_name . '</option>';
    }
    echo '</select> অথবা <input class="box" type="text" id="new_brand" name="new_brand" />';
}
//get product class
$pt_id2 = $_GET['ptid2'];
if ($pt_id2 != null){
    echo ': <input style="width: 142px;" class="box2" type="text" id="pro_classification" name="pro_classification" />';
}
?>
