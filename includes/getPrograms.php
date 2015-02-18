<?php
error_reporting(0);
include_once './ConnectDB.inc';
include_once './connectionPDO.php';
include_once './MiscFunctions.php';
$officeID = $_SESSION['loggedInOfficeID'];
if (isset($_GET['key']) && ($_GET['key'] != '')) {
	$str_key = $_GET['key'];
                   $today = date("Y-m-d");
                  $suggest_query = "SELECT * FROM program WHERE program_no LIKE('$str_key%') AND program_date >= '$today' AND ticket_prize IS NULL ORDER BY program_no";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $pNo = $suggest['program_no'];
                     $id = $suggest['idprogram'];
	            echo "<u><a onclick=setProgram('$pNo','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $pNo . "</a></u></br>";
        	}               
}
elseif (isset($_GET['budgetkey']) && ($_GET['budgetkey'] != '')) {
	$str_key = $_GET['budgetkey'];
                    $officeID = $_GET['offid'];
                   $today = date("Y-m-d");
                  $suggest_query = "SELECT * FROM program WHERE program_no LIKE('$str_key%') AND program_date >= '$today' 
                                                AND payment_status != 'paid' AND Office_idOffice =$officeID  ORDER BY program_no";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $pNo = $suggest['program_no'];
                     $id = $suggest['idprogram'];
	            echo "<u><a onclick=setProgram('$pNo','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $pNo . "</a></u></br>";
        	}               
}
elseif (isset($_GET['ticketkey']) && ($_GET['ticketkey'] != '')) {
	$str_key = $_GET['ticketkey'];
                   $today = date("Y-m-d");
                  $suggest_query = "SELECT * FROM program WHERE program_no LIKE('$str_key%') AND program_date >= '$today' AND ticket_prize IS NOT NULL ORDER BY program_no";
	$reslt= mysql_query($suggest_query);
	while($suggest = mysql_fetch_assoc($reslt)) {
                    $pNo = $suggest['program_no'];
                     $id = $suggest['idprogram'];
	            echo "<u><a onclick=setProgram('$pNo','$id'); style='text-decoration:none;color:brown;cursor:pointer;'>" . $pNo . "</a></u></br>";
        	}               
}
elseif(isset($_GET['type']) && !isset($_GET['report']))
{
    $g_type = $_GET['type'];
    $today = date("Y-m-d");
    $typeinbangla = getProgramType($g_type);
    $sel_program = mysql_query("SELECT * FROM program WHERE program_type = '$g_type' AND program_date >= '$today' AND ticket_prize IS NOT NULL ORDER BY program_date ");
     echo "<table border='1' cellpadding='0' cellspacing='0'>
            <tr id='table_row_odd'>
                <td style='border:1px black solid; '><b>$typeinbangla-এর নাম</b></td>
                <td style='border:1px black solid;'><b>তারিখ</b></td>
                <td style='border:1px black solid;'><b>সময়</b></td>
                <td style='border:1px black solid;'><b>ভেন্যু</b></td>
                <td style='border:1px black solid;'></td>
            </tr><tbody>";
    while($progrow = mysql_fetch_assoc($sel_program))
    {
        $db_programname = $progrow['program_name'];
        $db_programdate = $progrow['program_date'];
        $date = english2bangla(date('d/m/Y',  strtotime($db_programdate)));
        $db_programtime = $progrow['program_time'];
        $time = english2bangla($db_programtime);
        $db_programvanue = $progrow['program_location'];
        $db_progID = $progrow['idprogram'];
        echo "
                <tr>
                    <td style='border:1px black solid;'>$db_programname </td>
                    <td style='border:1px black solid;'>$date</td>
                    <td style='border:1px black solid;'>$time</td>
                    <td style='border:1px black solid;'>$db_programvanue</td>
                    <td style='border:1px black solid;text-align:center;'><a href='online_ticket_buying.php?opt=submit_ticket&prgrm_id=$db_progID'><input style ='font-size: 12px; width:50px;border:2px solid green;cursor:pointer;' type='button' value='ক্রয়' /></td>
                </tr>";
            
    }
    echo "</tbody></table>";
}

elseif(isset($_GET['report'])) //for program cost report *************************************
{
    $g_type = $_GET['type'];
    $today = date("Y-m-d");
    $typeinbangla = getProgramType($g_type);
    $sel_program = mysql_query("SELECT * FROM program,program_cost WHERE fk_program_id = idprogram 
                                                    AND program_type = '$g_type' AND program_date < '$today' AND payment_status= 'paid' 
                                                    AND pc_status = 'given' ORDER BY program_date");
     echo "<table border='1' cellpadding='0' cellspacing='0'>
            <tr id='table_row_odd'>
                <td style='border:1px black solid; '><b>$typeinbangla-এর নাম</b></td>
                <td style='border:1px black solid;'><b>তারিখ</b></td>
                <td style='border:1px black solid;'><b>সময়</b></td>
                <td style='border:1px black solid;'><b>ভেন্যু</b></td>
                <td style='border:1px black solid;'></td>
            </tr><tbody>";
    while($progrow = mysql_fetch_assoc($sel_program))
    {
        $db_programname = $progrow['program_name'];
        $db_programdate = $progrow['program_date'];
        $date = english2bangla(date('d/m/Y',  strtotime($db_programdate)));
        $db_programtime = $progrow['program_time'];
        $time = english2bangla($db_programtime);
        $db_programvanue = $progrow['program_location'];
        $db_progID = $progrow['idprogram'];
        echo "
                <tr>
                    <td style='border:1px black solid;'>$db_programname </td>
                    <td style='border:1px black solid;'>$date</td>
                    <td style='border:1px black solid;'>$time</td>
                    <td style='border:1px black solid;'>$db_programvanue</td>
                    <td style='border:1px black solid;text-align:center;'><a onclick=showProgReport('$db_progID')><input style ='font-size: 12px; width:50px;border:2px solid green;cursor:pointer;' type='button' value='রিপোর্ট' /></td>
                </tr>";
            
    }
    echo "</tbody></table>";
}

elseif(($_GET['what']=='attendance') && isset($_GET['whichtype']))
{
    $g_type = $_GET['whichtype'];
    $typeinbangla = getProgramType($g_type);
    $today = date("Y-m-d");
    $sel_program = mysql_query("SELECT * FROM program WHERE program_type = '$g_type' AND program_date <= '$today' 
        AND attendance_status='not_given' AND Office_idOffice = $officeID ORDER BY program_name ");
     echo "<table border='1' cellpadding='0' cellspacing='0'>
            <tr id='table_row_odd'>
                <td style='border:1px black solid; '><b>$typeinbangla-এর নাম</b></td>
                <td style='border:1px black solid;'><b>তারিখ</b></td>
                <td style='border:1px black solid;'><b>সময়</b></td>
                <td style='border:1px black solid;'><b>ভেন্যু</b></td>
                <td style='border:1px black solid;'></td>
            </tr><tbody>";
    while($progrow = mysql_fetch_assoc($sel_program))
    {
        $db_programname = $progrow['program_name'];
        $db_programdate = $progrow['program_date'];
        $date = english2bangla(date('d/m/Y',  strtotime($db_programdate)));
        $db_programtime = $progrow['program_time'];
        $time = english2bangla($db_programtime);
        $db_programvanue = $progrow['program_location'];
        $db_progID = $progrow['idprogram'];
        echo "
                <tr>
                    <td style='border:1px black solid;'>$db_programname</td>
                    <td style='border:1px black solid;'>$date</td>
                    <td style='border:1px black solid;'>$time</td>
                    <td style='border:1px black solid;'>$db_programvanue</td>
                    <td style='border:1px black solid;text-align:center;'><a href='presenter_attendance.php?opt=submit&id=$db_progID'><input style ='font-size: 12px; width:100px;border:2px solid green;cursor:pointer;' type='button' value='হাজিরা প্রদান' /></a></td>
                </tr>";
            
    }
    echo "</tbody></table>";
}
elseif(($_GET['what']=='salary') && isset($_GET['whichtype']))
{
    $g_type = $_GET['whichtype'];
    $typeinbangla = getProgramType($g_type);
    $today = date("Y-m-d");
    $sel_program = mysql_query("SELECT * FROM program WHERE program_type = '$g_type' AND program_date <= '$today' 
        AND attendance_status='given' AND payment_status='unpaid' AND Office_idOffice =$officeID ORDER BY program_name ");
     echo "<table border='1' cellpadding='0' cellspacing='0'>
            <tr id='table_row_odd'>
                <td style='border:1px black solid; '><b>$typeinbangla-এর নাম</b></td>
                <td style='border:1px black solid;'><b>তারিখ</b></td>
                <td style='border:1px black solid;'><b>সময়</b></td>
                <td style='border:1px black solid;'><b>ভেন্যু</b></td>
                <td style='border:1px black solid;'></td>
            </tr><tbody>";
    while($progrow = mysql_fetch_assoc($sel_program))
    {
        $db_programname = $progrow['program_name'];
        $db_programdate = $progrow['program_date'];
        $date = english2bangla(date('d/m/Y',  strtotime($db_programdate)));
        $db_programtime = $progrow['program_time'];
        $time = english2bangla($db_programtime);
        $db_programvanue = $progrow['program_location'];
        $db_progID = $progrow['idprogram'];
        echo "
                <tr>
                    <td style='border:1px black solid;'>$db_programname</td>
                    <td style='border:1px black solid;'>$date</td>
                    <td style='border:1px black solid;'>$time</td>
                    <td style='border:1px black solid;'>$db_programvanue</td>
                    <td style='border:1px black solid;text-align:center;'><a href='presenter_salary.php?opt=submit&id=$db_progID'><input style ='font-size: 12px; width:100px;border:2px solid green;cursor:pointer;' type='button' value='বেতন প্রদান' /></a></td>
                </tr>";
            
    }
    echo "</tbody></table>";
}
?>
