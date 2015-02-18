<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
?>
<style type="text/css">
    @import "css/bush.css";
</style>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="javascripts/jquery-1.4.3.min.js"></script>
<script type="text/javascript">
    $('.del').live('click',function(){
        $(this).parent().parent().remove();
       
    });
    $('.add').live('click',function()
    {
        var appendTxt= "<tr><td ><input class='textfield'  id='sub' name='sub[]' type='text' /></td><td><input class='textfield' style='text-align: right' id='quantity1' name='quantity1[]' type='text' onkeypress='return numbersonly(event)' />\n\
                                        . <input class='boxTK' id='quantity2' name=quantity2[]' type='text' onkeypress='return numbersonly(event)'/> TK</td>\n\
                                         <td><textarea class='textfield' type='text' id='desc' name='desc[]' ></textarea></td><td ><input class='box5' type='file' id='cost_scandoc' name='cost_scandoc' style='font-size:10px;''/></td><td ><input type='button' class='del' /></td><td><input type='button' class='add' /></td><?php
$new++;
echo $new;
?></tr>";
        $("#container_others:last").after(appendTxt);
    })

    window.onclick = function()
    {
        new JsDatePick({
            useMode: 2,
            target: "date",
            dateFormat: "%Y-%m-%d"
        });
    }
    
    function numbersonly(e)
    {   
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8)
        { //if the key isn't the backspace key (which we should allow)
            if (unicode<48||unicode>57) //if not a number
                return false //disable key press
        }
    }
</script>
<div class="column6">
    <div class="main_text_box">

        <div>
            <form method="POST" enctype="multipart/form-data" action="" id="off_form" name="off_form">
                <table class="formstyle"  style=" width: 92%;" > 
                    <tr><th colspan="2" style="text-align: center" colspan="4"><h1>অফিসের নাম</h1></th></tr>
                    <tr>
                        <td style="text-align: right"><b>তারিখঃ </b><input class="box" type="text" id="date" placeholder="Date" name="exp_date"/></td>    
                        <td style="text-align: left"><input class="btn" style =" font-size: 12px " type="submit" name="submit" id="submit" value="খুঁজুন" /></td>
                    </tr>               

                    <tr>
                        <td colspan="2">
                            <table class="formstyle" align="center" style="border: black solid 1px !important; border-collapse: collapse;">
                        <tr>
                            <td style='border-right: 1px solid #000099;border-top: 1px solid #000099;'>ক্রম</td>
                            <td style='border-right: 1px solid #000099;border-top: 1px solid #000099;'>তারিখ</td>
                            <td style='border-right: 1px solid #000099;border-top: 1px solid #000099;'>খাত</td>
                            <td style='border-right: 1px solid #000099;border-top: 1px solid #000099;'>পরিমাণ</td>
                            <td style='border-right: 1px solid #000099;border-top: 1px solid #000099;'>কমেন্ট/বর্ণনা</td>
                            <td style='border-right: 1px solid #000099;border-top: 1px solid #000099;'>স্ক্যান ডক</td>
                            <td style='border-right: 1px solid #000099;border-top: 1px solid #000099;'>অনুমোদন</td>
                        </tr>
                    </table>
                        </td>
                    </tr>

                </table>
            </form>                          
        </div>
    </div>  
</div>    
<?php
include_once 'includes/footer.php';
?>