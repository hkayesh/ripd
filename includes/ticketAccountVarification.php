<?php
if(isset($_GET['code']))
{
    $g_code = $_GET['code'];
    if($g_code == '12345')
    {
        echo "ok";
    }
    else
    {echo "";}
}
?>
