<?php
spl_autoload_register('autoloaderApp');

function autoloaderApp($classname) {
	$path = dirname(__DIR__) . DIRECTORY_SEPARATOR . "models/";
	$extension = ".class.php";
	$full_path = $path . $classname . $extension;

	if (!file_exists($full_path)) {
        echo "can't find the file class : " . $full_path;
		return FALSE;
	}
	require_once $full_path;
}