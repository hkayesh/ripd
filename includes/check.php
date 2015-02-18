<?php
    if (preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$_GET['x']))
                { 
                    echo "";
                 }
                    else
                        {
                        echo "<span style='color: red; font-weight: bold'>ভুল ইমেইল এড্রেস</span>";
    
                        }
    
?>