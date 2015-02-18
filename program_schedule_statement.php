<?php
//include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';

$loginUSERname = $_SESSION['acc_holder_name'] ;
$logedInUser = $_SESSION['userIDUser'];
$logedInUserType = $_SESSION['userType'];
$type = getTypeFromWho($logedInUserType);
$typeinbangla= getProgramType($type);
$whoinbangla = getProgramer2($logedInUserType);
?>
<style type="text/css"> @import "css/bush.css";</style>

    <div class="main_text_box" style="width: 100% !important;">
        <div style="padding-left: 50px;"><a href="personal_official_profile_employee.php"><b>ফিরে যান</b></a></div>
          <div>
           <form method="POST"  name="frm" action="">	
               <table  class="formstyle" style="width: 90% !important; font-family: SolaimanLipi !important;margin:0 auto !important;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 20px;">চলতি এবং আপ-কামিং <?php echo $typeinbangla;?></th></tr>
                    <tr><td colspan="13" style="color: sienna; text-align: center; font-size: 20px;"><b><?php echo $loginUSERname;?></b></td></tr>
                    <tr>
                    <td colspan="2">
                        <table align="center" style="border: black solid 1px !important; border-collapse: collapse;">
                                    <thead>                                     
                                        <tr id="table_row_odd">
                                        <td style='border: 1px solid #000099; text-align: center;font-weight: bold;' >তারিখ</td>
                                        <td style='border: 1px solid #000099;text-align: center;font-weight: bold;' ><?php echo $typeinbangla;?>-এর নাম</td>
                                        <td style='border: 1px solid #000099;text-align: center;font-weight: bold;'>অফিস</td>
                                        <td style='border: 1px solid #000099;text-align: center;font-weight: bold;'>ভেন্যু</td>
                                        <td style='border: 1px solid #000099;text-align: center;font-weight: bold;'>সময়</td>
                                        <td style='border: 1px solid #000099;text-align: center;font-weight: bold;'><?php echo $whoinbangla;?>-এর লিস্ট</td>
                                        </tr>
                                    </thead>
                                <tbody style="font-size: 12px !important">
                                    <?php 
                                            $rs = mysql_query("SELECT * FROM program,office WHERE program_type = '$type'
                                                                            AND Office_idOffice = idOffice
                                                                            AND program_date BETWEEN CURDATE() AND '2099-12-31' 
                                                                            AND idprogram= ANY(SELECT fk_idprogram FROM presenter_list, employee
                                                                                                         WHERE fk_Employee_idEmployee = idEmployee AND cfs_user_idUser = $logedInUser) 
                                                                            ORDER BY program_date ASC");
                                            while ($row = mysql_fetch_array($rs)) {
                                                $db_programId = $row['idprogram'];
                                                $db_programName = $row['program_name'];
                                                $db_programLocation = $row['program_location'];
                                                $db_programDate = $row['program_date'];
                                                $db_programTime = $row['program_time'];           
                                                $db_programSubject = $row['subject'];
                                                $db_office_name = $row['office_name'];
                                                $db_office_address = $row['office_details_address'];
                                                $demonastrators = '';
                                                $sql_demonastrators_name = "SELECT * FROM presenter_list, employee, cfs_user WHERE fk_idprogram = '$db_programId' 
                                                                                                  AND fk_Employee_idEmployee = idEmployee AND cfs_user_idUser = idUser";
                                                $row_demonastrators_name = mysql_query($sql_demonastrators_name);
                                                while ($row_names = mysql_fetch_array($row_demonastrators_name)){
                                                    $db_demons_name = $row_names['account_name'];
                                                    $demonastrators = $db_demons_name.", ".$demonastrators;
                                                }
                                                echo "<tr>";
                                                echo "<td style='border:1px solid black;'>".english2bangla(date("d/m/Y",  strtotime($db_programDate)))."</td>";
                                                echo "<td style='border:1px solid black;'>$db_programName</td>";
                                                echo "<td style='border:1px solid black;'>$db_office_name</td>";
                                                echo "<td style='border:1px solid black;'>$db_programLocation</td>";                                             
                                                echo "<td style='border:1px solid black;'>".english2bangla(date('g:i a' , strtotime($db_programTime)))."</td>";
                                                echo "<td style='border:1px solid black;'>$demonastrators</td>";
                                                echo "</tr>";
                                            }
                                      ?>
                                </tbody>
                            </table>
                       </td>
                    </tr>
                </table>
            </form>
        </div>                 
    </div>
    <?php include_once 'includes/footer.php';?>