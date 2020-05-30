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
        <div class="card-deck my-5 mx-5">
            <?php
                $tab = $pictures->get_index_pictures($index, $pictures_by_row);
                foreach($tab as $row){
                HTMLViews::card_views($row->img);
                $index++;
            } ?>
        </div>
        <div class="card-deck my-5 mx-5">
            <?php
                $tab = $pictures->get_index_pictures($index, $pictures_by_row);
                foreach($tab as $row){
                HTMLViews::card_views($row->img);
                $index++;
            } ?>
        </div>
    </div>
</body>