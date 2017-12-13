<?php

//käivitab olemasolevat sessiooni
session_start();

//hävitab sessiooni koos muutujatega ja kõik kaasnevaga
session_destroy();

//suuname avalehele tagasi
header("Location: main.php");




?>
