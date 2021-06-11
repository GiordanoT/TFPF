<?php

    require_once("dbh.inc.php");
    require_once("functions/DeletePartecipazione.fun.php");  
    require_once('SMTP.php');
    require_once('PHPMailer.php');
    require_once('Exception.php');
    session_start();

    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\Exception;
    $id = $_GET["id"];

    $resultUtenti = getData("SELECT utente.nome as nome_utente,utente.cognome as cognome_utente,evento.nome as nome_evento, utente.email as email
                                    FROM evento,utente,partecipazione,data_evento
                                    WHERE partecipazione.id_utente = utente.id AND partecipazione.id_data = data_evento.id
                                    AND data_evento.id_evento = evento.id
                                    AND partecipazione.id = {$id}");

    $result = DeletePartecipazione($id);
    if($result == 1){
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

            foreach($resultUtenti as $rowUtente){
                    
                $mail->ClearAddresses();
                $mail->ClearCCs();
                $mail->ClearBCCs();

                $mail->setFrom('globexcorporation@gmail.com', 'Globex Corporation');
                $mail->addAddress("{$rowUtente['email']}", "{$rowUtente['cognome_utente']}"." "."{$rowUtente['nome_utente']}");     // Add a recipient
            

                //content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject='Annullamento partecipazione';

                $mail->Body="Ciao {$rowUtente['cognome_utente']} {$rowUtente['nome_utente']}, la informiamo che la sua partecipazione all'evento {$rowUtente['nome_evento']}
                            e' stata annullata. Cordiali saluti, Globex Corporation.";

                $mail->send();
            }
        }  
        catch(Exception $e) {
          header("Location: ../error.php");
        }
        header("Location: ../eventiutente.php?id={$_SESSION["id"]}");
        exit();
    }else{
        header("Location: ../error.php");
        exit();
    }
?>