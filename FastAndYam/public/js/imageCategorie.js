// Function to validate and preview images for category form
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
        } else {
            console.error(`Error element with ID ${errorId} not found`);
        }
    }

    function clearError() {
        if (imageError) {
            imageError.textContent = '';
            imageError.style.display = 'none';
        }
    }

    if (!form) {
        console.error(`Form with ID ${formId} not found`);
        return;
    }
    if (!imageInput) {
        console.error(`Image input with ID ${imageInputId} not found`);
        return;
    }

    // Handle image input change
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        clearError();
        if (imagePreview) {
            imagePreview.style.display = 'none';
        }

        if (file) {
            // Validate file type
            if (!allowedTypes.includes(file.type)) {
                showError('Type de fichier non autorisé. Utilisez jpg, png ou gif.');
                imageInput.value = '';
                return;
            }

            // Validate file size
            if (file.size > maxFileSize) {
                showError('Le fichier est trop volumineux. Maximum 5 Mo.');
                imageInput.value = '';
                return;
            }

            // Show preview
            if (imagePreview) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    console.log(`Image preview updated for ${imageInputId}`);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    // Validate on form submission
    form.addEventListener('submit', function(e) {
        const file = imageInput.files[0];
        clearError();

        // Only validate if a file is selected (image is optional)
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
        console.log(`Form ${formId} submitted`);
    });
}

// Initialize for category form only
setupImageValidation(
    'categorie-form',
    'categorie-images',
    'categorie-image-preview',
    'categorie-image-error'
);
