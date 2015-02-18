<?php
error_reporting(0);
include_once './connectionPDO.php';
include_once './selectQueryPDO.php';
include_once './MiscFunctions.php';
$g_proChartID = $_GET['proID'];

$sql_select_product ->execute(array($g_proChartID));
$arr_product = $sql_select_product->fetchAll();
foreach ($arr_product as $proRow) {
    $db_proname = $proRow['pro_productname'];
    $db_proCode = $proRow['pro_code'];
    $db_proBrand = $proRow['pro_brand_or_grp'];
    $db_proArticle = $proRow['pro_article'];
    $db_proUnit = $proRow['pro_unit'];
    $db_proImage = $proRow['pro_picture'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css"> @import "../css/bush.css";</style>
        <script type="text/javascript" src="../javascripts/external/mootools.js"></script>
        <script type="text/javascript" src="../javascripts/dg-filter.js"></script>
    </head>
    <body>
	
            <table  class="formstyle" style="margin: 5px 10px 15px 10px; width: 99%; font-family: SolaimanLipi !important;">          
                <tr><th colspan="3" style="text-align: center;"><?php echo $db_proname?></th></tr>
                <tr>
                    <td>
                        <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;"><?php echo $db_proCode?></legend>
                            <table>
                                <tr>
                                        <td><b>ব্র্যান্ড</b></td>
                                        <td>: <?php echo $db_proBrand;?></td>
                                 </tr>
                                       <tr>
                                           <td><b>একক</b></td>
                                           <td>: <?php echo $db_proUnit;?></td>
                                       </tr>
                                       <tr>
                                           <td><b>কোড</b></td>
                                           <td>: <?php echo $db_proCode;?></td>
                                       </tr>
                                       <tr>
                                           <td><b>আর্টিকেল</b></td>
                                           <td>: <?php echo $db_proArticle;?></td>
                                       </tr>
                                       <tr>
                                           <td colspan="2" style="text-align: center" ><img src="../<?php echo $db_proImage;?>" width="100px" height="100px"/></td>
                                       </tr>
                            </table>
                        </fieldset>
                    </td>
                    <td>
                        <table border="1">
                            <tr>
                                <td>সার্চ/খুঁজুন: <input class="box" style="width: 150px;" type="text" id="search_box_filter" /></td>
                            </tr>
                            <tr>
                                <td>
                                    <table cellpadding="0" cellspacing="0" id="storeTable">
                                        <thead>
                                        <tr style="background-color: #267CB2; color: beige;" >
                                            <td style="border: 1px solid black">ক্রম</td>
                                            <td style="border: 1px solid black">অফিস/সেলসস্টোর</td>
                                            <td style="border: 1px solid black">ঠিকানা</td>
                                            <td style="border: 1px solid black">মোবাইল</td>
                                            <td style="border: 1px solid black">ইমেইল</td>
                                            <td style="border: 1px solid black">মূল্য (টাকা)</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sl = 1;
                                                $sql_select_product_from_inventory ->execute(array($g_proChartID));
                                                $arr_inventory = $sql_select_product_from_inventory->fetchAll();
                                                foreach ($arr_inventory as $value) {
                                                    $db_sellingprice = $value['ins_sellingprice'];
                                                    $db_onsID = $value['ins_ons_id'];
                                                    $db_onsType = $value['ins_ons_type'];
                                                    if( $db_onsType == 'office')
                                                    {
                                                        $sql_select_office->execute(array($db_onsID));
                                                        $arr_office = $sql_select_office->fetchAll();
                                                        foreach ($arr_office as $offrow) {
                                                            $db_offname = $offrow['office_name'];
                                                            $db_offaddress = $offrow['office_details_address'];
                                                            $db_offmail = $offrow['office_email'];
                                                            $db_offmbl = $offrow[''];
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $sql_select_sales_store->execute(array($db_onsID));
                                                        $arr_office = $sql_select_sales_store->fetchAll();
                                                        foreach ($arr_office as $offrow) {
                                                            $db_offname = $offrow['salesStore_name'];
                                                            $db_offaddress = $offrow['salesStore_details_address'];
                                                            $db_offmail = $offrow['salesStore_email'];
                                                            $db_offmbl = $offrow[''];
                                                        }
                                                    }
                                                    $slNo = english2bangla($sl);
                                                    echo "<tr>
                                                            <td style='border: 1px solid black'>$slNo</td>
                                                            <td style='border: 1px solid black'>$db_offname</td>
                                                            <td style='border: 1px solid black'>$db_offaddress</td>
                                                            <td style='border: 1px solid black'></td>
                                                            <td style='border: 1px solid black'>$db_offmail</td>
                                                            <td style='border: 1px solid black'>$db_sellingprice</td>
                                                        </tr>";
                                                    $sl++;
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>      
            </table>
                    <script type="text/javascript">
                var filter = new DG.Filter({
                    filterField : $('search_box_filter'),
                    filterEl : $('storeTable'),
                    colIndexes : [1,2]
                });
         </script>
    </body>
</html>