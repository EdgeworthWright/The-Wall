<?php
session_start();

require '../private/dbconn.php';
?>

<?php
    ob_start();
    include("../private/templates/header.php");
    $buffer=ob_get_contents();
    ob_end_clean();

    $title = "Purple Shrimp";
    $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);

    echo $buffer;
?>

  <?php include '../private/templates/nav.php'; ?>

    <?php
    if (isset($_POST['register'])) {
      // Verificatie code
      $random_bytes = bin2hex(random_bytes(32));
      $verificatie_code = hash('md5', $random_bytes);

      // error list
      $errors = array();

      // Sanitize variables
      $voornaam = filter_var($_POST['voornaam'], FILTER_SANITIZE_STRING);
      $achternaam = filter_var($_POST['achternaam'], FILTER_SANITIZE_STRING);
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
      $safe_password = password_hash($password, PASSWORD_DEFAULT);

      if (empty($voornaam) || empty($achternaam)) {
        $errors['naam'] = "Vul een naam in";
      }

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Uw email is niet ingevuld";
      } else if (empty($email)) {
        $errors['email'] = "Vul een email in";
      }

      if (empty($password)) {
        $errors['password'] = "Vul een wachtwoord in";
      }

      if (!empty($errors)) {
        print_r($errors);
      } else {
        $sql = "INSERT INTO gebruikers (voornaam, achternaam, email, password, verificatie_code) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $data = array(
          $voornaam,
          $achternaam,
          $email,
          $safe_password,
          $verificatie_code
        );

        $stmt->execute($data);

        /*E-mail*/
        $verify_link = '<a href="http://25890.hosts2.ma-cloud.nl/the-wall/public/verify.php?code=' . $verificatie_code . '&e=' . $_POST['email'] . ' "> Kimpa </a>';

        $email_to = $_POST['email'];
        $email_from = '25890@ma-web.nl';
        $subject = 'Verificatie The Wall';

        // Hier maken we een heel kort email bericht
        $message = $verify_link;

        // Het afzender en reply-to adres moeten we in een speciale $headers string zetten
        $headers = 'From:' .  $email_from . "\r\n";
        $headers .= 'Reply-To:' .  $email_from . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        $result = mail (
          $email_to,
          $subject,
          $message,
          $headers
        );

        if(!$result){
          echo 'Er ging iets fout bij het versturen van de verificatie e-mail';
          exit;
        } else{
          echo 'Klik de link in de verificatie email om je account te bevestigen';
          exit;
        }
      }
    }


    if (isset($_POST['login'])) {
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

        header('Location: index.php');
      }
    }
    ?>

  <div class="logregcss">
    <form method="POST">
      <label for="voornaam">Voornaam</label> <br>
      <input type="text" name="voornaam" id="voornaam"> <br>
      <label for="achternaam">Achternaam</label> <br>
      <input type="text" name="achternaam" id="achternaam"> <br>
      <label for="email">Email</label> <br>
      <input type="text" name="email" id="email"> <br>
      <label for="password">Password</label> <br>
      <input type="password" name="password" id="password"> <br>
      <input type="submit" name="register" value="Register">
    </form>

    <br>

    <form method="POST">
      <label for="email">E-mail</label> <br>
      <input type="email" name="email" id="email"> <br>
      <label for="password">Password</label> <br>
      <input type="password" name="password" id="password"> <br>
      <input type="submit" name="login" value="Log in">
    </form>
  </div>

<?php include '../private/templates/footer.php'; ?>
