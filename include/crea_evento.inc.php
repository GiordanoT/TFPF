<?php
    
    require_once("dbh.inc.php");
    require_once("../test/CreaEvento.php");
    session_start();
    
    if( !isset($_POST['crea']) ){
        header("Location: ../creaEvento.php");
        exit();
    }
    
    $admin = $_SESSION['id'];
    $nome = $_POST['nome'];
    $nome = addslashes( $nome );
    $nome = strip_tags( $nome );

    $descrizione = $_POST['descrizione'];
    $descrizione = addslashes( $descrizione );
    $descrizione = strip_tags( $descrizione );

    $citta = $_POST['citta'];
    $citta = addslashes( $citta );
    $citta = strip_tags( $citta );

    $tipologia = $_POST['tipologia'];
    $categoria = $_POST['categoria'];
    $costo = $_POST['costo'];
    $posti = $_POST['posti'];
   
    $immagine = $_FILES['immagine']['name'];
    $path_immagine = "image/".basename($immagine);

    $result = creaEvento($nome,$descrizione,$tipologia,$categoria,$posti,$admin,$costo,$path_immagine,0);

    if($result == 0){
        header("Location: ../creaEvento.php?error=bad_data");
        exit();
    }
    if($result == 2){
        header("Location: ../creaEvento.php?error=dbms_error");
        exit();
    }
    else{
        move_uploaded_file($_FILES['immagine']['tmp_name'], "../".$path_immagine);
        header("Location: ../home.php");
    }
?>