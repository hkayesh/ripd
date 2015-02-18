<?php
include_once 'getSelectedThana.php';
include_once './MiscFunctions.php';
$arrayEmpStatus = array('posting' => 'কর্মচারী', 'contract' => 'চুক্তিবদ্ধ');
                $joinArray = implode(',', $arr_thanaID);
                $type = $_GET['type'];
                $programType = getTypeFromWho($type);
                $sql_list = "SELECT * FROM cfs_user, employee, address, thana, district, division WHERE idUser=employee.cfs_user_idUser 
                             AND employee.employee_type='$type' AND adrs_cepng_id= idEmployee 
                            AND address_type='Present' AND address_whom='emp' 
                             AND Thana_idThana=idThana AND idThana IN ($joinArray) AND idDistrict= District_idDistrict AND idDivision=Division_idDivision ";
                $db_result_presenter_info = mysql_query($sql_list); //Saves the query of Presenter Infromation
                while ($row_prstn = mysql_fetch_array($db_result_presenter_info)) {
                    $db_rl_presenter_name = $row_prstn['account_name'];
                    $db_rl_presenter_acc = $row_prstn['account_number'];
                    $db_rl_presenter_mobile = $row_prstn['mobile'];
                    $db_rl_presenter_email = $row_prstn['email'];
                    $db_rl_presenter_id = $row_prstn['idEmployee'];
                    $db_rl_presenter_status = $row_prstn['status'];
                    $db_thana = $row_prstn['thana_name'];
                    $db_district = $row_prstn['district_name'];
                    $db_division = $row_prstn['division_name'];
                    echo "<tr>
                        <td >$db_rl_presenter_name</td>
                        <td>$db_rl_presenter_acc</td>
                        <td>$db_rl_presenter_mobile</td>
                        <td>$db_rl_presenter_email</td>
                        <td> $arrayEmpStatus[$db_rl_presenter_status]</td>    
                        <td>$db_thana</td>
                        <td>$db_district</td>
                        <td>$db_division</td>
                        <td style='text-align: center ' ><a href='presentation_schdule_combined.php?action=sedule&id=".$db_rl_presenter_id."&type=".$programType."'>সিডিউল </a></td>  
                    </tr>";
                }
?>