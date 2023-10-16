<?php
if (is_admin()){
    $content = $db->real_escape_string($_POST["content"]);
    if ($_POST) {

        $q = $db->query("UPDATE `config` SET value='$content' WHERE name='homepage'");
        //print_r($q);
        echo "<p><h4>Success!</h4> <a href='/' target='_blank'>[Preview]</a></p>";

    }
    //$bid = $db->real_escape_string($_GET["id"]);
    //$title = $db->real_escape_string($_POST["title"]);
    
    $time = time();
     $q = $db->query("SELECT * FROM config WHERE name='homepage'");
    //echo $q->num_rows;
   // if ($q->num_rows == 1) {
    //echo $content;
    $row = $q->fetch_assoc();
    
?>

<h1>Edit Homepage</h1>

<form method="POST">
    <p>
        <label>Content</label>
        <textarea name="content"><?php echo $row["value"]; ?></textarea>
    </p>

    <button type="submit">Submit</button>
    <link rel="stylesheet" href="https://cdn.rawgit.com/CoffeePerry/simplemde-theme-bootstrap-dark/master/dist/simplemde-theme-bootstrap-dark.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script>
        var markdown_form = new SimpleMDE();
    </script>
</form>
<?php } ?>