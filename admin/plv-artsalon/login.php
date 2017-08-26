<?php
  $password = $_POST["password"] ;

  if ($password == "aiueo12345") {
    session_start();
    $_SESSION['plv'] = 'plv';
    header( "Location: schedule_data" ) ;
    exit ;
  } else {
    echo "パスワードが違います" ;
  }
 ?>
