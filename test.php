<?php
	require("../../config.php");
	
	function laeVeged() {
	$database = "if17_marek6";
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
	$stmt = $mysqli->prepare("SELECT topping_name, topping_price, topping_png FROM toppings WHERE topping_type = 2");
	$stmt->bind_result($toppingName, $toppingPrice, $toppingpng);
	$stmt->execute();
	while ($stmt->fetch()) {
		//<a href="toppings/". $toppingpng .><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
		$notice .= '<a href=#' .$toppingName .'><img src ="toppings/' .$toppingpng .'" height="250" /></a>';
	}
	$mysqli->close();
	$stmt->close();
	return $notice;
	}
	function laeLihad() {
	$database = "if17_marek6";
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
	$stmt = $mysqli->prepare("SELECT topping_name, topping_price, topping_png FROM toppings WHERE topping_type = 1");
	$stmt->bind_result($toppingName, $toppingPrice, $toppingpng);
	$stmt->execute();
	while ($stmt->fetch()) {
		//<a href="toppings/". $toppingpng .><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
		$notice .= '<a href=#' .$toppingName .'><img src ="toppings/' .$toppingpng .'" height="250" /></a>';
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
		<a href="toppings/bottom.png"><img src="toppings/bottom.png" height="550" /></a>
		</div><!-- pizza-inner -->
	</div><!-- pizza-outer -->
	<div class="bottoms-cont">
	<div class="bottoms-outer">
		<div class="bottoms-inner">
			<?php echo laeVeged();?>
			<!--<a href="Graafika/pizza_create_pics/meat/sausage.png"><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			<a href="Graafika/pizza_create_pics/meat/sausage.png"><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			<a href="Graafika/pizza_create_pics/meat/sausage.png"><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			<a href="Graafika/pizza_create_pics/meat/sausage.png"><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			<a href="Graafika/pizza_create_pics/meat/sausage.png"><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			<a href="Graafika/pizza_create_pics/meat/sausage.png"><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			<a href="Graafika/pizza_create_pics/meat/sausage.png"><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			<a href="Graafika/pizza_create_pics/meat/sausage.png"><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			<a href="Graafika/pizza_create_pics/meat/sausage.png"><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			<a href="Graafika/pizza_create_pics/meat/sausage.png"><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			<a href="Graafika/pizza_create_pics/meat/sausage.png"><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>-->
		</div><!-- end bottoms-inner -->
	</div><!-- end bottoms-outer -->
	</div><!-- end bottoms-cont -->
	</div><!-- end body -->
</div><!-- end container -->
</body>
</html>