// Check the Username 
function checkUserName() {
  var userName = document.getElementById("userName");
  var userNameValue = userName.value.trim();

  if(!userNameValue === ''){
    addIsValid(userName);
    return true
  }else{
    addIsInvalid(userName)
    return false;
  }
}

// Check the Password format is valid
function checkPassword() {
  var password = document.getElementById("password");
  var passwordValue = password.value.trim();
  var regex =  /^[A-Za-z]\w{7,14}$/;

  if(regex.test(password)){
    addIsValid(passwordValue);
    return true;
  }else{
    addIsInvalid(password);
    return false;
  }
}

// Sign Up button events
var loginBtn = document.getElementById("loginBtn");
loginBtn.addEventListener("click", function (event) {
  var form = document.querySelector('.needs-validation');
  
  var statusArray = [];
  statusArray.push(checkUserName());
  statusArray.push(checkPassword());
 
  if (statusArray.includes(false)) {
    event.preventDefault();
    event.stopPropagation();
  }
}, false);

// Add valid class & removes any invalid class
function addIsValid(element){
  if(!element.classList.contains("is-valid")){
    element.classList.add("is-valid");
  }

  if(element.classList.contains("is-invalid")){
    element.classList.remove("is-invalid");
  }
}

// Add invalid class & removes any valid class
function addIsInvalid(element){
  if(!element.classList.contains("is-invalid")){
    element.classList.add("is-invalid");
  }

  if(element.classList.contains("is-valid")){
    element.classList.remove("is-valid");
  }
}

 // To redirect to the next page
document.getElementById("loginBtn").onclick = function () {
  location.href = "#"; 
}