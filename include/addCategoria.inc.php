<?php
  require_once( "dbh.inc.php" );

  $nome = addslashes( $_POST['nome'] );
  $nome = strip_tags( $nome );
  if( !isset($_POST['aggiungi']) ){
    header("Location: ../error.php");
    exit();
  }

  $immagine = $_FILES['immagine']['name'];
  $path_immagine = "image/evento/".basename($immagine);

  $query = "INSERT INTO categoria(nome,immagine) VALUES( '{$nome}','{$path_immagine}' )";
  $result = setData($query);
  echo $query;
  if( $result == 1 ){
      move_uploaded_file($_FILES['immagine']['tmp_name'], "../".$path_immagine);
      header("Location: ../home.php");
      exit();
  }
  else{
    header("Location: ../error.php");
    exit();
  }







 ?>
