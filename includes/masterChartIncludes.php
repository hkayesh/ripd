<?php
error_reporting(0);
include_once './ConnectDB.inc';
include_once './selectQueryPDO.php';
 if(isset($_GET['catcode']))
 {
     $g_code = $_GET['catcode'];
     $g_name = $_GET['catname'];
     echo '<div class="toggler" style="margin: 0 auto; ">
                            <h3 class="ui-state-default ui-corner-all h3button">'.$g_name.'</h3>
                           <div  class="ui-widget-content ui-corner-all effect">';
                                    $sql_select_type->execute(array($g_code));
                                    $arr_type_rslt = $sql_select_type->fetchAll();
                                    foreach ($arr_type_rslt as $typerow) {
                                        $db_typeName = $typerow['pro_type'];
                                        $db_catagoryID = $typerow['idproduct_catagory'];
                                        echo "<a class='innerLinks' href='masterChart_part_2.php?type=$db_catagoryID'> $db_typeName </a>";
                                    }
           echo  '</div></div>';
 }
elseif(isset($_GET['brand']))
 {
     $g_brand = $_GET['brand'];
     $sql_select_cat_by_brand->execute(array($g_brand));
     $arr_catagory = $sql_select_cat_by_brand->fetchAll();
     foreach ($arr_catagory as $value) {
         $db_catcode = $value['pro_cat_code'];
         $db_catname = $value['pro_catagory'];
     echo '<div class="toggler" style="float:left ">
                            <h3 class="ui-state-default ui-corner-all h3button">'.$db_catname.'</h3>
                           <div  class="ui-widget-content ui-corner-all effect">';
                                    $sql_select_type_by_brand->execute(array($g_brand,$db_catcode));
                                    $arr_type_rslt = $sql_select_type_by_brand->fetchAll();
                                    foreach ($arr_type_rslt as $typerow) {
                                        $db_typeName = $typerow['pro_type'];
                                        $db_catagoryID = $typerow['idproduct_catagory'];
                                        echo "<a class='innerLinks' href='masterChart_part_2.php?type=$db_catagoryID' > $db_typeName </a>";
                                    }
           echo  '</div></div>';
     }
 }
elseif(isset($_GET['type']))
 {
     $g_catID = $_GET['type'];
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
     echo '<div class="toggler" style="float: left; ">
                                <h3 class="ui-state-default ui-corner-all h3button" >'.$db_proName.'</h3>
                               <div  class="ui-widget-content ui-corner-all effect">
                                   <table style="margin-left: 0px;">
                                       <tr>
                                           <td>ব্র্যান্ড</td>
                                           <td>: '.$db_proBrand.'</td>
                                       </tr>
                                       <tr>
                                           <td>একক</td>
                                           <td>: '.$db_proUnit.'</td>
                                       </tr>
                                       <tr>
                                           <td>কোড</td>
                                           <td>: '.$db_proCode.'</td>
                                       </tr>
                                       <tr>
                                           <td>আর্টিকেল</td>
                                           <td>: '.$db_proArticle.'</td>
                                       </tr>
                                       <tr>
                                           <td colspan="2" style="text-align: center" ><img src="'.$db_proImage.'" width="40px" height="40px"/></td>
                                       </tr>
                                       <tr>
                                           <td colspan="2" style="text-align: center"><a class="detailsLinks" onclick="showDetails('.$db_proChartID.')">বিস্তারিত</a></td>
                                       </tr>
                                   </table>
                               </div>
                           </div>';
        }
 }
 elseif(isset($_GET['probrand']))
 {
     $g_brandcode = $_GET['probrand'];
      $sql_select_product_by_brand->execute(array($g_brandcode));
      $arr_product = $sql_select_product_by_brand->fetchAll();
      foreach ($arr_product as $value) {
                                    $db_proName = $value['pro_productname'];
                                    $db_proCode = $value['pro_code'];
                                    $db_proBrand = $value['pro_brand_or_grp'];
                                    $db_proArticle = $value['pro_article'];
                                    $db_proUnit = $value['pro_unit'];
                                    $db_proImage = $value['pro_picture'];
                                    $db_proChartID = $value['idproductchart'];
     echo '<div class="toggler" style="float: left; ">
                                <h3 class="ui-state-default ui-corner-all h3button" >'.$db_proName.'</h3>
                               <div  class="ui-widget-content ui-corner-all effect">
                                   <table style="margin-left: 0px;">
                                       <tr>
                                           <td>ব্র্যান্ড</td>
                                           <td>: '.$db_proBrand.'</td>
                                       </tr>
                                       <tr>
                                           <td>একক</td>
                                           <td>: '.$db_proUnit.'</td>
                                       </tr>
                                       <tr>
                                           <td>কোড</td>
                                           <td>: '.$db_proCode.'</td>
                                       </tr>
                                       <tr>
                                           <td>আর্টিকেল</td>
                                           <td>: '.$db_proArticle.'</td>
                                       </tr>
                                       <tr>
                                           <td colspan="2" style="text-align: center" ><img src="'.$db_proImage.'" width="40px" height="40px"/></td>
                                       </tr>
                                       <tr>
                                           <td colspan="2" style="text-align: center"><a class="detailsLinks" onclick="showDetails('.$db_proChartID.')">বিস্তারিত</a></td>
                                       </tr>
                                   </table>
                               </div>
                           </div>';
        }
 }
?>
