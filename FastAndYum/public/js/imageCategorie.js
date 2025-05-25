// Fonction pour valider et prévisualiser les images du formulaire de catégorie
function setupImageValidation(formId, imageInputId, previewId, errorId) {
    const form = document.getElementById(formId);
    const imageInput = document.getElementById(imageInputId);
    const imagePreview = document.getElementById(previewId);
    const imageError = document.getElementById(errorId);

    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    const maxFileSize = 5 * 1024 * 1024; // 5 Mo

    // Affiche un message d'erreur
    function showError(message) {
        if (imageError) {
            imageError.textContent = message;
            imageError.style.display = 'block';
        } else {
            console.error(`Élément d'erreur avec l'ID ${errorId} introuvable`);
        }
    }

    // Efface le message d'erreur
    function clearError() {
        if (imageError) {
            imageError.textContent = '';
            imageError.style.display = 'none';
        }
    }

    if (!form) {
        console.error(`Formulaire avec l'ID ${formId} introuvable`);
        return;
    }
    if (!imageInput) {
        console.error(`Champ d'image avec l'ID ${imageInputId} introuvable`);
        return;
    }

    // gere le changement d'image
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        clearError();
        if (imagePreview) {
            imagePreview.style.display = 'none';
        }

        if (file) {
            // Vérifie le type de fichier
            if (!allowedTypes.includes(file.type)) {
                showError('Type de fichier non autorisé. Utilisez jpg, png ou gif.');
                imageInput.value = '';
                return;
            }

            // Vérifie la taille du fichier
            if (file.size > maxFileSize) {
                showError('Le fichier est trop volumineux. Maximum 5 Mo.');
                imageInput.value = '';
                return;
            }

            // Affiche l'aperçu de l'image
            if (imagePreview) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    console.log(`Aperçu de l'image mis à jour pour ${imageInputId}`);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    // Valide le fichier lors de la soumission du formulaire
    form.addEventListener('submit', function(e) {
        const file = imageInput.files[0];
        clearError();

        // Valide uniquement si un fichier est sélectionné (l'image est facultative)
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
        console.log(`Formulaire ${formId} soumis`);
    });
}

// Initialisation pour le formulaire de catégorie uniquement
setupImageValidation(
    'categorie-form',
    'categorie-images',
    'categorie-image-preview',
    'categorie-image-error'
);
