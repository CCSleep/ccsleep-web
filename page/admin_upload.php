<?php
//ini_set("display_errors",1);
if (is_admin()) {
    ?>
    <h1>Add Image Batch</h1>
    <h3>Instructions</h3>
    <ol>
        <li>Create ZIP file containing images</li>
        <li>Upload ZIP file to FTP server using content folder (ftp.ccsleep.net)</li>
        <li>The file will appear on the table below</li>
        <li>Choose either [ExAdd] (Extract + Process ZIP files) or [OnlyEx] (Extract Only)</li>
    </ol>
    <h4>Notes</h4>
    <ul>
        <li>Allowed image types are JPG, PNG and WEBP</li>
        <li>This will treat all files as new files</li>
        <li>Using [ExAdd] on [filename].zip will add to gallery called [filename]</li>
		<li>[ExAdd] also add ampersand after the filename</li>
    </ul>
	<h4>File Properties</h4>
	<ul>
		<li>You can add file properties to server using filenames</li>
		<li>Add __ followed by file properties, seperate each properties with +</li>
		<li>@XXX = tag cosplayer XXX (specified on <a href="/layer">/layer</a> page)</li>
		<li>&amp; = do not upload this file</li>
		<li>ex. IMG_0001__@MJI+@KWI.jpg = IMG_0001.jpg, tag cosplayer MJI and KWI</li>
	</ul>
    <p><b>Please remove folders after processing!</b></p>
    <p><b>Using WEBP images is preferred to save bandwidth!</b></p>
    <table>
        <thead>
                <tr>
                    <th>File Name</th>
                    <th>Options</th>
                </tr>
        </thead>
        <tbody>
        <?php $dir = "content";
        foreach (scandir($dir) as $i) {
            $allowed = array("zip");
            if (in_array(pathinfo($i, PATHINFO_EXTENSION), $allowed)) {
            ?>
                <tr>
                    <td><a href="<?= "/$dir/$i" ?>"><?= $i ?></a></td>
                    <td>
                        <a href="/api/admin/upload?file=<?= urlencode($i) ?>&add_uploaded">[ExAdd]</a>
                        <a href="/api/admin/upload?file=<?= urlencode($i) ?>&mode=extractonly">[OnlyEx]</a>
                    </td>
                </tr>
            <?php
               }
          }
         ?>
         </tbody>
    </table>
    <h3>Process Folder</h3>
    <p>If you uploaded a folder or extracted a ZIP file, the directories will be listed here.</p>
    <form action="/api/admin/upload">
        <p>
            <label>Folder (in server)</label>
	        <select id="folder" name="folder">
	             <option value="" disabled selected>Select your option...</option>
	             <?php 
		         foreach (scandir($dir) as $i) {
		            if (is_dir("$dir/".$i) && $i != "." && $i != "..") {
		            ?>
		             <option value="<?= $i ?>"><?= $i ?></option>
		            <?php
		            }
    		     }
    		     ?>
	         </select>
         </p>
         <p>
             <label>Gallery</label>
             <input type="text" name="gallery" placeholder="gallery-name">
         </p>
		 <p>
			 <input type="checkbox" name="add_uploaded">
			 <label>Add uploaded (&amp;) tag to filename</label> 
	     </p>
         <input type="hidden" name="mode" value="folder">
		
         <button type="submit">Submit</button>
    </form>
    
    <h3>Delete Folder</h3>
    <p>If you uploaded a folder or extracted a ZIP file, the directories will be listed here.</p>
    <p><b>Please remove folders after processing!</b></p>
    <form action="/api/admin/upload" id="delete-folder">
        <p>
            <label>Folder (in server)</label>
	        <select id="folder" name="folder">
    	        <option value="" disabled selected>Select your option...</option>
	            <?php 
	            foreach (scandir($dir) as $i) {
		     
    		        if (is_dir("$dir/".$i) && $i != "." && $i != "..") {
    		           ?>
    		            <option value="<?= $i ?>"><?= $i ?></option>
    		            <?php
    		        }
		        }
		         ?>
	         </select>
         </p>
         <input type="hidden" name="mode" value="delete">
         <button type="button" id="delete-button">DELETE</button>
    </form>
    <style>
		input[type=checkbox], input[type=checkbox]:checked {
			background-color: #ffffff;
			width: 20px;
			height: 20px;
		}
	</style>
     <script>
        document.querySelector("#delete-button").addEventListener("click", () => {
            if (confirm("Are you sure you want to delete this item? This action is not reversible!")) {
                document.querySelector("#delete-folder").submit()
            }
        })
     </script>
    <?php 
}
?>
