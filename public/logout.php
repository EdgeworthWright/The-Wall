<?php
//Sessie starten en meteen vernietigen
session_start();
session_destroy();

//doorsturen naar login
header('Location: logreg.php');
exit();
?>
