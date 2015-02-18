<?php

/* $Id: Logout.php 4864 2012-02-02 22:35:31Z vvs2012 $*/
include_once 'includes/header.php';
$AllowAnyone=True; /* Allow all users to log off  */
//session_start();
?>

<div style="margin-top: 10%; margin-left: 40%;">

    <div class="left_box">
        <div class="top_left_box"></div>
        <div class="center_left_box">
            <div class="box_title">
                <span>লগ আউট</span>
            </div>


            <div class="form">
                <form method ="post" action ="index.php">
                   <!-- <input type =" hidden" name =" FormID" value =" <?php //echo $_SESSION['FormID'] ?>" /> -->

                    <div>
                        <pre>রিপড এর পক্ষ থেকে আপনাকে ধন্যবাদ</pre>
                    </div>

                    <div style="float: right; padding: 10px 25px 0 0;">
                        <input type="submit" name ="submit" value ="ঠিক আছে"/>                        
                    </div>

                </form>

            </div>
        </div>
        <div class="bottom_left_box"></div>
    </div>
    
</div>
<?php
	// Cleanup
	session_unset();
	session_destroy();        
?>
<?php
include_once 'includes/footer.php';
?>