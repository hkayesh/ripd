<?php
include_once 'includes/header.php';
?>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>

<script type="text/javascript">
    function infoFromThana()
    {
        var xmlhttp;
        if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
        else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                document.getElementById('office').innerHTML=xmlhttp.responseText;
        }
        var division_id, district_id, thana_id;
        division_id = document.getElementById('division_id').value;
        district_id = document.getElementById('district_id').value;
        thana_id = document.getElementById('thana_id').value;
        xmlhttp.open("GET","includes/infoOfficeFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
        xmlhttp.send();
    }
</script>
<?php 
if($_GET['action'] == 'viewCalendar'){
    $current_office_id = $_GET['officeId'];
    $current_office_name = $_GET['office_name'];
    //echo "Current_salestore_id = ".$current_office_id;
?>
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

        function prev_month() {
            return mktime(0, 0, 0, (CURRENT_MONTH_N == 1 ? 12 : CURRENT_MONTH_N - 1), (checkdate((CURRENT_MONTH_N == 1 ? 12 : CURRENT_MONTH_N - 1), CURRENT_DAY, (CURRENT_MONTH_N == 1 ? CURRENT_YEAR - 1 : CURRENT_YEAR)) ? CURRENT_DAY : 1), (CURRENT_MONTH_N == 1 ? CURRENT_YEAR - 1 : CURRENT_YEAR));
        }

        function next_month() {
            return mktime(0, 0, 0, (CURRENT_MONTH_N == 12 ? 1 : CURRENT_MONTH_N + 1), (checkdate((CURRENT_MONTH_N == 12 ? 1 : CURRENT_MONTH_N + 1), CURRENT_DAY, (CURRENT_MONTH_N == 12 ? CURRENT_YEAR + 1 : CURRENT_YEAR)) ? CURRENT_DAY : 1), (CURRENT_MONTH_N == 12 ? CURRENT_YEAR + 1 : CURRENT_YEAR));
        }
///
        function makeCalendar($current_office_id, $current_office_name) {
            echo '<table class ="cal_table" cellspacing="4" ><tr>';
            echo '<td colspan="7"><b>অফিস ('.$current_office_name.') ডে এন্ড অফ ডে</b></td></tr><tr>';
            echo '<td><a href="office_day_calendar.php?action=viewCalendar&officeId='.$current_office_id.'&office_name='.$current_office_name.'&date=' . PREV_MONTH . '" style="display:block;width:100%;height:100%;text-decoration:none;"><img src="images/left_back_2.png" style="display:block;width:100%;height:100%;text-decoration:none;"></img></a></td>';
            echo '<td colspan="5" style="text-align:center">' . CURRENT_MONTH_A . ' - ' . CURRENT_YEAR . '</td>';
            echo '<td><a href="office_day_calendar.php?action=viewCalendar&officeId='.$current_office_id.'&office_name='.$current_office_name.'&date=' . NEXT_MONTH . '" style="display:block;width:100%;height:100%;text-decoration:none;"><img src="images/right_back_2.png" style="display:block;width:100%;height:100%;text-decoration:none;"></img></a></td>';
            echo '</tr><tr bgcolor = #06ACE5>';
            echo '<td>রবি</td>';
            echo '<td>সোম</td>';
            echo '<td>মঙ্গল</td>';
            echo '<td>বুধ</td>';
            echo '<td>বৃহস্পতি</td>';
            echo '<td>শুক্র</td>';
            echo '<td>শনি</td>';
            echo '</tr><tr>';
            /// Weekly Holyday **************        
            /// Weekly Holyday **************        
            $WHdayValue = '';
            $WHdayValue2 = '';
            $weekly_holiday_row = 1;

            $row_number = 1;
            //$dayNumber = 0;
            $weekly_holiday_desc = "";
            $sql_WHday = "SELECT * from " . $dbname . ".weekly_holiday where office_type='office' And office_store_id='$current_office_id'";
            $rs_WHday = mysql_query($sql_WHday);
            while ($row_WHday = mysql_fetch_array($rs_WHday)) {
                $weekly_hd_value = $row_WHday['holiday_value'];
                $weekly_hd_serial = $row_WHday['holiday_serial'];
                $weekly_holiday_desc = $row_WHday['wh_description'];
                if($weekly_hd_serial==1){
                $WHdayValue = $weekly_hd_value;
                //$row_number = 2;
                }else{
                    $WHdayValue2 = $weekly_hd_value;
                    //$row_number = 1;
                }
            }
            if (empty($WHdayValue)){
                $WHdayValue = 101;
            }
            if (empty($WHdayValue2)){
                $WHdayValue2 = 101;
            }
            //echo "Current_salestore_id= ".$current_office_id." WHdayValue= ".$WHdayValue." WHdayValue2= ".$WHdayValue2;
            for ($i = 1; $i <= NUM_OF_DAYS + START_DAY; $i++) {
                if ($i > START_DAY) {
                    $monthDate = $i - START_DAY;
                    //echo $i.''.CURRENT_MONTH_N.''.CURRENT_YEAR;                    
                    $CurDate = CURRENT_YEAR . '-' . CURRENT_MONTH_N . '-' . $monthDate;
                    //echo $CurDate;
                    $colorValueHDay = '#F05656'; //dayValue
                    $colorValueOnDay = '#458F8E';
                    $SODayDesc = '';
                    $RGHDayDesc = '';
                    $specialOffDay = '';
                    $specialOnDay = '';
                    if (($i % $WHdayValue) == 0 OR ($i % $WHdayValue2) == 0) {
                        //*******Special Onday
                        $sql_SODay = "SELECT * from ".$dbname.".special_onday where spN_date = '$CurDate' And office_type='office' And office_store_id='$current_office_id'";
                        $rs_SODay = mysql_query($sql_SODay);
                        //echo "Rows from spOnday: ".mysql_num_rows($rs_SODay)."<br \>";
                        while ($row_SODay = mysql_fetch_array($rs_SODay)) {
                            $SODayDesc = $row_SODay['spN_description'];
                            $colorValueHDay = 'green';
                        }
                        if($SODayDesc!=""){
                            echo "<td bgcolor= '$colorValueHDay' class='tooltip_calender' title='$SODayDesc'>" . $monthDate . "</td>";
                        }else{
                        echo "<td bgcolor= '$colorValueHDay' class='tooltip_calender' title='$weekly_holiday_desc'>" . $monthDate . "</td>";                         
                        }
                        if (($i % $WHdayValue) == 0) {
                            $WHdayValue = $WHdayValue + 7;
                        }else{
                            $WHdayValue2 = $WHdayValue2 + 7;
                        }
                    } else {
                        //******************* RIPD & Government Holyday
                        $sql_RGHDay = "SELECT * from ".$dbname.".ripd_and_govt_holiday where rng_holiday_date = '$CurDate'";
                        $rs_RGHDay = mysql_query($sql_RGHDay);
                        while ($row_RGHDay = mysql_fetch_array($rs_RGHDay)) {
                            $RGHDayDesc = $row_RGHDay['rng_hd_description'];
                        }
                        if ($RGHDayDesc!="") {
                            $sql_spOnDay = "SELECT * from ".$dbname.".special_onday where spN_date = '$CurDate' And office_type='office' And office_store_id='$current_office_id'";
                            $rs_spOnDay = mysql_query($sql_spOnDay);

                            while ($row_spOnDay = mysql_fetch_array($rs_spOnDay)) {
                                $specialOnDay = $row_spOnDay['spN_description'];
                                $colorValueOnDay = 'green';
                            }
                            if ($specialOnDay!="") {
                                echo "<td bgcolor= '$colorValueOnDay' class='tooltip_calender' title='$specialOnDay'>" . $monthDate . "</td>";
                            } else {
                                echo "<td bgcolor= '$colorValueHDay' class='tooltip_calender' title='$RGHDayDesc'>" . $monthDate . "</td>";
                            }
                        } else {
                            $sql_spOffDay = "SELECT * from ".$dbname.".special_offday where sp_off_day_date = '$CurDate' And office_type='office' And office_store_id='$current_office_id'";
                            $rs_spOffDay = mysql_query($sql_spOffDay);
                            while ($row_spOffDay = mysql_fetch_array($rs_spOffDay)) {
                                $specialOffDay = $row_spOffDay['sp_off_day_description'];
                                $colorValueOnDay = 'yellow';
                            }
                            if($specialOffDay!=""){
                                echo "<td bgcolor= '$colorValueOnDay' class='tooltip_calender' title='$specialOffDay'>" . $monthDate . "</td>";
                            }else{
                                echo "<td bgcolor= '$colorValueOnDay'>" . $monthDate . "</td>";
                            }
                         }
                    }
                } else {
                    if (($i % $WHdayValue) == 0 OR ($i % $WHdayValue2) == 0) {
                        if (($i % $WHdayValue) == 0) {
                            $WHdayValue = $WHdayValue + 7;
                            echo "<td bgcolor= '#F05656'></td>";
                        }else{
                            $WHdayValue2 = $WHdayValue2 + 7;
                        echo "<td bgcolor= '#F05656'></td>";
                        }
                    }else{
                    echo "<td bgcolor= '#DBEAF9'></td>";
                    }
                }

                if ((($i) % COLUMNS) == 0 && $i != NUM_OF_DAYS + START_DAY) {
                    echo '</tr><tr>';
                    $row_number++;
                }
            }
            //echo "Row_number: ".$row_number."Column: ".COLUMNS." Num_of_day: ".NUM_OF_DAYS." Start_day: ".START_DAY;
            echo str_repeat('<td style="background-color: #DBEAF9">&nbsp;</td>', (COLUMNS * ($row_number)) - (NUM_OF_DAYS + START_DAY)) . '</tr></table>';
        }

    }

    $cal = new Calendar($_GET['date']);
    $cal->makeCalendar($current_office_id, $current_office_name);
    ?>
</div>
<?php 
}else{    
?>
<div class="page_header_div">
    <div class="page_header_title">অফিস ক্যালেন্ডার</div>
</div>
<fieldset id="award_fieldset_style">
    <div style="text-align: right;padding-right: 1%;margin-bottom: 5px;">
        <input type="hidden" id="method" value="infoFromThana()">
        সার্চ/খুঁজুন:<input type = "text" id ="search_box_filter"><br />
    </div>
    
    <span id="office">
        <div>
            <form method="POST" onsubmit="">
            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo "অফিস নং"; ?></th>
                        <th><?php echo "অফিস নেইম"; ?></th>
                        <th><?php echo "অফিস নম্বর"; ?></th>
                        <th><?php echo "ঠিকানা"; ?></th>
                        <th>ক্যালেন্ডার</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //officeTableHead();
                    $sql_officeTable = "SELECT * from ".$dbname.".office ORDER BY office_name ASC";
                    $db_officeNo = 0;
                    $rs = mysql_query($sql_officeTable);

                    //echo mysql_num_rows($rs);
                    while ($row_officeNcontact = mysql_fetch_array($rs)) {
                        $db_officeNo = $db_officeNo + 1;
                        $office_id = $row_officeNcontact['idOffice'];
                        $db_officeName = $row_officeNcontact['office_name'];
                        $db_officeNumber = $row_officeNcontact['office_number'];
                        $db_officeAddress = $row_officeNcontact['office_details_address'];
                        
                        echo "<tr>";
                        echo "<td>$db_officeNo</td>";
                        echo "<td>$db_officeName</td>";
                        echo "<td>$db_officeNumber</td>";                        
                        echo "<td>$db_officeAddress</td>";
                        echo "<td><a href='?action=viewCalendar&officeId=$office_id&office_name=$db_officeName'>ভিউ ক্যালেন্ডার</td>";                        
                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>      
            </form>
        </div>
    </span>          
</fieldset>

<script type="text/javascript">
    var filter = new DG.Filter({
        filterField : $('search_box_filter'),
        filterEl : $('office_info_filter')
    });
</script>
<?php 
}
include_once 'includes/footer.php';
?>