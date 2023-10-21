function toggleLanguage(changedLanguage){

	const drawForTodayTag = document.getElementById("drawForToday");	
	const addButton = document.getElementById("addButton");
	const hello = document.getElementById("hello");

	const addNextRadioStation = document.getElementById("addNextRadioStation");
	const stationName = document.getElementsByClassName("stationName");
	const stationUrl = document.getElementsByClassName("stationUrl");
	const refresh = document.getElementById("refresh");

	const addStation = document.getElementById('addStation');
	const logout = document.getElementById("logout");
	const radioListTag = document.getElementById("radioList");
	const closeModalButton = document.getElementById("closeModalButton");

	const useInDrawn = document.getElementsByClassName("useInDrawn");
	const updateRadioInMyList = document.getElementsByClassName("updateRadioInMyList");
	const deleteRadioFromMyList = document.getElementsByClassName("deleteRadioFromMyList");
	const doNotUseInDrawn = document.getElementsByClassName("doNotUseInDrawn");

	const editRadioStation = document.getElementById("editRadioStation");
	const editStation = document.getElementById("editStation");
	const successMsg = document.getElementById("successMsg");
	const errorMsg = document.getElementById("errorMsg");

	const radioUpdated = document.getElementById("radioUpdated");
	const radioIdOrTokenWereRemoved = document.getElementById("radioIdOrTokenWereRemoved");
	const radioIsNotExists = document.getElementById("radioIsNotExists");
	const theSameValues = document.getElementById("theSameValues");

	const deleteRadioConfirmation = document.getElementById("deleteRadioConfirmation");
	const moveBack = document.getElementById("moveBack");
	const areYouSureThatYouWantDelete = document.getElementById("areYouSureThatYouWantDelete");
	const radioCorrectlyAdded = document.getElementById("radioCorrectlyAdded");

	const emptyFieldsOnAddRadio = document.getElementById("emptyFieldsOnAddRadio");
	const radioCorrectlyDeleted = document.getElementById("radioCorrectlyDeleted");
	const radioAlreadyExists = document.getElementById("radioAlreadyExists");

	const toManyDrawsForStandardAccount = document.getElementById("toManyDrawsForStandardAccount");
	const theLastDrawnRadio = document.getElementById("theLastDrawnRadio");
	const qtyOfTodayDrawn = document.getElementById("qtyOfTodayDrawn");
	const radioNameForStatisticTable = document.getElementsByClassName("radioNameForStatisticTable");

	const qtyOfDrawnsForRadio = document.getElementsByClassName("qtyOfDrawnsForRadio");
	const welcome = document.getElementById("welcome");
	const userStatsToday = document.getElementById("userStatsToday");
	const allUsersStats = document.getElementById("allUsersStats");

	const userStats = document.getElementById("userStats");
	const drawnRadioListIsEmpty = document.getElementById("drawnRadioListIsEmpty");

	selectedLanguage = setLanguageCookies(changedLanguage);
	radioListTag.innerHTML = selectedLanguage.radioList;

	
	addButton.innerHTML = selectedLanguage.add;
	let formVisibility = false;
	if(formVisibility){
		addButton.innerHTML = selectedLanguage.hide;
	}
	
	addNextRadioStation.innerHTML = selectedLanguage.addNextRadioStation;
	addStation.innerHTML = selectedLanguage.add;
	areYouSureThatYouWantDelete.innerHTML = selectedLanguage.areYouSureThatYouWantDelete;
	moveBack.innerHTML = selectedLanguage.back;
	deleteRadioConfirmation.innerHTML = selectedLanguage.delete;

	refresh.innerHTML = selectedLanguage.refresh;
	hello.innerHTML = selectedLanguage.hello;
	logout.innerHTML = selectedLanguage.logout;
	closeModalButton.title = selectedLanguage.closeModal;

	editRadioStation.innerHTML = selectedLanguage.editRadioStation;
	editStation.innerText = selectedLanguage.edit;

	if(useInDrawn != null){
		for(let i = 0;i<useInDrawn.length;i++){
			useInDrawn[i].title = selectedLanguage.useInDrawn
		}
		
	}
	if(doNotUseInDrawn != null){
		for(let i = 0;i<doNotUseInDrawn.length;i++){
			doNotUseInDrawn[i].title = selectedLanguage.doNotUseInDrawn
		}
	}

	if(updateRadioInMyList != null){
		for(let i = 0;i<updateRadioInMyList.length;i++){
			updateRadioInMyList[i].title = selectedLanguage.updateRadioInMyList
		}
		
	}

if(deleteRadioFromMyList != null){
		for(let i = 0;i<deleteRadioFromMyList.length;i++){
			deleteRadioFromMyList[i].title = selectedLanguage.deleteRadioFromMyList
			
		}
		
	}

if(stationName != null){
	for(let i = 0;i<stationName.length;i++){
		stationName[i].innerHTML = selectedLanguage.stationName	
	}
}

if(stationUrl != null){
	for(let i = 0;i<stationUrl.length;i++){
		stationUrl[i].innerHTML = selectedLanguage.stationUrl
	}
}

	if(successMsg != null){
		successMsg.innerHTML =  selectedLanguage.success;
	}
	if(errorMsg != null){
		errorMsg.innerText = selectedLanguage.error;
	}


	if(radioUpdated != null){
		radioUpdated.innerHTML =  selectedLanguage.radioUpdated;
	}
	if(radioIdOrTokenWereRemoved != null){
		radioIdOrTokenWereRemoved.innerHTML = selectedLanguage.radioIdOrTokenWereRemoved;
	}

	if(radioIsNotExists != null){
		radioIsNotExists.innerHTML =  selectedLanguage.radioIsNotExists;
	}
	if(theSameValues != null){
		theSameValues.innerHTML = selectedLanguage.theSameValues;
	}
	if(radioCorrectlyAdded != null){
		radioCorrectlyAdded.innerHTML = selectedLanguage.radioCorrectlyAdded;
	} 

	if(successMsg != null){
        successMsg.innerHTML =  selectedLanguage.success;
    }
    if(errorMsg != null){
        errorMsg.innerText = selectedLanguage.error;
    }
	if(emptyFieldsOnAddRadio != null){
		emptyFieldsOnAddRadio.innerHTML = selectedLanguage.radioNameOrUrlIsEmpty;
	}
	if(radioCorrectlyDeleted != null){
		radioCorrectlyDeleted.innerHTML = selectedLanguage.radioCorrectlyDeleted;
	}
	if(radioAlreadyExists != null){
		radioAlreadyExists.innerHTML = selectedLanguage.radioAlreadyExists + ". " + selectedLanguage.cannotAddRadioWithTheSameValues;
	}
	if(toManyDrawsForStandardAccount != null){
		toManyDrawsForStandardAccount.innerHTML = selectedLanguage.youHaveExceededTheAllowedAmountOfDrawnForDay + " " + selectedLanguage.forAccountStandard + ". " + selectedLanguage.forNextDrawnExtendYourAccountToPremium
	}
	if(theLastDrawnRadio != null){
		theLastDrawnRadio.innerHTML = selectedLanguage.theLastDrawnRadio;
	}
	if(drawForTodayTag != null){
		drawForTodayTag.innerHTML = selectedLanguage.drawForToday;
	}
	
	if(qtyOfTodayDrawn != null){
		qtyOfTodayDrawn.innerHTML = selectedLanguage.qtyOfTodayDrawn;
	}

	if(radioNameForStatisticTable != null){
		for(let i = 0;i<radioNameForStatisticTable.length;i++){
			radioNameForStatisticTable[i].innerHTML = selectedLanguage.name2;
		}
	}

	if(qtyOfDrawnsForRadio != null){
		for(let i = 0;i<qtyOfDrawnsForRadio.length;i++){
			qtyOfDrawnsForRadio[i].innerHTML = selectedLanguage.quantity;
		}
	}

	if(welcome != null){
		welcome.innerHTML = selectedLanguage.welcome;
	}

	if(allUsersStats != null){
		allUsersStats.innerHTML = selectedLanguage.allUsersStats;
	}

	if(userStatsToday != null){
		userStatsToday.innerHTML = selectedLanguage.userStatsToday;
	}

	if(userStats != null){
		userStats.innerHTML = selectedLanguage.userStats;
	}

	if(drawnRadioListIsEmpty != null){
		drawnRadioListIsEmpty.innerHTML = selectedLanguage.drawnRadioListIsEmpty;
	}


}
