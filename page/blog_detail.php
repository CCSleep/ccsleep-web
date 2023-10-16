<?php
    include "common/Parsedown.php";
    $Parsedown = new Parsedown();
    $bid = $db->real_escape_string($_GET["id"]);
    $q = $db->query("SELECT * FROM blog WHERE id=$bid");
    //echo $q->num_rows;
    if ($q->num_rows == 1) {
        $row = $q->fetch_assoc();
        ?>
            <h1><?php echo $row["title"]; ?></h1>
            <?php if (is_admin_silent()) { ?><a href="/blog/edit/<?= $row["id"] ?>" class="link-admin">[Edit]</a><?php } ?>
            <p>Created at <?php echo date('Y/m/d H:i', $row["created_at"]); ?></p>
            <?php if (!empty($row["modified_at"])) { ?><p>Updated at <?php echo date('Y/m/d H:i', $row["modified_at"]); ?> </p> <?php } ?>
            <hr>
            <?php echo $Parsedown->text($row["content"]); ?>
        <?php
    } else {
        http_response_code(404);
    }
    
    $next = $db->query("SELECT id FROM blog WHERE id>$bid ORDER BY id ASC LIMIT 1");
    $prev = $db->query("SELECT id FROM blog WHERE id<$bid ORDER BY id DESC LIMIT 1");
    //var_dump($next);
    if ($prev->num_rows > 0){
        $row = $prev->fetch_assoc();
        //var_dump($row);
    	$r = $row["id"];
    	
    	echo "<a href='/blog/$r'> &lt;&lt; Previous Post</a>&nbsp;";
    }
    if ($next->num_rows > 0){
    	$row = $next->fetch_assoc();
    	$r = $row["id"];
    	echo "<a href='/blog/$r'> &gt;&gt; Next Post</a>";
    }

?>