<?php
include_once 'includes/header.php';
?>
<script type="text/javascript" src="javascripts/area.js"></script>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="javascripts/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="javascripts/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    window.onclick = function()
    {
        new JsDatePick({
            useMode:2,
            target:"date_from",
            dateFormat:"%Y-%m-%d"
        });
    };
    window.onload = function()
    {
        new JsDatePick({
            useMode:2,
            target:"date_to",
            dateFormat:"%Y-%m-%d"
        });
    };
</script>
<script type="text/javascript">
function infoPresentationFromThana()
{
    var xmlhttp;
    if (window.XMLHttpRequest) xmlhttp=new XMLHttpRequest();
    else xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) 
            document.getElementById('office').innerHTML=xmlhttp.responseText;
    }
    var division_id, district_id, thana_id, date_from, date_to;
    division_id = document.getElementById('division_id').value;
    district_id = document.getElementById('district_id').value;
    thana_id = document.getElementById('thana_id').value;
    date_from = document.getElementById('date_from').value;
    date_to = document.getElementById('date_to').value;
    xmlhttp.open("GET","includes/infoProgramFromThana.php?dsd="+district_id+"&dvd="+division_id+"&ttid="+thana_id+"&df="+date_from+"&dt="+date_to+"&type=presentation",true);
    xmlhttp.send();
}
</script>
<div class="page_header_div"><div class="page_header_title">প্রেজেন্টেশন সিডিউল</div></div>
<fieldset id="award_fieldset_style">
    <div style="float: left;">
        <?php
        include_once('includes/areaSearch.php');
        getArea("infoPresentationFromThana()");
        ?>
    </div>
    <div style="float: right; margin-right: 10px;">        
        <input type="hidden" id="method" value="infoPresentationFromThana()">
        সার্চ/খুঁজুন:  <input type = "text" id ="search_box_filter">
    </div>    

    <div style="float: left; padding-bottom: 10px;padding-top: 10px; margin-left: 0px;">
        <b>শুরুর তারিখঃ</b><input type="text" name="date_from" id="date_from" placeholder="Date From"  style="">&nbsp;&nbsp;
        <b>শেষের তারিখঃ</b> <input type="text" name="date_to" id="date_to" placeholder="Date To">
        <input type="hidden" id="method" value="infoPresentationFromThana()">
        <input type="button" onclick="infoPresentationFromThana()" value="সাবমিট">
    </div>

    <span id="office">
        <div class="presen_pro_training_travel_table">
            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo "প্রেজেন্টেশন নাম"; ?></th>                   
                        <th><?php echo "লোকেশন"; ?></th>
                        <th><?php echo "বিষয়" ?></th>
                        <th><?php echo "তারিখ"; ?></th>
                        <th><?php echo "সময়"; ?></th>
                        <th><?php echo "উপস্থাপক"; ?></th>      
                        <th><?php echo "অফিস নাম"; ?></th>
                        <th><?php echo "অফিস ঠিকানা"; ?></th>       
                    </tr>
                </thead>
                <tbody>
                    <?php
                $sql_programTable = "SELECT * FROM program,office WHERE program_type = 'presentation'
                                                    AND Office_idOffice = idOffice
                                                    AND program_date BETWEEN CURDATE() AND '2099-12-31' ORDER BY program_date ASC";
                $db_slNo = 0;
                $rs = mysql_query($sql_programTable);
                while ($row = mysql_fetch_array($rs)) {
                    $db_slNo = $db_slNo + 1;
                    $db_programId = $row['idprogram'];
                    $db_programName = $row['program_name'];
                    $db_programLocation = $row['program_location'];
                    $db_programDate = $row['program_date'];
                    $db_programTime = $row['program_time'];           
                    $db_programSubject = $row['subject'];
                    $db_office_name = $row['office_name'];
                    $db_office_address = $row['office_details_address'];
                    $demonastrators = '';
                    $sql_demonastrators_name = "SELECT * FROM presenter_list, employee, cfs_user WHERE fk_idprogram = '$db_programId' AND fk_Employee_idEmployee = idEmployee AND cfs_user_idUser = idUser";
                    $row_demonastrators_name = mysql_query($sql_demonastrators_name);
                    while ($row_names = mysql_fetch_array($row_demonastrators_name)){
                        $db_demons_name = $row_names['account_name'];
                        $demonastrators = $db_demons_name.", ".$demonastrators;
                    }
                    echo "<tr>";
                    echo "<td>$db_programName</td>";
                    echo "<td>$db_programLocation</td>";
                    echo "<td>$db_programSubject</td>";
                    echo "<td>".english2bangla(date("d/m/Y",  strtotime($db_programDate)))."</td>";
                    echo "<td>".english2bangla(date('g:i a' , strtotime($db_programTime)))."</td>";
                    echo "<td>$demonastrators</td>";
                    echo "<td>$db_office_name</td>";
                    echo "<td>$db_office_address</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>                        
        </div>
    </span>          
</fieldset>

<script type="text/javascript">
    var filter = new DG.Filter({
//        filterField : $('search_box_filter'),
//        filterEl : $('office_info_filter')
    });
</script>

<?php
include_once 'includes/footer.php';
?>
