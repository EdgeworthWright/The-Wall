<?php
  session_start();

    ob_start();
    include("../private/templates/header.php");
    $buffer=ob_get_contents();
    ob_end_clean();

    $title = "Purpie Boi";
    $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);

    echo $buffer;
?>

  <?php include '../private/templates/nav.php'; ?>

  <h1 id="nametag">Purple Shrimp Upload Service</h1>
  <h2 id="nametag">Contact us via these services below</h2>

  <div id="contact">
    <a href="https://twitter.com/_PurpleShrimp" target="_blank"><img src="images/Twitter.png" style="max-height:200px; max-width:200px; margin:0 auto;"></a>
    <a href="mailto:25890@ma-web.nl;25467@ma-web.nl"><img src="images/gmail.png" style="max-height:200px; max-width:200px; margin:0 auto;"></a>
  </div>

<?php include '../private/templates/footer.php'; ?>
