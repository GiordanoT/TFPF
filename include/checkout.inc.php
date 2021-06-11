<?php
    require_once('SMTP.php');
    require_once('PHPMailer.php');
    require_once('Exception.php');

    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\Exception;

    session_start();
    require_once("dbh.inc.php");
    if( !isset( $_POST['nome'] ) ){
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
        $query = "INSERT INTO partecipazione(id_data,codice,intestatario,email) VALUES ({$row[0]},{$codice},'{$intestatario}','{$email}')";
        $result = setData( $query );
        if( $result == 0 ){
          header( "Location: ../error.php" );
          exit();
        }
        else{
          $mail=new PHPMailer(true);
          try {
            //settings
            //$mail->SMTPDebug=2; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host='smtp.gmail.com';
            $mail->SMTPAuth=true; // Enable SMTP authentication
            $mail->Username='globexcorporation268@gmail.com'; // SMTP username
            $mail->Password='agile123'; // SMTP password
            $mail->SMTPSecure='ssl';
            $mail->Port=465;

            $mail->setFrom('globexcorporation@gmail.com', 'Globex Corporation');

            //recipient
            $mail->addAddress($email, $intestatario);     // Add a recipient

            //content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject='Biglietto';
            $mail->Body="Grazie per aver acquistato un biglietto da noi; \npotrai accedere al biglietto tramite il seguente link: \nhttp://localhost/TFPF/ticket.php?id={$codice}";
            $mail->AltBody="Grazie per aver acquistato un biglietto da noi; \npotrai accedere al biglietto tramite il seguente link: \nhttp://localhost/TFPF/ticket.php?id={$codice}";

            $mail->send();
          }
          catch(Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: '.$mail->ErrorInfo;
          }
        }
        $totale += $row[1];
      }
      else{
        $resultEmail = getData("SELECT email 
                                                FROM utente
                                                WHERE id = {$_SESSION['id']}");
        $email = $resultEmail[0]['email'];
        $mail=new PHPMailer(true);
        try {
            //settings
            //$mail->SMTPDebug=2; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host='smtp.gmail.com';
            $mail->SMTPAuth=true; // Enable SMTP authentication
            $mail->Username='globexcorporation268@gmail.com'; // SMTP username
            $mail->Password='agile123'; // SMTP password
            $mail->SMTPSecure='ssl';
            $mail->Port=465;

            $mail->setFrom('globexcorporation@gmail.com', 'Globex Corporation');

            //recipient
            $mail->addAddress($email, $intestatario);     // Add a recipient

            //content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject='Biglietto';
            $mail->Body="Grazie per aver acquistato un biglietto da noi; \npotrai accedere al biglietto tramite il seguente link: \nhttp://localhost/TFPF/ticket.php?id={$codice}";
            $mail->AltBody="Grazie per aver acquistato un biglietto da noi; \npotrai accedere al biglietto tramite il seguente link: \nhttp://localhost/TFPF/ticket.php?id={$codice}";

            $mail->send();
          }
          catch(Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: '.$mail->ErrorInfo;
        }
        $query = "INSERT INTO partecipazione(id_utente,id_data,codice,intestatario) VALUES ({$_SESSION['id']},{$row[0]},{$codice},'{$intestatario}')";
        $result = setData( $query );
        $query = "DELETE FROM preferito WHERE id_utente = {$_SESSION['id']} AND id_data = {$row[0]}";
        $resultQ = setData( $query );
        if( $result == 0 || $resultQ == 0 ){
          header( "Location: ../error.php" );
          exit();
        }
      }
    }

    if( $_POST['totale'] == 0 ){
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
            <input type="hidden" name="amount" value="'.$_POST['totale'].'">
            <input style="display:none;" type="submit" value="Compra ora">
          </form>
        </body>';
      exit();
    }







?>
