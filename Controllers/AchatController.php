<?php 

require_once __DIR__ . '/../Models/Achat.php';
require_once __DIR__ . '/../config/db.php';

    class AchatController {
        private $model;

        public function __construct() {
            $db = new Database;
            $this->model = new Achat($db->getConnection());
        }

        public function index() {
            $achat = $this->model->read();
            include __DIR__ . '/../Views/achat/read.php';
        }


        public function create() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['nouvelleFacture'])) {
                    // Réinitialiser la facture
                    unset($_SESSION['numAchat']);
                    header('Location: index.php?entity=achat&action=create');
                } elseif (isset($_POST['valider'])) {

                    if(!isset($_SESSION['numAchat'])) {
                        $_SESSION['numAchat'] = $this->model->generateNumber(); 
                    }
                        $trueAchat = $_SESSION['numAchat'];

                        print_r($_POST);

                        echo $_POST['nom_produit'];

                        echo "la valeur de trueAchat ". $trueAchat;
                    if(isset($_POST['nomClient'],$_POST['nbr'],$_POST['dateAchat'])) {
                        $num_produit = $this->model->chercherNumParNomProduit($_POST['nom_produit']);
                      //  echo "la valeur de num_produit ".  $num_produit[0]['num_produit'];
                        $result = $this->model->soustraction($num_produit[0]['num_produit'],$_POST['nbr']);
                        echo $result;
                

                    if($result === true) {

                            $existe = $this->model->verification($trueAchat);
                           // echo $existe;
                            $num_client = $this->model->chercherNumParNomClient($_POST['nomClient']);
                            if(count($existe) == 0){
                                $this->model->createFacture($trueAchat,$_POST['dateAchat'],$num_client[0]['num_client']);
                            }
                            $this->model->createLigneFacture($trueAchat,$num_produit[0]['num_produit'],$_POST['nbr']);       
                                header('Location: index.php?entity=achat&action=create');

                    } else {
                            $_SESSION['error_message'] = $result['error'];
                            $_SESSION['stock_initial'] = $result['stock_initial'];
                            header('Location: index.php?entity=achat&action=create');
                    }    
                    
                  //    echo "la valeur de trueAchat"+$numAchat;
                    }
                 
                } 
                elseif(isset($_POST['genererPdf'])){

                    if(isset($_SESSION['numAchat'])) {
                    $this->model->genererPdf($_SESSION['numAchat']);
                    }

                }
                
                else {
                 
                    header('Location: index.php?entity=achat&action=create');

                } 
            } else {
                include __DIR__ . '/../Views/achat/create1.php';
            }
        
        }

        public function update($numAchat,$numMedoc1,$nbr1) {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $numAchat = $_GET['id'] ;
                $numMedoc1 = $_GET['param1'] ;
                $numMedoc = $_POST['numMedoc'];
                $nomClient = $_POST['nomClient'];
                $nbr = $_POST['nbr'];
                $dateAchat = $_POST['dateAchat'];

                $this->model->modSoustraction($numAchat,$numMedoc,$nbr,$numMedoc1,$nbr1);

                if($this->model->update($numAchat,$numMedoc,$nomClient,$nbr,$dateAchat,$numMedoc1,$nbr1)){
                    $this->model->read();
                    header('Location: index.php?entity=achat');
                  echo $numMedoc1;

                } else {
                    echo "erreur";
                }
                
            } else {
                include __DIR__ . '/../Views/achat/update.php';
            }
        }

        public function CreatePdf($numAchat){

            if($numAchat) {
             $this->model->genererPdf($numAchat);
            }
        }

        public function delete($numAchat) {
  
            if($numAchat) {
        
                $this->model->delete($numAchat);
                echo json_encode(['success' => true]);  

            } else {

                echo json_encode(['success' => false]);   

            }
        }    
        
        public function genererPdf($numAchat) {

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
                $this->model->genererPdf($numAchat);

            }
            
        }


        public function rechercher() {

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
               $nomClient = $_POST['inputRecherche'];
                $achat = $this->model->rechercher($nomClient);
                include __DIR__ . '/../Views/achat/read.php';
            
            }

        }

        public function entreDeuxDate() {
            
            $date1 = $_POST['date1'];
            $date2 = $_POST['date2'];
            $achat = $this->model->nonRegleEntreDeuxDate($date1,$date2);

            include __DIR__ . '/../Views1/achat/read.php';
        }

       public function ajaxProduits() {
        
            $search = $_GET['q'] ?? '';   
            $produits = $this->model->rechercherProduitsAjax($search);
        
            header('Content-Type: application/json');
            echo json_encode($produits);
            
        }


         

    }


       
?>