<?php
    
    session_start();
    require_once "media_data_api.php";
    require_once "../../common/is_admin.php";
    //ini_set("display_errors", 1);
    function rrmdir($dir) { 
       if (is_dir($dir)) { 
         $objects = scandir($dir);
         foreach ($objects as $object) { 
           if ($object != "." && $object != "..") { 
             if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
               rrmdir($dir. DIRECTORY_SEPARATOR .$object);
             else
               unlink($dir. DIRECTORY_SEPARATOR .$object); 
           } 
         }
         rmdir($dir); 
       } 
    }
    $content = "../../content";
    if (is_admin_silent()) {
        $allowed = array("zip");
        $filename = "$content/".$_GET["file"];
        
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        //echo $ext;
        $mode = $_GET["mode"];
		$add_uploaded = isset($_GET["add_uploaded"]);
        if(in_array($ext, $allowed)) {
            $gallery_name = pathinfo($filename, PATHINFO_FILENAME);
            $basename = pathinfo($filename, PATHINFO_BASENAME);
            $el = "$content/$gallery_name";
            //echo $el;
            if (!is_dir($el)) mkdir($el, 0700);
            
            if ($mode == "extractonly") {
                 extract_zip($filename, $el);
                 header("location: /admin/upload");
            } else {
                 extract_zip($filename, $el);
                 $r = upload_batch($gallery_name, $el, $add_uploaded);
                 if ($r) {header("location: /admin/upload");} else {echo "-1";}
            }
        } elseif ($mode == "folder" && is_dir("$content/".$_GET["folder"])) {
			//var_dump($add_uploaded);
            $r = upload_batch($_GET["gallery"], "$content/".$_GET["folder"], $add_uploaded);
            if ($r) {header("location: /admin/upload");} else {echo "-1";}
        } elseif ($mode == "delete" && is_dir("$content/".$_GET["folder"])) {
            rrmdir("$content/".$_GET["folder"]);
            header("location: /admin/upload");
        } else {
            echo "-1";
        }
    }
?>