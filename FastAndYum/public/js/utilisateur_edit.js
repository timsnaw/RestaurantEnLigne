function togglePasswordForm() {
    const form = document.getElementById('password-form');
    const toggle = document.getElementById('show-password-form');
    if (toggle.checked) {
        form.style.display = 'block';
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        form.style.display = 'none';
    }
}

function hidePasswordForm() {
    const form = document.getElementById('password-form');
    const toggle = document.getElementById('show-password-form');
    form.style.display = 'none';
    toggle.checked = false;
}

function toggleDeleteAccountForm() {
    const form = document.getElementById('delete-account-form');
    const toggle = document.getElementById('show-delete-account-form');
    if (toggle.checked) {
        form.style.display = 'block';
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        form.style.display = 'none';
    }
}

function hideDeleteAccountForm() {
    const form = document.getElementById('delete-account-form');
    const toggle = document.getElementById('show-delete-account-form');
    form.style.display = 'none';
    toggle.checked = false;
}

function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    const toggle = input.nextElementSibling;
    if (input.type === 'password') {
        input.type = 'text';
        toggle.textContent = 'Masquer';
    } else {
        input.type = 'password';
        toggle.textContent = 'Afficher';
    }
}