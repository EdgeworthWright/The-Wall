<?php
session_start();

require '../private/dbconn.php';

?>

<form method="POST" action="login.php">
  <label for="email">email</label>
  <input type="email" name="email" id="email">
  <label for="password">password</label>
  <input type="password" name="password" id="password">
  <input type="submit" value="Log in">
</form>

<a href="test.php">test.php</a>

<?php
if ($_SERVER['REQUEST_METHOD'] == POST) {
  // error list
  $errors = array();

  // Sanitize
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

  // Check vars
  if (empty($email)) {
    $errors['email'] = "Vul uw email in.";
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Uw email in niet correct ingevuld.";
  }

  if (empty($password)) {
    $errors['password'] = "Vul een wachtwoord in.";
  }

  if (!empty($errors)) {
    print_r($errors);
    exit();
  } else {
    $sql = 'SELECT * FROM gebruikers WHERE email = ? AND verificatie_code = ""';

    $statement = $conn->prepare($sql);

    $statement->execute([$email]);

    $result = $statement->fetch();

    $pass_in_db = $result['password'];
    $gebruikers_id = $result['id'];
    $hashpls = password_hash($password, PASSWORD_DEFAULT);

    if (password_verify($password, $pass_in_db)) {
      echo "ok";
    } else {
      echo "no";
      exit();
    }

    $_SESSION['gebruiker_id'] = $gebruikers_id;
    header('Location: test.php');
  }
}
?>
