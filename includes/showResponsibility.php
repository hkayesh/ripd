<?php
error_reporting(0);
include_once 'ConnectDB.inc';

$selected_post_id = $_GET['post_id'];
if($selected_post_id=="new_post"){
    echo '<tr><td style="padding-left: 0px;width:48%;">পোস্ট-এর নাম</td>
                        <td style="padding-left: 4px;">:   <input class="box" type="text" id="post_name" name="post_name" value=""/></td>                                  
                    </tr>
                    <tr>
                        <td style="padding-left: 0px;width:48%;">পোস্টের দায়িত্ব</td>
                        <td style="padding-left: 2px;">  <textarea id="responsibility" name="responsibility"  style="width: 70%;"></textarea></td></tr>';
    
}elseif ($selected_post_id>0) {
    $selected_post_responsibility_query = "SELECT responsibility_desc FROM post WHERE idPost='$selected_post_id'";
    $selected_post_responsibility = mysql_query($selected_post_responsibility_query);
    $responsibility_result = mysql_fetch_assoc($selected_post_responsibility); 
        $db_response = $responsibility_result['responsibility_desc'];
          echo '<tr><td style="padding-left: 0px;width:48%;">পোস্টের দায়িত্ব</td>
                        <td style="padding-left: 2px;"> <textarea id="responsibility" name="responsibility" style="width: 70%;" readonly="">'.$db_response.'</textarea></td></tr>';                  
    
}
?>