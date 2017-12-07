<?php
	require("../../config.php");
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	$signupBirthDate = null;
	$signupUserName = "";
	$signupFirstName = "";
	$signupLastName = "";
	$signupEmail = "";
	$signupPhone = "";
	$signupGender = "";
	$signupFirstNameError = "";
	$signupLastNameError = "";
	$signupUserNameError = "";
	$signupEmailError = "";
	$signupPhoneError = "";
	$signupPasswordError = "";
	$signupDaySelectHTML = "";
	$signupDaySelectHTML .= '<select name="signupBirthDay">' ."\n";
	$signupDaySelectHTML .= '<option value="" selected disabled>päev</option>' ."\n";
	for ($i = 1; $i < 32; $i ++){
		if($i == $signupBirthDay){
			$signupDaySelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupDaySelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ." \n";
		}
		
	}
	$signupDaySelectHTML.= "</select> \n";
	
	//Tekitan sünnikuu valiku
	$monthNamesEt = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$signupMonthSelectHTML = "";
	$signupMonthSelectHTML .= '<select name="signupBirthMonth">' ."\n";
	$signupMonthSelectHTML .='<option value ="" selected disabled>kuu</option>' . "\n";
	
	foreach($monthNamesEt as $key=>$month){                      //$key=>$month võtab kõigepealt massiivi indeksi ja siis väärtuse
		if($key +1 === $signupBirthMonth) {
			$signupMonthSelectHTML .= '<option value ="' .($key + 1) .'" selected>' .$month ."</option> \n"; 
		} else {
			$signupMonthSelectHTML .= '<option value = "' .($key + 1) .'">' .$month ."</option> \n";
		}
		 
	}
	$signupMonthSelectHTML .="</select> \n";
	
	//Tekitame aasta valiku
	$signupYearSelectHTML = "";
	$signupYearSelectHTML .= '<select name="signupBirthYear">' ."\n";
	$signupYearSelectHTML .= '<option value="" selected disabled>aasta</option>' ."\n";
	$yearNow = date("Y");
	for ($i = $yearNow; $i > 1900; $i --){
		if($i == $signupBirthYear){
			$signupYearSelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupYearSelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ."\n";
		}
		
	}
	$signupYearSelectHTML.= "</select> \n";

if (isset($_POST["signupButton"])) {
		if (isset ($_POST["signupBirthDay"])){
			$signupBirthDay = $_POST["signupBirthDay"];
			//echo $signupBirthDay;
		}
	
		if (isset ($_POST["signupBirthMonth"])) {
			$signupBirthMonth = intval($_POST["signupBirthMonth"]);
		}
	
		if (isset ($_POST["signupBirthYear"])){
			$signupBirthYear = $_POST["signupBirthYear"];
			//echo $signupBirthYear;
		}
		//Kontrollime kas sisestatud kuupäev on valiidne
	
		if (isset ($_POST["signupBirthDay"]) and (isset ($_POST["signupBirthMonth"])) and (isset ($_POST["signupBirthYear"]))) {
			if (checkdate(intval($_POST["signupBirthMonth"]), intval($_POST["signupBirthDay"]), intval($_POST["signupBirthYear"]))) {
				$birthDate = date_create($_POST["signupBirthMonth"] ."/"  .$_POST["signupBirthDay"] ."/" .$_POST["signupBirthYear"]);
				$signupBirthDate = date_format($birthDate, "Y-m-d");
				//echo $signupBirthDate;
			} else {
				$signupBirthDayError = "Sünnikuupäev on vigane";
			}
		} else {
			$signupBirthDayError = "Sünnikuupäev pole määratud";
		}
		
		if(isset($_POST["signupPassword"])) {
			if(strlen($_POST["signupPassword"]) < 8) {
				$signupPasswordError = "Parool on liiga lühike";
			}
		}
		
	if(empty ($signupFirstNameError) and empty($signupLastNameError) and empty($signupUserNameError) and empty($signupBirthDayError) and empty($signupEmailError) and empty($signupPhoneError) and empty($signupPasswordError) and !empty($_POST["signupPassword"])) {
			$signupPassword = hash("sha512", $_POST["signupPassword"]);
			$signupGender = $_POST["signupGender"];
			register_function($_POST["signupUser"], $signupPassword, $_POST["signupEmail"], $_POST["signupFirstName"], $_POST["signupFamilyName"],$signupGender ,$signupPhone, $signupBirthDate);
			
	}
}
	
function register_function($userName, $password, $email, $firstName, $lastName, $gender, $phone, $birthday){
		$database = "if17_marek6";
		$notice = "";
		$userName = test_input($userName);
		$email = test_input($email);
		$firstName = test_input($firstName);
		$lastName = test_input($lastName);
		$phone = test_input($phone);
		$birthday = test_input($birthday);
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		//käsud serverile
		$stmt = $mysqli->prepare("INSERT INTO users (user_name, user_firstname, user_lastname, user_phone, user_gender, user_email, user_password, user_birthday) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssisss", $userName, $firstName, $lastName, $phone, $gender, $email, $password, $birthday);
		if ($stmt->execute()) {
			$notice = "Registreerimine õnnestus";
			header("Location: login.php?success=true");
		} else {
			$notice = "Registreerumine ebaõnnestus";
		}
		$stmt->close();
		$mysqli->close();
		header("Location: login.php");
		exit();
}
function test_input($data) {
		$data = trim($data); //eemaldab lõpust tühiku
		$data = stripslashes($data); // eemaldab /'id
		$data = htmlspecialchars($data); //eemaldab keelatud märgid
		return $data;
}

?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Registreerimine</title>
</head>
<body>
<div class="ostukorv">
	<a href="main.php"><img src="Graafika/ostukorv.png" alt="Logo"></a>
</div>
<div class="logo">
	<a href="main.php"><img src="Graafika/logo.png" alt="Logo"></a>
</div>


<div class="navbar">
<ul>
<li><a href="tellimine.php">Menüü</a></li>
</ul>
</div>
	</form>	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<table class = login>
		<tr>
			<td><span style="color:red"><?php echo $signupPasswordError ?></span>
		</tr>
		<tr>
			<td><label>Kasutajanimi:</label></td>
			<td><input name="signupUser" type="text" value="" required></td>
			<td><span style="color:red" ></span></td>
		<tr>
		<tr>
			<td><label>Parool:</label></td>
			<td><input name="signupPassword" placeholder="Salasõna" type="password" required></td>
			<td><span style="color:red"></span></td>
		</tr>
		<tr>
			<td><label>E-mail:</label></td>
			<td><input name="signupEmail" type="email" required></td>
			<td><span style="color:red"></span></td>
		</tr>
		<tr>
			<td><label>Eesnimi: </label></td>
			<td><input name="signupFirstName" type="text" value="" required></td>
			<td><span style="color:red" ></span></td>
		</tr>
		<tr>
			<td><label>Perekonnanimi: </label></td>
			<td><input name="signupFamilyName" type="text" value="" required></td>
			<td><span style="color:red" ></span></td>
		</tr>
		<tr>
			<td><label> Sisesta sünnikuupäev: </label></td>
			<td><?php echo "\n <br> \n" .$signupDaySelectHTML ."\n" .$signupMonthSelectHTML ."\n" .$signupYearSelectHTML ."\n <br> \n";$signupMonthSelectHTML;?></td>
			<td><span style="color:red" ></span></td>
		</tr>
		<tr>
		<tr>
			<td><label>Telefoninumber: </label></td>
			<td><input name="signupNumber" type="text" value="" required></td>
			<td><span style="color:red" ></span></td>
		</tr>
			<td><label>Sugu:</label><span></td>
			<td>
				<select name="signupGender" type="number">
					<option value="1">Mees</option>
					<option value="2">Naine</option>
				</select>
			</td>
			<td><span style="color:red" ></span></td>
		</tr>
		<tr>
			<td></td>
			<td><input name="signupButton" type="submit" value="Loo kasutaja" class = "loginbuttons"></td>
		</tr>
	</table> 
	</form>
</body>
</html>