<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
if (isset($_GET['id'])) {
    $g_custid = $_GET['id'];
    $custAcid = base64_decode($g_custid);
    
    $sel_customer = mysql_query("SELECT * FROM customer_account, cfs_user,address, village, post_office, thana, district, division
                                                      WHERE address_whom = 'cust' AND village_idvillage= idvillage AND post_office_idPost_office =idPost_office
                                                      AND post_office.Thana_idThana = idThana AND District_idDistrict = idDistrict
                                                      AND Division_idDivision = idDivision
                                                      AND adrs_cepng_id = idCustomer_account AND idCustomer_account = $custAcid 
                                                      AND cfs_user_idUser = idUser");
    while ($custrow = mysql_fetch_assoc($sel_customer)) {
        $db_custname = $custrow['account_name'];
        $db_custacc = $custrow['account_number'];
        $db_custmobile = $custrow['mobile'];
        $db_custripdemail = $custrow['ripd_email'];
        $db_custAccOpenDate = $custrow['account_open_date'];
        $db_custImage = $custrow['scanDoc_picture'];
        $db_custOpeningPin = $custrow['opening_pin_no'];
        $db_custReferer = $custrow['referer_id'];
        $sel_referer = mysql_query("SELECT account_name FROM cfs_user WHERE idUser = $db_custReferer");
        $referer_row = mysql_fetch_assoc($sel_referer);
        $refere_name = $referer_row['account_name'];
        $db_addressType = $custrow['address_type'];
        if($db_addressType == 'Present') //  present address
        {
            $db_prhouse = $custrow['house'];
            $db_prhouseno = $custrow['house_no'];
            $db_prroad = $custrow['road'];
            $db_prvilg = $custrow['village_name'];
            $db_prpost = $custrow['post_offc_name'];
            $db_prthana = $custrow['thana_name'];
            $db_prdistrict = $custrow['district_name'];
            $db_prdiv = $custrow['division_name'];
        }
        //permanent address
        else 
        {
            $db_phouse = $custrow['house'];
            $db_phouseno = $custrow['house_no'];
            $db_proad = $custrow['road'];
            $db_pvilg = $custrow['village_name'];
            $db_ppost = $custrow['post_offc_name'];
            $db_pthana = $custrow['thana_name'];
            $db_pdistrict = $custrow['district_name'];
            $db_pdiv = $custrow['division_name'];
        }
    }
    
}
    ?>
    <style type="text/css"> @import "css/bush.css";</style>
    <script type="text/javascript" src="javascripts/area.js"></script>
    <script type="text/javascript">
        function custInfoFromArea()
        {
            var xmlhttp;
            if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
            else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) 
                    document.getElementById('customer_list').innerHTML=xmlhttp.responseText;
            }
            var division_id, district_id, thana_id,post_id,village_id;
            division_id = document.getElementById('division_id').value;
            district_id = document.getElementById('district_id').value;
            thana_id = document.getElementById('thana_id').value;
            post_id = document.getElementById('post_id').value;
            village_id = document.getElementById('vilg_id').value;
            xmlhttp.open("GET","includes/updateCustFromArea.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id+"&pid="+post_id+"&vid="+village_id,true);
            xmlhttp.send();
        }
    </script>
    <?php if (isset($_GET['id'])) {?>
    <div class="main_text_box">
        <div style="padding-left: 110px;"><a href="customer_list.php"><b>ফিরে যান</b></a></div>
        <div>
            <form  enctype="multipart/form-data">	
                <table  class="formstyle" style="font-family: SolaimanLipi !important;width: 80%;">          
                    <tr><th colspan="2" style="text-align: center;font-size: 18px;">কাস্টমারের পরিচিতি</th></tr>
                    <tr>
                        <td colspan="2" style=" text-align: right; padding-left: 10px !important; margin: 0px">
                            <table>
                                <tr>
                                    <td ><b>কাস্টমারের নাম :</b></td>
                                    <td >: <?php echo $db_custname ?></td>
                                    <td colspan="2" style="padding-right: 0px;text-align: center;" rowspan="4"> 
                                        <img src="<?php echo $db_custImage; ?>" width="128px" height="128px" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <td ><b>একাউন্ট নাম্বার </b></td>
                                    <td>: <?php echo $db_custacc ?></td>
                                </tr>
                                <tr>
                                    <td ><b>মোবাইল </b></td>
                                    <td >: <?php echo $db_custmobile ?></td>
                                </tr>
                                <tr>
                                    <td ><b>ইমেল </b></td>
                                    <td >: <?php echo $db_custripdemail ?></td>
                                </tr>
                                <tr>
                                    <td ><b>একাউন্ট খোলার তারিখ</b></td>
                                    <td >: <?php echo english2bangla(date("d/m/Y",  strtotime($db_custAccOpenDate))); ?></td>
                                </tr>
                                <tr>
                                    <td ><b>পিন নং </b></td>
                                    <td >: <?php echo $db_custOpeningPin ?></td>
                                </tr>
                                <tr>
                                    <td ><b>রেফারারের নাম</b></td>
                                    <td >: <?php echo $refere_name ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-size: 16px;"><b>বর্তমান ঠিকানা</b></td>
                                </tr>
                                <tr>
                                    <td colspan="4" ><hr /></td>
                                </tr>
                                <tr>
                                    <td ><b>ঠিকানা</b></td>
                                    <td >: <?php echo "বাসা- ".$db_prhouse.", ".$db_prhouseno.", রোড-".$db_prroad; ?></td>
                                    <td ><b>গ্রাম/ পাড়া / প্রোজেক্ট</b></td>
                                    <td >: <?php echo $db_prvilg ?></td>
                                </tr>
                                <tr>
                                    <td ><b>পোস্টঅফিস</b></td>
                                    <td >: <?php echo $db_prpost ?></td>
                                    <td ><b>থানা</b></td>
                                    <td >: <?php echo $db_prthana ?></td>
                                </tr>
                                <tr>
                                    <td ><b>জেলা</b></td>
                                    <td >: <?php echo $db_prdistrict ?></td>
                                    <td ><b>বিভাগ</b></td>
                                    <td >: <?php echo $db_prdiv; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-size: 16px;"><b>স্থায়ী ঠিকানা</b></td>
                                </tr>
                                <tr>
                                    <td colspan="4" ><hr /></td>
                                </tr>
                                <tr>
                                    <td ><b>ঠিকানা</b></td>
                                    <td >: <?php echo "বাসা- ".$db_phouse.", ".$db_phouseno.", রোড-".$db_proad; ?></td>
                                    <td ><b>গ্রাম/ পাড়া / প্রোজেক্ট</b></td>
                                    <td >: <?php echo $db_pvilg ?></td>
                                </tr>
                                <tr>
                                    <td ><b>পোস্টঅফিস</b></td>
                                    <td >: <?php echo $db_ppost ?></td>
                                    <td ><b>থানা</b></td>
                                    <td >: <?php echo $db_pthana ?></td>
                                </tr>
                                <tr>
                                    <td ><b>জেলা</b></td>
                                    <td >: <?php echo $db_pdistrict ?></td>
                                    <td ><b>বিভাগ</b></td>
                                    <td >: <?php echo $db_pdiv ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>  
                </table>
            </form>
        </div>           
    </div>
<?php } else { ?>
    
    <div class="main_text_box">      
        <div style="padding-left: 10px;">
            <a href="crm_management.php"><b>ফিরে যান</b></a></br>
                <div style="border: 1px solid grey;width: 100%">
                    <table  style=" width: 99%; margin-bottom: 10px;margin-left: 2px;" > 
                        <tr><th style="text-align: center; background-image: radial-gradient(circle farthest-corner at center top , #FFFFFF 0%, #0883FF 100%);height: 45px;padding-bottom: 5px;padding-top: 5px;" colspan="2" ><h1>কাস্টমারের তালিকা</h1></th></tr>
                        <tr>
                            <td></br>
                            <?php
                                include_once 'includes/areaSearchForCustomer.php';
                                getArea("custInfoFromArea()");
                                ?>
                                <input type="hidden" id="method" value="custInfoFromArea()" />
                            </td>
                    </tr>
                    <tr>
                        <td><br/>
                        <table cellpadding="3px" cellspacing="0px" style="margin-left: 2px;width: 99%;">
                                <thead>
                                    <tr id="table_row_odd">
                                        <td style="border: 1px solid black;text-align: center;"><b>কাস্টমারের নাম</b></td>
                                        <td style="border: 1px solid black;text-align: center;"><b>একাউন্ট নং</b></td>
                                        <td style="border: 1px solid black;text-align: center;"><b>মোবাইল</b></td>
                                        <td style="border: 1px solid black;text-align: center;"><b>থানা</b></td>
                                        <td style="border: 1px solid black;text-align: center;"><b>পোস্টঅফিস</b></td>
                                        <td style="border: 1px solid black;text-align: center;"><b>গ্রাম</b></td>
                                        <td style="border: 1px solid black;text-align: center;"></td>
                                    </tr>
                                </thead>
                                <tbody id="customer_list">   
                                    <?php
                                     $sql_officeTable = "SELECT * FROM cfs_user,customer_account WHERE  cfs_user_idUser=idUser AND user_type='customer' ORDER BY account_name ASC";
                                        $rs = mysql_query($sql_officeTable);
                                            while ($row_officeNcontact = mysql_fetch_array($rs)) {
                                            $db_Name = $row_officeNcontact['account_name'];
                                            $db_accNumber = $row_officeNcontact['account_number'];
                                            $db_email = $row_officeNcontact['email'];
                                            $db_mobile = $row_officeNcontact['mobile'];
                                            $db_custID = $row_officeNcontact['idCustomer_account'];
                                            $sql_custAddrss = mysql_query("SELECT * FROM address,thana,post_office,village WHERE  idThana=address.Thana_idThana AND address_whom='cust' 
                                                                                                AND address_type='Permanent' AND adrs_cepng_id= $db_custID
                                                                                                AND post_idpost = idPost_office AND village_idvillage = idvillage");
                                            $addressrow = mysql_fetch_assoc($sql_custAddrss);
                                            $db_thana = $addressrow['thana_name'];
                                            $db_post= $addressrow['post_offc_name'];
                                            $db_village = $addressrow['village_name'];
                                            echo "<tr style='border: 1px solid #969797;'>";
                                            echo "<td style='border: 1px solid #969797;'>$db_Name</td>";
                                            echo "<td style='border: 1px solid #969797;'>$db_accNumber</td>";
                                            echo "<td style='border: 1px solid #969797;'>$db_mobile</td>";
                                            echo "<td style='border: 1px solid #969797;'>$db_thana</td>";
                                            echo "<td style='border: 1px solid #969797;'>$db_post</td>";
                                            echo "<td style='border: 1px solid #969797;'>$db_village</td>";
                                                $v = base64_encode($db_custID);
                                            echo "<td style='border: 1px solid black;'><a href='customer_list.php?id=$v'>বিস্তারিত</a></td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>                        
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php
}
include_once 'includes/footer.php';
?>