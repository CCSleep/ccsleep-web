<!DOCTYPE html>
<?php
	session_start();
    $page = $_GET["page"];
	require_once "common/is_admin.php";
    date_default_timezone_set("Asia/Bangkok");
    require_once "common/conn.php"; 
?>
<html>
    <head>
        <title>GalleryPlus</title>
		<link rel="stylesheet" href="/css/simple-form.css">
        <link rel="stylesheet" href="/css/rbd.min.css">
        <meta charset="UTF-8">
    </head> 
    <body>
        <header class="container">
            <h1>Gallery<span class="fg-aux-three">+</span></h1>
            <p><i>CCSleep's Image Viewer</i></p>
        </header>
        <hr>
        <?php
            
            if (empty($page)) {
                include "page/home.php";
            } else {
                switch ($page) {
                    case "home":
                        include "page/gp/home.php";
                        break;
                    case "gallery":
                        include "page/gp/gallery.php";
                        break;
                    case "image_view":
                        include "page/gp/image_view.php";
                        break;
					case "image_edit":
                        include "page/gp/image_edit.php";
                        break;
                    default:
                        http_response_code(404);
                }
            }
        ?>
		<hr>
		<footer>
			(c) <?= date("Y", time()) ?> CCSleep - All rights reserved unless otherwise stated.
		</footer>
    </body>
    
</html> 