<?php
  error_reporting(E_ALL ^ E_NOTICE);
  require_once( 'include/template.inc.php' );

  require( 'templates/begin.template.html' );

    require( 'components/navbar.component.php' );
    require( 'templates/termini.template.html' );
    require( 'components/footer.component.php' );

  require( 'templates/end.template.html' );

?>
