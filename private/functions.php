<?php

// Maak verbinding met de database
function dbConnect() {
  // Laad de instellingen
  $config = include 'db_config.php';

  try {
    $dsn = "mysql:host=" . $config['db_host'] . ';dbname=' . $config['db_name'];
    $conn = new PDO($dsn, $config['db_user'], $config['db_pass']);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $conn;
  } catch (PDOExeption $err) {
    echo "Database connectie fout: " . $err->getMessage();
    exit();
  }

}
