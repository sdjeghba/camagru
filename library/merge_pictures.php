<?php

$tmpimg = $_POST['picture'];
$picture = imagecreatefromstring(base64_decode($tmpimg));
$tmpfilter = $_POST['filter'];
$filter = imagecreatefrompng(dirname(__DIR__)."/content/filters/img".$tmpfilter.".png");

imagealphablending($filter, false);
imagesavealpha($filter, true);

imagecopy($picture, $filter, 0, 0, 0, 0, 320, 240);
ob_start();
imagejpeg($picture, null, 100);
$contents = ob_get_contents();
ob_end_clean();

echo json_encode(base64_encode($contents));
imagedestroy($picture);
imagedestroy($filter);