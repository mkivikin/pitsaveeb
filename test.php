<?php
	require("../../config.php");
	require("functions.php");
	/*$url = $_SERVER['REQUEST_URI'];
	$parts = parse_url($url);
	if (in_array('topping', $parts)) {
		$pizzaComponent = $parts['topping'];
		echo $pizzaComponent;
	} else {
		$pizzaComponent = "";
	}*/
	
	
	//kontrolli, kas kasutaja sisse logitud
	if(!isset($_SESSION["userID"])) {
			header("Location: login.php");
			}
	
	//kui kasutaja vajutab vali pitsa nuppu, salvestab loodud pitsa faili sessiooni muutujasse userPitsa, kustutab ajutised sessioonimuutujad, suunab avalehele
	if (isset($_REQUEST["createButton"])) {
		$_SESSION["userPizza"]="pitsad/".$_SESSION["pitsa"];
		resetSession(); //tagab selle, et kui kasutaja tuleb tagasi ,saab otsast peale alustada
		header("Location: main.php");
		exit();
	}
	
	
	//kui lisand valitud, loob uue pildi
	if (isset($_REQUEST["topping"])) {
		$pizzaComponent = $_REQUEST['topping'];
		//kontrollin, kui lisadega pilti ei ole veel loodud, siis looma failinime, salvestab ajutisse sessiooni muutujasse pitsa
		if (!isset ($_SESSION["pitsa"]))	
			$_SESSION["pitsa"] = $_SESSION["userID"] . "_" . time() . ".png";
		
		addTopping($pizzaComponent);
	}
	
	


	function laeVeged() {
		return laeLisad(2);
		}
		
	function laeLihad() {
		return laeLisad(1);
	}
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styletest.css">
	<title>Valmista Pitsa</title>
</head>
<body>
<div class="container">
	<div class="header">
	</div><!-- end header -->
	<div class="body">
	<div class="toppings-outer">
		<div class="toppings-inner">
			<?php echo laeLihad();?>
		</div><!-- end toppings-inner -->
	</div><!-- end toppings-outer -->
	<div class="pizza-outer">
		<div class="pizza-inner">
		<?php
		//kui pitsa valitud, näitab pitsa pilti koos valitud lisadega, muidu näitab ainult tühja pitsat
			if (isset($_SESSION["pitsa"])) {
				echo '<img src="pitsad/'.$_SESSION["pitsa"].'" height="550" />';
			}else{
				echo '<img src="toppings/bottom.png" height="550" />';
			}
		?>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input name="createButton" type="submit" value="Loo Pitsa">
		<!--<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input name="logOut" type="submit" value="Logi">
		</form>-->
		</div><!-- pizza-inner -->
	</div><!-- pizza-outer -->
	<div class="bottoms-cont">
	<div class="bottoms-outer">
		<div class="bottoms-inner">
			<?php echo laeVeged();?>
		</div><!-- end bottoms-inner -->
	</div><!-- end bottoms-outer -->
	</div><!-- end bottoms-cont -->
	</div><!-- end body -->
</div><!-- end container -->
</body>
</html>
