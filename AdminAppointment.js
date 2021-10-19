acceptRejectBtn = document.getElementById("acceptRejectApointmentSaveBtn");

acceptRejectBtn.addEventListener("click", function(event){
    var acceptRadio = document.getElementById("acceptRadio").checked;
    var rejectRadio = document.getElementById("rejectRadio").checked;

    if(!acceptRadio && !rejectRadio) { 
        alert("No changes made!");
        event.preventDefault();
        event.stopPropagation();
    }
    
});

var administeredBtn = document.getElementById("administeredVaccinationSaveBtn");

administeredBtn.addEventListener("click", function(event) {
    var administeredCheckbox = document.getElementById("administeredCheckbox").checked;

    if(!administeredCheckbox) { 
        alert("No changes made!");
        event.preventDefault();
        event.stopPropagation();
    }
})