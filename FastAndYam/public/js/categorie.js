        const form = document.getElementById('categorie-form');
        const imageInput = document.getElementById('images');
        const imagePreview = document.getElementById('image-preview');
        const imageError = document.getElementById('image-error');

        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        const maxFileSize = 5 * 1024 * 1024;

        function showError(message) {
            imageError.textContent = message;
            imageError.style.display = 'block';
        }

        function clearError() {
            imageError.textContent = '';
            imageError.style.display = 'none';
        }

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            clearError();
            imagePreview.style.display = 'none';

            if (file) {
                if (!allowedTypes.includes(file.type)) {
                    showError('Type de fichier non autorisé. Utilisez jpg, png ou gif.');
                    imageInput.value = '';
                    return;
                }
                if (file.size > maxFileSize) {
                    showError('Le fichier est trop volumineux. Maximum 5 Mo.');
                    imageInput.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        form.addEventListener('submit', function(e) {
            const file = imageInput.files[0];
            clearError();

            if (file) {
                if (!allowedTypes.includes(file.type)) {
                    e.preventDefault();
                    showError('Type de fichier non autorisé. Utilisez jpg, png ou gif.');
                    return;
                }
                if (file.size > maxFileSize) {
                    e.preventDefault();
                    showError('Le fichier est trop volumineux. Maximum 5 Mo.');
                    return;
                }
            }
        });