<?php
include 'ConnectDB.inc';
include_once 'MiscFunctions.php';

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
    $brandReslt =mysql_query("SELECT DISTINCT pro_brnd_or_grp_code, pro_brand_or_grp FROM `product_chart` WHERE product_catagory_idproduct_catagory=$G_proCatID ;") or exit ("sorry. :p..");
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
        <td width='11%'><div align='center'><strong>একক</strong></div></td>
        <td width='12%'><div align='center'><strong>আর্টিকেল</strong></div></td>
      </tr>";
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
                                $db_article=$row["pro_article"];
                                $db_procode=$row["pro_code"];
                            echo '<tr>';
                            echo '<td><div align="center">'.english2bangla($SL).'</div></td>';
                            echo '<td><div align="left">'.$db_procode.'</div></td>';
                              echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                              echo '<td><div align="center">'.$db_unit.'</div></td>';
                              echo '<td><div align="center">'.$db_article.'</div></td>';
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
        <td width='11%'><div align='center'><strong>একক</strong></div></td>
        <td width='12%'><div align='center'><strong>আর্টিকেল</strong></div></td>
      </tr>";
        if (isset($_GET['proCatID']))
                {
                            $SL= 1;
                            $G_productCatID = $_GET['proCatID'];
                            $result = mysql_query("SELECT * FROM product_chart WHERE product_catagory_idproduct_catagory =$G_productCatID");
                                while($row = mysql_fetch_assoc($result))
                                {
                                        $db_proname=$row["pro_productname"];
                                        $db_unit=$row["pro_unit"];
                                        $db_article=$row["pro_article"];
                                        $db_procode=$row["pro_code"];
                                    echo '<tr>';
                                    echo '<td><div align="center">'.english2bangla($SL).'</div></td>';
                                    echo '<td><div align="left">'.$db_procode.'</div></td>';
                                      echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                                      echo '<td><div align="center">'.$db_unit.'</div></td>';
                                      echo '<td><div align="center">'.$db_article.'</div></td>';
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
        <td width='11%'><div align='center'><strong>একক</strong></div></td>
        <td width='12%'><div align='center'><strong>আর্টিকেল</strong></div></td>
      </tr>";
        if (isset($_GET['proCatCode']))
                {
                            $SL= 1;
                            $G_productCatCode = $_GET['proCatCode'];
                            $result = mysql_query("SELECT * FROM product_chart ,product_catagory WHERE product_catagory_idproduct_catagory =idproduct_catagory AND pro_cat_code= '$G_productCatCode'");
                                while($row = mysql_fetch_assoc($result))
                                {
                                        $db_proname=$row["pro_productname"];
                                        $db_unit=$row["pro_unit"];
                                        $db_article=$row["pro_article"];
                                        $db_procode=$row["pro_code"];
                                    echo '<tr>';
                                    echo '<td><div align="center">'.english2bangla($SL).'</div></td>';
                                    echo '<td><div align="left">'.$db_procode.'</div></td>';
                                      echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                                      echo '<td><div align="center">'.$db_unit.'</div></td>';
                                      echo '<td><div align="center">'.$db_article.'</div></td>';
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
        <td width='11%'><div align='center'><strong>একক</strong></div></td>
        <td width='12%'><div align='center'><strong>আর্টিকেল</strong></div></td>
      </tr>";
        if (isset($_GET['brandCode']))
                {
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
                                while($row = mysql_fetch_assoc($result))
                                {
                                    $db_proname=$row["pro_productname"];
                                        $db_unit=$row["pro_unit"];
                                        $db_article=$row["pro_article"];
                                        $db_procode=$row["pro_code"];
                                        echo '<tr>';
                                        echo '<td><div align="center">'.english2bangla($SL).'</div></td>';
                                        echo '<td><div align="left">'.$db_procode.'</div></td>';
                                          echo '<td><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                                          echo '<td><div align="center">'.$db_unit.'</div></td>';
                                          echo '<td><div align="center">'.$db_article.'</div></td>';
                                          echo '</tr>';
                                        $SL++;
                                }
                }
        echo "</table>";

}
?>