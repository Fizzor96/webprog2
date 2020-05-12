
<link rel="stylesheet" href="form.css">
<div class="body content">
    <div class="welcome">
        <?php $alert = "Welcome". " ". $_SESSION['username'].' Permission: '. $_SESSION['permission'] ?>
        <div class="alert alert-success"><?php echo $alert ?></div>
        <center> Welcome <span class="user"><?= $_SESSION['username'].' '. $_SESSION['permission'] ?></span></center>
		<br><br><em></em>
    </div>
</div>
