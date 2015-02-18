<?php
include_once 'ConnectDB.inc';

function pv_hitting($custID, $cust_type, $sumID,$selling_type,$total_profit)
{
    $sel_current_command = mysql_query("SELECT idcommand FROM command LEFT JOIN running_command 
                                                                    ON command.commandno = running_command.commandno");
    $rowcommand = mysql_fetch_assoc($sel_current_command);
    $commandID = $rowcommand['idcommand'];
    if($cust_type == 'customer')
    {
        $type = 'account';
    }
    else 
        { $type = 'no_acc'; }
      
    if($type == 'account')
    {
        // select referers *************************************
        $sel_referer = mysql_query("SELECT * FROM view_usertree WHERE ut_customerid = $custID");
        while($row = mysql_fetch_assoc($sel_referer)) {
            $one = $row['ut_first_parentid'];
            $two = $row['ut_second_parentid'];
            $three = $row['ut_third_parentid'];
            $four = $row['ut_fourth_parentid'];
            $five = $row['ut_fifth_parentid'];
        }
        // select customer pkg ******************************
        $sel_cust_pkg = mysql_query("SELECT Account_type_idAccount_type FROM customer_account WHERE cfs_user_idUser = $custID");
        while($row = mysql_fetch_assoc($sel_cust_pkg)) {
            $pkgtype = $row['Account_type_idAccount_type'];
        }
    
    // select view pv view **************************
     $sel_pv_view = mysql_query("SELECT * FROM view_pv_view WHERE cust_type = '$type' AND sales_type= '$selling_type' AND store_type='both' AND account_type_id=$pkgtype AND idcommand = $commandID");
    while($row = mysql_fetch_assoc($sel_pv_view)) {
            $se = $row['selling_earn'];
            $ri = $row['pv_ripd_income'];
            $direct_sales = $row['direct_sales_cust'];
            $Rone = $row['Rone'];
            $Rtwo = $row['Rtwo'];
            $Rthree = $row['Rthree'];
            $Rfour = $row['Rfour'];
            $Rfive = $row['Rfive'];
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
        
        $total_softcost = 0;
        $borkot = 0;
        mysql_query("START TRANSACTION");
        if($one != 0)
        {
            $one_hit = ($total_profit * $Rone) / 100;
            $sql1 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $one_hit, total_balanace = total_balanace + $one_hit WHERE cfs_user_iduser = $one ");
            $sql5 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $one_hit, last_update = NOW() WHERE fund_code = 'RHC'");
            $sel_child_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $one AND date = CURDATE() ");
            if(mysql_num_rows($sel_child_row)> 0)
            {
               $sql6 = mysql_query("UPDATE cust_pv_child_date SET cust_c1 = cust_c1+$one_hit WHERE cust_own_id = $one AND date = CURDATE() ");
            }
            else
                {
                    $sql6 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_c1,date) VALUES ($one,$one_hit,NOW())");
                }
        }
        else { $borkot = $borkot + (($total_profit * $Rone) / 100); $one_hit = 0; $sql1=1; $sql5=1; $sql6 =1;}
        
        if($two != 0)
        {
            $two_hit = ($total_profit * $Rtwo) / 100;
            $sql1=mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $two_hit, total_balanace = total_balanace + $two_hit WHERE cfs_user_iduser = $two ");
            $sql5 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $two_hit, last_update = NOW() WHERE fund_code = 'RHC'");
            $sel_child_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $two AND date = CURDATE()");
            if(mysql_num_rows($sel_child_row)> 0)
            {
               $sql6 = mysql_query("UPDATE cust_pv_child_date SET cust_c2 = cust_c2+$two_hit WHERE cust_own_id = $two AND date = CURDATE()");
            }
            else
                {
                    $sql6 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_c2,date) VALUES ($two,$two_hit,NOW())");
                }
        }
        else { $borkot = $borkot + (($total_profit * $Rtwo) / 100); $two_hit = 0;  }
        
        if($three != 0)
        {
            $three_hit = ($total_profit * $Rthree) / 100;
            $sql1 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $three_hit, total_balanace = total_balanace + $three_hit WHERE cfs_user_iduser = $three ");
            $sql5 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $three_hit, last_update = NOW() WHERE fund_code = 'RHC'");
            $sel_child_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $three AND date = CURDATE()");
            if(mysql_num_rows($sel_child_row)> 0)
            {
               $sql6 = mysql_query("UPDATE cust_pv_child_date SET cust_c3 = cust_c3+$three_hit WHERE cust_own_id = $three AND date = CURDATE()");
            }
            else
                {
                    $sql6 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_c3,date) VALUES ($three,$three_hit,NOW())");
                }
        }
        else { $borkot = $borkot + (($total_profit * $Rthree) / 100); $three_hit = 0;  }
        if($four != 0)
        {
            $four_hit = ($total_profit * $Rfour) / 100;
            $sql1 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $four_hit, total_balanace = total_balanace + $four_hit WHERE cfs_user_iduser = $four ");
            $sql5 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $four_hit, last_update = NOW() WHERE fund_code = 'RHC'");
            $sel_child_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $four AND date = CURDATE()");
            if(mysql_num_rows($sel_child_row)> 0)
            {
               $sql6 = mysql_query("UPDATE cust_pv_child_date SET cust_c4 = cust_c4+$four_hit WHERE cust_own_id = $four AND date = CURDATE()");
            }
            else
                {
                    $sql6 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_c4,date) VALUES ($four,$four_hit,NOW())");
                }
        }
        else { $borkot = $borkot + (($total_profit * $Rfour) / 100); $four_hit = 0;  }
        if($five != 0)
        {
            $five_hit = ($total_profit * $Rfive) / 100;
            $sql1 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $five_hit, total_balanace = total_balanace + $five_hit WHERE cfs_user_iduser = $five ");
            $sql5 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $five_hit, last_update = NOW() WHERE fund_code = 'RHC'");
            $sel_child_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $five AND date = CURDATE()");
            if(mysql_num_rows($sel_child_row)> 0)
            {
               $sql6 = mysql_query("UPDATE cust_pv_child_date SET cust_c5 = cust_c5+$five_hit WHERE cust_own_id = $five AND date = CURDATE()");
            }
            else
                {
                    $sql6 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_c5,date) VALUES ($five,$five_hit,NOW())");
                }
        }
        else { $borkot = $borkot + (($total_profit * $Rfive) / 100); $five_hit = 0;  }
        
            // calculate total soft cost ****************************     
           foreach ($arr_softcost as $key => $value) {
               $sql2 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $value, last_update = NOW() WHERE fund_code = '$key' ");
               $total_softcost =$total_softcost+$value;
           }
           $se_hit = ($total_profit * $se) / 100;
           $ri_hit = ($total_profit * $ri) / 100;
           $own_hit = ($total_profit * $direct_sales) / 100;
           
           $sel_own_row = mysql_query("SELECT * FROM cust_pv_child_date WHERE cust_own_id = $custID AND date = CURDATE()");
            if(mysql_num_rows($sel_own_row)> 0)
            {
               $sql7 = mysql_query("UPDATE cust_pv_child_date SET cust_own_pv = cust_own_pv+$own_hit WHERE cust_own_id = $custID AND date = CURDATE()");
            }
            else
                {
                    $sql7 = mysql_query("INSERT INTO cust_pv_child_date (cust_own_id,cust_own_pv,date) VALUES ($custID,$own_hit,NOW())");
                }

           $sql4 = mysql_query("UPDATE acc_user_balance SET pv_balance = pv_balance + $own_hit, total_balanace = total_balanace + $own_hit WHERE cfs_user_iduser = $custID ");
           $sql8 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $own_hit, last_update = NOW() WHERE fund_code = 'RHC'");

           $sql3 = mysql_query("INSERT INTO sales_customer_hitting (selling_earn,soft_costing,own,Rone,Rtwo,Rthree,Rfour,Rfive,ripd_income,borkot,sales_summery_idsalessummery) 
                                             VALUES($se_hit,$total_softcost,$own_hit,$one_hit,$two_hit,$three_hit,$four_hit,$five_hit,$ri_hit,$borkot,$sumID)") or exit(mysql_error());

           if($sql1 && $sql2 && $sql3 && $sql4 && $sql5 && $sql6 && $sql7 && $sql8)
           {
                mysql_query("COMMIT");
                $flag = 1;
           }
          else {
               mysql_query("ROLLBACK");
               $flag = 0;
           }
    }
    
 else 
     {
                $G_s_type = $_SESSION['loggedInOfficeType'];
                $sel_pv_view = mysql_query("SELECT * FROM view_pv_view WHERE cust_type = '$type' AND sales_type= '$selling_type' AND store_type='$G_s_type' AND account_type_id= 0 AND idcommand = $commandID");
            
                while($row = mysql_fetch_assoc($sel_pv_view)) {
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
               $se_hit = ($total_profit * $se) / 100;
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

function pin_pv_hitting($sumID,$total_profit,$pin)
{
    $sel_current_command = mysql_query("SELECT idcommand FROM command LEFT JOIN running_command 
                                                                    ON command.commandno = running_command.commandno");
    $rowcommand = mysql_fetch_assoc($sel_current_command);
    $commandID = $rowcommand['idcommand'];
    $type = 'account';

     // select customer pkg ******************************
        $sel_cust_pkg = mysql_query("SELECT Account_type_idAccount_type FROM customer_account WHERE cfs_user_idUser = $custID");
        while($row = mysql_fetch_assoc($sel_cust_pkg)) {
            $pkgtype = $row['Account_type_idAccount_type'];
        }
    
    // select view pv view **************************
     $sel_pv_view = mysql_query("SELECT * FROM view_pv_view WHERE cust_type = '$type' AND sales_type= '$selling_type' AND store_type='both' AND account_type_id=$pkgtype AND idcommand = $commandID");
        while($row = mysql_fetch_assoc($sel_pv_view)) {
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
        // calculate hitting amount **********************************
        
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
        
        $total_softcost = 0;
        mysql_query("START TRANSACTION");
        
        // calculate total soft cost ****************************     
           foreach ($arr_softcost as $key => $value) {
               $sql2 = mysql_query("UPDATE main_fund SET fund_amount = fund_amount + $value, last_update = NOW() WHERE fund_code = '$key' ");
               $total_softcost =$total_softcost+$value;
           }
           $se_hit = ($total_profit * $se) / 100;
           $ri_hit = ($total_profit * $ri) / 100;
           
           $sql3 = mysql_query("INSERT INTO sales_customer_hitting (selling_earn,soft_costing,ripd_income,sales_summery_idsalessummery) 
                                             VALUES($se_hit,$total_softcost,$ri_hit,$sumID)");
           
           $sql_pin = mysql_query("SELECT * FROM pin_makingused WHERE  pin_no = '$pin'");
                if(mysql_num_rows($sql_pin) == 1)
                { 
                    $up_sql = mysql_query("UPDATE pin_makingused SET pin_total_profit = $total_profit, sales_summery_idsalessummery = $sumeryid "); 
                }

           if($sql2 && $sql3 && $up_sql)
           {
                mysql_query("COMMIT");
                $flag = 1;
           }
          else {
               mysql_query("ROLLBACK");
               $flag = 0;
           }
           return $flag;
}

?>