<?php
error_reporting(0);
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
    echo "<select class='box' onchange='showClass(this.value,$G_proCatID);showBrandProducts(this.value,$G_proCatID);' style='width: 200px;font-family: SolaimanLipi !important;'>";
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
    echo "<select class='box' onchange='showProduct(this.value,$G_brandCode,$G_chartID)' style='width: 200px;font-family: SolaimanLipi !important;'>";
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
   echo '<table style="width: 96%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                                            <thead>
                                          <tr id="table_row_odd">
                                              <td width="11%" style="border: solid black 1px;"><div align="center"><strong>ক্রমিক নং</strong></div></td>
                                            <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
                                            <td width="30%"  style="border: solid black 1px;"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>
                                            <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>একক</strong></div></td>
                                            <td width="12%" style="border: solid black 1px;"><div align="center"><strong></strong></div></td>
                                          </tr>
                                          </thead>
                                          <tbody style="background-color: #FCFEFE">';
        if (isset($_GET['chartID']))
                {	
                            $G_productChartID = $_GET['chartID'];
                           $G_whichBrand = $_GET['idbrand'];
                            $G_whichtype = $_GET['cataID'];
                            $SL= 1;
                            if($G_productChartID == 0)
                            {
                                $result = mysql_query("SELECT * FROM product_chart WHERE pro_brnd_or_grp_code ='$G_whichBrand' AND product_catagory_idproduct_catagory='$G_whichtype'") or exit ("hai hai ahia");
                            }
                             else
                            {
                                 $result = mysql_query("SELECT * FROM product_chart WHERE idproductchart = '$G_productChartID';");
                            }
                          while( $row = mysql_fetch_assoc($result))
                             {
                                $db_proname=$row["pro_productname"];
                                $db_unit=$row["pro_unit"];
                                $db_procode=$row["pro_code"];
                                $db_proChartID = $row["idproductchart"];
                            echo '<tr>';
                            echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($SL).'</div></td>';
                            echo '<td  style="border: solid black 1px;"><div align="left">'.$db_procode.'</div></td>';
                            echo '<td  style="border: solid black 1px;"><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                            echo '<td  style="border: solid black 1px;"><div align="center">'.$db_unit.'</div></td>';
                            echo '<td style="border: solid black 1px;"><div align="center"><a onclick="details('.$db_proChartID.')" style="cursor:pointer;color:blue;"><u>বিস্তারিত<u></a></div></td>';
                            echo '</tr>';
                            $SL++;
                               }
                }
        echo "</tbody></table>";

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
                                            <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>একক</strong></div></td>
                                            <td width="12%" style="border: solid black 1px;"><div align="center"><strong></strong></div></td>
                                          </tr>
                                          </thead>
                                          <tbody style="background-color: #FCFEFE">';
        if (isset($_GET['proCatID']))
                {
                            $functionName = $_GET['function'];
                            $SL= 1;
                            $G_productCatID = $_GET['proCatID'];
                            $result = mysql_query("SELECT * FROM product_chart WHERE product_catagory_idproduct_catagory =$G_productCatID");
                            $numberOfRows = mysql_num_rows($result);
                            if($numberOfRows > 0)
                            {    
                            while($row = mysql_fetch_assoc($result))
                                {
                                        $db_proname=$row["pro_productname"];
                                        $db_unit=$row["pro_unit"];
                                        $db_article=$row["pro_article"];
                                        $db_procode=$row["pro_code"];
                                        $db_proChartID = $row["idproductchart"];
                                        $function = $functionName."(".$db_proChartID.")";
                                        echo '<tr>';
                                        echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($SL).'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="left">'.$db_procode.'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="center">'.$db_unit.'</div></td>';
                                        echo '<td style="border: solid black 1px;"><div align="center"><a onclick='.$function.' style="cursor:pointer;color:blue;"><u>বিস্তারিত<u></a></div>
                                            <input type="hidden" id="fun" value='.$functionName.' /></td>';
                                        echo '</tr>';
                                    $SL++;
                                }
                                echo "</tbody></table>";
                            }
                            else {
                                echo '<tr><td><input type="hidden" id="fun" value='.$functionName.' /></td></tr></tbody></table>';
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
                                            <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>একক</strong></div></td>
                                            <td width="12%" style="border: solid black 1px;"><div align="center"><strong></strong></div></td>
                                          </tr>
                                          </thead>
                                          <tbody style="background-color: #FCFEFE">';
        if (isset($_GET['proCatCode']))
                {
                            $functionName = $_GET['function'];
                            $SL= 1;
                            $G_productCatCode = $_GET['proCatCode'];
                            $result = mysql_query("SELECT * FROM product_chart ,product_catagory WHERE product_catagory_idproduct_catagory =idproduct_catagory AND pro_cat_code= '$G_productCatCode'");
                            $numberOfRows = mysql_num_rows($result);
                            if($numberOfRows > 0)
                            {    
                            while($row = mysql_fetch_assoc($result))
                                {
                                        $db_proname=$row["pro_productname"];
                                        $db_unit=$row["pro_unit"];
                                        $db_article=$row["pro_article"];
                                        $db_procode=$row["pro_code"];
                                        $db_proChartID = $row["idproductchart"];
                                        $function = $functionName."(".$db_proChartID.")";
                                        echo '<tr>';
                                        echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($SL).'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="left">'.$db_procode.'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="center">'.$db_unit.'</div></td>';
                                        echo '<td style="border: solid black 1px;"><div align="center"><a onclick='.$function.' style="cursor:pointer;color:blue;"><u>বিস্তারিত<u></a></div>
                                            <input type="hidden" id="fun" value='.$functionName.' /></td>';
                                        echo '</tr>';
                                    $SL++;
                                }
                                echo "</tbody></table>";
                            }
                            else {
                                echo '<tr><td><input type="hidden" id="fun" value='.$functionName.' /></td></tr></tbody></table>';
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
                                            <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>একক</strong></div></td>
                                            <td width="12%" style="border: solid black 1px;"><div align="center"><strong></strong></div></td>
                                          </tr>
                                          </thead>
                                          <tbody style="background-color: #FCFEFE">';
        if (isset($_GET['brandCode']))
                {
                            $functionName = $_GET['function'];
                            $SL= 1;
                            $G_brandcode = $_GET['brandCode'];
                            $G_idproductCatagory = $_GET['procatid'];
                            if($G_brandcode == 0)
                            {
                                $result = mysql_query("SELECT * FROM product_chart WHERE  product_catagory_idproduct_catagory=$G_idproductCatagory ");
                            }
                            else
                            {
                                $result = mysql_query("SELECT * FROM product_chart WHERE pro_brnd_or_grp_code =$G_brandcode AND product_catagory_idproduct_catagory=$G_idproductCatagory");
                            }
                            $numberOfRows = mysql_num_rows($result);
                            if($numberOfRows > 0)
                            {    
                            while($row = mysql_fetch_assoc($result))
                                {
                                    $db_proname=$row["pro_productname"];
                                        $db_unit=$row["pro_unit"];
                                        $db_article=$row["pro_article"];
                                        $db_procode=$row["pro_code"];
                                        $db_proChartID = $row["idproductchart"];
                                        $function = $functionName."(".$db_proChartID.")";
                                        echo '<tr>';
                                        echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($SL).'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="left">'.$db_procode.'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                                        echo '<td  style="border: solid black 1px;"><div align="center">'.$db_unit.'</div></td>';
                                        echo '<td style="border: solid black 1px;"><div align="center"><a onclick='.$function.' style="cursor:pointer;color:blue;"><u>বিস্তারিত<u></a></div>
                                            <input type="hidden" id="fun" value='.$functionName.' /></td>';
                                        echo '</tr>';
                                        $SL++;
                                }
                                echo "</tbody></table>";
                            }
                            else {
                                echo '<tr><td><input type="hidden" id="fun" value='.$functionName.' /></td></tr></tbody></table>';
                            }                
                }
}
?>