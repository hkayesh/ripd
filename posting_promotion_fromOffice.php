<?php
include_once 'includes/MiscFunctions.php';
include 'includes/header.php';
include_once './includes/selectQueryPDO.php';
?>
<style type="text/css">@import "css/bush.css";</style>
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
        xmlhttp.open("GET","includes/infoSetteleOfficeFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id,true);
        xmlhttp.send();
    }
</script>
 
    <?php if($_GET['iffimore'] != 'll1i1s0t01'){?>
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
        <div>
            <table  class='formstyle' style="width: 80%;">       
                <tr><th style='text-align: center;'>সকল অফিসের তালিকা</th></tr>
                <tr><td>
                    <div style="padding-bottom: 10px;">
                        <?php
                        include_once 'includes/areaSearch.php';
                        getArea("infoFromThana()");
                        ?>
                        <input type="hidden" id="method" value="infoFromThana()">
                        সার্চ/খুঁজুন:  <input type="text" id="search_box_filter">
                    </div>
                </td></tr>
                <tr><td>    
                    <span id="office">
                        <div>
                            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                                <thead>
                                    <tr id="table_row_odd" style="font-weight: bold">
                                        <td>অফিস নং</td>
                                        <td>অফিসের নাম</td>
                                        <td>অফিস নম্বর</td>
                                        <td>একাউন্ট নম্বর</td>
                                        <td>ব্রাঞ্চের নাম</td>
                                        <td>অফিসের ঠিকানা</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //officeTableHead();
                                    $sql_setteleOfficeTable = "SELECT * from office ORDER BY office_name ASC";
                                    $db_slNo = 0;
                                    $rs = mysql_query($sql_setteleOfficeTable);
                                    //echo mysql_num_rows($rs);
                                    while ($row_setteleOfficeTable = mysql_fetch_array($rs)) 
                                        {
                                        $db_slNo = $db_slNo + 1;
                                        $db_setteleOfficeID = $row_setteleOfficeTable['idOffice'];
                                        $db_setteleOfficeName = $row_setteleOfficeTable['office_name'];
                                        $db_setteleOfficeNumber = $row_setteleOfficeTable['office_number'];
                                        $db_setteleOfficeAN = $row_setteleOfficeTable['account_number'];
                                        $db_setteleOfficeBranch = $row_setteleOfficeTable['branch_name'];
                                        $db_setteleOfficeAddress = $row_setteleOfficeTable['office_details_address'];
                                        echo "<tr>";
                                        echo "<td>$db_slNo</td>";
                                        echo "<td>$db_setteleOfficeName</td>";
                                        echo "<td>$db_setteleOfficeNumber</td>";
                                        echo "<td>$db_setteleOfficeAN</td>";
                                        echo "<td>$db_setteleOfficeBranch</td>";
                                        echo "<td>$db_setteleOfficeAddress</td>";
                                        echo "<td><a href='posting_promotion_fromOffice.php?iffimore=ll1i1s0t01&offid=$db_setteleOfficeID'>কর্মচারীদের তালিকা</a></td>";
                                        echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>                        
                        </div>
                    </span> 
                </td></tr>                
            </table>
        </div>
    </div>       
    <script type="text/javascript">
        var filter = new DG.Filter({
            filterField : $('search_box_filter'),
            filterEl : $('office_info_filter')
        });
    </script>
    <?php     
            }
    else if ($_GET['iffimore']=='ll1i1s0t01')
            {
    ?>
        <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="posting_promotion_fromOffice.php"><b>ফিরে যান</b></a></div>
        <div>
            <?php
           $get_office_id = $_GET['offid'];
           $sql_select_office->execute(array($get_office_id));
           $arr_off = $sql_select_office->fetchAll();
           foreach ($arr_off as $row) {
               $office_name = $row['office_name'];
           }
            echo "<table  class='formstyle' style='width: 80%;'>";          
                echo "<tr><th colspan='10' style='text-align: center;font-size:18px;'>$office_name - এ কর্মচারীদের তালিকা</th></tr>";
                echo "<tr align='left' id='table_row_odd'>
                    <td><b>ক্রম</b></td>
                    <td><b>কর্মচারীদের নাম</b></td>
                    <td><b>একাউন্ট নাম্বার</b></td>
                    <td><b>গ্রেড</b></td>
                    <td><b>গ্রেডের স্থায়িত্বকাল</b></td>
                    <td><b>দায়িত্ব</b></td>
                    <td><b>অফিসে সময়কাল</b></td>
                    <td colspan='3'></td>
                </tr>";
                $sel_office_employee->execute(array($get_office_id));
                $row1 = $sel_office_employee->fetchAll();
                $sl = 1;
                foreach ($row1 as $emprow)
                {
                    $empID = $emprow['idEmployee'];
                    $timestamp=time(); //current timestamp
                    $sql_select_employee_grade->execute(array($empID));
                    $graderow = $sql_select_employee_grade->fetchAll();
                    foreach ($graderow as $arr_grade) {
                        $db_gradeInsertDate = $arr_grade['insert_date'];
                        $db_gradename = $arr_grade['grade_name'];      
                    }
                  
                    $start = date_create($db_gradeInsertDate);
                    $interval1 = date_diff(date_create(), $start);
                    $grdyears = english2bangla($interval1->format('%Y'));
                    $grdmonths2 = english2bangla($interval1->format('%M'));
                    $grddays = english2bangla($interval1->format('%d'));
                    
                    $sql_select_view_emp_post->execute(array($empID,$get_office_id));
                    $result = $sql_select_view_emp_post->fetchAll();
                    foreach ($result as $arr_row) {
                        $db_post = $arr_row['post_name'];
                        $db_postingDate = $arr_row['posting_date'];
                    }
//                                           
                        $datetime1 = date_create($db_postingDate);
                        $interval = date_diff(date_create(), $datetime1);
                        $years = english2bangla($interval->format('%Y'));
                        $months2 = english2bangla($interval->format('%M'));
                        $days = english2bangla($interval->format('%d'));
                    echo "<tr>
                        <td>".english2bangla($sl)."</td>
                        <td>".$emprow['account_name']."</td>
                        <td>".$emprow['account_number']."</td>
                        <td>".$db_gradename."</td>
                        <td>$grdyears বছর, $grdmonths2 মাস, $grddays দিন</td>
                        <td>$db_post</td>
                        <td>$years বছর, $months2 মাস, $days দিন</td>
                        <td><a href='posting_to.php?0to1o1ff01i0c1e0=$empID&bkprnt=posting_promotion_fromOffice.php?iffimore=ll1i1s0t01%%offid=$get_office_id'>পোস্টিং করুন</a></td>
                        <td><a href='promotion_to.php?0to1o1ff01i0c1e0=$empID&bkprnt=posting_promotion_fromOffice.php?iffimore=ll1i1s0t01%%offid=$get_office_id'>প্রোমোশন করুন</a></td>
                        <td><a href='postingNpromotion.php?0to1o1ff01i0c1e0=$empID&bkprnt=posting_promotion_fromOffice.php?iffimore=ll1i1s0t01%%offid=$get_office_id'>পোস্টিং এন্ড প্রোমোশন</a></td>
                    </tr>"; // give the user id in the the place of $get_office_id
                    $sl++;
                }
            echo "</table>";
            ?>
        </div>
    </div>
    <?php
            }
    ?>
<?php
include 'includes/footer.php';?>
