<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$loginUSERname = $_SESSION['UserID'];
$db_id = $_SESSION['loggedInOfficeID'];
$db_catagory= $_SESSION['loggedInOfficeType'] ;
$db_offname = $_SESSION['loggedInOfficeName'];
//$queryemp = mysql_query("SELECT * FROM employee WHERE cfs_user_idUser = ANY(SELECT idUser FROM cfs_user WHERE user_name = '$loginUSERname');");
//$emprow = mysql_fetch_assoc($queryemp);
//$db_onsid = $emprow['emp_ons_id'];
//$queryonsr = mysql_query("SELECT * FROM ons_relation WHERE idons_relation ='$db_onsid' ;");
//$onsrow = mysql_fetch_assoc($queryonsr);
//$db_catagory = $onsrow['catagory'];
//$db_id = $onsrow['add_ons_id'];
//switch ($db_catagory) {
//    case 'office' :
//        $offquery = mysql_query("SELECT * FROM office WHERE idOffice= '$db_id';");
//        $offrow = mysql_fetch_assoc($offquery);
//        $db_offname = $offrow['office_name'];
//        break;
//
//    case 's_store' :
//        $salesquery = mysql_query("SELECT * FROM sales_store WHERE idSales_store=$db_id");
//        $salesrow = mysql_fetch_assoc($salesquery);
//        $db_offname = $salesrow['salesStore_name'];
//        break;
//}
$msg ="";
if (isset($_POST['submit_post'])) {
    //print_r($_POST);
    $inserted_ons_catagory = $_POST['ons_type'];
    $inserted_ons_id = $_POST['ons_id'];
    $selected_post_id = $_POST['post_id'];
    $inserted_post_number = $_POST['post_number'];
    
    if($selected_post_id>0){
        $sql_insert_post_number = "INSERT INTO post_in_ons (number_of_post, free_post, post_onstype, used_post, post_onsid, Post_idPost) 
                Values('$inserted_post_number', '$inserted_post_number', '$inserted_ons_catagory', '', '$inserted_ons_id', '$selected_post_id')";
    if (mysql_query($sql_insert_post_number)) {
        $msg = "You Have Successfully Created Post and Post Number";
    } else {
        $msg = "Sorry, Your Operation is Failed. Plaese Try Again";
    }
    }elseif ($selected_post_id=="new_post") {
        
    $inserted_post_name = $_POST['post_name'];
    $inserted_post_responsibility = $_POST['responsibility'];
    $sql_insert_post = "INSERT INTO post (post_name, responsibility_desc) values('$inserted_post_name', '$inserted_post_responsibility')";
    if (mysql_query($sql_insert_post)) {
       // echo "I am successful";
        $inserted_post_id = mysql_insert_id();
        //echo $inserted_post_id . " ------";
        $sql_insert_post_number = "INSERT INTO post_in_ons (number_of_post, free_post, post_onstype, used_post, post_onsid, Post_idPost) 
                Values('$inserted_post_number', '$inserted_post_number', '$inserted_ons_catagory', '', '$inserted_ons_id', '$inserted_post_id')";
        if (mysql_query($sql_insert_post_number)) {
            $msg = "You Have Successfully Created Post '".$inserted_post_name."' and Post Number";
        }
    } else {
        $msg = "Sorry, Your Operation is Failed. Please Try Again";
    }
    }
    
} 
?>
<title>ক্রিয়েট পোস্ট</title>
<style type="text/css"> @import "css/bush.css";</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" media="screen" charset="utf-8"/>
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script language="JavaScript" type="text/javascript" src="javascripts/postsearch.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<script type="text/javascript">
 function update(id)
	{ TINY.box.show({iframe:'editPost.php?pionsid='+id,width:500,height:280,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
 </script>
<script>
    function showResponsibility(postid)
    {
            if(window.XMLHttpRequest){
                xmlhttp = new XMLHttpRequest();
            }
            xmlhttp.onreadystatechange=function(){
                if(xmlhttp.readyState==4 && xmlhttp.status==200){
                    document.getElementById("post_and_responsibility").innerHTML=xmlhttp.responseText;
                }
            }		
            xmlhttp.open("GET","includes/showResponsibility.php?post_id="+postid,true);
            xmlhttp.send();
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
function beforeSubmit()
{
    if ((document.getElementById('post_number').value !="") 
        && (document.getElementById('post_id').value != "0"))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>  
<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
        <div class="domtab" style="font-family: SolaimanLipi !important;">
            <ul class="domtabs">
                <li class="current"><a href="#01">পোস্ট লিস্ট</a></li>
                <li class="current"><a href="#02" style="width: 200px !important">ক্রিয়েট পোস্ট এন্ড পোস্ট সংখ্যা</a></li> 
            </ul>
        </div> 

         <div>
            <h2><a name="01" id="01"></a></h2><br/>
            <form method="POST" onsubmit="" name="frm" action="">	
                <table  class="formstyle">          
                    <tr><th colspan="2" style="text-align: center;">ভিউ পোস্ট</th></tr>
                    <tr><td colspan="2" style="text-align: center;font-size: 16px;color: green;"><?php if($msg!=""){echo $msg;}?></td></tr>
                    <td colspan="6">
                        <span id="office2">
                            <table  style="border: black solid 1px;" align="center" width= 90%" cellpadding="1px" cellspacing="1px">
                                <thead>
                                    <tr><td colspan="5" style="color: sienna; text-align: center; font-size: 20px;"><?php echo $db_offname; ?></td></tr>
                                    <tr style="border: black solid 1px;">
                                        <th style="width: 10%">পোস্ট</th>
                                        <th style="width: 10%">পোস্টের সংখ্যা</th>
                                        <th style="width: 10%">খালি পোস্টের সংখ্যা</th>
                                        <th style="width: 55%">দায়িত্ব</th>
                                        <th style="width: 15%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_select_post_in_ons = "SELECT * FROM post, post_in_ons where post_onstype='$db_catagory' And post_onsid='$db_id' AND Post_idPost = idPost";
//$db_slNo = 0;
                                    $selected_post_in_ons = mysql_query($sql_select_post_in_ons);

                                    while ($rows_post_in_ons = mysql_fetch_array($selected_post_in_ons)) {
                                        $db_selected_post_name = $rows_post_in_ons['post_name'];
                                        $db_selected_post_number = $rows_post_in_ons['number_of_post'];
                                        $db_selected_post_responsibility = $rows_post_in_ons['responsibility_desc'];
                                        $db_post_in_ons_id = $rows_post_in_ons['idpostinons'];
                                        $db_post_avail = $rows_post_in_ons['free_post'];
                                        echo "<tr style='border: black solid 1px;'>";
                                        echo "<td>$db_selected_post_name</td>";
                                        echo "<td style='text-align:center;'>$db_selected_post_number</td>";
                                         echo "<td style='text-align:center;'>$db_post_avail</td>";
                                        echo "<td>$db_selected_post_responsibility</td>";                  
                                        echo "<td><a onclick='update($db_post_in_ons_id)' style='cursor:pointer;color:blue;'><u>এডিট করুন</u></a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </span>  
                    </td>
                    </tr>    
                </table>
            </form>
        </div> 
    </div>
    
        <div>
            <h2><a name="02" id="02"></a></h2><br/>
            <form method="POST" action="" onsubmit="return beforeSubmit()">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;">          
                    <tr><th colspan="2" style="text-align: center;"> সিলেক্ট পোস্ট এন্ড পোস্ট সংখ্যা </th></tr>
                    <tr>
                        <td>অফিস / সেলস স্টোর / পাওয়ার স্টোর</td>
                        <td>: 
                            <input class="box" type="text" style="width: 210px;" id="ons_name" name="ons_name" value="<?php echo $db_offname; ?>" readonly=""/>
                            <input type="hidden" id="ons_id" name="ons_id" value="<?php echo $db_id; ?>"/>
                            <input type="hidden" id="ons_type" name="ons_type" value="<?php echo $db_catagory; ?>"/>                            
                        </td>            
                    </tr>
                    <tr>
                        <td>সিলেক্ট পোস্ট নাম</td>
                        <td>:  <select class="box" type="text" id="post_id" name="post_id" onchange="showResponsibility(this.value)" />
                        <option value="0" selected="selected">-সিলেক্ট পোস্ট-</option>
                        <option value="new_post">নতুন পোস্ট</option>
                    <?php
                    $post_sql = mysql_query("SELECT * FROM post Where idPost NOT IN (SELECT Post_idPost From post_in_ons where post_onstype='$db_catagory' And post_onsid='$db_id') ORDER BY post_name ASC");
                    while ($post_rows = mysql_fetch_array($post_sql)) {
                        $db_post_id = $post_rows['idPost'];
                        $db_post_name = $post_rows['post_name'];
                        echo'<option style="width: 96%" value=' . $db_post_id . '>' . $db_post_name . '</option>';
                    }
                    ?>
                    </select><em2> *</em2></td>                                  
                    </tr>           
                    <tr><td colspan="2"><table id="post_and_responsibility" style="font-family: SolaimanLipi !important;width: 100%; margin-top: 0px;margin-bottom: 0px;margin-left: 0px;margin-right: 0px;border:0px solid grey; color: black;"></table></td></tr>
                    <tr>
                        <td>নাম্বার অফ পোস্ট</td>
                        <td>:   <input class="box" type="text" id="post_number" name="post_number" onkeypress=' return numbersonly(event)' /> জন <em2> *</em2></td>                                  
                    </tr>
                    <tr>                    
                        <td colspan="2" style="padding-left: 250px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit_post" readonly="" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>
             
</div>
<?php
include_once 'includes/footer.php';
?>