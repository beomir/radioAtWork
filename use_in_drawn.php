<?php
	session_start();
	if(!isset($_SESSION['logged'])){
        header("Location: index.php");
        exit();
    }

	require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

	$dataForDeleteRadio = $_GET['token'];
	$userToken = explode("?",$dataForDeleteRadio)[0];
	$radioId = explode("=",$dataForDeleteRadio)[1];


	try{
        $connection = @new mysqli($host,$db_user,$db_password,$db_name);
        if($connection->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } 
    }catch(Exception $e){
        echo "<br>Developer Info: ".$e;
    }

	$setRadioDrawnStatus;
	$currentRadioDrawnStatusQuery = $connection->query("
	select use_with_drawn
	from users_radio_list
	join users  on users.user_id = users_radio_list.user_id 
	where users.token = '$userToken' and users_radio_list.radio_id = '$radioId'
	");

	$currentRadioDrawnStatusResult = $currentRadioDrawnStatusQuery->fetch_assoc();
	$currentRadioDrawnStatusValue = $currentRadioDrawnStatusResult['use_with_drawn'];

	if($currentRadioDrawnStatusValue==1){
		$_SESSION['c_added_to_drawn'] = "Radio removed from Drawn";
		$setRadioDrawnStatus = 0;
	} else {
		$_SESSION['c_added_to_drawn'] = "Radio added to Drawn";
		$setRadioDrawnStatus = 1;
	}


	if($connection->query("
	update users_radio_list
	join users  on users.user_id = users_radio_list.user_id 
	set use_with_drawn = '$setRadioDrawnStatus'
	where users.token = '$userToken' and users_radio_list.radio_id = '$radioId'"
	)){
		
		$_SESSION['c_added_to_drawn_status'] = true;
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
