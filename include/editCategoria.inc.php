<?php
  require_once( "dbh.inc.php" );
  
  if( !isset($_POST['aggiungi']) ){
    header("Location: ../error.php");
    exit();
  }

  $nome = addslashes( $_POST['nome'] );
  $nome = strip_tags( $nome );
  $id = $_POST['id'];
  $immagine = $_FILES['immagine']['name'];

  if( $immagine != NULL ){
    $path_immagine = "image/evento/".basename($immagine);
    $query = "UPDATE categoria set nome = '{$nome}', immagine = '{$path_immagine}' WHERE id = {$id}";
    $result = setData($query);

    if( $result == 1 ){
        move_uploaded_file($_FILES['immagine']['tmp_name'], "../".$path_immagine);
        header("Location: ../home.php");
        exit();
    }
    else{
      header("Location: ../error.php");
      exit();
    }
  }
  else{
    $query = "UPDATE categoria set nome = '{$nome}' WHERE id={$id}";

    $result = setData($query);
    if( $result == 1 ){
        header("Location: ../home.php");
        exit();
    }
    else{
      header("Location: ../error.php");
      exit();
    }
  }


 ?>
