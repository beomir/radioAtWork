<?php
	session_start();
	if(!isset($_SESSION['logged'])){
        header("Location: index.php");
        exit();
    }

	require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

	$userToken = $_POST['userToken'];
	$radioId = $_POST['radioId'];

	$newRadioUrl = $_POST['stationUrlInputEdit'];
	$newRadioName = $_POST['editStationNameInput'];
	

	try{
        $connection = @new mysqli($host,$db_user,$db_password,$db_name);
        if($connection->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } 
    }catch(Exception $e){
        echo "<br>Developer Info: ".$e;
    }

	$checkEditedRadioDataQuery = $connection->query("
	select rl.name,rl.url
	from users_radio_list url
	join users u on u.user_id = url.user_id 
	join radio_list rl on rl.id = url.radio_id
	where u.token = '$userToken' and url.radio_id = '$radioId'
	");

	if($radioId == null || $userToken == null){
		$_SESSION['e_update_radio'] = true;
		$_SESSION['e_radio_not_updated_token_or_radioId_were_removed'] = "RadioId or UserToken were removed from form";
		header('Location: index.php');
		exit();
	}
	

	$checkEditedRadioDataResult = $checkEditedRadioDataQuery->fetch_assoc();
	$oldRadioName = $checkEditedRadioDataResult['name'];
	$oldRadioUrl = $checkEditedRadioDataResult['url'];

	if($oldRadioName == $newRadioName && $newRadioUrl == $oldRadioUrl){
		$_SESSION['e_update_radio'] = true;
		$_SESSION['e_radio_not_updated_the_same_values'] = "The same values";
		header('Location: index.php');
		exit();
	}
	if($newRadioName == null || $newRadioUrl == null){
		$_SESSION['e_update_radio'] = true;
		$_SESSION['e_radio_not_updated_empty_places'] = "Radio name or URL is empty";
		header('Location: index.php');
		exit();
	}
	if($checkEditedRadioDataQuery->num_rows == 0){
		$_SESSION['e_update_radio'] = true;
		$_SESSION['e_radio_not_updated_radio_is_not_exists'] = "Radio is not exists";
		header('Location: index.php');
		exit();
	}

	if($connection->query("
	update radio_list
    join users_radio_list on users_radio_list.radio_id = radio_list.id
	join users  on users.user_id = users_radio_list.user_id 
	set name = '$newRadioName', url = '$newRadioUrl'
	where users.token = '$userToken' and users_radio_list.radio_id = '$radioId'"
	)){

		$connection->query("
		update radio_list_statistics
		set radio_name = '$newRadioName', radio_url = '$newRadioUrl'
		where radio_id = '$radioId'");

		
		$_SESSION['c_radio_updated'] = "Radio updated";
		$_SESSION['c_radio_updated_status'] = true;
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

		//////statistics start
		$statisticUserNoPeriodQuery = sprintf("
		select count(dr.id),rl.radio_name,rl.radio_url
		from drawn_radios dr
		join users u on u.user_id = dr.user_id
		join radio_list_statistics rl on rl.radio_id = dr.radio_id
		where u.token = '%s'
		group by rl.radio_name,rl.radio_url
		union ALL
		select 0,'',''
		union ALL
		select 0,'',''
		union ALL
		select 0,'',''
		union ALL
		select 0,'',''
		union ALL
		select 0,'',''
		order by 1 desc
		limit 5
		",
		mysqli_real_escape_string($connection,$userToken));
		$statisticUserNoPeriodResult = $connection->query($statisticUserNoPeriodQuery);
		$statisticUserNoPeriodData = $statisticUserNoPeriodResult->fetch_all();
		$_SESSION['i_statistic_user_no_period'] = $statisticUserNoPeriodData;

		$statisticNoPeriodQuery = sprintf("
		select count(dr.id),rl.radio_name,rl.radio_url
		from drawn_radios dr
		join radio_list_statistics rl on rl.radio_id = dr.radio_id
		group by rl.radio_name,rl.radio_url
		union ALL
		select 0,'',''
		union ALL
		select 0,'',''
		union ALL
		select 0,'',''
		union ALL
		select 0,'',''
		union ALL
		select 0,'',''
		order by 1 desc
		limit 5
		");
		$statisticNoPeriodResult = $connection->query($statisticNoPeriodQuery);
		$statisticNoPeriodData = $statisticNoPeriodResult->fetch_all();
		$_SESSION['i_statistic_no_period'] = $statisticNoPeriodData;

		$statisticUserTodayQuery = sprintf("
		select count(dr.id),rl.radio_name,rl.radio_url
		from drawn_radios dr
		join users u on u.user_id = dr.user_id
		join radio_list_statistics rl on rl.radio_id = dr.radio_id
		where u.token = '%s' and dr.creation_date_time >= CURRENT_DATE
		group by rl.radio_name,rl.radio_url
		union ALL
		select 0,'',''
		union ALL
		select 0,'',''
		union ALL
		select 0,'',''
		union ALL
		select 0,'',''
		union ALL
		select 0,'',''
		order by 1 desc
		limit 5
		",mysqli_real_escape_string($connection,$userToken));
		$statisticUserTodayResult = $connection->query($statisticUserTodayQuery);
		$statisticUserTodayData = $statisticUserTodayResult->fetch_all();
		$_SESSION['i_statistic_user_today'] = $statisticUserTodayData;
		/////statistics end


		header('Location: index.php');
		$connection->close();
	}else{
		throw new Exception($connection->error);
	}

?>
