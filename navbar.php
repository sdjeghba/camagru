<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Camagru</title>
</head>
<nav class="navbar navbar-dark bg-dark">
    <a href="/index.php" class="navbar-brand">
        <img src="/src/img/camera.png" width="30" height="30" alt="icon camera" class="d-inline-block align-top">
        Camagru
    </a>
    <?php
    if (!isset($_SESSION['connected']) || (isset($_SESSION['connected']) && $_SESSION['connected'] == 0)): {
       echo <<<HTML
        <form action="/login.php" class="form-inline" method="post">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">@</span>
                </div>
            </div>
            <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="username">
            <input type="password" class="form-control" placeholder="Password" name="pwd">
            <button class="btn btn-primary">Se connecter</button>
            <a href="#" class="text-warning mx-2" style="font-size:0.8em; font-style:italic">Mot de passe oublié ?</a>
        </form>        
HTML;
    }
    else: {
        echo <<<HTML
            <p class="text-success px-4 my-auto">Connecté
            <img src="src/img/user.png" width="30" height="30" alt="icon camera" class="d-inline-block align-top mx-3">
            <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
            </p>
HTML;
    }
    endif; ?>
</nav>