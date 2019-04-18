<?php //username en posts (postnummers en posts) ?>
<?php
session_start();

require '../private/dbconn.php';

include 'check-login.php';

try {
  $sql = "SELECT * FROM gebruikers WHERE id ='" . $_SESSION['gebruiker_id'] . "'";

  $statement = $conn->query($sql);

  $result = $statement->fetchAll();
} catch (PDOException $err) {
  echo $err->getMessage();
}

?>

<?php
    ob_start();
    include("../private/templates/header.php");
    $buffer=ob_get_contents();
    ob_end_clean();

    $title = "Shrimpofile";
    $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);

    echo $buffer;
?>

<?php include '../private/templates/nav.php'; ?>

<h1 style="text-align: center;">Good day
<?php
foreach ($result as $row) {
  echo $row['voornaam'];
}
?>
</h1>

<?php
try {
  $sql2 = "SELECT * FROM posts WHERE author ='" . $_SESSION['gebruiker_id'] . "'";

  $stmt = $conn->query($sql2);

  foreach ($stmt as $row) {
    $src = $row['imagelink'];

    echo
      "<img class='modaalKnop' src='$src'>" .
      "<section class='modaalContent'>" .
      "<img src='$src'>" .
      "<article>" .
      "<h3>" . $row['title'] . "</h3>" .
      "<blockquote>" . $row['description'] . "</blockquote>" .
      "<h4>" . $row['tag'] . "</h4>" .
      "</article>" .
      "</section>";
  }


} catch (PDOException $err) {
    echo $err->getMessage();
}
?>

<script src="scripts/modal.js" charset="utf-8"></script>


<?php include '../private/templates/footer.php'; ?>
