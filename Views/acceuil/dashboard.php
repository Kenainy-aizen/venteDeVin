<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= APP_NAME ?> – Tableau de bord</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/Views/shared/modern.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/Views/shared/dashboard.css">

    <!-- Google Charts -->
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
                    { c: [{ v: "<?= htmlspecialchars($row['mois_fr']) ?>" }, { v: <?= (float) $row['recette_totale'] ?> }] },
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
                    { c: [{ v: "<?= addslashes(htmlspecialchars($row1['design'])) ?>" }, { v: <?= (float) $row1['total_achete'] ?> }] },
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
                    { c: [{ v: "<?= addslashes(htmlspecialchars($row['mode_paiement'])) ?>" }, { v: <?= (float) $row['total_paye'] ?> }] },
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
                    { c: [{ v: "<?= addslashes(htmlspecialchars($row['type_client'])) ?>" }, { v: <?= (float) $row['total_recette'] ?> }] },
                    <?php endforeach; ?>
                ]
            }
        };
    </script>
    <script src="<?= BASE_URL ?>/Views/acceuil/charts.js"></script>
</head>
<body>
    <!-- SIDEBAR NAVIGATION -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <h1 class="logo">🍷<span>VinGest</span></h1>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-menu">
                <li class="nav-item active">
                    <a href="<?= BASE_URL ?>/index.php?entity=acceuil&action=index" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>

                <li class="nav-section-title">Gestion</li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/index.php?entity=produit&action=index" class="nav-link">
                        <i class="fas fa-wine-bottle"></i>
                        <span>Produits</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/index.php?entity=client&action=index" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Clients</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/index.php?entity=command&action=index" class="nav-link">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Commandes</span>
                    </a>
                </li>

                <li class="nav-section-title">Ventes</li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/index.php?entity=achat&action=index" class="nav-link">
                        <i class="fas fa-receipt"></i>
                        <span>Factures</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/index.php?entity=reglement&action=index" class="nav-link">
                        <i class="fas fa-credit-card"></i>
                        <span>Règlements</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="user-info">
                    <p class="user-name">Admin</p>
                    <p class="user-role">Administrateur</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- TOP BAR -->
        <div class="top-bar">
            <div class="top-bar-left">
                <h2 class="page-title">📊 Tableau de bord</h2>
            </div>

            <div class="top-bar-right">
                <div class="top-bar-actions">
                    <button class="icon-btn" title="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </button>
                    <button class="icon-btn" title="Paramètres">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- PAGE CONTENT -->
        <div class="page-content">
            <!-- STATS GRID -->
            <div class="stats-grid">
                <!-- Card 1: Factures -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon primary">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="stat-label">Factures ce mois</div>
                    </div>
                    <div class="stat-value"><?= (int) ($nbFac['nb'] ?? 0) ?></div>
                    <div class="stat-footer">
                        <span class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> +12%
                        </span>
                    </div>
                </div>

                <!-- Card 2: Recette totale -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon success">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="stat-label">Recette totale</div>
                    </div>
                    <div class="stat-value"><?= number_format($recetteTotal['recette'] ?? 0, 0, ',', ' ') ?> Ar</div>
                    <div class="stat-footer">
                        <span class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> +8%
                        </span>
                    </div>
                </div>

                <!-- Card 3: Montant reçu -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon info">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-label">Montant reçu</div>
                    </div>
                    <div class="stat-value"><?= number_format($totalReg['total'] ?? 0, 0, ',', ' ') ?> Ar</div>
                    <div class="stat-footer">
                        <span class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> +5%
                        </span>
                    </div>
                </div>

                <!-- Card 4: Montant non payé -->
                <div class="stat-card danger">
                    <div class="stat-header">
                        <div class="stat-icon danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-label">Montant non payé</div>
                    </div>
                    <div class="stat-value"><?= number_format($totalPaye ?? 0, 0, ',', ' ') ?> Ar</div>
                    <div class="stat-footer">
                        <button class="stat-btn" onclick="openClientsModal()">
                            Voir détails <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Card 5: Bouteilles vendues -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon warning">
                            <i class="fas fa-bottle-water"></i>
                        </div>
                        <div class="stat-label">Bouteilles vendues</div>
                    </div>
                    <div class="stat-value"><?= (int) ($totalBout ?? 0) ?></div>
                    <div class="stat-footer">
                        <span class="stat-trend positive">
                            <i class="fas fa-arrow-up"></i> +15%
                        </span>
                    </div>
                </div>

                <!-- Card 6: Stock total -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon secondary">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="stat-label">Stock total</div>
                    </div>
                    <div class="stat-value"><?= number_format($stock['nb'] ?? 0, 0, ',', ' ') ?> btl</div>
                    <div class="stat-footer">
                        <span class="stat-trend negative">
                            <i class="fas fa-arrow-down"></i> -3%
                        </span>
                    </div>
                </div>
            </div>

            <!-- CHARTS SECTION -->
            <div class="charts-section">
                <h3 class="section-title">📈 Analyses et Statistiques</h3>

                <div class="charts-grid">
                    <div class="chart-card">
                        <h4 class="chart-title">Recettes mensuelles</h4>
                        <div id="myChart1" class="chart-container"></div>
                    </div>

                    <div class="chart-card">
                        <h4 class="chart-title">Produits les plus vendus</h4>
                        <div id="myChart2" class="chart-container"></div>
                    </div>

                    <div class="chart-card">
                        <h4 class="chart-title">Modes de paiement</h4>
                        <div id="myChart3" class="chart-container"></div>
                    </div>

                    <div class="chart-card">
                        <h4 class="chart-title">Répartition par type de client</h4>
                        <div id="myChart4" class="chart-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- SIDEBAR BACKDROP -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- MODAL: Clients non réglés -->
    <div class="modal" id="clientsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Clients en attente de paiement</h2>
                <button class="modal-close" onclick="closeClientsModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>N° Client</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>N° Facture</th>
                                <th>Total</th>
                                <th>Payé</th>
                                <th>Restant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($clients) > 0): ?>
                                <?php foreach ($clients as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['num_client']) ?></td>
                                    <td><?= htmlspecialchars($row['nom_client']) ?></td>
                                    <td><?= htmlspecialchars($row['email_client']) ?></td>
                                    <td><?= htmlspecialchars($row['num_facture']) ?></td>
                                    <td><?= number_format($row['montant_total'], 0, ',', ' ') ?> Ar</td>
                                    <td><?= number_format($row['montant_paye'], 0, ',', ' ') ?> Ar</td>
                                    <td class="danger-text">
                                        <strong><?= number_format($row['montant_restant'], 0, ',', ' ') ?> Ar</strong>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <i class="fas fa-check-circle"></i> Aucun client en attente de paiement
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>/Views/shared/main.js"></script>
    <script>
        function openClientsModal() {
            document.getElementById('clientsModal').classList.add('active');
        }

        function closeClientsModal() {
            document.getElementById('clientsModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('clientsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeClientsModal();
            }
        });
    </script>
</body>
</html>
