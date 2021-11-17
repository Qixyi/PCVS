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