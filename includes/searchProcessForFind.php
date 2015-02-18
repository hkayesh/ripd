<?php
include 'ConnectDB.inc';
include_once 'MiscFunctions.php';

if ($_GET['id']== 't')
{
    $G_catCode= $_GET['catagory'];
    $typeReslt =mysql_query("SELECT * FROM `product_catagory` WHERE pro_cat_code= '$G_catCode' ORDER BY pro_type;") or exit ("sorry...");
    echo "<select class='box'  onchange='showBrands(this.value);showTypeProducts(this.value);' style='width: 200px;font-family: SolaimanLipi !important;'>";
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
    $brandReslt =mysql_query("SELECT DISTINCT pro_brnd_or_grp_code, pro_brand_or_grp FROM `product_chart` WHERE product_catagory_idproduct_catagory=$G_proCatID ;") or exit ("sorry. :p..");
    echo "<select class='box' onchange='showBrandProducts(this.value,$G_proCatID);' style='width: 200px;font-family: SolaimanLipi !important;'>";
    echo  "<option value=0>-সিলেক্ট করুন-</option>";
    while($brandRow = mysql_fetch_assoc($brandReslt))
    {
            echo  "<option value=".$brandRow['pro_brnd_or_grp_code'].">".$brandRow['pro_brand_or_grp']."</option>";
    }
    echo "</select>";
}

// ---------------------------- products for specific type-----------------------------------------------------------
elseif ($_GET['id']== 'type')
{
    echo '<table style="width: 96%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                                            <thead>
                                          <tr id="table_row_odd">
                                              <td width="11%" style="border: solid black 1px;"><div align="center"><strong>ক্রমিক নং</strong></div></td>
                                            <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
                                            <td width="30%"  style="border: solid black 1px;"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>
                                            <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>মূল্য (টাকা)</strong></div></td>
                                          </tr>
                                          </thead>
                                          <tbody style="background-color: #FCFEFE">';
        if (isset($_GET['proCatID']))
                {
                            $g_str = $_GET['invStr'];
                            $arr_str = explode(",", $g_str);
                            $type = $arr_str[0];
                            $id = $arr_str[1];
                            $SL= 1;
                            $G_productCatID = $_GET['proCatID'];
                            $result = mysql_query("SELECT * FROM inventory,product_chart
                                WHERE ins_ons_id = $id AND ins_ons_type='$type' AND ins_product_type='general' AND ins_productid = idproductchart 
                                    AND product_catagory_idproduct_catagory =$G_productCatID");
                            $numberOfRows = mysql_num_rows($result);
                            if($numberOfRows > 0)
                            {
                                while($row = mysql_fetch_assoc($result))
                                {
                                        $db_proname=$row["pro_productname"];
                                        $db_procode=$row["pro_code"];
                                        $db_sellingprice = $row['ins_sellingprice'];
                                        echo '<tr>';
                                        echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($SL).'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="left">'.$db_procode.'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($db_sellingprice).'</div>
                                                                       <input type="hidden" id="invStr" value= "'.$g_str.'" /></td>';
                                        echo '</tr>';
                                    $SL++;
                                }
                                 echo "</tbody></table>";
                            }
                            else {
                                echo '<tr><td><input type="hidden" id="invStr" value= "'.$g_str.'" /></td></tr></tbody></table>';
                            }
                }
}
// ---------------------------- products for specific catagory-----------------------------------------------------------
elseif ($_GET['id']== 'catagory')
{
  echo '<table style="width: 96%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                                            <thead>
                                          <tr id="table_row_odd">
                                              <td width="11%" style="border: solid black 1px;"><div align="center"><strong>ক্রমিক নং</strong></div></td>
                                            <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
                                            <td width="30%"  style="border: solid black 1px;"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>
                                            <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>মূল্য (টাকা)</strong></div></td>
                                          </tr>
                                          </thead>
                                          <tbody style="background-color: #FCFEFE">';
        if (isset($_GET['proCatCode']))
                {
                            $g_str = $_GET['invStr'];
                            $arr_str = explode(",", $g_str);
                            $type = $arr_str[0];
                            $id = $arr_str[1];
                            $SL= 1;
                            $G_productCatCode = $_GET['proCatCode'];
                            $result = mysql_query("SELECT * FROM inventory,product_chart ,product_catagory 
                                WHERE ins_ons_id = $id AND ins_ons_type='$type' AND ins_product_type='general' AND ins_productid = idproductchart 
                                    AND product_catagory_idproduct_catagory =idproduct_catagory 
                                    AND pro_cat_code= '$G_productCatCode'");
                            $numberOfRows = mysql_num_rows($result);
                            if($numberOfRows > 0)
                            {
                                while($row = mysql_fetch_assoc($result))
                                {
                                        $db_proname=$row["pro_productname"];
                                        $db_procode=$row["pro_code"];
                                        $db_sellingprice = $row['ins_sellingprice'];
                                        echo '<tr>';
                                        echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($SL).'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="left">'.$db_procode.'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($db_sellingprice).'</div>
                                                                      <input type="hidden" id="invStr" value= "'.$g_str.'" /></td></td>';
                                        echo '</tr>';
                                    $SL++;
                                }
                                echo "</tbody></table>";
                            }
                            else {
                                echo '<tr><td><input type="hidden" id="invStr" value= "'.$g_str.'" /></td></tr></tbody></table>';
                            }
                }
}
//***************************products list for specific brand*******************************
elseif ($_GET['id']== 'brnd')
{
   echo '<table style="width: 96%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                                            <thead>
                                          <tr id="table_row_odd">
                                              <td width="11%" style="border: solid black 1px;"><div align="center"><strong>ক্রমিক নং</strong></div></td>
                                            <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
                                            <td width="30%"  style="border: solid black 1px;"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>
                                            <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>মূল্য (টাকা)</strong></div></td>
                                          </tr>
                                          </thead>
                                          <tbody style="background-color: #FCFEFE">';
        if (isset($_GET['brandCode']))
                {
                            $g_str = $_GET['invStr'];
                            $arr_str = explode(",", $g_str);
                            $type = $arr_str[0];
                            $id = $arr_str[1];
                            $SL= 1;
                            $G_brandcode = $_GET['brandCode'];
                            $G_idproductCatagory = $_GET['procatid'];
                            if($G_brandcode == 0)
                            {
                                $result = mysql_query("SELECT * FROM inventory,product_chart 
                                    WHERE ins_ons_id = $id AND ins_ons_type='$type' AND ins_product_type='general' AND ins_productid = idproductchart 
                                    AND  product_catagory_idproduct_catagory=$G_idproductCatagory ");
                            }
                            else
                            {
                                $result = mysql_query("SELECT * FROM inventory,product_chart 
                                    WHERE ins_ons_id = $id AND ins_ons_type='$type' AND ins_product_type='general' AND ins_productid = idproductchart
                                    AND pro_brnd_or_grp_code =$G_brandcode AND product_catagory_idproduct_catagory=$G_idproductCatagory");
                            }
                            $numberOfRows = mysql_num_rows($result);
                            if($numberOfRows > 0)
                            {
                                while($row = mysql_fetch_assoc($result))
                                {
                                    $db_proname=$row["pro_productname"];
                                        $db_procode=$row["pro_code"];
                                        $db_sellingprice = $row['ins_sellingprice'];
                                        echo '<tr>';
                                        echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($SL).'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="left">'.$db_procode.'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($db_sellingprice).'</div>
                                                                       <input type="hidden" id="invStr" value="'.$g_str.'" /></td>';
                                        echo '</tr>';
                                        $SL++;
                                }
                                 echo "</tbody></table>";
                            }
                            else {
                                echo '<tr><td><input type="hidden" id="invStr" value= "'.$g_str.'" /></td></tr></tbody></table>';
                            }                                
                }
}
?>