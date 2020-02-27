<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/content/css/bootstrap.css"">
    <link rel="stylesheet" href="/content/css/camagru.css"">
    <title>Camagru</title>
</head>
<nav class="navbar navbar-dark bg-dark">
    <a href="/index.php" class="navbar-brand">
        <img src="/content/images/camera.png" width="30" height="30" alt="icon camera" class="d-inline-block align-top">
        Camagru
    </a>
    <?php
    if (!isset($_SESSION['online']) || (isset($_SESSION['online']) && $_SESSION['online'] == 0)): {
       echo <<<HTML
        <form action="/controllers/log_in_controller.php" class="form-inline" method="post">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">@</span>
                </div>
            </div>
            <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="username" required>
            <input type="password" class="form-control" placeholder="Password" name="pwd" required>
            <button class="btn btn-primary">Se connecter</button>
            <a href="/controllers/resend_password_controller.php" class="text-warning mx-2" style="font-size:0.8em; font-style:italic">Mot de passe oublié ?</a>
        </form>        
HTML;
    }
    else: {
        echo <<<HTML
            <p class="text-success px-4 my-auto">Connecté
            <a href="/controllers/account_controller.php"><img src="/content/images/user.png" width="30" height="30" alt="icon camera" class="d-inline-block align-top mx-3"></a>
            <a href="/controllers/logout.php" class="btn btn-danger">Se déconnecter</a>
            </p>
HTML;
    }
    endif; ?>
</nav>