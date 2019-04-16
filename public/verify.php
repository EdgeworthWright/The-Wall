<?php

require '../private/dbconn.php';

echo $_GET['code'] . "<br>";
echo $_GET['e'] . "<br>";

$verificatie_code = filter_var($_GET['code'], FILTER_SANITIZE_STRING);
$email = filter_var($_GET['e'], FILTER_VALIDATE_EMAIL);

// Als er gegevens missen dan stoppen we
if (empty($verificatie_code) || empty($email)) {
    echo 'Ongeldige gegevens';
    exit();
}

// Check of het gelijk is aan de database
$sql = 'SELECT * FROM gebruikers WHERE verificatie_code = ? AND email = ?';
$statement = $conn->prepare($sql);

$data = [
  $verificatie_code,
  $email
];

$result = $statement->execute($data);

if (!$result) {
  echo 'Fout bij ophalen gegevens';
  exit();
}

// Haal het eerste resultaat op (de gevonden gebruiker)
$gebruiker = $statement->fetch();

// Als $gebruiker leeg is dan is de link ongeldig of al gebruikt
if (empty($gebruiker)) {
  echo "Ongeldige link/gebruikte link";
  exit();
}

// Als we tot hier komen is er een rij gevonden
// Nu maken we de verificatie code leeg en tonen we een melding
$gebruikers_id = $gebruiker['id'];
$sql = 'UPDATE gebruikers SET verificatie_code = "" WHERE id = ?';
$statement = $conn->prepare($sql);

$data = [
  $gebruikers_id
];

$result = $statement->execute($data);

if (!$result) {
  echo 'Er ging iets fout bij het opslaan van de gegevens';
  exit();
}

echo 'Verificatie gelukt, je kunt nu <a href="logreg.php">inloggen</a>.';
?>
