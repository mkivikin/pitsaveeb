
<?php
    /* REGISTREERI PHP KOOD */
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


<?php
    /*LOGIN PHP KOOD*/
    require("../../config.php");
    require("functions.php");
    $notice = "";
    $loginUser = "";
    $loginPasswordError = "";
    $success = "";
    if(isset ($_SESSION["userID"])){
        header("Location: main.php");
        exit();
    }
    if (isset($_POST["signinButton"])) {
        if (isset($_POST["loginUsername"])) {
            if (!empty($_POST["loginUsername"])) {
                $loginUser = $_POST["loginUsername"];
            }
            else {
                $notice = "Kasutaja nimi on sisselogimiseks kohustuslik";
            }
        }
        if (isset($_POST["loginPassword"])) {
            if (empty($_POST["loginPassword"])) {
                $loginPasswordError = "Sisselogimiseks on vaja sisestada parool";
            }
            else {
            }
        }
        if (!empty($_POST["loginUsername"]) and !empty($_POST["loginPassword"])) {
            echo loginFunction($loginUser,($_POST["loginPassword"]));
        }
    }
    
    if (isset($_POST["goToRegister"])) {
        header("Location: register.php");
    }
?>

<!doctype html>
<html lang="en">
<head>
    <title>Sisene veebi</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
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
                        <div class="nav-logins-registreeri">registreeri</div>
                        <div class="nav-logins-logisisse">LOGI SISSE</div>
                    </div>
                </div>
                <div class="nav-logo">
                    <img src="Graafika/logo.png">
                </div>
            </nav>

        </div>
    </section>
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-around">

                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md text-white bg-red loginHeading">
                            <p>REGISTREERI</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md bg-faded-white registreeri-form d-flex align-items-center padup">
                            <div class="container">
                                <form class="" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                    <span class="warning"><?php echo $signupPasswordError; ?> </span>
                                    <div class="form-group row">
                                        <label for="signup-user" class="col-sm-4 col-form-label">Kasutajanimi</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="signup-user" name="signupUser" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="signup-pw" class="col-sm-4 col-form-label">Salasõna</label>
                                        <div class="col-sm-8">
                                        <input name="signupPassword" type="password" id="signup-pw" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="signup-email" class="col-sm-4 col-form-label">Email</label>
                                        <div class="col-sm-8">
                                        <input name="signupEmail" type="email" class="form-control" id="signup-email" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="signup-firstname" class="col-sm-4 col-form-label">Eesnimi</label>
                                        <div class="col-sm-8">
                                        <input name="signupFirstName" value="" type="text" class="form-control" id="signup-firstname" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="signup-familyname" class="col-sm-4 col-form-label">Perenimi</label>
                                        <div class="col-sm-8">
                                        <input name="signupFamilyName" value="" type="text" class="form-control" id="signup-familyname" placeholder="" required>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label>Sünnikuupäev</label>
                                        <div>
                                            <?php echo "\n <br> \n" .$signupDaySelectHTML ."\n" .$signupMonthSelectHTML ."\n" .$signupYearSelectHTML ."\n <br> \n";$signupMonthSelectHTML;?>     
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="signup-number" class="col-sm-4 col-form-label">Number</label>
                                        <div class="col-sm-8">
                                        <input name="signupNumber" value="" type="text" class="form-control" id="signup-number" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="signup-gender" class="col-sm-4 col-form-label">Sugu</label>
                                        <div class="col-sm-8">
                                        <select class="form-control" name="signupGender" type="number" id="signup-gender">
                                            <option value="1">Mees</option>
                                            <option value="2">Naine</option>
                                        </select>
                                    </div>
                                    </div>
                                    <button class="btn btn-primary btn-red full" name="signupButton" type="submit" value="Loo kasutaja">Loo kasutaja</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md text-white bg-red loginHeading">
                            <p>LOGI SISSE</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md bg-faded-white logisisse-form d-flex align-items-center padup">
                            <form class="container" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >
                                <span style="color:red" ><?php echo $notice, $loginPasswordError; ?></span>
                                <span><?php echo $success; ?></span>
                                <div class="form-group">
                                    <label for="logisisse-email">Email</label>
                                    <input type="text" class="form-control" id="logisisse-email" placeholder="" name="loginUsername" value="<?php echo $loginUser; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="logisisse-pw">Salasõna</label>
                                    <input type="password" class="form-control" id="logisisse-pw" name="loginPassword" placeholder="Salasõna">
                                </div>

                                

                            </form>
                        </div>
                    </div>
                    <div class="row">
                            
                            <button class="btn btn-primary btn-red full" id="loginButton" name="signinButton" type="submit" value="Logi sisse">Logi sisse</button>
                        
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