<?php
error_reporting(0);
include_once 'includes/MiscFunctions.php';
include_once 'includes/header.php';
$logedinOfficeId = $_SESSION['loggedInOfficeID'];
$logedinOfficeType=$_SESSION['loggedInOfficeType'];
?>
<style type="text/css">@import "css/bush.css";</style>
<style type="text/css">
#search {
    width: 50px;background-color: #009933;border: 2px solid #0077D5;cursor: pointer; color: wheat;
}
#search:hover {
    background-color: #0077D5;border: 2px inset #009933;color: wheat;
}
</style>
<link rel="stylesheet" href="css/tinybox.css" type="text/css" />
<script src="javascripts/tinybox.js" type="text/javascript"></script>
<script type="text/javascript">
 function details(id,month,year)
{   TINY.box.show({url:'includes/salary_details.php?onsID='+id+'&month='+month+'&year='+year,width:800,height:550,opacity:30,topsplit:3,animate:true,close:true,maskid:'bluemask',maskopacity:50,boxid:'success'}); }
 </script>
 
<div class="main_text_box">
    <div style="padding-left: 110px;"><a href="hr_employee_management.php"><b>ফিরে যান</b></a></div>
    <div>
        <table  class='formstyle' style="width: 80%;">       
            <tr><th style='text-align: center;'>সকল অফিসের তালিকা</th></tr>
            <tr>                        
                <td>
                        <fieldset style="border: #686c70 solid 3px;width: 60%;margin-left:20%;">
                            <legend style="color: brown">সার্চ</legend>
                            <form method="POST"  name="frm" action="">	
                            <table>
                                <tr>
                                    <td >মাস </td>
                                    <td >
                                        <select style="border: 1px solid black" name="month">
                                            <option value="0">-সিলেক্ট করুন-</option>
                                            <option value="1">জানুয়ারী</option>
                                            <option value="2">ফেব্রুয়ারী</option>
                                            <option value="3">মার্চ</option>
                                            <option value="4">এপ্রিল</option>
                                            <option value="5">মে</option>
                                            <option value="6">জুন</option>
                                            <option value="7">জুলাই</option>
                                            <option value="8">আগস্ট</option>
                                            <option value="9">সেপেম্বর</option>
                                            <option value="10">অক্টোবর</option>
                                            <option value="11">নভেম্বর</option>
                                            <option value="12">ডিসেম্বর</option>
                                        </select>
                                    </td>
                                    <td >বছর</td>
                                    <td ><select class="box" style="width: 70px;" name="year">
                                            <option value="0">-বছর-</option>
                                            <?php
                                                $thisYear = date('Y');
                                                $startYear = '2000';
                                                foreach (range($thisYear, $startYear) as $year) {
                                                echo '<option value='.$year.'>'. $year .'</option>'; }
                                            ?>
                                        </select>
                                    </td>
                                    <td><input id="search" type="submit" name="submit" value="দেখুন" /></td>
                                </tr>
                            </table>
                            </form>
                        </fieldset>
                    </td>
            </tr>
            <tr><td>    
                <span id="office">
                    <div>
                        <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                            <thead>
                                <?php
                                     if(isset($_POST['submit']))
                                        {
                                            $p_month = $_POST['month'];;
                                            $p_year = $_POST['year'];
                                            $monthName = date("F", mktime(0, 0, 0, $p_month, 10));
                                        }
                                ?>
                                <tr id="table_row_odd" style="font-weight: bold"><td colspan="7" style="text-align: center;border: 1px solid black;"><?php echo $monthName." ,",$p_year;?></td></tr>
                                <tr id="table_row_odd" style="font-weight: bold">
                                    <td style="border: 1px solid black;">ক্রম</td>
                                    <td style="border: 1px solid black;">অফিস / সেলসস্টোর</td>
                                    <td style="border: 1px solid black;">নাম</td>
                                    <td style="border: 1px solid black;">অফিস নম্বর</td>
                                    <td style="border: 1px solid black;"> ঠিকানা</td>
                                    <td style="border: 1px solid black;">মোট বেতন (টাকা)</td>
                                    <td style="border: 1px solid black;"></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($_POST['submit']))
                                {
                                    $db_slNo = 1;
                                    if($logedinOfficeType == 'office')
                                    {
                                        $rs = mysql_query("SELECT * FROM office WHERE idOffice= $logedinOfficeId OR parent_id= $logedinOfficeId ORDER BY office_name ASC");
                                        while ($row_officeTable = mysql_fetch_array($rs)) 
                                            {
                                            $db_setteleOfficeID = $row_officeTable['idOffice'];
                                            $db_setteleOfficeName = $row_officeTable['office_name'];
                                            $db_setteleOfficeNumber = $row_officeTable['office_number'];
                                            $db_setteleOfficeAddress = $row_officeTable['office_details_address'];
                                            $sel_office_salary = mysql_query("SELECT total_month_salary, idons_relation FROM salary_approval LEFT JOIN ons_relation ON salapp_onsid = idons_relation
                                                   WHERE add_ons_id= $db_setteleOfficeID AND catagory ='office' AND month_no=$p_month AND year_no =$p_year AND salary_approver_id != 0");
                                            $off_sal_row = mysql_fetch_assoc($sel_office_salary);
                                            $ons_id = $off_sal_row['idons_relation'];
                                            echo "<tr>";
                                            echo "<td>".english2bangla($db_slNo)."</td>";
                                            echo "<td>অফিস</td>";
                                            echo "<td>$db_setteleOfficeName</td>";
                                            echo "<td>$db_setteleOfficeNumber</td>";
                                            echo "<td>$db_setteleOfficeAddress</td>";
                                            echo "<td>".english2bangla($off_sal_row['total_month_salary'])."</td>";
                                            echo '<td><a onclick="details('.$ons_id.','.$p_month.','.$p_year.')" style="cursor:pointer;color:blue;"><u>বিস্তারিত<u></a></td>';
                                            echo "</tr>";
                                            $db_slNo++;
                                            }
                                    }
                                    else
                                        {
                                            $rs2 = mysql_query("SELECT * FROM sales_store WHERE idSales_store= $logedinOfficeId ORDER BY salesStore_name ASC");
                                            while ($row_salestoreTable = mysql_fetch_array($rs2)) 
                                                {
                                                $db_storeID = $row_salestoreTable['idSales_store'];
                                                $db_storeName = $row_salestoreTable['salesStore_name'];
                                                $db_storeNumber = $row_salestoreTable['salesStore_number'];
                                                $db_storeAddress = $row_salestoreTable['salesStore_details_address'];
                                                $sel_office_salary = mysql_query("SELECT total_month_salary, idons_relation FROM salary_approval LEFT JOIN ons_relation ON salapp_onsid = idons_relation
                                                                                                       WHERE add_ons_id= $db_storeID AND catagory ='s_store' 
                                                                                                       AND month_no=$p_month AND year_no =$p_year AND salary_approver_id != 0");
                                                $off_sal_row = mysql_fetch_assoc($sel_office_salary);
                                                $ons_id = $off_sal_row['idons_relation'];
                                                echo "<tr>";
                                                echo "<td>".english2bangla($db_slNo)."</td>";
                                                echo "<td>সেলসস্টোর</td>";
                                                echo "<td>$db_storeName</td>";
                                                echo "<td>$db_storeNumber</td>";
                                                echo "<td>$db_storeAddress</td>";
                                                echo "<td>".english2bangla($off_sal_row['total_month_salary'])."</td>";
                                                echo '<td><a onclick="details('.$ons_id.','.$p_month.','.$p_year.')" style="cursor:pointer;color:blue;"><u>বিস্তারিত<u></a></td>';
                                                echo "</tr>";
                                                $db_slNo++;
                                            }
                                    }
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
<?php include 'includes/footer.php';?>
