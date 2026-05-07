<?php

class Produit
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // creer un medicament

    public function create(
        $num_produit,
        $design,
        $prix_consommateur,
        $prix_detaillant,
        $prix_gros,
        $nombre,
    ) {
        $query =
            "INSERT INTO PRODUIT (num_produit, design, prix_detaillant, prix_consommateur, prix_gros, nombre) VALUES (:num_produit, :design, :prix_detaillant, :prix_consommateur, :prix_gros, :nombre)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":num_produit", $num_produit);
        $stmt->bindParam(":design", $design);
        $stmt->bindParam(":prix_detaillant", $prix_detaillant);
        $stmt->bindParam(":prix_consommateur", $prix_consommateur);
        $stmt->bindParam(":prix_gros", $prix_gros);
        $stmt->bindParam(":nombre", $nombre);
        return $stmt->execute();
    }

    public function read()
    {
        $query = "SELECT * FROM PRODUIT ORDER BY num_produit ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(
        $num_produit,
        $design,
        $prix_gros,
        $prix_consommateur,
        $prix_detaillant,
        $nombre,
    ) {
        $query =
            "UPDATE PRODUIT SET design = :design, prix_detaillant = :prix_detaillant, prix_gros = :prix_gros, prix_consommateur = :prix_consommateur, nombre = :nombre WHERE num_produit = :num_produit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":design", $design);
        $stmt->bindParam(":prix_consommateur", $prix_consommateur);
        $stmt->bindPAram(":prix_gros", $prix_gros);
        $stmt->bindParam(":prix_detaillant", $prix_detaillant);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":num_produit", $num_produit);
        return $stmt->execute();
    }

    public function delete($num_produit)
    {
        try {
            // 🔐 Démarrer la transaction
            $this->conn->beginTransaction();

            // 1️⃣ Supprimer le produit
            $queryProduit =
                "DELETE FROM PRODUIT WHERE num_produit = :num_produit";
            $stmtProduit = $this->conn->prepare($queryProduit);
            $stmtProduit->bindParam(":num_produit", $num_produit);
            $stmtProduit->execute();

            // 2️⃣ Supprimer les COMMANDES sans lignes
            $queryCommande = "
                    DELETE FROM COMMANDE
                    WHERE num_bon_commande NOT IN (
                        SELECT DISTINCT num_commande FROM LIGNE_COMMANDE
                    )
                ";
            $this->conn->exec($queryCommande);

            // 3️⃣ Supprimer les FACTURES sans lignes
            $queryFacture = "
                    DELETE FROM FACTURE
                    WHERE num_facture NOT IN (
                        SELECT DISTINCT num_facture FROM LIGNE_FACTURE
                    )
                ";
            $this->conn->exec($queryFacture);

            // ✅ Tout est OK
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            // ❌ Erreur → rollback
            $this->conn->rollBack();
            throw $e; // laisse le contrôleur gérer l'erreur
        }
    }

    public function generateNumber()
    {
        $query =
            "SELECT num_produit FROM PRODUIT ORDER BY num_produit DESC LIMIT 1";
        $stmt = $this->conn->query($query);
        if ($stmt && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $lastNumMedoc = $row["num_produit"];
            $lastNumber = intval(substr($lastNumMedoc, 4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $newNumMedoc = "PRO-" . str_pad($newNumber, 3, "0", STR_PAD_LEFT);

        return $newNumMedoc;
    }

    public function verification($design)
    {
        $query = "SELECT * FROM PRODUIT WHERE design = :design";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":design", $design);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    public function rechercher($nomProduit)
    {
        $query = "SELECT * FROM PRODUIT WHERE design LIKE :design ";
        $stmt = $this->conn->prepare($query);
        $keyword = "%$nomProduit%";
        $stmt->bindParam(":design", $keyword);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
