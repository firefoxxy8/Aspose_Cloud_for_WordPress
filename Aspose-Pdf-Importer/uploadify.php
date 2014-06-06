<?php

$targetFolder = $_REQUEST['folder'];


if (!empty($_FILES)) {
    //mysql_query("UPDATE wp_posts SET post_title = 'Fahad Hello World!' WHERE ID = 1");

	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $targetFolder;
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];

	// Validate the file type
	$fileTypes = array('pdf'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
    $file_name   = $fileParts['filename'] . '.' . $fileParts['extension'];

	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
        echo  $file_name;
	} else {
        echo 'Invalid file type.';
	}
}
?>