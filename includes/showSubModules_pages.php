<?php

/*
 * This page will be included in every module pages to show sub modules and their pages
 */

//$module_page_name = basename($_SERVER["SCRIPT_NAME"]);
$module_page_name = $current_page_name;
//echo "changedPath Pos : ".$_SESSION['changedPathPos'];
//$subModuleArray = $_SESSION['modSubModPageArray'][$module_id];
foreach ($_SESSION['modSubModPageArray'][$module_page_name] as $key => $value) {
    //$module_value = $value;
    $submodule_key = $key;
    $loopValue = 0;
    echo '<tr><th style="text-align: center" colspan="2"><h1>' . $_SESSION['subModuleArray'][$submodule_key] . '</h1></th></tr><tr>';
    //echo "subModule Key = " . $submodule_key . " subModule Name = " . $submoduleArrayList[$submodule_key] . "<br/>";
    //$subModulePages = $_SESSION['modSubModPageArray'][$module_id][$submodule_key];
    foreach ($_SESSION['modSubModPageArray'][$module_page_name][$submodule_key] as $key2 => $value2) {
        if (($loopValue % 2) == 0) {
                echo "</tr><tr>";
            }
        $pageLinkName = $key2;
        $pageLinkViewName = $value2;
        echo '<td><a href="' . $_SESSION['changedPathPos'].$pageLinkName . '">' . $pageLinkViewName . '</a></td>';
        //echo "Page Key : " . $pageKey . " page Name : " . $pageValue . "<br/>";
        $loopValue = $loopValue + 1;
        
    }
    echo "</tr>";
    //echo "*******************************************************************<br/>";
}
?>
