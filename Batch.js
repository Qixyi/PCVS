function checkSelectCentre(){
    var selectCentre = document.getElementById("centreName");
    if(selectCentre.value != ""){
      addIsValid(selectCentre);
      return true;
      }
      addIsInvalid(selectCentre);
      return false;
    }