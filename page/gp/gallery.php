<?php
    // ini_set("display_errors", 1);
    include "common/Parsedown.php";
    //require_once "common/s3_credentials.php";
    
    function get_object ($key) {
        return "https://media.ccsleep.net/$key";
    }
    $Parsedown = new Parsedown();
    $bid = $db->real_escape_string($_GET["id"]);
    $pg = isset($_GET['pg']) && is_numeric($_GET['pg']) ? intval($_GET['pg']) : 1;
    $q = $db->query("SELECT * FROM gallery WHERE short_name='$bid'");
    $items_per_page = 20;
    if ($q->num_rows == 1) {
        $row = $q->fetch_assoc();
        $q = $db->query("SELECT COUNT(DISTINCT layer) AS cnt FROM media_layer_tag WHERE uuid IN (SELECT uuid FROM media WHERE gallery_id='$bid')");
        $ccnt = $q->fetch_assoc()["cnt"];
        $q = $db->query("SELECT COUNT(*) as cnt FROM media WHERE gallery_id='$bid'");
        $icnt = $q->fetch_assoc()["cnt"];
?>
<h1><?= $row["long_name"] ?></h1>
<p><i><?= $icnt ?> photos w/ <?= $ccnt ?> cosplayer(s)</i></p>
<?= $Parsedown->text($row["description"]); ?>

<?php
    $item_start = ($pg-1) * $items_per_page;
    $total_pages = ceil($icnt / $items_per_page);
    $q = $db->query("SELECT * FROM media WHERE gallery_id='$bid' LIMIT $item_start,$items_per_page");
    if ($q->num_rows > 0) {
        ?>
<div class="pagination">
<p>Page: </p>
<?php
    // Pagination
    
    if ($pg > 1) {
      ?>
      <a href="/g/<?= $bid ?>/p/<?= $pg-1 ?>">&lt;&lt;</a>
      <?php
    } 
    if ($pg > 3) {
      ?>
      <a href="/g/<?= $bid ?>/p/1">1</a>
      <p>&#8230;</p>
      <?php
    }
    ?>
    
    <?php if ($pg-2 > 0) { ?><a href="/g/<?= $bid ?>/p/<?= $pg-2 ?>"><?= $pg-2 ?></a><?php } ?>
    <?php if ($pg-1 > 0) { ?><a href="/g/<?= $bid ?>/p/<?= $pg-1 ?>"><?= $pg-1 ?></a><?php } ?>
    <p><u><b><?= $pg ?></b></u></p>
    <?php if ($pg+1 <= $total_pages) { ?><a href="/g/<?= $bid ?>/p/<?= $pg+1 ?>"><?= $pg+1 ?></a><?php } ?>
    <?php if ($pg+2 <= $total_pages) { ?><a href="/g/<?= $bid ?>/p/<?= $pg+2 ?>"><?= $pg+2 ?></a><?php } ?>
    <?php
    if ($pg < $total_pages-2) {
      ?>
      <p>&#8230;</p>
      <a href="/g/<?= $bid ?>/p/<?= $total_pages ?>"><?=$total_pages?></a>

      <?php
    } 
    if ($pg < $total_pages) {
      ?>
        <a href="/g/<?= $bid ?>/p/<?= $pg+1 ?>">&gt;&gt;</a>
  <?php
}
?>
    
</div>

<hr>
<div id="gallery">
        <?php
        while ($row = $q->fetch_assoc()) {
            $r_uuid = $row['uuid'];
            // $q2 = $db->query("SELECT color, short_name, url FROM cosplayers WHERE short_name IN (SELECT DISTINCT layer FROM media_layer_tag WHERE uuid='$r_uuid')");
            ?>
            <a href="/i/<?= $row["uuid"] ?>">
                <img src="<?= get_object($row["server_thumbnail"]) ?>">
            </a>
            <?php
        }
        ?>
</div>
        <?php
    } else {
        ?>
        <hr><h2>Not Found!</h2>
        <?php
    }
?>
<?php } else { ?>
<h2>Gallery Not Found!</h2>
<?php } ?>
<style>
    #gallery{
         column-count:4;
         column-gap:20px;
    }
     @media (max-width:1200px){
         #gallery{
             column-count:3;
             column-gap:20px;
        }
    }
     @media (max-width:800px){
         #gallery{
             column-count:2;
             column-gap:20px;
        }
    }
     @media (max-width:600px){
         #gallery{
             column-count:1;
        }
    }
    .pagination {
        display: flex;
        align-items: center;
        column-gap: 1rem;
    }
</style>