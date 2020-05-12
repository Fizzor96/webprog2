<?php if(!isset($_SESSION['permission'])) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>

<?php
    require_once DATABASE_CONTROLLER;
    $date = date("Y-m-d");
    $editid = $_GET['edit'];
    $tempmessage = getRecord("SELECT id, uid, uzenet, ido FROM chat WHERE id =".$editid);
    $tempuserid = $tempmessage['uid'];
    $tempusername = getRecord("SELECT username FROM users WHERE id =".$tempuserid)['username'];
    $query = "SELECT megnevezes, fejleszto, kiado, kiadas_eve, letoltesek_szama FROM programok WHERE megnevezes = '$editid'";
?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mod'])):
    $tuzenet = $_POST['edituzenet'];
    $query = "UPDATE chat SET uzenet = '$tuzenet', ido = '$date'  WHERE id = '$editid'";
    if(!executeDML($query, [])) {
        $success = 2;
        $alert = "Nem sikerült a művelet!";
        header('Location: index.php?P=chat&A='.$alert.'&S='.$success);
    } else {
        $success = 1;
        $alert = "Üzenet módosítva!";
        header('Location: index.php?P=chat&A='.$alert.'&S='.$success);
    }
?>
<?php endif; ?>

<div class="alertbox">
    <form method="POST">
        <table>
        <tr>
            <th scope="col"><?php print_r($tempusername) ?></th>
            <th scope="col">Üzenet:</th>
            <td><input type="text" value="<?php print_r($tempmessage['uzenet']) ?>" name="edituzenet"></td>
            <td><button type="submit" class="btn btn-primary" name="mod">Módosít</button></td>
        </tr>
        </table>
    </form>
</div>


<?php endif; ?>