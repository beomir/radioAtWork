
const successMsg = document.getElementById("successMsg");
const errorMsg = document.getElementById("errorMsg");
    
const questionBox = document.getElementById("questionBox");
const errorMsgState = document.getElementById("errorMsgState");
const correctMsgState = document.getElementById("correctMsgState");
const questionMsgState = document.getElementById("questionMsgState");

const questionMsg = document.getElementById("questionMsg");
const firstContainer = document.getElementById("first-container");


let errorBoxStateValue = false;
let correctBoxStateValue = false;
let questionBoxStateValue = false;
//////
deleteRadioConfirmation.addEventListener('click',function(){
    if(deleteRadioConfirmation.name.includes("token") && deleteRadioConfirmation.name.includes("id=") && deleteRadioConfirmation.name.includes("delete.php")){
        window.location.href = deleteRadioConfirmation.name;
    }
})

moveBack.addEventListener('click',function(){
    showOrHideQuestionBox( "cleanValues",false);
})
//////
//qestionBox
function showOrHideQuestionBox(target,value){
    let valueForOtherMsges; 
    if(target == "cleanValues"){
        valueForOtherMsges = false;
        firstContainer.classList.remove("block-pointer-events");
    } else {
        valueForOtherMsges = true;
        deleteRadioConfirmation.name = "delete.php?" + target.name;
        const radio = document.getElementById("radio");
        radio.innerHTML = target.parentElement.parentElement.previousSibling.firstChild.text;
        firstContainer.classList.add("block-pointer-events");
    }

    correctBoxStateValue = value;
    if(errorMsgState !=null){
        hideOrShowErrorMsg(valueForOtherMsges);
    }
    if(correctMsgState != null){
        hideOrShowCorrectMsg(valueForOtherMsges);
    }

    if(correctBoxStateValue){
        questionBox.classList.remove("is-hidden");
        questionBox.classList.remove("doNotDisplay");
        questionMsgState.classList.add("rotate270degBack");
        setTimeout(function() {
        questionBox.classList.remove("hideAboveTheTop");
    }, 100);
    } else{
        questionBox.classList.add("hideAboveTheTop");
        setTimeout(function() {
            questionBox.classList.add("doNotDisplay");
            questionBox.classList.add("is-hidden");
        }, 1000);
    }
}

questionMsgState.addEventListener("click",function(){
    showOrHideQuestionBox("cleanValues",false);
})


///errorMsg
function hideOrShowErrorMsg(value){
 
    errorBoxStateValue = value;
    
    if(errorBoxStateValue){
        errorBox.classList.remove("rotate");
        errorMsgState.classList.add("rotate270deg");
        errorMsgState.classList.remove("rotate270degBack");
        errorMsgState.classList.add("rightDownCorner");
        setTimeout(function() {
            errorBox.classList.add("hideToUpSide");
            
        }, 100);
        
    } else {
        errorBox.classList.remove("hideToUpSide");
        errorMsgState.classList.remove("rotate270deg");
        errorMsgState.classList.add("rotate270degBack");
        errorMsgState.classList.remove("rightDownCorner");
        
        setTimeout(function() {
            errorBox.classList.add("rotate");
        }, 1000);
    } 
}

if(errorMsgState !=null){
    errorMsgState.classList.add("rotate270degBack");

    errorMsgState.addEventListener("click",function(){
        errorBoxStateValue = !errorBoxStateValue
        hideOrShowErrorMsg(errorBoxStateValue);
    })
}

///correctMsg
function hideOrShowCorrectMsg(value){

    correctBoxStateValue = value;

    if(correctBoxStateValue){
        correctBox.classList.remove("rotate");
        correctMsgState.classList.add("rotate270deg");
        correctMsgState.classList.remove("rotate270degBack");
        correctMsgState.classList.add("rightDownCorner");
        setTimeout(function() {
            correctBox.classList.add("hideToUpSide");
        }, 100);
        
    } else {
        correctBox.classList.remove("hideToUpSide");
        correctMsgState.classList.remove("rotate270deg");
        correctMsgState.classList.add("rotate270degBack");
        correctMsgState.classList.remove("rightDownCorner");
        
        setTimeout(function() {
            correctBox.classList.add("rotate");
        }, 1000);
        
    } 
}

if(correctMsgState != null){
    correctMsgState.classList.add("rotate270degBack");

    correctMsgState.addEventListener("click",function(){
        correctBoxStateValue = !correctBoxStateValue
        hideOrShowCorrectMsg(correctBoxStateValue);

    })
}

    
