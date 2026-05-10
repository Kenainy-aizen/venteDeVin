<!-- Barre de navigation partagée -->
<!-- Utilisation: <?php require_once __DIR__ . "/../shared/navbar.php"; ?> -->

<?php
$currentEntity = $_GET["entity"] ?? "acceuil";
$navItems = [
    "acceuil" => ["label" => "📊 Tableau de bord", "width" => "width:150px"],
    "produit" => ["label" => "🍾 Produits", "width" => ""],
    "client" => ["label" => "👥 Clients", "width" => ""],
    "command" => ["label" => "📋 Commandes", "width" => ""],
    "achat" => ["label" => "💳 Ventes", "width" => ""],
    "reglement" => ["label" => "💰 Règlements", "width" => ""],
];
?>

<ul>
    <?php foreach ($navItems as $entity => $item): ?>
    <li class="nav-item">
        <a href="<?= BASE_URL ?>/index.php?entity=<?= $entity ?>&action=index">
            <button class="nav-link <?= $currentEntity === $entity
                ? "nav-active"
                : "" ?>"
                    <?= $item["width"] ?? "" ?>>
                <?= $item["label"] ?>
            </button>
        </a>
    </li>
    <?php endforeach; ?>
</ul>
