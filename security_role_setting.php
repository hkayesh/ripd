<?php
error_reporting(0);
include_once 'includes/ConnectDB.inc';
include_once 'includes/MiscFunctions.php';
$g_roleid = $_GET['roleid'];
$role_sel = mysql_query("SELECT * FROM security_roles WHERE idsecurityrole = $g_roleid;");
$rolrow = mysql_fetch_assoc($role_sel);
$db_rolname = $rolrow['role_name'];

$msg ="";
function getUsedSubMod($id)
{
    $submodRslt= mysql_query("SELECT * FROM security_groups, securiy_submodules WHERE security_roles_idsecurityrole = $id AND security_submodules_idsecuritysubmod = idsecuritysubmod");
    while($submodrow = mysql_fetch_assoc($submodRslt))
    {
	echo  "<option value=".$submodrow['idsecuritysubmod'].">".$submodrow['submod_name']."</option>";
    }
}
function getUnusedSubMod($id)
{
    $submodRslt= mysql_query("SELECT * FROM securiy_submodules WHERE idsecuritysubmod NOT IN 
                                                (SELECT security_submodules_idsecuritysubmod FROM security_groups WHERE security_roles_idsecurityrole = $id);");
    while($submodrow = mysql_fetch_assoc($submodRslt))
    {
	echo  "<option value=".$submodrow['idsecuritysubmod'].">".$submodrow['submod_name']."</option>";
    }
}
if(isset($_POST['update']))
{
    $p_str_submodlist = $_POST['optionlist'];
    $arr_submodlist = explode(',', $p_str_submodlist);
    $p_id = $_POST['roleID'];
    
    $delquery = mysql_query("DELETE FROM security_groups WHERE security_roles_idsecurityrole = $p_id");
    for($i=0;$i<count($arr_submodlist);$i++) {
        $value= $arr_submodlist[$i];
        $upquery = mysql_query("INSERT INTO security_groups (security_roles_idsecurityrole, security_submodules_idsecuritysubmod) VALUES ($p_id,$value);");
    }    
    if ($upquery ==1)
	{$msg = "আপডেট হয়েছে"; }
        else { $msg ="আপডেট হয়নি"; }
}

?>
<script>
function out()
    {
        setTimeout(function(){parent.location.href=parent.location.href;},1000);
    }
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
var select1 = document.getElementById('selectLeft');

for(var i=0; i < select1.options.length; i++){
    arr.push(select1.options[i].value);
}
document.getElementById('optionlist').value = arr.toString();
}
</script>
</head>
<body>
                <form method="POST"  action="">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;margin: 0 !important;">          
                    <tr><th colspan="2" style="text-align: center;">রোল সেটিং</th></tr>
                    <?php if($msg == "") {?>
                    <tr>
                    <td style="text-align: center; width: 50%;">রোল নাম</td>
                    <td>: <?php echo $db_rolname;?><input type="hidden" name="roleID" value="<?php echo $g_roleid;?>" />
                        <input type="hidden" name="optionlist" id="optionlist" /></td>   
                    </tr>
                     <tr>
                         <td colspan="2">
                             <table style="border: black solid 1px;">
                                 <thead>
                                     <th colspan="3" style="background-image: none!important; background-color: #cccccc">সেট সাবমডিউল</th>
                                 </thead>
                                 <tbody>
                                    <tr>
                                        <td width="45%">
                                             <fieldset style="border: #999999 solid 2px; text-align: center;">
                                                 <legend  style="color: brown;">ব্যবহৃত সাবমডিউল</legend>
                                                    <select name="selectLeft" size="10" id="selectLeft" style="width: 240px; overflow: auto; padding: 3px; border: 1px solid #808080">
                                                        <?php getUsedSubMod($g_roleid);?>
                                                    </select>
                                             </fieldset>
                                         </td>
                                        <td width="10%" style="padding-top: 70px;text-align: center;">
                                             <input name="btnLeft" type="button" id="btnLeft" value="&lt;&lt;" onClick="javaScript:moveToRightOrLeft(2);"/></br>
                                             <input name="btnRight" type="button" id="btnRight" value="&gt;&gt;" onClick="javaScript:moveToRightOrLeft(1);"/>
                                        </td>
                                        <td width="45%">
                                             <fieldset style="border:#999999 solid 2px;text-align: center;">
                                                 <legend  style="color: brown;">অব্যবহৃত সাবমডিউল</legend>
                                                    <select name="selectRight" size="10" id="selectRight" style="width: 240px; overflow: auto; padding: 3px; border: 1px solid #808080;">
                                                       <?php getUnusedSubMod($g_roleid);?>
                                                   </select>
                                              </fieldset>
                                         </td>
                                     </tr>
                                 </tbody>
                             </table>
                         </td>  
                    </tr>
                    <tr>                    
                        <td colspan="2" style="padding-left: 150px; " ></br><input class="btn" style =" font-size: 12px; " type="submit" id="update" onclick="show()" name="update" value="আপডেট করুন" /></td>                           
                    </tr>
                    <?php }    
                    else { ?>
                    <tr>
                        <td colspan="2" style="text-align: center; font-size: 16px;color: green;"><?php echo $msg;  echo "<script>out();</script>";?></td>          
                    </tr><?php }?>
                </table>
              </form>
</body>
</html>