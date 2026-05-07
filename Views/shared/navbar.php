<?php
/**
 * Barre de navigation partagée
 * Usage: <?php require_once __DIR__ . '/../shared/navbar.php'; ?>
 */
$currentEntity = $_GET['entity'] ?? 'acceuil';
?>
<ul>
    <li class="nav-item">
        <a href="index.php?entity=acceuil&action=read">
            <button class="nav-link <?= $currentEntity === 'acceuil' ? 'nav-active' : '' ?>" style="width:120px">Tableau de bord</button>
        </a>
    </li>
    <li class="nav-item">
        <a href="index.php?entity=produit&action=read">
            <button class="nav-link <?= $currentEntity === 'produit' ? 'nav-active' : '' ?>">Produits</button>
        </a>
    </li>
    <li class="nav-item">
        <a href="index.php?entity=client&action=read">
            <button class="nav-link <?= $currentEntity === 'client' ? 'nav-active' : '' ?>">Clients</button>
        </a>
    </li>
    <li class="nav-item">
        <a href="index.php?entity=command&action=read">
            <button class="nav-link <?= $currentEntity === 'command' ? 'nav-active' : '' ?>">Commandes</button>
        </a>
    </li>
    <li class="nav-item">
        <a href="index.php?entity=achat&action=read">
            <button class="nav-link <?= $currentEntity === 'achat' ? 'nav-active' : '' ?>">Ventes</button>
        </a>
    </li>
    <li class="nav-item">
        <a href="index.php?entity=reglement&action=read">
            <button class="nav-link <?= $currentEntity === 'reglement' ? 'nav-active' : '' ?>">Règlements</button>
        </a>
    </li>
</ul>
