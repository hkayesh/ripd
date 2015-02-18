<?php
include_once 'includes/header.php';
include_once 'includes/showTables.php';
include_once 'includes/selectQueryPDO.php';
?>
<style type="text/css">
a { 
	display:block;
	text-decoration: none;
/* add cursor:default; to this rule to disable the hand cursor */
}

a:hover{ /* don't move this positioning to normal state */
 	position:relative;
}

span img {
        width: 720px;
        height: 360px;
}

a span {  /* this is for the large image and the caption */
	position: absolute;
	display:none;
	background-color: #000000;
	padding: 5px 5px 5px 5px;
}

img { /* leave or IE puts a border around links */
border-width: 0;
}

a:hover span { 
	display:block;
	bottom: -100px; /* means the pop-up's top is 50px away from thumb's top */
	right: 10px; /* means the pop-up's left is 90px far from the thumb's left */
	z-index: 1;
	
/* If you want the pop-up open to the left of thumb, remove the left: 90px; and add  
right: 90px; This would mean the right side of the pop-up is 90px far from the right side of thumb */	

/* If you want the pop-up open above the thumb, remove the top: 50px; and add  
bottom: 50px; This would mean the bottom of the pop-up is 50px far from the bottom of thumb */	

/* add cursor:default; to this rule to disable the hand cursor only for the large image */
}

.resize_thumb {
	width: 70px; /* enter desired thumb width here */
	height : 22px;
            alignment-adjust: central;
}

/* smart image enlarger ends here */
</style>
<script type="text/javascript" src="javascripts/external/mootools.js"></script>
<script type="text/javascript" src="javascripts/dg-filter.js"></script>

<div class="page_header_div">
    <div class="page_header_title">এওয়ার্ডসমূহ</div>
</div>
<fieldset id="award_fieldset_style">
    <div style="text-align: right;padding-right: 1%;margin-bottom: 5px;">সার্চ/খুঁজুন:<input type = "text" id ="search_box_filter"><br /></div>
    <span id="office">
        <div>
            <table id="office_info_filter" border="1" align="center" width= 99%" cellpadding="5px" cellspacing="0px">                    
                <thead>
                    <tr align="left" id="table_row_odd">
                        <th><?php echo "ক্রম"; ?></th>
                        <th><?php echo "এওয়ার্ড নাম"; ?></th>
                        <th><?php echo "প্রদানকারীর নাম"; ?></th>
                        <th><?php echo "এওয়ার্ড বর্ণনা"; ?></th>
                        <th><?php echo "তারিখ"; ?></th>
                        <th><?php echo "এওয়ার্ড গ্রহণকারী"; ?></th>
                        <th><?php echo "এওয়ার্ড ছবি"; ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    //use pdo
                    $db_slNo = 0;
                    $sql_select_award_all->execute();
                    $arr_awd = $sql_select_award_all->fetchAll();
                    foreach ($arr_awd as $row_awards) {
                        $db_slNo = $db_slNo + 1;
                        $serial = english2bangla($db_slNo);
                        $db_awd_name = $row_awards['awd_name'];
                        $db_awd_provider_name = $row_awards['awd_provider_name'];
                        $db_awd_description = $row_awards['awd_description'];
                        $db_awd_date = english2bangla($row_awards['awd_date']);
                        $db_awd_image = $row_awards['awd_image'];
                        $db_awd_receivers_name = $row_awards['awd_receivers_name'];
                        
                        echo "<tr>";
                        echo "<td>$serial</td>";
                        echo "<td>$db_awd_name</td>";
                        echo "<td>$db_awd_provider_name</td>";
                        echo "<td>$db_awd_description</td>";
                        echo "<td>$db_awd_date</td>";
                        echo "<td>$db_awd_receivers_name</td>";
                        echo '<td><a href=""><img src="'.$db_awd_image.'" alt="No Image" class="resize_thumb" /><span>
                        <img src="'.$db_awd_image.'" alt="No Image"/><br />
                        </span></a></td>';
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
        filterField : $('search_box_filter'),
        filterEl : $('office_info_filter')
        //colIndexes : [0,2]
    });
</script>
<?php
include_once 'includes/footer.php';
?>
            

