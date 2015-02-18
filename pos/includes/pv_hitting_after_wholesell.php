<?php
include_once 'ConnectDB.inc';

function pv_hitting($profitless, $cust_type, $sumID,$selling_type,$total_profit)
{
    $sel_current_command = mysql_query("SELECT idcommand FROM command LEFT JOIN running_command 
                                                                    ON command.commandno = running_command.commandno");
    $rowcommand = mysql_fetch_assoc($sel_current_command);
    $commandID = $rowcommand['idcommand'];
    if($cust_type == 'unregcustomer')
    {
                $type = 'no_acc';

                $G_s_type = $_SESSION['loggedInOfficeType'];
                $sel_pv_view = mysql_query("SELECT * FROM view_pv_view WHERE cust_type = '$type' AND sales_type= '$selling_type' AND store_type='$G_s_type' AND account_type_id= 0 AND idcommand = $commandID");
            
                while($row = mysql_fetch_assoc($sel_pv_view)) {
                    $less = $row['less_amount'];
                    $pnh_outside = $row['patent_nh'];
                    $se = $row['selling_earn'];
                    $ri = $row['pv_ripd_income'];
                    $office = $row['office'];
                    $staff = $row['staff'];
                    $shariah = $row['shariah'];
                    $charity = $row['charity'];
                    $presentation = $row['presentation'];
                    $training = $row['training'];
                    $program = $row['program'];
                    $travel = $row['travel'];
                    $patent = $row['patent'];
                    $leadership = $row['leadership'];
                    $transport = $row['transport'];
                    $research = $row['research'];
                    $server = $row['server'];
                    $bag = $row['bag'];
                    $brochure = $row['brochure'];
                    $form = $row['form'];
                    $moneyrcpt = $row['money_receipt'];
                    $pad = $row['pad'];
                    $box = $row['box'];
                    $extra = $row['extra'];
                }
                // calculate hitting amount *************************************8
                $office_hit = ($total_profit * $office) / 100;
                $staff_hit = ($total_profit * $staff) / 100;
                $shariah_hit = ($total_profit * $shariah) / 100;
                $charity_hit = ($total_profit * $charity) / 100;
                $presentation_hit = ($total_profit * $presentation) / 100;
                $training_hit = ($total_profit * $training) / 100;
                $program_hit = ($total_profit * $program) / 100;
                $travel_hit = ($total_profit * $travel) / 100;
                $patent_hit = ($total_profit * $patent) / 100;
                $leadership_hit = ($total_profit * $leadership) / 100;
                $transport_hit = ($total_profit * $transport) / 100;
                $research_hit = ($total_profit * $research) / 100;
                $server_hit = ($total_profit * $server) / 100;
                $bag_hit = ($total_profit * $bag) / 100;
                $brochure_hit = ($total_profit * $brochure) / 100;
                $form_hit = ($total_profit * $form) / 100;
                $moneyrcpt_hit = ($total_profit * $moneyrcpt) / 100;
                $pad_hit = ($total_profit * $pad) / 100;
                $box_hit = ($total_profit * $box) / 100;
                $extra_hit = ($total_profit * $extra) / 100;
                $arr_softcost = array('SOF'=>$office_hit,'SWO'=>$staff_hit,'SSC'=>$shariah_hit,'SCR'=>$charity_hit,'SPR'=>$presentation_hit,'STR'=>$training_hit,'SPG'=>$program_hit,'STL'=>$travel_hit,'SLD'=>$leadership_hit,'SJT'=>$transport_hit,'SGR'=>$research_hit,'SSV'=>$server_hit,'SBG'=>$bag_hit,'SBR'=>$brochure_hit,'SFR'=>$form_hit,'SMR'=>$moneyrcpt_hit,'SPD'=>$pad_hit,'SBX'=>$box_hit,'SER'=>$extra_hit,'SPT'=>$patent_hit);
                
                mysql_query("START TRANSACTION");
                $total_softcost = 0;
                    foreach ($arr_softcost as $key => $value) {
                   $sql2 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $value, last_update = NOW() WHERE fund_code = '$key' ");
                   $total_softcost =$total_softcost+$value;
               }
               $less_hit = (($total_profit * $less) /100) - $profitless;
               $se_hit = (($total_profit * $se) / 100) + $less_hit;
               $ri_hit = ($total_profit * $ri) / 100;
               $spo_hit =  ($total_profit * $pnh_outside) / 100;
               $sql3 = mysql_query("INSERT INTO sales_customer_hitting (selling_earn,soft_costing,ripd_income,pn_outside,sales_summery_idsalessummery) 
                                                    VALUES($se_hit,$total_softcost,$ri_hit,$spo_hit,$sumID)");
               
               if($sql2 && $sql3)
                {
                     mysql_query("COMMIT");
                     $flag = 1;
                }
               else {
                    mysql_query("ROLLBACK");
                    $flag = 0;
                }
    }
    
  return $flag;
}

?>
