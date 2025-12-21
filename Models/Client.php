<?php
    class Client {

        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        public function read(){
            $query = "SELECT * FROM CLIENT";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);           
        }

        public function delete($num_client){
            $query = "DELETE FROM CLIENT WHERE num_client = :num_client";
            $stmt = $this->conn->prepare($query);
            $stmt->bindparam(':num_client',$num_client);
            return $stmt->execute();
        }

        public function create($num_client, $nom_client, $type_client, $adresse_client, $telephone_client, $email_client){
            $query = "INSERT INTO CLIENT (num_client, nom_client, type_client, adresse_client, telephone_client, email_client ) VALUES (:num_client, :nom_client, :type_client, :adresse_client, :telephone_client, :email_client)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nom_client',$nom_client);
            $stmt->bindParam(':type_client',$type_client);
            $stmt->bindParam(':adresse_client',$adresse_client);
            $stmt->bindParam(':telephone_client',$telephone_client);
            $stmt->bindParam(':email_client',$email_client);
            $stmt->bindParam(':num_client',$num_client);
            return $stmt->execute();
        }

        public function numGenerer(){
            $query="SELECT num_client FROM CLIENT ORDER BY num_client DESC LIMIT 1";
            $stmt = $this->conn->query($query);

            if($stmt && $stmt->rowCount()>0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $lastnum_client = $row['num_client'];
                $lastnum = intval(substr($lastnum_client,4));
                $newnumber = $lastnum + 1;
            } else {
                $newnumber = 1;
            }

            $new_num_client = "CLI-" . str_pad($newnumber ,3,"0",STR_PAD_LEFT);

            return $new_num_client;

        }

        public function update($num_client, $nom_client, $type_client, $adresse_client, $telephone_client, $email_client) {
            $query = "UPDATE CLIENT SET nom_client = :nom_client, adresse_client = :adresse_client, type_client = :type_client, telephone_client = :telephone_client, email_client = :email_client WHERE num_client = :num_client";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':num_client',$num_client);
            $stmt->bindParam(':adresse_client',$adresse_client);
            $stmt->bindParam(':nom_client',$nom_client);
            $stmt->bindParam(':type_client',$type_client);
            $stmt->bindParam(':telephone_client',$telephone_client);
            $stmt->bindParam(':email_client',$email_client);

            return $stmt->execute();
        }
        

        

    }



?>