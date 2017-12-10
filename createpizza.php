<?php
	require("../../config.php");
	require("functions.php");
	if (isset ($_GET["pizzaCreate"])) {
		$toppings = $_GET['toppings'];
			if(empty($toppings)) {
				echo("Te ei valinud ühtegi toppingut");
			} else {
				$N = count($toppings);
				echo("Te valisite ".$N ." toppingut: ");
				for($i=0; $i < $N; $i++) {
					echo($toppings[$i] . " ");
				}
			}
	}
	function laeVeged() {
		$database = "if17_marek6";
		$notice = "";
		$folder = "toppings/";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("SELECT topping_id, topping_name, topping_png FROM toppings WHERE topping_type = 2");
		$stmt->bind_result($topping_id, $toppingName, $toppingpng);
		$stmt->execute();
		while ($stmt->fetch()) {
			//<a href="toppings/". $toppingpng .><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			$notice .='<li><input type="checkbox" id="cb'.$topping_id.'" name="toppings[]"/> <label for="cb'.$topping_id.'"><img src ="'.$folder.$toppingpng.'"/></label>';
		}
		$mysqli->close();
		$stmt->close();
		return $notice;
		}
		
	function laeLihad() {
		$database = "if17_marek6";
		$folder = "toppings/";
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("SELECT topping_id, topping_name, topping_png FROM toppings WHERE topping_type = 1");
		$stmt->bind_result($topping_id,$toppingName, $toppingpng);
		$stmt->execute();
		while ($stmt->fetch()) {
			//<a href="toppings/". $toppingpng .><img src="Graafika/pizza_create_pics/meat/sausage.png" height="190" /></a>
			//$notice .= '<a href=?' .$toppingName .'><img src ="toppings/' .$toppingpng .'" height="250" /></a>';
			//$notice .= '<img src ="toppings/' .$toppingpng .'" height="250" /><input type = "checkbox" name = "topping" value="'.$toppingName.'"><br>';
			$notice .='<li><input type="checkbox" id="cb'.$topping_id.'" name="toppings[]" /> <label for="cb'.$topping_id.'"><img src ="'.$folder.$toppingpng.'"/></label>';
		}
		$mysqli->close();
		$stmt->close();
		return $notice;
	}
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<link rel="stylesheet" type="text/css" href="radiotest.css">
	<meta charset="utf-8">
	<title>Valmista Pitsa</title>
</head>
<body>
<form method = "GET">
	<div class="toppings-outer">
		<div class="toppings-inner">
				<ul name="Lihad">
					<?php echo laeLihad();?>
				</ul>
		</div><!-- end toppings-inner -->
	</div><!-- end toppings-outer -->
	<div class="pizza-outer">
		<div class="pizza-inner">
			<a href="toppings/bottom.png"><img src="toppings/bottom.png" height="550" /></a>
			<input class="pizzabuttons" name ="pizzaCreate" type="submit" value="Submit">
		</div><!-- pizza-inner -->
	</div><!-- pizza-outer -->
<div class="bottoms-container">
<div class="bottoms-outer">
	<div class="bottoms-inner">
		<ul name="Veged">
			<?php echo laeVeged();?>
		</ul>
	</div><!-- end bottoms-inner -->
</div><!-- end bottoms-outer -->
</div><!-- end bottoms-container -->
</form>
</body>
</html>