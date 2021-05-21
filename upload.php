<?php
// header('Location: http://localhost/PHP-ecommerce-master/index.php');
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    

    $uploadOk = 1;
  } else {
echo "<script>
window.location.href='index.php';
alert('Enter a valid file type');
</script>";

    $uploadOk = 0;
  }
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
echo "<script>
window.location.href='index.php';
alert('Sorry, your file was not uploaded TRY AGAIN ');
</script>";

  echo '<script>alert("Sorry, your file was not uploaded.")</script>';
  echo "";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "<script>
window.location.href='index.php';
alert('file uploaded successfully!!');
</script>";
  } else {
    echo '<script>alert("error while uploading")

    </script>';
  }
}
?>