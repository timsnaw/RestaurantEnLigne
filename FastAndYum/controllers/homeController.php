<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

// Inclusion des fichiers nécessaires
require_once BASE_PATH . 'config/connexion.php';
require_once BASE_PATH . 'models/homeModel.php';

class ControllerHome {
    private $pdo; 
    private $model;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->model = new ModelHome($pdo);
    }

    public function gererDemande($page) {
        switch ($page) {
            case 'promotions':
                $this->promotions();
                break;
            case 'menu':
                $this->menu();
                break;
            case 'home':
                $this->categorie();
                break;
            case 'apropos':
                $this->apropos();
                break;
            case 'contact':
                $this->contact();
                break;
            case 'search':
                $this->search();
                break;
            case 'details':
                $action = isset($_GET['action']) ? $_GET['action'] : null;
                if ($action === 'add_comment') {
                    $this->addComment();
                } elseif ($action === 'delete_comment') {
                    $this->deleteComment();
                } else {
                    $this->detailsProduct();
                }
                break;
            case 'panier':
                $action = isset($_GET['action']) ? $_GET['action'] : null;                
                if ($action === 'ajoute') {
                    $this->ajoute();
                } elseif ($action === 'modifier') {
                    $this->modifier();
                } elseif ($action === 'supprimer') {
                    $this->supprimer();
                } else {
                    $this->panier();
                }
                break;
            default:
                include BASE_PATH . 'view/home.php';
                break;
        }
    }


    //permet d'ajouter un commentaire et afficher un message si il y a une error ou non
    public function addComment() {

        ob_start();
        header('Content-Type: application/json; charset=utf-8');
        $response = ['success' => false, 'message' => 'Erreur inconnue'];

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $response['message'] = 'Méthode non autorisée';
                echo json_encode($response);
                exit;
            }

            if (!isset($_SESSION['user_id'])) {
                $response['message'] = 'Vous devez être connecté en tant que client';
                echo json_encode($response);
                exit;
            }

            $csrf_token = $_POST['csrf_token'] ?? '';
            if ($csrf_token !== ($_SESSION['csrf_token'] ?? '')) {
                $response['message'] = 'Jeton CSRF invalide';
                echo json_encode($response);
                exit;
            }

            $plat_id = isset($_GET['plat_id']) ? (int)$_GET['plat_id'] : 0;
            $user_id = (int)$_SESSION['user_id'];
            $commentaire = isset($_POST['commentaire']) ? trim($_POST['commentaire']) : '';
            $note = isset($_POST['note']) ? (int)$_POST['note'] : 0;


            if ($plat_id <= 0) {
                $response['message'] = 'ID du plat invalide';
                echo json_encode($response);
                exit;
            }

            if (empty($commentaire)) {
                $response['message'] = 'Le commentaire ne peut pas être vide';
                echo json_encode($response);
                exit;
            }

            if ($note < 0 || $note > 5) {
                $response['message'] = 'Note invalide (doit être entre 0 et 5)';
                echo json_encode($response);
                exit;
            }

            
            $user = $this->model->getUserInfo($user_id);

            if (!$user) {
                $response['message'] = 'Utilisateur introuvable';
                echo json_encode($response);
                exit;
            }

            $success = $this->model->addAvis($user_id, $plat_id, $commentaire, $note);
            if ($success) {
                $response = [
                    'success' => true,
                    'message' => 'Avis ajouté avec succès',
                    'comment' => [
                        'avis_id' => $this->pdo->lastInsertId(),
                        'commentaire' => htmlspecialchars($commentaire),
                        'note' => $note,
                        'date_avis' => date('Y-m-d H:i:s'),
                        'prenom' => htmlspecialchars($user['prenom'] ?? 'Utilisateur'),
                        'nom' => htmlspecialchars($user['nom'] ?? ''),
                        'image_client' => htmlspecialchars($user['image_client'] ?? 'default_user.png'),
                        'user_id' => $user_id
                    ]
                ];
            } else {
                $response['message'] = 'Erreur lors de l\'ajout de l\'avis';
            }
        } catch (Exception $e) {
            $response['message'] = 'Erreur serveur';
        }

        ob_end_clean();
        echo json_encode($response);
        exit;
    }

    //permet de rechercher d'un plat par son nom 
    public function search() {
        if (isset($_GET['q'])) {
            $query = trim($_GET['q']);
            $results = $this->model->searchPlats($query);
            header('Content-Type: application/json');
            echo json_encode($results);
            exit;
        }
        header('Content-Type: application/json');
        echo json_encode([]);
        exit;
    }

    // permet d'obtenir les categorie et les avis
    public function categorie() {
        $categories = $this->model->getCategories();
        $avis = $this->model->getAvis();


        $data = [
            'categories' => $categories,
            'avis' => $avis
        ];

        require_once 'view/home.php';
    }

    // Menu page action
    public function menu() {
        $categories = $this->model->getCategories();
        $avis = $this->model->getAvis();

        $categorie_data = [];
        foreach ($categories as $categorie) {
            $plats = $this->model->getPlatParCategorie($categorie['categorie_id']);
            foreach ($plats as &$plat) {
                $plat['average_rating'] = $this->model->getNote($plat['plat_id']);
            }
            $categorie_data[$categorie['categorie_id']] = [
                'nom_categorie' => $categorie['nom_categorie'],
                'plats' => $plats
            ];
        }

        $data = [
            'categories' => $categories,
            'categorie_data' => $categorie_data,
            'avis' => $avis

        ];
        require_once BASE_PATH . 'view/menu.php';
    }

    // permet d'obtenir les plat avec promotion
    public function promotions() {
        $products = $this->model->getPromotedProducts();
        $categories = $this->model->getCategories();
        $avis = $this->model->getAvis();

        foreach ($products as &$product) {
            $product['average_rating'] = $this->model->getNote($product['plat_id']);
        }

        $data = [
            'products' => $products,
            'categories' => $categories,
            'avis' => $avis
        ];

        require_once BASE_PATH . 'view/promotions.php';
    }

    //permet d'ajouter les categorie et avis dans le header menu 
    public function contact(){
        $categories = $this->model->getCategories();
        $avis = $this->model->getAvis();


        $data = [
            'categories' => $categories,
            'avis' => $avis
        ];

        require_once 'view/contact.php';
    }

    //permet d'ajouter les categorie et avis dans le header menu et dans la page apropos 
    public function apropos(){
        $categories = $this->model->getCategories();
        $avis = $this->model->getAvis();


        $data = [
            'categories' => $categories,
            'avis' => $avis
        ];

        require_once 'view/apropos.php';
    }

    // permet d'obtenir tou les nformation d'une plats
    public function detailsProduct() {
        if (!isset($_GET['plat_id'])) {
            header('Location: index.php?page=menu&error=Identifiant du produit manquant');
            exit;
        }

        $plat_id = (int)$_GET['plat_id'];
        $product = $this->model->getPlatParId([$plat_id]);
        if (empty($product)) {
            header('Location: index.php?page=menu&error=Produit introuvable');
            exit;
        }
        $product = $product[0]; 
        $categories = $this->model->getCategories();

        // Obtenir la catégorie
        $categorie = $this->model->getCategorieParId($product['categorie_id']);
        // Obtenir les avis
        $avis = $this->model->getAvisParId($plat_id);
        // Obtenir la note moyenne
        $average_rating = $this->model->getNote($plat_id);

        $data = [
            'product' => $product,
            'categories' => $categories,
            'categorie' => $categorie,
            'avis' => $avis,
            'average_rating' => $average_rating
        ];

        require_once BASE_PATH . 'view/detailsProduct.php';
    }



     // permet d'ajouter les plats a panier
    public function panier() {
        $panierItems = [];
        $total = 0;

        if (!empty($_SESSION['panier'])) {
            $platIds = array_keys($_SESSION['panier']);
            $products = $this->model->getPlatParId($platIds);
            foreach ($products as $product) {
                $quantite = $_SESSION['panier'][$product['plat_id']];
                $price = !empty($product['taux_reduction']) 
                    ? $product['prix'] * (1 - $product['taux_reduction'] / 100)
                    : $product['prix'];
                $subtotal = $price * $quantite;
                $total += $subtotal;
                $panierItems[] = [
                    'plat_id' => $product['plat_id'],
                    'titre' => $product['titre'],
                    'description' => $product['description'],
                    'image' => $product['image'],
                    'prix' => $price,
                    'quantite' => $quantite,
                    'subtotal' => $subtotal
                ];
            }
        }
        $categories = $this->model->getCategories();

        $data = [
            'panierItems' => $panierItems,
            'total' => $total,
            'success' => isset($_GET['success']) ? $_GET['success'] : null,
            'categories' => $categories,
        ];

        require_once BASE_PATH . 'view/panier.php';
    }

    // permet d'ajouter panier
    public function ajoute() {
        if (isset($_GET['plat_id']) || isset($_POST['plat_id'])) {
            if(isset($_GET['plat_id']) ){
            $plat_id = (int)$_GET['plat_id'];
            $quantite = 1;
        }else{
            $plat_id = (int)$_POST['plat_id'];
            $quantite = (int)$_POST['quantite'];
        }

            if ($plat_id > 0 && $quantite > 0) {
                if (!isset($_SESSION['panier'])) {
                    $_SESSION['panier'] = [];
                }

                if (isset($_SESSION['panier'][$plat_id])) {
                    $_SESSION['panier'][$plat_id] += $quantite;
                } else {
                    $_SESSION['panier'][$plat_id] = $quantite;
                }

                header('Location: index.php?page=panier&success=plat ajoute  panier');
                exit;
            }
        }

        header('Location: index.php?page=menu');
        exit;
    }

    // modifier panier quantities
    public function modifier() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $plat_id => $quantite) {
                $plat_id = (int)$plat_id;
                $quantite = (int)$quantite;
                if ($plat_id > 0) {
                    if ($quantite > 0) {
                        $_SESSION['panier'][$plat_id] = $quantite;
                    } else {
                        unset($_SESSION['panier'][$plat_id]);
                    }
                }
            }
            header('Location: index.php?page=panier&success=panier modifier');
            exit;
        }
        header('Location: index.php?page=panier');
        exit;
    }

    // supprimer palt dans panier
    public function supprimer() {
        if (isset($_GET['plat_id'])) {
            $plat_id = (int)$_GET['plat_id'];
            if (isset($_SESSION['panier'][$plat_id])) {
                unset($_SESSION['panier'][$plat_id]);
            }
            header('Location: index.php?page=panier&success=plat supprimer');
            exit;
        }
        header('Location: index.php?page=panier');
        exit;
    }


    // permet de supprimer les commentaire 
    public function deleteComment() {
        header('Content-Type: application/json; charset=utf-8');
        $response = ['success' => false, 'message' => 'Erreur inconnue'];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            $response['message'] = 'Vous devez être connecté en tant que client';
            echo json_encode($response);
            exit;
        }

        $plat_id = (int)($_GET['plat_id'] ?? 0);
        $avis_id = (int)($_GET['avis_id'] ?? 0);
        $user_id = (int)$_SESSION['user_id'];
        $csrf_token = $_POST['csrf_token'] ?? '';

        if ($plat_id <= 0 || $avis_id <= 0) {
            $response['message'] = 'ID du plat ou de l\'avis invalide';
            echo json_encode($response);
            exit;
        }

        if ($csrf_token !== ($_SESSION['csrf_token'] ?? '')) {
            $response['message'] = 'Invalid CSRF token';
            echo json_encode($response);
            exit;
        }

        try {
            $success = $this->model->deleteAvis($avis_id, $user_id);
            if ($success) {
                $response = [
                    'success' => true,
                    'message' => 'Avis supprimé avec succès',
                    'avis_id' => $avis_id
                ];
            } else {
                $response['message'] = 'Erreur lors de la suppression de l\'avis';
            }
        } catch (Exception $e) {
            error_log("Erreur dans deleteComment: " . $e->getMessage());
            $response['message'] = 'Erreur serveur: ' . $e->getMessage();
        }

        echo json_encode($response);
        exit;
    }

   
}
?>