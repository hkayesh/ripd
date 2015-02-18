<?php
error_reporting(0);
include_once 'includes/header.php';
include_once 'includes/selectQueryPDO.php';
include_once 'includes/ConnectDB.inc';
?>
<title>বেতনের জন্য কর্মচারী লিস্ট</title>
<style type="text/css">@import "css/style.css";</style>
<div class="column6">
    <div class="main_text_box">      
        <div style="padding-left: 110px;">
            <a href="hr_employee_management.php"><b>ফিরে যান</b></a></br>
            <div style="border: 1px solid grey;">
                <table  style=" width: 100%; margin-bottom: 10px;" > 
                    <tr><th style="text-align: center; background-image: radial-gradient(circle farthest-corner at center top , #FFFFFF 0%, #0883FF 100%);height: 45px;padding-bottom: 5px;padding-top: 5px;" colspan="2" ><h1>কর্মচারীর লিস্ট</h1></th></tr>
                </table>
                <fieldset id="fieldset_style" style=" width: 90% !important; margin-left: 30px !important;" >
                    <span id="office">
                        <br/><br />
                        <div>
                            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                                <thead>
                                    <tr align="left" id="table_row_odd">
                                        <td>কর্মচারীর নাম</td>
                                        <td>একাউন্ট</td>
                                        <td>মোবাইল</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php
                                    $office_id = $_SESSION['loggedInOfficeID'];
                                    $office_type = $_SESSION['loggedInOfficeType'];
                                    $sql_select_id_ons_relation->execute(array($office_type, $office_id));
                                    $id_ons = $sql_select_id_ons_relation->fetchAll();
                                    foreach ($id_ons as $row){
                                        $db_idons_relation = $row['idons_relation'];
                                    }
                                    $rs = mysql_query("SELECT * FROM cfs_user WHERE  	cfs_account_status = 'active' AND idUser = ANY(SELECT cfs_user_idUser FROM employee  WHERE emp_ons_id = '$db_idons_relation');");

                                    while ($rowemployee = mysql_fetch_assoc($rs)) 
                                    {  
                                         $db_user_id = $rowemployee['idUser'];
                                         $db_mobile =  english2bangla($rowemployee['mobile']);
                                         $db_empaccount = $rowemployee['account_number'];
                                        $db_empname = $rowemployee['account_name'];
                                       ?>
                                       <tr align="left" id="table_row_odd">
                                           <td><?php echo $db_empname;?></td>
                                        <td><?php echo $db_empaccount;?></td>
                                        <td><?php echo $db_mobile;?></td>
                                        <td><a href="salary_given_statement.php?id='<?php echo $db_user_id?>'">সেলারি স্টেটমেন্ট</a></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>                        
                        </div>
                    </span>          
                </fieldset>
            </div>
        </div>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>