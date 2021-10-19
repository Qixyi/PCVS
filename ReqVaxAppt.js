// Confirm submit button events
var confirmBtn = document.getElementById("confirmBtn");
confirmBtn.addEventListener("click", function (event) {
    var form = document.querySelector('.needs-validation');

    var statusArray = [];
    statusArray.push(checkVaccineManufacturer());
    statusArray.push(checkCentreNameBatchNo());
    statusArray.push(checkCentreAddress());
    statusArray.push(checkAppointmentDate());

    if (statusArray.includes(false)) {
      event.preventDefault();
      event.stopPropagation();
    }
}, false);


var testCheckbox = document.getElementById("vaccineNameManufacturer");  
if (!testCheckbox.checked) {
  alert("You have not check!");
}
else {
  alert("Success Message!!");
}  

var testCheckbox = document.getElementById("centreNameAddress");  
if (!testCheckbox.checked) {
  alert("You have not check!");
}
else {
  alert("Success Message!!");
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


  
  
  
    