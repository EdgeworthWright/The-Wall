<nav>
  <ul class="navlinks">
    <li id="navknop"><a id="nava" href="contact.php">Contact</a></li>
    <?php
      if (empty($_SESSION['gebruiker_id'])) {
        echo "<li id='navknop'><a id='nava' href='logreg.php'>Login</a></li>";
      } else {
        echo "<li id='navknop'><a id='nava' href='logout.php'>Logout</a></li>";
      }

      if (!empty($_SESSION['gebruiker_id'])) {
        echo "<li id='navknop'><a id='nava' href='upload.php'>Upload</a></li>";
      }
    ?>
    <li id="navknop"><a id="nava" href="index.php">Home</a></li>
    <h1 class="namenav"><img id="navpic" src="images/shrimp.png"></img></h1>
  </ul>
</nav>
