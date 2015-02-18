<?php
include_once 'includes/session.inc';
include_once 'includes/header.php';
include_once 'includes/columnLeftMainMenu.php';
$current_page_name = basename($_SERVER["SCRIPT_NAME"]);
?>
<style type="text/css">
    @import "css/domtab.css";
</style>


<div class="columnSubmodule">
    <table class="formstyle"> 
        
      <?php
        include_once 'includes/showSubModules_pages.php';
      ?>  

    </table>
</div>
<?php

include_once 'includes/footer.php';
?>