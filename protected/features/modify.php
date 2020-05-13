<?php if(!isset($_SESSION['permission'])) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>

<?php
    require_once DATABASE_CONTROLLER;
    $option = $_GET['C'];
    $data = getRecord("SELECT email FROM users WHERE id =".$_SESSION['uid']);
?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mod'])):
    $adat = $_POST['adat'];
    $query = "";
    $id = $_SESSION['uid'];
    switch($option) {
        case "email":
            $query = "UPDATE users SET email = '$adat' WHERE id = '$id'";
        break;
        case "password":
            $password = sha1($adat);
            $query = "UPDATE users SET password = '$password' WHERE id = '$id'";
        break;
    }
    if(!executeDML($query, [])) {
        $success = 2;
        $alert = "Nem sikerült a művelet!";
        header('Location: index.php?P=profile&A='.$alert.'&S='.$success);
    } else {
        $success = 1;
        $alert = "Sikeres módosítás!";
        header('Location: index.php?P=logout');
    }
?>
<?php endif; ?>

<div class="alertbox">
    <form method="POST">
        <table>
        <tr>
            <th scope="col"></th>
            <th scope="col"><?php $option == "email" ? print_r("Email: ") : print_r("Password:") ?></th>
            <td><input type="text" value="<?php $option == "email" ? print_r($data['email']) : print_r('') ?>" name="adat"></td>
            <td><button type="submit" class="btn btn-primary" name="mod">Módosít</button></td>
        </tr>
        </table>
    </form>
</div>


<?php endif; ?>