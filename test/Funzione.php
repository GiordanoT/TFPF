<?php

	function login($email,$password){

		if($email == '' || $password == ''){
			return false;
		}
		else{
			$query = "SELECT id,nome,cognome,email,password,ruolo FROM utente WHERE email ='".$email."' AND password ='".$password."' ";

			$resultUtenti = getData($query);

			if(count($resultUtenti) != 1)
				return 0;
			else{
				return 1;
			}
		}
 	} 

 	}

?>
