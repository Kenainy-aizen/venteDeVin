<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes – Vente de Vin</title>
    <link rel="stylesheet" href="/lib/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/Views/command/read.css">
</head>
<body>

<nav class="navbarAll">
    <div>
        <a class="logo">🍷 VENTE</a>
        <div id="mynavbar">
            <?php require_once __DIR__ . "/../shared/navbar.php"; ?>
            <form class="d-flex" action="index.php?entity=command&action=rechercher" method="POST">
                <input id="inputRecherche" name="inputRecherche" type="text" placeholder="Rechercher une commande…">
                <button class="btnRecherche" type="submit">Rechercher</button>
            </form>
        </div>
    </div>
</nav>

<div class="titre">
    <h1>Liste des commandes</h1>
</div>

<div style="margin-top: 55px;"><br><br><br>

    <div class="filters">
        <label class="switch">
            <input type="checkbox" id="attente" checked onchange="filtrer()">
            <span class="slider attente"></span>
            <span class="text">En attente</span>
        </label>
        <label class="switch">
            <input type="checkbox" id="regle" checked onchange="filtrer()">
            <span class="slider regle"></span>
            <span class="text">Réglé</span>
        </label>
    </div>

    <table class="tbl" id="AchatsVidy">
        <colgroup>
            <col style="width: 200px;">
            <col style="width: 200px;">
            <col style="width: 200px;">
            <col style="width: 200px;">
            <col style="width: 345px;">
        </colgroup>
        <thead style="position: fixed;">
            <tr class="trMedocTble">
                <th style="width: 200px;">N° Commande</th>
                <th style="width: 200px;">Client</th>
                <th style="width: 200px;">Date</th>
                <th style="width: 200px;">Statut</th>
                <th style="width: 345px; background-color:rgb(33,33,33); color:white;">Actions</th>
            </tr>
        </thead>
        <tr style="height: 40px;"></tr>
        <tbody>
            <?php foreach ($command as $cmd): ?>
            <tr data-statut="<?= strtolower(
                htmlspecialchars($cmd["statut"]),
            ) ?>">
                <td><?= htmlspecialchars($cmd["num_bon_commande"]) ?></td>
                <td><?= htmlspecialchars($cmd["nom_client"]) ?></td>
                <td><?= htmlspecialchars($cmd["date_commande"]) ?></td>
                <td>
                    <span class="badge-statut badge-<?= strtolower(
                        $cmd["statut"],
                    ) === "regle"
                        ? "regle"
                        : "attente" ?>">
                        <?= htmlspecialchars($cmd["statut"]) ?>
                    </span>
                </td>
                <td style="display:flex; justify-content:flex-start; align-items:center; gap:10px; margin-left:15px;">
                    <form method="post" action="index.php?entity=command&action=CreatePdf&id=<?= htmlspecialchars(
                        $cmd["num_bon_commande"],
                        ENT_QUOTES,
                    ) ?>">
                        <button type="submit" name="genererPdf" style="background-color: rgb(193,215,251); border: 2px solid darkblue;">PDF</button>
                    </form>
                    <button style="background-color: rgb(255,189,189); border: 2px solid rgb(158,3,3);"
                        class="btnSupprimer"
                        data-id="<?= htmlspecialchars(
                            $cmd["num_bon_commande"],
                            ENT_QUOTES,
                        ) ?>">Supprimer</button>
                    <button onclick="openModal1(
                        '<?= htmlspecialchars(
                            $cmd["num_bon_commande"],
                            ENT_QUOTES,
                        ) ?>',
                        '<?= htmlspecialchars(
                            $cmd["nom_client"],
                            ENT_QUOTES,
                        ) ?>',
                        '<?= htmlspecialchars(
                            $cmd["date_commande"],
                            ENT_QUOTES,
                        ) ?>',
                        '<?= htmlspecialchars($cmd["statut"], ENT_QUOTES) ?>'
                    )" style="background-color: rgb(223,209,26); border: 2px solid darkblue;">Modifier</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div><a href="index.php?entity=command&action=create"><button class="btn1">+ Nouvelle commande</button></a></div>
</div>

<!-- Modal Édition -->
<div id="modal1" class="modal1">
    <div class="modal-content1">
        <span class="close" onclick="closeModal1()">&times;</span>
        <h2>Modifier une commande</h2>
        <form id="command-form" action="index.php?entity=command&action=update" method="POST">
            <label for="dateAchat">Date :</label>
            <input type="date" name="date_cmd" id="dateAchat">
            <label for="nomClient">Client :</label>
            <input type="text" name="nom_client" id="nomClient">
            <label for="statut1">Statut :</label>
            <select name="statut" id="statut1">
                <option value="En attente">En attente</option>
                <option value="Regle">Réglé</option>
            </select>
            <button type="submit" class="btn2">Enregistrer</button>
        </form>
    </div>
</div>

<script>
    function openModal1(num_bon_commande, nomClient, date_cmd, statut) {
        document.getElementById('nomClient').value = nomClient;
        document.getElementById('dateAchat').value = date_cmd;
        document.getElementById('statut1').value = statut;
        const form = document.getElementById('command-form');
        form.action = `index.php?entity=command&action=update&id=${num_bon_commande}`;
        document.getElementById("modal1").style.display = "flex";
    }
    function closeModal1() {
        document.getElementById("modal1").style.display = "none";
    }
    window.onclick = function(event) {
        const modal1 = document.getElementById('modal1');
        if (event.target === modal1) modal1.style.display = "none";
    };
    function filtrer() {
        const showAttente = document.getElementById('attente').checked;
        const showRegle   = document.getElementById('regle').checked;
        document.querySelectorAll("tr[data-statut]").forEach(row => {
            const statut = row.dataset.statut;
            row.style.display = (
                (statut === 'en attente' && showAttente) ||
                (statut === 'regle'      && showRegle)
            ) ? '' : 'none';
        });
    }
</script>

<script src="/lib/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/Views/command/script.js"></script>

<?php if (isset($_GET["success"]) && $_GET["success"] == 1): ?>
<script>Swal.fire({ icon:'success', title:'Succès', text:'Commande modifiée avec succès.', confirmButtonText:'OK' });</script>
<?php endif; ?>
<?php if (isset($_GET["error"]) && $_GET["error"] == 1): ?>
<script>Swal.fire({ icon:'error', title:'Erreur', text:'La modification a échoué.', confirmButtonText:'OK' });</script>
<?php endif; ?>

</body>
</html>
