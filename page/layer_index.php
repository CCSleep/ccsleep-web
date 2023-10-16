<h1>All Cosplayers</h1>
<?php
    if (is_admin_silent()) {
        ?>
        <a href="/layer/new" class="link-admin">[New Post]</a>
        <?php
        if (!isset($_GET["edit"])) {
            ?>
                <div><a href="/layer/edit" class="link-admin">[Edit Mode]</a></div>
            <?php
        } else {
        ?>
                <div><a href="/layer" class="link-admin">[Exit Edit Mode]</a></div>
        <?php
        }
    }
    $q = $db->query("SELECT * FROM cosplayers");
    while ($row = $q->fetch_assoc()) {
       
        if (is_admin_silent() && isset($_GET["edit"])) {
             ?>
            <a href="/layer/edit/<?php echo $row["short_name"]; ?>" style="color: <?php echo $row["color"]; ?>"><?php echo $row["short_name"]; ?></a>
            <?php
        } else {
            ?>
            <a href="<?php echo $row["url"]; ?>" style="color: <?php echo $row["color"]; ?>"><?php echo $row["short_name"]; ?></a>
            <?php
        }
    }
?>