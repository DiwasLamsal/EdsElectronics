/*
-Diwas Lamsal
-18406547
-CSY2028 WEB PROGRAMMING TERM I ASSIGNMENT
-UNIVERSITY OF NORTHAMPTON

-script.js file for almost javascript content of the system
*/
window.onload = function(){
// Do something when the window loads


}

//-------------------------------------------------------------------------------------//

// Validating password with JavaScript
function checkPassword(){
  var pass = document.getElementById('password');
  var passChecker = document.getElementById('passtest');
  var submit = document.getElementById('submission');
  var confirmPass = document.getElementById('confirmpassword');
  var confirmPassChecker = document.getElementById('confirmpasstest');

  submit.disabled = true;
  if(pass.value != confirmPass.value){
    confirmPassChecker.style.color = "red";
    confirmPassChecker.innerHTML = "Passwords do not match.";
    submit.disabled = true;
  }

  if(pass.value.length<9){
    passtest.style.color = "red";
    passtest.innerHTML = "Password too short.";
  }
  else if(pass.value.length > 8 && pass.value.length < 17){
    passtest.style.color = "green";
    passtest.innerHTML = "Valid password!";
  }
  else if(pass.value.length>16){
    passtest.style.color = "red";
    passtest.innerHTML = "Password too long.";
  }

  if(pass.value == confirmPass.value){
    confirmPassChecker.style.color = "green";
    confirmPassChecker.innerHTML = "Passwords Match!";
  }

  if(confirmPass.value == " " || confirmPass.value == "" || pass.value ==""){
    confirmPassChecker.innerHTML = "<br>";
    submit.disabled = true;
  }

  if(passtest.style.color == "green" && confirmPassChecker.style.color == "green")
    submit.disabled = false;
}

//-------------------------------------------------------------------------------------//

//Validating image upload with JavaScript
function checkImage() {


  var submit = document.getElementById('submission');
  var imageFile = document.getElementById('imageFile');
  var imageTest = document.getElementById('imageTest');
  var ext = imageFile.value.split('.').pop().toLowerCase();
  var extensions = ["jpg", "jpeg", "png", "svg"];
  var isValid = extensions.indexOf(ext);
  submit.disabled = true;


  if(isValid!=-1 && (imageFile.files[0].size)/1024<1000){
    submit.disabled = false;
    imageTest.style.color="green";
    imageTest.innerHTML = "Valid Image";
  }
  // If the image file size exceeds more than 1MB
  else if((imageFile.files[0].size)/1024>1000){
    console.log((imageFile.files[0].size)/1024>1000);
    submit.disabled = true;
    imageTest.style.color="red";
    imageTest.innerHTML = "File size is too big. Please enter an image upto 1MB";
  }
  else{
    submit.disabled = true;
    imageTest.style.color="red";
    imageTest.innerHTML = "The file type is not valid. Please select an image of type jpg, jpeg, png or svg.";
  }


}


//Search Bar animation
function searchClicked(){
  var search = document.getElementById('searchInput');
  var searchButton = document.getElementById('searchButton');
  search.style.width = "200px";
  searchButton.style.opacity = "1";
  searchButton.style.cursor = "pointer";
  searchButton.style.display="block";
}

function searchLeft(){
  setTimeout(removeSearch, 1000);
}

function removeSearch(){
  var search = document.getElementById('searchInput');
  var searchButton = document.getElementById('searchButton');
  search.style.width = "0px";
  searchButton.style.opacity = "0";
  searchButton.style.cursor = "normal";
  searchButton.style.display="none";
}


// Get initials to display on reviews
function getInitials(name){
  var initials = name[0] + name[name.lastIndexOf(" ") + 1];
  return initials;
}
