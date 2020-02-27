<?php

require __DIR__ . DIRECTORY_SEPARATOR . "content/layout/navbar.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./models/User.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./models/HandleDb.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./models/ViewsMsg.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "/models/Form.php";
if (!empty($_SESION['online'])) {
    var_dump($_SESSION['online']);
}
?>

<body>
<?php require_once 'views/index_view.php'; ?>
</body>

<?php require_once __DIR__ . "/content/layout/footer.php"?>