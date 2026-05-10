<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : '' ?><?= APP_NAME ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS Globale -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/Views/shared/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/Views/shared/components.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/Views/shared/modern.css">

    <!-- CSS Additionnels (optionnel) -->
    <?php if (isset($additionalCSS)): ?>
        <?php foreach ($additionalCSS as $css): ?>
            <link rel="stylesheet" href="<?= BASE_URL ?>/Views/<?= htmlspecialchars($css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
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
                <li class="nav-item <?= ($currentEntity ?? 'acceuil') === 'acceuil' ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>/index.php?entity=acceuil&action=index" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>

                <li class="nav-section-title">Gestion</li>

                <li class="nav-item <?= ($currentEntity ?? '') === 'produit' ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>/index.php?entity=produit&action=index" class="nav-link">
                        <i class="fas fa-wine-bottle"></i>
                        <span>Produits</span>
                    </a>
                </li>

                <li class="nav-item <?= ($currentEntity ?? '') === 'client' ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>/index.php?entity=client&action=index" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Clients</span>
                    </a>
                </li>

                <li class="nav-item <?= ($currentEntity ?? '') === 'command' ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>/index.php?entity=command&action=index" class="nav-link">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Commandes</span>
                    </a>
                </li>

                <li class="nav-section-title">Ventes</li>

                <li class="nav-item <?= ($currentEntity ?? '') === 'achat' ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>/index.php?entity=achat&action=index" class="nav-link">
                        <i class="fas fa-receipt"></i>
                        <span>Factures</span>
                    </a>
                </li>

                <li class="nav-item <?= ($currentEntity ?? '') === 'reglement' ? 'active' : '' ?>">
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
                <h2 class="page-title" id="pageTitle"><?= $pageTitle ?? 'Page' ?></h2>
            </div>

            <div class="top-bar-right">
                <div class="top-bar-actions">
                    <!-- Notifications (optionnel) -->
                    <button class="icon-btn" title="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </button>

                    <!-- Settings -->
                    <button class="icon-btn" title="Paramètres">
                        <i class="fas fa-cog"></i>
                    </button>

                    <!-- Logout -->
                    <button class="icon-btn" title="Déconnexion">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- PAGE CONTENT -->
        <div class="page-content">
            <?= isset($content) ? $content : '' ?>
        </div>
    </main>

    <!-- BACKDROP (pour mobile) -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>/Views/shared/main.js"></script>

    <!-- Scripts additionnels (optionnel) -->
    <?php if (isset($additionalScripts)): ?>
        <?php foreach ($additionalScripts as $script): ?>
            <script src="<?= BASE_URL ?>/Views/<?= htmlspecialchars($script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
