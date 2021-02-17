<?php
session_start();
require "config/connexion.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);

    if (isset($login) && isset($motdepasse)) {
        extract($_POST);
        $requete = $bdd->query('select * from utilisateur where login_utilisateur = "'.$login.'" and mot_passe_utilisateur = "'.$motdepasse.'"');
        if ($stmt= $requete->fetch()) {
            $_SESSION['connecte'] = $stmt['id_utilisateur'];
            $_SESSION['id_etablissement'] = $stmt['id_etablissement'];
            $_SESSION['id_departement'] = $stmt['id_departement'];
            $_SESSION['id_type_utilisateur '] = $stmt['id_type_utilisateur'];
            header('Location:pages/index.php');
        } else {
            $_SESSION['connecte'] = "";
            $_SESSION['error_message'] = "votre nom d'utilisateur ou votre mot de passe est incorrecte";
        }


    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>connexion à sdap</title>
    <link rel="stylesheet" href="src/css/login.css">
    <link rel="stylesheet" href="src/css/bootstrap.min.css">

</head>
<body>


<div class="container-fluid">
    <div class="row d-flex">
        <div class="col-lg-6">
            <div class="card1 pb-5">
                <div class="row px-3 justify-content-center mt-4 mb-5 border-line"><img
                            src="src/img/uNGdWHi.png" class="image"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card2 card border-0 px-4 py-5">
                <div class="row mb-4 px-3">
                    <h3 class="mb-0 mr-4 mt-2 text-uppercase text-primary">Bienvenue sur le <b>S</b>ystème de
                        <b>D</b>ETERMINATION
                        <b>A</b>UTOMATIQUE DES <b>P</b>OINTS
                        D’ADMISSIBILTE EN MASTER 1</h3>
                </div>

                <?php if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])): ?>
                    <p class="text-white bg-danger p-2"><?= $_SESSION['error_message'] ?></p>
                <?php endif; ?>

                <form method="post">
                    <div class="row px-3"><label class="mb-1">
                            <h6 class="mb-0 text-sm">nom d'utilisateur</h6>
                        </label> <input class="mb-4" type="text" name="login"
                                        placeholder="Entrez votre nom d'utilisateur" required>
                    </div>
                    <div class="row px-3"><label class="mb-1">
                            <h6 class="mb-0 text-sm">mot de passe</h6>
                        </label> <input type="password" name="motdepasse" placeholder="Entrez votre mot de passe" required maxlength="255">
                    </div>

                    <div class="row mb-3 px-3 mt-3">
                        <button type="submit" class="btn rounded-0 btn-primary text-center">se connecter</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="row fixed-row-bottom">
        <div class="col-12 bg-blue py-4 mt-5">
            <div class="row px-3"><small class="ml-4 ml-sm-5 mb-2">Copyright &copy; 2020. Université de Cocody.</small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js	"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

</body>
</html>