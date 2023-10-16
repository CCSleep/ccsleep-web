<h1>GalleryPlus Edit</h1>

<ul>
<?php
$q = $db->query("SELECT * FROM gallery ORDER BY created_at DESC");
while($row = $q->fetch_assoc()) {
    ?>
    <li>
        <a href="/gallery/edit/<?php echo $row["short_name"]; ?>"><?= $row["long_name"] ?> (<?= $row["short_name"] ?>)</a> 
    </li>
    <?php
}

?>
</ul>