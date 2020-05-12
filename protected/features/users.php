<?php if(!isset($_SESSION['permission'])) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>
<?php
	require_once DATABASE_CONTROLLER;

	$query = "SELECT id, username, email, permission FROM users ORDER BY id ASC";
    $users = getList($query);


    if($_GET['A'] != "" || $_GET['S'] != 0)
    {
        $alert = $_GET['A'];
        $success = $_GET['S'];
    } else {
        $alert = "";
        $success = 0;
    }
?>




<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['del'])):
    if($_SESSION['permission'] > 0) {
        $id = $_POST['del'];
        $query = "DELETE FROM users WHERE id = '$id'";
        $query2 = "DELETE FROM userdata WHERE uid = '$id'";
        $query3 = "DELETE FROM chat WHERE uid = '$id'";
        if(!executeDML($query, [])) {
            $success = 2;
            $alert = "Nem sikerült a user törlése!";
            header('Location: index.php?P=users&A='.$alert.'&S='.$success);
        } else {
            if(!executeDML($query2, [])) {
                $success = 2;
                $alert = "Nem sikerült a 'userdata' törlése!";
                header('Location: index.php?P=users&A='.$alert.'&S='.$success);
            } else {
                if(!executeDML($query3, [])) {
                    $success = 2;
                    $alert = "Nem sikerült a 'chat' törlése!";
                    header('Location: index.php?P=users&A='.$alert.'&S='.$success);
                } else {
                    $success = 1;
                    $alert = "Sikeres művelet!";
                    header('Location: index.php?P=users&A='.$alert.'&S='.$success);
                }
            }
        }
    } else {
        $success = 2;
        $alert = "Nincs hozzá jogod!";
        header('Location: index.php?P=users&A='.$alert.'&S='.$success);
    }
?>
<?php endif; ?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])):
    if($_SESSION['permission'] > 0){
        $id = $_POST['edit'];
        $permission = $_POST['permission'];
        $query = "UPDATE users SET permission = '$permission' WHERE id = '$id'";
        if(!executeDML($query, [])) {
            $success = 2;
            $alert = "Nem sikerült a művelet! ".$permission." ".$id;
            header('Location: index.php?P=users&A='.$alert.'&S='.$success);
        } else {
            $success = 1;
            $alert = "Módosítás végrehajtva";
            header('Location: index.php?P=users&A='.$alert.'&S='.$success);
        }
    } else {
        $success = 2;
        $alert = "Nincs hozzá jogod!";
        header('Location: index.php?P=users&A='.$alert.'&S='.$success);
    }
?>
<?php endif; ?>




<div class="alertbox">
    <?php if($success == 1) : ?>
    <div class="alert alert-success"><?php echo $alert ?></div>
    <?php endif; ?>
    <?php if($success == 2) : ?>
    <div class="alert alert-error"><?php echo $alert ?></div>
    <?php endif; ?>
</div>

	<?php if(count($users) == 0) : ?>
		<h1>No users found in the database</h1>
	<?php else : ?>
		<form method="POST">
		<table class="usertable">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">ID</th>
					<th scope="col">Username</th>
					<th scope="col">Email</th>
					<th scope="col">Permission</th>
					<th scope="col">Szerkesztés</th>
					<th scope="col">Törlés</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 0; ?>
				<?php foreach ($users as $w) : ?>
					<?php $i++; ?>
					<tr>
						<th scope="row"><?=$i ?></th>
						<td><?=$w['id'] ?></td>
						<td><?=$w['username'] ?></td>
						<td><?=$w['email'] ?></td>
						<td><input type="text" id="permid" value="<?=$w['permission'] ?>" name="permission"></td>
						<td><button type="submit" class="btn btn-primary" name="edit" value="<?=$w['id'] ?>">Edit</button></td>
						<td><button type="submit" class="btn btn-primary" name="del" value="<?=$w['id'] ?>">Delete</button></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	<?php endif; ?>
<?php endif; ?>
