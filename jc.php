<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>jQuery UI Effects - Toggle Demo</title>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="javascripts/jquery-1.9.1.js"></script>
<script src="javascripts/jquery-ui.js"></script>
<style>
.toggler {
width: 500px;
height: auto;
}
.effect {
position: relative;
width: 240px;
height: 135px;
padding: 0.4em;
}
</style>
<!--<script type="text/javascript">
$(function() {
    $(".effect").hide();
var first = $(".effect:first"); 
first.show();
$( ".h3button" ).click(function() {
    $('.h3button').not(this).each(function(){
        var content = $(this).next();
        $(content).hide();
    });
        var selectedEffect = 'blind';
        var content = $(this).next();
        $(content).toggle( selectedEffect, 500 );
        return false;
    });
});
</script>-->
</head>
<body>
 <?php
 for($i=0;$i<5;$i++) {
 ?>
<div class="toggler">
 <h3 class="ui-state-default ui-corner-all button" style="text-align: center;width: 100px;">Toggle</h3>
<div  class="ui-widget-content ui-corner-all effect">
<p>
Etiam libero neque, luctus a, eleifend nec, semper at, lorem. Sed pede. Nulla lorem metus, adipiscing ut, luctus sed, hendrerit vitae, mi.
</p>
</div>
</div>
 <?php }?>
</body>
</html>
