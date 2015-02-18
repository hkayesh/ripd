<?php
error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

if(isset($_POST['submit_ticket']))
{
    echo "<script>alert('টিকেটটি সফলভাবে তৈরি হয়েছে');
        window.open(making_ticket.php, '_blank'');
        </script>";
    //header('Location:making_ticket.php');
}

if(isset($_POST['submit']))
{
    $t_prize=$_POST['ticket_prize'];
    $seat=$_POST['number_of_seat'];
    $xtra_seat=$_POST['extra_seat'];
    $programID=$_POST['programID'];
    $programname=$_POST['programName'];
    $date=$_POST['programDate'];
    $time=$_POST['programTime'];
    $employee_name=$_POST['emp_name'];
    $employee_mail = $_POST['emp_mail'];
    $P_description = $_POST['description'];
    $P_type = $_POST['type'];
    $p_place = $_POST['place'];
    
    $pupsql = "UPDATE `program` SET `total_seat` = '$seat',`extra_seat` = '$xtra_seat', `ticket_prize` = '$t_prize', `subject`= '$P_description' WHERE `program`.`idprogram` = '$programID' ;";
    $pusresult=mysql_query($pupsql) or exit('query failed: '.mysql_error());
}
?>
<title>টিকেট মেকিং</title>
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
     function beforeSubmit(){
    if ((document.getElementById('prgrm_number').value !="")
    && (document.getElementById('ticket_prize').value !="")
    && (document.getElementById('number_of_seat').value !="")
    && (document.getElementById('extra_seat').value !=""))
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
        xmlhttp.open("GET","includes/getPresentations.php?v="+val,true);
        xmlhttp.send();
    }

function getProgram(key)
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
                document.getElementById('progResult').setAttribute('style','position:absolute;top:38%;left:61.2%;width:250px;z-index:10;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('progResult').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getPrograms.php?key="+key,true);
        xmlhttp.send();	
}
</script>
<?php
if($_GET['step']=='02')
    { $typeinbangla = getProgramType($P_type);
$whoinbangla =  getProgramer($P_type);
?>
<div class="column6">
        <div class="main_text_box">
            <div style="padding-left: 110px;"><a href="making_ticket.php"><b>ফিরে যান</b></a></div> 
            <div>
                <form method="POST" onsubmit="" >	
                    <table  class="formstyle" style="color: #3333CC; font-weight:600;font-family: SolaimanLipi !important;">          
                        <tr><th colspan="4" style="text-align: center;">টিকেট মেইকিং </th></tr>
                        <tr>
                            <td style="text-align: center;">টিকেট প্রাইজঃ <span style="color: black;"><?php echo $t_prize;?> TK /Ticket</span></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">মোট আসন সংখ্যাঃ <span style="color: black;"><?php echo $seat;?></span></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">অতিরিক্ত আসন সংখ্যাঃ <span style="color: black;"><?php echo $xtra_seat;?></span></td>
                        </tr>
                        <tr>  
                            <td colspan="2" style="padding-left: 0;">
                                <div id="front" style="width: 768px; height: 384px; border: blue dashed 2px; margin: 0 auto;background-image: url(images/watermark.png);background-repeat: no-repeat;background-size:100% 100%; ">
                                    <div id="front_left" style="width: 192px; height: 384px;border-right:blue dotted 1px; float: left;">
                                         <div style="width: 180px; float: left;padding-left: 4px;text-align: center;"><span style="font-family: SolaimanLipi;color: #3333CC;font-size: 20px;"><span style="color: black;"><?php echo $programname;?></span></span></div>
                                         <div id="entry" style="width: 180px;float:left;padding-top: 5px;text-align: center;"><span style="font-family: SolaimanLipi;color: #3333CC;font-size: 20px;">এন্ট্রি পাস</span></div>
                                          <div id="owner_info" style="width: 180px; float: left;padding-left: 4px;padding-top: 10px;">
                                            <span>স্বত্তাধিকারীর নামঃ </span></br>
                                            <span>স্বত্তাধিকারীর মোবাইল নাম্বারঃ </span></br>
                                            <span style="text-align: right;">আসন নাম্বারঃ ০০</span></br>
                                            <span>তারিখঃ <span style="color: black;"><?php echo $date;?></span></span></br><span>সময়ঃ <span style="color: black;"><?php echo $time;?></span></span>
                                            </div>
                                    </div>
                                    <div id="front_ri8" style="width: 574px; height: 384px; float: left;">
                                       <div id="logo" style="width: 80px;height: 80px;float: left;background-image: url(images/logo.png);background-repeat: no-repeat;background-size:100% 80px;"><image /></div>
                                        <div style="width: 450px;height: 80px;float: left;padding-left: 9px;">
                                            <div><span style="font-family: SolaimanLipi;color: #3333CC;font-size: 35px;">রিপড ইউনিভার্সাল</span><span style="font-family: SolaimanLipi;color: #3333CC;font-size: 20px;"> লিমিটেড</span></div>
                                            <div><span style="font-family: SolaimanLipi;color: #8A8B8C;font-size: 20px;">রিলীভ এন্ড ইমপ্রুভমেন্ট প্ল্যান অব ডেপ্রাইভড</span></div>
                                        </div>
                                       <div style="width: 570px; float: left;padding-left: 4px;text-align: center;"><span style="font-family: SolaimanLipi;color: #3333CC;font-size: 20px;"><span style="color: black;"><?php echo $programname;?></span></span></div>
                                        <div id="front_info" style="width: 570px; float: left;padding-left: 4px;">
                                            <span><?php echo $whoinbangla;?>-এর নামঃ <span style="color: black;"><?php echo $employee_name;?></span></span></br>
                                            <span><?php echo $whoinbangla;?>-এর ই-মেইলঃ <span style="color: black;"><?php echo $employee_mail;?></span></span></br>
                                            <span>স্থানঃ <span style="color: black;"><?php echo $p_place;?></span></span></br>
                                            <span>তারিখঃ <span style="color: black;"><?php echo $date;?></span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>সময়ঃ <span style="color: black;"><?php echo $time;?></span></span>
                                        </div>
                                        <div id="entry" style="width: 574px;float:left;padding-top: 5px;text-align: center;"><span style="font-family: SolaimanLipi;color: #3333CC;font-size: 20px;">এন্ট্রি পাস</span></div>
                                        <div id="owner_info" style="width: 570px; float: left;padding-left: 4px;">
                                            <span>স্বত্তাধিকারীর নামঃ </span></br>
                                            <span>স্বত্তাধিকারীর মোবাইল নাম্বারঃ </span></br>
                                            <span style="text-align: right;">আসন নাম্বারঃ ০০</span></br>
                                            </div>
                                    </div>
                                </div>
                            </td>
                        </tr>        
                        <tr>  
                            <td colspan="2" style="padding-left: 0;">
                                <div id="back" style="width: 768px; height: 384px;  border: blue dashed 2px;background-color: #fff; margin: 0 auto;">
                                    <div id="back_ri8" style="width: 574px; height: 384px; float: left;border-right: blue dotted 1px;">
                                        <div id="back_head" style="text-align: center;padding-top: 10px;">
                                        <span style="font-family: SolaimanLipi;color: #3333CC;font-size: 20px;"> কার্যবিবরণী</span>
                                        </div>
                                        <div id="back_content" style="padding: 10px;">
                                            <span style="font-family: SolaimanLipi;color: #000000;font-size: 16px;"><?php echo $P_description;?></span>
                                        </div>
                                        </div>
                                </div>
                            </td>
                        </tr>        
                        <tr>                    
                            <td colspan="2" style="padding-left: 300px; " ></br><input class="btn" style =" font-size: 12px; " type="submit" name="submit_ticket" value="ঠিক আছে" /></td>                           
                        </tr>    
                    </table>
                </form>
            </div>
        </div>      
    </div>
<?php
} else {
    ?>
<div class="column6">
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="program_management.php"><b>ফিরে যান</b></a></div> 
        <div>
            <form method="POST" onsubmit="return beforeSubmit()" action="making_ticket.php?step=02">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;">          
                    <tr><th colspan="4" style="text-align: center;">টিকেট মেইকিং</th></tr>
                    <tr>
                        <td colspan="2"><?php if($msg!=""){echo $msg; } ?></td>
                    </tr>
                    <tr>
                        <td>প্রেজেন্টেশন / প্রোগ্রাম / ট্রেইনিং / ট্রাভেল এর নম্বর</td>
                        <td>:  <input class="box" type="text" id="prgrm_number" name="prgrm_number" onkeyup="getProgram(this.value);"/><em2> *</em2>
                            <div id="progResult"></div><input type="hidden" name="prgrm_id" id="prgrm_id"/>
                        </td>
                    </tr>
<!--                    <tr>
                        <td style="width: 40%">বিষয়</td>
                        <td>: 
                            <select class="selectOption" name="type" id="type" onchange="getname(this.value)" style="width: 167px !important;">
                                <option value=" ">----টাইপ সিলেক্ট করুন-----</option>
                                <option value="presentation">প্রেজেন্টেশন</option>
                                <option value="program">প্রোগ্রাম</option>
                                <option value="training">ট্রেইনিং</option>
                                <option value="travel">ট্রাভেল</option>
                            </select>  
                        </td>      
                    </tr>         
                    <tr>
                        <td>প্রেজেন্টেশন / প্রোগ্রাম / ট্রেইনিং / ট্রাভেল এর নাম</td>
                        <td>:  <span id="p_name"></span> </td>
                    </tr>-->
                    <tr>
                        <td colspan="2" id="pall">
                        </td>
                    </tr>
                     <tr>
                        <td>কার্যবিবরণী / বিষয়বস্তু</td>
                        <td> <textarea  class="box" type="text" id="description" name="description" ></textarea></td>            
                    </tr>
                    <tr>
                        <td>টিকেট প্রাইজ</td>
                        <td>:    <input  class="box" type="text" id="ticket_prize" name="ticket_prize" onkeypress="return checkIt(event)" /><em2> *</em2> টাকা/টিকেট<em> (ইংরেজিতে লিখুন)</em></td>            
                    </tr>
                    <tr>
                        <td>আসন সংখ্যা </td>
                        <td>:    <input  class="box" type="text" id="number_of_seat" name="number_of_seat"  onkeypress=' return numbersonly(event)'  /><em2> *</em2><em> (ইংরেজিতে লিখুন)</em></td>           
                    </tr>
                    <tr>
                        <td>অতিরিক্ত আসন সংখ্যা </td>
                        <td>:    <input  class="box" type="text" id="extra_seat" name="extra_seat" onkeypress=' return numbersonly(event)'  /><em2> *</em2><em> (ইংরেজিতে লিখুন)</em></td>
                    </tr>                       
                    <tr>                    
                        <td colspan="2" style="padding-left: 300px; padding-top: 10px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" /></td>
                    </tr>    
                </table>
            </form>
        </div>
    </div>      
</div>
<?php
}
?>
<?php
include 'includes/footer.php';
?>