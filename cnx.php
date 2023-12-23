<?php
try{
    $host="localhost";
    $base="students database";
    $user="root";
    $pws="";
    $cnx= new pdo("mysql:host=$host;dbname=$base",$user,$pws);
}
catch(Exception $e){
    die('Erreur :' . $e-> getMessage());
}



?>