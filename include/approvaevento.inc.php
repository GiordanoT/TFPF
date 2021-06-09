<?php

    require_once("dbh.inc.php");
    require_once("functions/ApprovaEvento.fun.php");
    require_once('SMTP.php');
    require_once('PHPMailer.php');
    require_once('Exception.php');
    session_start();

    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\Exception;


    $id = $_GET['id'];
    $del = $_GET['del'];
    $result = ApprovaEvento( $id, $del );

    if( $result == 1 || $result == 2 ){
      $mail=new PHPMailer(true); // Passing `true` enables exceptions
      try {
        //settings
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host='smtp.gmail.com';
        $mail->SMTPAuth=true; // Enable SMTP authentication
        $mail->Username='globexcorporation268@gmail.com'; // SMTP username
        $mail->Password='agile123'; // SMTP password
        $mail->SMTPSecure='ssl';
        $mail->Port=465;

        $resultUtenti = getData("SELECT utente.nome as nome_utente,utente.cognome as cognome_utente,email,evento.nome as nome_evento
                                FROM evento,utente 
                                WHERE evento.admin_evento = utente.id 
                                AND evento.id = {$id}");

        foreach($resultUtenti as $rowUtente){
                
          $mail->ClearAddresses();
          $mail->ClearCCs();
          $mail->ClearBCCs();

          $mail->setFrom('globexcorporation@gmail.com', 'Globex Corporation');
          $mail->addAddress("{$rowUtente['email']}", "{$rowUtente['cognome_utente']}"." "."{$rowUtente['nome_utente']}");     // Add a recipient
       

          //content
          $mail->isHTML(true); // Set email format to HTML
          $mail->Subject='Approvazione evento';

          if($result == 1){
            $mail->Body="Ciao {$rowUtente['cognome_utente']} {$rowUtente['nome_utente']}, la informiamo che l'evento {$rowUtente['nome_evento']}
                        da lei creato e' stato approvato. Cordiali saluti, Globex Corporation.";
          }
          else{
            $mail->Body="Ciao {$rowUtente['nome_utente']} {$rowUtente['nome_utente']}, siamo spiacenti di informarla che l'evento {$rowUtente['nome_evento']}
                        da lei creato non e' stato approvato. Cordiali saluti, Globex Corporation.";
          }

          $mail->send();
        }
      } 
      catch(Exception $e) {
          header("Location: ../error.php");
      }
      header( "Location: ../approvaevento.php" );
      exit();
    }
    else{
      header( "Location: ../error.php" ); 
      exit();
    }




?>