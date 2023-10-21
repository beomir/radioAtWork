function setLanguageCookies(changedLanguage){
	let cookieExpires = "";
	let date = new Date();
        date.setTime(date.getTime() + (3*24*60*60*1000));
        cookieExpires = "; expires=" + date.toUTCString();

	document.cookie = "selected_language="+changedLanguage.currentLang + cookieExpires;

	langInCookie = getCookie("selected_language");
	return translations[langInCookie];
}

function setAddStationFormState(cookieValue){
	let cookieExpires = "";
	let date = new Date();
        date.setTime(date.getTime() + (3*24*60*60*1000));
        cookieExpires = "; expires=" + date.toUTCString();

	document.cookie = "add_radio_form_visible=" + cookieValue + cookieExpires;
	
}