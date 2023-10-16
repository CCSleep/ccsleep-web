<?php
    if (is_admin()) {
        $bid = $db->real_escape_string($_GET["id"]);
        $name = $db->real_escape_string($_POST["name"]);
        $short_name = $db->real_escape_string($_POST["short_name"]);
        $desc = $db->real_escape_string($_POST["desc"]);
        $location = $db->real_escape_string($_POST["location"]);
        $map_link = $db->real_escape_string($_POST["map_link"]);
        $date_from = date("U", strtotime($db->real_escape_string($_POST["date_from"])));
        $date_to = date("U", strtotime($db->real_escape_string($_POST["date_to"])));
        $show_time = !empty($_POST["show_time"]) ? "true" : "false";
        $price = $_POST["price_unknown"] ? -1 : $db->real_escape_string($_POST["price"]);
        $show_gallery = !empty($_POST["show_gallery"]) ? "true" : "false";
        $modified_at = time();
        
        $q = $db->query("SELECT * FROM `events` WHERE short_name='$bid'");
        if ($q->num_rows == 1) {
            $row = $q->fetch_assoc();
            if ($_POST) {
                if ($_POST["action"] === "delete") {
                    $q = $db->query("DELETE FROM `events` WHERE short_name='$bid'");
                    header("location: /event");
                } else {
                    $db->query("UPDATE `events` SET
                        short_name='$short_name', long_name='$name', description='$desc', 
                        location='$location', map_link='$map_link', date_from=$date_from, 
                        date_to=$date_to, show_time=$show_time, price=$price, show_gallery=$show_gallery,
                        modified_at=$modified_at WHERE short_name='$bid'");
                    header("location: /event/edit/$short_name");
                }
            }
?>
<h1>Edit Event Post</h1>

<form method="POST">
    <p>
        <label>Event Name</label>
        <input type="text" name="name" id="name" placeholder="Maruya#36" value="<?= $row["long_name"] ?>" required>
    </p>
    <p>
        <label>Acronym (on link)</label>
        <input type="text" name="short_name" id="short-name" placeholder="maruya36" value="<?= $row["short_name"] ?>" required>
        <button id="generate-link" type="button">Kebab Generate</button>
    </p>
    
    <p>
        <label>Description</label>
        <textarea name="desc"><?= $row["description"] ?></textarea>
    </p>
    <p>
        <label>Location</label>
        <input type="text" name="location" placeholder="The Street Ratchada" value="<?= $row["location"] ?>" required>
    </p>
    <p>
        <label>Map Link (temp)</label>
        <input type="text" name="map_link" placeholder="https://maps.google.com/..." value="<?= $row["map_link"] ?>">
    </p>
    <p>
        <label>From</label>
        <input type="datetime-local" name="date_from" id="date-from" value="<?= date("Y-m-d\TH:i", $row["date_from"]) ?>">
    </p>
    <p>
        <label>To</label>
        <input type="datetime-local" name="date_to" id="date-to" value="<?= date("Y-m-d\TH:i", $row["date_to"]) ?>">
    </p>
    <p>
        <label>Show Time</label>
        <input type="checkbox" name="show_time"<?= $row["show_time"] ? " checked" : "" ?>>
    </p>
    <p>
        <label>Price</label>
        <input type="number" name="price" id="price" value="<?= $row["price"] ?>"<?= $row["price"] == -1 ? " disabled" : "" ?>>
        <input type="checkbox" id="price-unknown" name="price_unknown"<?= $row["price"] == -1 ? " checked" : "" ?>>
        <label for="price-unknown">Unknown</label>
    </p>
    <p>
        <input type="checkbox" id="show-gallery" name="show_gallery"<?= $row["show_gallery"] ? " checked" : "" ?>>
        <label for="show-gallery">Show in Gallery page</label>
    </p>
    <h3>Transportation</h3>
    <p><i>under construction...</i></p>
    <h3>Tags</h3>
    <p><i>under construction...</i></p>
    <button type="submit">Submit</button>
</form>

<?php include "common/delete_component.php" ?>

<style>
    input[type=checkbox], input[type=checkbox]:checked {
        background-color: #ffffff;
        width: 20px;
        height: 20px;
    }
</style>
<link rel="stylesheet" href="https://cdn.rawgit.com/CoffeePerry/simplemde-theme-bootstrap-dark/master/dist/simplemde-theme-bootstrap-dark.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
    var markdown_form = new SimpleMDE()
    const date_from = document.querySelector("#date-from")
    const date_to = document.querySelector("#date-to")
    const price = document.querySelector("#price")
    const price_unknown = document.querySelector("#price-unknown")
    date_from.addEventListener("change", () => {
        date_to.disabled = false
        date_to.setAttribute("min", date_from.value)
    })
    price_unknown.addEventListener("change", () => {
        price.disabled = price_unknown.checked
    })
    const kebabCase = str => str
    .match(/[A-Z]{2,}(?=[A-Z][a-z]+[0-9]*|\b)|[A-Z]?[a-z]+[0-9]*|[A-Z]|[0-9]+/g)
    .join('-')
    .toLowerCase()
    document.querySelector("#generate-link").addEventListener("click", () => {
        document.querySelector("#short-name").value = kebabCase(document.querySelector("#name").value)
    })
</script>
<?php
        } else {
            echo "<h1>Not Found!</h1>";
        }
    }
?>