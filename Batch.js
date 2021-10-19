// Confirm submit button events
var confirmBtn = document.getElementById("confirmBtn");
confirmBtn.addEventListener("click", function (event) {
    var form = document.querySelector('.needs-validation');

    var statusArray = [];
    statusArray.push(checkVaccineName());
    statusArray.push(checkHealthcareCentre());
    statusArray.push(checkAppointmentDate());

    if (statusArray.includes(false)) {
      event.preventDefault();
      event.stopPropagation();
    }
}, false);

// Check if vaccine name is selected
function checkVaccineName(){
  var vaccineName= document.getElementById("vaccineName");
  if(vaccineName.value != ""){
    addIsValid(vaccineName);
    return true;
  }
  addIsInvalid(vaccineName);
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

// Date Picker set min limit to tomorrow
var today = new Date();
var tomorrow = new Date();
tomorrow.setDate(today.getDate() + 1);

var dd = tomorrow.getDate();
var mm = tomorrow.getMonth() + 1;
var yyyy = tomorrow.getFullYear();

if (dd < 10) {
   dd = '0' + dd;
}

if (mm < 10) {
   mm = '0' + mm;
} 

function checkAppointmentDate(){
    var appointmentDate = document.getElementById("appointmentDate");
    var validDate = Date.parse(appointmentDate.value);
  
    // must set, else, invalid comparison due to current time
    tomorrow.setHours(0,0,0,0);
  
    if(isNaN(validDate)){
      addIsInvalid(appointmentDate);
      return false;
    }
    else {
      if(validDate >= tomorrow){
        addIsValid(appointmentDate);
        return true;
      } else {
        addIsInvalid(appointmentDate);
        return false;
      }
    }
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