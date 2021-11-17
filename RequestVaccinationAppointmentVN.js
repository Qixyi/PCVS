function checkButtonVaccine(){
  vaccineRadio = document.getElementsByName("radioBtnVaccine");
  flag = false;
  vaccineRadio.forEach(element => { 
    if(element.checked){
      flag = true;
      
    }
    
  });
  if (!flag){
  setVisible(document.getElementById('invalid-vaccine'));
    return false;
  } else {
   setInVisible(document.getElementById('invalid-vaccine'));
    return true;
  }
}

// Request Vaccination Appointment submit button events
var requestBtn = document.getElementById("requestBtn");
requestBtn.addEventListener("click", function (event) {

    var statusArray = [];
    statusArray.push(checkButtonVaccine());

    if (statusArray.includes(false)) {
      event.preventDefault();
      event.stopPropagation();
    }
}, false);

  function setVisible(element){
    if(element.classList.contains("invisible")){
      element.classList.remove("invisible");
    }
  }

  function setInVisible(element){
    if(!element.classList.contains("invisible")){
      element.classList.add("invisible");
    }
  }