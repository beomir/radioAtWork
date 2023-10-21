<?php
session_start();

if(!isset($_SESSION['logged'])){
	header("Location: index.php");
	exit();
}

?>
<html>
<head>
	<link rel="stylesheet" href="css/buttons.css">
	<link rel="stylesheet" href="css/basicStyles.css">
	<link rel="stylesheet" href="css/form.css">
	<link rel="stylesheet" href="css/table.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<div id="first-container">
<div class="flags">
	<img id="polish"  src="images/pl2.png">
	<img id="english" src="images/gb2.png">
	<img id="german"  src="images/ge2.png">
</div>
<div class="counter">
	<?php
	echo "<div style='display: inline-block' id='qtyOfTodayDrawn'></div>: <div style='display: inline-block'>".$_SESSION['i_drawn_radio_qty']." / ".$_SESSION['i_max_drawns_for_account']."</div>";
	?>
</div>
<nav>
		<div class="navTitle">RADIO</div>
		<div id="rectangle1" class="rectangle"></div>
		<div id="rectangle2" class="rectangle"></div>
		<div id="rectangle3" class="rectangle"></div>
		<div id="rectangle4" class="rectangle"></div>
 </nav>
 <div class="statistics">
	<?php
	///For user without Period
	echo "<table class='statistics-table'>";
	echo "<tr><td colspan='2'><span id='userStats'></span></td><tr>";
	echo "<th style='width:60%' class='radioNameForStatisticTable'></th>";
	echo "<th style='width:40%' class='qtyOfDrawnsForRadio'></th>";
	foreach($_SESSION['i_statistic_user_no_period'] as $value){
		echo "<tr>";
		echo "<td><a target='_blank' href=".$value[2]."><div class='radioName'>".$value[1]."</div></a></td>";
		echo "<td><div>".$value[0]."</div></td>";
		echo "</tr>";
	}
	echo "</table>";

	///For user today
	echo "<table class='statistics-table'>";
	echo "<tr><td colspan='2'><span id='userStatsToday'></span></td><tr>";
	echo "<th style='width:60%' class='radioNameForStatisticTable'></th>";
	echo "<th style='width:40%' class='qtyOfDrawnsForRadio'></th>";
	foreach($_SESSION['i_statistic_user_today'] as $value){
		echo "<tr>";
		echo "<td><a target='_blank' href=".$value[2]."><div class='radioName'>".$value[1]."</div></a></td>";
		echo "<td><div>".$value[0]."</div></td>";
		echo "</tr>";
	}
	echo "</table>";

	///For all users without period
	echo "<table class='statistics-table'>";
	echo "<tr><td colspan='2'><span id='allUsersStats'></span></td><tr>";
	echo "<th style='width:60%' class='radioNameForStatisticTable'></th>";
	echo "<th style='width:40%' class='qtyOfDrawnsForRadio'></th>";
	foreach($_SESSION['i_statistic_no_period'] as $value){
		echo "<tr>";
		echo "<td><a target='_blank' href=".$value[2]."><div class='radioName'>".$value[1]."</div></a></td>";
		echo "<td><div>".$value[0]."</div></td>";
		echo "</tr>";
	}
	echo "</table>";
	?>
 </div> 

	<div>
		<div class="leftNav">
			<?php
				echo "<p><span id='hello'></span><span style='color:green;font-weight:bold'> ".$_SESSION['user']."</span><a style='float:right;color:red' href='logout.php' id='logout'></a></p>";
				echo '<table class="radioTable" id="radioTableId"><thead>';
				echo '<th id="radioList"><span>:</span></th>';
				echo '<th></th>';
				echo '<th></th>';
				echo '<th></th>';
				echo '</thead>';
				echo '<tbody>';
				foreach($_SESSION['userRadioList'] as $value){
					echo "<tr>";
					echo "<td><a target='_blank' href=".$value[1]."><div class='radioName'>".$value[0]."</div></a></td>";
					echo "<td class='deleteRadioFromMyList'><div class='makeItBigger'><img name='".$value[2]."' class='deleteRadio' style='height:20px;weight:20px;cursor:pointer' src='images/remove-icon.png'/></div></td>";
					echo "<td class='updateRadioInMyList'><img id='stationId".$value[5]."' class='makeItBigger stationId' style='height:20px;weight:20px;cursor:pointer' src='images/rename.png'/></td>";
					if($value[3]==0){
						echo "<td class='useInDrawn'><a href='use_in_drawn.php?".$value[4]."'><img class='makeItBigger' style='height:20px;weight:20px' src='images/black-star.png'/></a></td>";
					} else {
						echo "<td class='doNotUseInDrawn'><a href='use_in_drawn.php?".$value[4]."'><img class='makeItBigger' style='height:20px;weight:20px' src='images/gold-star.png'/></a></td>";
					}
					echo "</tr>";
				}
				echo '</tbody>';
				echo '</table>';


			?>
			<br>
			<button class="button-29" id="addButton"></button>

			<form action="letsDrawn.php" method="post">
				<button class="button-29 button-28" id="refresh" name="refresh" type="submit"></button>
			</form>
		</div>
		<div class="centralPositions centerText">
				<?php
					if($_SESSION['i_drawn_radio_qty'] == $_SESSION['i_max_drawns_for_account']){
						echo "<br>";
						echo "<div id='theLastDrawnRadio'></div>";
						echo "<br>";
						echo "<br>";
						echo "<a href='".$_SESSION['last_drawn_radio_url']."' target='_blank' id='linkHere'><button class='circle' id='found'>".$_SESSION['last_drawn_radio_name']."</button></a>";
						echo "<br>";
						echo "<br>";
						echo "<div id='toManyDrawsForStandardAccount'></div>";
					} else if(isset($_SESSION['drawnRadio'])){
					echo "<div id='drawForToday'></div>";
					echo "<a href='".$_SESSION['drawnRadioUrl']."' target='_blank' id='linkHere'><button class='circle' id='found'>".$_SESSION['drawnRadio']."</button></a>";
					} else {
						echo "<div id='welcome'></div>";

						if(isset($_SESSION['last_drawn_radio_url'])){
							echo "<br>";
							echo "<div id='theLastDrawnRadio'></div>";
							echo "<br>";
							echo "<br>";
							echo "<a href='".$_SESSION['last_drawn_radio_url']."' target='_blank' id='linkHere'><button class='circle' id='found'>".$_SESSION['last_drawn_radio_name']."</button></a>";
						}
					}
				?>
			
		</div>
		<form action="addRadio.php" method="post" id="addRadioForm" class="formValues hideToLeftSide doNotDisplay">
			<div style="margin-right: auto;margin-left: auto;" class="form">
			<img src="images/cross-close.png" style="width:20px;height:20px;float:right;cursor:pointer" id="closeModalButton" title="Close modal">
				<div class="subtitle" id="addNextRadioStation"></div>
				<div class="input-container ic1">
				<input name="addStationName" id="stationNameInput" class="input" type="text" placeholder=" " />
				<div class="cut"></div>
				<label for="stationNameInput" class="placeholder stationName" ></label>
				</div>
				<div class="input-container ic2">
				<input name="addStationUrl" id="stationUrl" class="input" type="text" placeholder=" " />
				<div class="cut"></div>
				<label for="stationUrl" class="placeholder stationUrl" ></label>
				</div>
				<button type="text" class="buttonForm" id="addStation"></button>
			</div>
		</form>


		<form action="editRadio.php" method="post" id="editRadioForm" class="formValues hideToLeftSide doNotDisplay">
			<div style="margin-right: auto;margin-left: auto;" class="form">
			<img src="images/cross-close.png" style="width:20px;height:20px;float:right;cursor:pointer" id="closeModalButtonEditForm" title="Close modal">
				<div class="subtitle" id="editRadioStation"></div>
				<div class="input-container ic1">
				<input name="editStationNameInput" id="editStationNameInput" class="input" type="text" placeholder=" " />
				<div class="cut"></div>
				<label for="editStationNameInput" class="placeholder stationName" ></label>
				</div>
				<div class="input-container ic2">
				<input name="stationUrlInputEdit" id="stationUrlInputEdit" class="input" type="text" placeholder=" " />
				<div class="cut"></div>
				<label for="stationUrlInputEdit" class="placeholder stationUrl"></label>
				</div>
				<input name="radioId" id="radioId" class="doNotDisplay"  type="text"/>
				<?php
				echo "<input name='userToken' value='".$_SESSION['userToken']."' class='doNotDisplay'  type='text'/>"
				?>
				<button type="text" class="buttonForm"  id="editStation"></button>
			</div>
		</form>
	</div>
</div>

<div id="questionBox" class="questionBox hideAboveTheTop doNotDisplay">

		<img src="images/arrowLeft.png" style="width:20px;height:20px;float:right;cursor:pointer" id="questionMsgState"/><img src="images/question-icon.png" style="width:50px;height:50px;float:right"/><span style="font-size: 40px;font-weight: bold;" id="questionMsg"></span>
		<div class="question">
			<div><span id="areYouSureThatYouWantDelete"></span><span> </span><span id="radio"></span>?</div>
			<button class="button-delete" id="deleteRadioConfirmation"></button> 
			<button class="button-cancel"id="moveBack"></button>
		</div>

</div>


<?php
if(isset($_SESSION['e_update_radio'])){
echo '<div class="errorBoxRadio rotate" id="errorBox">';
echo '<img src="images/arrowLeft.png" style="width:20px;height:20px;float:right;cursor:pointer" id="errorMsgState"/><img src="images/alert-icon-red-11.png" style="width:50px;height:50px;float:right"/><span style="font-size: 40px;font-weight: bold;" id="errorMsg"></span>';
if(isset($_SESSION['e_radio_not_updated_the_same_values'])){
	echo '<div class="error" id="theSameValues">'.$_SESSION['e_radio_not_updated_the_same_values'].'</div>';
	unset($_SESSION['e_radio_not_updated_the_same_values']);
}
if(isset($_SESSION['e_radio_not_updated_radio_is_not_exists'])){
	echo '<div class="error" id="radioIsNotExists">'.$_SESSION['e_radio_not_updated_radio_is_not_exists'].'</div>';
	unset($_SESSION['e_radio_not_updated_radio_is_not_exists']);
}
if(isset($_SESSION['e_radio_not_updated_token_or_radioId_were_removed'])){
	echo '<div class="error" id="radioIdOrTokenWereRemoved">'.$_SESSION['e_radio_not_updated_token_or_radioId_were_removed'].'</div>';
	unset($_SESSION['e_radio_not_updated_token_or_radioId_were_removed']);
}
if(isset($_SESSION['e_radio_not_updated_empty_places'])){
	echo '<div class="error" id="emptyFieldsOnAddRadio">'.$_SESSION['e_radio_not_updated_empty_places'].'</div>';
	unset($_SESSION['e_radio_not_updated_empty_places']);
}
echo '</div>';
unset($_SESSION['e_update_radio']);
}

if(isset($_SESSION['e_drawn_radio'])){
	echo '<div class="errorBoxRadio rotate" id="errorBox">';
	echo '<img src="images/arrowLeft.png" style="width:20px;height:20px;float:right;cursor:pointer" id="errorMsgState"/><img src="images/alert-icon-red-11.png" style="width:50px;height:50px;float:right"/><span style="font-size: 40px;font-weight: bold;" id="errorMsg"></span>';
	if(isset($_SESSION['e_drawn_radio_query_error'])){
		echo '<div class="error" id="queryError">'.$_SESSION['e_drawn_radio_query_error'].'</div>';
		unset($_SESSION['e_drawn_radio_query_error']);
	}
	if(isset($_SESSION['e_drawn_radio_drawn_list_is_empty'])){
		echo '<div class="error" id="drawnRadioListIsEmpty">'.$_SESSION['e_drawn_radio_drawn_list_is_empty'].'</div>';
		unset($_SESSION['e_drawn_radio_drawn_list_is_empty']);
	}
	echo '</div>';
unset($_SESSION['e_drawn_radio']);
}


if(isset($_SESSION['c_radio_updated'])){
echo '<div class="correctBoxRadio rotate" id="correctBox">';
echo '<img src="images/arrowLeft.png" style="width:20px;height:20px;float:right;cursor:pointer" id="correctMsgState"/><img src="images/approved-icon-7.png" style="width:50px;height:50px;float:right"/><span style="font-size: 40px;font-weight: bold;" id="successMsg"></span>';

			if(isset($_SESSION['c_radio_updated'])){
				echo'<div class="correct" id="radioUpdated">'.$_SESSION['c_radio_updated'].'</div>';
				unset($_SESSION['c_radio_updated']);
			}
echo '</div>';
unset($_SESSION['c_radio_updated']);
}


if(isset($_SESSION['c_radio_removed_status'])){
	echo '<div class="correctBoxRadio rotate" id="correctBox">';
	echo '<img src="images/arrowLeft.png" style="width:20px;height:20px;float:right;cursor:pointer" id="correctMsgState"/><img src="images/approved-icon-7.png" style="width:50px;height:50px;float:right"/><span style="font-size: 40px;font-weight: bold;" id="successMsg"></span>';
	
				if(isset($_SESSION['c_radio_removed'])){
					echo'<div class="correct" id="radioCorrectlyDeleted">'.$_SESSION['c_radio_removed'].'</div>';
					unset($_SESSION['c_radio_removed']);
				}
	echo '</div>';
	unset($_SESSION['c_radio_removed_status']);
}

if(isset($_SESSION['c_radio_added'])){
	echo '<div class="correctBoxRadio rotate" id="correctBox">';
	echo '<img src="images/arrowLeft.png" style="width:20px;height:20px;float:right;cursor:pointer" id="correctMsgState"/><img src="images/approved-icon-7.png" style="width:50px;height:50px;float:right"/><span style="font-size: 40px;font-weight: bold;" id="successMsg"></span>';
	
				if(isset($_SESSION['c_radio_added'])){
					echo'<div class="correct" id="radioCorrectlyAdded">'.$_SESSION['c_radio_added'].'</div>';
					unset($_SESSION['c_radio_added']);
				}
	echo '</div>';
	unset($_SESSION['c_radio_added']);
}
if(isset($_SESSION['e_add_radio'])){
	echo '<div class="errorBoxRadio rotate" id="errorBox">';
	echo '<img src="images/arrowLeft.png" style="width:20px;height:20px;float:right;cursor:pointer" id="errorMsgState"/><img src="images/alert-icon-red-11.png" style="width:50px;height:50px;float:right"/><span style="font-size: 40px;font-weight: bold;" id="errorMsg"></span>';
	if(isset($_SESSION['e_addRadio_already_exists'])){
		echo '<div class="error" id="radioAlreadyExists">'.$_SESSION['e_addRadio_already_exists'].'</div>';
		unset($_SESSION['e_addRadio_already_exists']);
	}
	if(isset($_SESSION['e_addRadio_cannot_find_user'])){
		echo '<div class="error" id="cannotFindUser">'.$_SESSION['e_addRadio_cannot_find_user'].'</div>';
		unset($_SESSION['e_addRadio_cannot_find_user']);
	}
	if(isset($_SESSION['e_addRadio_radio_url_or_name_is_empty'])){
		echo '<div class="error" id="emptyFieldsOnAddRadio">'.$_SESSION['e_addRadio_radio_url_or_name_is_empty'].'</div>';
		unset($_SESSION['e_addRadio_radio_url_or_name_is_empty']);
	}

	echo '</div>';
	unset($_SESSION['e_add_radio']);
}
?>

<script src="js/cookies.js"></script>
<script src="js/translations.js"></script>
<script src="js/translationsRadio.js"></script>
<script src="js/radio.js"></script>
<script src="js/boxMessages.js"></script>
</body>
</html>