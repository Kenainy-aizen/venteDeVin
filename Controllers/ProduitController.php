<?php
require_once __DIR__ . '/../Models/Produit.php';
require_once __DIR__ . '/../config/db.php';

class ProduitController {
    private $model;

    public function __construct() {
        $db = new Database();
        $this->model = new Produit($db->getConnection());
    }

    public function index() {
        $produit = $this->model->read();
        include __DIR__ . '/../Views/produit/read.php';

    }

    public function create() {

        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            return;
        } 
        if (!isset($_POST['design']) || !isset($_POST['prix_consommateur']) 
        || !isset($_POST['prix_gros']) || !isset($_POST['prix_detaillant']) 
        || !isset($_POST['nombre'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Tous les champs doivent être remplis']);
            return;
        }
        $nombre = $_POST['nombre'];
        $design = $_POST['design'];
        $prix_detaillant = $_POST['prix_detaillant'];
        $prix_gros = $_POST['prix_gros'];
        $prix_consommateur = $_POST['prix_consommateur'];
    
        $result = $this->model->verification($design);
        
        if (count($result) > 0) {
            http_response_code(409); // Conflict
            echo json_encode(['success' => false, 'message' => 'Ce produit existe déjà']);
            return;
        }
        try {
            $trueProd = $this->model->generateNumber();
            $this->model->create($trueProd, $design, $prix_detaillant, $prix_consommateur, $prix_gros, $nombre);
            echo json_encode([
                'success' => true,
                'message' => 'Produit ajouté avec succès',
                'data' => [
                    'code' => $trueProd,
                    'designation' => $design,
                    'prix' => $prix_detaillant
                ]
            ]);
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la création: ' . $e->getMessage()]);
        }
    }

    public function update($num_produit) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $num_produit;
            $design = $_POST['design1'];
            $prix_detaillant = $_POST['prix_detaillant1'];
            $prix_consommateur = $_POST['prix_consommateur1'];
            $prix_gros = $_POST['prix_gros1'];
            $nombre = $_POST['nombre1'];

            $ok = $this->model->update( $num_produit, $design, $prix_gros, $prix_consommateur, $prix_detaillant, $nombre ); 
            if ($ok) { 
                header('Location: index.php?entity=produit&success=1'); 
                exit; 
            } else { 
                header('Location: index.php?entity=produit&error=1'); 
                exit; 
            } 
        }
    }
    
            

    public function delete($num_produit) {
    header('Content-Type: application/json');

    try {
        if (!$num_produit) {
            throw new Exception("ID du produit manquant");
        }

        $result = $this->model->delete($num_produit);

        if (!$result) {
            throw new Exception("Échec de la suppression en base de données");
        }

        echo json_encode([
            'success' => true
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}


    public function rechercher() {

        $nomProduit = $_POST['design'];
        $produit = $this->model->rechercher($nomProduit);    
        include __DIR__ . '/../Views/produit/read.php';

    }
}   

?>