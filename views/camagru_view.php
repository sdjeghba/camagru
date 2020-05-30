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
                        <div class="row justify-content-center my-2">
                            <button id="photo-button" class="btn btn-primary mx-2" disabled>Capture</button>
                            <button id="save-button" class="btn btn-primary mx-2" disabled>Sauvegarder</button>
                        </div>
                        <div class="row justify-content-center my-2">
                            <form id="choices">
                            <label for="choices">Filtres :</label>
                            <input type="radio" id="img1" name="choice" onclick="radio_selected(1)">
                            <label for="img1">Pikachu</label>
                            <input type="radio" id="img2" name="choice" onclick="radio_selected(2)">
                            <label for="img2">Obito</label>
                            <input type="radio" id="img3" name="choice" onclick="radio_selected(3)">
                            <label for="img3">Super Sayan</label>
                            </form>
                        </div>

                    </div>
                    <p style="font-style:italic;">Vous pouvez aussi télécharger une photo de votre appareil si vous ne possédez pas de webcam! Formats acceptés .png ou.jpg pour un fichier de 1.5 mo maximum</p>
                    <!-- <label class="file" title="Aucun fichier choisi">
                    <input type="file" accept="image/*" name="uploadimg" id="uploadimg" onchange="this.parentNode.setAttribute('title', this.value.replace(/^.*[\\/]/, ''))" />
                    </label> -->
                    <div class="row px-4 justify-content-center">
                        <span class="filelabel mx-2">Fichier : </span>
                        <span class=filelabelinput>
                            <input type="file" accept="image/*" name="uploadimg" id="uploadimg" style="display:none;" onchange="changeLabel()"/>
                            <label for="uploadimg" id="labeltext">Cliquer ici pour télécharger une photo</label> </span>
                        </span>
                    </div>
                    <br>
                    <input id="submitupload" class="submitbutton submitdisabled" type="submit" value="Fusionner les images" name="submit" disabled>
                </div>
             </div>
             <div id="mypictures" class="col-lg-4 mx-3 my-4 text-center">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                     Vos dernières prises photos
                    </div>
                    <div id="side" class="card-body display_min">
                    <?php
                        $pic = new Pictures("", $_SESSION['username'], "");
                        $tab = $pic->getPicturesConstraints(20, FALSE, 0, TRUE);
                        foreach ($tab as $value): ?>
                        <div class="display_min">
                            <img onclick="deletePicture(<?= $value['id_picture'] ?>)" id="delete_<?= $value['id_picture'] ?>" src="/content/images/redcross.png" alt="" class="delete_picture"/>
                            <img class="miniature" src="data:image/jpeg;base64,<?= base64_encode($value['picture']) ?>"/>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</body>

<script src="/js/gallery.js"></script>
<script src="/js/webcam.js"></script>