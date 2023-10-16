<?php
    function is_admin() {
        if (!($_SESSION["username"] == "admin")) {
            echo '<h1>Unauthorized!</h1>';
            return false;
        }
        return true;
    }
    
    function is_admin_silent() {
        if (!($_SESSION["username"] == "admin")) {
            //echo '<h1>Unauthorized!</h1>';
            return false;
        }
        return true;
    }
?>