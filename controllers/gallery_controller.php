<?php

$pictures = new Pictures("", "", "");
$pictures_total = $pictures->getPicturesNumber();
$pictures_by_row = 8;
$pictures_by_page = 8;
$number_pages = ceil($pictures_total / $pictures_by_page);

if (isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $number_pages) {
    $_GET['page'] = intval($_GET['page']);
    $current_page = $_GET['page'];
}
else {
    $current_page = 1;
}
$index = ($current_page - 1) * $pictures_by_page;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "views/gallery_view.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "content/layout/footer.php";