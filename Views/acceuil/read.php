<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord – Vente de Vin</title>
    <link rel="stylesheet" href="/Views/acceuil/cssAcceuil.css">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        window.chartData = {
          data1: {
            cols: [
              { label: "Mois", type: "string" },
              { label: "Recette par mois", type: "number" }
            ],
            rows: [
              <?php foreach ($result as $row): ?>
                { c: [{ v: "<?= htmlspecialchars(
                    $row["mois_fr"],
                ) ?>" }, { v: <?= (float) $row["recette_totale"] ?> }] },
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
                { c: [{ v: "<?= addslashes(
                    htmlspecialchars($row1["design"]),
                ) ?>" }, { v: <?= (float) $row1["total_achete"] ?> }] },
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
                { c: [{ v: "<?= addslashes(
                    htmlspecialchars($row["mode_paiement"]),
                ) ?>" }, { v: <?= (float) $row["total_paye"] ?> }] },
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
                { c: [{ v: "<?= addslashes(
                    htmlspecialchars($row["type_client"]),
                ) ?>" }, { v: <?= (float) $row["total_recette"] ?> }] },
              <?php endforeach; ?>
            ]
          }
        };
    </script>
    <script src="/Views/acceuil/charts.js"></script>
</head>
<body>

<nav class="navbarAll">
    <div>
        <a class="logo">🍷 VENTE</a>
        <div id="mynavbar">
            <?php require_once __DIR__ . "/../shared/navbar.php"; ?>
        </div>
    </div>
</nav>

<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-icon">🧾</div>
        <div class="stat-label">Factures ce mois</div>
        <div class="stat-value"><?= (int) ($nbFac["nb"] ?? 0) ?></div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-label">Recette totale</div>
        <div class="stat-value"><?= number_format(
            $recetteTotal["recette"] ?? 0,
            0,
            ",",
            " ",
        ) ?> Ar</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-label">Montant reçu</div>
        <div class="stat-value"><?= number_format(
            $totalReg["total"] ?? 0,
            0,
            ",",
            " ",
        ) ?> Ar</div>
    </div>

    <div class="stat-card stat-card--warning">
        <div class="stat-icon">⚠️</div>
        <div class="stat-label">Montant non payé</div>
        <div class="stat-value"><?= number_format(
            $totalPaye ?? 0,
            0,
            ",",
            " ",
        ) ?> Ar</div>
        <button class="open-modal-btn" onclick="openModal()">Voir les clients</button>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🍾</div>
        <div class="stat-label">Bouteilles vendues</div>
        <div class="stat-value"><?= (int) ($totalBout ?? 0) ?></div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-label">Stock total</div>
        <div class="stat-value"><?= number_format(
            $stock["nb"] ?? 0,
            0,
            ",",
            " ",
        ) ?> btl</div>
    </div>

</div>

<div class="charts-wrapper">
    <div id="myChart2" style="border-radius: 10px;"></div>
    <div id="myChart3" style="border-radius: 10px;"></div>
    <div id="myChart4" style="border-radius: 10px;"></div>
    <div id="myChart1" style="border-radius: 10px;"></div>
</div>

<!-- Modale clients non réglés -->
<div id="clientModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Clients n'ayant pas réglé la totalité de leur facture</h2>
        <table>
            <thead>
                <tr>
                    <th>N° Client</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Adresse</th>
                    <th>N° Facture</th>
                    <th>Montant Total</th>
                    <th>Montant Payé</th>
                    <th>Restant</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($clients) > 0): ?>
                    <?php foreach ($clients as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["num_client"]) ?></td>
                        <td><?= htmlspecialchars($row["nom_client"]) ?></td>
                        <td><?= htmlspecialchars($row["email_client"]) ?></td>
                        <td><?= htmlspecialchars($row["adresse_client"]) ?></td>
                        <td><?= htmlspecialchars($row["num_facture"]) ?></td>
                        <td><?= number_format(
                            $row["montant_total"],
                            0,
                            ",",
                            " ",
                        ) ?> Ar</td>
                        <td><?= number_format(
                            $row["montant_paye"],
                            0,
                            ",",
                            " ",
                        ) ?> Ar</td>
                        <td style="color:red; font-weight:bold;"><?= number_format(
                            $row["montant_restant"],
                            0,
                            ",",
                            " ",
                        ) ?> Ar</td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" style="text-align:center;">Aucun client en attente de paiement.</td></tr>
                <?php endif; ?>
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
        if (event.target === modal) modal.style.display = "none";
    };
</script>

</body>
</html>
