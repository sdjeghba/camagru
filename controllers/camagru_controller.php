<?php

require_once dirname(__DIR__) . "/content/layout/navbar.php";
require_once dirname(__DIR__) . "/library/autoloader.php";

if (empty($_SESSION)): {
    viewsMsg::alertMessage("Vous n'êtes pas autorisé à acceder à cette page", "danger");
    viewsMsg::indexRedirection(3);
}
else: {
    if (empty($_SESSION['online'])): {
        viewsMsg::alertMessage("Vous n'êtes pas autorisé à acceder à cette page", "danger");
        viewsMsg::indexRedirection(3);
    }
    else: {
        require_once dirname(__DIR__) . "/views/camagru_view.php";
    }
    endif;
}
endif;
require_once dirname(__DIR__) . "/content/layout/footer.php";