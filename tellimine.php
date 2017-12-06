<?php
$pizzaList=getAllPizzasFunction();

class Pizza {
    public $pizzaId;
	public $pizzaName;
	public $pizzaPrice;
}

function getAllPizzasFunction() {
	$database = "if17_marek6";
	$pizzaList = [];
	$mysqli = new mysqli("localhost","if17","if17", $database);
	$stmt = $mysqli->prepare("SELECT pizza_id, pizza_name, pizza_price FROM pizzas");
	$stmt->bind_result($pizzaId, $pizzaName, $pizzaPrice);
	$stmt->execute();
	while ($stmt->fetch()){
		$pizza = new Pizza();
		$pizza->pizzaId=$pizzaId;
		$pizza->pizzaName=$pizzaName;
		$pizza->pizzaPrice=$pizzaPrice; 
		array_push($pizzaList, $pizza);
	}
	$mysqli->close();
	$stmt->close();
	return $pizzaList; 
	
}
?>



<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Tellimine</title>
</head>
<body>
	<h1>Vali pizza!</h1>
	<form method="POST" action="<?php 'toppings.php'; ?>">
	<?php
	foreach ($pizzaList as $pizza){
		?>
		<br /><input type="radio" id="<?php echo $pizza->pizzaId; ?>" name="pizzaSelection" value="<?php echo $pizza->pizzaId; ?>">
		<label for="<?php echo $pizza->pizzaId; ?>">
			<img src="pizzad/<?php echo $pizza->pizzaId; ?>.jpg" title="<?php echo $pizza->pizzaName; ?>" height="100"/><?php echo $pizza->pizzaName; ?>
		</label>
		<?php
	}
	?>
	<br /><input name="choosePizzaButton" type="submit" value="Vali pizza" class="loginbuttons" width="100">
	</form>
</body>
</html>