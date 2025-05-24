// Function to validate and preview main image
function setupImageValidation(formId, imageInputId, previewId, errorId) {
    const form = document.getElementById(formId);
    const imageInput = document.getElementById(imageInputId);
    const imagePreview = document.getElementById(previewId);
    const imageError = document.getElementById(errorId);

    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    const maxFileSize = 5 * 1024 * 1024; // 5MB

    function showError(message) {
        if (imageError) {
            imageError.textContent = message;
            imageError.style.display = 'block';
        }
    }

    function clearError() {
        if (imageError) {
            imageError.textContent = '';
            imageError.style.display = 'none';
        }
    }

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            clearError();
            if (imagePreview) imagePreview.style.display = 'none';

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

    if (form) {
        form.addEventListener('submit', function(e) {
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
}

// Function to handle secondary images
function setupSecondaryImages() {
    const secondaryImagesContainer = document.getElementById('secondary-images-inputs');
    const addImageButton = document.getElementById('add-secondary-image');
    const secondaryError = document.getElementById('plat-images-secondary-error');
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    const maxFileSize = 5 * 1024 * 1024; // 5MB

    function showSecondaryError(message) {
        if (secondaryError) {
            secondaryError.textContent = message;
            secondaryError.style.display = 'block';
        }
    }

    function clearSecondaryError() {
        if (secondaryError) {
            secondaryError.textContent = '';
            secondaryError.style.display = 'none';
        }
    }

    // Add new secondary image input
    if (addImageButton) {
        addImageButton.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent any default behavior
            const imageGroup = document.createElement('div');
            imageGroup.className = 'image-group';
            imageGroup.innerHTML = `
                <input type="file" name="images_secondary[]" accept="image/jpeg,image/png,image/gif">
                <button type="button" class="remove-image">Supprimer</button>
                <img class="secondary-image-preview" src="#" alt="Aperçu de l'image" style="display: none;">
            `;
            secondaryImagesContainer.appendChild(imageGroup);
            console.log('New image group added'); // Debugging
        });
    } else {
        console.error('Add secondary image button not found');
    }

    // Handle file input changes for secondary images (event delegation)
    if (secondaryImagesContainer) {
        secondaryImagesContainer.addEventListener('change', function(e) {
            if (e.target && e.target.type === 'file') {
                const file = e.target.files[0];
                const preview = e.target.nextElementSibling?.nextElementSibling; // Get the preview image
                clearSecondaryError();

                if (file) {
                    if (!allowedTypes.includes(file.type)) {
                        showSecondaryError('Type de fichier non autorisé. Utilisez jpg, png ou gif.');
                        e.target.value = '';
                        if (preview) preview.style.display = 'none';
                        return;
                    }
                    if (file.size > maxFileSize) {
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

        // Handle remove button clicks (event delegation)
        secondaryImagesContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-image')) {
                e.preventDefault(); // Prevent any default behavior
                const imageGroup = e.target.parentElement;
                if (imageGroup) {
                    imageGroup.remove();
                    clearSecondaryError();
                    console.log('Image group removed'); // Debugging
                }
            }
        });
    } else {
        console.error('Secondary images container not found');
    }
}

// Initialize main image validation
setupImageValidation(
    'plat-form',
    'plat-image',
    'plat-image-preview',
    'plat-image-error'
);

// Initialize secondary images handling
setupSecondaryImages();