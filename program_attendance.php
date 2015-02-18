<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
include_once 'includes/selectQueryPDO.php';
?>
<title>প্রেজেন্টার/প্রোগ্রামার/ট্রেইনার এর উপস্থিতি</title>
<style type="text/css"> @import "css/bush.css";</style>
<style type="text/css">
    #search {
        width: 50px;background-color: #009933;border: 2px solid #0077D5;cursor: pointer; color: wheat;
    }
    #search:hover {
        background-color: #0077D5;border: 2px inset #009933;color: wheat;
    }
</style>
<script type="text/javascript">
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
                document.getElementById('progResult').setAttribute('style','position:absolute;top:35%;left:64%;width:250px;z-index:10;border: 1px inset black; overflow:auto; height:105px; background-color:#F5F5FF;');
            }
            document.getElementById('progResult').innerHTML=xmlhttp.responseText;
        }
        xmlhttp.open("GET","includes/getPrograms.php?key="+key,true);
        xmlhttp.send();	
    }
    function setProgram(progNo,progid)
    {
        document.getElementById('prgrm_number').value = progNo;
        document.getElementById('prgrm_id').value = progid;
        document.getElementById('progResult').style.display = "none";
        // checkProgramForAttendance(progid); 
    }
    function beforeProceed()
    {
        if (document.getElementById('programcheck').innerHTML != "")
        {
            document.getElementById('okk').readonly = false;
            return true;
        }
        else {
            document.getElementById('okk').readonly = true;
            return false;
        }
    }
</script>
<?php
if(isset($_POST['save'])){
    $var_arr = $_POST['attandance'];
    var_dump($var_arr);
}
?>
<div class="main_text_box" style="width: 100% !important;">
    <div style="padding-left: 50px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
    <div>
        <form method="post" action="" >
            <table  class="formstyle" style="width: 90% !important; font-family: SolaimanLipi !important;margin:0 auto !important;">  
                <tr><th colspan="2" style="text-align: center;">প্রেজেন্টার/প্রোগ্রামার/ট্রেইনার এর উপস্থিতি</th></tr>
                 
                <?php
                                if (isset($_POST['submit'])) { ?>
                <tr><td>
                                <fieldset style="border: #686c70 solid 3px;width: 50%;margin-left:25%;">
                                    <legend style="color: brown"><?php echo $_POST['prgrm_number']; ?></legend>
                                    <table>
                                        <tr>
                                            <?php
                                            $sql_select_program->execute(array($_POST['prgrm_number']));
                                            $program = $sql_select_program->fetchAll();
                                            foreach ($program as $row){
                                                $db_program_name = $row['program_name'];
                                                $db_program_date = $row['program_date'];
                                                $db_program_location = $row['program_location'];
                                                $db_program_time = $row['program_time'];
                                                $db_idprogram = $row['idprogram'];
                                            }
                                            ?>
                                            <td style="width: 25%; text-align: right"><b>প্রোগ্রাম নাম</b></td>
                                            <td style="width: 25%; text-align: left"> : <?php echo $db_program_name;?></td>
                                            <td style="width: 25%; text-align: right"><b>তারিখ</b></td>
                                            <td style="width: 25%; text-align: left"> : <?php echo english2bangla(date('d/m/Y', strtotime($db_program_date)));?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%; text-align: right"><b>লোকেশন</b></td>
                                            <td style="width: 25%; text-align: left"> : <?php echo $db_program_location;?></td>
                                            <td style="width: 25%; text-align: right"><b>সময়</b></td>
                                            <td style="width: 25%; text-align: left"> : <?php echo english2bangla($db_program_time);?></td>
                                        </tr>
                                    </table>
                            </fieldset>
           </td></tr>
                <tr><td>
                             <fieldset style="border: #686c70 solid 3px;width: 50%;margin-left:25%;">
                                    <legend style="color: brown">প্রেজেন্টার লিস্ট</legend>
                                    <table cellspacing="0" cellpadding="0" >
                                        <tr>
                                            <th style='border: 1px solid #000099; text-align: center' >ক্রম</th>
                                            <th style='border: 1px solid #000099; text-align: center' >নাম</th>
                                            <th style='border: 1px solid #000099; text-align: center' >একাউন্ট</th>
                                            <th style='border: 1px solid #000099; text-align: center' >উপস্থিতি</th>
                                        </tr>
                                        <tr>
                                            <?php
                                            $count = 1;
                                            $sql_select_presenter_list->execute(array($db_idprogram));
                                            $presenter_list = $sql_select_presenter_list->fetchAll();
                                            foreach ($presenter_list as $row){
                                                $db_account_name = $row['account_name'];
                                                $db_account_number = $row['account_number'];
                                                $show_count = english2bangla($count);
                                                ?>
                                            <td style='border: 1px solid #000099; text-align: center' ><?php echo $show_count;?></td>
                                            <td style='border: 1px solid #000099; text-align: center' ><?php echo $db_account_name;?></td>
                                            <td style='border: 1px solid #000099; text-align: center' ><?php echo $db_account_number;?></td>
                                            <td style='border: 1px solid #000099; text-align: center' >
                                                <input type="radio" name="attandance['<?php echo $count?>']" value="present">উপস্থিত<br>
                                                <input type="radio" name="attandance['<?php echo $count?>']" value="absent">অনুপস্থিত</td>
                                            </tr> 
                                            <?php
                                            $count++;
                                            }
                                            ?>
                                                             
                                    </table>
                            </fieldset>
                </td></tr>
                          <tr><td></br>
                            <input class="btn" style =" font-size: 12px; margin-left: 48% " type="submit" name="save" id="save" value="সেভ" /></td></tr>
                                <?php }
                                
                                else {?>
                            <tr>                    
                    <td colspan= "2" style="text-align: center; padding-top: 10px; " ><span id="programcheck"></span></td>                           
                </tr>
                <tr><td style="width: 50%; text-align: right"><b>প্রেজেন্টার/প্রোগ্রামার/ট্রেইনার এর নাম্বার<b></td>
                                <td style="width: 50%; text-align: left"> : <input class="box" type="text" id="prgrm_number" name="prgrm_number" onkeyup="getProgram(this.value);"/>
                                    <div id="progResult"></div><input type="hidden" name="prgrm_id" id="prgrm_id"/></td></tr>
                                <tr>                    
                                    <td colspan= "2" style="padding-left: 310px ; padding-top: 10px; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" id="okk" value="ঠিক আছে" /></td>                           
                                </tr> 
                                <?php }?>
                                </table>
                                </form>
                                </div>                 
                                </div>
                                <?php include_once 'includes/footer.php'; ?>