<?php
session_start();
include("../cnx.php");

if (isset($_POST['connecter'])) {
    $matricule = $_POST['matricule'];
    $table = array($matricule, $matricule); // Utilisation de $matricule deux fois pour la requête UNION
    $requete = "SELECT * FROM l2_miage WHERE matricule = ? 
                UNION 
                SELECT * FROM l2_gi WHERE matricule = ?";
    $prepare = $cnx->prepare($requete);
    $execute = $prepare->execute($table);
    $affiche = $prepare->fetchAll(PDO::FETCH_ASSOC); // Récupération de toutes les lignes correspondantes

    if ($affiche) {
        foreach ($affiche as $result) {
            $_SESSION['matricule'] = $result['matricule'];
            $_SESSION['matricule'] = $result['matricule']; // Assurez-vous que cela correspond au nom de colonne
            $_SESSION['nom_prenom'] = $result['nom_prenom']; // Assurez-vous que cela correspond au nom de colonne
            
            $_SESSION['nom_prenom'] = $result['nom_prenom']; // Assurez-vous que cela correspond au nom de colonne
            header('location: accueil.php');
            exit(); // Arrêt de l'exécution une fois la redirection effectuée
        }
    } else {
        $msg = "Matricule incorrect";
    }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Primary Meta Tags -->
<title>se connecter</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Pixel CSS -->
<link type="text/css" href="stylee.css" rel="stylesheet">
<link rel="icon" type="image/png" href="logo.jpg">

</head>

<body>
    <main>
        <!-- Section -->
        <section class="min-vh-100 d-flex bg-primary align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6 justify-content-center">
                        <div class="card bg-primary shadow-soft border-light p-4">
                            <div class="card-header text-center pb-0">
                                <h2 class="h4">Bienvenu chez REDIs</h2>  
                            </div>
                            <div class="card-body">
                                <form action="index.php" method="post" class="mt-">
                                    <!-- Form -->
                                    <div class="form-group">
                                        <label for="exampleInputIcon3">Votre Matricule</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><span class="fas fa-address-card"></span></span>
                                            </div>
                                            <input class="form-control" id="exampleInputIcon3" placeholder="XXINFXXXXXX"   type="text" aria-label="email adress" name="matricule">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-block btn-primary" name = "connecter">Se connecter</button>
                                </form>
                                <?php

                                    echo (isset($msg)?$msg:"") ;

                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</body>

</html>