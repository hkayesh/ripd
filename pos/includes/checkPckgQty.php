<?php
$check= 0;
$G_left = $_GET['leftstr'];
$G_ri8 = $_GET['ri8str'];
$G_pckgQty = $_GET['pckgqty'];
$arr_left = explode('/', $G_left);
$arr_ri8 = explode('/', $G_ri8);
foreach($arr_left as $key => $value) 
    {
        $arr_left[$key] = $value*$G_pckgQty;
    }
$count = count($arr_left);
for($j=0; $j<$count; $j++)
     {
          if( $arr_ri8[$j] < $arr_left[$j])
            {
                $check =1;break;
             }
      }
if($check ==1)
{
    echo 1;
}
else
{
    echo 0;
}
?>
