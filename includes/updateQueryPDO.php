<?php
include_once 'connectionPDO.php';
$sql_update_prev_command = $conn->prepare("UPDATE command_execution SET com_end_date=NOW() WHERE commandno=? ORDER BY idcommandexec DESC LIMIT 1");
$sql_update_account_block = $conn->prepare("UPDATE cfs_user SET blocked='1' WHERE user_name=?");
$sql_update_password = $conn->prepare("UPDATE cfs_user SET password=? WHERE idUser=?");
$sql_update_command = $conn->prepare("UPDATE command SET commandno=?, command_desc=?, pv_value=? WHERE idcommand=?");
$sql_update_award = $conn->prepare("UPDATE ripd_award SET awd_name=?, awd_provider_name=?, awd_description=?, 
                                                                awd_date=?, awd_image=?, awd_receivers_type=?, awd_receivers_name=?, cfs_user_id=? 
                                                               WHERE idaward=?");
// ************************** posting & promotion *************************************************
$sql_update_post_in_ons_up = $conn->prepare("UPDATE post_in_ons SET free_post = (free_post+1), used_post=(used_post-1)
                                                                                WHERE  idpostinons=?");
$sql_update_post_in_ons_down = $conn->prepare("UPDATE post_in_ons SET free_post = (free_post-1), used_post=(used_post+1)
                                                                                    WHERE  idpostinons=?");
$sql_update_cheque = $conn->prepare("UPDATE acc_user_cheque SET postpond_reason = ?, cheque_status = ?, cheque_update_datetime = NOW(), cheque_updated_userid = ?, chqupd_officeid = ?
                                                                                    WHERE  cheque_num = ?");
// *********************************** salary ****************************************************************
$sql_update_sal_approval = $conn->prepare("UPDATE salary_approval SET total_month_salary=?, salary_approver_id=?,
                                                                        salary_approved_date=NOW() WHERE salappid=?");
$sql_update_salary_chart = $conn->prepare("UPDATE salary_chart SET deducted_amount=?, bonus_amount=?, total_given_amount=?,
                                                                        salary_status='paid' WHERE fk_sal_aprv_salappid=? AND user_id=? ");
// *********************************** notification *******************************************************
$sql_update_notification = $conn->prepare("UPDATE notification SET nfc_status=? WHERE idnotification=? ");
?>
