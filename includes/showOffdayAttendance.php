<?php
error_reporting(0);
include_once 'ConnectDB.inc';
include_once 'connectionPDO.php';

$holiday =0;
$specialonday=0;
function dateTodaynumber ($date) // date to day number convertion
{
    $day = date('l', strtotime($date)); // from date to day convertion 
    $day_of_week = date('w', strtotime($day)); // from dayname to dayno convertion
    return $day_of_week;
}

$db_onsid= $_GET['emponsid'];
$currentdate =$_GET['selecteddate'];

$sql_onsr = mysql_query("SELECT * FROM ons_relation WHERE idons_relation = $db_onsid;");
$onsr_row = mysql_fetch_assoc($sql_onsr);
$db_type = $onsr_row['catagory'];
$db_offNstoreid = $onsr_row['add_ons_id'];
//special onday check ****************************
            $sql_son = mysql_query("SELECT * FROM special_onday WHERE office_type= '$db_type' AND office_store_id = $db_offNstoreid AND spN_date ='$currentdate' ;");
            while($sonrow = mysql_fetch_assoc($sql_son))
            {
                $holiday =0; $specialonday = 1;
                        break;
            }
if($holiday==0 && $specialonday == 0 )
{
    //weekly holiday check ************************
    $sql_wh = mysql_query("SELECT * FROM weekly_holiday WHERE office_type= '$db_type' AND office_store_id = $db_offNstoreid;");
    while($whrow = mysql_fetch_assoc($sql_wh))
    {
        $db_daynumber = $whrow['holiday_value'] -1;
        $current_daynumber = dateTodaynumber ($currentdate);
        if($db_daynumber == $current_daynumber)
        {
            $holiday =1 ;
            break;
        }
    }
    if($holiday == 0)
    {
        // ripd & govt holiday chekck***********************
        $sql_rng = mysql_query("SELECT * FROM ripd_and_govt_holiday WHERE rng_holiday_date = '$currentdate';");
        while($rngrow = mysql_fetch_assoc($sql_rng))
        {
            $holiday =1; 
                    break;
        }
        if($holiday == 0)
        {
            //special offday check ****************************
            $sql_soff = mysql_query("SELECT * FROM special_offday WHERE office_type= '$db_type' AND office_store_id = $db_offNstoreid AND sp_off_day_date ='$currentdate' ;");
            while($soffrow = mysql_fetch_assoc($sql_soff))
            {
                $holiday =1;
                        break;
            }
        }
    }
}

if(($holiday==0) || ($specialonday==1))
{ 
            echo "<tr><td colspan='13' style='text-align:center;color:red;font-size:16px;'>দুঃখিত, আজ নিয়মিত কর্মদিবস</br> নিয়মিত কর্মচারীর হাজিরার জন্য নিম্নের লিঙ্ক-এ ক্লিক করুন</td></tr>";
    echo "<tr><td colspan='13' style='text-align:center;font-size:18px;'><a href='regular_emp_attendance.php'>নিয়মিত কর্মচারীর হাজিরা</a></td></tr>";                       
}
 else
     {
      $db_slNo = 1;
                                    $rs = mysql_query("SELECT * FROM cfs_user WHERE  	cfs_account_status = 'active' AND idUser = ANY(SELECT cfs_user_idUser FROM employee  WHERE emp_ons_id = '$db_onsid');");

                                    while ($rowemployee = mysql_fetch_assoc($rs)) 
                                    {  
                                        $sl =  english2bangla($db_slNo);
                                        $db_empaccount = $rowemployee['account_number'];
                                        $db_empname = $rowemployee['account_name'];
                                        $db_empcfsid = $rowemployee['idUser'];
                                        $leavesql = mysql_query("SELECT * FROM emp_in_leave WHERE emp_id=$db_empcfsid;");
                                        while($row = mysql_fetch_assoc($leavesql))
                                        {
                                            $db_strtdate = $row['starting_date'];
                                            $db_enddate = $row['end_date'];
                                            if((strtotime($currentdate) >=strtotime($db_strtdate)) && (strtotime($currentdate) <= strtotime($db_enddate))) {$leave = 1;}
                                            else {$leave =0;}
                                            
                                        }
                                        $emprslt = mysql_query("SELECT * FROM employee WHERE cfs_user_idUser = $db_empcfsid;");
                                        $rowemp = mysql_fetch_assoc($emprslt);
                                        $db_emp_id = $rowemp['idEmployee'];
                                        echo "<tr>";
                                        echo "<td style='border: 1px solid #000;'>$sl</td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><input name='empacc[$db_slNo]' type='hidden' value='$db_empaccount' />$db_empaccount</td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><input name= 'empname[$db_slNo]' type='hidden' value='$db_empname' />$db_empname<input name='empid[$db_slNo]' type='hidden' value='$db_emp_id' /></td>";
                                        if($leave == 1)
                                        {
                                             echo "<td style='border: 1px solid #000; padding:0px !important;'><input type='hidden' id='leave[$db_slNo]' name='atten[$db_slNo]' value='leave' />
                                                    <input id='inleave[$db_slNo]' type='text' readonly style='width:100%;height:100%;' name='inleave[$db_slNo]' value='ছুটি' />                                          
                                                    </td>";
                                             echo "<td style='border: 1px solid #000; padding:0px !important;'><textarea id='cause[$db_slNo]' name='cause[$db_slNo]' style='width:98%;height:100%;margin:0px !important' disabled=''></textarea></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><input id='intime[$db_slNo]' type='time' name='intime[$db_slNo]' value='09:00:00' style='height:100%;' disabled=''/></td>";
                                        echo "<td  style='border: 1px solid #000; padding:0px !important;'><input id='outtime[$db_slNo]' type='time' name='outtime[$db_slNo]' value='17:00:00' style='height:100%;'disabled=''/></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><select id='min_gap[$db_slNo]' name='min_gap[$db_slNo]' style='width:100%;height:100%;font-size: 12px !important' disabled=''>
                                        <option>-সিলেক্ট-</option>    
                                        <option value='0' >নাই</option>    
                                        <option value='15'>১৫ মিঃ</option>
                                            <option value='20'>২০ মিঃ</option>
                                            <option value='30'>৩০ মিঃ</option>
                                            <option value='40'>৪০ মিঃ</option>
                                            <option value='50'>৫০ মিঃ</option>
                                            </select></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><textarea id='min_gap_des[$db_slNo]' name='min_gap_des[$db_slNo]' style='width:98%;height:100%;margin:0px !important' disabled=''></textarea></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><select id='maj_gap[$db_slNo]' name='maj_gap[$db_slNo]' onchange='setWorkandXtra(this.value,$db_slNo)' style='width:100%;height:100%;font-size: 12px !important' disabled=''>
                                        <option selected>-সিলেক্ট-</option>     
                                        <option value='0' >নাই</option>    
                                        <option value='1'>১ ঘণ্টা</option>
                                            <option value='1.5'>১.৫ ঘণ্টা</option>
                                            <option value='2'>২ ঘণ্টা</option>
                                            <option value='2.5'>২.৫ ঘণ্টা</option>
                                            <option value='3'>৩ ঘণ্টা</option>
                                            <option value='3.5'>৩.৫ ঘণ্টা</option>
                                            <option value='4'>৪ ঘণ্টা</option>
                                            </select></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><textarea id='maj_gap_des[$db_slNo]' name='maj_gap_des[$db_slNo]' style='width:98%;height:100%;margin:0px !important' disabled=''></textarea></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><input id='worktime[$db_slNo]' type='text' readonly style='width:100%;height:100%;' name='worktime[$db_slNo]' disabled=''/></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><input id='xtratime[$db_slNo]' type='text' readonly style='width:100%;height:100%;' name='xtratime[$db_slNo]' disabled=''/></td>";
                                        echo "</tr>";
                                        }
                                        else
                                        {
                                            echo "<td style='border: 1px solid #000; padding:0px !important;'>
                                                    <input type='radio' name='atten[$db_slNo]' value='yes' onclick = 'checkAttendance(this.value,$db_slNo)'/>উপস্থিত</br>                                           
                                                    </td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><textarea id='cause[$db_slNo]' name='cause[$db_slNo]' style='width:98%;height:100%;margin:0px !important' disabled=''></textarea></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><input id='intime[$db_slNo]' type='time' name='intime[$db_slNo]' value='09:00:00' style='height:100%;' disabled=''/></td>";
                                        echo "<td  style='border: 1px solid #000; padding:0px !important;'><input id='outtime[$db_slNo]' type='time' name='outtime[$db_slNo]' value='17:00:00' style='height:100%;' disabled=''/></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><select id='min_gap[$db_slNo]' name='min_gap[$db_slNo]' style='width:100%;height:100%;font-size: 12px !important' disabled=''>
                                        <option>-সিলেক্ট-</option>    
                                        <option value='0' >নাই</option>    
                                        <option value='15'>১৫ মিঃ</option>
                                            <option value='20'>২০ মিঃ</option>
                                            <option value='30'>৩০ মিঃ</option>
                                            <option value='40'>৪০ মিঃ</option>
                                            <option value='50'>৫০ মিঃ</option>
                                            </select></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><textarea id='min_gap_des[$db_slNo]' name='min_gap_des[$db_slNo]' style='width:98%;height:100%;margin:0px !important' disabled=''></textarea></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><select id='maj_gap[$db_slNo]' name='maj_gap[$db_slNo]' onchange='setWorkandXtra(this.value,$db_slNo)' style='width:100%;height:100%;font-size: 12px !important' disabled=''>
                                        <option selected>-সিলেক্ট-</option>     
                                        <option value='0' >নাই</option>    
                                        <option value='1'>১ ঘণ্টা</option>
                                            <option value='1.5'>১.৫ ঘণ্টা</option>
                                            <option value='2'>২ ঘণ্টা</option>
                                            <option value='2.5'>২.৫ ঘণ্টা</option>
                                            <option value='3'>৩ ঘণ্টা</option>
                                            <option value='3.5'>৩.৫ ঘণ্টা</option>
                                            <option value='4'>৪ ঘণ্টা</option>
                                            </select></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><textarea id='maj_gap_des[$db_slNo]' name='maj_gap_des[$db_slNo]' style='width:98%;height:100%;margin:0px !important' disabled=''></textarea></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><input id='worktime[$db_slNo]' type='text' readonly style='width:100%;height:100%;' name='worktime[$db_slNo]' disabled=''/></td>";
                                        echo "<td style='border: 1px solid #000; padding:0px !important;'><input id='xtratime[$db_slNo]' type='text' readonly style='width:100%;height:100%;' name='xtratime[$db_slNo]' disabled=''/></td>";
                                        echo "</tr>";
                                        }
                                         $db_slNo++;
                                         echo "<input name= 'count' type='hidden' value='$db_slNo' />";
                                    }
    
}
                                  
?>

