<?php if(!isset($_SESSION['permission'])) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>
<?php
    require_once DATABASE_CONTROLLER;
    
    $date = date("Y-m-d");
	$e = "";
	$queryy = "INSERT INTO userdata (uid, szulido, lakhely, nem, webhely, github, bemutatkozas, kep) VALUES (:uid, :szulido, :lakhely, :nem, :webhely, :github, :bemutatkozas, :kep)";
	$paramss = [
		':uid' => $_SESSION['uid'],
		'szulido' => $date,
		':lakhely' => "nincs",
		':nem' => 0,
		':webhely' => "nincs",
		':github' => "nincs",
		':bemutatkozas' => "Bemutatkozószöveg!",
		':kep' => $e
	];

	if(!executeDML($queryy, $paramss)) {
        $alert = "Hiba a létrehozás során";
        $success = 2;
	}

    $datas1 = getRecord("SELECT id, username, email FROM users WHERE id =".$_SESSION['uid']);
    $datas2 = getRecord("SELECT szulido, lakhely, nem, webhely, github, bemutatkozas, kep FROM userdata WHERE uid =".$_SESSION['uid']);

    $kep = $datas2['kep'];
    $picture = "/public/userimages/".$kep;

    $gender = $datas2['nem'];
    $nem = "";
    if($datas2['nem'] == 0) {
        $nem = "Nő";
    }
    elseif($datas2['nem'] == 1) {
        $nem = "Férfi";
    } else {
        $nem = "Egyéb";
    }
    //Alert section
    // 0 - debug , 1 - success , 2 - error
    $success = 0;
    $alert = "";
    $cdata = "";

    if($_GET['A'] != "" || $_GET['S'] != 0)
    {
        $alert = $_GET['A'];
        $success = $_GET['S'];
    } else {
        $alert = "";
        $success = 0;
    }
?>


<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mentes'])):
    $szulido = $_POST['szulido'];
    $nem = $_POST['gender'];
    $lakhely = $_POST['lakhely'];
    $webhely = $_POST['webhely'];
    $github = $_POST['github'];
    $bemutatkozas = $_POST['bemutatkozas'];
    $uid = $_SESSION['uid'];

    $query = "UPDATE userdata SET szulido = '$szulido', lakhely = '$lakhely', nem = '$nem', webhely = '$webhely', github = '$github', bemutatkozas = '$bemutatkozas'  WHERE uid = '$uid'";
    if(!executeDML($query, [])) {
        $success = 2;
        $alert = "Nem sikerült a művelet!";
        header('Location: index.php?P=profile&A='.$alert.'&S='.$success);
    } else {
        $success = 1;
        $alert = "Módosítás végrehajtva!";
        header('Location: index.php?P=profile&A='.$alert.'&S='.$success);
    }
?>
<?php endif; ?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['refresh'])):
    header('Location: index.php?P=profile&A=""&S=0');
?>
<?php endif; ?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['imgup'])):
    header('Location: index.php?P=imageup');
?>
<?php endif; ?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['passchange'])):
    $cdata = "password";
    header('Location: index.php?P=modify&C='.$cdata);
?>
<?php endif; ?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['emailchange'])):
    $cdata = "email";
    header('Location: index.php?P=modify&C='.$cdata);
?>
<?php endif; ?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['imgdel'])):
    $id = $_SESSION['uid'];
    $adat = "";
    $query = "UPDATE userdata SET kep = '$adat' WHERE uid = '$id'";

    if(!executeDML($query, [])) {
        $success = 2;
        $alert = "Nem sikerült a művelet!";
        header('Location: index.php?P=profile&A='.$alert.'&S='.$success);
    } else {
        $success = 1;
        $alert = "Sikeres módosítás!";
        header('Location: index.php?P=profile&A='.$alert.'&S='.$success);
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
    <center><h1></h1></center>
<?php else : ?>
    <link href="/public/ptable.css" rel="stylesheet" type="text/css"/>
    <link href="/public/input.css" rel="stylesheet" type="text/css"/>
    <form method="POST">
    <table>
    <tbody>
        <tr>
            <th colspan="4">Profile</th>
        </tr>
        <tr>
            <td rowspan="4">
                <img src="<?=$picture ?>" alt="Kép nem található">
            </td>
            <td>UID: <?php print_r($_SESSION['uid']) ?></td>
            <td colspan="2">Bemutatkozás:</td>
        </tr>
        <tr>
            <td>Username: <?php print_r($datas1['username']) ?></td>
            <td colspan="2" rowspan="3"><input type="textarea" id="bemutatkozas" value="<?php print_r($datas2['bemutatkozas']) ?>" name="bemutatkozas"></td>
        </tr>
        <tr>
            <td>Permission Level: <?php print_r($_SESSION['permission']) ?></td>
        </tr>
        <tr>

            <td>Email: <?php print_r($_SESSION['email']) ?></td>
        </tr>
        <tr>
            <td>Született:</td>
            <td><input type="text" value="<?php print_r($datas2['szulido']) ?>" name="szulido"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Nem:</td>
            <td>
                <select name="gender">
                    <option value="<?=$gender?>"><?php print_r($nem) ?></option>
                    <option value="0">Nő</option>
                    <option value="1">Férfi</option>
                    <option value="2">Egyéb</option>
                </select>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Lakhely:</td>
            <td><input type="text" value="<?php print_r($datas2['lakhely']) ?>" name="lakhely"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Webhely:</td>
            <td><input type="text" value="<?php print_r($datas2['webhely']) ?>" name="webhely"></td>
            <td>
                <div class="wrapper">
                    <button type="submit" class="btn btn-block btn-primary wrapbtn" name="imgup">Kép feltöltése</button>
                </div>
                <div class="wrapper">
                    <button type="submit" class="btn btn-block btn-primary wrapbtn" name="imgdel">Kép törlése</button>
                </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>Github:</td>
            <td><input type="text" value="<?php print_r($datas2['github']) ?>" name="github"></td>
            <td>
                <div class="wrapper">
                    <button type="submit" class="btn btn-block btn-primary wrapbtn" name="passchange">Change Password</button>
                </div>
                <div class="wrapper">
                <button type="submit" class="btn btn-block btn-primary wrapbtn" name="emailchange">Change Email</button>
                </div>
            </td>
            <td>
                <div class="wrapper">
                    <button type="submit" class="btn btn-block btn-primary wrapbtn" name="refresh">Frissít</button>
                </div>
                <div class="wrapper">
                    <button type="submit" class="btn btn-block btn-primary wrapbtn" name="mentes">Mentés</button>
                </div>
            </td>
        </tr>
    </tbody>
    </table>
    </form>
    <?php endif; ?>
<?php endif; ?>

<div class="disclaimer">
    <em></em>
</div>