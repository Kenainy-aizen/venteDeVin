<?php
    require_once __DIR__ . '/../config/db.php';
    require_once __DIR__ . '/../Models/Command.php';

    class CommandController {

        private $model;

        public function __construct() {

            $db = new Database();
            $this->model = new Command($db->getConnection());

        }

        public function index() {

            $command = $this->model->read();
            include __DIR__ . '/../Views/command/read.php';

        }

        public function delete($num_bon_commande) {              
                if($num_bon_commande) {
                    $this->model->deleteLCMD($num_bon_commande);
                    $this->model->deleteCMD($num_bon_commande);
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false]);
                }                        
        }

         public function update($num_bon_commande) {

           if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $date = $_POST['date_cmd'];
                $statut = $_POST['statut'];
                $nom = $_POST['nom_client'];

                $num = $this->model->nomClientTonumClient($nom);
                
                $this->model->updateCMD($num_bon_commande,$num[0]['num_client'],$date,$statut);
                header('Location: index.php?entity=command&action=index');

           }
            
        }

        public function create() {

            if($_SERVER['REQUEST_METHOD'] === 'POST' ) {

                if(isset($_POST['nouvelleFacture'])) {

                    unset($_SESSION['num_bon_command']);
                    header('Location: index.php?entity=command&action=create');

                } elseif(isset($_POST['valider'])) {
                    
                    if(!isset($_SESSION['num_bon_command'])){

                        $_SESSION['num_bon_command'] = $this->model->genererNumber();

                    }

                    $num_bon = $_SESSION['num_bon_command'];

                    if(isset($_POST['quantite'],$_POST['nom_client'],$_POST['design'])) {

                        $quantite = $_POST['quantite'];

                        $nomClient = $_POST['nom_client'];
                        $numClient = $this->model->nomClientTonumClient($nomClient);

                        $design = $_POST['design'];
                        $num_produit = $this->model->designTonumProduit($design);
                        echo $num_produit[0]['num_produit'];
                        $date = $_POST['date_cmd'];
                        echo $design;

                        $status = "En attente";

                        $result = $this->model->verification($num_bon);

                        if(count($result) == 0) {
                            $this->model->createCMD($num_bon,$date,$status,$numClient[0]['num_client']);
                        }

                        $this->model->createLCMD($num_bon,$num_produit[0]['num_produit'],$quantite);
                        header('Location: index.php?entity=command&action=create');


                    }

                } elseif(isset($_POST['genererPdf'])) {
                    $this->model->genererPdf($_SESSION['num_bon_command']);
                }
            } 
             else {
                include __DIR__ . '/../Views1/command/create.php';
            }
        
            
        }

        public function CreatePdf($num_reg) {
            $this->model->genererPdf($num_reg);

        }

    }
?>