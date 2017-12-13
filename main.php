<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Epic Pizza</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">

</head>
<body>
<div class="webpage container">
    <section class="navigation">
        <div class="container-fluid">
            <nav class="navbar navbar-light bg-light text-white">
                <div class="nav-upper">
                    <div class="nav-telli"><a>TELLI KOHE: 56942834</a></div>
                    <img class="nav-ostukorv" src="Graafika/ostukorv.png">
                </div>
                <div class="nav-bottom bg-red">
                    <div class="nav-logins">
                        <div class="nav-logins-registreeri">
						<?php
						if(isset($_SESSION["userID"])) {
							echo 'Tere <b>'.$_SESSION["userName"].'</b>!';
						}else{
							echo '<a href= "loginregister.php" class="text-white"> Registreeri </a>';
						}
						?>
						</div>
                        <div class="nav-logins-logisisse"> 
						<?php
						if(isset($_SESSION["userID"])) {
							echo '<a href= "logout.php" class="text-white"> LOGI VÄLJA </a>';
						}else{
							echo '<a href= "loginregister.php" class="text-white"> LOGI SISSE </a>';
						}
						?>
						</div>
                    </div>
                </div>
                <div class="nav-logo">

                    <img src="Graafika/logo.png">
                </div>
            </nav>

        </div>
    </section>
    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="valmistamine col-md-6">
                    <div class="row">
                        <div class="tee-pitsa col-md-12">
							<?php 
							
							//pitsavalimise lingi anname siis, kui kasutaja on sisse loginud 
							if(isset($_SESSION["userID"])) {
								echo '<div><a href="test.php">TEE OMA PITSA VALMIS SIIN<a></div>';
							}else{
								echo '<div>Pitsa valimiseks logi sisse!</div>';
							}
							?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="viimati-valmistatud col-md-12">
                            Viimati valmistatud pitsa:
                            <div class="col-md-12">                  
								<?php 
								
								//kui lisad valitud, näitab valmis pilti
								if(isset($_SESSION["userPizza"])) {
									echo '<img src="'.$_SESSION["userPizza"].'" alt="userPizza" height="300"  />';
									
									//kustutab muutuja ära, kui kasutaja värskendab brauserit, ei näe ta enam pilti(see oli taotuslik) (võib kasutada funktsiooni unlink -kustutab faili füüsiliselt)
									unset($_SESSION["userPizza"]);
								}else{
									echo "Siin pitsa";
								}
								?>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <img class="pitsakarp" src="Graafika/pitsakarp.png">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="populaarne">HETKEL POPULAARNE:</div>
            </div>
            <div class="row justify-content-center">
                <div class="card-deck">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">OLIVE</h4>
                        </div>
                        <img class="card-img-bottom" src="Graafika/pitsad/1.png" alt="Card image cap">
                        <div class="card-block lisakorvi">
                            lisa ostukorvi
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">OLIVE</h4>
                        </div>
                        <img class="card-img-bottom" src="Graafika/pitsad/2.png" alt="Card image cap">
                        <div class="card-block lisakorvi">
                            lisa ostukorvi
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">OLIVE</h4>
                        </div>
                        <img class="card-img-bottom" src="Graafika/pitsad/3.png" alt="Card image cap">
                        <div class="card-block lisakorvi">
                            lisa ostukorvi
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">OLIVE</h4>
                        </div>
                        <img class="card-img-bottom" src="Graafika/pitsad/4.png" alt="Card image cap">
                        <div class="card-block lisakorvi">
                            lisa ostukorvi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>
