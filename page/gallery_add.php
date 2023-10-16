<?php
    if (is_admin()) {
    $short_name = $db->real_escape_string($_POST["short_name"]);
    $long_name = $db->real_escape_string($_POST["long_name"]);
    $content = $db->real_escape_string($_POST["desc"]);
    $time = time();
    //echo $content;
    if ($_POST) {
        $q = $db->query("INSERT INTO `gallery` VALUES (NULL, '$short_name', '$long_name', '$content', $time, NULL)");
        //print_r($q);
        echo "<h4>Success!</h4>";
    }
    
?>

<h1>Add Gallery</h1>
<p><b>This adds gallery to be shown at GalleryPlus!</b></p>
<form method="POST">
    <p>
        <label>Short Name</label>
        <input type="text" name="short_name" placeholder="Short Name" required>
    </p>
    <p>
        <label>Long Name</label>
        <input type="text" name="long_name" placeholder="Long Name" required>
    </p>
    <p>
        <label>Description</label>
        <textarea name="desc"></textarea>
    </p>
    <button type="submit">Submit</button>
    <link rel="stylesheet" href="https://cdn.rawgit.com/CoffeePerry/simplemde-theme-bootstrap-dark/master/dist/simplemde-theme-bootstrap-dark.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script>
        var markdown_form = new SimpleMDE();
    </script>
</form>
<?php } ?>