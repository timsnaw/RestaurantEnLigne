<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une catégorie</title>
    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        #image-preview {
            margin-top: 10px;
            max-width: 150px;
            display: none;
        }
    </style>
</head>
<body>
    <div>
        <h2>Ajouter une catégorie</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </p>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <p style="color: green;">
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="index.php?page=categorie_add" enctype="multipart/form-data" id="categorie-form">
            <div>
                <label for="nom_categorie">Nom de la catégorie</label><br>
                <input type="text" name="nom_categorie" id="nom_categorie" required>
            </div>
            <br>
            <div>
                <label for="images">Image de la catégorie (optionnel)</label><br>
                <input type="file" name="images" id="images" accept="image/jpeg,image/png,image/gif">
                <p id="image-error" class="error-message"></p>
                <img id="image-preview" src="#" alt="Prévisualisation de l'image">
            </div>
            <br>
            <div>
                <button type="submit">Ajouter</button>
                <a href="index.php?page=categorie_info">Annuler</a>
            </div>
        </form>
    </div>

    <script>
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
    </script>
</body>
</html>