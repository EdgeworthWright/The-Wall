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

    <h1 id="nametag">Purple Shrimp Upload Service</h1>

    <?php
    try {
      $sql = "SELECT * FROM posts";

      $stmt = $conn->query($sql);

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
<!-- 27/3/2019 -->
