// Fonction pour valider et prévisualiser l'image principale
function setupImageValidation(formId, imageInputId, previewId, errorId) {
    const form = document.getElementById(formId);
    const imageInput = document.getElementById(imageInputId);
    const imagePreview = document.getElementById(previewId);
    const imageError = document.getElementById(errorId);

    const typesAutorises = ['image/jpeg', 'image/png', 'image/gif'];
    const tailleMaxFichier = 5 * 1024 * 1024; // 5 Mo

    // Afficher un message d'erreur
    function showError(message) {
        if (imageError) {
            imageError.textContent = message;
            imageError.style.display = 'block';
        }
    }

    // Effacer le message d'erreur
    function clearError() {
        if (imageError) {
            imageError.textContent = '';
            imageError.style.display = 'none';
        }
    }

    // Validation à la sélection d'un fichier
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            clearError();
            if (imagePreview) imagePreview.style.display = 'none';

            if (file) {
                if (!typesAutorises.includes(file.type)) {
                    showError('Type de fichier non autorisé. Utilisez jpg, png ou gif.');
                    imageInput.value = '';
                    return;
                }
                if (file.size > tailleMaxFichier) {
                    showError('Le fichier est trop volumineux. Maximum 5 Mo.');
                    imageInput.value = '';
                    return;
                }
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
    }

    // Validation avant l'envoi du formulaire
    if (form) {
        form.addEventListener('submit', function(e) {
            const file = imageInput?.files[0];
            clearError();

            if (file) {
                if (!typesAutorises.includes(file.type)) {
                    e.preventDefault();
                    showError('Type de fichier non autorisé. Utilisez jpg, png ou gif.');
                    return;
                }
                if (file.size > tailleMaxFichier) {
                    e.preventDefault();
                    showError('Le fichier est trop volumineux. Maximum 5 Mo.');
                    return;
                }
            }
        });
    }
}

// Fonction pour gérer les images secondaires
function setupSecondaryImages() {
    const secondaryImagesContainer = document.getElementById('secondary-images-inputs');
    const addImageButton = document.getElementById('add-secondary-image');
    const secondaryError = document.getElementById('plat-images-secondary-error');
    const typesAutorises = ['image/jpeg', 'image/png', 'image/gif'];
    const tailleMaxFichier = 5 * 1024 * 1024; // 5 Mo

    // Afficher une erreur pour les images secondaires
    function showSecondaryError(message) {
        if (secondaryError) {
            secondaryError.textContent = message;
            secondaryError.style.display = 'block';
        }
    }

    // Effacer l'erreur des images secondaires
    function clearSecondaryError() {
        if (secondaryError) {
            secondaryError.textContent = '';
            secondaryError.style.display = 'none';
        }
    }

    // Ajouter un nouveau champ d'image secondaire
    if (addImageButton) {
        addImageButton.addEventListener('click', function(e) {
            e.preventDefault(); // Empêcher le comportement par défaut
            const imageGroup = document.createElement('div');
            imageGroup.className = 'image-group';
            imageGroup.innerHTML = `
                <input type="file" name="images_secondary[]" accept="image/jpeg,image/png,image/gif">
                <button type="button" class="remove-image">Supprimer</button>
                <img class="secondary-image-preview" src="#" alt="Aperçu de l'image" style="display: none;">
            `;
            secondaryImagesContainer.appendChild(imageGroup);
            console.log('Nouveau champ d’image ajouté'); // Débogage
        });
    } else {
        console.error("Bouton d'ajout d'image secondaire introuvable");
    }

    // Gérer les changements de fichiers pour les images secondaires
    if (secondaryImagesContainer) {
        secondaryImagesContainer.addEventListener('change', function(e) {
            if (e.target && e.target.type === 'file') {
                const file = e.target.files[0];
                const preview = e.target.nextElementSibling?.nextElementSibling; // Récupère l'élément image pour l'aperçu
                clearSecondaryError();

                if (file) {
                    if (!typesAutorises.includes(file.type)) {
                        showSecondaryError('Type de fichier non autorisé. Utilisez jpg, png ou gif.');
                        e.target.value = '';
                        if (preview) preview.style.display = 'none';
                        return;
                    }
                    if (file.size > tailleMaxFichier) {
                        showSecondaryError('Le fichier est trop volumineux. Maximum 5 Mo.');
                        e.target.value = '';
                        if (preview) preview.style.display = 'none';
                        return;
                    }
                    if (preview) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }
                } else {
                    if (preview) preview.style.display = 'none';
                }
            }
        });

        // Gérer le clic sur le bouton "Supprimer"
        secondaryImagesContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-image')) {
                e.preventDefault(); // Empêcher le comportement par défaut
                const imageGroup = e.target.parentElement;
                if (imageGroup) {
                    imageGroup.remove();
                    clearSecondaryError();
                    console.log('Champ d’image supprimé'); // Débogage
                }
            }
        });
    } else {
        console.error("Conteneur des images secondaires introuvable");
    }
}

// Initialisation de la validation de l'image principale
setupImageValidation(
    'plat-form',
    'plat-image',
    'plat-image-preview',
    'plat-image-error'
);

// Initialisation de la gestion des images secondaires
setupSecondaryImages();
