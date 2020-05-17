<?php 
require __DIR__ . "/content/layout/navbar.php";
require_once __DIR__ . DIRECTORY_SEPARATOR ."./models/viewsMsg.class.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "/models/pictures.class.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "/models/likes.class.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "/models/comments.class.php";

if (empty($_SESSION) || empty($_SESSION['online']) || $_SESSION['online'] != 1):
    viewsMsg::alert_message("Vous n'avez pas accès à cette page" ,"danger");
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
?>

<body>
    <div class="container-fluid justify-content-center my-3">
        <div class="row justify-content-center">
            <div class="card-deck mx-3 my-5 justify-content-center">
            <?php
                $tab = $pictures->getPicturesConstraints($pictures_by_row, TRUE, $index, TRUE);
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
                        <img onclick="deletePicture(<?= $id_pic ?>)" id="delete_<?= $id_pic ?>" src="redcross.png" alt="" class="delete_picture">
                        <img class="img-card" src="data:image/jpeg;base64,<?= base64_encode($value['picture']) ?>"/>
                        <div class="card-body">
                        <?php  if (!empty($_SESSION) && $_SESSION['username']): {
                                if (!$liked): { ?>
                                    <button onclick="addLike(<?= $id_pic ?>)" class="like" ><img id=like_<?= $id_pic ?> src="/content/images/unliked.png"/></button><?php
                                }
                                else: { ?>
                                    <button onclick="addLike(<?= $id_pic ?>)" class="like" ><img id=like_<?= $id_pic ?> src="/content/images/liked.png"/></button><?php
                                }
                                endif;
                            }
                            endif;?>
                            <span class="like-police" id="likes_number<?= $id_pic ?>"><?= $number_like ?> j'aime </span>
                            <img class="comment" src="/content/images/comment.png"/>
                            <span id="comments_number_<?= $id_pic ?>" class="comment-police"><?= $number_comments ?> commentaire<?= $number_comments > 1 ? "s" : ""; ?></span>
                            <div class="card-text">
                            </div>
                            <?php if (!empty($_SESSION) && !empty($_SESSION['username'])) {?>
                                <a href="#modal-comment<?= $id_pic ?>" class="modal-js">Voir/Ajouter commentaires..</a>
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
                    <li class="arrow"><a class="page-link rounded-circle" href="my_gallery.php?page=<?= $current_page - 1 ?>"><span class="fa fa-arrow-right"></span> ← </a></li>
                    <?php } ?>
                    <li class="justify-content-center"><?= $current_page?> / <?= $number_pages ? $number_pages : 1; ?></li>
                    <?php if ($current_page < $number_pages) { ?>
                    <li class="arrow"><a class="page-link rounded-circle" href="my_gallery.php?page=<?= $current_page + 1 ?>"><span class="fa fa-arrow-left">→</span></a></li>
                    <?php }?>
                </ul>
            </div>
    </div>
    <script src="modal.js"></script>
    <script type="text/javascript" src="/gallery.js"></script>
</body>
</html>
<?php }
endif; 