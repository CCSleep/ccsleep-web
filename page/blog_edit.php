<?php
if (is_admin()){
    $bid = $db->real_escape_string($_GET["id"]);
    $title = $db->real_escape_string($_POST["title"]);
    $content = $db->real_escape_string($_POST["content"]);
    $time = time();
    if ($_POST) {
        if ($_POST["action"] === "delete") {
            $q = $db->query("DELETE FROM `blog` WHERE id='$bid'");
            header("location: /blog");
        } else {
            $q = $db->query("UPDATE `blog` SET title ='$title', content='$content', modified_at='$time' WHERE id=$bid");
            echo "<p><h4>Success!</h4> <a href='/blog/$bid' target='_blank'>[Preview]</a></p>";
        }
    }
    
      $q = $db->query("SELECT * FROM blog WHERE id=$bid");
    //echo $q->num_rows;
    if ($q->num_rows == 1) {
    //echo $content;
    $row = $q->fetch_assoc();
    
    
?>

<h1>Edit Blog Post</h1>

<form method="POST">
    <p>
        <label>Title</label>
        <input type="text" name="title" placeholder="Title" value="<?php echo $row["title"] ?>" required>
    </p>
    <p>
        <label>Content</label>
        <textarea name="content"><?php echo $row["content"]; ?></textarea>
    </p>
   
    <button type="submit">Submit</button>
    <link rel="stylesheet" href="https://cdn.rawgit.com/CoffeePerry/simplemde-theme-bootstrap-dark/master/dist/simplemde-theme-bootstrap-dark.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script>
        var markdown_form = new SimpleMDE();
    </script>
</form>

<?php include "common/delete_component.php" ?>

<?php } else { ?>
<h2>Blog Not Found!</h2>
<?php } 
} ?>
