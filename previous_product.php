<?php
//include 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/areaSearchForProduct.php';

function get_catagory() {
    echo "<option value=0> -সিলেক্ট করুন- </option>";
    $catagoryRslt = mysql_query("SELECT DISTINCT pro_catagory, pro_cat_code FROM product_catagory ORDER BY pro_catagory;");
    while ($catrow = mysql_fetch_assoc($catagoryRslt)) {
        echo "<option value=" . $catrow['pro_cat_code'] . ">" . $catrow['pro_catagory'] . "</option>";
    }
}
?>
<script type="text/javascript" src="javascripts/area3.js"></script>
<style type="text/css">@import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css">
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
    function previousProductDetails(id,typeNid)
    { TINY.box.show({url:'includes/ripd_previous_product_details.php?inventID='+id+'&typeNid='+typeNid,width:700,height:400,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
</script>
<div class="main_text_box">
    <div>           
            <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 80%;">          
                <tr><th style="text-align: center" colspan="2"><h1>প্রিভিয়াস প্রোডাক্ট চার্ট</h1></th></tr>
                <tr>
                    <td>
                        <fieldset style="border:3px solid #686c70;width: 99%;">
                            <legend style="color: brown;font-size: 14px;">সার্চ করুন</legend>
                            <table>
                                <tr>
                                    <td><?php getAreaOffice(); ?></td>
                                    <td><select class="box" id="offNsales" name="offNsales" style="width: 200px;font-family: SolaimanLipi !important;" onchange='previousProductsForOnS(this.value)'>
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
                            <legend style="color: brown;font-size: 14px;">প্রিভিয়াস প্রোডাক্টের তালিকা</legend>
                            <div>
                                <table style="width: 96%;margin: 0 auto;" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr id="table_row_odd">
                                            <td width="6%" style="border: solid black 1px;text-align: center;"><strong>ক্রম</strong></td>
                                            <td width="40%"  style="border: solid black 1px;text-align: center;"><strong>প্রোডাক্ট নাম</strong></td>
                                            <td width="20%"  style="border: solid black 1px;text-align: center;"><strong>কোড</strong></td>
                                            <td width="15%"  style="border: solid black 1px;"><strong>বিক্রয় শুরু</strong></td>
                                            <td width="15%"  style="border: solid black 1px;"><strong>বিক্রয় বন্ধ</strong></td>
                                            <td width="11%"  style="border: solid black 1px;"><strong>অপশন</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody id="resultTable" style="background-color: #FCFEFE">
                                    </tbody>
                                    <tr>
                                </table>
                            </div>
                        </fieldset>
                    </td>
                </tr>
            </table>
    </div>
</div>   
<?php include_once 'includes/footer.php'; ?>