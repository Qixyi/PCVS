function checkButtonHealthcareCentre(){
    if (!document.getElementById('radioBtnSMC').checked &&
    !document.getElementById('radioBtnKPJ').checked &&
    !document.getElementById('radioBtnSMC').checked ) {
      setVisible(document.getElementById('invalid-vaccine'));
      return false;
    } else {
     setInVisible(document.getElementById('invalid-vaccine'));
      return true;
    }
  }

  var requestBtn = document.getElementById("requestBtn");
requestBtn.addEventListener("click", function (event) {

    var statusArray = [];
    statusArray.push(checkButtonHealthcareCentre());

    alert(statusArray);
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