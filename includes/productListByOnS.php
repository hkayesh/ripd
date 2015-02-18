<?php
include_once './ConnectDB.inc';
$g_str =$_GET['typeNid'];
$arr_str = explode(",", $g_str);
$type = $arr_str[0];
$id = $arr_str[1];

echo "<table style='width: 96%;margin: 0 auto;' cellspacing='0' cellpadding='0'>
                                            <thead>
                                          <tr id='table_row_odd'>
                                              <td width='11%' style='border: solid black 1px;'><div align='center'><strong>ক্রমিক নং</strong></div></td>
                                            <td width='20%'  style='border: solid black 1px;'><div align='center'><strong>প্রোডাক্ট কোড</strong></div></td>
                                            <td width='30%'  style='border: solid black 1px;'><div align='center'><strong>প্রোডাক্ট-এর নাম</strong></div></td>
                                            <td width='11%'  style='border: solid black 1px;'><div align='center'><strong>মূল্য (টাকা)</strong></div></td>
                                          </tr>
                                          </thead>
                                          <tbody style='background-color: #FCFEFE'>";
                                        
                                                        $slNo = 1;
                                                        $result = mysql_query("SELECT * FROM inventory 
                                                                WHERE ins_ons_id = $id AND ins_ons_type='$type' AND ins_product_type='general' ORDER BY ins_productname ");
                                                        
                                                            while ($row = mysql_fetch_assoc($result))
                                                            {
                                                                $db_proname=$row["ins_productname"];
                                                                $db_procode=$row["ins_product_code"];
                                                                $db_sellingprice = $row['ins_sellingprice'];
                                                                echo '<tr>';
                                                                echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($slNo).'</div></td>';
                                                                echo '<td  style="border: solid black 1px;"><div align="left">'.$db_procode.'</div></td>';
                                                                  echo '<td  style="border: solid black 1px;"><div align="left">&nbsp;&nbsp;&nbsp;'.$db_proname.'</div></td>';
                                                                  echo '<td  style="border: solid black 1px;"><div align="center">'.english2bangla($db_sellingprice).'</div>
                                                                      <input type="hidden" id="invStr" value='.$g_str.' /></td>';
                                                                  echo '</tr>';
                                                                  $slNo++;
                                                            }
       echo " </tbody></table>";
?>
