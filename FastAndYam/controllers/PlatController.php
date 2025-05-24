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

            // Gestion de l'image principale
            $image = $_FILES['image'] ?? null;
            $upload_dir = BASE_PATH . 'public/images/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $image_path = '';
            if ($image && $image['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
                $image_name = uniqid() . '.' . $ext;
                $full_path = $upload_dir . $image_name;
                if (!move_uploaded_file($image['tmp_name'], $full_path)) {
                    $errors[] = "Échec du téléchargement de l'image principale.";
                } else {
                    $image_path = $image_name;
                }
            } else {
                $errors[] = "L'image principale est requise.";
            }

            // Gestion des images secondaires (optionnelles)
            $secondary_images = $_FILES['images_secondary'] ?? null;
            $secondary_image_paths = [];
            if ($secondary_images && !empty($secondary_images['name'][0])) {
                foreach ($secondary_images['name'] as $key => $name) {
                    if ($secondary_images['error'][$key] === UPLOAD_ERR_OK) {
                        $ext = pathinfo($name, PATHINFO_EXTENSION);
                        $image_name = uniqid() . '.' . $ext;
                        $full_path = $upload_dir . $image_name;
                        if (move_uploaded_file($secondary_images['tmp_name'][$key], $full_path)) {
                            $secondary_image_paths[] = $image_name;
                        } else {
                            $errors[] = "Échec du téléchargement de l'image secondaire : $name.";
                        }
                    }
                }
            }

            if (empty($errors)) {
                try {
                    $this->pdo->beginTransaction();
                    $plat_id = $this->platModel->ajouterPlat($categorie_id, $titre, $description, $prix, $image_path);
                    foreach ($secondary_image_paths as $secondary_image) {
                        $this->platModel->ajouterImageSecondaire($plat_id, $secondary_image);
                    }
                    $this->pdo->commit();
                    header('Location: index.php?page=plats&message=Plat ajouté avec succès.');
                    exit;
                } catch (Exception $e) {
                    $this->pdo->rollBack();
                    // Supprimer les fichiers téléversés en cas d'erreur
                    if ($image_path && file_exists($upload_dir . $image_path)) {
                        unlink($upload_dir . $image_path);
                    }
                    foreach ($secondary_image_paths as $secondary_image) {
                        if (file_exists($upload_dir . $secondary_image)) {
                            unlink($upload_dir . $secondary_image);
                        }
                    }
                    $errors[] = "Erreur lors de l'enregistrement : " . $e->getMessage();
                }
            }

            if (!empty($errors)) {
                $_SESSION['error'] = "Erreurs : " . implode(", ", $errors);
            }
        }

        require_once BASE_PATH . 'view/admin/plat_add.php';
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


// Modifier un plat existant
private function modifierPlat() {
    $plat_id = filter_input(INPUT_GET, 'plat_id', FILTER_VALIDATE_INT);
    if (!$plat_id || !($platInfo = $this->platModel->getPlatId($plat_id))) {
        header('Location: index.php?page=plats&message=Identifiant du plat invalide.');
        exit;
    }

    $categories = $this->platModel->getCategories();

    // Gestion de la suppression d'une image secondaire
    if (isset($_GET['delete_image_id'])) {
        $image_id = filter_input(INPUT_GET, 'delete_image_id', FILTER_VALIDATE_INT);
        if ($image_id) {
            try {
                $image_name = $this->platModel->supprimerImageSecondaire($image_id);
                if ($image_name && file_exists(BASE_PATH . 'public/images/' . $image_name)) {
                    unlink(BASE_PATH . 'public/images/' . $image_name);
                }
                $_SESSION['success'] = "Image secondaire supprimée avec succès.";
                header("Location: index.php?page=plat_edit&plat_id=$plat_id");
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de la suppression de l'image : " . $e->getMessage();
            }
        }
    }

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

        // Gestion de l'image principale
        $image = $_FILES['image'] ?? null;
        $image_path = $platInfo['image'];
        $upload_dir = BASE_PATH . 'public/images/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $image_name = uniqid() . '.' . $ext;
            $full_path = $upload_dir . $image_name;
            if (move_uploaded_file($image['tmp_name'], $full_path)) {
                if (!empty($platInfo['image']) && file_exists(BASE_PATH . 'public/images/' . $platInfo['image'])) {
                    unlink(BASE_PATH . 'public/images/' . $platInfo['image']);
                }
                $image_path = $image_name;
            } else {
                $errors[] = "Échec du téléchargement de la nouvelle image principale.";
            }
        }

        // Gestion des images secondaires (optionnelles)
        $secondary_images = $_FILES['images_secondary'] ?? null;
        $secondary_image_paths = [];
        if ($secondary_images && !empty($secondary_images['name'][0])) {
            foreach ($secondary_images['name'] as $key => $name) {
                if ($secondary_images['error'][$key] === UPLOAD_ERR_OK) {
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $image_name = uniqid() . '.' . $ext;
                    $full_path = $upload_dir . $image_name;
                    if (move_uploaded_file($secondary_images['tmp_name'][$key], $full_path)) {
                        $secondary_image_paths[] = $image_name;
                    } else {
                        $errors[] = "Échec du téléchargement de l'image secondaire : $name.";
                    }
                }
            }
        }

        // Vérification du nombre total d'images secondaires
        $existing_images = $this->platModel->getSecondairesImages($plat_id);
        if (count($existing_images) + count($secondary_image_paths) > 5) {
            $errors[] = "Vous ne pouvez pas avoir plus de 5 images secondaires.";
        }

        if (empty($errors)) {
            try {
                $this->pdo->beginTransaction();
                $this->platModel->modifierPlat($plat_id, $categorie_id, $titre, $description, $prix, $image_path);
                foreach ($secondary_image_paths as $secondary_image) {
                    $this->platModel->ajouterImageSecondaire($plat_id, $secondary_image);
                }
                $this->pdo->commit();
                header('Location: index.php?page=plats&message=Plat modifié avec succès.');
                exit;
            } catch (Exception $e) {
                $this->pdo->rollBack();
                // Supprimer les fichiers téléversés en cas d'erreur
                if ($image_path !== $platInfo['image'] && file_exists($upload_dir . $image_path)) {
                    unlink($upload_dir . $image_path);
                }
                foreach ($secondary_image_paths as $secondary_image) {
                    if (file_exists($upload_dir . $secondary_image)) {
                        unlink($upload_dir . $secondary_image);
                    }
                }
                $errors[] = "Erreur lors de la modification : " . $e->getMessage();
            }
        }

        if (!empty($errors)) {
            $_SESSION['error'] = "Erreurs : " . implode(", ", $errors);
        }
    }

    require_once BASE_PATH . 'view/admin/plat_edit.php';
}
}
?>
