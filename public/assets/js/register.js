document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const passwordInput = document.querySelector('input[name="password"]');
    const confirmInput = document.querySelector('input[name="confirm_password"]');

    form.addEventListener('submit', (e) => {
        const password = passwordInput.value;
        const confirm = confirmInput.value;

        // Vérifie la force du mot de passe
        const strongEnough = /^(?=.*[A-Z])(?=.*\d).{8,}$/.test(password);

        if (!strongEnough) {
            e.preventDefault();
            alert("❌ Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.");
        } else if (password !== confirm) {
            e.preventDefault();
            alert("❌ Les mots de passe ne correspondent pas.");
        }
    });
});
