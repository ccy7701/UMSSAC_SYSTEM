document.addEventListener('DOMContentLoaded', function () {
    const identifierField = document.getElementById('identifier-field');
    const roleRadios = document.querySelectorAll('input[name="account_role"]');

    if (identifierField && roleRadios.length > 0) {
        function updateLoginForm() {
            const selectedRole = document.querySelector('input[name="account_role"]:checked').value;

            if (selectedRole === "1") {
                identifierField.innerHTML = `
                    <label for="matric-number" class="rsans form-label fw-semibold">Matric number</label>
                    <div class="input-group">
                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-id-badge"></i></span>
                        <input type="text" id="matric-number" name="account_matric_number" class="rsans form-control" required autofocus>
                    </div>
                `;
            } else if (selectedRole === "2") {
                identifierField.innerHTML = `
                    <label for="fm-email-address" class="rsans form-label fw-semibold">Faculty member e-mail address</label>
                    <div class="input-group">
                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-envelope"></i></span>
                        <input type="text" id="fm-email-address" name="account_email_address" class="rsans form-control" required autofocus>
                    </div>
                `;
            } else {
                identifierField.innerHTML = `
                    <label for="ad-email-address" class="rsans form-label fw-semibold">Admin e-mail address</label>
                    <div class="input-group">
                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-envelope"></i></span>
                        <input type="text" id="ad-email-address" name="account_email_address" class="rsans form-control" required autofocus>
                    </div>
                `;
            }
        }

        // Attach event listeners to each radio button
        roleRadios.forEach(radio => {
            radio.addEventListener('change', updateLoginForm);
        });

        // Initialize form based on default selected role
        updateLoginForm();
    }
});
