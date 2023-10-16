<?php 
/*****************Sergi Sanahuja*******************/

require '../model/model.php';


// Ens connectem a la base de dades	
try{
    $conection = new PDO('mysql:host=localhost;dbname=pt04_sergi_sanahuja', 'root', '');
    
   

    
// Establim el numero de pagina en la que l'usuari es troba.
# si no troba cap valor, assignem la pagina 1.
//Constante con el número de resultados por página: 3    
    $paginaActual = isset($_REQUEST['pagina']) ? (int) $_REQUEST['pagina'] : 1; 
    

// definim quants post per pagina volem carregar.
# Si no troba cap valor, assignem 5 posts per pagina.
    
   $_POSTSperPagina = isset($_POST['numArticles']) ? (int)$_POST['numArticles'] : 5;

// Revisem des de quin article anem a carregar, depenent de la pagina on es trobi l'usuari.
# Comprovem si la pagina en la que es troba es més gran d'1, sino carreguem des de l'article 0.
# Si la pagina es més gran que 1, farem un càlcul per saber des de quin post carreguem
    
if($paginaActual > 1){
    $inici = ($paginaActual * $_POSTSperPagina - $_POSTSperPagina);
}else{
    $inici = 0;
}

// Preparem la consulta SQL  
    
$llista = select($conection, $inici, $paginaActual, $_POSTSperPagina);   
     
  
// Comprovem que hagui articles, en cas contrari, rediriguim
    if(!$llista){
        header('Location: index.php?pagina=1');
    }

// Calculem el total d'articles per a poder conèixer el número de pàgines de la paginació
    $totalArticles = totalArticles($conection);


// Calculem el numero de pagines que tindrà la paginació. Llavors hem de dividir el total d'articles entre els POSTS per pagina
    $numeroPagines = ceil($totalArticles / $_POSTSperPagina);

// Comprovem que la pagina en la que es troba l'usuari no sigui més gran que el numero de pagines que tenim.
# Si es més gran, rediriguim a la pagina 1.

    $li = button($paginaActual, $numeroPagines);      
    

}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
    die();
}

//comprova que al fer click a la pagina no sigui més gran que el numero de pagines que tenim.
function comprovarPagina($paginaActual, $numeroPagines){
    if($paginaActual > $numeroPagines || $paginaActual < 1){
        header('Location: index.php?pagina=1');
    }
}

// Funcio que posa els botons de la paginació 
function button($paginaActual, $numeroPagines){
    $li = "";    
    
    for($i = 1; $i <= $numeroPagines; $i++){
        if($paginaActual == $i){
            $li .= "<li class='active'><a href='index.php?pagina=$i'>$i</a></li>";
        }else{
            $li .= "<li><a href='index.php?pagina=$i'>$i</a></li>";
        }
    }
    

    return $li;

}

require '../vista/index.vista.php';

?>