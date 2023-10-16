<?php 
if ($_POST){
if ($_POST["username"] == "admin" && hash("sha256", $_POST["password"]) == "8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918") {
    $_SESSION["username"] = "admin";
} else {
   echo '<h4>Wrong Password!</h4>';
}
}
if (!empty($_SESSION["username"])) {
    ?>
    <h1>Admin Panel</h1>
	<h2>Home</h2>
	<ul>
		<li><a href="/home/edit">Edit Homepage</a></li>
	</ul>
	<h2>GalleryPlus</h2>
	<ul>
		<li><a href="/admin/upload">Upload Image</a></li>
		<li><a href="/gallery/new">Add GalleryPlus Gallery</a></li>
		<li><a href="/gallery/list">Edit GalleryPlus Gallery</a></li>
	</ul>
	
	<h2>Event</h2>
	<ul>
		<li><a href="/event/new">Add Event Page</a></li>
	</ul>
	<h2>Other</h2>
	<ul>
		<li><a href="/admin_logout">Logout</a></li>
	</ul>
    
    <?php
} else { 
?>

<h1>Admin Login</h1>
<form method="POST">
     <p>
        <label>Username</label>
        <input type="text" placeholder="Username" name="username" required>
    </p>
    <p>
        <label>Password</label>
        <input type="password" placeholder="Password" name="password" required>
    </p>
    <button type="submit">Login</button>
</form>
<?php
}
?>