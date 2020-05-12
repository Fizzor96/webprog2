<?php if(!isset($_SESSION['permission'])) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>

<?php
    require_once DATABASE_CONTROLLER;
?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    $target_dir = "./public/userimages/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }
    
    // Check file size
    //kb 5 mega
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {


        $datas2 = getRecord("SELECT kep FROM userdata WHERE uid =".$_SESSION['uid']);
        unlink('./public/userimages/'.$datas2['kep']);
    
        $kep = basename( $_FILES["fileToUpload"]["name"]);
        $uid = $_SESSION['uid'];
        $query = "UPDATE userdata SET kep = '$kep'  WHERE uid = '$uid'";
        if(!executeDML($query, [])) {
          $success = 2;
          $alert = "Nem sikerült a művelet!";
          header('Location: index.php?P=profile&A='.$alert.'&S='.$success);
        } else {
          $success = 1;
          $alert = "Kép feltöltve! ".$kep;
          header('Location: index.php?P=profile&A='.$alert.'&S='.$success);
        }



        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }



?>
<?php endif; ?>
  <div class="welcome">
    <form action="" method="post" enctype="multipart/form-data">
    Select image to upload: <br><br>
    <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
    <input type="submit" value="Upload Image" name="submit">
    </form>
  </div>

<?php endif; ?>