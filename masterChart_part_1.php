<?php 
    include_once 'includes/header.php';
    include_once './includes/selectQueryPDO.php';

    function showCatagory($sql)
    {
         echo  "<option value=0> -সিলেক্ট করুন- </option>";
        $sql->execute(array());
        $arr_catagoryRslt = $sql->fetchAll();
        foreach ($arr_catagoryRslt as $catrow) {
            echo  "<option value=".$catrow['pro_cat_code'].">".$catrow['pro_catagory']."</option>";
        }
    }
 function showBrand($sql)
    {
         echo  "<option value=0> -সিলেক্ট করুন- </option>";
        $sql->execute(array());
        $arr_brandRslt = $sql->fetchAll();
        foreach ($arr_brandRslt as $brandrow) {
            echo  "<option value=".$brandrow['pro_brnd_or_grp_code'].">".$brandrow['pro_brand_or_grp']."</option>";
        }
    }
?>
<style type="text/css"> @import "css/bush.css";</style>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="javascripts/jquery-1.9.1.js"></script>
<script src="javascripts/jquery-ui.js"></script>
<style type="text/css">
.toggler {
width: 200px;
height: auto;
margin: 5px 10px;
}
.effect {
position: relative;
width: 200px;
height: auto;
padding: 0.4em;
}
.innerLinks {
    display:block;
    text-decoration: none;
    text-align:center;
    cursor:pointer;
    color:green;
    background-color:#fcefa1;
    margin:3px 0px;
    border:1px solid green;
}
.innerLinks:hover {
    background-color:#1a82f7;
    border: 1px solid #03C;
    color: #fcefa1;
}
h3 {
    text-align: center;
    width: 200px;
    cursor: pointer;
}
h3:hover,
h3:active {
    background: #c2bdbd;
    border: 1px solid black;
}
</style>
<script type="text/javascript">
$(function() {
   // $(".effect").hide();
    //var first = $(".effect:first"); 
    //first.show();
    $( ".h3button" ).click(function() {
        var selectedEffect = 'blind';
        var content = $(this).next();
        $(content).toggle( selectedEffect, 500 );
        return false;
    });
});
</script>
<!-- ################### ajax ####################################-->
<script>
    function showSpecificCatagory(catagory) // for specific catagory
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
                document.getElementById('catagoryShowcage').innerHTML=xmlhttp.responseText;
            }
        }
        var selectbox = document.getElementById('catagory');
        var catname = selectbox.options[ selectbox.selectedIndex].text;
        xmlhttp.open("GET","includes/masterChartIncludes.php?catcode="+catagory+"&catname="+catname,true);
        xmlhttp.send();	
}

function showCatagoryForBrand(brand) 
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
                document.getElementById('catagoryShowcage').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/masterChartIncludes.php?brand="+brand,true);
        xmlhttp.send();	
}
</script>
<div class="page_header_div">
    <div class="page_header_title">মূল পণ্য তালিকা (মাস্টার চার্ট)</div>
</div>
<div>
    <table>
        <tr>
            <td style="text-align: right;color: #000099;font-size:14px;">ক্যাটাগরি :
                <select id='catagory' class="box" onchange= "showSpecificCatagory(this.value)">
                    <?php showCatagory($sql_select_all_catagory)?>
                </select>
            </td>
            <td style="text-align: center;color: red;"> <b>অথবা </b></td>
            <td style="color: #000099;font-size:14px;">ব্র্যান্ড / গ্রুপ :
                <select class="box" onchange='showCatagoryForBrand(this.value)'>
                    <?php showBrand($sql_select_all_brand)?>
                </select>            
            </td>
        </tr>
        <tr>
            <td colspan="3"></br>
                <div id="catagoryShowcage" style="width: 100%;height: auto;" >
                        <?php
                                // ******************************** catagory ****************************
                                $sql_select_all_catagory->execute();
                                $arr_catagory = $sql_select_all_catagory->fetchAll();
                                foreach ($arr_catagory as $value) {
                                $db_catName = $value['pro_catagory'];
                                $db_catCode = $value['pro_cat_code'];
                        ?>
                    <div class="toggler" style="float: left; ">
                            <h3 class="ui-state-default ui-corner-all h3button" style="text-align: center;width: 200px;"><?php echo $db_catName;?></h3>
                           <div  class="ui-widget-content ui-corner-all effect">
                               <?php
                                    // ********************************* type ******************************
                                    $sql_select_type->execute(array($db_catCode));
                                    $arr_type_rslt = $sql_select_type->fetchAll();
                                    foreach ($arr_type_rslt as $typerow) {
                                        $db_typeName = $typerow['pro_type'];
                                        $db_catagoryID = $typerow['idproduct_catagory'];
                                        echo "<a class='innerLinks' href='masterChart_part_2.php?type=$db_catagoryID'> $db_typeName </a>";
                                    }
                               ?>
                           </div>
                       </div>
                            <?php }?>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php include_once 'includes/footer.php';?>