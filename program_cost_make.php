<?php
error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/selectQueryPDO.php';

$userID = $_SESSION['userIDUser'];
$prog_ons_type = $_SESSION['loggedInOfficeType'];
$prog_ons_id = $_SESSION['loggedInOfficeID'];

$ins_progcost = $conn->prepare("INSERT INTO program_cost (fk_program_id,pc_need_amount,pc_maker_id,pc_maker_ons_id,pc_make_date,pc_status)
                                                        VALUES (?,?,?,?,NOW(),'made')");
$insert_notification = $conn->prepare("INSERT INTO notification (nfc_tablename,nfc_tableid,nfc_senderid,nfc_receiverid,nfc_message,nfc_actionurl,nfc_date,nfc_status, nfc_type, nfc_catagory) 
                                                            VALUES ('program_cost',?,?,?,?,?,NOW(),?,?,?)");

if(isset($_POST['submit']))
{
    $programID=$_POST['prgrm_id'];
    $budget=$_POST['budget'];
    // parent ons id find --------------------------------
        if($prog_ons_type == 'office') 
      {
          $sql_select_office->execute(array($prog_ons_id));
          $offrow = $sql_select_office->fetchAll();
          foreach ($offrow as $value) {
              $db_parent_id = $value['parent_id'];
               if($db_parent_id == 0)
              {
                   $sql_select_id_ons_relation->execute(array($prog_ons_type,$prog_ons_id));
                     $onsrow = $sql_select_id_ons_relation->fetchAll();
                     foreach ($onsrow as $value) {
                         $db_parent_onsID = $value['idons_relation'];
                     }
              }
                else 
                    {
                        $sql_select_id_ons_relation->execute(array($prog_ons_type,$db_parent_id));
                        $onsrow = $sql_select_id_ons_relation->fetchAll();
                        foreach ($onsrow as $value) {
                            $db_parent_onsID = $value['idons_relation'];
                    }
              }
          }    
      }

     $sql_select_id_ons_relation->execute(array($prog_ons_type,$prog_ons_id));
     $row = $sql_select_id_ons_relation->fetchAll();
     foreach ($row as $onsrow) {
         $db_onsID = $onsrow['idons_relation'];
     }
    
    $conn->beginTransaction();
    $sqlresult1 = $ins_progcost->execute(array($programID,$budget,$userID,$db_onsID));
    $progcost_id = $conn->lastInsertId();
    
       $url = "program_cost_approval.php?id=".$progcost_id;
       $status = "unread";
       $type="action";
       $nfc_catagory="official";
       $msg = "প্রোগ্রাম বাজেটের আবেদন";
       $sqlrslt3 = $insert_notification->execute(array($progcost_id,$userID,$db_parent_onsID,$msg,$url,$status,$type,$nfc_catagory));
    
    if($sqlresult1 && $sqlrslt3)
       {
           $conn->commit();
           echo "<script>alert('প্রোগ্রাম খরচের আবেদন করা হল')</script>";
       }
       else {
           $conn->rollBack();
           echo "<script>alert('দুঃখিত, প্রোগ্রাম খরচের আবেদন করা হয়নি')</script>";
       }
    
}
?>

<style type="text/css">@import "css/bush.css";</style>
<script>
    function numbersonly(e)
   {
        var unicode=e.charCode? e.charCode : e.keyCode
            if (unicode!=8)
            { //if the key isn't the backspace key (which we should allow)
                if (unicode<48||unicode>57) //if not a number
                return false //disable key press
            }
}
   function checkIt(evt) // float value-er jonno***********************
    {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode ==8 || (charCode >47 && charCode <58) || charCode==46) {
        status = "";
        return true;
    }
    status = "This field accepts numbers only.";
    return false;
}
function setProgram(progNo,progid)
{
        document.getElementById('prgrm_number').value = progNo;
        document.getElementById('prgrm_id').value = progid;
        document.getElementById('progResult').style.display = "none";
        getall(progid);
}
function beforeSubmit()
{
    if ((document.getElementById('programName').value !="0")
            && (document.getElementById('budget').value !=""))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
</script>
<script  type="text/javascript">
    function getname(type)
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
                document.getElementById('p_name').innerHTML=xmlhttp.responseText;
                
            }
        }
        xmlhttp.open("GET","includes/getPresentations.php?t="+type,true);
        xmlhttp.send();
    }
    
    function getall(val)
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
                document.getElementById('pall').innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","includes/getPresentations.php?v="+val+"&budget=1",true);
        xmlhttp.send();
    }

function getProgram(key,offid)
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
            if(key.length ==0)
                {
                   document.getElementById('progResult').style.display = "none";
               }
                else
                    {document.getElementById('progResult').style.visibility = "visible";
                document.getElementById('progResult').setAttribute('style','position:absolute;top:38%;left:62.2%;width:250px;z-index:10;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('progResult').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getPrograms.php?budgetkey="+key+"&offid="+offid,true);
        xmlhttp.send();	
}
</script>

<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="program_management.php"><b>ফিরে যান</b></a></div> 
        <div>
            <form method="POST" onsubmit="return beforeSubmit()" action="">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;">          
                    <tr><th colspan="4" style="text-align: center;">বাজেট তৈরি</th></tr>
                    <tr>
                        <td style="width: 310px;">প্রেজেন্টেশন / প্রোগ্রাম / ট্রেইনিং / ট্রাভেল এর নম্বর</td>
                        <td>:  <input class="box" type="text" id="prgrm_number" name="prgrm_number" onkeyup="getProgram(this.value,'<?php echo $prog_ons_id;?>');"/><em2> *</em2>
                            <div id="progResult"></div><input type="hidden" name="prgrm_id" id="prgrm_id"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="pall">
                        </td>
                    </tr>
                    <tr>
                        <td>প্রয়োজনীয় টাকার পরিমান</td>
                        <td>: <input  class="box" type="text" id="budget" name="budget" onkeypress=' return numbersonly(event)'  /> টাকা<em2> *</em2></td>
                    </tr>
                    <tr>                    
                        <td colspan="2" style="padding-left: 300px; padding-top: 10px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="বাজেট করুন" /></td>
                    </tr>    
                </table>
            </form>
        </div>
    </div>      
</div>
<?php include 'includes/footer.php'; ?>