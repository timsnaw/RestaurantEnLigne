function setupImageValidation(formId, imageInputId, previewId, errorId) {
    const form = document.getElementById(formId);
    const imageInput = document.getElementById(imageInputId);
    const imagePreview = document.getElementById(previewId);
    const imageError = document.getElementById(errorId);

    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    const maxFileSize = 5 * 1024 * 1024; // 5MB

    function showError(message) {
        imageError.textContent = message;
        imageError.style.display = 'block';
    }

    function clearError() {
        imageError.textContent = '';
        imageError.style.display = 'none';
    }

    // Gestion du changement d'image
    imageInput?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        clearError();
        if (imagePreview) imagePreview.style.display = 'none';

        if (file) {
            // Validation type
            if (!allowedTypes.includes(file.type)) {
                showError('Type de fichier non autorisé. Utilisez jpg, png ou gif.');
                imageInput.value = '';
                return;
            }
            
            // Validation taille
            if (file.size > maxFileSize) {
                showError('Le fichier est trop volumineux. Maximum 5 Mo.');
                imageInput.value = '';
                return;
            }
            
            // Prévisualisation
            if (imagePreview) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    });

    // Validation à la soumission
    form?.addEventListener('submit', function(e) {
        const file = imageInput?.files[0];
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
}

// Initialisation pour les plats
setupImageValidation(
    'plat-form', 
    'plat-images', 
    'plat-image-preview', 
    'plat-image-error'
);

// Initialisation pour les catégories
setupImageValidation(
    'categorie-form', 
    'categorie-images', 
    'categorie-image-preview', 
    'categorie-image-error'
);