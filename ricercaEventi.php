<?php
  error_reporting(E_ALL ^ E_NOTICE);
  require_once( 'include/template.inc.php' );

  require( 'templates/begin.template.html' );

    require( 'components/navbar.component.php' );
    require( 'components/ricercaEventi.component.php' );
    require( 'components/footer.component.php' );

  require( 'templates/end.template.html' );

?>
