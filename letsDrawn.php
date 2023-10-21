<?php
	session_start();
	if(!isset($_SESSION['logged'])){
        header("Location: index.php");
        exit();
    }

	require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

	$userToken = $_SESSION['userToken'];

	try{
        $connection = @new mysqli($host,$db_user,$db_password,$db_name);
        if($connection->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } 
    }catch(Exception $e){
        echo "<br>Developer Info: ".$e;
    }
	
	$findLimitOfDrawsForUserBasedOnAccountStatus = sprintf("
	select user_id, case when to_date < CURRENT_DATE or to_date is null then standard else premium end
	from (
		SELECT u.user_id,
		max(p.to_date) to_date,
		CURRENT_TIMESTAMP,
		(select drawn_for_standard_account from base_settings) standard,
		(select drawn_for_premium_account from base_settings) premium
		from users u
		left outer join premium p on p.user_id = u.user_id
		where u.token = '%s'
		group by u.user_id,(select drawn_for_standard_account from base_settings),(select drawn_for_premium_account from base_settings)
	) a",
	mysqli_real_escape_string($connection,$userToken));

	$accountLimitsResult = $connection->query($findLimitOfDrawsForUserBasedOnAccountStatus);
	$accountLimitsData = $accountLimitsResult->fetch_all();
	$_SESSION['i_max_drawns_for_account'] = $accountLimitsData[0][1];

	$drawnsToday = sprintf("
	SELECT * 
	FROM drawn_radios dr
	join users u on u.user_id = dr.user_id
	join radio_list_statistics rl on rl.radio_id = dr.radio_id
	where 
	token = '%s'
	and
	dr.creation_date_time >= CURRENT_DATE
	order by dr.creation_date_time desc,dr.id desc",
	mysqli_real_escape_string($connection,$userToken));

	$drawnsTodayResult = $connection->query($drawnsToday);
	$qtyOfDrawns = $drawnsTodayResult->num_rows;

	$drawnsData = $drawnsTodayResult->fetch_all();
	$_SESSION['i_drawn_radio_qty'] = $qtyOfDrawns;
	if($drawnsData != null){
		$_SESSION['last_drawn_radio_name'] = $drawnsData[0][14];
		$_SESSION['last_drawn_radio_url'] = $drawnsData[0][15];
	}

	if($qtyOfDrawns + 1>$_SESSION['i_max_drawns_for_account']){
		$_SESSION['i_premium'] = true;
		$_SESSION['i_premium_buy_it'] = "To get more than 5 drawns per day then go buy premium account";
		header('Location: index.php');
		exit();
	}
	
	$userRadioListToDrawnQuery = sprintf("
	select rl.name radio_name,rl.url radio_url,url.radio_id,u.user_id
	from users u 
	join users_radio_list url on url.user_id = u.user_id 
	join radio_list rl on rl.id = url.radio_id 
	where u.token ='%s' and use_with_drawn = 1",
	mysqli_real_escape_string($connection,$userToken));

	$userRadioListToDrawnList = $connection->query($userRadioListToDrawnQuery);
	if($userRadioListToDrawnList){
		$userRadioListToDrawnResult = $userRadioListToDrawnList->fetch_all();
	} else {
		$_SESSION['e_drawn_radio'] = true;
		$_SESSION['e_drawn_radio_query_error'] = "Query Error";
		header('Location: index.php');
		exit();
	}


	if($userRadioListToDrawnResult == null){
		$_SESSION['e_drawn_radio'] = true;
		$_SESSION['e_drawn_radio_drawn_list_is_empty'] = "Drawn list is empty";
		header('Location: index.php');
		exit();
	}
    
    
	$drawRandNbrForRadio = rand(0,sizeof($userRadioListToDrawnResult)-1);
	$_SESSION['drawnRadioUrl'] = $userRadioListToDrawnResult[$drawRandNbrForRadio][1];
	$_SESSION['drawnRadio'] = $userRadioListToDrawnResult[$drawRandNbrForRadio][0];
	$radioId = $userRadioListToDrawnResult[$drawRandNbrForRadio][2];
	$userId = $userRadioListToDrawnResult[$drawRandNbrForRadio][3];

	$connection->query("insert into drawn_radios(radio_id,user_id,creation_date_time) values('$radioId','$userId',CURRENT_TIMESTAMP())");
	

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

	$_SESSION['i_drawn_radio_qty'] = $connection->query($drawnsToday)->num_rows;
	
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
		$findUserRadioList = $connection->query($userRadioListQuery);
		$userRadioList = $findUserRadioList->fetch_all();
		$_SESSION['userRadioList'] = $userRadioList;

		header('Location: index.php');
		$connection->close();

?>
