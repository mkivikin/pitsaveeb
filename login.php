<?php
	require("../../config.php");
	$notice = "";
	$loginUser = "";
	$loginPasswordError = "";
	if (isset($_POST["signinButton"])) {
		if (isset($_POST["loginUsername"])) {
			if (!empty($_POST["loginUsername"])) {
				$loginUser = $_POST["loginUsername"];
			}
			else {
				$notice = "Kasutaja nimi on sisselogimiseks kohustuslik";
			}
		}
		if (isset($_POST["loginPassword"])) {
			if (!empty($_POST["loginPassword"])) {
				$loginPasswordError = "Sisselogimiseks on vaja sisestada parool";
			}
			else {
			}
		}
		if (!empty($_POST["loginUsername"]) and !empty($_POST["loginPassword"])) {
			echo loginFunction($loginUser,($_POST["loginPassword"]));
		}
	}
	
	if (isset($_POST["goToRegister"])) {
		header("Location: register.php");
	}

function loginFunction($user, $password) {
	$database = "if17_marek6";
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
	$stmt = $mysqli->prepare("SELECT user_id, user_name,user_password, user_rank FROM users WHERE user_name = ?");
	$stmt->bind_param("s", $user);
	$stmt->bind_result($idDb, $userDb, $pwDb, $rankDb);
	$stmt->execute();
	if ($stmt->fetch()){
		$hash = hash("sha512", $password);
			if($hash == $pwDb) {
				$notice = "Said sisselogitud";
				$_SESSION["userID"] = $idDb;
				$_SESSION["userName"] = $userDb; 
				$_SESSION["userRank"] = $rankDb;
				header("Location: main.php");
				exit();
			} else {
				$notice = "Teie sisestatud parool või kasutajanimi on vale";
			}
			
	}
	$mysqli->close();
	$stmt->close();
	return $notice;
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Sisselogimine</title>
</head>
<body>
<div class="navbar">
<a href="#">Menüü</a>
<a href="#">Valmista oma pitsa</a>
<a href="#">Meist</a>
</div>
<div class="main">
	<span style="color:red" ><?php echo $notice, $loginPasswordError; ?></span>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<table class = login>
		<tr>
			<td colspan = "2"><label>Logi sisse!<label></td>
		</tr>
		<tr>
			<td><label>Kasutajanimi: </label></td>
			<td colspan="2"><input name="loginUsername" type="text" value="<?php echo $loginUser; ?>"></td>
		</tr>
		<tr>
			<td><label>Parool: </label></td>
			<td colspan="2"><input name="loginPassword" placeholder="Salasõna" type="password"></td>
		</tr>
		<tr>	
			<td colspan="3"><input name="signinButton" type="submit" value="Logi sisse" class = loginbuttons></td>
		</tr>
		
		<tr>	
			
			<td><label>Pole veel kasutaja?</label></td>
			<td><input name="goToRegister" type="submit" value="Registreerima" class = loginbuttons></td>
		</tr>
	</table>
	</form>
</div>
</body>
</html>