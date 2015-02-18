<?php
error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$userID = $_SESSION['userIDUser'];
if(isset($_POST['submit'])) 
{
    $p_programID=$_POST['pesentation_id'];
    $p_totalsalary=$_POST['totalsalary'];
    $p_salary = $_POST['salary'];
    $sl = 0;
     mysql_query("START TRANSACTION");
    $sql_up = mysql_query("UPDATE program SET payment_status='paid', total_payment=$p_totalsalary WHERE idprogram='$p_programID'");
      foreach ($_SESSION['arrPresenters'] as $key => $row) 
      { 
          $y =  mysql_query("UPDATE presenter_list SET payment='$p_salary[$sl]' WHERE fk_idprogram='$p_programID' AND fk_Employee_idEmployee=$key ");
          $sl++;
      }
    if ($sql_up && $y) {
        mysql_query("COMMIT");
        unset($_SESSION['arrPresenters']);
         echo "<script>alert('বেতন দেয়া হয়েছে')</script>";
    } else {
         mysql_query("ROLLBACK");
         echo "<script>alert('দুঃখিত,বেতন দেয়া হয়নি')</script>";
    }
}
?>
<link href="css/bush.css" rel="stylesheet" type="text/css"/>
<script  type="text/javascript">
function getList(type)
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
           document.getElementById('list').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getPrograms.php?whichtype="+type+"&what=salary",true);
        xmlhttp.send();	
}
</script>
<script>
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
function calculateSalary(i)
{
    var finalsalary = 0;
    for (var j=1;j<=document.getElementsByName('salary[]').length;j++){
        finalsalary = finalsalary + Number(document.getElementById('salary['+j+']').value);
    }
    document.getElementById('totalsalary').value = finalsalary;
}
</script>
<?php
if ($_GET['opt']=='submit') {
        $G_presentation_id = $_GET['id'];
        $db_result_edit = mysql_query("SELECT * FROM program,office WHERE idprogram =$G_presentation_id AND Office_idOffice=idOffice");
        $row_edit = mysql_fetch_array($db_result_edit);
        $db_rl_presentation_number = $row_edit['program_no'];
        $db_rl_presentation_name = $row_edit['program_name'];
        $db_rl_presentation_date = $row_edit['program_date'];
        $db_rl_presentation_time = $row_edit['program_time'];
        $db_rl_presentation_location = $row_edit['program_location'];
        $db_rl_presentation_type = $row_edit['program_type'];
        $db_rl_officeacc = $row_edit['office_name'];
        if (!isset($_SESSION['arrPresenters']))
           {
            $_SESSION['arrPresenters'] = array();
            $sel_presenters = mysql_query("SELECT * FROM presenter_list,cfs_user,employee  
                                                                WHERE fk_idprogram =$G_presentation_id AND prog_attendance='present'
                                                                AND fk_Employee_idEmployee = idEmployee AND cfs_user_idUser= idUser");
            while ($row_presenters = mysql_fetch_assoc($sel_presenters))
            {
               $db_acc = $row_presenters['account_number'];
               $db_name = $row_presenters['account_name'];
               $db_mbl = $row_presenters['mobile'];
               $db_eid = $row_presenters['idEmployee'];
               $arr_temp = array($db_acc,$db_name,$db_mbl);
               $_SESSION['arrPresenters'][$db_eid] = $arr_temp;
               }
        }
  $whoinbangla =  getProgramer($db_rl_presentation_type);
  $typeinbangla = getProgramType($db_rl_presentation_type);
    ?>
    <div class="column6">
        <div class="main_text_box">
            <div style="padding-left: 110px;"><a href="presenter_salary.php"><b>ফিরে যান</b></a></div> 
            <div> 
                <form method="POST" action="presenter_salary.php">	
                    <table  class="formstyle" style="font-family: SolaimanLipi !important;">          
                        <tr><th colspan="4" style="text-align: center;font-size: 20px;">বেতন প্রদান</th></tr>
                        <tr>
                            <td style="width:40%" ><?php echo $typeinbangla;?> নাম্বার</td>
                            <td>: <input  class="box" type="text" name="presentation_number" readonly  value="<?php echo $db_rl_presentation_number; ?>"/></td>   
                        </tr>
                        <tr>
                            <td ><?php echo $typeinbangla;?>-এর নাম</td>               
                            <td>: <input  class="box" type="text" readonly="" name="presentation_name" id="presentation_name" value="<?php echo $db_rl_presentation_name; ?>"/>
                                <input type="hidden" name="pesentation_id" value="<?php echo $G_presentation_id;?>"</td>   
                        </tr>
                        <tr>
                            <td>অফিস</td>               
                            <td colspan="3">: <input class="box" readonly="" id="off_name" name="offname" value="<?php echo $db_rl_officeacc;?>" /></td>
                        </tr>
                        <tr>
                            <td>স্থান</td>
                            <td>: <input  class="box" type="text" readonly="" id="place" name="place" value="<?php echo $db_rl_presentation_location;?>"/></td>            
                        </tr>
                        <tr>
                            <td >তারিখ</td>
                            <td>: <input class="box" type="text" readonly="" id="presentation_date" name="presentation_date" value="<?php echo $db_rl_presentation_date; ?>"/></td>
                            </td>   
                        </tr>
                        <tr>
                            <td > সময় </td>
                            <td>: <input  class="box" type="text" readonly="" name="presentation_time" id="presentation_time" value="<?php echo $db_rl_presentation_time; ?>"/></td>
                        </tr>
                        <tr>
                            <td colspan="2"> <?php echo $whoinbangla?> লিস্ট</td> 
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table cellspacing="0">
                                    <tr id="table_row_odd">
                                        <td style="border: 1px solid black;"><?php echo $whoinbangla?>-এর নাম </td>
                                        <td style="border: 1px solid black;">একাউন্ট নাম্বার</td>
                                        <td style="border: 1px solid black;">মোবাইল নাম্বার</td>
                                        <td style="border: 1px solid black;">বেতন (টাকা)</td>
                                    </tr>
                                    <?php
                                    $sl=1;
                                     foreach ($_SESSION['arrPresenters'] as $row) {
                                    echo '<tr>';
                                    echo '<td>' . $row[1] . '</td>';
                                    echo '<td>' . $row[0].'</td>';
                                    echo '<td>' .$row[2].'</td>';
                                    echo '<td><input class="box" type="text" name="salary[]" id="salary['.$sl.']" onkeypress="return checkIt(event)" style="text-align: right;" onkeyup="calculateSalary(this.value,'.$sl.')"/></td>';
                                    echo '</tr>';
                                    $sl++;
                                }
                            ?>
                                    <tr>
                                        <td colspan="4" ><hr /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: right"><b>মোটঃ</b></td>
                                        <td><input class="box" type="text" name="totalsalary" id="totalsalary" style="text-align: right;" /> টাকা</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;"><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="বেতন দিন" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>      
    </div>
<?php }
else {
    if (isset($_SESSION['arrPresenters']))
                    {
                         unset($_SESSION['arrPresenters']);
                    }
    ?>
    <div class="column6">
        <div class="main_text_box">
            <div style="padding-left: 110px;"><a href="program_management.php"><b>ফিরে যান</b></a></div> 
            <div>
                <form method="POST" onsubmit="" action="presenter_attendance.php?opt=submit">	
                    <table  class="formstyle" style="font-family: SolaimanLipi !important;">          
                        <tr><th colspan="4" style="text-align: center;font-size: 20px;">বেতন প্রদান</th></tr>
                        <tr>
                            <td style="width: 40%">প্রেজেন্টেশন / প্রোগ্রাম / ট্রেইনিং / ট্রাভেল</td>
                            <td>: <select class="selectOption" name="type" id="type" onchange="getList(this.value)" style="width: 170px !important;">
                                    <option value=" ">----টাইপ সিলেক্ট করুন-----</option>
                                    <option value="presentation">প্রেজেন্টেশন</option>
                                    <option value="program">প্রোগ্রাম</option>
                                    <option value="training">ট্রেইনিং</option>
                                    <option value="travel">ট্রাভেল</option>
                                </select></br></br>  
                            </td>      
                        </tr>
                        <tr>
                            <td colspan="2" id="list"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>      
    </div>
    <?php
}
include 'includes/footer.php';
?>