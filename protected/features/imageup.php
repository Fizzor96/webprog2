<?php if(!isset($_SESSION['permission'])) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>

<?php
    require_once DATABASE_CONTROLLER;
?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    $target_dir = "./public/userimages/";
    //$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    //így nem lesz kétszer ugyanaz a kép feltöltve
    $target_file = $target_dir . $_SESSION['uid'] . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      if($flname != null){
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".<br>";
          $uploadOk = 1;
        } else {
          echo "File is not an image. <br>";
          $uploadOk = 0;
        }
      } else {
        $success = 2;
        $alert = "You did not choose a file!";
        header('Location: index.php?P=profile&A='.$alert.'&S='.$success);
      }
    }
    
    //ez a rész felesleges
    // Check if file already exists
    if (file_exists($target_file)) {
      if($flname != null){
        echo "Sorry, file already exists. <br>";
        $uploadOk = 0;
      }
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
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. <br>";
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $datas2 = getRecord("SELECT kep FROM userdata WHERE uid =".$_SESSION['uid']);

        $uid = $_SESSION['uid'];
        $defkep = basename( $_FILES["fileToUpload"]["name"]);
        $kep = $_SESSION['uid'].basename( $_FILES["fileToUpload"]["name"]);
        $query = "UPDATE userdata SET kep = '$kep'  WHERE uid = '$uid'";

        if($datas2['kep'] == $kep){
          $success = 1;
          $alert = "Kép feltöltve! ".$defkep;
          header('Location: index.php?P=profile&A='.$alert.'&S='.$success);
        } else {
          unlink('./public/userimages/'.$datas2['kep']);
          if(!executeDML($query, [])) {
            $success = 2;
            $alert = "Nem sikerült a művelet!";
            header('Location: index.php?P=profile&A='.$alert.'&S='.$success);
          } else {
            $success = 1;
            $alert = "Kép feltöltve! ".$defkep;
            header('Location: index.php?P=profile&A='.$alert.'&S='.$success);
          }
        }

        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }



?>
<?php endif; ?>
  <link href="/public/input.css" rel="stylesheet" type="text/css"/>
  <div class="welcome">
    <form action="" method="post" enctype="multipart/form-data">
    Select image to upload: <br><br>
    <label for="file-upload" class="custom-file-upload btn btn-block btn-primary">
      <i class="fa fa-cloud-upload"></i> Select Image
    </label>
    <input type="file" id="file-upload" name="fileToUpload" id="fileToUpload"><br><br>
    <input type="submit" class="btn btn-block btn-primary" value="Upload Image" name="submit">
    </form>
  </div>
<?php endif; ?>