<?php 
session_start();
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
				$_SESSION["userID"] = $idDb;
				$_SESSION["userName"] = $userDb; 
				$_SESSION["userRank"] = $rankDb;
				header("Location: test.php");
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