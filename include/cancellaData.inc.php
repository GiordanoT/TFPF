<?php  
    
    require_once("dbh.inc.php");
    require_once("functions/CancellaData.fun.php");
    require_once('SMTP.php');
    require_once('PHPMailer.php');
    require_once('Exception.php');
    session_start();

    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\Exception;

    $id_evento = $_SESSION['id_evento'];

    $id_data = $_GET['id_data'];

    $resultUtenti = getData("SELECT nome,data,intestatario,email 
                             FROM evento,partecipazione,data_evento 
                             WHERE evento.id = data_evento.id_evento 
                             AND partecipazione.id_data = data_evento.id 
                             AND evento.id = {$id_evento} 
                             AND partecipazione.id_data = {$id_data}");

    $resultUtenti_1 = getData("SELECT nome,data,intestatario,email 
                            FROM evento,partecipazione,data_evento 
                            WHERE evento.id = data_evento.id_evento 
                            AND partecipazione.id_data = data_evento.id 
                            AND evento.id = {$id_evento}");

    $result = CancellaData($id_data, $id_evento);

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

                //recipient
                $mail->addAddress("{$rowUtente['email']}", "{$rowUtente['intestatario']}");     // Add a recipient

                //content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject='Aggiornamento evento';
                $mail->Body="Ciao {$rowUtente['intestatario']}, siamo spiacenti di informarle che 
                             la data del {$rowUtente['data']} dell'evento {$rowUtente['nome']} e' stata
                             cancellata. Cordiali saluti, Globex Corporation.";

                $mail->send();
            }
            $eliminaPartecipazioni = setData("DELETE FROM partecipazione WHERE id_data = {$id_data}");
            header("Location: ../cancellaEvento.php?id_evento={$id_evento}");
        } 
        catch(Exception $e) {
            header("Location: ../modificaDate.php?error=dbms_error");
        }
        exit();
    }
    if($result == 2){
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

            foreach($resultUtenti_1 as $rowUtente){

                $mail->ClearAddresses();
                $mail->ClearCCs();
                $mail->ClearBCCs();

                $mail->setFrom('globexcorporation@gmail.com', 'Globex Corporation');

                //recipient
                $mail->addAddress("{$rowUtente['email']}", "{$rowUtente['intestatario']}");     // Add a recipient

                //content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject='Aggiornamento evento';
                $mail->Body="Ciao {$rowUtente['intestatario']}, siamo spiacenti di informarle che 
                             l'evento {$rowUtente['nome']} e' stato cancellato. Cordiali saluti, Globex Corporation.";

                $mail->send();
            }

            $eliminaPartecipazioni = setData("DELETE FROM partecipazione,data_evento 
                                              WHERE data_evento.id_evento = {$id_evento} AND 
                                              partecipazione.id_data = data_evento.id");
            header("Location: ../eventicreati.php");
        } 
        catch(Exception $e) {
            header("Location: ../modificaDate.php?error=dbms_error");
        }
        exit();
    }
    else{
        header("Location: ../error.php");
    }

?>