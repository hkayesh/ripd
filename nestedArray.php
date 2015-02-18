
<?php
error_reporting(0);
include_once 'includes/header.php';
?>
<style type="text/css">
    @import "css/domtab.css";
</style>
<div class="columnSld">
    <table class="formstyle"> 
        <tr>
            <td style="margin-left: 20%;padding-left: 100px;">
                <?php
                echo "<pre>";
                print_r($_SESSION['modSubModPageArray']);
                echo "</pre>";
                echo '--------------Role Based Page Array------------------';
                echo "<pre>";
                print_r($_SESSION['roleBasedPageArray']);
                echo "</pre>";
                
                echo '--------------Extra Access Page Array------------------';
                echo "<pre>";
                print_r($_SESSION['extraAccessPageArray']);
                echo "</pre>";
                
                echo '--------------Withdrawal Access Page Array------------------';
                echo "<pre>";
                print_r($_SESSION['withdrawalAccessPageArray']);
                echo "</pre>";
                
                echo '--------------Merged Access Page Array------------------';
                echo "<pre>";
                print_r($_SESSION['mergedAccessArray']);
                echo "</pre>";
                
                echo '--------------Overall  Access Page Array------------------';
                echo "<pre>";
                print_r($_SESSION['overalAccessArray']);
                echo "</pre>";
                
                echo '--------------Final Module and SubModule Page Array------------------';
                echo "<pre>";
                print_r($_SESSION['pagesArray']);
                echo "</pre>";
                
                echo '--------------Module Array List------------------';
                echo "<pre>";
                print_r($_SESSION['moduleArray']);
                echo "</pre>";
                ?>
            </td>
        </tr>
    </table>
</div>
<?php
include_once 'includes/footer.php';
?>