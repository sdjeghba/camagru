<aside id="modal-comment<?= $id_pic ?>" class="modal" aria-hidden="true" role="dialog" style="display:none;">
    <div id="modal-wrapper" class="modal-wrapper js-modal-stop">
        <div id="card-size" class="card-sm mx-2 my-3">
            <img class="img-card" src="data:image/jpeg;base64,<?= base64_encode($value['picture']) ?>"/>
            <div class="card-body">
                <?php  if (!empty($_SESSION) && $_SESSION['username']): {
                        if (!$liked): { ?>
                            <button onclick="addLike(<?= $id_pic ?>)" class="like" ><img id=modal_like_<?= $id_pic ?> src="/content/images/unliked.png"/></button><?php
                        }
                        else: { ?>
                            <button onclick="addLike(<?= $id_pic ?>)" class="like" ><img id=modal_like_<?= $id_pic ?> src="/content/images/liked.png"/></button><?php
                        }
                        endif;
                    }
                    endif;
                ?>
                <img class="comment" src="/content/images/comment.png"/>
                <span id="modal_comments_n_<?= $id_pic ?>" class="comment-police"><?= $number_comments ?> commentaires</span>
                <span class="like-police" id="modal_likes_number_<?= $id_pic ?>"><?= $number_like ?> j'aime </span>
                <h5 class="card-title my-2 center">Commentaires</h5>
                <div class="card-text" id="first_comment_<?= $id_pic ?>">
                    <?php foreach ($comments as $row): {?>
                        <p class="comment"><b><?= $row->username; ?>: </b><?= $row->comment; ?></p>
                    <?php }?>
                    <?php endforeach; ?>
                </div>
                <input type="text" maxlength="255" onkeypress="{if (event.keyCode == 13) { event.preventDefault(); addComment(<?= $id_pic ?>, this, '<?= $user ?>')}}"
                class="inputcomment" id="new_comment_<?= $id_pic ?>" name="new_comment_<?= $id_pic ?>" placeholder="Ajouter un commentaire...">
            </div>
            <div class="card-footer">
                <small class="text-muted">Photo prise par : <strong><?=$value['username'];?></strong></small>
            </div>
        </div>
    </div>
    <button class="js-modal-close btn btn-danger">X</button>
</aside>   