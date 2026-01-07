<?php

    class Produit {
        private $conn;

        public function __construct($db) {
            $this->conn = $db;
        }

        // creer un medicament

        public function create($num_produit, $design, $prix_consommateur, $prix_detaillant, $prix_gros, $nombre) {
            $query = "INSERT INTO PRODUIT (num_produit, design, prix_detaillant, prix_consommateur, prix_gros, nombre) VALUES (:num_produit, :design, :prix_detaillant, :prix_consommateur, :prix_gros, :nombre)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':num_produit', $num_produit);
            $stmt->bindParam(':design', $design);
            $stmt->bindParam(':prix_detaillant' , $prix_detaillant);
            $stmt->bindParam(':prix_consommateur', $prix_consommateur);
            $stmt->bindParam(':prix_gros',$prix_gros);
            $stmt->bindParam(':nombre', $nombre);
            return $stmt->execute();
        }

       

        public function read() {
            $query = "SELECT * FROM PRODUIT ORDER BY num_produit ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

      

        public function update($num_produit, $design, $prix_gros, $prix_consommateur, $prix_detaillant, $nombre) {        
            $query = "UPDATE PRODUIT SET design = :design, prix_detaillant = :prix_detaillant, prix_gros = :prix_gros, prix_consommateur = :prix_consommateur, nombre = :nombre WHERE num_produit = :num_produit";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':design', $design);
            $stmt->bindParam(':prix_consommateur', $prix_consommateur);
            $stmt->bindPAram(':prix_gros', $prix_gros);
            $stmt->bindParam(':prix_detaillant', $prix_detaillant);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':num_produit', $num_produit);
            return $stmt->execute();
        }

        public function delete($num_produit) {
            $query = "DELETE FROM PRODUIT WHERE num_produit = :num_produit";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':num_produit',$num_produit);
            return $stmt->execute();
        }

        public function readOne($numMedoc) {
            $query = "SELECT * FROM medicament WHERE numMedoc = :numMedoc";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':numMedoc',$numMedoc);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function generateNumber() {
            $query = "SELECT num_produit FROM PRODUIT ORDER BY num_produit DESC LIMIT 1";
            $stmt = $this->conn->query($query);
            if ($stmt && $stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $lastNumMedoc = $row['num_produit'];
                $lastNumber = intval(substr($lastNumMedoc,4));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $newNumMedoc = "PRO-" . str_pad($newNumber, 3, "0", STR_PAD_LEFT);

            return $newNumMedoc;
        }

        public function recherche($design) {

            $query = "SELECT * FROM medicament WHERE Design LIKE :design ORDER BY numMedoc ASC ";
            $stmt = $this->conn->prepare($query);
            $keyword = "%$design%";
            $stmt->bindParam(':design',$keyword);
            $stmt->execute();
            $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $resultats;
        }

        public function ruptureDeStock() {

            $query = "SELECT * FROM medicament WHERE stock < 5";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function recetteTotal() {
            
            $query = "SELECT m.prix_unitaire, a.nbr FROM achat a JOIN medicament m ON a.numMedoc = m.numMedoc" ;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $totalProduit = 0;
            
            //var_dump($result);
            foreach ($result as $row) {
                $totalProduit += $row['nbr'] * $row['prix_unitaire'] ;
            
            }

            return $totalProduit;
        }

        public function getTop5MedicamentsVendus() {
            // Requête SQL pour récupérer les médicaments les plus vendus
            $query = "
                SELECT m.Design, SUM(a.nbr) AS total_vendu
                FROM achat a
                JOIN medicament m ON a.numMedoc = m.numMedoc
                GROUP BY m.numMedoc
                ORDER BY total_vendu DESC
                LIMIT 5
            ";
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function verification($design) {
            $query = "SELECT * FROM PRODUIT WHERE design = :design";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':design',$design);
            $stmt->execute();
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        }

          public function rechercher($nomProduit) {
            $query = "SELECT * FROM PRODUIT WHERE nomClient LIKE :nomClient ";
            $stmt = $this->conn->prepare($query);
            $keyword = "%$nomProduit%";
            $stmt->bindParam(':nomClient',$keyword);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>