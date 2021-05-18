<?php

	function login($email,$password){

		if($email == '' || $password == ''){
			return false;
		}
		else{
			$query = "SELECT id,nome,cognome,email,password,ruolo FROM utente WHERE email ='".$email."' AND password ='".$password."' ";

			$resultUtenti = getData($query);

			if(count($resultUtenti) != 1)
				return false;
			else{
				return true;
			}
		}
 	} 

 	}

      //inserimento db
      if(setData( " INSERT INTO utente (nome,cognome,email,password) VALUES ('".$_POST["nome"]."', '".$_POST["cognome"]."', '".$_POST["email"]."', '".$password."') ")){
        $resultUtente=getData("Select * from utente order by id DESC limit 1");
        $rowUtente=$resultUtente[0];
        
        $_SESSION["nome"] = $rowUtente["nome"];
        $_SESSION["cognome"] = $rowUtente["cognome"];
        $_SESSION["mail"] = $rowUtente["email"];
        
        return 1;
        
      }else return 2;

    }

    //require "../include/dbh.inc.php";
    //echo registrazione('giordano@mail.it','123','prova','prova');

?>
