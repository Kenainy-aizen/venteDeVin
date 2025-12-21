<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../Models/accueil.php';

class AcceuilController {
    private $model;

    public function __construct() {
        $db = new Database;
        $this->model = new accueil($db->getConnection());

    } 

    public function index() {
        $nbFac = $this->model->nombreFactureMois();
        $recetteTotal = $this->model->recetteTotal();
        $totalReg = $this->model->totalReg();
        $totalPaye = $this->model->totalRecettePaye();
        $totalBout = $this->model->nbBoutVenduMois();
        $stock = $this->model->stock();
        $type = $this->model->paiement();
        $repartition = $this->model->repartition();
        $result = $this->model->recetteMois();
        $result1 = $this->model->top5(); 
        $clients = $this->model->listePasRegle();
        include __DIR__ . '/../Views/acceuil/read.php';
    }

    
} 
?>