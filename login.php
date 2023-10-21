<?php

    session_start();
    if(!isset($_POST['login']) || (!isset($_POST['password']))){
        header("Location: index.php");
        exit();
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try{
        $connection = @new mysqli($host,$db_user,$db_password,$db_name);
        if($connection->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        } 
    }catch(Exception $e){
        echo "<br>Developer Info: ".$e;
    }
    

        $login = $_POST['login'];
        $password = $_POST['password'];

        $login = htmlentities($login,ENT_QUOTES,"UTF-8");
        $password = htmlentities($password,ENT_QUOTES,"UTF-8");

        $userData = "";

        if($findUser = @$connection->query(
            sprintf("select * from users where user='%s'",
            mysqli_real_escape_string($connection,$login)
            ))){
            $resultQty = $findUser->num_rows;
            if($resultQty>0){
                $row = $findUser->fetch_assoc();
                if(password_verify($password,$row['password'])){

                    $_SESSION['logged'] = true;
                    $_SESSION['e_login'] = false;
                    
                    $_SESSION[''] = $row['user_id'];
                    $_SESSION['user'] = $row['user'];

                    $_SESSION['userToken'] = $row['token'];

                    $userRadioListQuery = sprintf(
                        "select rl.name radio_name,
                         rl.url radio_url,
                         concat('token=',u.token,'?id=',url.radio_id) as token_user_radio_id,
                         use_with_drawn,
                         concat('token=',u.token,'?id=',url.radio_id) as use_with_drawn_url,
                         url.radio_id
                         from users u 
                         join users_radio_list url on url.user_id = u.user_id 
                         join radio_list rl on rl.id = url.radio_id 
                         where u.user ='%s'",
                    mysqli_real_escape_string($connection,$login));
                    $findUserRadioList = $connection->query($userRadioListQuery);
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
                    mysqli_real_escape_string($connection,$row['token']));
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
                    ",mysqli_real_escape_string($connection,$row['token']));
                    $statisticUserTodayResult = $connection->query($statisticUserTodayQuery);
                    $statisticUserTodayData = $statisticUserTodayResult->fetch_all();
                    $_SESSION['i_statistic_user_today'] = $statisticUserTodayData;
                    /////statistics end


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
                    mysqli_real_escape_string($connection,$row['token']));
                
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
                    mysqli_real_escape_string($connection,$row['token']));
                
                    $drawnsTodayResult = $connection->query($drawnsToday);
                    $qtyOfDrawns = $drawnsTodayResult->num_rows;
                
                    $drawnsData = $drawnsTodayResult->fetch_all();
                    $_SESSION['i_drawn_radio_qty'] = $qtyOfDrawns;
                    if($drawnsData != null){
                        $_SESSION['last_drawn_radio_name'] = $drawnsData[0][14];
                        $_SESSION['last_drawn_radio_url'] = $drawnsData[0][15];
                    }
                    unset($_SESSION['loginError']);
                    $findUser->free_result();
                    $findUserRadioList->free_result();
                    @header('Location: radio.php');
                } else{
                    $_SESSION['e_login'] = true;
                    $_SESSION['loginError'] = '<div style="color:#ffa07a" id="loginError"></div><span class="doNotDisplay" id="loginErrorState">'.$_SESSION['e_login'].'</span>';
                    header('Location: index.php');
                }
            }else{
                $_SESSION['e_login'] = true;
                $_SESSION['loginError'] = '<div style="color:#ffa07a" id="loginError"></div><span class="doNotDisplay" id="loginErrorState">'.$_SESSION['e_login'].'</span>';
                header('Location: index.php');
            }

        $connection->close();
    }

?>