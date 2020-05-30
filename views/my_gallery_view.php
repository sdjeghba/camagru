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
                        <img onclick="deletePicture(<?= $id_pic ?>)" id="delete_<?= $id_pic ?>" src="/content/images/redcross.png" alt="" class="delete_picture">
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
                            <?php require dirname(__DIR__) . "/views/modal_view.php"; ?>
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
                    <li class="arrow"><a class="page-link rounded-circle" href="my_gallery_controller.php?page=<?= $current_page - 1 ?>"><span class="fa fa-arrow-right"></span> ← </a></li>
                    <?php } ?>
                    <li class="justify-content-center"><?= $current_page?> / <?= $number_pages ? $number_pages : 1; ?></li>
                    <?php if ($current_page < $number_pages) { ?>
                    <li class="arrow"><a class="page-link rounded-circle" href="my_gallery_controller.php?page=<?= $current_page + 1 ?>"><span class="fa fa-arrow-left">→</span></a></li>
                    <?php }?>
                </ul>
            </div>
    </div>
    <script src="/js/modal.js"></script>
    <script type="text/javascript" src="/js/gallery.js"></script>
</body>
</html>