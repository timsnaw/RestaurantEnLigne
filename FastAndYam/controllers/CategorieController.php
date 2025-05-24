<?php
// Vérifie si la constante BASE_PATH est définie
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

// inclusion des fichiers de configuration et du modele de categorie
require_once BASE_PATH . 'config/connexion.php';
require_once BASE_PATH . 'models/CategorieModel.php';

class CategorieController {
    private $model;

    // Constructeur : initialise le modele avec l'objet PDO
    public function __construct($pdo) {
        $this->model = new CategorieModel($pdo);
    }

    // Gère la page demandée via l'URL et appelle la methode correspondante
    public function gererDemande() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'categorie_info';
        switch ($page) {
            case 'categorie_info':
                $this->afficherCategorieList(); // Liste des catégories
                break;
            case 'categorie_details':
                $this->afficherCategorieDetails(); // Détails d'une catégorie
                break;
            case 'categorie_edit':
                $this->ModifierCategorie(); // Modifier une catégorie
                break;
            case 'categorie_delete':
                $this->SupprimerCategorie(); // Supprimer une catégorie
                break;
            case 'categorie_add':
                $this->AjouterCategorie(); // Ajouter une nouvelle catégorie
                break;
            default:
                // Redirection par défaut vers la liste des catégories
                header("Location: index.php?page=categorie_info");
                exit;
        }
    }

    // Affiche la liste de toutes les catégories
    private function afficherCategorieList() {
        $categories = $this->model->getToutCategories();
        include BASE_PATH . 'view/admin/categorie_info.php';
    }

    // Affiche les détails d'une catégorie spécifique (nom, image, plats liés)
    private function afficherCategorieDetails() {
        $categorie_id = isset($_GET['categorie_id']) ? (int)$_GET['categorie_id'] : 0;
        $categorieInfo = $categorie_id > 0 ? $this->model->getCategorieId($categorie_id) : false;
        $plats = $categorie_id > 0 ? $this->model->getPlatsParCategorie($categorie_id) : [];
        include BASE_PATH . 'view/admin/categorie_details.php';
    }

    // Gère l’upload et la validation de l’image (format, taille, nom unique)
    private function gererImageUpload($existingImage = '') {
        if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = BASE_PATH . 'public/images/';
            $fileName = basename($_FILES['images']['name']);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $newFileName = uniqid() . '.' . $fileExtension;
            $uploadPath = $uploadDir . $newFileName;

            // Vérifie le type de fichier
            if (!in_array($fileExtension, $allowedExtensions)) {
                $_SESSION['error'] = "Type de fichier non autorisé. Utilisez jpg, jpeg, png ou gif.";
                return $existingImage;
            }

            // Verifie la taille du fichier (max 5 Mo)
            if ($_FILES['images']['size'] > 5 * 1024 * 1024) {
                $_SESSION['error'] = "Le fichier est trop volumineux. Maximum 5 Mo.";
                return $existingImage;
            }

            // Deplace le fichier vers le dossier de destination
            if (move_uploaded_file($_FILES['images']['tmp_name'], $uploadPath)) {
                return $newFileName;
            } else {
                $_SESSION['error'] = "Erreur lors du téléchargement de l'image.";
                return $existingImage;
            }
        }

        // Aucun fichier sélectionné : on garde l'image existante
        return $existingImage;
    }

    // Permet de modifier une catégorie existante
    private function ModifierCategorie() {
        $categorie_id = isset($_GET['categorie_id']) ? (int)$_GET['categorie_id'] : 0;
        $categorieInfo = $categorie_id > 0 ? $this->model->getCategorieId($categorie_id) : false;

        // Vérifie si un formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $categorieInfo) {
            $nom_categorie = trim($_POST['nom_categorie'] ?? '');
            $existingImage = $categorieInfo['image_categorie'] ?? '';

            // Upload d’image
            $image_categorie = $this->gererImageUpload($existingImage);

            // Validation du nom et modification
            if ($nom_categorie && !$this->model->nameExiste($nom_categorie, $categorie_id)) {
                if ($this->model->modifierCategorie($categorie_id, $nom_categorie, $image_categorie)) {
                    $_SESSION['success'] = "Catégorie mise à jour avec succès.";
                    header("Location: index.php?page=categorie_details&categorie_id=$categorie_id");
                    exit;
                } else {
                    $_SESSION['error'] = "Erreur lors de la mise à jour de la catégorie.";
                }
            } else {
                $_SESSION['error'] = $nom_categorie ? "Ce nom de catégorie existe déjà." : "Le nom de la catégorie est requis.";
            }
        }

        // Affiche le formulaire de modification
        include BASE_PATH . 'view/admin/categorie_edit.php';
    }

    // Permet d'ajouter une nouvelle catégorie
    private function AjouterCategorie() {
        // Vérifie si un formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_categorie = trim($_POST['nom_categorie'] ?? '');

            // Upload de l'image
            $image_categorie = $this->gererImageUpload();

            // Validation et ajout
            if ($nom_categorie && !$this->model->nameExiste($nom_categorie)) {
                if ($this->model->ajouterCategorie($nom_categorie, $image_categorie)) {
                    $_SESSION['success'] = "Catégorie ajoutée avec succès.";
                    header("Location: index.php?page=categorie_add");
                    exit;
                } else {
                    $_SESSION['error'] = "Erreur lors de l'ajout de la catégorie.";
                }
            } else {
                $_SESSION['error'] = $nom_categorie ? "Ce nom de catégorie existe déjà." : "Le nom de la catégorie est requis.";
            }
        }

        // Affiche le formulaire d'ajout
        include BASE_PATH . 'view/admin/categorie_add.php';
    }
    // supprime une categorie selon son ID
    private function SupprimerCategorie() {
        $categorie_id = isset($_GET['categorie_id']) ? (int)$_GET['categorie_id'] : 0;

        if ($categorie_id > 0) {
            // recupere les informations de la catégorie pour obtenir le nom de l'image
            $categorieInfo = $this->model->getCategorieId($categorie_id);

            // Si la catégorie existe et a une image associe
            if ($categorieInfo && !empty($categorieInfo['image_categorie'])) {
                // Construire le chemin complet du fichier image
                $imagePath = BASE_PATH . 'public/images/' . $categorieInfo['image_categorie'];

                // Verifier si le fichier existe et le supprimer
                if (file_exists($imagePath)) {
                    if (!unlink($imagePath)) {
                        $_SESSION['error'] = "Erreur lors de la suppression de l'image associée.";
                    }
                }
            }

            // Supprimer la categorie et les plats associes
            try {
                if ($this->model->supprimeCategorie($categorie_id)) {
                    $_SESSION['success'] = "Catégorie et plats associés supprimés avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression de la catégorie.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        } else {
            $_SESSION['error'] = "ID de catégorie invalide.";
        }
        
        // Redirige vers la liste apres suppression
        header("Location: index.php?page=categorie_info");
        exit;
    }
}
?>
