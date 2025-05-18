<?php
require_once BASE_PATH . 'models/PlatModel.php';

class PlatController {
    private $pdo;
    private $platModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->platModel = new PlatModel($pdo);
    }

    public function gererDemande() {
        $action = $_GET['page'] ?? 'plats';

        switch ($action) {
            case 'plats':
                $this->listPlats();
                break;
            case 'plat_add':
                $this->ajouterPlat();
                break;
            case 'plat_edit':
                $this->modifierPlat();
                break;
            case 'plat_info':
                $this->platInfo();
                break;
            case 'plat_delete':
                $this->supprimerPlat();
                break;
            default:
                $this->listPlats();
                break;
        }
    }

    // Liste des plats avec les catégories
    private function listPlats() {
        $selected_categorie_id = filter_input(INPUT_GET, 'categorie_id', FILTER_VALIDATE_INT) ?: null;
        $plats = $this->platModel->getPlatsAvecCategories($selected_categorie_id);
        $categories = $this->platModel->getCategories();
        $message = $_GET['message'] ?? '';
        require_once BASE_PATH . 'view/admin/plats.php';
    }

    // Ajouter un nouveau plat
private function ajouterPlat() {
    $categories = $this->platModel->getCategories();
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = [];

        $categorie_id = filter_input(INPUT_POST, 'categorie_id', FILTER_VALIDATE_INT);
        $titre = trim($_POST['titre'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_FLOAT);

        if (!$categorie_id) $errors[] = "Catégorie invalide.";
        if (empty($titre)) $errors[] = "Le titre est requis.";
        if (empty($description)) $errors[] = "La description est requise.";
        if ($prix === false || $prix < 0) $errors[] = "Prix invalide.";

        // Gestion de l'image
        $image = $_FILES['image'] ?? null;
        $upload_dir = BASE_PATH . 'public/images/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $image_path = '';
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $image_name = uniqid() . '.' . $ext; // Nom du fichier uniquement
            $image_path = $upload_dir . $image_name; // Chemin complet pour le déplacement
            if (!move_uploaded_file($image['tmp_name'], $image_path)) {
                $errors[] = "Échec du téléchargement de l'image.";
            } else {
                $image_path = $image_name; // Stocker uniquement le nom dans la DB
            }
        } else {
            $errors[] = "L'image est requise.";
        }

        if (empty($errors)) {
            try {
                $this->platModel->ajouterPlat($categorie_id, $titre, $description, $prix, $image_path);
                header('Location: index.php?page=plats&message=Plat ajouté avec succès.');
                exit;
            } catch (Exception $e) {
                $errors[] = "Erreur lors de l'enregistrement : " . $e->getMessage();
            }
        }

        if (!empty($errors)) {
            $_SESSION['error'] = "Erreurs : " . implode(", ", $errors);
        }
    }

    require_once BASE_PATH . 'view/admin/plat_add.php';
}

    // Modifier un plat existant
private function modifierPlat() {
    $plat_id = filter_input(INPUT_GET, 'plat_id', FILTER_VALIDATE_INT);
    if (!$plat_id || !($platInfo = $this->platModel->getPlatId($plat_id))) {
        header('Location: index.php?page=plats&message=Identifiant du plat invalide.');
        exit;
    }

    $categories = $this->platModel->getCategories();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = [];

        $categorie_id = filter_input(INPUT_POST, 'categorie_id', FILTER_VALIDATE_INT);
        $titre = trim($_POST['titre'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_FLOAT);

        if (!$categorie_id) $errors[] = "Catégorie invalide.";
        if (empty($titre)) $errors[] = "Le titre est requis.";
        if (empty($description)) $errors[] = "La description est requise.";
        if ($prix === false || $prix < 0) $errors[] = "Prix invalide.";

        // Gestion de la nouvelle image
        $image = $_FILES['image'] ?? null;
        $image_path = $platInfo['image'];
        $upload_dir = BASE_PATH . 'public/images/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $image_name = uniqid() . '.' . $ext; // Nom du fichier uniquement
            $full_path = $upload_dir . $image_name; // Chemin complet pour le déplacement
            if (move_uploaded_file($image['tmp_name'], $full_path)) {
                if (!empty($platInfo['image']) && file_exists(BASE_PATH . 'public/images/' . $platInfo['image'])) {
                    unlink(BASE_PATH . 'public/images/' . $platInfo['image']); // Supprimer l’ancienne image
                }
                $image_path = $image_name; // Stocker uniquement le nom dans la DB
            } else {
                $errors[] = "Échec du téléchargement de la nouvelle image.";
            }
        }

        if (empty($errors)) {
            try {
                $this->platModel->modifierPlat($plat_id, $categorie_id, $titre, $description, $prix, $image_path);
                header('Location: index.php?page=plats&message=Plat modifié avec succès.');
                exit;
            } catch (Exception $e) {
                $errors[] = "Erreur lors de la modification : " . $e->getMessage();
            }
        }

        if (!empty($errors)) {
            $_SESSION['error'] = "Erreurs : " . implode(", ", $errors);
        }
    }

    require_once BASE_PATH . 'view/admin/plat_edit.php';
}

    // Afficher les plats d'une catégorie spécifique
    private function platInfo() {
    $plat_id = filter_input(INPUT_GET, 'plat_id', FILTER_VALIDATE_INT);
    if (!$plat_id) {
        header('Location: index.php?page=plats&message=Identifiant du plat invalide.');
        exit;
    }

    $plat = $this->platModel->getPlatId($plat_id);
    if (!$plat) {
        header('Location: index.php?page=plats&message=Plat introuvable.');
        exit;
    }

    $categories = $this->platModel->getCategories();
    $categorieInfo = array_filter($categories, fn($cat) => $cat['categorie_id'] == $plat['categorie_id']);
    $categorieInfo = reset($categorieInfo);
    $message = $_GET['message'] ?? '';

    require_once BASE_PATH . 'view/admin/plat_info.php';
}

    // Supprimer un plat
private function supprimerPlat() {
    $plat_id = filter_input(INPUT_GET, 'plat_id', FILTER_VALIDATE_INT);
    $message = '';

    if ($plat_id) {
        try {
            $plat = $this->platModel->getPlatId($plat_id);
            if ($plat) {
                if (!empty($plat['image']) && file_exists(BASE_PATH . 'public/images/' . $plat['image'])) {
                    unlink(BASE_PATH . 'public/images/' . $plat['image']); // Supprimer l’image
                }
                $this->platModel->supprimerPlat($plat_id);
                $message = 'Plat supprimé avec succès.';
            } else {
                $message = 'Plat introuvable.';
            }
        } catch (Exception $e) {
            $message = 'Erreur lors de la suppression : ' . $e->getMessage();
        }
    } else {
        $message = 'Identifiant du plat invalide.';
    }

    header("Location: index.php?page=plats&message=" . urlencode($message));
    exit;
}
}
?>
