<?php
$message = '';
include_once 'includes/header.php';
include_once 'includes/MiscFunctions.php';
if (isset($_POST['submit'])) {
    if (!isset($PathPrefix)) {
        $PathPrefix = '';
    }
    if (!isset($AllowAnyone)) { 
        // // only do security checks if AllowAnyone is not true 
        //echo "if Condition in Anyone";
        $givenUserName = mysql_real_escape_string($_POST['UserNameEntryField']);
        $givenPassword = $_POST['Password'];
        include $PathPrefix . 'includes/UserLogin.php'; // Login checking 
        if (!empty($givenUserName) && !empty($givenPassword)) {
            
            $rc = userLogin($givenUserName, md5($givenPassword));
        } elseif (empty($givenUserName) && empty($givenPassword)) {
            
            $rc = UL_SHOWLOGIN_Both_Empty;
        }elseif (empty($givenUserName)) {
            
            $rc = UL_SHOWLOGIN_UserName_Empty;
        } else {
            
            $rc = UL_SHOWLOGIN_Pass_Empty;
        }
        
        switch ($rc) {
            case UL_OK;
                echo "<meta http-equiv='refresh' content='0; URL=index.php'>";
                exit();

            case UL_SHOWLOGIN:
                $message = 'ভুল তথ্য, আবার চেষ্টা করুন';
                break;

            case UL_BLOCKED:
                $message = 'দুঃখিত, আপনার একাউন্টি ব্লক আছে। একাউন্টি আন-ব্লক করার জন্য আপনার নিকটস্থ অফিসে যোগাযোগ করুন';
                break;
            
            case UL_Temporarily_Closed:
                $message = 'দুঃখিত, আপনার একাউন্টি সাময়িকভাবে বন্ধ আছে। একাউন্টি খোলার জন্য আপনার নিকটস্থ অফিসে যোগাযোগ করুন';
                break;

            case UL_Permanently_Closed:
                $message = 'দুঃখিত, আপনার একাউন্টি স্থায়ীভাবে বন্ধ আছে। আপনি আর এই সিস্টেমে লগ-ইন করতে পারবেন না';
                break;
            
            case UL_Is_BLOCKED:
                $message = 'দুঃখিত, ভুল ইনফরমেশন দিয়ে ৫ বারের বেশি চেষ্টা করায় আপনার একাউন্টি ব্লক করা হয়েছে। একাউন্টি আন-ব্লক করার জন্য আপনার নিকটস্থ অফিসে যোগাযোগ করুন';
               break;
           
            case UL_SHOWLOGIN_Both_Empty:
                $message = 'দুঃখিত, আপনি আপনার ইউজার নাম এবং পাসওয়ার্ড কোনো-টাই দেন নাই';
                break;
            
            case UL_NOTVALID:
                $message = 'দুঃখিত, আপনি আপনার ইউজার নাম অথবা পাসওয়ার্ড ভুল দিতেছেন। পুনরায় ভাল করে চেক করুন এবং ৫ বারের বেশি ভুল তথ্য দিয়ে লগ-ইনের চেষ্টা করলে আপনার একাউন্টি ব্লক হয়ে যাবে';
                break;
           
            case UL_SHOWLOGIN_UserName_Empty:
                $message = 'দুঃখিত, আপনি আপনার ইউজার নাম দেন নাই';
                break;
            
            case UL_SHOWLOGIN_Pass_Empty:
                $message = 'দুঃখিত, আপনি আপনার পাসওয়ার্ড দেন নাই';
                break;
            
            case UL_Already_BLOCKED:
                $message = 'দুঃখিত, ভুল ইনফরমেশন দিয়ে ৫ বারের বেশি চেষ্টা করায় আপনার একাউন্টি আগেই ব্লক হয়ে গেছে। একাউন্টি আন-ব্লক করার জন্য আপনার নিকটস্থ অফিসে যোগাযোগ করুন';
                break;
        }
    } //only do security checks if AllowAnyone is not true 
}
?>

<div style="margin-top: 10%; margin-left: 20%;margin-bottom: 10%;">

    <div class="login_left_box" style="width: 600px;">
        <div class="center_left_box" style="width: 400px;">
           
            <div class="box_title" style="text-align: center; margin-left: 40%;">
                <span>লগইন</span> করুন
            </div>
            <?php
            echo "<h2 style ='width:600px;color:red;text-align:center;'><blink>" . $message . "</blink></h2>";
            if (isset($_GET['needLoging']) && !isset($_POST['submit'])) {
                $msgNotLogin = "দুঃখিত, আপনাকে লগ ইন করতে হবে";
                echo "<h2 style ='width:600px;color:red;text-align:center;'><blink>" . $msgNotLogin . "</blink></h2>";
            }
            ?>

            <div class="form" style="margin-left: 40%;">
                <form method ="post" onsubmit="">

                    <div class="form_row">
                        <label class="left">ইউজারনেমঃ </label><input type="text" class="form_input" name ="UserNameEntryField"/>
                    </div>
                    <div class="form_row">
                        <label class="left">পাসওয়ার্ডঃ </label><input type="password" class="form_input" name ="Password" />
                    </div>

                    <div style="float: right; padding: 10px 25px 0 0;">
                        <input type="submit" name ="submit" value ="লগইন"/>
                        <div class="form_row_register">
                            <a href="#"></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include_once 'includes/footer.php';
?>