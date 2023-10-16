<?php
    $action = $_GET["action"];
    switch ($action) {
        case "add":
            require_once "page/gallery_add.php";
            break;
		case "list":
            require_once "page/gallery_list.php";
            break;
        case "edit":
            require_once "page/gallery_edit.php";
            break;
        default:
            http_response_code(404);
    }
?>