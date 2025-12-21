<?php

    // require __DIR__ . '/../pdf/fpdf.php';

    class Reglement {
        private $conn;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            
            $query="SELECT 
                F.num_facture,
                R.num_reglement,
                R.date_reglement,
                R.montant_reglement,
                R.mode_paiement,
                R.nom_personne_reglement,
                F.montant_total,
                (F.montant_total - COALESCE(SUM(R2.montant_reglement), 0)) AS reste_a_payer
                FROM REGLEMENT R
                JOIN FACTURE F ON F.num_facture = R.num_facture
                JOIN REGLEMENT R2 ON R2.num_facture = F.num_facture
                GROUP BY F.num_facture, R.num_reglement, F.montant_total, R.montant_reglement
                ORDER BY F.num_facture ASC, R.num_reglement ASC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function create($num_reglement,$num_facture,$date_reglement,$mode_paiement,$montant_reglement,$nom_personne_reglement) {
            $query = "INSERT INTO REGLEMENT (num_reglement,num_facture,date_reglement,mode_paiement,montant_reglement,nom_personne_reglement) VALUES (:num_reglement, :num_facture, :date_reglement, :mode_paiement, :montant_reglement, :nom_personne_reglement) ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':num_reglement',$num_reglement);
            $stmt->bindParam(':num_facture',$num_facture);
            $stmt->bindParam(':date_reglement',$date_reglement);
            $stmt->bindParam(':mode_paiement',$mode_paiement);
            $stmt->bindParam(':montant_reglement',$montant_reglement);
            $stmt->bindParam(':nom_personne_reglement',$nom_personne_reglement);
            return $stmt->execute();
        }

        public function delete($num_reglement) {
            $query = "DELETE FROM REGLEMENT WHERE num_reglement = :num_reglement";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':num_reglement',$num_reglement);
            return $stmt->execute();
        }

        public function update($num_reglement,$num_facture,$date_reglement,$mode_paiement,$montant_reglement,$nom_personne_reglement){
            $query = "UPDATE REGLEMENT SET num_facture = :num_facture, date_reglement = :date_reglement, mode_paiement = :mode_paiement, montant_reglement = :montant_reglement, nom_personne_reglement = :nom_personne_reglement WHERE num_reglement = :num_reglement";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':num_facture',$num_facture);
            $stmt->bindParam(':num_reglement',$num_reglement);
            $stmt->bindParam(':date_reglement',$date_reglement);
            $stmt->bindParam(':mode_paiement',$mode_paiement);
            $stmt->bindParam(':montant_reglement',$montant_reglement);
            $stmt->bindParam(':nom_personne_reglement',$nom_personne_reglement);
            return $stmt->execute();
        }

        public function genererNumber() {
            $query = "SELECT num_reglement FROM REGLEMENT ORDER BY num_reglement DESC LIMIT 1";
            $stmt = $this->conn->query($query);

            if($stmt && $stmt->rowCount() > 0){
                $num_regl = $stmt->fetch(PDO::FETCH_ASSOC);
                $lastNumReg = $num_regl['num_reglement'];
                $lastNum = intval(substr($lastNumReg,4));
                $newNumber = $lastNum + 1;
            } else {
                $newNumber = 1;
            }

            $newNumberReg = "REG-".str_pad($newNumber,3,"0",STR_PAD_LEFT); 

            return $newNumberReg;
        }

        

        public function soustraction() {
            $query = "
                SELECT 
                    (F.montant_total - SUM(R.montant_reglement)) AS reste
                FROM REGLEMENT R
                JOIN FACTURE F ON F.num_facture = R.num_facture
                GROUP BY R.num_facture, F.montant_total, R.num_reglement
                ORDER BY R.num_reglement ASC
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_COLUMN); // retourne un tableau simple des "reste"
        }

        public function genererPdf($num_reg) {

            error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

           
            function txt($str) {
                return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $str);
            }

            $placeholders = rtrim(str_repeat('?,', count($num_reg)), ',');

            $stmt = $this->conn->prepare("
                SELECT * FROM REGLEMENT WHERE num_reglement IN ($placeholders)                   
            ");

            $stmt->execute($num_reg);

            $reglements = $stmt->fetchAll(PDO::FETCH_ASSOC);

            

            $query = "SELECT c.num_client, c.email_client, c.adresse_client
              FROM CLIENT c
              JOIN FACTURE f ON f.num_client = c.num_client
              WHERE c.nom_client = :nom_client";

            $stmt1 = $this->conn->prepare($query);
            $stmt1->bindParam(':nom_client', $reglements[0]['nom_personne_reglement']);
            $stmt1->execute();
          //  print_r ($reglements);
           // echo $reglements[0]['nom_personne_reglement'];
            $info = $stmt1->fetchAll(PDO::FETCH_ASSOC);
           // print_r ($info);
            $pdf = new FPDF();
            $pdf->AddPage();

            $pdf->AddFont('DejaVu','','DejaVuSans.php');
            $pdf->AddFont('DejaVu','B','DejaVuSans-Bold.php');
            
            $pdf->SetFont('DejaVu','B',10);
            $pdf->setX(82);
            $pdf->Cell(100, 6, txt('RECU-REGLEMENT'), 0, 0, 'L');
            $pdf->Ln(8);

             $pdf->SetFont('DejaVu','',10);

            $y = 25;
            $pdf->SetXY(10, $y);
            $pdf->Cell(90, 4, txt("Lazan'i Betsileo"), 0, 0, 'L');
            $pdf->SetXY(110, $y);
            $pdf->Cell(90, 4, txt('Fianarantsoa le ' . $reglements[0]['date_reglement']), 0,1, 'R');
            
            $pdf->Ln(1);
            $pdf->SetX(10);
            $pdf->Cell(90, 4, txt("Adresse : ISAHA-FIANARANTSOA"), 0, 1, 'L');

            $pdf->Ln(1);
            $pdf->SetX(10);
            $pdf->Cell(90, 4, txt("TEL        : 0340328712/0340328646"), 0, 0, 'L');

            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->Cell(90, 4, txt('Mail       : lazan_i_betsileo2@yahoo.fr'), 0, 1, 'L');

            $pdf->SetX(153);
            $pdf->Cell(90, 4, txt('BL/REGLEMENT N°'.$num_reg['0']), 0, 1, 'L');

            $pdf->SetX(153);
            $pdf->Cell(90, 4, txt('Doit : ' . $reglements[0]['nom_personne_reglement']), 0, 1, 'L');

            $pdf->SetX(153);
            $pdf->Cell(90, 4, txt($info[0]['adresse_client'].''), 0, 1, 'L');
            
            $pdf->SetX(153);
            $pdf->Cell(90, 4, txt($info[0]['email_client']), 0, 1, 'L');
            
            $pdf->SetX(153);
            $pdf->Cell(90, 4, txt('NIF: ' . $info[0]['num_client']), 0, 1, 'L');

            $pdf->Ln(4);

            $pdf->Ln(2);
            $pdf->SetX(50);
            $pdf->SetFont('DejaVu','B',9);
            $pdf->Cell(15, 8, txt('N°'), 1, 0, 'C');
            $pdf->Cell(35, 8, txt('Numero de facture'), 1, 0, 'C');
            $pdf->Cell(40, 8, txt('Montant a payer '), 1, 1, 'C');

            $pdf->SetFont('DejaVu','',9);

            $totalGeneral = 0;
            $num = 1;

            foreach ($reglements as $row) {

                $totalGeneral += $row['montant_reglement'];
                $pdf->SetX(50);
                $pdf->Cell(15, 8, $num++, 1, 0, 'C');
                $pdf->Cell(35, 8, $row['num_facture'], 1, 0, 'C');
                $pdf->Cell(40, 8, number_format($row['montant_reglement'], 2, ',', ' '), 1, 1, 'C');

            }
            $pdf->SetX(50);
            $pdf->SetFont('DejaVu','B',9);
            $pdf->Cell(15, 8, '', 0, 0);
            $pdf->Cell(35, 8, txt('Total') , 1, 0, 'C');
            $pdf->Cell(40, 8, number_format($totalGeneral, 2, ',', ' '), 1, 1, 'C');

            $pdf->Ln(10);
            $pdf->SetFont('DejaVu','',9);

            $pdf->Cell(90, 4, txt('Mode de reglement : par '.$reglements[0]['mode_paiement']), 0, 1, 'L');
            
            $pdf->Ln(2);
            $montantEnLettres = $this->montantEnLettres($totalGeneral);

            $pdf->Cell(90, 4, txt('Arrêtée à la somme de : ' . $montantEnLettres));

            $pdf->Ln(8);
            $pdf->SetFont('DejaVu','B',10);
            $pdf->Cell(95, 6, txt('LE CLIENT'), 0, 0, 'L');
            $pdf->Cell(95, 6, txt('LE FOURNISSEUR'), 0, 1, 'R');

            $pdf->Output('I', 'REGLEMENT_' . $num_reg[0] . '.pdf');
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