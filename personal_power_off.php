<?php
error_reporting();
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

if(isset($_POST['submit']))
{
    $p_id = $_POST['empID'];
    $p_str_pagelist = $_POST['optionlist'];
    if($p_str_pagelist == "")
    {
        $p_str_pagelist = 0;
    }
    
    $p_str_accesspagelist = $_POST['accessoptionlist'];
    if($p_str_accesspagelist == "")
    {
        $p_str_accesspagelist = 0;
    }
       
    mysql_query("START TRANSACTION");
    $up_xtraaccess = mysql_query("UPDATE cfs_user SET extra_access = '$p_str_accesspagelist' WHERE idUser = $p_id");
    $up_withdrawal = mysql_query("UPDATE cfs_user SET withdrawl_access = '$p_str_pagelist' WHERE idUser = $p_id");
   
    if ($up_xtraaccess && $up_withdrawal)
    {
        mysql_query("COMMIT");
        echo "<script>alert('স্থগিতকরণ হয়েছে')</script>";
    }
        else {
            mysql_query("ROLLBACK");
            echo "<script>alert('স্থগিতকরণ হয়নি')</script>";
        }
}

if(isset($_GET['id']))
{
    $empCfsid = $_GET['id'];
    $selreslt= mysql_query("SELECT * FROM  cfs_user WHERE idUser = $empCfsid");
    $getrow = mysql_fetch_assoc($selreslt);
    $db_empname = $getrow['account_name'];
    $db_empmobile = $getrow['mobile'];
    $db_emproleid = $getrow['security_roles_idsecurityrole'];
    $db_xaccess =$getrow['extra_access'];
    $db_withdrawaccess =$getrow['withdrawl_access'];
    
    $sql_post = mysql_query("SELECT post_name FROM employee, employee_posting, post_in_ons, post
                                                WHERE idPost = Post_idPost AND idpostinons = post_in_ons_idpostinons AND Employee_idEmployee = idEmployee
                                                AND  cfs_user_idUser = $empCfsid");
    $sql_postrow = mysql_fetch_assoc($sql_post);
    $db_empposition = $sql_postrow['post_name'];
    $sql_employee = mysql_query("SELECT * FROM employee WHERE cfs_user_idUser = $empCfsid");
    $emprow = mysql_fetch_assoc($sql_employee);
    $db_paygrdid = $emprow['pay_grade_id'];
    $db_empid = $emprow['idEmployee'];
    $sql_empinfo = mysql_query("SELECT * FROM employee_information WHERE Employee_idEmployee = $db_empid");
    $empinforow = mysql_fetch_assoc($sql_empinfo);
    $db_empphoto = $empinforow['emplo_scanDoc_picture'];
}

function getOffAccess($db_withdrawaccess)
{
    $submodRslt= mysql_query("SELECT * FROM security_pages WHERE idsecuritypage IN ($db_withdrawaccess) ORDER BY page_view_name");
    while($submodrow = mysql_fetch_assoc($submodRslt))
    {
	echo  "<option value=".$submodrow['idsecuritypage'].">".$submodrow['page_view_name']."</option>";
    }
}
function getXtraPages($db_xaccess)
{
    $submodRslt= mysql_query("SELECT * FROM security_pages WHERE idsecuritypage IN ($db_xaccess) ORDER BY page_view_name");
    while($submodrow = mysql_fetch_assoc($submodRslt))
    {
	echo  "<option value=".$submodrow['idsecuritypage'].">".$submodrow['page_view_name']."</option>";
    }
}
?>
<style type="text/css"> @import "css/bush.css";</style>
<script type="text/javaScript">
function moveToRightOrLeft(side)
   {
       var listLeft= document.getElementById('selectLeft');
       var listRight=document.getElementById('selectRight');

       if(side==1) // left to right
       {
           if(listLeft.options.length==0){
               alert('সব সাবমডিউল অব্যবহৃত করা হয়ে গেছে');
               return false;
           }else{
               var selectedCountry=listLeft.options.selectedIndex;

               move(listRight,listLeft.options[selectedCountry].value,listLeft.options[selectedCountry].text);
               listLeft.remove(selectedCountry);

               if(listLeft.options.length>0){
                   listLeft.options[0].selected=true;
               }
           }
       }
       else if(side==2)// right to left
       {
           if(listRight.options.length==0){
               alert('সব সাবমডিউল ব্যবহার করা হয়ে গেছে');
               return false;
           }else{
               var selectedCountry=listRight.options.selectedIndex;

               move(listLeft,listRight.options[selectedCountry].value,listRight.options[selectedCountry].text);
               listRight.remove(selectedCountry);

               if(listRight.options.length>0){
                   listRight.options[0].selected=true;
               }
           }
       }
   }

   function move(listBoxTo,optionValue,optionDisplayText)// move function
   {
       var newOption = document.createElement("option");
       newOption.value = optionValue;
       newOption.text = optionDisplayText;
       listBoxTo.add(newOption, null);
       return true;
   }
</script>
<script type="text/javascript">
function show()
{
    var arr = new Array();
    var arr2 = new Array();
    
    var select1 = document.getElementById('selectRight');
    for(var i=0; i < select1.options.length; i++){
        arr.push(select1.options[i].value);
    }
    document.getElementById('optionlist').value = arr.toString();
    
    var select2 = document.getElementById('selectLeft');
    for(var i=0; i < select2.options.length; i++){
        arr2.push(select2.options[i].value);
    }
    document.getElementById('accessoptionlist').value = arr2.toString();
}
</script>
    <div class="main_text_box">
        <div style="padding-left: 50px;"><a href="employee_for_power_distribution.php"><b>ফিরে যান</b></a></div>
        <div>
            <form method="POST" enctype="multipart/form-data" action="">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 90%;margin-left: 50px;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 20px;">ক্ষমতা স্থগিতকরন</th></tr>
                    <tr>
                        <td>
                            <table style="margin-left: 0px !important;">
                                 <tbody>
                                    <tr>
                                        <td width="45%"><input type="hidden" name="empID" value="<?php echo $empCfsid?>" /><input type="hidden" name="xaccess" value="<?php echo $db_xaccess?>" />
                                             <fieldset style="border: #999999 solid 2px; text-align: center;">
                                                 <legend  style="color: brown;">বিকেন্দ্রীকৃত দায়িত্ব</legend>
                                                    <select name="selectLeft" size="10" id="selectLeft" style="width: 240px; overflow: auto; padding: 3px; border: 1px solid #808080">
                                                        <?php getXtraPages($db_xaccess);?>
                                                    </select>
                                             </fieldset>
                                         </td>
                                        <td width="10%" style="padding-top: 70px;text-align: center;">
                                            <input name="btnRight" type="button" id="btnRight" value="&gt;&gt;" onClick="javaScript:moveToRightOrLeft(1);"/><br/>
                                             <input name="btnLeft" type="button" id="btnLeft" value="&lt;&lt;" onClick="javaScript:moveToRightOrLeft(2);"/>                            
                                        </td>
                                        <td width="45%"><input type="hidden" name="optionlist" id="optionlist" /><input type="hidden" name="accessoptionlist" id="accessoptionlist" />
                                             <fieldset style="border:#999999 solid 2px;text-align: center;">
                                                 <legend  style="color: brown;">স্থগিতকৃত দায়িত্ব</legend>
                                                    <select name="selectRight" size="10" id="selectRight" style="width: 240px; overflow: auto; padding: 3px; border: 1px solid #808080;">
                                                       <?php  getOffAccess($db_withdrawaccess);?>
                                                   </select>
                                              </fieldset>
                                         </td>
                                     </tr>
                                 </tbody>
                            </table>     
                        </td>
                         <td width="41%"></br>
                            <table>
                                    <tr>
                                        <td width="40%" rowspan='5' style="padding-left: 0px;"> <img src="<?php echo $db_empphoto;?>" width="128px" height="128px" alt=""></td> 
                                    </tr>
                                    <tr>
                                        <td width="57%"><input type="hidden" readonly="" value="<?php echo $db_empname;?>" /><?php echo $db_empname;?></td>
                                    </tr>     
                                    <tr>
                                        <td><input type="hidden" readonly="" value="<?php echo $db_empposition;?>" /><?php echo $db_empposition;?>
                                                <input type="hidden" readonly="" id="emp_paygrade" name="emp_paygrade" value="<?php echo $db_paygrdid;?>" /></td>
                                    </tr>    
                                    <tr>
                                        <td><input type="hidden" readonly="" value="<?php echo $db_empmobile;?>" /><?php echo $db_empmobile;?>
                                                <input type="hidden" readonly="" name="empid"value="<?php echo $db_empid;?>" /></td>
                                    </tr>    
                                    </table>
                                </td>
                            </tr>
                            <tr>                    
                        <td colspan="2" style="padding-left: 250px; " ></br></br><input class="btn" style =" font-size: 12px; " type="submit" onclick="show()" name="submit" value="সেভ করুন" /></td>                           
                    </tr>    
                </table>
                </fieldset>
            </form>
        </div>           
    </div>
<?php include_once 'includes/footer.php'; ?>