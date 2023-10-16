<!DOCTYPE html>
<?php
    session_start();
    require_once "common/is_admin.php";
    $page = $_GET["page"];
    date_default_timezone_set("Asia/Bangkok");
    require_once "common/conn.php"; 
?>
<html>
    <head>
        <title>CCSleep</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/css/simple-form.css">
        <link rel="stylesheet" href="/css/rbd.min.css">
        
    </head>
    <body>
        <header>
            <h1>CCSleep</h1>
            <p>v1.0.0</p>
            <nav>
                <a href="/">home</a>
                <a href="/blog">blog</a>
                <a href="/event">event</a>
                <a href="/gallery">gallery</a>
                <a href="/layer">layer</a>
                <?php if (is_admin_silent()) { ?>
                    <a href="/admin" class="link-admin">admin</a>
                <?php } ?>
            </nav>
        </header>
        <hr>
            <?php
                if (empty($page)) {
                    $page = "home";
                }
                
                switch($page) {
                    case "home":
                        include "page/home.php";
                        break;
                    case "home_edit":
                        if (is_admin()) { include "page/home_edit.php"; }
                        break;
                    case "admin":
                        include "page/admin_login.php";
                        break;
                    case "admin_upload":
                        include "page/admin_upload.php";
                        break;
                    case "admin_logout":
                        include "page/admin_logout.php";
                        break;
                    case "blog":
                        include "page/blog.php";
                        break;
                    case "layer":
                        include "page/layer.php";
                        break;
                    case "gallery":
                        include "page/gallery.php";
                        break;
                    case "event":
                        include "page/event.php";
                        break;    
                    default:
                        http_response_code(404);
                }
                
            ?>
        
        <hr>
        <footer>
            (c) <?php echo date("Y", time()); ?> CCSleep - All works licensed with <a href="https://creativecommons.org/licenses/by-sa/4.0/">CC BY-SA 4.0</a> unless otherwise stated.
        </footer>
    </body>
</html>
