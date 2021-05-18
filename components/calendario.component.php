<?php
  error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));

	require_once('include\dbh.inc.php');
	$template = new Template( 'templates/calendario.template.html' );
  date_default_timezone_set("Europe/Rome");
  if(!isset($_GET["mese"]) || !isset($_GET["anno"]) ){
    $anno = date('Y');
    $monthNumber = date('m');
    $monthNumber--;
  }
  else {
    $anno = $_GET["anno"];
    $monthNumber = $_GET["mese"];
  }
  if(isset($_POST["meno"])){
    if($monthNumber == 0){
       $anno--;
       $monthNumber = 11;
    } else {
      $monthNumber = ($monthNumber-1)%12;
    }
  }
  if(isset($_POST["piu"])){
    if($monthNumber == 11){
       $anno++;
       $monthNumber = 0;
    } else {
      $monthNumber = ($monthNumber+1)%12;
    
    }

  }
  $template -> setContent("URL_DATA_CALENDARIO", "anno={$anno}&mese={$monthNumber}");

  switch ( $monthNumber ) {
    case 0:
        $mese = "Gennaio";
        $meseTitle ="Jan";
        $endMonth = 31;
      break;
      case 1:
        $mese = "Febbraio";
        $meseTitle ="Feb";
        if($anno % 4 == 0)
          $endMonth = 29;
        else
          $endMonth = 28;
      break;
      case 2:
        $mese = "Marzo";
        $meseTitle ="Mar";
        $endMonth = 31;
      break;
      case 3:
        $mese = "Aprile";
        $meseTitle ="Apr";
        $endMonth = 30;
      break;
      case 4:
        $mese = "Maggio";
        $meseTitle ="May";
        $endMonth = 31;
      break;
      case 5:
        $mese = "Giugno";
        $meseTitle ="Jun";
        $endMonth = 30;
      break;
      case 6:
        $mese = "Luglio";
        $meseTitle ="Jul";
        $endMonth = 31;
      break;
      case 7:
        $mese = "Agosto";
        $meseTitle ="Aug";
        $endMonth = 31;
      break;
      case 8:
        $mese = "Settembre";
        $meseTitle ="Sep";
        $endMonth = 30;
      break;
      case 9:
        $mese = "Ottobre";
        $meseTitle ="Oct";
        $endMonth = 31;
      break;
      case 10:
        $mese = "Novembre";
        $meseTitle ="Nov";
        $endMonth = 30;
      break;
      case 11:
        $mese = "Dicembre";
        $meseTitle ="Dec";
        $endMonth = 31;
      break;
  }
   $template -> setContent("MESE",$mese);
   $template -> setContent("ANNO",$anno);

  $template -> setContent("WEEK_1","1");
  $template -> setContent("FLAG_WEEK_1","d-none");
  $template -> setContent("EVENTO_WEEK_1","");
  $template -> setContent("WEEK_1","2");
  $template -> setContent("FLAG_WEEK_1","d-none");
  $template -> setContent("EVENTO_WEEK_1","");
  $template -> setContent("WEEK_1","3");
  $template -> setContent("FLAG_WEEK_1","d-none");
  $template -> setContent("EVENTO_WEEK_1","");
  $template -> setContent("WEEK_1","4");
  $template -> setContent("FLAG_WEEK_1","d-none");
  $template -> setContent("EVENTO_WEEK_1","");
  $template -> setContent("WEEK_1","5");
  $template -> setContent("EVENTO_WEEK_1","Inter-Milan");
  $template -> setContent("FLAG_WEEK_1","");
  $template -> setContent("WEEK_1","6");
  $template -> setContent("FLAG_WEEK_1","d-none");
  $template -> setContent("EVENTO_WEEK_1","");
  $template -> setContent("WEEK_1","7");
  $template -> setContent("EVENTO_WEEK_1","Roma-Lazio");
  $template -> setContent("EVENTO_WEEK_1","Roma-Lazio");
  $template -> setContent("EVENTO_WEEK_1","Roma-Lazio");

  $template -> setContent("EVENTO_WEEK_1","Roma-Lazio");

  $template -> setContent("FLAG_WEEK_1","");
	$template -> close();
?>
