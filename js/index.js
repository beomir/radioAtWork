const loginFlag = document.getElementById("changeFormLogin");
const registryFlag = document.getElementById("changeFormRegistration");
const loginForm = document.getElementById("loginForm");
const registrationForm = document.getElementById("registrationForm");
const registrationError = document.getElementById("registrationError");
const errorBox = document.getElementById("errorBox");
const correctBox = document.getElementById("correctBox");

const errorMsgState = document.getElementById("errorMsgState");
const correctMsgState = document.getElementById("correctMsgState");
const radioVideo = document.getElementById("radioVideo");
const loginErrorState = document.getElementById("loginErrorState");

registryFlag.innerHTML = selectedLanguage.login2;
loginFlag.innerHTML = selectedLanguage.registration;


loginFlag.addEventListener("click",function(){
	loginForm.classList.add("hideToLeftSide");
	setTimeout(function() {
		loginForm.classList.add("doNotDisplay");	
		registrationForm.classList.remove("doNotDisplay");
	  }, 500);
	  setTimeout(function() {
		registrationForm.classList.remove("hideToLeftSide");
	}, 600);
});

registryFlag.addEventListener("click",function(){
	registrationForm.classList.add("hideToLeftSide");
	
	setTimeout(function() {
		registrationForm.classList.add("doNotDisplay");
		loginForm.classList.remove("doNotDisplay");
	}, 500);
	setTimeout(function() {
		loginForm.classList.remove("hideToLeftSide");
	}, 600);
});

let errorBoxStateValue = false;
let correctBoxStateValue = false;

if(loginErrorState != null){
	
	if(loginErrorState.textContent == 1){
		setTimeout(function() {
			letsGo();
		}, 500);
		
	}

}

if(registrationError != null){
	//if erorr on registration then come back to registration form
	if(registrationError.textContent == 1){
		loginForm.classList.add("hideToLeftSide");
		loginForm.classList.add("doNotDisplay");	
	
		registrationForm.classList.remove("hideToLeftSide");
		registrationForm.classList.remove("doNotDisplay");
		letsGo();
		//if correctly created account
	} else if(registrationError.textContent == 0){

		correctBox.classList.remove("doNotDisplay");
		errorBox.classList.add("doNotDisplay");
		correctMsgState.addEventListener("click",function(){
			correctBoxStateValue = !correctBoxStateValue;
			if(correctBoxStateValue){
				correctBox.classList.remove("rotate");
				correctMsgState.classList.add("rotate180deg");
				correctMsgState.classList.remove("rotate180degBack");
				setTimeout(function() {
					correctBox.classList.add("hideToLeftSideIn90Percent");
					
				}, 100);
				
			} else {
				correctBox.classList.remove("hideToLeftSideIn90Percent");
				correctMsgState.classList.remove("rotate180deg");
				correctMsgState.classList.add("rotate180degBack");
				setTimeout(function() {
					correctBox.classList.add("rotate");
				}, 1000);
				
			}
			})
		
	}
	
} else{
	errorBox.classList.add("doNotDisplay");
}

function letsGo(){
	errorBox.classList.remove("doNotDisplay");
	correctBox.classList.add("doNotDisplay");

	errorMsgState.addEventListener("click",function(){
		errorBoxStateValue = !errorBoxStateValue;
		if(errorBoxStateValue){
			errorBox.classList.remove("rotate");
			errorMsgState.classList.add("rotate180deg");
			errorMsgState.classList.remove("rotate180degBack");
			setTimeout(function() {
				errorBox.classList.add("hideToLeftSideIn90Percent");
				
			}, 100);
			
		} else {
			errorBox.classList.remove("hideToLeftSideIn90Percent");
			errorMsgState.classList.remove("rotate180deg");
			errorMsgState.classList.add("rotate180degBack");
			setTimeout(function() {
				errorBox.classList.add("rotate");
			}, 1000);
			
		}
		
	})
}




