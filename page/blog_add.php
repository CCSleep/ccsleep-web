<?php
    if (is_admin()) {
    $title = $db->real_escape_string($_POST["title"]);
    $content = $db->real_escape_string($_POST["content"]);
    $time = time();
    //echo $content;
    if ($_POST) {
        $q = $db->query("INSERT INTO `blog` VALUES (NULL, '$title', '$content', $time, NULL)");
        //print_r($q);
        echo "<h4>Success!</h4>";
    }
    
?>

<h1>Add Blog Post</h1>

<form method="POST">
    <p>
        <label>Title</label>
        <input type="text" name="title" placeholder="Title" required>
    </p>
    <p>
        <label>Content</label>
        <textarea name="content"></textarea>
    </p>
    <button type="submit">Submit</button>
    <link rel="stylesheet" href="https://cdn.rawgit.com/CoffeePerry/simplemde-theme-bootstrap-dark/master/dist/simplemde-theme-bootstrap-dark.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script>
        var markdown_form = new SimpleMDE();
    </script>
</form>
<?php } ?>