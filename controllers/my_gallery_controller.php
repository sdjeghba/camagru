<?php 

require_once dirname(__DIR__) . "/content/layout/navbar.php";
require_once dirname(__DIR__) . "/library/autoloader.php";

if (empty($_SESSION) || empty($_SESSION['online']) || $_SESSION['online'] != 1):
    viewsMsg::alertMessage("Vous n'avez pas accès à cette page" ,"danger");
else: {
    $username = $_SESSION['username'];
    $pictures = new Pictures("", $username, "");
    $pictures_total = $pictures->getUserPicturesNumber();
    $pictures_by_row = 8;
    $pictures_by_page = 8;
    $number_pages = ceil($pictures_total / $pictures_by_page);

    if (isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $number_pages): {
        $_GET['page'] = intval($_GET['page']);
        $current_page = $_GET['page'];
    }
    else:
        $current_page = 1;
    endif;
    $index = ($current_page - 1) * $pictures_by_page;
    require dirname(__DIR__) . "/views/my_gallery_view.php";
}
endif; 