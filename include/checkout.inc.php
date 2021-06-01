<?php
    session_start();
    require_once("dbh.inc.php");
    if( !isset( $_POST['checkout'] ) ){
      header( "Location: ../error.php" );
      exit();
    }
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $intestatario = $nome." ".$cognome;
    $email = $_POST['mail'];
    $intestatario = addslashes( $intestatario );
    $intestatario = strip_tags( $intestatario );
    $email = addslashes( $email );
    $email = strip_tags( $email );
    $result = array();
    $totale = 0;
    for( $i = 0; $i < 7; $i++ ){
      $j = $i+10;
      if( isset($_POST[$i]) && isset($_POST[$j]) ){
        $var = array();
        array_push( $var, $_POST[$i] );
        array_push( $var, $_POST[$j] );
        array_push( $result, $var );
      }
    }
    foreach( $result as $row ){
      $codice_uno = rand( 1000000000,9999999999 );
      $codice_due = rand( 1000000000,9999999999 );
      $codice = $codice_uno.$codice_due;
      if( !isset( $_SESSION['mail'] ) ){
        $query = "INSERT INTO partecipazione(costo,id_data,codice,intestatario,email) VALUES ({$row[1]},{$row[0]},{$codice},'{$intestatario}','{$email}')";
        $result = setData( $query );
        if( $result == 0 ){
          header( "Location: ../error.php" );
          exit();
        }
        else{
          $subject = "Biglietto";
          $txt = "Grazie per aver acquistato un biglietto da noi; \npotrai accedere al biglietto tramite il seguente link: \nhttp://localhost/TFPF/ticket.php?id={$codice}";
          mail($email,$subject,$txt);
        }
        $totale += $row[1];
      }
      else{
        $query = "INSERT INTO partecipazione(id_utente,costo,id_data,codice,intestatario) VALUES ({$_SESSION['id']},{$row[1]},{$row[0]},{$codice},'{$intestatario}')";
        $result = setData( $query );
        if( $result == 0 ){
          header( "Location: ../error.php" );
          exit();
        }
        else{
          //$subject = "Biglietto";
          //$txt = "Grazie per aver acquistato un biglietto da noi; \npotrai accedere al biglietto tramite il seguente link: \nhttp://localhost/TFPF/ticket.php?id={$codice}";
          //mail($email,$subject,$txt);
        }
        $totale += $row[1];
      }
    }

    if( $totale == 0 ){
      header("Location: ../home.php");
      exit();
    }
    else{
      echo'
        <body onload="setTimeout(function() { document.myform.submit() }, 0)">
          <form name="myform" method="post" action= "https://www.paypal.com/cgi-bin/webscr">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="currency_code" value="EUR">
            <input type="hidden" name="business" value="GlobexCorporation@mail.com">
            <input type="hidden" name="item_name" value="Biglietto">
            <input type="hidden" name="notify_url" value="http://localhost/TFPF/home.php" />
            <input type="hidden" id="buybuttonid" name="custom" value="10" />
            <input type="hidden" name="amount" value="'.$totale.'">
            <input style="display:none;" type="submit" value="Compra ora">
          </form>
        </body>';
      exit();
    }







?>
