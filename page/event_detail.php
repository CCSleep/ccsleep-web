<?php
    include "common/Parsedown.php";
    $Parsedown = new Parsedown();
    $bid = $db->real_escape_string($_GET["id"]);
    $q = $db->query("SELECT * FROM events WHERE short_name='$bid'");
    //echo $q->num_rows;
    if ($q->num_rows == 1) {
        $row = $q->fetch_assoc();
        ?>
            <h1><?php echo $row["long_name"]; ?></h1>
            <?php if (is_admin_silent()) { ?><a href="/event/edit/<?= $row["short_name"] ?>" class="link-admin">[Edit]</a><?php } ?>
            <p>Event Date: <?= row_date($row["date_from"], $row["date_to"]) ?> <?= $row["show_time"] ? render_time($row["date_from"], $row["date_to"]) : '' ?></p>
            <p>@ <a href="<?= $row["map_link"] ?>"><?= $row["location"] ?></a></p>
            <hr>
            <?php echo $Parsedown->text($row["description"]); ?>
        <?php
    } else {
        http_response_code(404);
    }
?>