<?php
if (is_admin()) {
    $bid = $db->real_escape_string($_GET["id"]);
    $name = $db->real_escape_string($_POST["name"]);
    $link = $db->real_escape_string($_POST["link"]);
    $short_name = $db->real_escape_string($_POST["short_name"]);
    $color = $db->real_escape_string($_POST["color"]);
    $time = time();
    $q = $db->query("SELECT * FROM cosplayers WHERE short_name='$bid'");
    //echo $q->num_rows;
    if ($q->num_rows == 1) {
        //echo $content;
        $row = $q->fetch_assoc();
        if ($_POST) {
            if ($_POST["action"] === "delete") {
                $q = $db->query("DELETE FROM `cosplayers` WHERE short_name='$bid'");
                header("location: /layer");
            } else {
                $q = $db->query("UPDATE `cosplayers` SET long_name ='$name', short_name='$short_name', url='$link', color='$color', modified_at=$time WHERE short_name='$bid'");
                //print_r($q);
                header("Location: /layer/edit/$short_name");
            }
        } else {
            ?>
<h1>Edit Cosplayer's Name</h1>

<form method="POST">
    <p>
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $row['long_name']; ?>" placeholder="Title" required>
    </p>
    <p>
        <label>Acronym</label>
        <input type="text" name="short_name" value="<?php echo $row['short_name']; ?>" placeholder="ABC" required>
    </p>
    <p>
        <label>Social Link (temp)</label>
        <input type="text" name="link" value="<?php echo $row['url']; ?>" placeholder="https://instagram.com/abc" required>
    </p>
    <p>
        <label>Color</label>
        <input type="color" name="color" value="<?php echo $row['color']; ?>" value="#4ed8f9" required>
    </p>
   
    <button type="submit">Submit</button>
</form>
<?php include "common/delete_component.php" ?>
            <?php
        }
    } else {
        echo '<h1>Not Found!</h1>';
    }   
}
?>

