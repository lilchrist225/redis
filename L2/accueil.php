<?php
session_start();
include('../cnx.php');

// Assurez-vous que $_SESSION['matricule'] existe et n'est pas vide avant de l'utiliser dans la requête
if (isset($_SESSION['matricule']) && !empty($_SESSION['matricule'])) {
    $matricule = $_SESSION['matricule'];
    
    $requete = "SELECT * FROM l1_gi JOIN parrain_filleule_l2_l1 ON l1_gi.matricule = parrain_filleule_l2_l1.filleule_id WHERE parrain_id = ? ";
    $prepare = $cnx->prepare($requete);
    $prepare->execute([$matricule]);
    $nb = $prepare->rowCount();
    $affiche = $prepare->fetchAll(PDO::FETCH_ASSOC);
    if ($nb == 0){
        $requete2 = "SELECT * FROM l1_miage JOIN parrain_filleule_l2_l1_m ON l1_miage.matricule = parrain_filleule_l2_l1_m.filleule_id WHERE parrain_id = ? ";
        $prepare2 = $cnx->prepare($requete2);
        $prepare2->execute([$matricule]);
        $nb2 = $prepare2->rowCount();
        if ($nb2 > 0) {
            $affiche2 = $prepare2->fetchAll(PDO::FETCH_ASSOC);
            // Traitement des résultats de la deuxième requête ici
        }
    }


    $requete3 = "SELECT * FROM parrain_filleule_l3_l2_gi WHERE filleule_id= ?";
    $prepare3 = $cnx->prepare($requete3);
    $prepare3->execute([$matricule]);
    $nb3 = $prepare3->rowCount();
    $affiche3 = $prepare3->fetchAll(PDO::FETCH_ASSOC);


    $requete4 = "SELECT * FROM parrain_filleule_l3_l2_m WHERE filleule_id= ?";
    $prepare4 = $cnx->prepare($requete4);
    $prepare4->execute([$matricule]);
    $nb4 = $prepare4->rowCount();
    $affiche4 = $prepare4->fetchAll(PDO::FETCH_ASSOC);



}




?>





<!--

=========================================================
* Neumorphism UI - v1.0.0
=========================================================

* Product Page: https://themesberg.com/product/ui-kits/neumorphism-ui
* Copyright 2020 Themesberg MIT LICENSE (https://www.themesberg.com/licensing#mit)

* Coded by https://themesberg.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Primary Meta Tags -->
<title>Votre parrain</title>


<!-- Fontawesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Pixel CSS -->
<link type="text/css" href="stylee.css" rel="stylesheet">

<!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

<link rel="icon" type="image/png" href="logo.jpg">
<style>
    .table-container {
        margin-top: 50px;
    }
    td:hover {
        background-color: black;
        color: #f0f0f0;
    }
    .highlight {
        background-color: #44476a; /* Vert */
        color: #ffffff; /* Texte blanc pour une meilleure lisibilité */
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    .fadeIn {
        animation: fadeIn 1s ease-in-out;
    }
</style>

</head>

<body>
    <header class="header-global">
        <nav id="navbar-main" aria-label="Primary navigation" class="navbar navbar-main navbar-expand-lg navbar-theme-primary headroom navbar-light">
            <div class="container position-relative">
                <div class="navbar-brand shadow-soft py-2 px-3 rounded border border-light mr-lg-4">
                    <img class="navbar-brand-dark" src="logo.jpg" style="width: 50px; height: 50px; border-radius: 5px;" alt="Logo light">
                    <img class="navbar-brand-light" src="logo.jpg" style="width: 50px; height: 50px; border-radius: 5px;" alt="Logo dark">
                </div>
            </div>
        </nav>
    </header>
    <div>
        <!-- Hero -->
        <div class="section section-header">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8 text-center">
                        <h1 class="display-2 mb-4">Bienvenu chez REDIs</h1>
                        <p class="lead mb-7">Voici le nom de ton parrain pour l'année 2023 - 2024.</p>
                        <h2 class="mb-5">Bienvenue <?php echo $_SESSION['nom_prenom'] ?></h2>
                </div>
            </div>        
        </div>
        <!-- End of Hero section -->
        <section class="section section-lg pt-0">
            <div class="container card bg-primary shadow-soft border-light p-4">
                <div class="container mt-5 table-container">
    
                     
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Noms filleules</th>
                                    
                                    <th>Prenoms filleules</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                    if ($affiche) {
                                        foreach ($affiche as $result) {
                                            echo '<tr>';
                                            echo '<td rowspan="1" class="align-middle text-center">' . $result['filleule_nom'] . '</td>'. '<td rowspan="1" class="align-middle text-center">' . $result['prenom'] . '</td>' ;
                                            echo '</tr>';
                                        }
                                    } else if ($affiche2) {
                                        foreach ($affiche2 as $result2) {
                                            echo '<tr>';
                                            echo '<td rowspan="1" class="align-middle text-center">' . $result2['filleule_nom'] . '</td>' . '<td rowspan="1" class="align-middle text-center">' . $result2['prenom'] . '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        // Gérer le cas où il n'y a pas de résultat pour les deux requêtes
                                        echo '<tr><td colspan="2">Aucun résultat trouvé.</td></tr>';
                                    }
                                ?>
                            </tbody>
                            
                        </table>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nom et Prenoms Parrain</th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if ($affiche3) {
                                    foreach ($affiche3 as $result3) {
                                        echo '<tr>';
                                        echo '<td rowspan="1" class="align-middle text-center">' . $result3['parrain_nom'] . '</td>';
                                        echo '</tr>';
                                    }
                                } elseif ($affiche4) {
                                    foreach ($affiche4 as $result4) {
                                        echo '<tr>';
                                        echo '<td rowspan="1" class="align-middle text-center">' . $result4['parrain_nom'] . '</td>';
                                        echo '</tr>';
                                    }
                                }else {
                                    // Gérer le cas où il n'y a pas de résultat pour la troisième requête
                                    echo '<tr><td colspan="1">Aucun résultat trouvé pour les parrains de niveau 3.</td></tr>';
                                }
                                
                                ?>
                                
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section -->
        <section class="section section-lg pt-0">
            <div class="container">
                <div class="row align-items-center justify-content-around">
                    <div class="col-md-6 col-xl-6 mb-5">
                        <div class="card bg-primary shadow-soft border-light organic-radius p-3">
                            <img class="organic-radius img-fluid" src="Image.jpg" alt="modern desk">
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-5 text-center text-md-left" style="font-size: larger;">
                        <h2 class="h1 mb-4">Pourquoi un parrain ?</h2>
                        <p style="font-size: smaller;">Le système de parrainage a été mis en place pour plusieurs raisons. Tout d'abord, il favorise le partage de connaissances entre deux promotions (par exemple, L1 MIAGE et L2 MIAGE). Ensuite, il permet aux filleuls d'apprendre auprès de leurs devanciers afin d'éviter les mêmes erreurs. Enfin, il vise à consolider les relations entre les différentes promotions.</p>
                        <p style="font-size: small;">Vous pouvez contacter votre parrain dès maintenant. Bonne année! 😉🥳😊</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of section -->
    </div>

    <footer style="margin-top: -200px;" class="pb-5 border-light bg-primary">
    <div class="container">
        <hr class="my-5">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-center">
                    <img src="logo.jpg" style="width: 50px; height: 50px; border-radius: 5px;" class="mb-3">
                </div>
            <div class="d-flex text-center justify-content-center align-items-center" role="contentinfo">
                <p class="font-weight-normal font-small mb-0">Designed by the Informatics Club
                    <span class="current-year">2023</span></p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        // Ajoutez une classe d'animation à chaque cellule lorsqu'elle est cliquée
        $('td').click(function(){
            $(this).toggleClass('fadeIn');
        });

        // Barre de recherche
        $('#searchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase();

            // Réinitialise la couleur de fond pour tous les éléments
            $('td').removeClass('highlight');

            if (searchText === '') {
                // Si la barre de recherche est vide, réaffiche tous les tbody
                $('tbody').show();
            } else {
                // Sinon, masque les tbody qui ne correspondent pas à la recherche
                $('tbody').hide();
                $('tbody:contains("' + searchText + '")').show();

                // Applique la couleur verte uniquement aux cellules correspondantes
                $('td:contains("' + searchText + '")').addClass('highlight');
            }
        });

        // Fonction pour le filtrage de texte insensible à la casse
        jQuery.expr[':'].contains = function(a, i, m) {
            return jQuery(a).text().toLowerCase()
                .indexOf(m[3].toLowerCase()) >= 0;
        };
    });
</script>

</body>

</html>