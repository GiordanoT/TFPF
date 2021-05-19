<?php
  error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));
  if(!isset($_SESSION['mail'])){
    require( "components/error.component.php" );
    require( "components/footer.component.php" );
    exit();
  }
	require_once('include\dbh.inc.php');
  require_once( 'test/EventiCalendarioPref.php' );
  require_once( 'test/EventiCalendarioPar.php' );
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
    if( $monthNumber < 0 || $monthNumber > 11 ){
      require( "components/error.component.php" );
      require( "components/footer.component.php" );
      exit();
    }
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

  $monthNumber += 1;
  $firstDay = strtotime( $meseTitle." 1 ".$anno);
  $firstDay= date("D", $firstDay);
  switch ($firstDay) {
    case 'Mon':
      $endMonth += 1;
      $i = 1;
      $sub = 0;
    break;

    case 'Tue':
      $endMonth += 2;
      $i = 2;
      $sub = 1;
    break;

    case 'Wed':
      $endMonth += 3;
      $i = 3;
      $sub = 2;
    break;

    case 'Thu':
    $endMonth += 4;
    $i = 4;
    $sub = 3;
    break;

    case 'Fri':
    $endMonth += 5;
    $i = 5;
    $sub = 4;
    break;

    case 'Sat':
    $endMonth += 6;
    $i = 6;
    $sub = 5;
    break;

    case 'Sun':
    $endMonth += 7;
    $i = 7;
    $sub = 6;
    break;
}
for( $x = 1; $x < $i; $x++ ){
  $template -> setContent( 'WEEK_'.$x, "" );
  $template -> setContent( 'EVENTO_WEEK_'.$x, "" );
  $template -> setContent( 'FLAG_WEEK_'.$x, "d-none" );
}
while( $i < $endMonth ){
  $g = $i - $sub;
  $template -> setContent( 'WEEK_'.$i, $g );
  $eventiPref = EventiCalendarioPref( $anno."-".$monthNumber."-".$g , "{$_SESSION['id']}" );
  $eventiPar = EventiCalendarioPar( $anno."-".$monthNumber."-".$g , "{$_SESSION['id']}" );

  if( $eventiPref == 0 && $eventiPar == 0 ){
    $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
    $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
  }
  else{
    $eventiPar = $eventiPar[1];
    foreach( $eventiPar as $eventoPar ){
      $template -> setContent( 'EVENTO_WEEK_'.$i, $eventoPar['nome'] );
      $template -> setContent( 'DOT_COLOR_'.$i, "#28a745" );
    }
    $eventiPref = $eventiPref[1];
    foreach( $eventiPref as $eventoPref ){
      $template -> setContent( 'EVENTO_WEEK_'.$i, $eventoPref['nome'] );
      $template -> setContent( 'DOT_COLOR_'.$i, "#dc3545" );
    }
  }
  $i++;
}
for( $i=$endMonth; $i<43; $i++ ){
  $template -> setContent( 'WEEK_'.$i, "" );
  $template -> setContent( 'EVENTO_WEEK_'.$i, "" );
  $template -> setContent( 'FLAG_WEEK_'.$i, "d-none" );
}






	$template -> close();
?>
