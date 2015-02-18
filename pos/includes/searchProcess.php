<?php
include_once 'ConnectDB.inc';
include_once 'MiscFunctions.php';
$storeID = $storeID = $_SESSION['loggedInOfficeID'];
$scatagory = $_SESSION['loggedInOfficeType'];

$sql_runningpv = mysql_query("SELECT * FROM running_command");
$pvrow = mysql_fetch_assoc($sql_runningpv);
    $current_pv = $pvrow['pv_value'];
    
if ($_GET['id']== 't')
{
    $G_catCode= $_GET['catagory'];
    $typeReslt =mysql_query("SELECT * FROM `product_catagory` WHERE pro_cat_code= '$G_catCode' ORDER BY pro_type;") or exit ("sorry...");
    echo "<select  onchange='showBrands(this.value);showTypeProducts(this.value);' style='width: 200px;font-family: SolaimanLipi !important;'>";
    echo  "<option value=0>-সিলেক্ট করুন-</option>";
    while($typeRow = mysql_fetch_assoc($typeReslt))
    {
            echo  "<option value=".$typeRow['idproduct_catagory'].">".$typeRow['pro_type']."</option>";
    }
    echo "</select>";
}

elseif ($_GET['id']== 'b')
{
    $G_proCatID= $_GET['type'];
    $brandReslt =mysql_query("SELECT DISTINCT pro_brnd_or_grp_code, pro_brand_or_grp FROM `product_chart` WHERE product_catagory_idproduct_catagory=$G_proCatID AND idproductchart = ANY( SELECT ins_productid FROM inventory WHERE ins_ons_id =$storeID AND ins_ons_type= '$scatagory');") or exit ("sorry. :p..");
    echo "<select  onchange='showClass(this.value,$G_proCatID);showBrandProducts(this.value,$G_proCatID);' style='width: 200px;font-family: SolaimanLipi !important;'>";
    echo  "<option value=0>-সিলেক্ট করুন-</option>";
    while($brandRow = mysql_fetch_assoc($brandReslt))
    {
            echo  "<option value=".$brandRow['pro_brnd_or_grp_code'].">".$brandRow['pro_brand_or_grp']."</option>";
    }
    echo "</select>";
}

elseif ($_GET['id']== 'c')
{
    $G_brandCode= $_GET['brand'];
    $G_chartID = $_GET['type'];
    $classReslt =mysql_query("SELECT * FROM `product_chart` WHERE pro_brnd_or_grp_code= '$G_brandCode' AND product_catagory_idproduct_catagory=$G_chartID ORDER BY pro_classification;") or exit ("sorry. :p..");
    echo "<select  onchange='showProduct(this.value,$G_brandCode,$G_chartID)' style='width: 200px;font-family: SolaimanLipi !important;'>";
    echo  "<option value=0>-সিলেক্ট করুন-</option>";
        while($classRow = mysql_fetch_assoc($classReslt))
        {
                echo  "<option value=".$classRow['idproductchart'].">".$classRow['pro_classification']."</option>";
        }
    echo "</select>";
}
//**************************** productlist table***************************
elseif ($_GET['id']== 'all')
{
   echo " <table width='100%' border='1' cellspacing='0' cellpadding='0' style='border-color:#000000; border-width:thin; font-size:18px;'>
      <tr>
          <td width='8%'><div align='center'><strong>ক্রমিক নং</strong></div></td>
        <td width='23%'><div align='center'><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width='30%'><div align='center'><strong>প্রোডাক্ট-এর নাম</strong></div></td>
        <td width='11%'><div align='center'><strong>পর্যাপ্ত পরিমাণ</strong></div></td>
        <td width='12%'><div align='center'><strong>খুচরা মূল্য</strong></div></td>
        <td width='10%'><div align='center'><strong>পি.ভি.</strong></div></td>
        <td width='6%'><div align='center'><strong>করনীয়</strong></div></td>
      </tr>";
        if (isset($_GET['chartID']))
                {	
                            $G_productChartID = $_GET['chartID'];
                           $G_whichBrand = $_GET['idbrand'];
                            $G_whichtype = $_GET['cataID'];
                            $SL= 1;
                            if($G_productChartID == 0)
                            {
                                $result = mysql_query("SELECT * FROM inventory WHERE ins_ons_id=$storeID AND ins_ons_type='$scatagory' AND ins_product_type= 'general' AND ins_productid = 
                                ANY( SELECT idproductchart FROM product_chart WHERE pro_brnd_or_grp_code =$G_whichBrand AND product_catagory_idproduct_catagory=$G_whichtype );") or exit ("hai hai ahia");
                            }
                            else
                            {
                                 $result = mysql_query("SELECT * FROM inventory WHERE ins_ons_id=$storeID AND ins_ons_type='$scatagory' AND ins_product_type= 'general' AND ins_productid = '$G_productChartID';");
                            }
                               while( $row = mysql_fetch_assoc($result))

                               {$db_proname=$row["ins_productname"];
                                $db_price=english2bangla($row["ins_sellingprice"]);
                                $db_qty=english2bangla($row["ins_how_many"]);
                                $db_procode=$row["ins_product_code"];
                                $db_proPV=english2bangla($row["ins_profit"] * $current_pv);
                                $inventoryID= $row['idinventory'];

              echo '<tr>';
              echo '<td><div align="center">'.english2bangla($SL).'</div></td>';
              echo '<td><div align="left">'.$db_procode.'</div></td>';
                echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                echo '<td><div align="center">'.$db_qty.'</div></td>';
                echo '<td><div align="center">'.$db_price.'</div></td>';
                echo '<td><div align="center">'.$db_proPV.'</div></td>';
                echo "<td><a onclick='productUpdate($inventoryID)' style='cursor:pointer;color:blue;'><u>আপডেট করুন</u></a></td>";
                echo '</tr>';
                $SL++;
                               }
                }
        echo "</table>";

}
// ---------------------------- products for specific catagory-----------------------------------------------------------
elseif ($_GET['id']== 'catagory')
{
   echo " <table width='100%' border='1' cellspacing='0' cellpadding='0' style='border-color:#000000; border-width:thin; font-size:18px;'>
      <tr>
          <td width='8%'><div align='center'><strong>ক্রমিক নং</strong></div></td>
        <td width='23%'><div align='center'><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width='30%'><div align='center'><strong>প্রোডাক্ট-এর নাম</strong></div></td>
        <td width='11%'><div align='center'><strong>পর্যাপ্ত পরিমাণ</strong></div></td>
        <td width='12%'><div align='center'><strong>খুচরা মূল্য</strong></div></td>
        <td width='10%'><div align='center'><strong>পি.ভি.</strong></div></td>
        <td width='6%'><div align='center'><strong>করনীয়</strong></div></td>
      </tr>";
        if (isset($_GET['proCatCode']))
                {
                            $SL= 1;
                            $G_productCatCode = $_GET['proCatCode'];
                            $result = mysql_query("SELECT * FROM inventory WHERE ins_ons_id=$storeID AND ins_ons_type='$scatagory' AND ins_product_type= 'general' AND ins_productid = 
                                ANY( SELECT idproductchart FROM product_chart,product_catagory WHERE product_catagory_idproduct_catagory =idproduct_catagory AND pro_cat_code= '$G_productCatCode');");
                                while($row = mysql_fetch_assoc($result))
                                {
                                    $inventoryID= $row['idinventory']; 
                                    echo '<tr>';
                                      echo '<td><div align="center">'.english2bangla($SL).'</div></td>';
                                      echo '<td><div align="left">'.$row["ins_product_code"].'</div></td>';
                                        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$row["ins_productname"].'</div></td>';
                                        echo '<td><div align="center">'.english2bangla($row["ins_how_many"]).'</div></td>';
                                        echo '<td><div align="center">'.english2bangla($row["ins_sellingprice"]).'</div></td>';
                                        echo '<td><div align="center">'.english2bangla($row["ins_profit"] * $current_pv).'</div></td>';
                                        echo "<td><a onclick='productUpdate($inventoryID)' style='cursor:pointer;color:blue;'><u>আপডেট করুন</u></a></td>";
                                        echo '</tr>';
                                        $SL++;
                                }
                }
        echo "</table>";

}
// ---------------------------- products for specific type-----------------------------------------------------------
elseif ($_GET['id']== 'type')
{
   echo " <table width='100%' border='1' cellspacing='0' cellpadding='0' style='border-color:#000000; border-width:thin; font-size:18px;'>
      <tr>
          <td width='8%'><div align='center'><strong>ক্রমিক নং</strong></div></td>
        <td width='23%'><div align='center'><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width='30%'><div align='center'><strong>প্রোডাক্ট-এর নাম</strong></div></td>
        <td width='11%'><div align='center'><strong>পর্যাপ্ত পরিমাণ</strong></div></td>
        <td width='12%'><div align='center'><strong>খুচরা মূল্য</strong></div></td>
        <td width='10%'><div align='center'><strong>পি.ভি.</strong></div></td>
        <td width='6%'><div align='center'><strong>করনীয়</strong></div></td>
      </tr>";
        if (isset($_GET['proCatID']))
                {
                            $SL= 1;
                            $G_productCatID = $_GET['proCatID'];
                            $result = mysql_query("SELECT * FROM inventory WHERE ins_ons_id=$storeID AND ins_ons_type='$scatagory' AND ins_product_type= 'general' AND ins_productid = 
                                ANY( SELECT idproductchart FROM product_chart WHERE product_catagory_idproduct_catagory =$G_productCatID);");
                                while($row = mysql_fetch_assoc($result))
                                {
                                    $inventoryID= $row['idinventory']; 
                                    echo '<tr>';
                                      echo '<td><div align="center">'.english2bangla($SL).'</div></td>';
                                      echo '<td><div align="left">'.$row["ins_product_code"].'</div></td>';
                                        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$row["ins_productname"].'</div></td>';
                                        echo '<td><div align="center">'.english2bangla($row["ins_how_many"]).'</div></td>';
                                        echo '<td><div align="center">'.english2bangla($row["ins_sellingprice"]).'</div></td>';
                                        echo '<td><div align="center">'.english2bangla($row["ins_profit"] * $current_pv).'</div></td>';
                                        echo "<td><a onclick='productUpdate($inventoryID)' style='cursor:pointer;color:blue;'><u>আপডেট করুন</u></a></td>";
                                        echo '</tr>';
                                        $SL++;
                                }
                }
        echo "</table>";

}
//***************************products list for specific brand*******************************
elseif ($_GET['id']== 'brnd')
{
   echo " <table width='100%' border='1' cellspacing='0' cellpadding='0' style='border-color:#000000; border-width:thin; font-size:18px;'>
      <tr>
          <td width='8%'><div align='center'><strong>ক্রমিক নং</strong></div></td>
        <td width='23%'><div align='center'><strong>প্রোডাক্ট কোড</strong></div></td>
        <td width='30%'><div align='center'><strong>প্রোডাক্ট-এর নাম</strong></div></td>
        <td width='11%'><div align='center'><strong>পর্যাপ্ত পরিমাণ</strong></div></td>
        <td width='12%'><div align='center'><strong>খুচরা মূল্য</strong></div></td>
        <td width='10%'><div align='center'><strong>পি.ভি.</strong></div></td>
        <td width='6%'><div align='center'><strong>করনীয়</strong></div></td>
      </tr>";
        if (isset($_GET['brandCode']))
                {
                            $SL= 1;
                            $G_brandcode = $_GET['brandCode'];
                            $G_idproductCatagory = $_GET['procatid'];
                            if($G_brandcode == 0)
                            {
                                $result = mysql_query("SELECT * FROM inventory WHERE ins_ons_id=$storeID AND ins_ons_type='$scatagory' AND ins_product_type= 'general' AND ins_productid = 
                                ANY( SELECT idproductchart FROM product_chart WHERE  product_catagory_idproduct_catagory=$G_idproductCatagory);");
                            }
                            else
                            {
                                $result = mysql_query("SELECT * FROM inventory WHERE ins_ons_id=$storeID AND ins_ons_type='$scatagory' AND ins_product_type= 'general' AND ins_productid = 
                                    ANY( SELECT idproductchart FROM product_chart WHERE pro_brnd_or_grp_code =$G_brandcode AND product_catagory_idproduct_catagory=$G_idproductCatagory);");
                            }
                                while($row = mysql_fetch_assoc($result))
                                {
                                    $inventoryID= $row['idinventory']; 
                                    echo '<tr>';
                                      echo '<td><div align="center">'.english2bangla($SL).'</div></td>';
                                      echo '<td><div align="left">'.$row["ins_product_code"].'</div></td>';
                                        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$row["ins_productname"].'</div></td>';
                                        echo '<td><div align="center">'.english2bangla($row["ins_how_many"]).'</div></td>';
                                        echo '<td><div align="center">'.english2bangla($row["ins_sellingprice"]).'</div></td>';
                                        echo '<td><div align="center">'.english2bangla($row["ins_profit"] * $current_pv).'</div></td>';
                                        echo "<td><a onclick='productUpdate($inventoryID)' style='cursor:pointer;color:blue;'><u>আপডেট করুন</u></a></td>";
                                        echo '</tr>';
                                        $SL++;
                                }
                }
        echo "</table>";

}
?>