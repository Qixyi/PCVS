// Request Vaccination Appointment submit button events
var confirmBtn = document.getElementById("requestBtn");
requestBtn.addEventListener("click", function (event) {

    var statusArray = [];
    statusArray.push(checkAppointmentDate());
    
    if (statusArray.includes(false)) {
      event.preventDefault();
      event.stopPropagation();
    }
}, false);

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
    
tomorrowStr = yyyy +'-'+ mm +'-'+ dd;
document.getElementById("appointmentDate").setAttribute("min", tomorrowStr);


/* Checks if expiry date is:
1. valid
2. greater than/equal to tomorrow's date */

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

// Adds valid class & removes any invalid class
function addIsValid(element){
    if(!element.classList.contains("is-valid")){
      element.classList.add("is-valid");
    }
  
    if(element.classList.contains("is-invalid")){
      element.classList.remove("is-invalid");
    }
  }
  
  // Adds invalid class & removes any valid class
  function addIsInvalid(element){
    if(!element.classList.contains("is-invalid")){
      element.classList.add("is-invalid");
    }
  
    if(element.classList.contains("is-valid")){
      element.classList.remove("is-valid");
    }
  }
  