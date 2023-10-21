<?php
	session_start();
	if(isset($_POST['email'])){
		$validationPassed = true;

		$nick = $_POST['login'];
		$email = $_POST['email'];
		$language = $_POST['language'];
		$emailSafe = filter_var($email,FILTER_SANITIZE_EMAIL);

		$password = $_POST['passwordRegistration'];
		$password2 = $_POST['passwordRegistrationRepeat'];

		$password_hash = password_hash($password,PASSWORD_DEFAULT);

		//lengthName between 3-20 char
		if(strlen($nick)<3 || (strlen($nick)>20)){
			$validationPassed = false;
			$_SESSION['e_nick'] = "Nick must have between 3 to 20 characters";
			$_SESSION['e_registration'] = true;
			header('Location: index.php');
		}
		//check special characters
		if(ctype_alnum($nick)==false){
			$validationPassed = false;
			$_SESSION['e_nickSC'] = "Nick can't have special characters";
			$_SESSION['e_registration'] = true;
			header('Location: index.php');
		}
		//check email
		if((filter_var($emailSafe,FILTER_VALIDATE_EMAIL)==false) || $emailSafe!= $email){
			$validationPassed = false;
			$_SESSION['e_email'] = "Email is wrong";
			$_SESSION['e_registration'] = true;
			header('Location: index.php');
		}
		//checking password
		if(strlen($password) < 8 || strlen($password) > 20){
			$validationPassed = false;
			$_SESSION['e_password'] = "Password have more than 8 and less than 20 characters";
			$_SESSION['e_registration'] = true;
			header('Location: index.php');
		}
		if($password!=$password2){
			$validationPassed = false;
			$_SESSION['e_passwordNotTheSame'] = "Passwords are not the same";
			$_SESSION['e_registration'] = true;
			header('Location: index.php');
		}

		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$clientIp = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$clientIp = $_SERVER['REMOTE_ADDR'];
		}
		

		try{
			$connection = @new mysqli($host,$db_user,$db_password,$db_name);
			if($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}else{
				//check if user exists
				$checkIfUserAlreadyExits = $connection-> query("Select user_id from users where email='$email' or user='$nick'");
				$languageIdQuery = $connection-> query("Select id from languages where lang_shortcut='$language'");
				if(!$checkIfUserAlreadyExits) throw new Exception($connection->error);
				if(!$languageIdQuery) throw new Exception($connection->error);

				$qtyOfExistedUsers = $checkIfUserAlreadyExits->num_rows;
				$qtyOfLanguages = $languageIdQuery->num_rows;
				$languageIdResult = $languageIdQuery->fetch_assoc();
				$languageId = $languageIdResult['id'];

				if($qtyOfExistedUsers>0){
					$validationPassed = false;
					$_SESSION['e_nbr_of_users'] = "User with this login or email already exists!";
					$_SESSION['e_registration'] = true;
					header('Location: index.php');
				}

				if($qtyOfLanguages<1){
					$validationPassed = false;
					$_SESSION['e_language'] = "Language does not exists";
					$_SESSION['e_registration'] = true;
					header('Location: index.php');
				}

				//check If from one ip address were already created 5 accounts
				$checkHowManyAccountsWereCreatedFromThisIp = $connection-> query("Select user_id from users where create_date >= CURDATE() and ip_creator='$clientIp'");
				if(!$checkHowManyAccountsWereCreatedFromThisIp) throw new Exception($connection->error);
				$qtyOfAccounts = $checkHowManyAccountsWereCreatedFromThisIp->num_rows;
				if($qtyOfAccounts >= 5){
					$validationPassed = false;
					$_SESSION['e_accounts'] = "Account spam!";
					$_SESSION['e_registration'] = true;
					header('Location: index.php');
				}
				//save to db
				if($validationPassed == true){	
					$bytes = bin2hex(random_bytes(10));

					if($connection->query("insert into users values(null,'$nick','$password_hash','$email','$languageId',null,'$clientIp','$bytes')")){
						$_SESSION['c_acc_inserted'] = "Account correctly Inserted";
						$_SESSION['e_registration'] = false;
						header('Location: index.php');
					}else{
						throw new Exception($connection->error);
					}
				}
				$connection->close();
			}
		}catch(Exception $e){
			echo "<div>Server error! Sorry for inconveniences</div>";
			echo "<br>Developer Info: ".$e;
		}

	}
?>
