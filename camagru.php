<?php
require_once __DIR__ . "/content/layout/navbar.php";
require_once 'models/pictures.php';


if (empty($_SESSION))
    ViewsMsg::alert_message("Vous n'êtes pas autorisé à acceder à cette page", "danger");
else {
    if (empty($_SESSION['online']))
        ViewsMsg::alert_message("Vous n'êtes pas autorisé à acceder à cette page", "danger");
    else {
        echo "connected = " . $_SESSION['online'];
        echo "connected = " . $_SESSION['username'];
?>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-7 mx-4 my-4 text-center">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        Prenez vous en photo !
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="webcam">
                                <img id="imgsrc" class="pngfont" src="" alt="">
                                <video id="video" autoplay></video>
                            </div>
                            <canvas id="canvas" width="320px" height="240px"></canvas>
                        </div>
                        <button id="photo-button" class="btn btn-primary" disabled>Capture</button>
                            <button id="save-button" class="btn btn-primary">Sauvegarder</button>
                            <form id="choices">
                            <input type="radio" id="img1" name="choice" onclick="radio_selected(1)">
                            <label for="img1">One</label>
                            <input type="radio" id="img2" name="choice" onclick="radio_selected(2)">
                            <label for="img2">Eyes</label>
                            <input type="radio" id="img3" name="choice" onclick="radio_selected(3)">
                            <label for="img3">Dragon ball</label>
                            </form>
                    </div>
                    <p class="">Vous pouvez aussi télécharger une photo</p>
                    <label class="file" title="">
                    <input type="file" accept="image/*" name="uploadimg" id="uploadimg" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                    </label>
                    <input id="submitupload" type="submit" value="Fusionner les images" name="submit" disabled>
                </div>
             </div>
             <div id="mypictures" class="col-lg-4 mx-3 my-4 text-center">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                     Vos dernières prises photos
                    </div>
                    <div id="side" class="card-body">
                    <?php
                        $pic = new Pictures("", $_SESSION['username'], "");
                        $tab = $pic->getPicturesConstraints(20, FALSE, 0, TRUE);
                        foreach ($tab as $value): ?>
                        <img class="miniature" src="data:image/jpeg;base64,<?= base64_encode($value['picture']) ?>"/>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</body>

<script src="webcam.js"></script>
<?php require_once __DIR__ . "/content/layout/footer.php"?>
<?php }} ?>