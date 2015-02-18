<?php
error_reporting(0);
//include 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/areaSearchForProduct.php';

function get_catagory()
{
    echo  "<option value=0> -সিলেক্ট করুন- </option>";
    $catagoryRslt= mysql_query("SELECT DISTINCT pro_catagory, pro_cat_code FROM product_catagory ORDER BY pro_catagory;");
    while($catrow = mysql_fetch_assoc($catagoryRslt))
    {
	echo  "<option value=".$catrow['pro_cat_code'].">".$catrow['pro_catagory']."</option>";
    }
}

?>
<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript" src="javascripts/area3.js"></script>
<!--===========================================================================================================================-->
<script>
function showTypes(catagory) // for types dropdown list
{
    var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById('showtype').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcessForFind.php?id=t&catagory="+catagory,true);
        xmlhttp.send();	
}
function showBrands(type) // for brand dropdown list
{
    var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById('brand').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/searchProcessForFind.php?id=b&type="+type,true);
        xmlhttp.send();	
}

function showCatProducts(code) // show products from selecting catagory
{
    var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById('resultTable').innerHTML=xmlhttp.responseText;
            }
        }
        var invStr = document.getElementById('invStr').value;
        xmlhttp.open("GET","includes/searchProcessForFind.php?id=catagory&proCatCode="+code+"&invStr="+invStr,true);
        xmlhttp.send();
}
function showTypeProducts(proCatID) // show products from selecting types
{
    var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById('resultTable').innerHTML=xmlhttp.responseText;
            }
        }
        var invStr = document.getElementById('invStr').value;
        xmlhttp.open("GET","includes/searchProcessForFind.php?id=type&proCatID="+proCatID+"&invStr="+invStr,true);
        xmlhttp.send();
}

function showBrandProducts(brandcode,procatid) // show products from brand
{
    var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById('resultTable').innerHTML=xmlhttp.responseText;
            }
        }
        var invStr = document.getElementById('invStr').value;
        xmlhttp.open("GET","includes/searchProcessForFind.php?id=brnd&brandCode="+brandcode+"&procatid="+procatid+"&invStr="+invStr,true);
        xmlhttp.send();
}
</script>  

    <div class="main_text_box">
            <div>           
                <form method="POST" onsubmit="" >	
                    <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 80%;">          
                        <tr><th style="text-align: center" colspan="2"><h1>প্রাতিষ্ঠানিক চার্ট</h1></th></tr>
                        <tr>
                            <td>
                                <fieldset style="border:3px solid #686c70;width: 99%;">
                                        <legend style="color: brown;font-size: 14px;">সার্চ করুন</legend>
                                        <table>
                                            <tr>
                                                <td><?php
                                                            getAreaOffice();
                                                        ?>
                                                </td>
                                                <td><select class="box" id="offNsales" name="offNsales" style="width: 200px;font-family: SolaimanLipi !important;" onchange='showProductsForOnS(this.value)'>
                                                        <option value="0">-- অফিস / সেলসস্টোর --</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                               </fieldset>
                            </td> 
                        </tr>
                        <tr><td></br></td></tr>
                        <tr>
                            <td>
                                <fieldset   style="border: 3px solid #686c70 ; width: 99%;font-family: SolaimanLipi !important;">
                                    <legend style="color: brown;font-size: 14px;"><?php echo '';?></legend>
                                     <table>
                                         <tr><td></br></td></tr>
                                            <tr>
                                                <td><b>পণ্যের ক্যাটাগরি</b></br>
                                                    <select class="box" id="catagorySearch" name="catagorySearch" onchange="showTypes(this.value);showCatProducts(this.value);" style="width: 200px;font-family: SolaimanLipi !important;">
                                                        <?php echo get_catagory(); ?>
                                                    </select>
                                                </td>
                                                <td><b>পণ্যের টাইপ</b></br>
                                                    <span id="showtype"><select class="box" style="width: 200px;font-family: SolaimanLipi !important;"></select></span>
                                                </td>
                                                <td><b>ব্র্যান্ড / গ্রুপ</b></br>
                                                    <span id="brand"><select class="box" id="brandSearch" name="brandSearch" style="width: 200px;font-family: SolaimanLipi !important;"></select></span>
                                                </td>
                                            </tr>
                                        </table>
                                    
                                    <div id="resultTable"></br>
                                        <table style="width: 96%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                                            <thead>
                                          <tr id="table_row_odd">
                                              <td width="11%" style="border: solid black 1px;"><div align="center"><strong>ক্রমিক নং</strong></div></td>
                                            <td width="20%"  style="border: solid black 1px;"><div align="center"><strong>প্রোডাক্ট কোড</strong></div></td>
                                            <td width="30%"  style="border: solid black 1px;"><div align="center"><strong>প্রোডাক্ট-এর নাম</strong></div></td>
                                            <td width="11%"  style="border: solid black 1px;"><div align="center"><strong>একক</strong></div></td>
                                          </tr>
                                          </thead>
                                          <tbody style="background-color: #FCFEFE">
                                        <?php
                                                            $slNo = 1;
                                                        $result = mysql_query("SELECT * FROM product_chart ORDER BY pro_code ");
                                                            while ($row = mysql_fetch_assoc($result))
                                                            {
                                                                $db_proname=$row["pro_productname"];
                                                                $db_unit=$row["pro_unit"];
                                                                $db_procode=$row["pro_code"];
                                                                echo '<tr>';
                                                                echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($slNo).'</div></td>';
                                                                echo '<td  style="border: solid black 1px;"><div align="left">'.$db_procode.'</div></td>';
                                                                  echo '<td  style="border: solid black 1px;"><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                                                                  echo '<td  style="border: solid black 1px;"><div align="center">'.$db_unit.'</div></td>';
                                                                  echo '</tr>';
                                                                  $slNo++;
                                                            }
                                    ?>
                                          </tbody>
                                    </table>
                                    </div>
                                 </fieldset>
                            </td>
                        </tr>
                        <tr><td></br></td></tr>
                    </table>
                </form>
            </div>
        </div>   

<?php include_once 'includes/footer.php';?>