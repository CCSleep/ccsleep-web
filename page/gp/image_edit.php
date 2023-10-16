<?php
	require_once "common/s3_credentials.php";
	if (is_admin()) {
		
		function get_object ($key) {
			return "https://media.ccsleep.net/$key";
		}
		function delete_from_s3($server_loc, $bucket) {
			global $s3;
			$r = $s3->deleteObject(array(
				'Bucket' => $bucket,
				'Key'    => $server_loc
			));
			return $r;
		}
		$bid = $db->real_escape_string($_GET["id"]);
		if ($_POST) {
			$action = $_POST["action"];
			$i = $db->real_escape_string($_POST["short_name"]);
			if ($action == "add_tag") {
				$db->query("INSERT INTO media_layer_tag VALUES (NULL, '$bid', '$i')");
			} elseif ($action == "remove_tag") {
				$db->query("DELETE FROM media_layer_tag WHERE uuid='$bid' AND layer='$i'");
			} elseif ($action == "delete") {
				$db->query("DELETE FROM media_layer_tag WHERE uuid='$bid'");
				$q = $db->query("SELECT * FROM media WHERE uuid='$bid'");
				$r = $q->fetch_assoc();
				
				delete_from_s3($r["server_filename"], $bucket_name);
				delete_from_s3($r["server_thumbnail"], $bucket_name);
				$db->query("DELETE FROM media WHERE uuid='$bid'");
				header("location: /g/{$r['gallery_id']}");
			}
		}
		$q = $db->query("SELECT * FROM media WHERE uuid='$bid'");
		if ($q->num_rows > 0) {
			$row = $q->fetch_assoc();
			$q2 = $db->query("SELECT color, short_name, url FROM cosplayers WHERE short_name IN (SELECT DISTINCT layer FROM media_layer_tag WHERE uuid='{$row["uuid"]}')");
			?>
			<h1>Edit Image</h1>
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
			<h3>Add Cosplayer Tag</h3>
			<form method="POST">
				<p>
					<label>Name</label>
					<input type="text" name="short_name" placeholder="ABC">
				</p>
				<input type="hidden" name="action" value="add_tag">
				<button type="submit">Submit</button>
			</form>
			<h3>Remove Cosplayer Tag</h3>
			<form method="POST">
				<p>
					<label>Name</label>
					<input type="text" name="short_name" placeholder="ABC">
				</p>
				<input type="hidden" name="action" value="remove_tag">
				<button type="submit">Submit</button>
			</form>
			<?php include "common/delete_component.php" ?>
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
<?php
	}	
?>