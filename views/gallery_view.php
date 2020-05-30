<body>
    <?php if (empty($_SESSION['online'])) {
        echo <<<HTML
        <div class="alert alert-info text-center" role="alert">
            <h4 class="alert-heading">Woooow</h4>
            Tu veux toi aussi pouvoir prendre des photos avec filtres ?
            <br />
            N'attend plus et rejoins-nous en cliquant ici : <a href="/controllers/sign_in_controller.php" class="alert-link">JE M'INSCRIS!</a>
        </div>
HTML;
    }
    else if (!empty($_SESSION['online'] && $_SESSION['online'] == 1)) {
        echo <<<HTML
        <div class="alert alert-info text-center" role="alert">
            <h5 class="alert-heading">Tu veux te prendre en photo toi aussi clique sur "J'y vais!" juste ci-dessous !</h4>
            <a href="/controllers/camagru_controller.php" class="btn btn-primary btn-lg active" role="button" title="camagru">J'y vais!</a>
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
                            <?php require __DIR__ . "/modal_view.php"; ?>
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
    <script src="/js/modal.js"></script>
    <script type="text/javascript" src="/js/gallery.js"></script>
</body>