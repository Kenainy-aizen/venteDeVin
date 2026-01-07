<?php

require_once __DIR__ . '/../Models/Client.php';
require_once __DIR__ . '/../config/db.php';

class ClientController {
    private $model;

    public function __construct(){
        $db = new Database();
        $this->model = new Client($db->getConnection());
    }

    public function index() {
        $client = $this->model->read();
        include __DIR__ . '/../Views/client/read.php';
    }

    public function delete($num_client){

        if($num_client){
            $this->model->delete($num_client);
            echo json_encode(['success' => true]);          
        } else {
            echo json_encode(['success' => false]);
        }

    }

    public function create() {
       // header('Content-Type: application/json');

        // if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        //     http_response_code(405); // Method Not Allowed
        //     echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
           
        // }

        //  if (!isset($_POST['design']) || !isset($_POST['prix_consommateur']) || !isset($_POST['prix_gros']) || !isset($_POST['prix_detaillant']) || !isset($_POST['nombre'])) {
        //     http_response_code(400); // Bad Request
        //     echo json_encode(['success' => false, 'message' => 'Tous les champs doivent être remplis']);
        //     return;
        // }
       
        $nom_client = $_POST['nom_client'];
        $adresse_client = $_POST['adresse'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $type = $_POST['type_client'];

       // try{
            $num_client = $this->model->numGenerer();
            $this->model->create($num_client, $nom_client, $type, $adresse_client, $telephone, $email);
            // echo json_encode(['success' => true]);
        // }catch (Exception $e) {
        //     echo json_encode(['success' => false]);
        // }
           header('Location: index.php?entity=client');
        
    }

    public function update($num_client) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $adresse = $_POST['adresse1'];
            $nom_client = $_POST['nom_client1'];
            $telephone = $_POST['telephone1'];
            $email = $_POST['email1'];
            $type = $_POST['type_client1'];

            $this->model->update($num_client,$nom_client,$type,$adresse,$telephone,$email);
            header('Location: index.php?entity=client');
        }
    }

     
}   
?>