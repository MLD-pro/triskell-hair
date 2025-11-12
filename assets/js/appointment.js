document.addEventListener("DOMContentLoaded", function () {
    // Empêche le script d’être exécuté deux fois
    if (window.appointmentScriptLoaded) return;
    window.appointmentScriptLoaded = true;

    if (!document.getElementById("appointement_date1")) return;

    /* === VALIDATION des dates + créneaux === */
    function validateChoice(dateInputId, momentBlockSelector, nextBlockId, validateBtnId) {
        const dateInput = document.getElementById(dateInputId);
        const momentInputs = document.querySelectorAll(momentBlockSelector + " input[type=checkbox]");
        const nextBlock = nextBlockId ? document.getElementById(nextBlockId) : null;
        const validateBtn = document.getElementById(validateBtnId);

        if (!dateInput || !validateBtn || momentInputs.length === 0) return;

        validateBtn.addEventListener("click", function () {
            const hasMoment = Array.from(momentInputs).some(input => input.checked);

            if (dateInput.value && hasMoment) {
                dateInput.classList.add("validated");

                momentInputs.forEach(input => {
                    if (input.checked) {
                        input.parentElement.classList.add("moment-selected");
                    }
                });

                if (nextBlock) nextBlock.style.display = "block";
            } else {
                alert("Merci de choisir une date et au moins un créneau.");
            }
        });
    }

    validateChoice("appointement_date1", "#date1-block", "date2-block", "validate-date1");
    validateChoice("appointement_date2", "#date2-block", "date3-block", "validate-date2");
    validateChoice("appointement_date3", "#date3-block", null, "validate-date3");

    /* === SELECT2 pour le champ prestations === */
    const serviceSelect = document.querySelector('#appointement_services');
    if (serviceSelect && typeof $ !== "undefined" && typeof $.fn.select2 !== "undefined") {
        $(serviceSelect).select2({
            placeholder: "Choisissez les prestations que vous souhaitez",
            allowClear: true,
            width: '100%',
        });
    }

    /* === ENVOI AJAX DU FORMULAIRE === */
    const appointmentForm = document.querySelector('form[name="appointement"]');
    if (appointmentForm) {
        let isSubmitting = false;

        appointmentForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (isSubmitting) return;
            isSubmitting = true;

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading-spinner"></span> Envoi en cours...';

            fetch(this.action, {
                method: this.method,
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showPopupMessage(
                            "Demande envoyée avec succès",
                            "Votre demande de rendez-vous a bien été prise en compte.<br>Vous serez contacté très prochainement."
                        );
                        this.reset();
                        submitBtn.innerHTML = "Envoyé !";
                    } else {
                        showPopupMessage("Une erreur est survenue", "Merci de réessayer dans quelques instants.");
                        submitBtn.innerHTML = "Erreur";
                    }
                })
                .catch(() => {
                    showPopupMessage("Erreur réseau", "Impossible d’envoyer votre demande. Vérifiez votre connexion Internet.");
                    submitBtn.innerHTML = "Erreur réseau";
                })
                .finally(() => {
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                        isSubmitting = false;
                    }, 6000);
                });
        });
    }

    /* === POPUP === */
    function showPopupMessage(title, message) {
        const overlay = document.createElement('div');
        overlay.className = 'popup-overlay visible';

        const card = document.createElement('div');
        card.className = 'popup-card';
        card.innerHTML = `<h3>${title}</h3><p>${message}</p>`;

        overlay.appendChild(card);
        document.body.appendChild(overlay);

        setTimeout(() => card.classList.add('show'), 50);

        setTimeout(() => {
            overlay.classList.remove('visible');
            setTimeout(() => overlay.remove(), 400);
        }, 6000);

        overlay.addEventListener('click', () => {
            overlay.classList.remove('visible');
            setTimeout(() => overlay.remove(), 400);
        });
    }
});









