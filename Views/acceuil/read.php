<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCUEIL</title>
    
    <link rel="stylesheet" href="/Views/acceuil/cssAcceuil.css"> 
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        // 🧩 On prépare les données PHP sous forme JSON
        window.chartData = {
          data1: {
            cols: [
              { label: "Mois", type: "string" },
              { label: "Recette par mois", type: "number" }
            ],
            rows: [
              <?php foreach ($result as $row): ?>
                { c: [{ v: "<?= $row['mois_fr'] ?>" }, { v: <?= (float)$row['recette_totale'] ?> }] },
              <?php endforeach; ?>
            ]
          },
          data2: {
            cols: [
              { label: "Produit", type: "string" },
              { label: "Nombre", type: "number" }
            ],
            rows: [
              <?php foreach ($result1 as $row1): ?>
                { c: [{ v: "<?= addslashes($row1['design']) ?>" }, { v: <?= (float)$row1['total_achete'] ?> }] },
              <?php endforeach; ?>
            ]
          },
          data3: {
            cols: [
              { label: "Mode paiement", type: "string" },
              { label: "Total payé", type: "number" }
            ],
            rows: [
              <?php foreach ($type as $row): ?>
                { c: [{ v: "<?= addslashes($row['mode_paiement']) ?>" }, { v: <?= (float)$row['total_paye'] ?> }] },
              <?php endforeach; ?>
            ]
          },
          data4: {
            cols: [
              { label: "Type client", type: "string" },
              { label: "Total recette", type: "number" }
            ],
            rows: [
              <?php foreach ($repartition as $row): ?>
                { c: [{ v: "<?= addslashes($row['type_client']) ?>" }, { v: <?= (float)$row['total_recette'] ?> }] },
              <?php endforeach; ?>
            ]
          }
        };
</script>

<!-- 🔗 Charger ton fichier JS externe -->
<script src="/Views/acceuil/charts.js"></script>

    <nav class="navbarAll">
        <div>
          <a class="logo">VENTE</a>
          
          <div class="" id="mynavbar">
            <ul>
                <li class="nav-item">
                  <a href="index.php?entity=acceuil&action=read"><button class="nav-link">Dashbord</button></a>
                </li>
                <li class="nav-item">
                  <a href="index.php?entity=produit&action=read"><button class="nav-link" >Produits</button></a>
                </li>
                <li class="nav-item">
                  <a href="index.php?entity=achat&action=read"><button class="nav-link">Achats</button></a>
                </li>
                <li class="nav-item">
                   <a href="index.php?entity=client&action=read"><button class="nav-link">Clients</button></a>
                </li>
                <li class="nav-item">
                   <a href="index.php?entity=reglement&action=read"><button class="nav-link">Reglements</button></a>
                </li>
                <li class="nav-item">
                   <a href="index.php?entity=reglement&action=read"><button class="nav-link">Commands</button></a>
                </li>           
            </ul>          
          </div>
        </div>
      </nav>
    
</head>
<body>

    <!-- <div> <canvas id="myChart" style="background-color: white; border-radius: 10px;"></canvas></div> -->
    <div id="nbFac">
        <h2 style="margin-left: 7px;margin-top: 10px;">Nombre facture de ce mois :</h2>
        <h1 style="margin-left: 7px;margin-top: 0px;"><?= $nbFac['nb'] ?> factures</h1>
    </div>
    <div id="recetotal">
        <h2 style="margin-left: 7px;margin-top: 10px;">Le recette total :</h2>
        <h1 style="margin-left: 7px;margin-top: 23px;"><?= $recetteTotal['recette']?> ar</h1>
    </div>
    <div id="reste">
        <h2 style="margin-left: 7px;margin-top: 10px;">Recu :</h2>
        <h1 style="margin-left: 7px;margin-top: 23px;"><?= $totalReg['total']?> ar</h1>
    </div>
    <div id="totalReg">
        <h2 style="margin-left: 7px;margin-top: 10px;">Pas paye :</h2>
        <h1 style="margin-left: 7px;margin-top: 23px;"><?= $totalPaye?> ar</h1>
        <button class="open-modal-btn" onclick="openModal()">Afficher</button>
    </div>
    <div id="proVendu">
        <h2 style="margin-left: 7px;margin-top: 10px;">Produit vendu de ce mois :</h2>
        <h1 style="margin-left: 7px;margin-top: 0px;"><?= $totalBout?> bouteilles</h1>
    </div>
    <div id="stock">
        <h2 style="margin-left: 7px;margin-top: 10px;">Produit stocke :</h2>
        <h1 style="margin-left: 7px;margin-top: 23px;"><?= $stock['nb']?> bouteilles</h1>
    </div>
    <div id="myChart2" style="border-radius: 10px;"></div>
    <div id="myChart3" style="border-radius: 10px;"></div>
    <div id="myChart4" style="border-radius: 10px;"></div>
    <div id="myChart1" style="border-radius: 10px;"></div>



    <div id="clients-non-regles-section">

    <!-- Bouton pour ouvrir la modale -->
  

    <!-- Modale -->
    <div id="clientModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Clients n’ayant pas réglé la totalité de leur facture</h2>

            <table>
                <thead>
                    <tr>
                        <th>Num Client</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Num Facture</th>
                        <th>Montant Total</th>
                        <th>Montant Payé</th>
                        <th>Montant Restant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
            

                    if (count($clients) > 0) {
                        foreach ($clients as $row) {
                            echo "<tr>
                                <td>{$row['num_client']}</td>
                                <td>{$row['nom_client']}</td>
                                <td>{$row['email_client']}</td>
                                <td>{$row['adresse_client']}</td>
                                <td>{$row['num_facture']}</td>
                                <td>{$row['montant_total']}</td>
                                <td>{$row['montant_paye']}</td>
                                <td style='color:red;'>{$row['montant_restant']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center;'>Aucun client en attente de paiement.</td></tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("clientModal").style.display = "block";
        }
        function closeModal() {
            document.getElementById("clientModal").style.display = "none";
        }
        window.onclick = function(event) {
            const modal = document.getElementById("clientModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</div>



    <script>
        function openModal() {
            document.getElementById("clientModal").style.display = "block";
        }
        function closeModal() {
            document.getElementById("clientModal").style.display = "none";
        }
        window.onclick = function(event) {
            const modal = document.getElementById("clientModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
   
  
</body>
</html>
