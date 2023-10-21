toggleLanguage(selectedLanguage);

////Add next Radio Start
const addStation = document.getElementById('addStation');
const addRadioForm = document.getElementById("addRadioForm");
const closeModalButton = document.getElementById("closeModalButton");
const stationId = document.getElementsByClassName("stationId");

const editRadioForm = document.getElementById("editRadioForm");
const closeModalButtonEditForm = document.getElementById("closeModalButtonEditForm");
const correctBox = document.getElementById("correctBox");
const errorBox = document.getElementById("errorBox");

let formEditVisibility= false;
let formVisibility = false;
let addRadioFormVisibility = getCookie("add_radio_form_visible");
let checkIfUserWantEditAnotherRadio = 1;

const deleteRadio = document.getElementsByClassName("deleteRadio");

//delete radio

for(let i = 0; i<deleteRadio.length;i++){
	deleteRadio[i].addEventListener("click",function(event){
		let targetElementDelete = event.target;
		showOrHideQuestionBox(targetElementDelete,true);
	})
}


//Edit Modal
function editRadioFormVisibilityOnSide(){
	formEditVisibility = true;
	editRadioForm.classList.remove("doNotDisplay");
	editRadioForm.classList.remove("hideToLeftSide");
}

for(let i = 0; i < stationId.length; i++){
	stationId[i].addEventListener("click",function(event){
		let targetElement = event.target;
		// event.srcElement 
		closeModalButtonEditForm.title = selectedLanguage.closeModal;
		if(formVisibility){
			changeVisibilityOfModal();
			displayOrHideEditRadioForm(targetElement);
		} else if(checkIfUserWantEditAnotherRadio == 1){
			displayOrHideEditRadioForm(targetElement);
		} else {
			setValuesInEditModal(targetElement);
		}
	})
}

function setValuesInEditModal(targetElement){
	const catchedTargetElement = document.getElementById(targetElement.id).parentElement.previousSibling.previousSibling.firstChild;
	const editStationNameInput = document.getElementById("editStationNameInput");
	const stationUrlInputEdit = document.getElementById("stationUrlInputEdit");

	const radioId = document.getElementById("radioId");
	editStationNameInput.value = catchedTargetElement.text
	stationUrlInputEdit.value = catchedTargetElement.href
	radioId.value = targetElement.id.split('Id')[1];
	
}

function displayOrHideEditRadioForm(targetElement){
	checkIfUserWantEditAnotherRadio = 2;
	formEditVisibility = !formEditVisibility;
	if(formEditVisibility){
		//fillValues to form
		setValuesInEditModal(targetElement);

		setTimeout(function() {
			editRadioForm.classList.remove("doNotDisplay");
		  }, 600);
		  setTimeout(function() {
			editRadioForm.classList.remove("hideToLeftSide");
		}, 700);
	} else {
	editStationNameInput.value = "";
	stationUrlInputEdit.value = "";

	editRadioForm.classList.add("hideToLeftSide");
	setTimeout(function() {
		editRadioForm.classList.add("doNotDisplay");
	  }, 600);
	}
}

closeModalButtonEditForm.addEventListener("click",function(){
	displayOrHideEditRadioForm();
	checkIfUserWantEditAnotherRadio = 1;
});

////Add Modal
addButton.addEventListener("click",function(){
	changeVisibilityOfModal();
	checkIfUserWantEditAnotherRadio = 0;
})

closeModalButton.addEventListener("click",function(){
	changeVisibilityOfModal();
	checkIfUserWantEditAnotherRadio = 1;
});

function addRadioFormVisibilityOnSide(){
	formVisibility = true;
	addRadioForm.classList.remove("doNotDisplay");
	addRadioForm.classList.remove("hideToLeftSide");
	addButton.innerHTML = selectedLanguage.hide;
	closeModalButton.title = selectedLanguage.closeModal;
}


if(addRadioFormVisibility == "onSide"){
	addRadioFormVisibilityOnSide();
} 


function changeVisibilityOfModal(){
	formVisibility = !formVisibility
	if(formEditVisibility == true){
		displayOrHideEditRadioForm("");
	}
	if(formVisibility){
		addButton.innerHTML = selectedLanguage.hide
		setTimeout(function() {
			addRadioForm.classList.remove("doNotDisplay");
		  }, 600);
		  setTimeout(function() {
			addRadioForm.classList.remove("hideToLeftSide");
		}, 700);
		setAddStationFormState("onSide")
		
	} else {
	addButton.innerHTML = selectedLanguage.add
	addRadioForm.classList.add("hideToLeftSide");
	setTimeout(function() {
		addRadioForm.classList.add("doNotDisplay");
	  }, 600);
	  
	setAddStationFormState("offSide")
	}
}


