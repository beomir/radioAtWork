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

	if($connection->query("delete url from users_radio_list url join users u on u.user_id = url.user_id where u.token = '$userToken' and url.radio_id = '$radioId'")){
	   $connection->query("delete rl from radio_list rl where id = '$radioId'");
	    $_SESSION['c_radio_removed_status'] = true;
		$_SESSION['c_radio_removed'] = "Radio correctly removed";

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
