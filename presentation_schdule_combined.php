<?php
//error_reporting(0);
include 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$type=$_GET['type'];
$typeinbangla = getProgramType($type);
$whoinbangla =  getProgramer($type);
$whoType = getProgramerType($type);

$sql_cfs_emp_sel = $conn->prepare("SELECT idEmployee FROM cfs_user, employee WHERE cfs_user_idUser = idUser AND account_number= ?");
$sql_program_ins = $conn->prepare("INSERT INTO program (program_no, program_name, program_location, program_date, program_time, program_type, Office_idOffice) 
              VALUES (?, ?, ?, ?, ?, ?, ?)");
 $sql_presenterlist_ins = $conn->prepare("INSERT INTO presenter_list (fk_idprogram, fk_Employee_idEmployee) VALUES (?, ?)");

if (($_POST['new_submit'])) {
    $P_prstn_name = $_POST['presentation_name'];
    $P_prstn_date = $_POST['presentation_date'];
    $P_prstn_location = $_POST['place'];
     $str_random_no=(string)mt_rand (0 ,9999 );
     $str_program_random= str_pad($str_random_no,4, "0", STR_PAD_LEFT);
    $prstn_number_final = $type."-".$str_program_random;
    $P_prstn_time = $_POST['presentation_time'];
    $P_officeID = $_POST['parent_id'];

    $conn->beginTransaction();
        $y1 = $sql_program_ins->execute(array($prstn_number_final,$P_prstn_name,$P_prstn_location, $P_prstn_date, $P_prstn_time, $type, $P_officeID ));
        $db_last_insert_id = $conn->lastInsertId();
       foreach ($_SESSION['arrPresenters'] as $key => $row) 
      {
          $y = $sql_presenterlist_ins->execute(array($db_last_insert_id,$key));
      }
    if ($y1 && $y) {
        $conn->commit();
         unset($_SESSION['arrPresenters']);
         unset($_SESSION['arrProgram']);
        $msg = "<font style='color:green'>তথ্য সংরক্ষিত হয়েছে</font>";
    } else {
        $conn->rollBack();
        $msg = "<font style='color:red''>ভুল হয়েছে</font>";
    }
}
//###################UPDATE QUERY#######################
elseif (isset($_POST['submit1'])) {
    $P_prstn_id = $_POST['pesentation_id'];
    $P_prstn_unumber = $_POST['presentation_number'];
    $P_prstn_uname = $_POST['presentation_name'];
    $P_prstn_location = $_POST['place'];
    $P_prstn_udate = $_POST['presentation_date'];
    $P_prstn_utime = $_POST['presentation_time'];
    $P_officeID = $_POST['parent_id'];
    mysql_query("START TRANSACTION");
    $sql_up = mysql_query("UPDATE program 
                                 SET program_name='$P_prstn_uname', program_date='$P_prstn_udate', 
                                 program_time='$P_prstn_utime' ,program_location= '$P_prstn_location', Office_idOffice='$P_officeID'
                                 WHERE program_no='$P_prstn_unumber'");
    $del_prsnterlist = mysql_query("DELETE FROM presenter_list WHERE fk_idprogram='$P_prstn_id' ");
      foreach ($_SESSION['arrPresenters'] as $key => $row) 
      { 
          $y =  mysql_query("INSERT INTO presenter_list (fk_idprogram, fk_Employee_idEmployee) VALUES ($P_prstn_id, $key)");
      }
    if ($sql_up && $del_prsnterlist && $y) {
        mysql_query("COMMIT");
        unset($_SESSION['arrPresenters']);
        unset($_SESSION['arrProgram']);
        $msgi = "<font style='color:green'>তথ্য সংরক্ষিত হয়েছে</font>";
    } else {
         mysql_query("ROLLBACK");
        $msgi = "<font style='color:red'>ভুল হয়েছে</font>";
    }
}
?>
<title><?php echo $typeinbangla;?> শিডিউল</title>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="javascripts/jquery.js"></script>
<script type="text/javascript" src="javascripts/jquery.autocomplete.js"></script>
<script type="text/javascript" src="javascripts/area.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css"/>
<style type="text/css">@import "css/bush.css";</style>
<script type="text/javascript">
function setOffice(office,offid)
{
        document.getElementById('off_name').value = office;
        document.getElementById('parent_id').value = offid;
        document.getElementById('parentResult').style.display = "none";
        setLocation(offid);
}
function beforeSave()
    {
        if (document.getElementById('presenters').value != "")
        {
            document.getElementById('submit1').readonly = false;
            return true;
        }
        else {
            document.getElementById('submit1').readonly = true;
            return false;
        }
    }
</script>
<script>
function getOffice(str_key) // for searching parent offices
{
    var xmlhttp;
       if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if(str_key.length ==0)
                {
                   document.getElementById('parentResult').style.display = "none";
               }
                else
                    {   document.getElementById('parentResult').style.visibility = "visible";
                        document.getElementById('parentResult').setAttribute('style','position:absolute;top:41%;left:65.5%;width:250px;z-index:10;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
                    }
                document.getElementById('parentResult').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getParentOffices.php?search="+str_key+"&alloffice=1",true);
        xmlhttp.send();	
}
function getPresenters(key,type) // for searching presenters
{
    var xmlhttp;
       if (window.XMLHttpRequest)
        {
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
                   document.getElementById('presenterList').style.visibility = "hidden";
               }
                else
                    {document.getElementById('presenterList').style.visibility = "visible";
                    }
                document.getElementById('presenterList').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getParentOffices.php?key="+key+"&type="+type,true);
        xmlhttp.send();	
}

function setLocation(offid)
{     
       var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                document.getElementById('place').value=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getParentOffices.php?office="+offid,true);
        xmlhttp.send();
}
    function infoFromThana()
    {
        var type = '<?php echo $whoType;?>';
        var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                document.getElementById('plist').innerHTML=xmlhttp.responseText;
        }
        var division_id, district_id, thana_id;
        division_id = document.getElementById('division_id').value;
        district_id = document.getElementById('district_id').value;
        thana_id = document.getElementById('thana_id').value;
        xmlhttp.open("GET","includes/updatePresentersFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id+"&type="+type,true);
        xmlhttp.send();
    }
    
     function beforeSubmit(countrow){
    if ((document.getElementById('presentation_name').value !="")
    && (document.getElementById('off_name').value !="")
    && (countrow !="0")
    && (document.getElementById('place').value !="")
    && (document.getElementById('presentation_date').value !="")
    && (document.getElementById('presentation_time').value !=""))
        { return true; }
    else {
        alert("ফর্মের * বক্সগুলো সঠিকভাবে পূরণ করুন");
        return false; 
    }
}
function addToList(acc,name,mbl,eID) // to add into temporary array*******************
{
    
    var parentid = document.getElementById("parent_id").value;
    var pname = document.getElementById("presentation_name").value;
    var offname = document.getElementById("off_name").value;
    var place = document.getElementById("place").value;
    var pdate = document.getElementById("presentation_date").value;
    var ptime = document.getElementById("presentation_time").value;
    var xmlhttp;
        if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest();}
        else  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {  
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                  {
                     location.reload();
                  }
        }
        xmlhttp.open("GET","includes/getParentOffices.php?acc="+acc+"&name="+name+"&mbl="+mbl+"&eID="+eID+"&parentid="+parentid+"&pname="+pname+"&offname="+offname+"&place="+place+"&pdate="+pdate+"&ptime="+ptime, true);
        xmlhttp.send();
}
</script>
<!--*********************Presentation List****************** -->
<?php
if ($_GET['action'] == 'first') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="program_management.php"><b>ফিরে যান</b></a></div>
        <div style="padding-left: 70px;width: 30%;float: left;"><a href="presentation_schdule_combined.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?> লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a></div>
    </div>
    <div>
        <form method="POST" onsubmit="">	
            <table  class="formstyle" style =" width:85%" id="make_presentation_fillter" cellspacing="0">      
                <thead>
                    <tr>
                        <th colspan="8" ><?php echo $typeinbangla;?> সিডিউল</th>                        
                    </tr>          
                    <tr>
                        <td colspan="8" style="text-align: right"><b>খুঁজুন: </b><input type="text" class="box" id="search_filter" /></td>
                    </tr>
                    <tr id = "table_row_odd">
                        <td style="border-bottom: 1px solid black;"><b><?php echo $typeinbangla;?> নাম্বার</b></td>
                        <td style="border-bottom: 1px solid black;"><b><?php echo $typeinbangla;?> নাম</b></td>
                        <td style="border-bottom: 1px solid black;"><b><?php echo $whoinbangla?>-এর নাম</b></td>
                        <td style="border-bottom: 1px solid black;"><b>রিপড ই মেইল</b></td>
                        <td style="border-bottom: 1px solid black;"><b>তারিখ</b></td>
                        <td style="border-bottom: 1px solid black;"><b>বার</b></td>
                        <td style="border-bottom: 1px solid black;"><b>সময় </b></td>     
                        <td style="border-bottom: 1px solid black;"><b>অপশন</b></td>
                    </tr>
                </thead>
                <tbody> 
                    <?php
                     if (isset($_SESSION['arrPresenters']))
                    {
                         unset($_SESSION['arrPresenters']);
                    }
                    $db_result_presenter_name = mysql_query("SELECT * FROM program WHERE program_type = '$type' AND program_date >= NOW() ORDER BY program_date ");
                    while ($row_prstn = mysql_fetch_array($db_result_presenter_name)) {
                        $str_presenter_list = "";
                        $str_presenter_email_list = "";
                        $db_programID = $row_prstn['idprogram'];
                        $db_rl_prstn_number = $row_prstn['program_no'];
                        $db_rl_prstn_name = $row_prstn['program_name'];
                        $db_rl_prstn_date = $row_prstn['program_date'];
                        $db_rl_prstn_time = $row_prstn['program_time'];
                        $sql_prsntr_list = mysql_query("SELECT * FROM presenter_list, employee, cfs_user 
                                                                             WHERE idUser=cfs_user_idUser AND idEmployee= fk_Employee_idEmployee AND fk_idprogram=$db_programID ");
                         while ($row_prsnter = mysql_fetch_array($sql_prsntr_list)) {
                             $str_presenter_list = $row_prsnter['account_name'].",\n".$str_presenter_list;
                             $str_presenter_email_list = $row_prsnter['email'].",\n".$str_presenter_email_list;
                         }
                        ?>
                        <tr>
                            <td style="border-bottom: 1px solid black;"><?php echo $db_rl_prstn_number; ?></td>
                            <td style="border-bottom: 1px solid black;"><?php echo $db_rl_prstn_name; ?></td>
                            <td style="border-bottom: 1px solid black;"><?php echo $str_presenter_list; ?></td>
                            <td style="border-bottom: 1px solid black;"><?php echo $str_presenter_email_list; ?></td>
                            <td style="padding-left: 2px;border-bottom: 1px solid black;"><?php echo english2bangla(date("d/m/Y",  strtotime($db_rl_prstn_date))); ?></td>
                            <td style="border-bottom: 1px solid black;">
                                <?php
                                $timestamp = strtotime($db_rl_prstn_date);
                                $day = date('D', $timestamp);
                                if ($day == 'Wed') {
                                    echo "বুধ";
                                } elseif ($day == 'Thu') {
                                    echo "বৃহস্পতি";
                                } elseif ($day == 'Fri') {
                                    echo "শুক্র";
                                } elseif ($day == 'Sat') {
                                    echo "শনি";
                                } elseif ($day == 'Sun') {
                                    echo "রবি";
                                } elseif ($day == 'Mon') {
                                    echo "সোম";
                                } elseif ($day == 'Tue') {
                                    echo "মঙ্গল";
                                }
                                ?>
                            </td>
                            <td style="border-bottom: 1px solid black;"><?php echo english2bangla(date('g:i a' , strtotime($db_rl_prstn_time))); ?></td>
                            <td style="text-align: center;border-bottom: 1px solid black;" > <a href="presentation_schdule_combined.php?action=edit&id=<?php echo $db_programID; ?>&type=<?php echo $type;?>"> এডিট সিডিউল </a></td>  
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        var filter = new DG.Filter({
            filterField : $('search_filter'),
            filterEl : $('make_presentation_fillter'),
            colIndexes : [1,2]
        }); 
    </script>
    <!--******************Make Presentation************** -->
    <?php
} else if ($_GET['action'] == 'new') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="program_management.php"><b>ফিরে যান</b></a></div>
        <div> <a href="presentation_schdule_combined.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?>লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a></div>
    </div>

    <div>
        <form method="POST" autocomplete="off" aciton="presentation_schdule_combined.php?action=first" onsubmit="return beforeSubmit('<?php echo count($_SESSION['arrPresenters'])?>')">
            <table class="formstyle" style =" width:78%">
                <tr>
                    <th colspan="5">  মেইক <?php echo $typeinbangla;?></th>
                </tr>
                <?php
                    if ($msg != "") {
                         echo "<tr>
                         <td colspan='2' style='text-align: center;font-size:16px;'>$msg </td>
                     </tr>";
                     }
                ?>
                <?php
//                    if (isset($_SESSION['arrPresenters']))
//                       {
//                            unset($_SESSION['arrPresenters']);
//                       }
                   foreach ($_SESSION['arrProgram'] as $value) {
                       $pname = $value[0];
                       $offid = $value[1];
                       $offname = $value[2];
                       $place = $value[3];
                       $pdate = $value[4];
                       $ptime = $value[5];
                   }
                ?>
                <tr>
                    <td ><?php echo $typeinbangla;?>-এর নাম</td>               
                    <td colspan="3">: <input  class="box" type="text" name="presentation_name" id="presentation_name" value="<?php echo $pname;?>" /><em2> *</em2></td>   
                </tr>      
                <tr>
                    <td>অফিস</td>               
                    <td colspan="3">: <input class="box" id="off_name" name="offname" onkeyup="getOffice(this.value);" value="<?php echo $offname;?>" /><em2> *</em2><em> (অ্যাকাউন্ট নাম্বার)</em>
                       <div id="parentResult"></div><input type="hidden" name="parent_id" id="parent_id"value="<?php echo $offid;?>" />
                    </td>
                </tr>
                <tr>
                    <td>স্থান</td>
                    <td colspan="3">: <input  class="box" type="text" id="place" name="place" value="<?php echo $place;?>"/><em2> *</em2></td>            
                </tr>
                <tr>
                    <td >তারিখ </td>
                    <td colspan="3">: <input class="box"type="date" id="presentation_date" name="presentation_date" value="<?php echo $pdate;?>"/><em2> *</em2></td>   
                    </td>   
                </tr>
                <tr>
                    <td> সময় </td>
                    <td colspan="3">: <input  class="box" type="time" id="presentation_time" name="presentation_time" value="<?php echo $ptime;?>"/><em2> *</em2></td>  
                </tr>
                <tr>
                    <td> <?php echo $whoinbangla?> সিলেক্ট করুন</td>
                    <td colspan="3">: 
                        <input  class="box" type="text" id="preserters" name="preserters" onkeyup="getPresenters(this.value,'<?php echo $whoType ?>');" /><em2> *</em2><em> (অ্যাকাউন্ট নাম্বার)</em>
                        <div id="presenterList" style="position:absolute;top:58%;left:65.5%;width:250px;z-index:10;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;visibility: hidden"></div>
                    </td>  
                </tr>
                <tr>
                    <td colspan="2">
                        <table cellspacing="0">
                            <tr id="table_row_odd">
                                <td style="border: 1px solid black;"><?php echo $whoinbangla?>-এর নাম </td>
                                <td style="border: 1px solid black;">একাউন্ট নাম্বার</td>
                                <td style="border: 1px solid black;">মোবাইল নাম্বার</td>
                                <td style="border: 1px solid black;"></td>
                            </tr>
                            <?php
                            $url= urlencode($_SERVER['REQUEST_URI']);
                             foreach ($_SESSION['arrPresenters'] as $key => $row) {
                            echo '<tr>';
                            echo '<td >' . $row[1] . '</td>';
                            echo '<td>' . $row[0].'</td>';
                            echo '<td>' .$row[2].'</td>';
                            echo '<td style="text-align:center"><a href="includes/getParentOffices.php?delete=1&id='.$key.'&url='.$url.'"><img src="images/del.png" style="cursor:pointer;" width="20px" height="20px" /></a></td>';
                            echo '</tr>';
                        }
                    ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"></br><input type="submit" class="btn" name="new_submit" value="সেভ" >
                        &nbsp;
                        <input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--***************Edit Schedule****************** -->
    <?php
} elseif ($_GET['action'] == 'edit') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="presentation_schdule_combined.php?action=first&type=<?php echo $type;?>">ফিরে যান</b></a></div>
        <div > <a href="presentation_schdule_combined.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?> লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a></div>
    </div>
    <div>
        <!--PHP coding for SHOWING THE DATA IN EDIT SCHEDULE -->     
        <?php
        $G_presentation_id = $_GET['id'];
        $db_result_edit = mysql_query("SELECT * FROM program,office WHERE idprogram =$G_presentation_id AND Office_idOffice=idOffice");
        $row_edit = mysql_fetch_array($db_result_edit);
        $db_rl_presentation_number = $row_edit['program_no'];
        $db_rl_presentation_name = $row_edit['program_name'];
        $db_rl_presentation_date = $row_edit['program_date'];
        $db_rl_presentation_time = $row_edit['program_time'];
        $db_rl_presentation_location = $row_edit['program_location'];
        $db_rl_officeacc = $row_edit['account_number'];
        $db_rl_officeID = $row_edit['idOffice'];
        if (!isset($_SESSION['arrPresenters']))
           {
            $_SESSION['arrPresenters'] = array();
            $sel_presenters = mysql_query("SELECT * FROM presenter_list,cfs_user,employee  
                                                                WHERE fk_idprogram =$G_presentation_id 
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
        ?>
        <form method="POST" action=""> <!--Redirect from one page to another -->
            <table class="formstyle" style =" width:78%" id="presentation_fillter">       
                <tr>
                    <th colspan="5">  এডিট সিডিউল </th>
                </tr>
              <?php
                if ($msgi != "") {
                    echo "<tr>
                    <td colspan='2' style='text-align: center;font-size:16px;'>$msgi</font> 
                </tr>";
                }
                ?>
                <tr>
                    <td style="width:40%" ><?php echo $typeinbangla;?> নাম্বার</td>
                    <td>: <input  class="box" type="text" name="presentation_number" readonly  value="<?php echo $db_rl_presentation_number; ?>"/></td>   
                </tr>
                <tr>
                    <td ><?php echo $typeinbangla;?>-এর নাম</td>               
                    <td>: <input  class="box" type="text" name="presentation_name" id="presentation_name" value="<?php echo $db_rl_presentation_name; ?>"/>
                        <input type="hidden" name="pesentation_id" value="<?php echo $G_presentation_id;?>"</td>   
                </tr>
                <tr>
                    <td>অফিস</td>               
                    <td colspan="3">: <input class="box" id="off_name" name="offname" onkeyup="getOffice(this.value);" value="<?php echo $db_rl_officeacc;?>" /><em2> *</em2><em> (অ্যাকাউন্ট নাম্বার)</em>
                       <div id="parentResult"></div><input type="hidden" name="parent_id" id="parent_id"value="<?php echo $db_rl_officeID;?>" />
                    </td>
                </tr>
                <tr>
                    <td>স্থান</td>
                    <td>: <input  class="box" type="text" id="place" name="place" value="<?php echo $db_rl_presentation_location;?>"/></td>            
                </tr>
                <tr>
                    <td >তারিখ</td>
                    <td>: <input class="box" type="date" id="presentation_date" name="presentation_date" value="<?php echo $db_rl_presentation_date; ?>"/></td>
                    </td>   
                </tr>
                <tr>
                    <td > সময় </td>
                    <td>: <input  class="box" type="time" name="presentation_time" id="presentation_time" value="<?php echo $db_rl_presentation_time; ?>"/></td>
                </tr>
                <tr>
                    <td> <?php echo $whoinbangla?> সিলেক্ট করুন</td>
                    <td colspan="3">: <input  class="box" type="text" id="preserters" name="preserters" onkeyup="getPresenters(this.value,'<?php echo $whoType ?>');" /><em2> *</em2><em> (অ্যাকাউন্ট নাম্বার)</em>
                <div id="presenterList" style="position:absolute;top:62%;left:59%;width:250px;z-index:10;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;visibility: hidden"></div></td>  
                </tr>
                <tr>
                    <td colspan="2">
                        <table cellspacing="0">
                            <tr id="table_row_odd">
                                <td style="border: 1px solid black;"><?php echo $whoinbangla?>-এর নাম </td>
                                <td style="border: 1px solid black;">একাউন্ট নাম্বার</td>
                                <td style="border: 1px solid black;">মোবাইল নাম্বার</td>
                                <td style="border: 1px solid black;"></td>
                            </tr>
                            <?php
                            $url= urlencode($_SERVER['REQUEST_URI']);
                             foreach ($_SESSION['arrPresenters'] as $key => $row) {
                            echo '<tr>';
                            echo '<td>' . $row[1] .'</td>';
                            echo '<td>' . $row[0].'</td>';
                            echo '<td>' .$row[2].'</td>';
                            echo '<td ><a href="includes/getParentOffices.php?delete=1&id='.$key.'&url='.$url.'"><img src="images/del.png" style="cursor:pointer;" width="20px" height="20px" /></a></td>';
                            echo '</tr>';
                        }
                    ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"><input type="submit" class="btn" name="submit1" id="submit1" value="আপডেট" > 
                        &nbsp;<input type="reset" class="btn" name="reset" value="রিসেট"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--***************########### Presenters list 00000000000000000****************** -->
    <?php
} elseif ($_GET['action'] == 'list') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="program_management.php"><b> ফিরে যান</b></a></div>
        <div style="padding-left: 70px;width: 30%;float: left;"><a href="presentation_schdule_combined.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?> লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a> </div> 
    </div> 
    <form method="POST" onsubmit="">	
        <table  class="formstyle" style =" width:85%"id="presentation_fillter">          
            <thead>
                <tr>
                    <th colspan="10" ><?php echo $whoinbangla?>-এর  লিস্ট </th>                        
                </tr>             
                <tr >
                    <td colspan="10">
                     <?php include_once 'includes/areaSearch.php';
                                    getArea("infoFromThana()");
                    ?>
                    <input type="hidden" id="method" value="infoFromThana()">
                    </td>
                </tr>
                <tr id = "table_row_odd">
                    <td><b><?php echo $whoinbangla?>-এর নাম </td>
                    <td ><b>একাউন্ট নাম্বার</b></td>
                    <td ><b>মোবাইল নাম্বার</b></td>
                    <td ><b>ইমেইল</b></td>
                    <td ><b>প্রকার</b></td>
                    <td><b>থানা</b></td>
                    <td><b>জেলা</b></td>
                    <td><b>বিভাগ</b></td>
                    <td><b>অপশন</b></td>
                </tr>
            </thead>
            <tbody id="plist">
                <!--Presenter List Query -->
                <?php
                $arrayEmpStatus = array('posting' => 'কর্মচারী', 'contract' => 'চুক্তিবদ্ধ');
                $db_result_presenter_info = mysql_query("SELECT * FROM cfs_user, employee WHERE idUser=employee.cfs_user_idUser 
                                                                                    AND employee.employee_type='$whoType' "); 
                while ($row_prstn = mysql_fetch_array($db_result_presenter_info)) {
                    $db_rl_presenter_name = $row_prstn['account_name'];
                    $db_rl_presenter_acc = $row_prstn['account_number'];
                    $db_rl_presenter_mobile = $row_prstn['mobile'];
                    $db_rl_presenter_email = $row_prstn['email'];
                    $db_rl_presenter_id = $row_prstn['idEmployee'];
                    $db_rl_presenter_status = $row_prstn['status'];
                    $sql_list_address= mysql_query("SELECT * FROM employee, address, thana, district, division WHERE idEmployee=$db_rl_presenter_id AND adrs_cepng_id= idEmployee 
                                                                            AND address_type='Present' AND address_whom='emp' 
                                                                            AND Thana_idThana=idThana AND District_idDistrict = idDistrict AND Division_idDivision=idDivision ");
                    $addressrow = mysql_fetch_assoc($sql_list_address);                    
                        $db_thana = $addressrow['thana_name'];
                        $db_district = $addressrow['district_name'];
                        $db_division = $addressrow['division_name'];
                    ?>
                    <tr>
                        <td ><?php echo $db_rl_presenter_name; ?></td>
                        <td><?php echo $db_rl_presenter_acc; ?></td>
                        <td><?php echo $db_rl_presenter_mobile; ?></td>
                        <td><?php echo $db_rl_presenter_email; ?></td>
                        <td><?php echo $arrayEmpStatus[$db_rl_presenter_status]; ?></td>
                        <td><?php echo $db_thana; ?></td>
                        <td><?php echo $db_district; ?></td>
                        <td><?php echo $db_division; ?></td>
                        <td style="text-align: center " > <a href="presentation_schdule_combined.php?action=sedule&id=<?php echo $db_rl_presenter_id; ?>&type=<?php echo $type;?>">সিডিউল </a></td>  
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </form>
<!--   ****************************** Presenter's schedule ****************************-->
    <?php
} elseif ($_GET['action'] == 'sedule') {
    ?>
    <div style="padding-top: 10px;">    
        <div style="padding-left: 110px; width: 49%; float: left"><a href="presentation_schdule_combined.php?action=list&type=<?php echo $type;?>"><b>ফিরে যান</b></a></div>
        <div><a href="presentation_schdule_combined.php?action=first&type=<?php echo $type;?>"><?php echo $typeinbangla;?> লিস্ট</a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=new&type=<?php echo $type;?>">মেইক <?php echo $typeinbangla;?></a>&nbsp;&nbsp;<a href="presentation_schdule_combined.php?action=list&type=<?php echo $type;?>"><?php echo $whoinbangla?>-এর  লিস্ট</a></div>
    </div>
    <form method="POST" onsubmit="">	
        <table  class="formstyle" style =" width:78%" id="presentation_fillter">          
            <thead>
            <tr>
                <th colspan="100" >সিডিউল  </th>                        
            </tr>
            <tr id = "table_row_odd">
                <td><b><?php echo $typeinbangla?>-এর নাম </b></td>
                <td ><b>তারিখ</b></td>
                <td ><b>সময়</b></td>
                <td ><b>ভেন্যু</b></td>                
            </tr>
            </thead>
            <!--Sql query for showing the data of a presenter-->
            <?php
                    $G_presenter_id = $_GET['id'];
                    $sql_sedule = "SELECT * FROM  program, presenter_list WHERE  idprogram = fk_idprogram AND fk_Employee_idEmployee = $G_presenter_id";
                    $db_result_sql_sedule = mysql_query($sql_sedule);
                    while ($row_sedule = mysql_fetch_array($db_result_sql_sedule)) {
                        $db_sedule_presentation_name = $row_sedule['program_name'];
                        $db_sedule_presentaiton_date = $row_sedule['program_date'];
                        $db_sedule_presentation_time = $row_sedule['program_time'];
                        $db_sedule_presentation_venue = $row_sedule['program_location'];
                ?>
            <tbody>
                 <tr>
                    <td ><?php echo $db_sedule_presentation_name; ?></td>
                    <td><?php echo english2bangla(date("d/m/Y",  strtotime($db_sedule_presentaiton_date))); ?></td>                    
                    <td><?php echo english2bangla(date('g:i a' , strtotime($db_sedule_presentation_time))); ?></td>
                    <td><?php echo $db_sedule_presentation_venue; ?></td>                    
                </tr>
            </tbody>
            <?php } ?>
        </table>
    </form>
    <?php
}
include_once 'includes/footer.php';
?> 
