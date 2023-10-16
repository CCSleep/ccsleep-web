<?php
   // ini_set("display_errors", 1);
    // var_dump(scandir("../../common"));
    require_once "../../common/conn.php";
    require_once "../../common/s3_credentials.php";
	require_once "../../common/thumbimage.php";
    
    function format_uuidv4($data) {
      assert(strlen($data) == 16);
    
      $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
      $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        
      return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    
    function upload_to_s3($server_loc, $file_loc, $bucket) {
        global $s3;
        $r = $s3->putObject(array(
            'Bucket' => $bucket,
			'Key'    => $server_loc,
			'SourceFile' => $file_loc
        ));
        return $r;
    }
    function extract_zip($zip_file, $path) { 
        $zip = new ZipArchive;
        
        
        if ($zip->open($zip_file) === TRUE) {
            $zip->extractTo($path);
            $zip->close();
        }
    }
    function upload_batch($gallery_name, $path, $add_uploaded = true) {
        global $db, $bucket_name;
        
            $allowed = array("jpg", "png", "webp");
            foreach (scandir($path) as $f) {
                $fullpath = "$path/$f";
                $ext = pathinfo($fullpath, PATHINFO_EXTENSION);
                if (!in_array(strtolower($ext), $allowed)) continue;
                if (is_dir($fullpath)) continue;
                
                $filename = pathinfo($fullpath, PATHINFO_FILENAME);
                $c = explode("__", $filename);
                $layer_tag_list = array();
                if (count($c) === 2) {
                    $cfg = explode("+", $c[1]);
                    foreach ($cfg as $i) {
                        $cmd = substr($i, 0, 1);
                        $v = substr($i, 1);
                        switch($cmd) {
                            case "@":
                                array_push($layer_tag_list, $v);
                                break;
                            case "&":
                                goto ct;
                                break; 
                            default:
                                break;
                        }
                    }
                }
                
                $uuid = format_uuidv4(random_bytes(16));
                $fn = $db->real_escape_string("$uuid.$ext");
                $rfn = $db->real_escape_string("{$c[0]}.$ext");
                $gallery_name = $db->real_escape_string($gallery_name);
                //print_r("INSERT INTO media VALUES (NULL, '$uuid', '$gallery_name', '$rfn', '$gallery_name/$fn', '$gallery_name/tn/$fn')");
                $r = $db->query("INSERT INTO media VALUES (NULL, '$uuid', '$gallery_name', '$rfn', '$gallery_name/$fn', '$gallery_name/tn/$uuid.webp')");
                foreach ($layer_tag_list as $i) {
                    $i = $db->real_escape_string($i);
                    $db->query("INSERT INTO media_layer_tag VALUES (NULL, '$uuid', '$i')");
                    
                }
                
				
                upload_to_s3("$gallery_name/$fn", "$path/$f", $bucket_name);
                createThumbnail("$path/$f", "$path/thumb_$uuid.webp", 500);
				upload_to_s3("$gallery_name/tn/$uuid.webp", "$path/thumb_$uuid.webp", $bucket_name);
				unlink("$path/thumb_$uuid.webp");
				if ($add_uploaded) {
					 if (count($c) === 2) {
					 	rename($fullpath, "$path/{$c[0]}+&.$ext");
					 } else {
					 	rename($fullpath, "$path/{$c[0]}__&.$ext");
					 }
				}
                ct:
            }
            return true;
       
    }
    // echo upload_batch("kokoro-cosplay", "tmp/1691475971/kokoro-cosplay.zip");
?>