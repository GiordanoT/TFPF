<?php

    require_once("dbh.inc.php");
    require_once("functions/modifica_evento.fun.php");
    require_once('SMTP.php');
    require_once('PHPMailer.php');
    require_once('Exception.php');
    session_start();

    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\Exception;

    $durata = $_POST['num_giorni'];
    $prezzo_totale = $_POST['prezzo_totale'];
    $evento = $_SESSION['query_evento']; //query per la modifica delle informazioni per l'evento
    $date_vecchie = $_SESSION['date_vecchie']; //date dell'evento prima delle modifiche fatte dall'utente alla form per le date
    $id_evento = $_SESSION['id_evento'];
    $date_passate = $_SESSION['date_passate']; //numero di date che si sono già svolte

    //date,orari e prezzi dell'evento nuovi
    $giorni = array(); 
    $ora_inizio = array();
    $ora_fine = array();
    $prezzo_data = array();

    array_push($giorni,0);
    array_push($ora_inizio,0);
    array_push($ora_fine,0);
    array_push($prezzo_data,0);

    for($i = 1; $i <= $durata; $i++){
        array_push($giorni,$_POST['data_'.$i]);
        array_push($ora_inizio,$_POST['inizio_'.$i]);
        array_push($ora_fine,$_POST['fine_'.$i]);

        if($durata > 1)
            array_push($prezzo_data, $_POST['prezzo_'.$i]);
    }   

    $result = ModificaEvento($id_evento,$evento,$date_passate,$date_vecchie,$durata,$giorni,$ora_inizio,$ora_fine,$prezzo_data, $prezzo_totale);
   
    if($result == 0){
        header("Location: ../modificaDate.php?error=bad_data");
        exit();
    }
    if($result == 2){
        header("Location: ../modificaDate.php?error=dbms_error");
        exit();
    }
    else {

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

            $resultUtenti = getData("SELECT nome,data,intestatario,email,partecipazione.id_utente
                                     FROM evento,partecipazione,data_evento 
                                     WHERE evento.id = data_evento.id_evento 
                                     AND partecipazione.id_data = data_evento.id 
                                     AND evento.id = {$id_evento}");

            $data_odierna = date("Y-m-d");

            foreach($resultUtenti as $rowUtente){

                if($rowUtente['data'] > $data_odierna){

                    $mail->ClearAddresses();
                    $mail->ClearCCs();
                    $mail->ClearBCCs();

                    $mail->setFrom('globexcorporation@gmail.com', 'Globex Corporation');

                    if($rowUtente['email'] == NULL){
                        $resultEmail = getData("SELECT email 
                                                FROM utente
                                                WHERE id = {$rowUtente['id_utente']}");
                        $emailUtente = $resultEmail[0]['email'];
                        //recipient
                        $mail->addAddress("{$emailUtente}", "{$rowUtente['intestatario']}");     // Add a recipient
                    }
                    else{
                        //recipient
                        $mail->addAddress("{$rowUtente['email']}", "{$rowUtente['intestatario']}");     // Add a recipient
                    }

                    //content
                    $mail->isHTML(true); // Set email format to HTML
                    $mail->Subject='Aggiornamento evento';
                    $mail->Body="Ciao {$rowUtente['intestatario']}, l'evento {$rowUtente['nome']} al quale 
                                 parteciperai in data {$rowUtente['data']} ha subito delle modifiche. Controlla
                                 sul nostro portale le nuove informazioni. Cordiali saluti, Globex Corporation.";

                    $mail->send();
                }
            }
            header("Location: ../eventoModificato.php");
        } 
        catch(Exception $e) {
            header("Location: ../error.php");
        }
    }
    
?>