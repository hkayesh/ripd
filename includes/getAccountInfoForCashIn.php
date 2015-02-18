<?php
include_once './connectionPDO.php';
if($_GET['type'] == 'personal')
{
    $g_accountNo = $_GET['acNo'];
    $sel_cfs_user = $conn->prepare("SELECT * FROM cfs_user WHERE account_number= ? AND cfs_account_status='active' ");
    $sel_cfs_user->execute(array($g_accountNo));
    $row = $sel_cfs_user->fetchAll();
    $countrow = count($row);
    if($countrow == 0)
    {
        echo "<font style='color:red'>দুঃখিত, এই একাউন্ট নাম্বারটি সঠিক নয়</font>";
    }
     else {
        foreach ($row as $value) {
            echo '<table>
                        <tr>
                            <td style="padding-left: 8px !important;width:29.5%;">একাউন্টধারীর নাম<input type="hidden" name="acID" value="'.$value['idUser'].'" /></td>
                            <td>: <input class="box" type="text" id="acName" name="acName" readonly="" value="'.$value['account_name'].'" /></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 8px !important;">মোবাইল নাম্বার</td>
                            <td>: <input class="box" type="text" id="mobile" name="mobile" readonly="" value="'.$value['mobile'].'" /></td>
                        </tr>
                    </table>';
        }
    }
}
elseif ($_GET['type'] == 'office') {
    $g_accountNo = $_GET['acNo'];
        $sel_office = $conn->prepare("SELECT * FROM office WHERE office_selection='ripd' AND account_number= ?");
        $sel_office->execute(array($g_accountNo));
        $row = $sel_office->fetchAll();
        $countrow = count($row);
            if($countrow == 0)
            {
                echo "<font style='color:red'>দুঃখিত, এই একাউন্ট নাম্বারটি সঠিক নয়</font>";
            }
             else {
                foreach ($row as $value) 
                    {
                         echo ": <input class='box' type='text' readonly value='".$value['office_name']."' />";
                     }
             }
}

?>
