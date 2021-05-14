<?php

function login($email,$password){

		require_once("../include/dbh.inc.php");  
    	
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

?>