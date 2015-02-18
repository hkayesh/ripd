<?php
include_once 'connectionPDO.php';

//command option insert BASIC
$sql_insert_command = $conn->prepare("INSERT into command (commandno, command_desc, pv_value) VALUES (?, ?, ?)");    

//award
$sql_insert_award = $conn->prepare("INSERT into ripd_award (awd_name, awd_provider_name, awd_description,
                                       awd_date, awd_image, awd_receivers_type, awd_receivers_name, cfs_user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");    

//soft costing command for a particular command
$columns_scc = array('command_idcommand', 'store_selling_earn', 'direct_sales_cust', 'office', 'staff', 'shariah', 'charity', 'presentation', 'training', 'program', 
                                            'travel', 'patent', 'leadership', 'transport', 'research', 'server', 'bag', 'brochure', 'form', 'money_receipt', 'pad', 'box', 'extra');
$column_list_scc = join(',', $columns_scc);
$param_list_scc = join(',', array_map(function($col_scc) { return ":$col_scc"; }, $columns_scc));
$sql_insert_soft_cost_command = $conn->prepare("INSERT into pv_softcost ($column_list_scc) VALUES ($param_list_scc)");

//PV hitting customer for different package and command
$columns_hitting_customer = array('command_idcommand', 'Account_type_idAccount_type', 'Rone', 'Rtwo', 'Rthree', 'Rfour', 'Rfive', 'pv_ripd_income');
$column_list_hitting_cust = join(',', $columns_hitting_customer);
$param_list_hitting_cust = join(',', array_map(function($col_hcc) { return ":$col_hcc"; }, $columns_hitting_customer));
$sql_insert_hitting_customer_command = $conn->prepare("INSERT into pv_hitting_customer ($column_list_hitting_cust) VALUES ($param_list_hitting_cust)");

//PV hitting unregistered customer for different sales store and sales type
$columns_unreg_customer = array('command_idcommand', 'sales_type', 'store_type', 'less_amount', 'selling_earn', 'patent_nh', 'ripd_income');
$column_list_unreg_cust = join(',', $columns_unreg_customer);
$param_list_unreg_cust = join(',', array_map(function($col_ucc) { return ":$col_ucc"; }, $columns_unreg_customer));
$sql_insert_unreg_customer_command = $conn->prepare("INSERT into pv_unregistered_customer ($column_list_unreg_cust) VALUES ($param_list_unreg_cust)");

//command execution
$sql_insert_curr_command = $conn->prepare("INSERT into command_execution (commandno, com_start_date) VALUES (?, NOW())");
// send and transfer amount ************************************************
$sql_insert_acc_user_amount_transfer = $conn->prepare("INSERT into acc_user_amount_transfer (trans_type, trans_senderid, trans_receiverid, receiver_mobile_num, trans_amount, reciever_get, trans_servicecharge, trans_purpose, chrg_givenby, total_transaction, send_amt_status, send_amt_pin, trans_date_time) 
                                                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, NOW())");

//**************** posting & promotion ***********************************************************
$sql_insert_employee_posting = $conn->prepare("INSERT INTO employee_posting (posting_date, Employee_idEmployee, ons_relation_idons_relation, post_in_ons_idpostinons)
                                                                                VALUES(?, ?, ?, ?) ");
$sql_insert_employee_salary = $conn->prepare("INSERT INTO employee_salary (total_salary, insert_date,loan_next, loan_repay_month,fk_idloan,user_id, pay_grade_idpaygrade)
                                                                               VALUES(?, NOW(), ?,?,?,?, ?) ");

//**************** cheque making ***********************************************************
$sql_insert_cheque_making = $conn->prepare("INSERT INTO acc_user_cheque (cheque_num, cheque_type, cheque_description, cheque_mak_datetime, cheque_amount, cheque_makerid, cheque_status)
                                                                                VALUES(?, ?, ?, NOW(), ?, ?, ?) ");
// ************************************* employee salary give ***************************************************************************
$insert_sal_approval = $conn->prepare("INSERT INTO salary_approval (total_month_salary, month_no,year_no,salapp_onsid,salary_makerid,salary_making_date)
        VALUES (?,?,?, ?, ?, NOW())");
$insert_sal_chart = $conn->prepare("INSERT INTO salary_chart (month_no,year_no,actual_salary,pension_amount,loan_amount,given_amount,deducted_amount,bonus_amount,total_given_amount,user_id,salary_status,fk_sal_aprv_salappid)
        VALUES (?, ?, ?,?,?,?, ?, ?, ?, ?, 'made', ?)");
$insert_notification = $conn->prepare("INSERT INTO notification (nfc_senderid,nfc_receiverid,nfc_message,nfc_actionurl,nfc_date,nfc_status, nfc_type, nfc_catagory) 
                                                            VALUES (?,?,?,?,NOW(),?,?,?)");

?>
