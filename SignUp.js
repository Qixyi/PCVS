//To remove Staff ID attribute and Select Centre
function patientClick() { 
    var ICPassportDiv = document.getElementById('ICPassportDiv').classList.toggle('invisible');
    if(ICPassportDiv.classList.contains('invisible')){
      ICPassportDiv.classList.remove('invisible'); 
  }else{
    ICPassportDiv.classList.add('invisible'); 
    }
  }
  
  //To remove ICPassport
  function adminClick() { 
    var staffIDDiv = document.getElementById('staffIDDiv');
    var selectCentre = document.getElementById('selectCentre').classList.toggle('invisible');
       if(staffIDDiv.classList.contains('invisible')){
         staffIDDiv.classList.remove('invisible'); 
    }else{
      staffIDDiv.classList.add('invisible'); 
    }
  }
  
  function checkButton(){
    if(document.getElementById('flexRadioDefaultAdmin').checked){
      document.getElementById("display").innerHTML   
      = document.getElementById("flexRadioDefaultAdmin").value
      = " Healthcare Administrator radio button is checked";     
    }
    else if(document.getElementById('flexRadioDefaultPatient').checked) {   
      document.getElementById("display").innerHTML   
          = document.getElementById("flexRadioDefaultPatient").value   
          ="Patient radio button is checked";     
  }  
  else {   
      document.getElementById("error").innerHTML  
          = "You have not selected any user";   
  }   
  }
  
  var createCentreBtn = document.getElementById("createBtn");
  createCentreBtn.addEventListener("click", function (event) {
   
  
    var statusArray =[];
    statusArray.push(checkCentreName());
    statusArray.push(checkAddress());
  
    if (statusArray.includes(false)) {
      event.preventDefault();
      event.stopPropagation();
    }
  }, false);
  
  // Sign Up button events
  var signUpBtn = document.getElementById("signUpBtn");
  signUpBtn.addEventListener("click", function (event) {
  
    var adminSelected = document.getElementById('flexRadioDefaultPatient').checked;
  
    var statusArray = [];
    statusArray.push(checkFullName());
    statusArray.push(checkUserName());
    statusArray.push(checkPassword());
    statusArray.push(checkEmail());
    if(adminSelected){
      statusArray.push(checkStaffID());
      statusArray.push(checkSelectCentre());
    }else{
      statusArray.push(checkICPassport());
    }
   
    if (statusArray.includes(false)) {
      event.preventDefault();
      event.stopPropagation();
    }
  }, false);
  
  // Check the Centre Name 
  function checkCentreName() {
    var centreName = document.getElementById("centreName");
    var centreNameValue = centreName.value.trim();
  
    if(!centreNameValue === ''){
      addIsValid(centreName);
      return true
    }else{
      addIsInvalid(centreName)
      return false;
    }
  }
  
  // Check the Address 
  function checkAddress() {
    var address = document.getElementById("address");
    var centreNameValue = address.value.trim();
  
    if(!addressValue === ''){
      addIsValid(address);
      return true
    }else{
      addIsInvalid(address)
      return false;
    }
  }
  
  // Check the Full Name
  function checkFullName() {
    var fullName = document.getElementById("fullName");
    var fullNameValue = fullName.value.trim();
  
    if(!fullNameValue === ''){
      addIsValid(fullName);
      return true
    }else{
      addIsInvalid(fullName)
      return false;
    }
  }
  
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
      addIsValid(password);
      return true;
    }else{
      addIsInvalid(password);
      return false;
    }
  }
  
  // Check the Email format is valid
  function checkEmail() {
    var email = document.getElementById("email");
    var emailValue = email.value.trim();
    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  
    if(regex.test(emailValue)){
      addIsValid(email);
      return true;
    }else{
      addIsInvalid(email);
      return false;
    }
  }
  
  // Check the Staff ID format is valid
  function checkStaffID() {
    var staffID = document.getElementById("staffID");
    var staffIDValue = staffID.value.trim();
    var regex = /^HA[0-9]{4}/;
  
    if(regex.test(staffIDValue)){
      addIsValid(staffID);
      return true;
    }else{
      addIsInvalid(staffID);
      return false;
    }
  }
  
  // Check the IC/Passport
  function checkICPassport() {
    var iCPassport = document.getElementById("icPassport");
    var iCPassportValue = iCPassport.value.trim();
  
    if(!iCPassportValue === ''){
      addIsValid(iCPassport);
      return true
    }else{
      addIsInvalid(iCPassport)
      return false;
    }
  }
  
  
  // Check if the Healthcare Administrator selects the Healthcare Centre
  function checkSelectCentre(){
  var selectCentre = document.getElementById("centreName");
  if(selectCentre.value != ""){
    addIsValid(selectCentre);
    return true;
    }
    addIsInvalid(selectCentre);
    return false;
  }
  
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
  document.getElementById("signUpBtn").onclick = function () {
    location.href = "#"; 
  }
  
  
  
    
  
  