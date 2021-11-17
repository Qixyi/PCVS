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

function showConfirmModal(button){
    var vaccinationID = button.id;

    $.ajax({
        url:"confirm.php",
        method: "GET",
        data: {"vaccinationID": vaccinationID},
        success: function(response) {
            // Parse JSON string to Javascript object
            var vax = JSON.parse(response);
            // Displaying text in proper fields
            $("#confirmedModalFullName").text()
        }


    })
}

const allConfirmedBtn = document.getElementsByName("statusConfirmed");

allConfirmedBtn.forEach(btn => {
    btn.addEventListener("click", () => {
        window.location.href = "AdministerAppt.php?vaccinationID=" + btn.value;
    })
})

const allPendingBtn = document.getElementsByName("statusPending");

allPendingBtn.forEach(btn => {
    btn.addEventListener("click", () => {
        window.location.href = "ConfirmVaccinationAppointment.php?vaccinationID=" + btn.value;
    })
})