<?php require_once __DIR__ . "/content/layout/navbar.php" ?>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-7 mx-4 my-4 text-center">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                     Prenez vous en photo !
                    </div>
                    <div class="card-body my justify-content-center">
                        <div class="webcam_container">
                            <video autoplay="true" id="videoElement"></video>
                        </div>
                        <br>
                        <button type="button" id="capture" class="btn btn-primary">Capture !</button>
                    </div>

                </div>       
            </div>
            <div class="col-4 mx-3 my-4 text-center">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                     Vos dernières prises photos
                    </div>
                    <div class="card-body">
                        <canvas id="picture" class="canvas"></canvas>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
                            <script src="/script.js"></script>

<?php require_once __DIR__ . "/content/layout/footer.php"?>