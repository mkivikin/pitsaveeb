<?php
	require("../../config.php");
	$gender = "";
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	$signupBirthDate = null;
	
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
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Registreerimine</title>
</head>
<body>
<div class="navbar">
<a href="#">Menüü</a>
<a href="#">Valmista oma pitsa</a>
<a href="#">Meist</a>
</div>
	</form>	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<table class = login>
		<tr>
			<td><label>Eesnimi: </label></td>
			<td><input name="signupFirstName" type="text" value=""></td>
			<td><span style="color:red" ></span></td>
		</tr>
		<tr>
			<td><label>Perekonnanimi: </label></td>
			<td><input name="signupFamilyName" type="text" value=""></td>
			<td><span style="color:red" ></span></td>
		</tr>
		<tr>
			<td><label> Sisesta sünnikuupäev: </label></td>
			<td><?php
				echo "\n <br> \n" .$signupDaySelectHTML ."\n" .$signupMonthSelectHTML ."\n" .$signupYearSelectHTML ."\n <br> \n";$signupMonthSelectHTML;
			?></td>
			<td><span style="color:red" ><?php //echo $signupBirthDayError; ?></span></td>
		</tr>
		<tr>
			<td><label>Sugu:</label><span></td>
			<td>
				<select>
					<option value="1">Mees</option>
					<option value="2">Naine</option>
				</select>
			</td>
			<td><span style="color:red" ></span></td>
		</tr>
		<tr>
			<td><label>Kasutajanimi (E-post):</label></td>
			<td><input name="signupEmail" type="email" value="<?php?>"></td>
			<td><span style="color:red" ></span></td>
		<tr>
		<tr>
			<td><label>Parool:</label></td>
			<td><input name="signupPassword" placeholder="Salasõna" type="password"></td>
			<td><span style="color:red"></span></td>
		</tr>
		<tr>
			<td></td>
			<td><input name="signupButton" type="submit" value="Loo kasutaja"></td>
		</tr>
	</table> 
	</form>
</body>
</html>