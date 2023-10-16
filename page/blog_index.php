<h1>Blog</h1>
<?php if (is_admin_silent()) { ?>
<a href="/blog/new" class="link-admin">[New Post]</a>
<?php }?>
<ul>
<?php
$q = $db->query("SELECT * FROM blog ORDER BY created_at DESC");
while($row = $q->fetch_assoc()) {
    ?>
    <li>
        <a href="/blog/<?php echo $row["id"]; ?>"><?php echo date("Y/m/d", $row["created_at"]); ?> - <?php echo $row["title"]; ?></a> 
    </li>
    <?php
}

?>
</ul>