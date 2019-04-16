<?php
session_start();

require '../private/dbconn.php';

include 'check-login.php';
?>

<?php
if (isset($_FILES['image'])) {
  $errors = array();

  $file_name = time().$_FILES['image']['name'];
  $file_size = $_FILES['image']['size'];
  $file_tmp = $_FILES['image']['tmp_name'];
  $file_type = $_FILES['image']['type'];

  // de explode string-functie breekt een string in een array
  // hierbij breek je de string na de . (punt) waardoor je de bestands type hebt
  $filename_deel = explode('.',$_FILES['image']['name']);
  // end laat de laatste waarde van de array zoen
  $bestandstype = end($filename_deel);
  // voor het geval er JPG ipv jpg is geschreven
  $file_ext = strtolower($bestandstype);

  $bestandstypen = array("jpeg","jpg","png","gif");

  if ($file_size > 10485761) {
    $errors['grootte'] = "Het bestand moet kleiner zijn dan 10 MB";
  }

  /*AFBEELINGEN*/
  $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
  $detectedType = exif_imagetype($_FILES['image']['tmp_name']);

  if (in_array($detectedType, $allowedTypes) === false) {
    $errors['Bestandstype'] = "Kies alstublieft een PNG, JPG of GIF";
  }

  if (empty($errors) == true) {
    // move_uploaded_file stuurt je bestand naar een andere lokatie
    move_uploaded_file($file_tmp, "uploads/".$file_name);
    echo "Gelukt";

    try {
      $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
      $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
      $tag = filter_var($_POST['tag'], FILTER_SANITIZE_STRING);
      $linkToImage = "uploads/" . $file_name;
      $sql = "INSERT INTO posts (title, description, imagelink, tag) VALUES (?, ?, ?, ?)";

      $statement = $conn->prepare($sql);

      $data = [
        $title,
        $description,
        $linkToImage,
        $tag
      ];

      $statement->execute($data);
    } catch (PDOException $err) {
      echo $err->getMessage();
    }

    header('Location: index.php');
  } else {
    print_r($errors);
  }
}
?>

<?php
    ob_start();
    include("../private/templates/header.php");
    $buffer=ob_get_contents();
    ob_end_clean();

    $title = "Shrimpload";
    $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);

    echo $buffer;
?>

<?php include '../private/templates/nav.php'; ?>

<div class="uploadform">
  <form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="image">
    <br>
    <br>
    <label for="title">Title</label><br>
    <input type="text" name="title" id="title"> <br>
    <label for="description">Description</label> <br>
    <input type="text" name="description" id="description"> <br>
    <label for="tag">Tag</label> <br>
    <input type="text" name="tag" id="tag"> <br>
    <input type="submit" value="Shrimpload!">
  </form>
</div>


<?php include '../private/templates/footer.php'; ?>
