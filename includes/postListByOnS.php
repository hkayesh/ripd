<?php
include_once './ConnectDB.inc';
include_once './MiscFunctions.php';
$g_str =$_GET['typeNid'];
$arr_str = explode(",", $g_str);
$type = $arr_str[0];
$id = $arr_str[1];

$result = mysql_query("SELECT * FROM post, post_in_ons WHERE post_onsid = $id AND post_onstype='$type'
                                     AND Post_idPost=idPost ORDER BY post_name ");
    while ($row = mysql_fetch_assoc($result))
    {
        $db_postname=$row["post_name"];
        $db_postno=$row["number_of_post"];
        $db_freepost = $row['free_post'];
        $db_postingID = $row['idpostinons'];
        echo '<tr>';
        echo '<td  style="border: solid black 1px;"><div align="left">'.$db_postname.'</div></td>';
        echo '<td  style="border: solid black 1px;"><div align="left">&nbsp;&nbsp;&nbsp;'.english2bangla($db_postno).'</div></td>';
        echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($db_freepost).'</div></td>';
        if($db_freepost > 0)
        {
            echo '<td style="border: solid black 1px;"><input type="checkbox" name="OnSCheck" value='.$db_postingID.' /></td>';
        }
        else {echo '<td style="border: solid black 1px;"></td>' ;}
        echo '</tr>';
    }
?>
