<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';

$loginUSERname = $_SESSION['UserID'];
//echo "$loginUSERname";

$queryemp = mysql_query("SELECT * FROM employee WHERE cfs_user_idUser = ANY(SELECT idUser FROM cfs_user WHERE user_name = '$loginUSERname');");
$emprow = mysql_fetch_assoc($queryemp);
$db_onsid = $emprow['emp_ons_id'];
$queryonsr = mysql_query("SELECT * FROM ons_relation WHERE idons_relation ='$db_onsid' ;");
$onsrow = mysql_fetch_assoc($queryonsr);
$db_catagory = $onsrow['catagory'];
$db_id = $onsrow['add_ons_id'];
switch ($db_catagory) {
    case 'office' :
        $offquery = mysql_query("SELECT * FROM office WHERE idOffice= '$db_id';");
        $offrow = mysql_fetch_assoc($offquery);
        $db_offname = $offrow['office_name'];
        break;

    case 's_store' :
        $salesquery = mysql_query("SELECT * FROM sales_store WHERE idSales_store=$db_id");
        $salesrow = mysql_fetch_assoc($salesquery);
        $db_offname = $salesrow['salesStore_name'];
        break;
}
$post_n_ons_id = $_GET['pionsid'];
    $post_info_query = "SELECT * FROM post_in_ons, post WHERE idpostinons='$post_n_ons_id' AND Post_idPost=idPost";
    $post_info_result = mysql_query($post_info_query);
    while($result = mysql_fetch_array($post_info_result)){
        $db_edit_idpostinons = $result['idpostinons'];
        $db_edit_number_of_post = $result['number_of_post'];
        $db_edit_free_post = $result['free_post'];
        $db_used_post = $result['used_post'];
        $db_edit_post_name = $result['post_name'];
        $db_edit_responsibility_desc = $result['responsibility_desc'];
    }
$msg ="";
if(isset($_POST['submit_edit'])) {
    //print_r($_POST);
    $edited_post_in_ons_id = $_POST['edit_idpostinons'];
    $edited_number_of_post = $_POST['post_number'];
    $edited_free_post = $_POST['free_post_number'];

    $sql_edit_post = "UPDATE post_in_ons SET number_of_post ='$edited_number_of_post', free_post = '$edited_free_post' WHERE idpostinons = '$edited_post_in_ons_id'";
    if (mysql_query($sql_edit_post)) {
            $msg = "You Have Successfully Updated Post";
        }
    else {
        $msg = "Sorry, Your Operation is Failed. Try Again";
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css"> @import "css/bush.css";</style>
<script>
    function calculateFreePost(totalPost) // for calculation instalment amount*************
{
    var number_of_userPost = document.getElementById('used_post').value;
    var total_number_of_post = totalPost;
    var number_of_free_post = total_number_of_post - number_of_userPost;
    document.getElementById('free_post_number').value = number_of_free_post;
    if(number_of_free_post<0){
        document.getElementById('submit_edit').disabled =true ;
        document.getElementById('submit_edit').style.backgroundColor = "gray" ; 
    }else{
        document.getElementById('submit_edit').disabled =false ;
        document.getElementById('submit_edit').style.backgroundColor = "#0077D5" ;
    }
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
</head>
<body>
    <form method="POST" onsubmit="" name="" action="">	
                <table  class="formstyle" style="margin: 5px 10px 15px 10px; font-family: SolaimanLipi !important;">          
                    <tr><th colspan="2" style="text-align: center;"> এডিট পোস্ট </th></tr>
                    <?php 
                    if($msg==""){
                    ?>
                    <tr>
                        <td>অফিস / সেলস স্টোর / পাওয়ার স্টোর</td>
                        <td> : <?php echo $db_offname; ?>
                            <input type="hidden" id="edit_idpostinons" name="edit_idpostinons" value="<?php echo $db_edit_idpostinons; ?>"/>       
                        </td>            
                    </tr>
                    <tr>
                        <td>পোস্ট নাম</td>
                        <td> : <?php echo $db_edit_post_name;?></td>                                  
                    </tr>                    
                    <tr>
                        <td>পোস্টের দায়িত্ব</td>
                        <td  style="padding-left: 5%;"> <textarea id='responsibility' name='responsibility' style='width: 90%;' readonly="" ><?php echo $db_edit_responsibility_desc;?></textarea></td>                                  
                    </tr>
                    <tr>
                        <td>নাম্বার অফ পোস্ট</td>
                        <td>:   <input class="box" type="text" id="post_number" name="post_number" onkeypress=' return numbersonly(event)' onkeyup="calculateFreePost(this.value)" value="<?php echo $db_edit_number_of_post;?>"/> জন</td>                                  
                    </tr>
                    <tr>
                        <td>ব্যবহৃত পোস্ট</td>
                        <td>: <input class="box" type="text" id="used_post" name="used_post" value="<?php echo $db_used_post;?>" readonly /> জন</td>                                  
                    </tr>
                    <tr>
                        <td>নাম্বার অফ ফ্রি পোস্ট</td>
                        <td>:  <input class="box" type="text" id="free_post_number" name="free_post_number" readonly="" value="<?php echo $db_edit_free_post;?>"/> জন</td>                                  
                    </tr>
                    <tr>                    
                        <td colspan="2" style="padding-left: 25%; " ><input class="btn" style =" font-size: 12px; " type="submit" id="submit_edit" name="submit_edit" value="এডিট করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>    
                    <?php
                    }else{
                   ?>
                    <tr>
                        <td colspan="2" style="text-align: center; font-size: 16px;color: green;"><?php echo $msg;?></td>          
                    </tr>
                    <?php                     
                        echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
                        echo "<!--\n";
                        echo "top.location.href = 'create_post.php';\n";
                        echo "//-->\n";
                        echo "</script>\n";
                    }?>
                </table>
            </form>
</body>
</html>


