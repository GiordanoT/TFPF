<?php

    require_once("dbh.inc.php");
    require_once("functions/crea_evento.fun.php");
    session_start();

    if( !isset($_POST['crea']) ){
        header("Location: ../creaEvento.php");
        exit();
    }

    $_SESSION['giorni'] = $_POST['durata'];

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
    $posti = $_POST['posti'];

    $immagine = $_FILES['immagine']['name'];

    if( $immagine != NULL ){
      $path_immagine = "image/evento/".basename($immagine);
      $result = creaEvento($nome,$descrizione,$tipologia,$categoria,$posti,$admin,0,$path_immagine,$citta,0,2);
    }
    else {
      $result = creaEvento($nome,$descrizione,$tipologia,$categoria,$posti,$admin,0,"",$citta,0,2);

    }
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
        header("Location: ../scegliDate.php");
    }
?>
