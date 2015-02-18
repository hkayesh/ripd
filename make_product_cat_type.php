<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
$msg = "";

if (isset($_POST['pro_submit'])) {
    if (isset($_POST['pro_catagory'])) {
        $pro_catagory = $_POST['pro_catagory'];
        $pro_cat_code = $_POST['pro_cat_code'];
        $pro_type = $_POST['pro_type'];
        $pro_type_code = $_POST['pro_type_code'];

        $sql_product_insert = mysql_query("INSERT INTO product_catagory 
                                    (pro_catagory, pro_cat_code, pro_type, pro_type_code)
                                     VALUES  ('$pro_catagory', '$pro_cat_code', '$pro_type', '$pro_type_code')");
        if ($sql_product_insert) {
            $msg = "আপনার তথ্যটি সঠিকভাবে সংরক্ষিত হয়েছে";
        } else {
            $msg = "দুঃখিত, আবার চেস্টা করুন";
        }
    } else {     
        $pro_category_code = $_POST['product'];
        $pro_type = $_POST['pro_type'];
        $pro_type_code = $_POST['pro_type_code'];
        $sql_select = mysql_query("SELECT pro_catagory  FROM product_catagory where pro_cat_code ='$pro_category_code' ");
        $product_result= mysql_fetch_assoc($sql_select);
        $product_cat_name = $product_result['pro_catagory'];
        $sql_product_insert = mysql_query("INSERT INTO product_catagory 
                                    (pro_catagory, pro_cat_code, pro_type, pro_type_code)
                                     VALUES  ('$product_cat_name', '$pro_category_code', '$pro_type', '$pro_type_code')");
        if ($sql_product_insert) {
            $msg = "আপনার তথ্যটি সঠিকভাবে সংরক্ষিত হয়েছে";
        } else {
            $msg = "দুঃখিত, আবার চেষ্টা করুন";
        }
    }
}
?>
<title>মেইক প্রোডাক্ট ক্যাটাগরি এন্ড টাইপ</title>
<style type="text/css">@import "css/bush.css";</style>
<script>
    function shownew_product_caregory(new_product_category) // for types dropdown list
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
                document.getElementById('new_product_category').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/tablerow.php?id="+new_product_category,true);
        xmlhttp.send();	
    }
function beforeSubmit()
{
    if ((document.getElementById('product_id').value !="") 
        && (document.getElementById('pro_type').value != "")
        && (document.getElementById('pro_type_code').value != ""))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>
        <div class="main_text_box">
        <div style="padding-left: 112px;"><a href="product_info_management.php"><b>ফিরে যান</b></a><a style="padding-left: 565px;" href="make_product_details_info.php"><b>প্রোডাক্ট ইনফরমেশন ইন</b></a></div>
       <div>           
                <form method="POST" onsubmit="return beforeSubmit()">	
                    <table class="formstyle"  style="font-family: SolaimanLipi !important;width: 80%;">          
                        <tr><th style="text-align: center" colspan="2"><h1>মেইক প্রোডাক্ট ক্যাটাগরি এন্ড টাইপ</h1>
                        </th>
                        </tr>
                        <tr><td colspan="2"></td>
                        </tr>
                        <?php
                        if ($msg != "") {
                            echo '<tr><td colspan="2" style="text-align: center;font-size: 16px;color: green;">'.$msg.'</td></tr>';
                        }
                        ?>
                        <tr>
                            <td>প্রোডাক্ট ক্যাটাগরি</td>
                                <td> : <select class="box2" type="text" id="product_id" name="product" onchange="shownew_product_caregory(this.value)" />
                                    <option value="" selected="selected">- প্রোডাক্ট ক্যাটাগরি -</option>
                                    <option value="new">নতুন ক্যাটাগরি</option>
                                    <?php
                                    $product_cat_sql = mysql_query("SELECT DISTINCT pro_catagory, pro_cat_code FROM $dbname.product_catagory");
                                    while ($product_cat_rows = mysql_fetch_array($product_cat_sql)) {
                                        $db_product_cat_code = $product_cat_rows['pro_cat_code'];
                                        $db_product_cat_name = $product_cat_rows['pro_catagory'];
                                        echo "<option style='width: 96%'  value='$db_product_cat_code'>$db_product_cat_name</option>";
                                    }
                                    ?>
                        </select><em2> *</em2></td> 
                        </tr>
                        <tr><td colspan="2"><table id="new_product_category" style="font-family: SolaimanLipi !important;margin-top: 0px;margin-bottom: 0px;margin-left: 0px;margin-right: 0px;border:0px solid grey; color: black;"></table></td></tr>
                        <tr>
                            <td >প্রোডাক্ট টাইপ</td><td> : <input class="box" type="text" id="pro_type" name="pro_type" id="pro_type"/><em2> *</em2></td>
                            </tr>
                            <tr>
                                <td>প্রোডাক্ট টাইপ কোড</td><td> : <input class="box" type="text" id="pro_type_code" name="pro_type_code" maxlength="2" /><em2> *</em2></td>          
                        </tr>   
                    <tr>                    
                        <td colspan="2" style="padding-top: 5px; padding-bottom: 5px;text-align: center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="pro_submit" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" />
                        </td>                           
                    </tr>
                    </table>
                </form>
            </div>
        </div>   

<?php
include_once 'includes/footer.php';
?>
