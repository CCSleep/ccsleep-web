<?php
    $mode = $_GET["mode"];
    if ($mode == "past_event") {
        echo "<h1>Gallery</h1>
        <p>Gallery of past events. (under construction, working on image gallery)</p>"; 
    } else {
        echo "<h1>Events</h1>
        <p>Events I might go in the future (this page is heavily under construction...)</p><a href='/gallery'>[View Past Events]</a>";
    }
    $current_time = time();
    if ($mode == "past_event") {
        $q = $db->query("SELECT * FROM `events` WHERE show_gallery=1 ORDER BY date_from DESC");
    } else {
        $q = $db->query("SELECT * FROM `events` WHERE date_to>$current_time ORDER BY date_to ASC");
    }
    
    
    if ($q->num_rows > 0) {
?>
<div class="table-container">
    <table>
        <thead>
            <th>Name</th>
            <th>Date</th>
            <th>Location</th>
            <th>Door Rate</th>
        </thead>
        <tbody>
            <?php
                while ($row = $q->fetch_assoc()) {
                    ?>
                    <tr>
                        <td>
                            <a href="event/<?= $row["short_name"] ?>"><?= $row["long_name"] ?></a>
                        </td>
                        <td>
                            <p><?= row_date($row["date_from"], $row["date_to"]) ?></p><?= $row["show_time"] ? "<p>".render_time($row["date_from"], $row["date_to"])."</p>" : '' ?>
                        </td>
                        <td>
                            <a href="<?= $row["map_link"] ?>"><?= $row["location"] ?></a>
                        </td>
                        <td>
                            <?= render_price($row["price"]) ?>
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
</div>
<?php } else {
    echo '<h3>No upcoming events!</h3>';
} ?>