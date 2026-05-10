<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients – Vente de Vin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/lib/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/Views/client/read.css">
</head>
<body>

<nav class="navbarAll">
    <div>
        <a class="logo">🍷 VENTE</a>
        <div id="mynavbar">
            <?php require_once __DIR__ . "/../shared/navbar.php"; ?>
            <form class="d-flex" action="index.php?entity=client&action=rechercher" method="POST">
                <input id="inputRecherche" type="text" name="nom_client" placeholder="Rechercher un client…">
                <button class="btnRecherche">Rechercher</button>
            </form>
        </div>
    </div>
</nav>

<div class="titre">
    <h1>Liste des clients</h1>
</div>

<div style="margin-top: 55px;"><br><br><br>
    <table style="margin-left: 82px;" class="tbl" id="enter">
        <colgroup>
            <col style="width: 200px;">
            <col style="width: 200px;">
            <col style="width: 200px;">
            <col style="width: 200px;">
            <col style="width: 200px;">
            <col style="width: 200px;">
        </colgroup>
        <thead style="position: fixed;">
            <tr class="trMedocTble">
                <th style="width: 200px;">N° Client</th>
                <th style="width: 200px;">Nom</th>
                <th style="width: 200px;">Type</th>
                <th style="width: 200px;">Adresse</th>
                <th style="width: 200px;">Téléphone</th>
                <th style="width: 200px;">Email</th>
                <th style="width: 210px; background-color:rgb(33,33,33); color:white;">Actions</th>
            </tr>
        </thead>
        <tr style="height: 40px;"></tr>
        <tbody>
            <?php foreach ($client as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c["num_client"]) ?></td>
                <td><?= htmlspecialchars($c["nom_client"]) ?></td>
                <td><?= htmlspecialchars($c["type_client"]) ?></td>
                <td><?= htmlspecialchars($c["adresse_client"]) ?></td>
                <td><?= htmlspecialchars($c["telephone_client"]) ?></td>
                <td><?= htmlspecialchars($c["email_client"]) ?></td>
                <td>
                    <button onclick="openModal1(
                        '<?= htmlspecialchars($c["num_client"], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($c["nom_client"], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars(
                            $c["type_client"],
                            ENT_QUOTES,
                        ) ?>',
                        '<?= htmlspecialchars(
                            $c["adresse_client"],
                            ENT_QUOTES,
                        ) ?>',
                        '<?= htmlspecialchars(
                            $c["telephone_client"],
                            ENT_QUOTES,
                        ) ?>',
                        '<?= htmlspecialchars(
                            $c["email_client"],
                            ENT_QUOTES,
                        ) ?>'
                    )" style="background-color: rgb(193,215,251); border: 2px solid darkblue;">Éditer</button>
                    <button style="background-color: rgb(255,189,189); border: 2px solid rgb(158,3,3);"
                        class="btnSupprimer"
                        data-id="<?= htmlspecialchars(
                            $c["num_client"],
                            ENT_QUOTES,
                        ) ?>">Supprimer</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button onclick="openModal()" class="btn1">+ Ajouter</button>
</div>

<!-- Modal Ajout -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Ajouter un client</h2>
        <form action="index.php?entity=client&action=create" method="POST">
            <label for="nom_client">Nom :</label>
            <input type="text" name="nom_client" id="nom_client" required>
            <label for="type_client">Type de client :</label>
            <select name="type_client" id="type_client">
                <option value="Detaillant">Détaillant</option>
                <option value="Consommateur">Consommateur</option>
                <option value="Grossiste">Grossiste</option>
            </select>
            <label for="adresse">Adresse :</label>
            <input type="text" name="adresse" id="adresse" required>
            <label for="telephone">Téléphone :</label>
            <input type="tel" id="telephone" name="telephone" required>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
            <button type="submit" class="btn">Enregistrer</button>
        </form>
    </div>
</div>

<!-- Modal Édition -->
<div id="modal1" class="modal1">
    <div class="modal-content1">
        <span class="close" onclick="closeModal1()">&times;</span>
        <h2>Modifier un client</h2>
        <form id="client-form" action="index.php?entity=client&action=update" method="POST">
            <label for="nom_client1">Nom :</label>
            <input type="text" name="nom_client1" id="nom_client1" required>
            <label for="type_client1">Type de client :</label>
            <select name="type_client1" id="type_client1">
                <option value="Detaillant">Détaillant</option>
                <option value="Consommateur">Consommateur</option>
                <option value="Grossiste">Grossiste</option>
            </select>
            <label for="adresse1">Adresse :</label>
            <input type="text" name="adresse1" id="adresse1" required>
            <label for="telephone1">Téléphone :</label>
            <input type="text" name="telephone1" id="telephone1" required>
            <label for="email1">Email :</label>
            <input type="email" name="email1" id="email1" required>
            <button type="submit" class="btn2">Enregistrer</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById("modal").style.display = "flex";
    }
    function openModal1(num_client, nom_client, type_client, adresse, telephone, email) {
        document.getElementById('nom_client1').value = nom_client;
        document.getElementById('type_client1').value = type_client;
        document.getElementById('adresse1').value = adresse;
        document.getElementById('telephone1').value = telephone;
        document.getElementById('email1').value = email;
        const form = document.getElementById('client-form');
        form.action = `index.php?entity=client&action=update&id=${num_client}`;
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
<script src="<?= BASE_URL ?>/Views/client/script.js"></script>

<?php if (isset($_GET["success"]) && $_GET["success"] == 1): ?>
<script>
Swal.fire({ icon:'success', title:'Succès', text:'Client modifié avec succès.', confirmButtonText:'OK' });
</script>
<?php endif; ?>
<?php if (isset($_GET["error"]) && $_GET["error"] == 1): ?>
<script>
Swal.fire({ icon:'error', title:'Erreur', text:'La modification a échoué.', confirmButtonText:'OK' });
</script>
<?php endif; ?>

</body>
</html>
