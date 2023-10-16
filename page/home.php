<?php
include "common/Parsedown.php";
$Parsedown = new Parsedown();
// $bid = $db->real_escape_string($_GET["id"]);
$q = $db->query("SELECT * FROM config WHERE name='homepage'");
//echo $q->num_rows;

$row = $q->fetch_assoc();
if (is_admin_silent()) {
    ?>
    <a href="/home/edit" class="link-admin">[Edit]</a>
    <?php
}
echo $Parsedown->text($row["value"]);
        ?>
        
           