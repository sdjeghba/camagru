<?php

require __DIR__ . DIRECTORY_SEPARATOR . "content/layout/navbar.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./models/User.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./models/HandleDb.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./models/ViewsMsg.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "/models/Form.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "/models/pictures.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "/models/likes.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "/models/comments.php";


if (!empty($_SESION['online'])) {
    var_dump($_SESSION['online']);
}

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
?>

<body>
    <?php if (empty($_SESSION['online'])) {
        echo <<<HTML
        <div class="alert alert-info text-center" role="alert">
            <h4 class="alert-heading">Woooow</h4>
            Tu veux toi aussi pouvoir prendre des photos avec filtres ?
            <br />
            N'attend plus et rejoins-nous en cliquant ici : <a href="/controllers/sign_in_controller.php" class="alert-link">je m'inscris!</a>
        </div>
HTML;
    }
    else if (!empty($_SESSION['online'] && $_SESSION['online'] == 1)) {
        echo <<<HTML
        <div class="alert alert-info text-center" role="alert">
            <h5 class="alert-heading">Tu veux te prendre en photo toi aussi clique sur "GO!" juste ci-dessous !</h4>
            <a href="/camagru.php" class="btn btn-primary btn-lg active" role="button" title="camagru">GO!</a>
        </div>
HTML;
    }
    ?>
    <div class="container-fluid justify-content-center my-3">
        <div class="row justify-content-center">
            <div class="card-deck mx-3 my-5 justify-content-center">
            <?php
                $tab = $pictures->getPicturesConstraints($pictures_by_row, TRUE, $index, FALSE);
                foreach ($tab as $value): {
                    $id_pic = $value['id_picture'];
                    $user = !empty($_SESSION['username']) ? $_SESSION['username'] : "";
                    $like = new Likes($id_pic, $user);
                    $liked = $like->getLike();
                    $number_like = $like->likesNumber();
                    $comment = new Comments($id_pic, "", "");
                    $comments = $comment->getComments();
                    $number_comments = $comment->getCommentsNumber();
                    ?>
                    <div id="card-size" class="card-sm mx-2 my-3 border border-black">
                        <img class="img-card" src="data:image/jpeg;base64,<?= base64_encode($value['picture']) ?>"/>
                        <div class="card-body">
                        <?php  if (!empty($_SESSION) && !empty($_SESSION['username'])) {
                                if (!$liked): { ?>
                                    <button onclick="addLike(<?= $id_pic ?>)" class="like" ><img id=like_<?= $id_pic ?> src="/content/images/unliked.png"/></button><?php
                                }
                                else: { ?>
                                    <button onclick="addLike(<?= $id_pic ?>)" class="like" ><img id=like_<?= $id_pic ?> src="/content/images/liked.png"/></button><?php
                                }
                                endif;
                                ?><span class="like-police" id="likes_number<?= $id_pic ?>"><?= $number_like ?> j'aime </span>
                            <?php }
                            else {?>
                                <img src="/content/images/unliked.png"/></img>
                                <span class="like-police"><?= $number_like ?> j'aime</span>
                            <?php }?>
                            <!-- <img class="comment" src="/content/images/comment.png"/> -->
                            <img class="comment" src="/content/images/comment.png"/>
                            <span id="comments_number_<?= $id_pic ?>" class="comment-police"><?= $number_comments ?> commentaires</span>
                            <div class="card-text">
                            </div>
                            <?php if (!empty($_SESSION) && !empty($_SESSION['username'])) {?>
                                <p><a href="#modal-comment<?= $id_pic ?>" class="modal-js">Voir/Ajouter commentaires..</a></p>
                            <?php }?>
                            <?php require "modal.php"; ?>
                    </div>
                        <div class="card-footer">
                            <small class="text-muted">Photo prise par : <strong><?=$value['username'];?></strong></small>
                        </div>
                    </div>
                <?php $index++;}?>
                <?php endforeach; ?>
            </div>
        </div>        
             <div class="row justify-content-center">
                <ul class="pagination justify-content-between">
                    <?php if ($current_page > 1) { ?>
                    <li class="arrow"><a class="page-link rounded-circle" href="index.php?page=<?= $current_page - 1 ?>"><span class="fa fa-arrow-right"></span> ← </a></li>
                    <?php } ?>
                    <li class="justify-content-center"><?= $current_page?> / <?= $number_pages ? $number_pages : 1; ?></li>
                    <?php if ($current_page < $number_pages) { ?>
                    <li class="arrow"><a class="page-link rounded-circle" href="index.php?page=<?= $current_page + 1 ?>"><span class="fa fa-arrow-left">→</span></a></li>
                    <?php }?>
                </ul>
            </div>
    </div>
    <script src="modal.js"></script>
    <script type="text/javascript" src="/gallery.js"></script>
</body>

<?php require_once __DIR__ . "/content/layout/footer.php"?>