<?php
    require $_SERVER["DOCUMENT_ROOT"]."/common/aws.phar";
    $bucket_name        = "";
    $account_id         = "";
    $access_key_id      = "";
    $access_key_secret  = "";
    
    $credentials = new Aws\Credentials\Credentials($access_key_id, $access_key_secret);
    
    $options = array(
        'region' => 'auto',
        'endpoint' => "https://$account_id.r2.cloudflarestorage.com",
        'version' => 'latest',
        'credentials' => $credentials
    );
    
    $s3 = new Aws\S3\S3Client($options);
?>