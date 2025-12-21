<?php
    class Command {

        private $conn;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = "SELECT C.nom_client, O.num_bon_commande, O.date_commande, O.statut FROM COMMANDE O JOIN CLIENT C ON O.num_client = C.num_client";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function readLCMD() {
            $query = "SELECT ";
        }

        public function createCMD($num_bon_commande,$date_commande,$status,$num_client) {
            $query = "INSERT INTO COMMANDE (num_bon_commande, date_commande, statut, num_client) VALUES (:num_bon_commande, :date_commande, :statut, :num_client)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':num_bon_commande',$num_bon_commande);
            $stmt->bindParam(':date_commande',$date_commande);
            $stmt->bindParam(':num_client',$num_client);
            $stmt->bindParam(':statut',$status);
            $stmt->bindParam(':num_client',$num_client);

            return $stmt->execute();
        }

        public function createLCMD($num_commande,$num_produit,$quantite) {
            $query = "INSERT INTO LIGNE_COMMANDE (num_commande, num_produit, quantite) VALUES (:num_commande, :num_produit, :quantite)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam('num_commande',$num_commande);
            $stmt->bindParam('num_produit',$num_produit);
            $stmt->bindParam('quantite',$quantite);

            return $stmt->execute();
        }

        public function updateCMD($num_bon_commande,$num_client,$date_commande,$status){
            $query = "UPDATE COMMANDE SET date_commande = :date_commande, statut = :status, num_client = :num_client WHERE num_bon_commande = :num_bon_commande";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':date_commande',$date_commande);
            $stmt->bindParam(':num_client',$num_client);
            $stmt->bindParam(':status',$status);
            $stmt->bindParam(':num_bon_commande',$num_bon_commande);

            return $stmt->execute();
        }

        public function deleteCMD($num_bon_commande){
            $query = "DELETE FROM COMMANDE WHERE num_bon_commande = :num_bon_commande";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':num_bon_commande',$num_bon_commande);
            
            return $stmt->execute();
        }

        public function deleteLCMD($num_bon_commande){
            $query = "DELETE FROM LIGNE_COMMANDE WHERE num_commande = :num_bon_commande";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam('num_bon_commande',$num_bon_commande);

            return $stmt->execute();
        }

        public function genererNumber() {
            $query = "SELECT num_bon_commande FROM COMMANDE ORDER BY num_bon_commande DESC LIMIT 1";
            $stmt = $this->conn->query($query);
            
            if($stmt && $stmt->rowCount() > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $num_bon = $row['num_bon_commande'];
                $numberNum = intval(substr($num_bon,4));
                $new_num = $numberNum + 1;
            } else {
                $new_num = 1;
            }

            $newNumber = "CMD-".str_pad($new_num,3,'0',STR_PAD_LEFT);

            return $newNumber;
        }

        public function verification($num_bon_commande) {
            $query = "SELECT num_bon_commande FROM COMMANDE WHERE num_bon_commande = :num_bon_commande";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':num_bon_commande',$num_bon_commande);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function designTonumProduit($design) {
            $query = "SELECT num_produit FROM PRODUIT WHERE design = :design";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':design',$design);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function nomClientTonumClient($nomClient) {
            $query = "SELECT num_client FROM CLIENT WHERE nom_client like :num_client";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':num_client',"%$nomClient%");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function afficherCommand($numAchat) {
                   $stmt1 = $this->conn->prepare("
                        SELECT C.type_client 
                        FROM COMMANDE F 
                        JOIN CLIENT C ON F.num_client = C.num_client 
                        WHERE F.num_bon_commande = ?              
                    ");
                    $stmt1->execute([$numAchat]);
                    $type = $stmt1->fetchColumn(); // plus simple que fetchAll()[0]

                    // On choisit la colonne de prix en fonction du type
                    switch ($type) {
                        case "Detaillant":
                            $colPrix = "prix_detaillant";
                            break;
                        case "Consommateur":
                            $colPrix = "prix_consommateur";
                            break;
                        default:
                            $colPrix = "prix_gros";
                            break;
                    }

                    // Requête unique avec substitution de colonne
                    $query = "
                        SELECT L.num_commande, P.design, P.$colPrix AS prix_unitaire, 
                            L.quantite, (P.$colPrix * L.quantite) AS total
                        FROM LIGNE_COMMANDE L
                        JOIN PRODUIT P ON P.num_produit = L.num_produit
                        WHERE L.num_commande = ?
                    ";

                    $stmt = $this->conn->prepare($query);
                    $stmt->execute([$numAchat]);
                    $achats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
            if (empty($achats)) {
               // return "<p>Aucun achat trouvé pour cette facture.</p>";
               //return true;
            }
        
            $facture = "<h2>$numAchat</h2>";
            $facture .= "<table>
                            <tr>
                                <th>PRODUIT</th>
                                <th>Prix Unitaire</th>
                                <th>Quantité</th>
                                <th>Total</th>
                            </tr>";
        
            $totalGeneral = 0;
            foreach ($achats as $achat) {
                $facture .= "<tr>
                                <td>{$achat['design']}</td>
                                <td>{$achat['prix_unitaire']} Ar</td>
                                <td>{$achat['quantite']}</td>
                                <td>{$achat['total']} Ar</td>
                             </tr>";
                $totalGeneral += $achat['total'];

                $stmt2 = $this->conn->prepare("UPDATE FACTURE SET montant_total = :montant_total WHERE num_facture = :num_facture ");
                $stmt2->bindParam(':montant_total',$totalGeneral);
                $stmt2->bindParam(':num_facture',$numAchat);
                $stmt2->execute();

            }
        
            // $facture .= "<tr>
            //                 <td colspan='3'><strong>Total Général</strong></td>
            //                 <td><strong>{$totalGeneral} Ar</strong></td>
            //              </tr>";
            // $facture .= "</table>";
            
            return $facture;
        }

        public function genererPdf($numAchat) {
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

            if (!$numAchat) {
                die("Numéro d'achat manquant.");
            }

            function txt($str) {
                return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $str);
            }

            // Requête infos client
            $stmt1 = $this->conn->prepare("
                SELECT 
                    C.type_client, 
                    C.nom_client, 
                    C.adresse_client, 
                    C.num_client, 
                    C.email_client,
                    F.date_commande
                FROM COMMANDE F
                JOIN CLIENT C ON F.num_client = C.num_client 
                WHERE F.num_bon_commande = ?
            ");
            $stmt1->execute([$numAchat]);
            $factureInfo = $stmt1->fetch(PDO::FETCH_ASSOC);

            if (!$factureInfo) {
                die("Facture introuvable.");
            }

            // Choix prix
            switch ($factureInfo['type_client']) {
                case "Detaillant": $colPrix = "prix_detaillant"; break;
                case "Consommateur": $colPrix = "prix_consommateur"; break;
                default: $colPrix = "prix_gros"; break;
            }

            // Requête lignes
            $query = "
                SELECT P.design, P.$colPrix AS prix_unitaire, L.quantite
                FROM LIGNE_COMMANDE L
                JOIN PRODUIT P ON P.num_produit = L.num_produit
                WHERE L.num_commande = ?
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$numAchat]);
            $achats = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($achats)) {
                die("Achat non trouvé.");
            }

            // Création PDF
            $pdf = new FPDF();
            $pdf->AddPage();

            $pdf->AddFont('DejaVu','','DejaVuSans.php');
            $pdf->AddFont('DejaVu','B','DejaVuSans-Bold.php');
            $pdf->SetFont('DejaVu','',10);

            $pdf->SetFont('DejaVu','B',10);
            $pdf->setX(82);
            $pdf->Cell(100, 6, txt('BON DE COMMANDE'), 0, 0, 'L');
            $pdf->Ln(8);

            // En-tête - Société à gauche
            $pdf->SetFont('DejaVu','',10);

            $y = 25;
            $pdf->SetXY(10, $y);
            $pdf->Cell(90, 4, txt("Lazan'i Betsileo"), 0, 0, 'L');
            $pdf->SetXY(110, $y);
            $pdf->Cell(90, 4, txt('Fianarantsoa le ' . $factureInfo['date_commande']), 0, 1, 'R');
            
            $pdf->Ln(1);
            $pdf->SetX(10);
            $pdf->Cell(90, 4, txt('Adresse : ISAHA-FIANARANTSOA'), 0, 1, 'L');
            
            $pdf->Ln(1);
            $pdf->SetX(10);
            $pdf->Cell(90, 4, txt('TEL        : 0340328712/0340328646'), 0, 0, 'L');

            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->Cell(90, 4, txt('Mail       : lazan_i_betsileo2@yahoo.fr'), 0, 0, 'L');

            $pdf->SetX(110);
            $pdf->Cell(90, 4, txt('BL/FACTURE N° ' . $numAchat), 0, 1, 'R');
            
            $pdf->SetX(153);
            $pdf->Cell(90, 4, txt('Doit : ' . $factureInfo['nom_client'].''), 0, 1, 'L');
            
        
            $pdf->SetX(153);
            $pdf->Cell(90, 4, txt($factureInfo['adresse_client'].''), 0, 1, 'L');
            
            $pdf->SetX(153);
            $pdf->Cell(90, 4, txt($factureInfo['email_client']), 0, 1, 'L');
            
            $pdf->SetX(153);
            $pdf->Cell(90, 4, txt('NIF: ' . $factureInfo['num_client']), 0, 1, 'L');
            
        
            $pdf->Ln(4);
        
            // Tableau
            $pdf->Ln(2);
            $pdf->SetFont('DejaVu','B',9);
            $pdf->Cell(15, 8, txt('N°'), 1, 0, 'C');
            $pdf->Cell(20, 8, txt('Quantité'), 1, 0, 'C');
            $pdf->Cell(80, 8, txt('Désignation'), 1, 0, 'C');
            $pdf->Cell(35, 8, txt('Prix Unitaire'), 1, 0, 'C');
            $pdf->Cell(40, 8, txt('Montant'), 1, 1, 'C');

            $pdf->SetFont('DejaVu','',9);
            $totalGeneral = 0;
            $num = 1;
            
            foreach ($achats as $row) {
                $total = $row['prix_unitaire'] * $row['quantite'];
                $totalGeneral += $total;

                $pdf->Cell(15, 8, $num++, 1, 0, 'C');
                $pdf->Cell(20, 8, $row['quantite'], 1, 0, 'C');
                $pdf->Cell(80, 8, txt($row['design']), 1, 0, 'L');
                $pdf->Cell(35, 8, number_format($row['prix_unitaire'], 2, ',', ' '), 1, 0, 'C');
                $pdf->Cell(40, 8, number_format($total, 2, ',', ' '), 1, 1, 'C');
            }

            // Total
            $pdf->SetFont('DejaVu','B',9);
            $pdf->Cell(115, 8, '', 0, 0);
            $pdf->Cell(35, 8, txt('TOTAL'), 1, 0, 'C');
            $pdf->Cell(40, 8, number_format($totalGeneral, 2, ',', ' '), 1, 1, 'C');

            // Informations de paiement
            $pdf->Ln(4);
            $pdf->SetFont('DejaVu','',9);
        //  $pdf->Cell(0, 4, txt('Mode de Règlement: par chèque'), 0, 1, 'L');
            $pdf->Cell(0, 4, txt('DATE DE REGLEMENT: 60 jours après réception produits'), 0, 1, 'L');
            $pdf->Ln(2);
            $montantEnLettres = $this->montantEnLettres($totalGeneral);
            $pdf->Cell(0, 4, txt('Arrêtée à la somme de : ' . $montantEnLettres), 0, 1, 'L');
            
            // Signatures
            $pdf->Ln(8);
            $pdf->SetFont('DejaVu','B',10);
            $pdf->Cell(95, 6, txt('LE CLIENT'), 0, 0, 'L');
            $pdf->Cell(95, 6, txt('LE FOURNISSEUR'), 0, 1, 'R');

            $pdf->Output('I', 'COMMANDE_' . $numAchat . '.pdf');
        }

        public function nombreEnLettres($nombre) {
            // Tableaux pour la conversion
            $unite = array('', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf');
            $dizaine = array('', '', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante', 'quatre-vingt', 'quatre-vingt');
            $dixneuf = array('dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf');
            
            // Si le nombre est 0
            if ($nombre == 0) {
                return 'zéro';
            }
            
            $nombre = floor($nombre); // Enlever les décimales
            $resultat = '';
            
            // Milliards
            if ($nombre >= 1000000000) {
                $milliards = floor($nombre / 1000000000);
                if ($milliards == 1) {
                    $resultat .= 'un milliard ';
                } else {
                    $resultat .= $this->nombreEnLettres($milliards) . ' milliards ';
                }
                $nombre = $nombre % 1000000000;
            }
            
            // Millions
            if ($nombre >= 1000000) {
                $millions = floor($nombre / 1000000);
                if ($millions == 1) {
                    $resultat .= 'un million ';
                } else {
                    $resultat .= $this->nombreEnLettres($millions) . ' millions ';
                }
                $nombre = $nombre % 1000000;
            }
            
            // Milliers
            if ($nombre >= 1000) {
                $milliers = floor($nombre / 1000);
                if ($milliers == 1) {
                    $resultat .= 'mille ';
                } else {
                    $resultat .= $this->nombreEnLettres($milliers) . ' mille ';
                }
                $nombre = $nombre % 1000;
            }
            
            // Centaines
            if ($nombre >= 100) {
                $centaines = floor($nombre / 100);
                if ($centaines == 1) {
                    $resultat .= 'cent ';
                } else {
                    $resultat .= $unite[$centaines] . ' cent ';
                }
                $nombre = $nombre % 100;
            }
            
            // De 10 à 19
            if ($nombre >= 10 && $nombre <= 19) {
                $resultat .= $dixneuf[$nombre - 10];
                return trim($resultat);
            }
            
            // Dizaines (20, 30, 40, etc.)
            if ($nombre >= 20) {
                $d = floor($nombre / 10);
                $u = $nombre % 10;
                
                // Cas spéciaux pour 70, 80, 90
                if ($d == 7) {
                    $resultat .= 'soixante-';
                    if ($u == 1) {
                        $resultat .= 'et-onze';
                    } else {
                        $resultat .= $dixneuf[$u + 1];
                    }
                } elseif ($d == 8) {
                    $resultat .= 'quatre-vingt';
                    if ($u > 0) {
                        $resultat .= '-' . $unite[$u];
                    } else {
                        $resultat .= 's';
                    }
                } elseif ($d == 9) {
                    $resultat .= 'quatre-vingt-' . $dixneuf[$u + 1];
                } else {
                    $resultat .= $dizaine[$d];
                    if ($u == 1 && $d != 8) {
                        $resultat .= '-et-un';
                    } elseif ($u > 1) {
                        $resultat .= '-' . $unite[$u];
                    }
                }
                return trim($resultat);
            }
            
            // Unités (1 à 9)
            if ($nombre > 0) {
                $resultat .= $unite[$nombre];
            }
            
            return trim($resultat);
        }

        public function montantEnLettres($montant) {
            $texte = $this->nombreEnLettres($montant);          
            $texte = ucfirst($texte);
        
             return $texte . ' Ariary';
        }


    }




?>