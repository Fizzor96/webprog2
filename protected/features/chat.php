<?php if(!isset($_SESSION['permission'])) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>
<?php
	require_once DATABASE_CONTROLLER;

    $qmessages = "SELECT id, uid, uzenet, ido FROM chat ORDER BY ido DESC";
    $lmessages = getList($qmessages);


    //Alert section
    // 0 - debug , 1 - success , 2 - error
    $success = 0;
    $alert = "";

    if($_GET['A'] != "" || $_GET['S'] != 0)
    {
        $alert = $_GET['A'];
        $success = $_GET['S'];
    } else {
        $alert = "";
        $success = 0;
    }
    
    $date = date("Y-m-d");
?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['del'])):
    $mid = $_POST['del'];
    $tempmessage = getRecord("SELECT id, uid, uzenet, ido FROM chat WHERE id =".$_POST['del']);
    $tempuserid = $tempmessage['uid'];
    $tempusername = getRecord("SELECT username FROM users WHERE id =".$tempuserid)['username'];
    if($_SESSION['username'] == $tempusername || $_SESSION['permission'] > 0)
    {
        $query = "DELETE FROM chat WHERE id = '$mid'";
        
        if(!executeDML($query, [])) {
            $success = 2;
            $alert = "Hiba az adatbevitel során!";
            header('Location: index.php?P=chat&A='.$alert.'&S='.$success);
        } else {
            $success = 1;
            $alert = "Üzenet törölve!";
            header('Location: index.php?P=chat&A='.$alert.'&S='.$success);
        }
    } else {
        $success = 2;
        $alert = "Nincs hozzá jogod!";
        header('Location: index.php?P=chat&A='.$alert.'&S='.$success);
    }
?>
<?php endif; ?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kuld'])):
    if(strlen($_POST['uzenet']) < 6)
    {
        $alert = "Az üzenetnek legalább 6 karakter hosszúnak kell lennie!";
        $success = 2;
        header('Location: index.php?P=chat&A='.$alert.'&S='.$success);
    } 
    else 
    {
        $query = "INSERT INTO chat (uid, uzenet, ido) VALUES (:uid, :uzenet, :ido)";
        $params = [
            ':uid' => $_SESSION['uid'],
            ':uzenet' => $_POST['uzenet'],
            ':ido' => $date
        ];

        if(!executeDML($query, $params)) {
            $alert = "Hiba az adatbevitel során!";
            $success = 2;
            header('Location: index.php?P=chat&A='.$alert.'&S='.$success);
        } else {
            $alert = "Üzenet elküldve!";
            $success = 1;
            header('Location: index.php?P=chat&A='.$alert.'&S='.$success);
        }
    }
?>
<?php endif; ?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])):
        $editid = $_POST['edit'];
        $tempmessage = getRecord("SELECT id, uid, uzenet, ido FROM chat WHERE id =".$_POST['edit']);
        $tempuserid = $tempmessage['uid'];
        $tempusername = getRecord("SELECT username FROM users WHERE id =".$tempuserid)['username'];
    if($_SESSION['username'] == $tempusername || $_SESSION['permission'] > 0) {
        header('Location: index.php?P=edit&edit='.$editid);
    } else {
        $success = 2;
        $alert = "Nincs hozzá jogod!";
        header('Location: index.php?P=chat&A='.$alert.'&S='.$success);
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


<?php if(false) : ?>
    <center><h1>Nem írt még senki üzenetet</h1></center>
<?php else : ?>
    <form method="POST">
    <table>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">MessageID</th>
                <th scope="col">Feladó</th>
                <th scope="col">Üzenet</th>
                <th scope="col">Elküldve</th>
                <th scope="col" id="mytext"><input type="text" placeholder="Message" name="uzenet"></th>
                <th scope="col"><button type="submit" class="btn btn-primary" name="kuld">Küld</button></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 0; ?>
        <?php foreach ($lmessages as $w) : ?>
            <?php $i++; ?>
            <tr>
                <td><?=$i ?></td>
                <td><?=$w['id'] ?></td>
                <th scope="row"><?=(getRecord("SELECT username FROM users WHERE id = ".$w['uid']))['username'];?></th>
                <td><?=$w['uzenet'] ?></td>
                <td><?=$w['ido'] ?></td>
                <td><button type="submit" class="btn btn-primary" name="edit" value="<?=$w['id'] ?>">Szerkeszt</button></td>
                <td><button type="submit" class="btn btn-primary" name="del" value="<?=$w['id'] ?>">Töröl</button></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    </form>
    <?php endif; ?>
<?php endif; ?>

<div class="disclaimer">
    <em>Mindenki csak a saját üzenetét tudja törölni. Ezalól kivétel a magasabb jogosultsági szinttel rendelkező felhasználó!</em>
</div>