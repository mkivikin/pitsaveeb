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

	function laeLisad($type) {
		$database = "if17_marek6";
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("SELECT topping_name, topping_png FROM toppings WHERE topping_type = ". $type);
		$stmt->bind_result($toppingName, $toppingpng);
		$stmt->execute();
		while ($stmt->fetch()) {
			//<a href="toppings/". $toppingpng .><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			$notice .= '<a href="?topping=' .$toppingpng .'"><img src ="toppings/' .$toppingpng .'" height="190" /></a>';
		}
		$mysqli->close();
		$stmt->close();
		return $notice;
		}
		



function addTopping($topping) {
	//kontrollime, kas lisadega pitsa on juba loodud
	if(!isset($_SESSION["pitsaLoodud"])) {
		copy("toppings/bottom.png", "pitsad/" . $_SESSION["pitsa"]);
		$_SESSION["pitsaLoodud"] = true;
	}
	$uusPitsa = imagecreatefrompng("pitsad/" . $_SESSION["pitsa"]);
	$lisand = imagecreatefrompng("toppings/" . $topping);
	
	//kopeerib lisandite pildi pitsale peale(kuna pildi koordinaadid on konstantsed, siis on numbrid käsitsi valitud
	imagecopy($uusPitsa, $lisand, 36, 37, 0, 0, 525, 525);
	
	
	//must värv on läbipaistev
	$must= imagecolorallocate($uusPitsa, 0, 0, 0);
	imagecolortransparent($uusPitsa, $must);
	
	//valmispildi uuesti salvestamine faili tagasi
	imagepng($uusPitsa, "pitsad/" . $_SESSION["pitsa"]);
	
	//vabastab mälu
	imagedestroy($uusPitsa);

}

//kustutame ajutised sessioonimuutujad
function resetSession() {
	unset($_SESSION["pitsaLoodud"]);
	unset($_SESSION["pitsa"]);
}



?>
