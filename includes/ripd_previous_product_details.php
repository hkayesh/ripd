<?php
include_once './connectionPDO.php';
include_once './MiscFunctions.php';
$g_id = $_GET['inventID'];
$g_str =$_GET['typeNid'];
$arr_str = explode(",", $g_str);
$type = $arr_str[0];
$id = $arr_str[1];
$sel_product = $conn->prepare("SELECT * FROM inventory,product_chart,product_catagory WHERE idinventory= ?
                                                    AND ins_product_type='general' AND ins_productid= idproductchart 
                                                    AND product_catagory_idproduct_catagory = idproduct_catagory ");
$sel_product->execute(array($g_id));
$row = $sel_product->fetchAll();
foreach ($row as $row_product) {
    $db_proname = $row_product['ins_productname'];
    $db_procode = $row_product['ins_product_code'];
    $db_procat = $row_product['pro_catagory'];
    $db_protype = $row_product['pro_type'];
    $db_probrand = $row_product['pro_brand_or_grp'];
    $db_proclass = $row_product['pro_classification'];
}

$sel_selling = $conn->prepare("SELECT sal_salesdate FROM sales,sales_summary WHERE sal_store_type=? AND sal_storeid=? 
                                            AND idsalessummary=sales_summery_idsalessummery AND inventory_idinventory= ? ORDER BY sal_salesdate ASC");
$sel_selling->execute(array($type,$id,$g_id));
$row1 = $sel_selling->fetchAll();
foreach ($row1 as $key=>$row_sell) {
    if($key == 0)
    {
        $db_sell_start = $row_sell['sal_salesdate'];
    }
    $db_sell_end = $row_sell['sal_salesdate'];
}
$sel_selling_sum = $conn->prepare("SELECT SUM(quantity),SUM(sales_extra_profit) FROM sales,sales_summary WHERE sal_store_type=? AND sal_storeid=? 
                                            AND idsalessummary=sales_summery_idsalessummery AND inventory_idinventory= ? ORDER BY sal_salesdate ASC");
$sel_selling_sum->execute(array($type,$id,$g_id));
$row2 = $sel_selling_sum->fetchAll();
foreach ($row2 as $row_sum) {
    $db_sell_qty = $row_sum['SUM(quantity)'];
    $db_sell_xprofit = $row_sum['SUM(sales_extra_profit)'];
}
?>
<style type="text/css">@import "css/bush.css";</style>
<div class="main_text_box">
    <div>           	
        <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 95%;margin: 15px;">      
            <tr><th style="text-align: center" colspan="8"><h1>প্রিভিয়াস প্রডাক্ট ডিটেইলস</h1></th></tr>
            <tr>
                <td colspan="2" style="width: 18%; text-align: left;font-weight: bold">প্রডাক্টের নাম</td>
                <td colspan="2"style="width: 37%; text-align: left">: <?php echo $db_proname?></td>
                <td colspan="2" style="width: 10%; text-align: right;font-weight: bold">কোড</td>
                <td colspan="2" style="width: 25%; text-align: left">: <?php echo $db_procode?></td>
            </tr>
            <tr>
                 <td colspan="2" style=" text-align: left;font-weight: bold">ক্যাটাগরি</td>
                <td colspan="2" style=" text-align: left">: <?php echo $db_procat?></td>
                <td colspan="2" style="width: 10%; text-align: right;font-weight: bold">টাইপ</td>
                <td colspan="2" style="width: 25%; text-align: left">: <?php echo $db_protype?></td>
            </tr>
            <tr>
                <td colspan="2" style=" text-align: left;font-weight: bold">ব্যান্ড / গ্রুপ</td>
                <td colspan="2" style=" text-align: left">: <?php echo $db_probrand?></td>
                <td colspan="2" style="width: 10%; text-align: right;font-weight: bold">প্রকার</td>
                <td colspan="2" style="width: 25%; text-align: left">: <?php echo $db_proclass?></td>
            </tr>
             <tr>
                 <td colspan="2" style=" text-align: left;font-weight: bold">মোট বিক্রি</td>
                 <td colspan="2" style="text-align: left">: <?php echo english2bangla($db_sell_qty)." টি";?></td>
                <td colspan="2" style="width: 25%; text-align: right;font-weight: bold">প্রথম বিক্রির তারিখ</td>
                <td colspan="2" style="width: 25%; text-align: left">: <?php echo english2bangla(date("d/m/Y",  strtotime($db_sell_start)))?></td>
            </tr>
            <tr>
                 <td colspan="4" style=" text-align: left;font-weight: bold"></td>
                <td colspan="2" style="width: 25%; text-align: right;font-weight: bold">সর্বশেষ বিক্রির তারিখ</td>
                <td colspan="2" style="width: 25%; text-align: left">: <?php echo english2bangla(date("d/m/Y",  strtotime($db_sell_end)))?></td>
            </tr>
             <tr>
                <td colspan="4" style="width: 50%; text-align: right;font-weight: bold">মোট সেলিং আর্ন</td>
                <td colspan="4" style="width: 50%; text-align: left">: </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 50%; text-align: right;font-weight: bold">মোট রিপড ইনকাম</td>
                <td colspan="4" style="width: 50%; text-align: left">: </td>
            </tr>
            <tr>
               <td colspan="8" ><hr /></td>
            </tr>
            <tr>
                <td colspan="4" style="width: 50%; text-align: right;font-weight: bold">মোট প্রফিট</td>
                <td colspan="4" style="width: 50%; text-align: left">: </td>
            </tr>
            <tr>
                <td colspan="4" style="width: 50%; text-align: right;font-weight: bold">মোট এক্সট্রা প্রফিট</td>
                <td colspan="4" style="width: 50%; text-align: left">: <?php echo $db_sell_xprofit." টাকা"?></td>
            </tr>
            <tr>
               <td colspan="8" ><hr /></td>
            </tr>
             <tr>
                 <td colspan="4" style="width: 50%; text-align: right;font-weight: bold">সর্বমোট প্রফিট</td>
                <td colspan="4" style="width: 50%; text-align: left">: </td>
            </tr>
        </table>
    </div>
</div>   