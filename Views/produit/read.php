<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits – Vente de Vin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/lib/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/Views/produit/read.css">
</head>
<body>

<nav class="navbarAll">
    <div>
        <a class="logo">🍷 VENTE</a>
        <div id="mynavbar">
            <?php require_once __DIR__ . "/../shared/navbar.php"; ?>
            <form class="d-flex" action="index.php?entity=produit&action=rechercher" method="POST">
                <input id="inputRecherche" name="design" type="text" placeholder="Rechercher un produit…">
                <button class="btnRecherche" type="submit">Rechercher</button>
            </form>
        </div>
    </div>
</nav>

<div class="titre">
    <h1>Liste des produits</h1>
</div>

<div style="margin-top: 55px;"><br><br><br>
    <table class="tbl" id="medicaments">
        <colgroup>
            <col style="width: 170px;">
            <col style="width: 250px;">
            <col style="width: 170px;">
            <col style="width: 170px;">
            <col style="width: 170px;">
            <col style="width: 170px;">
            <col style="width: 210px;">
        </colgroup>
        <thead style="position: fixed;">
            <tr class="trMedocTble">
                <th style="width: 170px;">N° Produit</th>
                <th style="width: 250px;">Désignation</th>
                <th style="width: 170px;">Stock</th>
                <th style="width: 170px;">Prix détaillant</th>
                <th style="width: 170px;">Prix consommateur</th>
                <th style="width: 170px;">Prix de gros</th>
                <th style="width: 210px; background-color:rgb(33,33,33); color:white;">Actions</th>
            </tr>
        </thead>
        <tr style="height: 40px;"></tr>
        <tbody>
            <?php foreach ($produit as $p): ?>
            <tr <?= $p["nombre"] <= 5 ? 'class="stock-low"' : "" ?>>
                <td><?= htmlspecialchars($p["num_produit"]) ?></td>
                <td style="text-align:left;"><?= htmlspecialchars(
                    $p["design"],
                ) ?></td>
                <td>
                    <?= (int) $p["nombre"] ?> btl
                    <?= $p["nombre"] <= 5
                        ? '<span class="badge-warning">⚠️ Rupture</span>'
                        : "" ?>
                </td>
                <td><?= number_format(
                    $p["prix_detaillant"],
                    0,
                    ",",
                    " ",
                ) ?> Ar</td>
                <td><?= number_format(
                    $p["prix_consommateur"],
                    0,
                    ",",
                    " ",
                ) ?> Ar</td>
                <td><?= number_format($p["prix_gros"], 0, ",", " ") ?> Ar</td>
                <td>
                    <button onclick="openModal1(
                        '<?= htmlspecialchars(
                            $p["num_produit"],
                            ENT_QUOTES,
                        ) ?>',
                        '<?= htmlspecialchars($p["design"], ENT_QUOTES) ?>',
                        '<?= (int) $p["prix_detaillant"] ?>',
                        '<?= (int) $p["prix_consommateur"] ?>',
                        '<?= (int) $p["prix_gros"] ?>',
                        '<?= (int) $p["nombre"] ?>'
                    )" style="background-color: rgb(193, 215, 251); border: 2px solid darkblue;">Éditer</button>
                    <button style="background-color: rgb(255, 189, 189); border: 2px solid rgb(158,3,3);"
                        class="btnSupprimer"
                        data-id="<?= htmlspecialchars(
                            $p["num_produit"],
                            ENT_QUOTES,
                        ) ?>">Supprimer</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<button id="btn1" onclick="openModal()">+ Ajouter</button>

<!-- Modal Ajout -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Ajouter un produit</h2>
        <form id="produit-form" method="POST">
            <label for="design">Désignation :</label>
            <input type="text" name="design" id="design" required>
            <label for="prix_consommateur">Prix consommateur :</label>
            <input type="number" name="prix_consommateur" id="prix_consommateur" required>
            <label for="prix_detaillant">Prix détaillant :</label>
            <input type="number" name="prix_detaillant" id="prix_detaillant" required>
            <label for="prix_gros">Prix de gros :</label>
            <input type="number" name="prix_gros" id="prix_gros" required>
            <label for="nombre">Quantité en stock :</label>
            <input type="number" name="nombre" id="nombre" required>
            <button type="submit" class="btn">Enregistrer</button>
        </form>
    </div>
</div>

<!-- Modal Édition -->
<div id="modal1" class="modal1">
    <div class="modal-content1">
        <span class="close" onclick="closeModal1()">&times;</span>
        <h2>Modifier un produit</h2>
        <form id="medicament-form1" method="POST">
            <label for="design1">Désignation :</label>
            <input type="text" name="design1" id="design1" required>
            <label for="prix_detaillant1">Prix détaillant :</label>
            <input type="number" name="prix_detaillant1" id="prix_detaillant1" required>
            <label for="prix_gros1">Prix de gros :</label>
            <input type="number" name="prix_gros1" id="prix_gros1" required>
            <label for="prix_consommateur1">Prix consommateur :</label>
            <input type="number" name="prix_consommateur1" id="prix_consommateur1" required>
            <label for="nombre1">Quantité :</label>
            <input type="number" name="nombre1" id="nombre1" required>
            <button type="submit" class="btn2">Enregistrer</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById("modal").style.display = "flex";
    }
    function openModal1(num_produit, design, prix_detaillant, prix_consommateur, prix_gros, nombre) {
        document.getElementById('design1').value = design;
        document.getElementById('prix_consommateur1').value = prix_consommateur;
        document.getElementById('prix_detaillant1').value = prix_detaillant;
        document.getElementById('prix_gros1').value = prix_gros;
        document.getElementById('nombre1').value = nombre;
        const form = document.getElementById('medicament-form1');
        form.action = `index.php?entity=produit&action=update&id=${num_produit}`;
        document.getElementById("modal1").style.display = "flex";
    }
    function closeModal() {
        document.getElementById("modal").style.display = "none";
    }
    function closeModal1() {
        document.getElementById("modal1").style.display = "none";
    }
    window.onclick = function(event) {
        const modal1 = document.getElementById('modal1');
        const modal  = document.getElementById('modal');
        if (event.target === modal1) modal1.style.display = "none";
        else if (event.target === modal) modal.style.display = "none";
    };
</script>

<script src="<?= BASE_URL ?>/lib/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= BASE_URL ?>/Views/produit/script.js"></script>
<script src="<?= BASE_URL ?>/Views/produit/test1.js"></script>

<?php if (isset($_GET["success"]) && $_GET["success"] == 1): ?>
<script>
Swal.fire({ icon:'success', title:'Succès', text:'Produit modifié avec succès.', confirmButtonText:'OK' });
</script>
<?php endif; ?>
<?php if (isset($_GET["error"]) && $_GET["error"] == 1): ?>
<script>
Swal.fire({ icon:'error', title:'Erreur', text:'La modification a échoué.', confirmButtonText:'OK' });
</script>
<?php endif; ?>

</body>
</html>
