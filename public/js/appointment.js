document.addEventListener("DOMContentLoaded", function () {
    //  Partie VALIDATION des dates + créneaux
    function validateChoice(dateInputId, momentBlockSelector, nextBlockId, validateBtnId) {
        const dateInput = document.getElementById(dateInputId);
        const momentInputs = document.querySelectorAll(momentBlockSelector + " input[type=checkbox]");
        const nextBlock = nextBlockId ? document.getElementById(nextBlockId) : null;
        const validateBtn = document.getElementById(validateBtnId);

        validateBtn.addEventListener("click", function () {
            const hasMoment = Array.from(momentInputs).some(input => input.checked);

            if (dateInput.value && hasMoment) {
                // ✅ Style vert pour le champ date
                dateInput.style.border = "2px solid green";
                dateInput.style.backgroundColor = "#e6ffe6";

                // ✅ Style vert pour les cases cochées
                momentInputs.forEach(input => {
                    if (input.checked) {
                        input.parentElement.style.color = "green"; // texte en vert
                        input.style.accentColor = "green"; // case cochée en vert (navigateur moderne)
                    }
                });

                if (nextBlock) {
                    nextBlock.style.display = "block"; // Affiche le bloc suivant
                }
            } else {
                alert("Merci de choisir une date et au moins un créneau.");
            }
        });
    }

    validateChoice("appointement_date1", "#date1-block", "date2-block", "validate-date1");
    validateChoice("appointement_date2", "#date2-block", "date3-block", "validate-date2");
    validateChoice("appointement_date3", "#date3-block", null, "validate-date3");


    //  Partie SELECT2 pour le champ prestations souhaitées
    const serviceSelect = document.querySelector('#appointement_services');

    if (serviceSelect && typeof $ !== "undefined" && typeof $.fn.select2 !== "undefined") {
        $(serviceSelect).select2({
            placeholder: "Choisissez les prestations que vous souhaitez",
            allowClear: true,
            width: '100%' // occupe toute la largeur du champ
        });
    }
});







