<?php
    $action = $_GET["action"];
    switch ($action) {
        case "index":
            require_once "page/layer_index.php";
            break;
        case "add":
            require_once "page/layer_add.php";
            break;
        case "edit":
            require_once "page/layer_edit.php";
            break;
        // still no contact db so just link directly to the layer's profile
        // case "detail":
        //     require_once "page/layer_detail.php";
        //     break;
        default:
            http_response_code(404);
    }
?>