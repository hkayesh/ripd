<?php
error_reporting(0);
session_start();
include 'ConnectDB.inc'; 
$storeID = $_SESSION['loggedInOfficeID'];
$scatagory =$_SESSION['loggedInOfficeType'];
    if (isset($_GET['searchKey1']) && $_GET['searchKey1'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchKey1'];
	$suggest_query = "SELECT * FROM inventory WHERE ins_product_code LIKE('" .$str_key ."%') AND ins_ons_id = $storeID AND ins_ons_type='$scatagory' AND ins_product_type = 'general' ORDER BY ins_product_code";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) 
                    {
                                $inventoryid = $suggest['idinventory'];
                               echo "<a class='prolinks' onclick=inventoryProductInfo('$inventoryid'); style='text-decoration:none;color:brown;cursor:pointer;display:block;'>" . $suggest['ins_product_code'] ." ".$suggest['ins_productname']. "</a>";
                      }
}
    elseif (isset($_GET['searchKey2']) && $_GET['searchKey2'] != '') {
	//Add slashes to any quotes to avoid SQL problems.
	$str_key = $_GET['searchKey2'];
	$suggest_query = "SELECT * FROM product_chart WHERE pro_code LIKE('" .$str_key ."%') ORDER BY pro_code";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) 
                    {
                        $chartid = $suggest['idproductchart'];
                        echo "<a class='prolinks' onclick=ProductInfo('$chartid'); style='text-decoration:none;color:brown;cursor:pointer;display:block;'>" . $suggest['pro_code'] ." ".$suggest['pro_productname']. "</a>";
                      }
}
    elseif (isset($_GET['id1'])) {
	$invnID = $_GET['id1'];
                   $stmt = mysql_query("SELECT * FROM inventory,product_chart WHERE idproductchart= ins_productid AND idinventory=$invnID");
                   while($inventoryrow = mysql_fetch_assoc($stmt))
                   {
                                            $db_productname = $inventoryrow['ins_productname'];
                                            $db_productcode = $inventoryrow['ins_product_code'];
                                            $db_unit = $inventoryrow['pro_unit'];
                                            $db_qty = $inventoryrow['ins_how_many'];
                                        }
                    $str_sent = $db_productcode.",".$db_productname.",".$db_unit.",".$db_qty.",".$invnID;
                  echo $str_sent;
}
elseif (isset($_GET['id2'])) {
	$chartID = $_GET['id2'];
                    $selstmt2 = mysql_query("SELECT * FROM product_chart WHERE idproductchart=$chartID");
                    while($chartrow = mysql_fetch_assoc($selstmt2)) {
                                                $db_productname = $chartrow['pro_productname'];
                                                $db_productcode = $chartrow['pro_code'];
                                                $db_unit = $chartrow['pro_unit'];
                                            }
                                            $selstmt = mysql_query("SELECT * FROM inventory WHERE ins_product_type= 'general' AND ins_productid=$chartID AND ins_ons_id =$storeID AND ins_ons_type= '$scatagory' ");
                                            if(mysql_num_rows($selstmt) > 0)
                                            {
                                                $row = mysql_fetch_assoc($selstmt);
                                                $db_inventoryqty = $row['ins_how_many'];
                                            }
                                            else { $str_sorry = "দুঃখিত, এই পণ্যটি এন্ট্রি হয়নি"; $db_inventoryqty =  urlencode($str_sorry);}
                   
                    $str_sent2 = $db_productcode.",".$db_productname.",".$db_unit.",".$db_inventoryqty.",".$chartID;
                  echo $str_sent2;
}
elseif (isset($_GET['code'])) {
	$g_proID = $_GET['code'];
                     $g_qty1 = $_GET['qty1'];
                    $g_qty2 = $_GET['qty2'];
                    $sel_invnetory = mysql_query("SELECT * FROM inventory WHERE idinventory=$g_proID ");
                    while ($inventoryrow = mysql_fetch_assoc($sel_invnetory)) {
                        $db_buyingprice = $inventoryrow['ins_buying_price'];
                        $db_sellingprice = $inventoryrow['ins_sellingprice'];
                        $db_profit = $inventoryrow['ins_profit'];
                        $db_xtraprofit = $inventoryrow['ins_extra_profit'];
                    }
                   $newbuyingprice = ($db_buyingprice / $g_qty1) * $g_qty2;
                   $newsellingprice = ($db_sellingprice / $g_qty1) * $g_qty2;
                   $newprofit = ($db_profit / $g_qty1) * $g_qty2;
                   $newxtraprofit = ($db_xtraprofit / $g_qty1) * $g_qty2;
                    $str_sent3 = $newbuyingprice.",".$newsellingprice.",".$newprofit.",".$newxtraprofit;
                  echo $str_sent3;
}
?>