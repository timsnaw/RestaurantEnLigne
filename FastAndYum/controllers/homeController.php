<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__ . '/../../');
}

// Inclusion des fichiers nécessaires
require_once BASE_PATH . 'config/connexion.php';
require_once BASE_PATH . 'models/homeModel.php';

class ControllerHome {
    private $model;

    public function __construct($pdo) {
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
            case 'Apropos':
                $this->Apropos();
                break;
            case 'contact':
                $this->contact();
                break;
            case 'details':
                $this->detailsProduct();
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
    public function contact(){
        $categories = $this->model->getCategories();
        $avis = $this->model->getAvis();


        $data = [
            'categories' => $categories,
            'avis' => $avis
        ];

        require_once 'view/contact.php';
    }
    public function Apropos(){
        $categories = $this->model->getCategories();
        $avis = $this->model->getAvis();


        $data = [
            'categories' => $categories,
            'avis' => $avis
        ];

        require_once 'view/Apropos.php';
    }
public function detailsProduct() {
    if (!isset($_GET['plat_id'])) {
        header('Location: index.php?page=menu&error=Identifiant du produit manquant');
        exit;
    }

    $plat_id = (int)$_GET['plat_id'];
    $product = $this->model->getPlatParId([$plat_id]); // Pass as array for compatibility
    if (empty($product)) {
        header('Location: index.php?page=menu&error=Produit introuvable');
        exit;
    }
    $product = $product[0]; // Extraire le produit
    $categories = $this->model->getCategories();

    // Obtenir la catégorie
    $categorie = $this->model->getCategorieParId($product['categorie_id']);
    // Obtenir les avis
    $avis = $this->model->getAvis();
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




     // panier
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

    // ajouter panier
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
}
?>