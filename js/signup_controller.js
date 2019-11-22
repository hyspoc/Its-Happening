        /* 
 * All the sign up related actions will go in this file
 * Author : Roja Raman
 */

function openForm() {
    document.getElementsByClassName("main-agileits")[0].style.WebkitFilter = 'blur(4px)';
    document.getElementsByClassName("main-agileits")[0].style.filter= 'blur(4px)';
    document.getElementById("myForm").style.display = "block";
}

function closeForm() {
    document.getElementsByClassName("main-agileits")[0].style.WebkitFilter = 'blur(0px)';
    document.getElementsByClassName("main-agileits")[0].style.filter= 'blur(0px)';
    document.getElementById("myForm").style.display = "none";
}
function onSignIn(googleUser) {
    closeForm();
   
    var profile = googleUser.getBasicProfile();
    var id = profile.getId();
    var name = profile.getName();
    var mail = profile.getEmail();
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
    
    window.location.href = "register.php?id="+ id+"&name="+name+"&mail="+mail;
   
   
    
}
function forgotPwdPopup() {
    document.getElementsByClassName("main-agileits")[0].style.WebkitFilter = 'blur(4px)';
    document.getElementsByClassName("main-agileits")[0].style.filter= 'blur(4px)';
    document.getElementById("forgotPwd").style.display = "block";
}
function forgotPwdPopupClose() {
    document.getElementsByClassName("main-agileits")[0].style.WebkitFilter = 'blur(0px)';
    document.getElementsByClassName("main-agileits")[0].style.filter= 'blur(0px)';
    document.getElementById("forgotPwd").style.display = "none";
}

