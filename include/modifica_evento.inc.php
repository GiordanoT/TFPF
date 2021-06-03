<?php
    
    require_once("dbh.inc.php");
    session_start();
    
    if( !isset($_POST['modifica']) ){
        header("Location: ../error.php");
        exit();
    }

    $_SESSION['durata'] = $_POST['durata'];
    $id_evento = $_SESSION['id_evento'];

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
    $path_immagine = "image/evento/".basename($immagine);
        
    if($posti <= 0){
        header("Location: ../modificaEvento.php?error=bad_data&id_evento=".$id_evento);
        exit();
    }
    else{
        if( $immagine != NULL ){
            $query = "UPDATE evento  
            SET nome = '{$nome}', descrizione = '{$descrizione}', tipologia = '{$tipologia}', id_categoria = '{$categoria}', 
            posti = '{$posti}', immagine = '{$path_immagine}', citta = '{$citta}' 
            WHERE id = '{$id_evento}' ";
            
        } else {
            $query = "UPDATE evento  
            SET nome = '{$nome}', descrizione = '{$descrizione}', tipologia = '{$tipologia}', id_categoria = '{$categoria}', 
            posti = '{$posti}', citta = '{$citta}' 
            WHERE id = '{$id_evento}' ";
        }
        $_SESSION['query_evento'] = $query;
        move_uploaded_file($_FILES['immagine']['tmp_name'], "../".$path_immagine);
        header("Location: ../modificaDate.php");
    }

?>