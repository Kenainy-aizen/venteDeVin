<?php
$group = [];
foreach ($reglement as $rows) {
    $group[$rows["num_facture"]][] = $rows;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Règlements – Vente de Vin</title>
    <link rel="stylesheet" href="/lib/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/Views/reglement/read.css">
</head>
<body>

<nav class="navbarAll">
    <div>
        <a class="logo">🍷 VENTE</a>
        <div id="mynavbar">
            <?php require_once __DIR__ . "/../shared/navbar.php"; ?>
            <form class="d-flex" action="index.php?entity=reglement&action=rechercher" method="POST">
                <input id="inputRecherche" name="inputRecherche" type="text" placeholder="Rechercher un règlement…">
                <button class="btnRecherche">Rechercher</button>
            </form>
        </div>
    </div>
</nav>

<div class="titre">
    <h1>Liste des règlements</h1>
</div>

<div style="margin-top: 55px;"><br><br><br>
    <form action="index.php?entity=reglement&action=CreatePdf" method="post">
        <table style="margin-left: 10px;" class="tbl" id="enter">
            <colgroup>
                <col style="width: 170px;">
                <col style="width: 200px;">
                <col style="width: 200px;">
                <col style="width: 100px;">
                <col style="width: 160px;">
                <col style="width: 180px;">
                <col style="width: 150px;">
                <col style="width: 120px;">
                <col style="width: 220px;">
            </colgroup>
            <thead style="position: fixed;">
                <tr class="trMedocTble">
                    <th style="width: 170px;">N° Règlement</th>
                    <th style="width: 200px;">N° Facture</th>
                    <th style="width: 200px;">Nom du client</th>
                    <th style="width: 100px;">Date</th>
                    <th style="width: 160px;">Mode de paiement</th>
                    <th style="width: 180px;">Montant réglé</th>
                    <th style="width: 150px;">Total facture</th>
                    <th style="width: 120px;">Reste à payer</th>
                    <th style="width: 220px; background-color:rgb(33,33,33); color:white;">Actions</th>
                </tr>
            </thead>
            <tr style="height: 40px;"></tr>
            <tbody>
                <?php foreach ($group as $num_facture => $lignes): ?>
                    <?php
                    $rowspan = count($lignes);
                    $numFacture = $lignes[0]["num_facture"];
                    $reste = $lignes[0]["reste_a_payer"];
                    $montantTotal = $lignes[0]["montant_total"];
                    ?>
                    <?php foreach ($lignes as $i => $ligne): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_reglements[]"
                                value="<?= htmlspecialchars(
                                    $ligne["num_reglement"],
                                    ENT_QUOTES,
                                ) ?>"
                                style="width:20px;">
                            <?= htmlspecialchars($ligne["num_reglement"]) ?>
                        </td>
                        <?php if ($i === 0): ?>
                        <td rowspan="<?= $rowspan ?>"><?= htmlspecialchars(
    $numFacture,
) ?></td>
                        <?php endif; ?>
                        <td><?= htmlspecialchars(
                            $ligne["nom_personne_reglement"],
                        ) ?></td>
                        <td><?= htmlspecialchars(
                            $ligne["date_reglement"],
                        ) ?></td>
                        <td><?= htmlspecialchars(
                            $ligne["mode_paiement"],
                        ) ?></td>
                        <td><?= number_format(
                            $ligne["montant_reglement"],
                            0,
                            ",",
                            " ",
                        ) ?> Ar</td>
                        <?php if ($i === 0): ?>
                        <td rowspan="<?= $rowspan ?>"><?= number_format(
    $montantTotal,
    0,
    ",",
    " ",
) ?> Ar</td>
                        <td rowspan="<?= $rowspan ?>" <?= $reste > 0
    ? 'style="color:red;font-weight:bold;"'
    : 'style="color:green;"' ?>>
                            <?= number_format($reste, 0, ",", " ") ?> Ar
                        </td>
                        <?php endif; ?>
                        <td>
                            <button type="button"
                                style="background-color: rgb(193,215,251); border: 2px solid darkblue;"
                                onclick="openModal1(
                                    '<?= htmlspecialchars(
                                        $ligne["num_reglement"],
                                        ENT_QUOTES,
                                    ) ?>',
                                    '<?= htmlspecialchars(
                                        $ligne["mode_paiement"],
                                        ENT_QUOTES,
                                    ) ?>',
                                    '<?= htmlspecialchars(
                                        $ligne["date_reglement"],
                                        ENT_QUOTES,
                                    ) ?>',
                                    '<?= htmlspecialchars(
                                        $ligne["nom_personne_reglement"],
                                        ENT_QUOTES,
                                    ) ?>',
                                    '<?= htmlspecialchars(
                                        $numFacture,
                                        ENT_QUOTES,
                                    ) ?>',
                                    '<?= (int) $ligne["montant_reglement"] ?>'
                                )">Modifier</button>
                            <button type="button"
                                style="background-color: rgb(255,189,189); border: 2px solid rgb(158,3,3);"
                                class="btnSupprimer"
                                data-id="<?= htmlspecialchars(
                                    $ligne["num_reglement"],
                                    ENT_QUOTES,
                                ) ?>">Supprimer</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="btn3">Générer PDF sélectionnés</button>
    </form>
    <button onclick="openModal()" class="btn1">+ Ajouter</button>
</div>

<!-- Modal Ajout -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Ajouter un règlement</h2>
        <form id="reglement-form" method="POST">
            <label for="date">Date :</label>
            <input type="date" id="date" name="date" value="<?= date(
                "Y-m-d",
            ) ?>" required>
            <label for="nom">Nom du client :</label>
            <input type="text" id="nom" name="nom" required autocomplete="off">
            <label for="num_facture">Numéro de facture :</label>
            <select name="num_facture" id="num_facture" required>
                <option value="">-- Tapez le nom du client d'abord --</option>
            </select>
            <label for="mode_paye">Mode de paiement :</label>
            <select name="mode_paye" id="mode_paye">
                <option value="Espece">Espèces</option>
                <option value="Cheque">Chèque</option>
                <option value="Carte">Carte bancaire</option>
            </select>
            <label for="montant">Montant :</label>
            <input type="number" name="montant" id="montant" required>
            <button type="submit" class="btn">Enregistrer</button>
        </form>
    </div>
</div>

<!-- Modal Édition -->
<div id="modal1" class="modal1">
    <div class="modal-content1">
        <span class="close" onclick="closeModal1()">&times;</span>
        <h2>Modifier un règlement</h2>
        <form id="modif-form" action="index.php?entity=reglement&action=update" method="POST">
            <label for="date1">Date :</label>
            <input type="date" id="date1" name="date_reglement" required>
            <label for="nom1">Nom du client :</label>
            <input type="text" id="nom1" name="nom_client" required>
            <label for="num_facture1">N° Facture :</label>
            <input type="text" name="num_facture" id="num_facture1" required>
            <label for="mode_paye1">Mode de paiement :</label>
            <select name="mode_paiement" id="mode_paye1">
                <option value="Espece">Espèces</option>
                <option value="Cheque">Chèque</option>
                <option value="Carte">Carte bancaire</option>
            </select>
            <label for="montant1">Montant :</label>
            <input type="number" name="montant_reglement" id="montant1" required>
            <button type="submit" class="btn">Enregistrer</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById("modal").style.display = "flex";
    }
    function openModal1(num_reglement, mode, date, nom, num_facture, montant) {
        document.getElementById('date1').value = date;
        document.getElementById('mode_paye1').value = mode;
        document.getElementById('num_facture1').value = num_facture;
        document.getElementById('montant1').value = montant;
        document.getElementById('nom1').value = nom;
        const form = document.getElementById('modif-form');
        form.action = `index.php?entity=reglement&action=update&id=${num_reglement}`;
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

    // AJAX: charger les factures par nom client
    document.getElementById('nom').addEventListener('keyup', function () {
        const nomClient = this.value.trim();
        if (nomClient.length < 2) return;
        fetch(`index.php?entity=reglement&action=ajaxFactures&q=${encodeURIComponent(nomClient)}`)
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById('num_facture');
                select.innerHTML = '<option value="">-- Sélectionner une facture --</option>';
                if (data.length === 0) {
                    const opt = document.createElement('option');
                    opt.textContent = 'Aucune facture trouvée';
                    opt.disabled = true;
                    select.appendChild(opt);
                    return;
                }
                data.forEach(f => {
                    const option = document.createElement('option');
                    option.value = f.num_facture;
                    option.textContent = `${f.num_facture} | ${f.date_facture}`;
                    select.appendChild(option);
                });
            })
            .catch(err => console.error('Erreur AJAX:', err));
    });
</script>

<script src="/lib/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/Views/reglement/script.js"></script>
<script src="/Views/reglement/test1.js"></script>

<?php if (isset($_GET["success"]) && $_GET["success"] == 1): ?>
<script>Swal.fire({ icon:'success', title:'Succès', text:'Règlement modifié avec succès.', confirmButtonText:'OK' });</script>
<?php endif; ?>
<?php if (isset($_GET["error"]) && $_GET["error"] == 1): ?>
<script>Swal.fire({ icon:'error', title:'Erreur', text:'La modification a échoué.', confirmButtonText:'OK' });</script>
<?php endif; ?>

</body>
</html>
