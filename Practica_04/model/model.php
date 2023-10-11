<?php

//Funcio que retorna la llista de tots els articles
 function select($conection , $inici, $paginaActual, $_POSTSperPagina){
    $sql = "SELECT * FROM `articles`";

    $statmet = $conection->prepare($sql);
    
    // Executem la consulta
    
    $statmet -> execute();
    
    $resultat = $statmet->fetchAll();
    
    $llista = '';
    
    foreach($resultat as $fila){
        if($fila['Id'] > $inici && $fila['Id'] <= $inici + $_POSTSperPagina){
            $llista .= "<li>". $fila['Id'] . " - " . $fila['Article'] ."</li>";

        }else{
            $llista .= "";
        }
    }

    return $llista;
    
 }

 // retorna el total d'articles
 function totalArticles($conection){
    $sql = "SELECT * FROM `articles`";

    $statmet = $conection->prepare($sql);
    
    // Executem la consulta
    
    $statmet -> execute();
    
    //rowcount et torna el numero total d'article
    return $statmet->rowCount();    
    
 }

 function insertarUsuari($nom, $email, $password){
    $conection = new PDO('mysql:host=localhost;dbname=pt04_sergi_sanahuja', 'root', '');
    $sql = "INSERT INTO `usuaris`(`Usuari`, `Contrasenya`, `correu`) VALUES ('$nom', '$password', '$email')";
    $statmet = $conection->prepare($sql);
    $statmet -> execute();
 }

 function comprovarUsuari($email){
    $conection = new PDO('mysql:host=localhost;dbname=pt04_sergi_sanahuja', 'root', '');
    $sql = "SELECT * FROM `usuaris` WHERE `correu` = '$email'";
    $statmet = $conection->prepare($sql);
    $statmet -> execute();
    $resultat = $statmet->fetchAll();
    return $resultat;
 }

?>