<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$loginUSERname = $_SESSION['UserID'] ;

$sql = "INSERT INTO employee_attendance(emp_intime, emp_outtime, emp_worktime ,emp_extratime , date_of_atnd , emp_atnd_type , present_type ,emp_atnd_desc, emp_min_gaptime, emp_min_gapdesc, emp_maj_gaptime, emp_maj_gapdesc, atnd_making_date, month_no, year_no,emp_user_id, atnd_maker_id  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,NOW(),?,?,?,?)";
$stmt = $conn->prepare($sql);

$queryemp = mysql_query("SELECT emp_ons_id FROM employee, cfs_user WHERE cfs_user_idUser = idUser AND user_name = '$loginUSERname'");
$emprow = mysql_fetch_assoc($queryemp);
$db_onsid = $emprow['emp_ons_id'];
$queryonsr = mysql_query("SELECT * FROM ons_relation WHERE idons_relation ='$db_onsid' ;");
$onsrow = mysql_fetch_assoc($queryonsr);
$db_catagory = $onsrow['catagory'];
$db_id = $onsrow['add_ons_id'];
switch($db_catagory)
                   {
                       case 'office' : 
                           $offquery=mysql_query("SELECT * FROM office WHERE idOffice= '$db_id';");
                          $offrow = mysql_fetch_assoc($offquery);
                          $db_offname= $offrow['office_name'];
                       break;
                       
                        case 's_store' :
                            $salesquery=mysql_query("SELECT * FROM sales_store WHERE idSales_store=$db_id");
                          $salesrow = mysql_fetch_assoc($salesquery);
                            $db_offname= $salesrow['salesStore_name'];
                        break;
                   }          
if(isset($_POST['submit']))
    {
    $cfsrslt = mysql_query("SELECT * FROM cfs_user WHERE user_name = '$loginUSERname';");
    $cfsrow = mysql_fetch_assoc($cfsrslt);
    $makerid = $cfsrow['idUser'];
    $atten_date = $_POST['date'];
    $count = $_POST['count'];
    $attendance = $_POST['atten'];
    $empid = $_POST['empid'];
    $cause = $_POST['cause'];
    $intime = $_POST['intime'];
    $outtime = $_POST['outtime'];
    $min_gap = $_POST['min_gap'];
    $min_gap_des = $_POST['min_gap_des'];
    $maj_gap = $_POST['maj_gap'];
    $maj_gap_des = $_POST['maj_gap_des'];
    $worktime = $_POST['worktime'];
    $xtratime = $_POST['xtratime'];
    for($i=1;$i<$count;$i++)
    {
        $month = date("n", strtotime($atten_date));
        $year=date('Y', strtotime($atten_date));
        $atten_type = $attendance[$i];
        if($atten_type == 'yes')
        {
            $type = 'present';
        }
        elseif($atten_type == 'no')
        {
            $type = 'absent';
        }
 else { $type = 'leave';}
    $emp = $empid[$i];    
    $causes =$cause[$i];
    $in =$intime[$i];
    $out=$outtime[$i];
    $mingap = $min_gap[$i];
    $mindes=$min_gap_des[$i];
    $majgap=$maj_gap[$i];
    $majdes=$maj_gap_des[$i];
    $work=$worktime[$i];
    $xtra= $xtratime[$i];
        $yes = $stmt->execute(array($in,$out,$work,$xtra,$atten_date,$type,'overtime',$causes,$mingap,$mindes,$majgap,$majdes,$month,$year,$emp,$makerid));
    }
   
}

?>
<title>অফডে কর্মচারী হাজিরা</title>
<style type="text/css"> @import "css/bush.css";</style>

<script>
    function checkAttendance(checkvalue,i)
{
      if(checkvalue == 'yes')
        {
             document.getElementById("cause["+i+"]").disabled= false;
            document.getElementById("intime["+i+"]").disabled= false;
              document.getElementById("outtime["+i+"]").disabled= false;
              document.getElementById("min_gap["+i+"]").disabled= false;
              document.getElementById("min_gap_des["+i+"]").disabled= false;
              document.getElementById("maj_gap["+i+"]").disabled= false;
              document.getElementById("maj_gap_des["+i+"]").disabled= false;
              document.getElementById("worktime["+i+"]").disabled= false;
              document.getElementById("xtratime["+i+"]").disabled= false;
        }
        else
            {
             document.getElementById("cause["+i+"]").disabled= false;  
             document.getElementById("intime["+i+"]").disabled= true;
              document.getElementById("outtime["+i+"]").disabled= true;
              document.getElementById("min_gap["+i+"]").disabled= true;
              document.getElementById("min_gap_des["+i+"]").disabled= true;
              document.getElementById("maj_gap["+i+"]").disabled= true;
              document.getElementById("maj_gap_des["+i+"]").disabled= true;
              document.getElementById("worktime["+i+"]").disabled= true;
              document.getElementById("xtratime["+i+"]").disabled= true;
           }
}
function setWorkandXtra(major,i)
{
    var intime = document.getElementById("intime["+i+"]").value;
    var outtime = document.getElementById("outtime["+i+"]").value;
    var timeStart = new Date("01/01/1990 " + intime).getHours();
    var timeEnd = new Date("01/01/1990 " + outtime).getHours();
    var worktime= (timeEnd - timeStart) - major;
    var xtradiffer = worktime - 8;
    var xtratime = 0;
    if(xtradiffer > 0)
        {
            xtratime = xtradiffer;
        }
            document.getElementById("worktime["+i+"]").value = worktime ;
            document.getElementById("xtratime["+i+"]").value = xtratime;
}
</script>
<script>
function getdate(selecteddate,onsid) // date by date employee leave condition check ***************
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
                document.getElementById('show').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/showOffdayAttendance.php?selecteddate="+selecteddate+"&emponsid="+onsid,true);
        xmlhttp.send();	
}
</script>

<div class="column6" style="width: 100% !important;">
    <div class="main_text_box" style="width: 100% !important;">
        <div style="padding-left: 10px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
          <div>
           <form method="POST"  name="frm" action="">	
               <table  class="formstyle" style="width: 100% !important; font-family: SolaimanLipi !important;margin:0 !important;width: 98% !important;">          
                    <tr><th colspan="2" style="text-align: center;">অফডে কর্মচারী হাজিরা শিট</th></tr>
                    <tr>
                    <td colspan="2">
                        <table align="center" style="border: black solid 1px !important; border-collapse: collapse;">
                                    <thead>
                                        <tr><td colspan="13" style="color: sienna; text-align: center; font-size: 20px;"><b><?php echo $db_offname;?></b></td></tr>
                                        <tr><td colspan="13" style="color: sienna; text-align: center; font-size: 16px;">হাজিরার তারিখঃ 
                                                <input class="textfield" type="date" id="date" placeholder="Date" name="date" value="" onchange="getdate(this.value,'<?php echo $db_onsid?>')"/></td></tr>
                                        <tr>
                                            <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="2%">ক্রম</th>
                                        <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="10%">কর্মচারী অ্যাকাউন্ট নং</th>
                                        <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="14%">নাম</th>
                                        <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="7%">হাজিরার ধরন</th>
                                        <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="6%">বর্ণনা</th>
                                        <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="7%">ইন টাইম</th>
                                        <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="7%">আউট টাইম</th>
                                        <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="6%">মাইনর গ্যাপ</th>
                                        <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="6%">বর্ণনা</th>
                                        <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="6%">মেজর গ্যাপ</th>
                                        <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="6%">বর্ণনা</th>
                                        <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="7%">ওয়ার্ক টাইম</th>
                                        <th style='border-right: 1px solid #000099;border-top: 1px solid #000099;' width="7%">এক্সট্রা টাইম</th>
                                        </tr>
                                </thead>
                                <tbody style="font-size: 12px !important" id="show">
                                
                                </tbody>
                            </table>
                           </td>
                    </tr>    
                    <tr><td colspan='4' ></br><b>আজকের স্ক্যান ডকুমেন্টসঃ </b><input style ='font-size: 12px;' type='file' name='scan_doc'  /></td></tr>
                    <tr>                    
                     <td colspan='4' style='text-align: center' ></br><input class='btn' style ='font-size: 12px;' type='submit' name='submit' value='সেভ করুন' />
                         <input class='btn' style ='font-size: 12px' type='reset' name='reset' value='রিসেট করুন'  /></td>                           
                            </tr>
                    </table>
            </form>
        </div>                 
    </div>
    <?php
    include_once 'includes/footer.php';
    ?>