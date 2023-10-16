<?php
if (is_admin()) {
    $name = $db->real_escape_string($_POST["name"]);
    $link = $db->real_escape_string($_POST["link"]);
    $short_name = $db->real_escape_string($_POST["short_name"]);
    $color = $db->real_escape_string($_POST["color"]);
    $time = time();
    //echo $content;
    if ($_POST) {
    
        $q = $db->query("INSERT INTO `cosplayers` VALUES (NULL,'$short_name','$name', '$color','$link', $time, NULL )");
        //print_r($q);
        echo "<h4>Success!</h4>";
    } 
    
?>

<h1>Add Cosplayer's Name</h1>

<form method="POST">
    <p>
        <label>Name</label>
        <input type="text" name="name" placeholder="Title" required>
    </p>
    <p>
        <label>Acronym</label>
        <input type="text" name="short_name" placeholder="ABC" required>
    </p>
    <p>
        <label>Social Link (temp)</label>
        <input type="text" name="link" placeholder="https://instagram.com/abc" required>
    </p>
    <p>
        <label>Color</label>
        <input type="color" name="color" value="#4ed8f9" required>
    </p>
    <button type="submit">Submit</button>
</form>
<?php } ?>