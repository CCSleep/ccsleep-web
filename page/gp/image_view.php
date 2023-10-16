<?php
 //   ini_set("display_errors", 1);
    
    function get_object ($key) {
        return "https://media.ccsleep.net/$key";
    }
    $bid = $db->real_escape_string($_GET["id"]);

	$q = $db->query("SELECT * FROM media WHERE uuid='$bid'");
	if ($q->num_rows > 0) {
		$row = $q->fetch_assoc();
		$q2 = $db->query("SELECT color, short_name, url FROM cosplayers WHERE short_name IN (SELECT DISTINCT layer FROM media_layer_tag WHERE uuid='{$row["uuid"]}')");
		?>
		<h1>View Image</h1>
		<p><i>Click on the image to view full size</i></p>
		<p>
			Contact for RAW file: <a href="mailto:admin@ccsleep.net">admin@ccsleep.net</a> or <a href="https://twitter.com/ccsleep_">Twitter</a> 
		</p>
		<div class="image-container">
			<div>
				<a href="<?= get_object($row["server_filename"]) ?>" target="_blank">
					<img src="<?= get_object($row["server_thumbnail"]) ?>">
				</a>
			</div>
			<div>
				<?php
					if (is_admin_silent()) {
				?>
				<p>
					<a href="/ie/<?= $row["uuid"] ?>" class="link-admin">[Edit]</a>
				</p>
				<?php
					}
				?>
				<p><b>Filename:</b> <?= $row["filename"] ?></p>
				<p><b>UUID:</b> <?= $row["uuid"] ?></p>
				<p><b>Gallery:</b> <a href="/g/<?= $row["gallery_id"] ?>"><?= $row["gallery_id"] ?></a></p>
				<?php
					if ($q2->num_rows > 0) {
						?>
						<p>
							w/ <?php while ($r2 = $q2->fetch_assoc()) {
								?>
							<a href="<?= $r2["url"] ?>" style="color:<?= $r2["color"] ?>"><?= $r2["short_name"] ?></a>
								<?php
							} ?>
						</p>
						<?php
					}
				?>
				
			</div>
		</div>
		<?php
	} else {
		?>
		<h2>Image not found!</h2>
		<?php
	}
?>
<style>
	.image-container {
		display: grid;
		grid-template-columns: 50% 1fr;
		grid-gap: 20px;
	}
	@media (max-width:800px){
         .image-container {
             grid-template-columns: 1fr;
        }
    }
</style>