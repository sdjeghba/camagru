<?php require_once __DIR__ . "/content/layout/navbar.php" ?>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-8 mx-4 my-4 text-center">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                     Prenez vous en photo !
                    </div>
                    <div class="card-body" id="webcam_container">
                        <video autoplay="true" id="videoElement">
                            <script src="/webcam.js"></script>
                        </video>
                        <button id="startbutton">Take photo</button>
                    </div>  
                </div>
            </div>
            <div class="col-3 mx-3 my-4 text-center">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                     Vos dernières prises photos
                    </div>
                    <div class="card-body">
                        <p class="success">Done!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php require_once __DIR__ . "/content/layout/footer.php"?>