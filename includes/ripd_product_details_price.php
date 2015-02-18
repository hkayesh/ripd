<?php
error_reporting(0);
//include 'includes/session.inc';
include_once './connectionPDO.php';
include_once './selectQueryPDO.php';
include_once './MiscFunctions.php';
$g_chartID = $_GET['chartID'];

?>
<style type="text/css">@import "css/bush.css";</style>
<div class="main_text_box">
    <div>           
        <form method="POST" onsubmit="" >	
            <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 95%;margin-left: 10px;">          
                <tr><th style="text-align: center" colspan="2"><h1>বিভিন্ন অফিস / সেলসস্টোরে পণ্যটির মূল্য</h1></th></tr>
                <tr>
                    <td>
                        <table style="width: 98%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr id="table_row_odd">
                                    <td width="11%" style="border: solid black 1px;"><div align="center"><strong>ক্রমিক নং</strong></div></td>
                                    <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>অফিস / সেলসস্টোর</strong></div></td>
                                    <td width="30%"  style="border: solid black 1px;"><div align="center"><strong>মূল্য (টাকা)</strong></div></td>
                                 </tr>
                            </thead>
                            <tbody style="background-color: #FCFEFE">
                                <?php
                                     $sl = 1;
                                                $sql_select_product_from_inventory ->execute(array($g_chartID));
                                                $arr_inventory = $sql_select_product_from_inventory->fetchAll();
                                                foreach ($arr_inventory as $value) {
                                                    $db_sellingprice = $value['ins_sellingprice'];
                                                    $price = english2bangla($db_sellingprice);
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
                                                            <td style='border: 1px solid black;text-align:center;'>$price</td>
                                                        </tr>";
                                                    $sl++;
                                                }
                                ?>
                            </tbody>
                        </table>
                </tr>
            </table>
        </form>
    </div>
</div>   