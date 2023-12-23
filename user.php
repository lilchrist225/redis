<?php

include("cnx.php");

// Récupération des étudiants de L1
$requete = "SELECT * FROM l1_gi";
$prepare = $cnx->prepare($requete);
$execute = $prepare->execute();
if ($execute) {
    $filleules = $prepare->fetchAll();
} else {
    $errorInfo = $prepare->errorInfo();
    echo "Erreur d'exécution de la requête L1 : " . $errorInfo[2];
}

// Récupération des étudiants de L2
$requete2 = "SELECT * FROM l2_gi";
$prepare2 = $cnx->prepare($requete2);
$execute2 = $prepare2->execute();
if ($execute2) {
    $parrains = $prepare2->fetchAll();
} else {
    $errorInfo2 = $prepare2->errorInfo();
    echo "Erreur d'exécution de la requête L2 : " . $errorInfo2[2];
}

// Calcul du nombre de filleules que chaque parrain devrait avoir en moyenne
$numParrains = count($parrains);
echo $numParrains;
$numFilleules = count($filleules);
echo $numFilleules;
$numFilleulesParParrain = floor($numFilleules / $numParrains);
echo $numFilleulesParParrain;

// Mélange aléatoire des parrains et des filleules
shuffle($parrains);
shuffle($filleules);

// Attribution des parrains et filleules tout en garantissant à chaque filleule un parrain
// $filleuleIndex = 0;

// foreach ($parrains as $parrain) {
//     $parrainId = $parrain['Matricules'];
//     $parrainName = $parrain['Noms'];
//     echo "<br>";
//     echo $parrainId;
//     echo $parrainName;
//     for ($i = 0; $i < $numFilleulesParParrain; $i++) {
//         if ($filleuleIndex < $numFilleules) {
//             $filleuleId = $filleules[$filleuleIndex]['Matricules'];
//             $filleuleName = $filleules[$filleuleIndex]['Noms'];
//             echo $filleuleId;
//             echo $filleuleName;
//             // Insertion dans la table 'parrain_filleule' 
//             $insertionRequete = "INSERT INTO parrain_filleule (filleule_id, filleule_nom, parrain_id, parrain_nom) VALUES (?, ?, ?, ?)";
//             // Utilisation de la requête préparée ici
//             $insertionPrepare = $cnx->prepare($insertionRequete);
//             $insertionExecute = $insertionPrepare->execute([$filleuleId, $filleuleName, $parrainId, $parrainName]);

//             if (!$insertionExecute) {
//                 $errorInfoInsertion = $insertionPrepare->errorInfo();
//                 echo "Erreur lors de l'insertion : " . $errorInfoInsertion[2];
//             }

//             $filleuleIndex++;
//             echo "<br>";
//             echo $filleuleIndex;
//         } else {
//             break; // Tous les filleules ont été attribuées
//         }
//     }

//     if ($filleuleIndex >= $numFilleules) {
//         break; // Tous les filleules ont été attribuées
//     }
// }

$parrainIndex = 0;

foreach ($filleules as $filleule) {
    $parrain = $parrains[$parrainIndex % count($parrains)]; // Sélection du parrain

    $parrainId = $parrain['matricule'];
    $parrainName = $parrain['nom_prenom'];

    $filleuleId = $filleule['matricule'];
    $filleuleName = $filleule['Nom'];

    // Simulation de l'insertion dans la table 'parrain_filleule'
    // echo "Filleule ID: $filleuleId, Filleule Nom: $filleuleName, Parrain ID: $parrainId, Parrain Nom: $parrainName <br>";
    // Insertion dans la table 'parrain_filleule' 
    $insertionRequete = "INSERT INTO parrain_filleule_l2_l1 (filleule_id, filleule_nom, parrain_id, parrain_nom) VALUES (?, ?, ?, ?)";
    // Utilisation de la requête préparée ici
    $insertionPrepare = $cnx->prepare($insertionRequete);
    $insertionExecute = $insertionPrepare->execute([$filleuleId, $filleuleName, $parrainId, $parrainName]);
    if (!$insertionExecute) {
        $errorInfoInsertion = $insertionPrepare->errorInfo();
            echo "Erreur lors de l'insertion : " . $errorInfoInsertion[2];
        }

    $parrainIndex++;

    if ($parrainIndex >= count($parrains)) {
        $parrainIndex = 0; // Réinitialisation de l'index des parrains
    }
}
echo "Attribution et insertion terminées.";
?>

