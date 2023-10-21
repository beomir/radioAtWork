function toggleLanguage(changedLanguage){

	const logPanel = document.getElementById("logPanel");
    const login = document.getElementById("login");
	const name = document.getElementsByClassName("name");
	const password = document.getElementsByClassName("password");

	const loginError = document.getElementById("loginError");
	const registrationPanel = document.getElementById("registrationPanel");
	const registry = document.getElementById("registry");
	const repeatPassword = document.getElementById("passwordRegistrationRepeat");

	const defaultlanguage = document.getElementById("defaultlanguage");
	const errorMsg = document.getElementById("errorMsg");
	const nickNameError = document.getElementById("nickNameError"); 
	const nickNameErrorSC = document.getElementById("nickNameErrorSC"); 

	const emailError = document.getElementById("emailError"); 
	const passwordError = document.getElementById("passwordError"); 
	const passwordNotTheSame = document.getElementById("passwordNotTheSame");
	const nbrOfUsers = document.getElementById("nbrOfUsers");

	const langNotExists = document.getElementById("langNotExists");
	const englishLang = document.getElementById("englishLang");
	const polishLang = document.getElementById("polishLang");
	const germanLang = document.getElementById("germanLang");

	const email = document.getElementById("email");
	const accountCreated = document.getElementById("accountCreated");
	const successMsg = document.getElementById("successMsg");
	const accountSpam = document.getElementById("accountSpam");

	selectedLanguage = setLanguageCookies(changedLanguage);
	
	logPanel.innerHTML = selectedLanguage.logPanel;
	login.innerHTML = selectedLanguage.login;
	registrationPanel.innerHTML = selectedLanguage.registrationPanel;
	registry.innerHTML = selectedLanguage.registry;
	repeatPassword.innerHTML = selectedLanguage.repeatPassword;
	defaultlanguage.innerHTML = selectedLanguage.defaultlanguage;
	email.innerHTML = selectedLanguage.email;
	
	
	englishLang.text = selectedLanguage.english;
	polishLang.text = selectedLanguage.polish;
	germanLang.text = selectedLanguage.german;



	for(let i = 0;i < password.length;i++){
		password[i].innerHTML = selectedLanguage.password;
	}

	for(let i = 0;i < name.length;i++){
		name[i].innerHTML = selectedLanguage.name;
	}
	
	registryFlag.innerHTML = selectedLanguage.login2;
	loginFlag.innerHTML = selectedLanguage.registration;

	if(loginError != null){
		loginError.innerHTML = selectedLanguage.loginError;
	}
	
	if(errorMsg != null){
		errorMsg.innerText = selectedLanguage.error;
	}

	if(nickNameError != null){
		nickNameError.innerText = selectedLanguage.toShortNickname;
	}

	if(nickNameErrorSC != null){
		nickNameErrorSC.innerText = selectedLanguage.specialCharactersOfNickname;
	}

	if(emailError != null){
		emailError.innerText = selectedLanguage.toShortNickname;
	}
	if(passwordError != null){
		passwordError.innerText = selectedLanguage.toShortPassword;
	}
	if(passwordNotTheSame != null){
		passwordNotTheSame.innerText = selectedLanguage.notTheSamePassword;
	}
	if(nbrOfUsers != null){
		nbrOfUsers.innerText = selectedLanguage.userAlreadyExists;
	}
	if(langNotExists != null){
		langNotExists.innerHTML =  selectedLanguage.langNotExists;
	}
	if(accountCreated != null){
		accountCreated.innerHTML =  selectedLanguage.accountCreated;
	}

	if(successMsg != null){
		successMsg.innerHTML =  selectedLanguage.success;
	}
	if(accountSpam != null){
		accountSpam.innerHTML = selectedLanguage.accountSpam;
	}
	
}