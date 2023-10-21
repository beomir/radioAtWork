<?php
	session_start();
	if((isset($_SESSION['logged']))&&($_SESSION['logged']==true)){
		header('Location: radio.php');
		exit();
	}
	// $selected_lang = $_COOKIE['selected_language'];
	// if($selected_lang != null){
	// 	echo $selected_lang;
	// }
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http_equiv="X-UA-Compatible" content="IE-edge,chrome=1">
    <title>Radio</title>
    <link rel="stylesheet" href="css/basicStyles.css">
    <link rel="stylesheet" href="css/form.css">
	<link rel="stylesheet" href="css/buttons.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body onload="start()">
<div class="flags">
        <img id="polish"  src="images/pl2.png">
        <img id="english" src="images/gb2.png">
        <img id="german"  src="images/ge2.png">
</div>
<nav>
		<div class="navTitle">RADIO</div>
		<div id="rectangle1" class="rectangle"></div>
		<div id="rectangle2" class="rectangle"></div>
		<div id="rectangle3" class="rectangle"></div>
		<div id="rectangle4" class="rectangle"></div>
 </nav>
<div class="rightNav">
	<iframe id="radioVideo"
	type="text/html"
	width="320" 
	height="188" 
	src="https://www.youtube.com/embed/-cADeZjSwXs?start=70&autoplay=1&mute=1" 
	title="YouTube video player" 
	frameborder="0" 
	allow="autoplay"
	id="myRadioFrame">
	</iframe>
</div>

<form action="login.php" method="post" id="loginForm" class="formValues">
	<div style="margin-right: auto;margin-left: auto;" class="form">
		<div class="subtitle" id="logPanel"></div>
		<div class="input-container ic1">
		<input id="nameInput" class="input" type="text" name="login" placeholder=" " />
		<div class="cut"></div>
		<label for="name" class="placeholder name" id="name"></label>
		</div>
		<div class="input-container ic2">
		<input id="passwordName" class="input" type="password" name="password" placeholder=" " />
		<div class="cut"></div>
		<label for="password" class="placeholder password" id="password"></label>
		</div>
		<button class="button-29" type="submit" id="login"></button>
		<div class="button-29" style="display: flex;top:30%;background-image: radial-gradient(100% 100% at 100% 0, #5adaff 0, #915e25 100%);" id="changeFormLogin"></div>
	</div>
</form>

<form action="registration.php" method="post" id="registrationForm" class="formValues hideToLeftSide doNotDisplay">
	<div style="margin-right: auto;margin-left: auto;background-color: #484ac7" class="form">
		<div class="subtitle" id="registrationPanel"></div>
		
		<div class="input-container ic1">
		<input class="input" type="text" name="login" placeholder=" " />
		<div class="cutReg"></div>
		<label for="name" class="placeholder name" id="name"></label>
		</div>

		<div class="input-container ic2">
		<input  class="input" type="password" name="passwordRegistration" placeholder=" " />
		<div class="cutReg"></div>
		<label for="passwordRegistration" class="placeholder password" id="passwordRegistration"></label>
		</div>

		<div class="input-container ic2">
		<input  class="input" type="password" name="passwordRegistrationRepeat" placeholder=" " />
		<div class="cutReg"></div>
		<label for="passwordRegistrationRepeat" class="placeholder" id="passwordRegistrationRepeat"></label>
		</div>

		<div class="input-container ic2">
		<select  class="input" type="text" name="language" placeholder=" ">
			<option value="pl" id="polishLang"></option>
			<option value="gb" id="englishLang"></option>
			<option value="ge" id="germanLang"></option>
		</select>
		<div class="cutReg"></div>
		<label for="language" class="placeholder" id="defaultlanguage"></label>
		</div>

		<div class="input-container ic2">
		<input  class="input" type="text" name="email" placeholder=" " />
		<div class="cutReg"></div>
		<label for="email" class="placeholder" id="email"></label>
		</div>

		<button class="button-29" style="background-image: radial-gradient(100% 100% at 100% 0, #5adaff 0, #915e25 100%)" type="submit" id="registry"></button>
		<div class="button-29" style="display: flex;" id="changeFormRegistration"></div>
	</div>
</form>
<?php
echo '<div class="errorBox doNotDisplay rotate" id="errorBox">';
echo '<img src="images/arrowLeft.png" style="width:20px;height:20px;float:right;cursor:pointer" id="errorMsgState"/><img src="images/alert-icon-red-11.png" style="width:50px;height:50px;float:right"/><span style="font-size: 40px;font-weight: bold;" id="errorMsg"></span>';
			if(isset($_SESSION['loginError'])){
				echo $_SESSION['loginError'];
				unset($_SESSION['loginError']);
			}
			if(isset($_SESSION['e_registration'])){
				echo'<div class="doNotDisplay" id="registrationError">'.$_SESSION['e_registration'].'</div>';
				unset($_SESSION['e_registration']);
			}
			if(isset($_SESSION['e_nick'])){
				echo'<div class="error" id="nickNameError">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
			}
			if(isset($_SESSION['e_nickSC'])){
				echo'<div class="error" id="nickNameErrorSC">'.$_SESSION['e_nickSC'].'</div>';
				unset($_SESSION['e_nickSC']);
			}
			if(isset($_SESSION['e_email'])){
				echo'<div class="error" id="emailError">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
			if(isset($_SESSION['e_password'])){
				echo'<div class="error" id="passwordError">'.$_SESSION['e_password'].'</div>';
				unset($_SESSION['e_password']);
			}
			if(isset($_SESSION['e_passwordNotTheSame'])){
				echo'<div class="error" id="passwordNotTheSame">'.$_SESSION['e_passwordNotTheSame'].'</div>';
				unset($_SESSION['e_passwordNotTheSame']);
			}
			if(isset($_SESSION['e_nbr_of_users'])){
				echo'<div class="error" id="nbrOfUsers">'.$_SESSION['e_nbr_of_users'].'</div>';
				unset($_SESSION['e_nbr_of_users']);
			}
			if(isset($_SESSION['e_language'])){
				echo'<div class="error" id="langNotExists">'.$_SESSION['e_language'].'</div>';
				unset($_SESSION['e_language']);
			}
			if(isset($_SESSION['e_accounts'])){
				echo'<div class="error" id="accountSpam">'.$_SESSION['e_accounts'].'</div>';
				unset($_SESSION['e_accounts']);
			}
echo '</div>';
echo '<div class="correctBox doNotDisplay rotate"  id="correctBox">';
echo '<img src="images/arrowLeft.png" style="width:20px;height:20px;float:right;cursor:pointer" id="correctMsgState"/><img src="images/approved-icon-7.png" style="width:50px;height:50px;float:right"/><span style="font-size: 40px;font-weight: bold;" id="successMsg"></span>';

			if(isset($_SESSION['c_acc_inserted'])){
				echo'<div class="correct" id="accountCreated">'.$_SESSION['c_acc_inserted'].'</div>';
				unset($_SESSION['c_acc_inserted']);
			}
echo '</div>';
?>

<script src="js/cookies.js"></script>
<script src="js/translations.js"></script>
<script src="js/translationsIndex.js"></script>
<script src="js/index.js"></script>
<script src="js/nav.js"></script>

<?php
?>
</body>
</html>