<?php
if (is_admin()){
    $bid = $db->real_escape_string($_GET["id"]);
    $short_name = $db->real_escape_string($_POST["short_name"]);
    $long_name = $db->real_escape_string($_POST["long_name"]);
    $content = $db->real_escape_string($_POST["desc"]);
    $time = time();
    if ($_POST) {
        if ($_POST["action"] === "delete") {
            $q = $db->query("DELETE FROM `gallery` WHERE short_name='$bid'");
            header("location: /gallery");
        } else {
            $q = $db->query("UPDATE `gallery` SET short_name ='$short_name', long_name='$long_name', description='$content', modified_at='$time' WHERE short_name='$bid'");
            header("location: /gallery/edit/$short_name");
        }
    }
    
      $q = $db->query("SELECT * FROM gallery WHERE short_name='$bid'");
    //echo $q->num_rows;
    if ($q->num_rows == 1) {
    //echo $content;
    $row = $q->fetch_assoc();
    
    
?>

<h1>Edit Gallery</h1>

<form method="POST">
    <p>
        <label>Short Name</label>
        <input type="text" name="short_name" placeholder="Short Name"  value="<?php echo $row["short_name"] ?>" required>
    </p>
    <p>
        <label>Long Name</label>
        <input type="text" name="long_name" placeholder="Long Name"  value="<?php echo $row["long_name"] ?>" required>
    </p>
    <p>
        <label>Description</label>
        <textarea name="desc"><?php echo $row["description"] ?></textarea>
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
<h2>Gallery Not Found!</h2>
<?php } 
} ?>
