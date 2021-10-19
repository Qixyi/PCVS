// Confirm submit button events
var confirmBtn = document.getElementById("confirmBtn");
confirmBtn.addEventListener("click", function (event) {
    var form = document.querySelector('.needs-validation');

    var statusArray = [];
    statusArray.push(checkVaccineName());
    statusArray.push(checkCentreNameBatchNo());
    statusArray.push(checkHealthcareCentre());
   
    if (statusArray.includes(false)) {
      event.preventDefault();
      event.stopPropagation();
    }
}, false);

// Check if Vaccine name is selected
function checkVaccineName(){
  var vaccineName = document.getElementById("vaccineName");
  if(vaccineName.value != ""){
    addIsValid(vaccineName);
    return true;
  }
  addIsInvalid(vaccineName);
  return false;
}

// Check if healthcareCentre is selected
function checkCentreNameBatchNo(){
    var centreNameBatchNo = document.getElementById("centreNameBatchNo");
    if(centreNameBatchNo.value != ""){
      addIsValid(centreNameBatchNo);
      return true;
    }
    addIsInvalid(centreNameBatchNo);
    return false;
  }

// Check if healthcareCentre is selected
function checkHealthcareCentre(){
  var healthcareCentre = document.getElementById("healthcareCentre");
  if(healthcareCentre.value != ""){
    addIsValid(healthcareCentre);
    return true;
  }
  addIsInvalid(healthcareCentre);
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


  
  
  
    