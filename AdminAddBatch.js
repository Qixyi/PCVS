// Add Batch submit button events
var confirmBtn = document.getElementById("confirmBtn");
confirmBtn.addEventListener("click", function (event) {
    var form = document.querySelector('.needs-validation');

    var statusArray = [];
    statusArray.push(checkBatchNo());
    statusArray.push(checkSelectedVaccine());
    statusArray.push(checkExpiryDate());
    statusArray.push(checkQtyAvailable());

    if (statusArray.includes(false)) {
      event.preventDefault();
      event.stopPropagation();
    }
}, false);


// Check if vaccine name is selected
function checkSelectedVaccine(){
  var selectedVaccine = document.getElementById("vaccineName");
  if(selectedVaccine.value != ""){
    addIsValid(selectedVaccine);
    return true;
  }
  addIsInvalid(selectedVaccine);
  return false;
}


// Check if batchNo is given in valid format
// e.g. B000001 ('B' character with 6 numbers)
function checkBatchNo(){
    var batchNo = document.getElementById("batchNo");
    var batchNoValue = batchNo.value.trim();
    var regex = /^B[0-9]{6}/;

    if(regex.test(batchNoValue)){
        addIsValid(batchNo);
        return true;
    } else{
        addIsInvalid(batchNo);
        return false;
    }
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
    
tomorrowStr = yyyy +'-'+ mm +'-'+ dd;
document.getElementById("expiryDate").setAttribute("min", tomorrowStr);


/* Checks if expiry date is:
1. valid
2. greater than/equal to tomorrow's date */

function checkExpiryDate(){
  var expiryDate = document.getElementById("expiryDate");
  var validDate = Date.parse(expiryDate.value);

  // must set, else, invalid comparison due to current time
  tomorrow.setHours(0,0,0,0);

  if(isNaN(validDate)){
    addIsInvalid(expiryDate);
    return false;
  }
  else {
    if(validDate >= tomorrow){
      addIsValid(expiryDate);
      return true;
    } else {
      addIsInvalid(expiryDate);
      return false;
    }
  }
}


/* Checks if quantity available is:
1. integer
2. greater than/equal to 1 */

function checkQtyAvailable(){
  var qtyAvailable = document.getElementById("qtyAvailable");
  var qtyAvailableValue = qtyAvailable.value;

  qtyAvailableValue = parseInt(qtyAvailableValue, 10);

  if(qtyAvailableValue >= 1){
    addIsValid(qtyAvailable);
    return true;
  }
  else {
    addIsInvalid(qtyAvailable);
  }
  return false;
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

