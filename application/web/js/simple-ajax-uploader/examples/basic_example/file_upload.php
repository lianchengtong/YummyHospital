<?php
require(dirname(__FILE__) . '/../../extras/Uploader.php');

// Directory where we're storing uploaded images
// Remember to set correct permissions or it won't work
$upload_dir = '/home/rogee/project/website/YummyHospital/application/web/upload/';

$uploader = new FileUpload('uploadfile');

// Handle the upload
$result = $uploader->handleUpload($upload_dir);

if (!$result) {
    exit(json_encode(['success' => false, 'msg' => $uploader->getErrorMsg()]));
}

echo json_encode(['success' => true]);
