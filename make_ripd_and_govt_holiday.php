<?php
error_reporting(0);
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
?>
<title>রিপড এন্ড সরকারি ছুটি তৈরি</title>
<?php

$user_id = $_SESSION['userIDUser'];
//$user_id = "1";
$flag = 'false';
//*****************************************************************
//select office or saleStore_id from cfs_user and office or store relationship using user_id .... Needed

$monthDayNumber = 31;
$dayLoop = 1;
if (isset($_POST['submit'])) {
    for($dayLoop =1; $dayLoop<=$monthDayNumber;$dayLoop++){
        $date_var = "date_".$dayLoop;
        $RNGHoliday = "ripd_govt_holiday_".$dayLoop;
        $date_date = $_POST[$date_var];
        $RipdNGovtHoliday = $_POST[$RNGHoliday];
        //Check in Ripd And GovT Holiday Table
        $check_RnGDay_sql = mysql_query("SELECT * from ".$dbname.".ripd_and_govt_holiday where rng_holiday_date = '$date_date'");
        $check_RnGDay_row_number = mysql_num_rows($check_RnGDay_sql);
        
        //...........................Test Echo for see output.............................................
       // echo "date: ".$date_date." RipdNGovt: ".$RipdNGovtHoliday." check_RnGDay_row_number: ".$check_RnGDay_row_number."<br />";
        if($RipdNGovtHoliday!="" && $check_RnGDay_row_number<1){
          $sql_insert_ripd_govt_holiday = "INSERT into $dbname.ripd_and_govt_holiday (rng_holiday_date, rng_hd_description, rng_insert_date, cfs_user_idUser) 
                                                    VALUES ('$date_date', '$RipdNGovtHoliday', NOW(), '$user_id')";   
          if(mysql_query($sql_insert_ripd_govt_holiday)){
              $flag = 'true';
          }else{
              $flag = 'false';
              break;
          }
        }
        elseif($check_RnGDay_row_number>0){
            $sql_update_ripd_govt_holiday = "UPDATE ".$dbname.".ripd_and_govt_holiday SET rng_hd_description='$RipdNGovtHoliday', rng_insert_date=NOW(), cfs_user_idUser='$user_id' where rng_holiday_date = '$date_date'";
            if(mysql_query($sql_update_ripd_govt_holiday)){
              $flag = 'true';
          }else{
              $flag = 'false';
              break;
          }
        }else{}
    }
    if($flag=='true'){
        $msg = "Your Operation Has Successfully Completed";
    }else{
        $msg = "Error, Please Try Again.";
    }
}
?>
<style type="text/css">
    @import "css/bush.css";
    .cal_table td{
        text-align: center;
        font-size: 14px;
    }
</style>
<div style="padding-top: 10px;">
    <?php

    class Calendar {

        var $events;

        function Calendar($date) {
            if (empty($date))
                $date = time();
            define('NUM_OF_DAYS', date('t', $date));
            define('CURRENT_DAY', date('j', $date));
            define('CURRENT_MONTH_A', date('F', $date));
            define('CURRENT_MONTH_N', date('n', $date));
            define('CURRENT_YEAR', date('Y', $date));
            define('START_DAY', date('w', mktime(0, 0, 0, CURRENT_MONTH_N, 1, CURRENT_YEAR)));
            define('COLUMNS', 7);
            define('PREV_MONTH', $this->prev_month());
            define('NEXT_MONTH', $this->next_month());
        }

        function dayName($dayNumber) {
            if ($dayNumber == 1) {
                return "রবি";
            } elseif ($dayNumber == 2) {
                return "সোম";
            } elseif ($dayNumber == 3) {
                return "মঙ্গল";
            } elseif ($dayNumber == 4) {
                return "বুধ";
            } elseif ($dayNumber == 5) {
                return "বৃহস্পতি";
            } elseif ($dayNumber == 6) {
                return "শুক্র";
            } else {
                return "শনি";
            }
        }

        function prev_month() {
            return mktime(0, 0, 0, (CURRENT_MONTH_N == 1 ? 12 : CURRENT_MONTH_N - 1), (checkdate((CURRENT_MONTH_N == 1 ? 12 : CURRENT_MONTH_N - 1), CURRENT_DAY, (CURRENT_MONTH_N == 1 ? CURRENT_YEAR - 1 : CURRENT_YEAR)) ? CURRENT_DAY : 1), (CURRENT_MONTH_N == 1 ? CURRENT_YEAR - 1 : CURRENT_YEAR));
        }

        function next_month() {
            return mktime(0, 0, 0, (CURRENT_MONTH_N == 12 ? 1 : CURRENT_MONTH_N + 1), (checkdate((CURRENT_MONTH_N == 12 ? 1 : CURRENT_MONTH_N + 1), CURRENT_DAY, (CURRENT_MONTH_N == 12 ? CURRENT_YEAR + 1 : CURRENT_YEAR)) ? CURRENT_DAY : 1), (CURRENT_MONTH_N == 12 ? CURRENT_YEAR + 1 : CURRENT_YEAR));
        }

        function makeCalendar($msg,$flag) {
            echo '<div style="padding-left: 50px;"><a href="office_sstore_management.php"><b>ফিরে যান</b></a></div>';
            echo '<form name="ripd_govt_calender_form" method="POST" onsubmit="">';
            echo '<table class ="cal_table" cellspacing="0" style="width:90%; margin-left: 50px;"><tr>';
            echo '<td colspan="4" height="40px"><b>রিপড এন্ড সরকারী ছুটির দিন তৈরি</b></td></tr><tr>';
            if(!empty($msg)){
                if($flag=='true'){
                    echo '<td colspan="4" height="40px"><b><span style="color:green;font-size:25px;"><blink>'.$msg.'</blink></b></td></tr><tr>';
                }else{
                    echo '<td colspan="4" height="40px"><b><span style="color:red;font-size:25px;"><blink>'.$msg.'</blink></b></td></tr><tr>';
                }
            }
            echo '<td><a href="?&apps=SD&date=' . PREV_MONTH . '"><img src="images/back.ico" height="35px" width="35px"></img></a></td>';
            echo '<td colspan="2" ><b>' . CURRENT_MONTH_A . ' - ' . CURRENT_YEAR . '</b></td>';
            echo '<td><a href="?&apps=SD&date=' . NEXT_MONTH . '"><img src="images/back_right.bmp" height="35px" width="35px"></img></a></td>';
            echo '</tr>
                <tr bgcolor = #06ACE5>';

            echo '<td>বার</td>';
            echo '<td>তারিখ</td>';
            echo '<td colspan="2">RIPD and Govt. HD</td>';
            echo '</tr>';
            /// Weekly Holyday **************        
            $WHdayValue = '';
            $WHdayValue2 = '';

            //$row_number = 1;
            $dayNumber = 1;
            $sql_WHday = "SELECT * from " . $dbname . ".weekly_holiday where office_type ='office'";
            $rs_WHday = mysql_query($sql_WHday);
            while ($row_WHday = mysql_fetch_array($rs_WHday)) {
                $weekly_hd_value = $row_WHday['holiday_value'];
                $weekly_hd_serial = $row_WHday['holiday_serial'];
                if($weekly_hd_serial==1){
                $WHdayValue = $weekly_hd_value;
                //$row_number = 2;
                }else{
                    $WHdayValue2 = $weekly_hd_value;
                    //$row_number = 1;
                }
            }
            //echo "WHDay: " . $WHdayValue . " SDay: " . START_DAY . "  TDays: " . NUM_OF_DAYS . "<br \>";
            //$WHdayValue = '5';
            //$WHdayValue2 = '3';
            //if(empty($WHdayValue2)) {
                //$WHdayValue2 = '40';
            //}
            if (empty($WHdayValue)){
                $WHdayValue = 101;
            }
            if (empty($WHdayValue2)){
                $WHdayValue2 = 101;
            }
            for ($i = 1; $i <= NUM_OF_DAYS + START_DAY; $i++) {
                if ($i > START_DAY) {
                    $monthDate = $i - START_DAY;
                    //echo $i.''.CURRENT_MONTH_N.''.CURRENT_YEAR;                    
                    $CurDate = CURRENT_YEAR . '-' . CURRENT_MONTH_N . '-' . $monthDate;
                    //echo $CurDate;
                    $colorValueHDay = '#F05656'; //dayValue
                    $colorValueOnDay = '#458F8E';
                    $colorRGovt = '#DBEAF9';
                    $SODayDesc = '';
                    $RGHDayDesc = '';
                    $specialOffDay = '#FBF791';
                    $specialOnDay = '#9BF58E';
                    // Search in Ripd and Govt Holiday Table
                    $sql_RGHoliday=  mysql_query("SELECT * from ".$dbname.".ripd_and_govt_holiday where rng_holiday_date = '$CurDate'");
                    $RGHolidayRow = mysql_fetch_array($sql_RGHoliday);
                    $RGHolidayDesc = $RGHolidayRow['rng_hd_description']; 
                    
                    if (($i % $WHdayValue) == 0 OR ($i % $WHdayValue2) == 0) {

                        echo "<tr bgcolor= '$colorValueHDay'><td bgcolor= '$colorValueHDay'>" . $this->dayName($dayNumber) . "</td>";
                        echo "<td><input type=\"hidden\" name=\"date_$monthDate\" value=\"$CurDate\">$CurDate</td>";
                        echo "<td colspan='2'><textarea style=\"height: 30px; width: 420px; margin:0px\" id=\"ripd_govt\" name=\"ripd_govt_holiday_$monthDate\">$RGHolidayDesc</textarea></td>";
                        
                        if (($i % $WHdayValue) == 0) {
                            $WHdayValue = $WHdayValue + 7;
                        }else{
                            $WHdayValue2 = $WHdayValue2 + 7;
                        }
                    } else {
                        /*
                          //******************* RIPD & Government Holyday
                          $sql_RGHDay = "SELECT * from " . $dbname . ".ripd_and_govt_holiday where rng_holiday_date = '$CurDate' And status = 'y'";
                          $rs_RGHDay = mysql_query($sql_RGHDay);
                          while ($row_RGHDay = mysql_fetch_array($rs_RGHDay)) {
                          $RGHDayDesc = $row_RGHDay['rng_hd_description'];
                          }
                          if ($RGHDayDesc) {
                          $sql_spOnDay = "SELECT * from " . $dbname . ".special_onday where spN_date = '$CurDate' And offDay_officeStore_idRelational_offDay_n_officeStore = 1";
                          $rs_spOnDay = mysql_query($sql_spOnDay);

                          while ($row_spOnDay = mysql_fetch_array($rs_spOnDay)) {
                          $specialOnDay = $row_spOnDay['spN_description'];
                          $colorValueOnDay = 'green';
                          }
                          if ($specialOnDay)
                         * 
                         */
                        echo "<tr><td>" . $this->dayName($dayNumber) . "</td>";
                        echo "<td><input type=\"hidden\" name=\"date_$monthDate\" value=\"$CurDate\"/>$CurDate</td>";
                        echo "<td bgcolor= '$colorRGovt' colspan='2'><textarea style=\"height: 30px; width: 420px; margin:0px\" id=\"ripd_govt\" name=\"ripd_govt_holiday_$monthDate\">$RGHolidayDesc</textarea></td>";
                        
                        //echo "<td bgcolor = '$specialOnDay'><textarea style=\"height: 30px; width: 130px; margin:0px\" id=\"special_on_day\" name=\"special_on_day\" ></textarea></td>";
                        //echo "<td bgcolor = '$specialOffDay';><textarea style=\"height: 30px; width: 130px; margin:0px\" id=\"special_off_day\" name=\"special_off_day\" ></textarea></td></tr>";
                        /*

                          } else {
                          echo "<tr><td>" . $this->dayName($dayNumber) . "</td>";
                          echo "<td>$CurDate</td>";
                          echo "<td bgcolor= '$colorRGovt'><input  class=\"box\" type=\"text\" id=\"Ripd_govt\" name=\"Ripd_govt\" /></td>";
                          echo '<td><select class=\"box2\" name=\"option\" style=\"width: 70px;\">
                          <option value=\"Y\">Accept</option>
                          <option value=\"N\">Reject</option>
                          </select></td>';
                          echo "<td><input  class=\"box\" type=\"text\" id=\"special_onDay\" name=\"special_onDay\" /></td>";
                          echo "<td><input  class=\"box\" type=\"text\" id=\"special_offDay\" name=\"special_offDay\" /></td></tr>";
                          }
                          } else {
                          $sql_spOffDay = "SELECT * from " . $dbname . ".special_offday where sp_off_day_date = '$CurDate' And offday_officeStore = 1";
                          $rs_spOffDay = mysql_query($sql_spOffDay);
                          while ($row_spOffDay = mysql_fetch_array($rs_spOffDay)) {
                          $specialOffDay = $row_spOffDay['sp_off_day_description'];
                          $colorValueOnDay = 'yellow';
                          }
                          if ($specialOffDay) {
                          echo "<tr><td>" . $this->dayName($dayNumber) . "</td>";
                          echo "<td>$CurDate</td>";
                          echo "<td bgcolor= '$colorRGovt'><input  class=\"box\" type=\"text\" id=\"Ripd_govt\" name=\"Ripd_govt\" /></td>";
                          echo '<td><select class=\"box2\" name=\"option\" style=\"width: 70px;\">
                          <option value=\"Y\">Accept</option>
                          <option value=\"N\">Reject</option>
                          </select></td>';
                          echo "<td><input  class=\"box\" type=\"text\" id=\"special_onDay\" name=\"special_onDay\" /></td>";
                          echo "<td><input  class=\"box\" type=\"text\" id=\"special_offDay\" name=\"special_offDay\" /></td></tr>";
                          } else {
                          echo "<tr><td>" . $this->dayName($dayNumber) . "</td>";
                          echo "<td>$CurDate</td>";
                          echo "<td bgcolor= '$colorRGovt'><input  class=\"box\" type=\"text\" id=\"Ripd_govt\" name=\"Ripd_govt\" /></td>";
                          echo '<td><select class=\"box2\" name=\"option\" style=\"width: 70px;\">
                          <option value=\"Y\">Accept</option>
                          <option value=\"N\">Reject</option>
                          </select></td>';
                          echo "<td><input  class=\"box\" type=\"text\" id=\"special_onDay\" name=\"special_onDay\" /></td>";
                          echo "<td><input  class=\"box\" type=\"text\" id=\"special_offDay\" name=\"special_offDay\" /></td></tr>";
                          }
                          }
                         * 
                         */
                    }
                } else {
                    /*
                      echo "<tr><td>" . $this->dayName($dayNumber) . "</td>";
                      echo "<td>00</td>";
                      echo "<td bgcolor= '$colorRGovt'><input  class=\"box\" type=\"text\" id=\"Ripd_govt\" name=\"Ripd_govt\" /></td>";
                      echo "<td><select class=\"box2\" name=\"option\" style=\"width: 70px;\">
                      <option value=\"Y\">Accept</option>
                      <option value=\"N\">Reject</option>
                      </select></td>";
                      echo "<td><input  class=\"box\" type=\"text\" id=\"special_onDay\" name=\"special_onDay\" /></td>";
                      echo "<td><input  class=\"box\" type=\"text\" id=\"special_offDay\" name=\"special_offDay\" /></td></tr>";
                     * 
                     */
                    if (($i % $WHdayValue) == 0 OR ($i % $WHdayValue2) == 0) {
                        if (($i % $WHdayValue) == 0) {
                            $WHdayValue = $WHdayValue + 7;
                        }else
                            $WHdayValue2 = $WHdayValue2 + 7;
                    }
                }

                if ($i % 7 == 0) {
                    $dayNumber = 1;
                } else {
                    $dayNumber = $dayNumber + 1;
                }
            }
            echo '<tr><td colspan="4" style="text-align:center; " ><input class="btn" style =" font-size: 12px; " type="submit" name="submit" value="সেভ করুন" />
                            <input class="btn" style =" font-size: 12px" type="reset" name="reset" value="রিসেট করুন" /></td>         
                    </tr>';
    echo '</table>';
    echo '</form>';
            //echo str_repeat('<td width = 11% height =40px style="background-color: #DBEAF9">&nbsp;</td>', (COLUMNS * $row_number) - (NUM_OF_DAYS + START_DAY)) . '</tr></table>';
        }

    }

    $cal = new Calendar($_GET['date']);
    $cal->makeCalendar($msg,$flag);
    ?>
</div>       
<?php
include_once 'includes/footer.php';
?>