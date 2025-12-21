<?php
    require_once __DIR__ . "/../config/db.php";
    require_once __DIR__ . "/../Models/Reglement.php";
    
    class ReglementController {
        private $model;

        public function __construct(){
            $db = new Database();           
            $this->model = new Reglement($db->getConnection());
        }

        public function index(){
            $reglement = $this->model->read();
           // $reste = $this->model->soustraction();
            include __DIR__ . '/../Views/reglement/read.php';
        }

        public function create(){

           header('Content-Type: application/json');

            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                http_response_code(405); // methode non autorise
                echo json_encode(['success' => false, 'message' => 'Methode non autorise']);
                return;
            } 

            if(!isset($_POST['date']) || !isset($_POST['montant']) || !isset($_POST['mode_paye']) || !isset($_POST['num_facture'])) {
                http_response_code(400); // bad request
                echo json_encode(['success' => false, 'message' => 'Remplir tout le champ']);
                return;
            }

            $date = $_POST['date'];
            $montant = $_POST['montant'];
            $num_facture = $_POST['num_facture'];
            $mode_pay = $_POST['mode_paye'];
            $nom = $_POST['nom'];

            try {
                $num_reg = $this->model->genererNumber();
                $this->model->create($num_reg,$num_facture,$date,$mode_pay,$montant,$nom);
                echo json_encode([
                    'success' => true,
                    'message' => 'Reglement ajoute avec succes',
                    'data' => [
                        'date_reglement' => $date,
                        'montant_reglement' => $montant,
                        'mode_paiement' => $mode_pay,
                        'num_facture' => $num_facture,
                    ]
                ]);
            }
            catch(Exception $e) {
                http_response_code(500); // internal server error
                echo json_encode(['success' => false, 'message' => 'Erreur de la creation'. $e->getMessage()]);
            }

        }

        public function delete($num_reglement){
            if($num_reglement){
                $this->model->delete($num_reglement);
                echo json_encode(['success' => true]);
            }
            else {
                echo json_encode(['success' => false]);
            }

        }

        public function update($num_reglement){
            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                $date = $_POST['date_reglement'];
                $montant = $_POST['montant_reglement'];
                $mode = $_POST['mode_paiement'];
                $num_facture = $_POST['num_facture'];
                $nom_client = $_POST['nom_client'];

                $this->model->update($num_reglement, $num_facture, $date, $mode, $montant, $nom_client);
                header('Location: index.php?entity=reglement');

            }
        }

        public function CreatePdf() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $selected = $_POST['selected_reglements'];
                $this->model->genererPdf($selected) ;
            }
        }
    }

?>