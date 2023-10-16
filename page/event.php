<?php
    function row_date($date_from, $date_to) {
        if (date("Y-m-d", $date_from) == date("Y-m-d", $date_to)) {
            return date("Y/m/d", $date_from);
        } else {
            return date("Y/m/d", $date_from)." - ".date("Y/m/d", $date_to);
        }
    }
    function render_time($date_from, $date_to) {
        return "[".date("H:i", $date_from)." - ".date("H:i", $date_to)."]";
    }
    function render_price($price) {
        if ($price == 0) return "Free";
        if ($price == -1) return "???";
        return $price;
    }
    $action = $_GET["action"];
    switch ($action) {
        case "index":
            require_once "page/event_index.php";
            break;
        case "add":
            require_once "page/event_add.php";
            break;
        case "edit":
            require_once "page/event_edit.php";
            break;
        case "detail":
            require_once "page/event_detail.php";
            break;
        default:
            http_response_code(404);
    }
?>