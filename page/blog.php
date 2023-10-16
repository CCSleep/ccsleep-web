<?php
    $action = $_GET["action"];
    switch ($action) {
        case "index":
            require_once "page/blog_index.php";
            break;
        case "add":
            require_once "page/blog_add.php";
            break;
        case "edit":
            require_once "page/blog_edit.php";
            break;
        case "detail":
            require_once "page/blog_detail.php";
            break;
        default:
            http_response_code(404);
    }
?>