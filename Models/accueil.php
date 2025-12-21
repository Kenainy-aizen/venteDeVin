
<?php
class Accueil {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;       
    }

    public function nombreFactureMois() {
        $query = " 
            SELECT COUNT(*) AS nb 
            FROM FACTURE 
            WHERE MONTH(date_facture) = MONTH(CURDATE())
            AND YEAR(date_facture) = YEAR(CURDATE())";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function recetteTotal() {
        $query = "
            SELECT 
            SUM(montant_total) as recette 
            FROM FACTURE
           ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function totalReg() {
        $query = "
            SELECT 
            SUM(montant_reglement) as total 
            FROM REGLEMENT
           ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function totalRecettePaye() {
        $recettes = $this->recetteTotal();
        $UnRecette = $recettes['recette'] ?? 0;

        $regs = $this->totalReg();
        $UnReg = $regs['total'] ?? 0;

        return $UnRecette - $UnReg;
    }

    public function nbBoutVenduMois() {
        $query = "
            SELECT 
            SUM(L.quantite) as nb 
            FROM LIGNE_FACTURE L
            JOIN FACTURE F 
            ON L.num_facture = F.num_facture
            WHERE MONTH(F.date_facture) = MONTH(CURDATE())
            AND YEAR(F.date_facture) = YEAR(CURDATE())";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $bout = $stmt->fetch(PDO::FETCH_ASSOC);

        $result = $bout['nb'] ?? 0;
        return $result;
    }

    public function stock() {
        $query = "SELECT SUM(nombre) as nb FROM PRODUIT";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function repartition() {
        $query = "
            SELECT 
            C.type_client AS type_client,
            SUM(F.montant_total) AS total_recette
            FROM FACTURE F
            JOIN CLIENT C ON F.num_client = C.num_client
            WHERE MONTH(F.date_facture) = MONTH(CURDATE())
            AND YEAR(F.date_facture) = YEAR(CURDATE())
            GROUP BY C.type_client
            ORDER BY total_recette DESC ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function paiement() {
        $query = "
            SELECT 
            mode_paiement,
            SUM(montant_reglement) AS total_paye
            FROM REGLEMENT
            WHERE MONTH(date_reglement) = MONTH(CURDATE())
            AND YEAR(date_reglement) = YEAR(CURDATE())
            GROUP BY mode_paiement
            ORDER BY total_paye DESC;
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function recetteMois() {

        $this->conn->exec("SET lc_time_names = 'fr_FR'");

         $query = "
              WITH mois_periode AS (
                  SELECT DATE_FORMAT(DATE_SUB(LAST_DAY(CURDATE()), INTERVAL n MONTH), '%Y-%m-01') AS mois_debut
                  FROM (
                      SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
                      UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7
                      UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11
                  ) AS nb
              )
              SELECT 
                  DATE_FORMAT(m.mois_debut, '%M %Y') AS mois_fr,
                  IFNULL(SUM(f.montant_total), 0) AS recette_totale
              FROM mois_periode m
              LEFT JOIN FACTURE f
                  ON DATE_FORMAT(f.date_facture, '%Y-%m') = DATE_FORMAT(m.mois_debut, '%Y-%m')
              GROUP BY m.mois_debut
              ORDER BY m.mois_debut
          ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function top5() {
        $query1 = "
                        SELECT 
                            P.design, 
                            IFNULL(SUM(L.quantite),0) AS 
                        total_achete
                        FROM PRODUIT P
                        LEFT JOIN LIGNE_FACTURE L ON
                        P.num_produit = L.num_produit
                        GROUP BY P.num_produit, P.design
                        ORDER BY total_achete DESC;
            ";

        $stmt1 = $this->conn->prepare($query1);
        $stmt1->execute();
        return $stmt1->fetchAll(PDO::FETCH_ASSOC);

    }


    public function listePasRegle() {
        $query = "
                 SELECT 
                    c.num_client,
                    c.nom_client,
                    c.email_client,
                    c.adresse_client,
                    f.num_facture,
                    f.montant_total,
                    COALESCE(SUM(r.montant_reglement), 0) AS montant_paye,
                    (f.montant_total - COALESCE(SUM(r.montant_reglement), 0)) AS montant_restant
                FROM 
                    CLIENT c
                JOIN 
                    FACTURE f ON c.num_client = f.num_client
                LEFT JOIN 
                    REGLEMENT r ON f.num_facture = r.num_facture
                GROUP BY 
                    c.num_client, c.nom_client, c.email_client, c.adresse_client, f.num_facture, f.montant_total
                HAVING 
                    montant_restant > 0
                ORDER BY 
                    montant_restant DESC;

                ";


        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>