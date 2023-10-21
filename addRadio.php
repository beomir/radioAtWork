<?php
	session_start();
	if(!isset($_SESSION['logged'])){
        header("Location: index.php");
        exit();
    }

	require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

	$userToken = $_SESSION['userToken'];

	$newRadioUrl = $_POST['addStationUrl'];
	$newRadioName = $_POST['addStationName'];

	if($newRadioUrl == null || $newRadioName == null){
		$_SESSION['e_add_radio'] = true;
		$_SESSION['e_addRadio_radio_url_or_name_is_empty'] = "Radio name or URL is empty";
		header('Location: index.php');
		exit();
	}

	try{
        $connection = @new mysqli($host,$db_user,$db_password,$db_name);
        if($connection->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } 
    }catch(Exception $e){
        echo "<br>Developer Info: ".$e;
    }

	$checkIfRadioAlreadyExistsForUser = $connection->query(
	sprintf("
    select *
	from users_radio_list url
	join users u on u.user_id = url.user_id 
	join radio_list rl on rl.id = url.radio_id
	where 
    u.token='%s'
    and rl.url ='%s'
    and rl.name ='%s'
	", $userToken,$newRadioUrl,$newRadioName));


	if($checkIfRadioAlreadyExistsForUser->num_rows > 0){
		$_SESSION['e_add_radio'] = true;
		$_SESSION['e_addRadio_already_exists'] = "Radio already exists, cannot add radio with the same values";
		header('Location: index.php');
		exit();
	}
	

	$insertNewRadio = "insert into radio_list(name,url) values('$newRadioName','$newRadioUrl')";
	$insertNewRadioToStatisticTable = "insert into radio_list(name,url) values('$newRadioName','$newRadioUrl')";

	$getUserIdQuery = $connection-> query("Select user_id from users where token ='$userToken'");
	$getUserIdResult = $getUserIdQuery->fetch_assoc();
	$userId = $getUserIdResult['user_id'];
	if($userId == null){
		$_SESSION['e_add_radio'] = true;
		$_SESSION['e_addRadio_cannot_find_user'] = "User with this token doesnt exists";
		header('Location: index.php');
		exit();
	}

	if ($connection->query($insertNewRadio) === TRUE) {
		$last_id = mysqli_insert_id($connection);

		$connection->query("insert into users_radio_list(user_id,radio_id,use_with_drawn) values('$userId','$last_id',TRUE)");
		$connection->query("insert into radio_list_statistics(radio_id,radio_name,radio_url) values('$last_id','$newRadioName','$newRadioUrl')");
		
		$_SESSION['c_radio_added'] = "Radio added";
		$_SESSION['c_add_radio'] = true;
		$userRadioListQuery = sprintf("
		select rl.name
		radio_name,
		rl.url radio_url,
		concat('token=',u.token,'?id=',url.radio_id) as token_user_radio_id,
		use_with_drawn,
		concat('token=',u.token,'?id=',url.radio_id) as use_with_drawn_url,
		url.radio_id
		from users u 
		join users_radio_list url on url.user_id = u.user_id 
		join radio_list rl on rl.id = url.radio_id 
		where u.token ='%s'",
		mysqli_real_escape_string($connection,$userToken));
		$findUserRadioList = @$connection->query($userRadioListQuery);
		$userRadioList = $findUserRadioList->fetch_all();
		$_SESSION['userRadioList'] = $userRadioList;


		header('Location: index.php');
		$connection->close();
	}else{
		throw new Exception($connection->error);
	}

?>
