<?php
//Sessie starten
session_start();

//Controleren of er een gebruiker_id in de sessie staat anders naar inlog form sturen
if (empty($_SESSION['gebruiker_id'])) {
    header('Location: logreg.php');
    exit();
}
