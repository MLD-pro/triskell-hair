document.addEventListener("DOMContentLoaded", function () {
    // Vérifie d'abord si la page contient le formulaire de rendez-vous
    if (!document.getElementById("appointement_date1")) {
        return; // si non, on arrête tout de suite, aucun code ne s’exécute
    }

    // Partie VALIDATION des dates + créneaux
    function validateChoice(dateInputId, momentBlockSelector, nextBlockId, validateBtnId) {
        const dateInput = document.getElementById(dateInputId);
        const momentInputs = document.querySelectorAll(momentBlockSelector + " input[type=checkbox]");
        const nextBlock = nextBlockId ? document.getElementById(nextBlockId) : null;
        const validateBtn = document.getElementById(validateBtnId);

        if (!dateInput || !validateBtn || momentInputs.length === 0) {
            return;
        }

        validateBtn.addEventListener("click", function () {
            const hasMoment = Array.from(momentInputs).some(input => input.checked);

            if (dateInput.value && hasMoment) {
                dateInput.style.border = "2px solid green";
                dateInput.style.backgroundColor = "#e6ffe6";

                momentInputs.forEach(input => {
                    if (input.checked) {
                        input.parentElement.style.color = "green";
                        input.style.accentColor = "green";
                    }
                });

                if (nextBlock) {
                    nextBlock.style.display = "block";
                }
            } else {
                alert("Merci de choisir une date et au moins un créneau.");
            }
        });
    }

    validateChoice("appointement_date1", "#date1-block", "date2-block", "validate-date1");
    validateChoice("appointement_date2", "#date2-block", "date3-block", "validate-date2");
    validateChoice("appointement_date3", "#date3-block", null, "validate-date3");

    // Partie SELECT2 pour le champ prestations souhaitées
    const serviceSelect = document.querySelector('#appointement_services');
    if (serviceSelect && typeof $ !== "undefined" && typeof $.fn.select2 !== "undefined") {
        $(serviceSelect).select2({
            placeholder: "Choisissez les prestations que vous souhaitez",
            allowClear: true,
            width: '100%',
        });
    }

    // Fermeture manuelle du message flash
    const flashMessages = document.querySelectorAll(".flash-popup");
    flashMessages.forEach(msg => {
        msg.style.position = "fixed";
        msg.style.top = "50%";
        msg.style.left = "50%";
        msg.style.transform = "translate(-50%, -50%)";
        msg.style.zIndex = "2000";
        msg.style.cursor = "pointer";

        msg.addEventListener("click", () => {
            msg.style.transition = "opacity 0.4s, transform 0.4s";
            msg.style.opacity = "0";
            msg.style.transform = "translate(-50%, -60%)";
            setTimeout(() => msg.remove(), 400);
        });
    });
});







