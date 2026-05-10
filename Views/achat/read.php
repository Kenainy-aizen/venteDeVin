<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventes – Vente de Vin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/lib/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/Views/achat/read.css">
</head>
<body>

<nav class="navbarAll">
    <div>
        <a class="logo">🍷 VENTE</a>
        <div id="mynavbar">
            <?php require_once __DIR__ . "/../shared/navbar.php"; ?>
            <form class="d-flex" action="index.php?entity=achat&action=rechercher" method="POST">
                <input id="inputRecherche" name="inputRecherche" type="text" placeholder="Rechercher une facture…">
                <button class="btnRecherche" type="submit">Rechercher</button>
            </form>
        </div>
    </div>
</nav>

<div class="titre">
    <h1>Liste des ventes</h1>
</div>

<div style="margin-top: 55px;"><br><br><br>

    <div id="requete"><br>
        <h3 style="color: white;">Ventes non réglées entre deux dates</h3><br>
        <form action="index.php?entity=achat&action=entreDeuxDate" method="post">
            <input type="date" name="date1">
            <input type="date" name="date2"><br><br>
            <button type="submit" style="background-color: white; border: 2px solid rgb(113,187,206);">Afficher</button>
        </form>
    </div><br>

    <table class="tbl" id="AchatsVidy">
        <colgroup>
            <col style="width: 200px;">
            <col style="width: 200px;">
            <col style="width: 200px;">
            <col style="width: 200px;">
            <col style="width: 250px;">
        </colgroup>
        <thead style="position: fixed;">
            <tr class="trMedocTble">
                <th style="width: 200px;">N° Facture</th>
                <th style="width: 200px;">Client</th>
                <th style="width: 200px;">Date</th>
                <th style="width: 200px;">Montant</th>
                <th style="width: 250px; background-color:rgb(33,33,33); color:white;">Actions</th>
            </tr>
        </thead>
        <tr style="height: 40px;"></tr>
        <tbody>
            <?php foreach ($achat as $a): ?>
            <tr>
                <td><?= htmlspecialchars($a["num_facture"]) ?></td>
                <td><?= htmlspecialchars($a["nom_client"]) ?></td>
                <td><?= htmlspecialchars($a["date_facture"]) ?></td>
                <td><?= number_format(
                    $a["montant_total"],
                    0,
                    ",",
                    " ",
                ) ?> Ar</td>
                <td style="display:flex; justify-content:flex-start; align-items:center; gap:10px; margin-left:15px;">
                    <form method="post" action="index.php?entity=achat&action=CreatePdf&id=<?= htmlspecialchars(
                        $a["num_facture"],
                        ENT_QUOTES,
                    ) ?>">
                        <button type="submit" name="genererPdf" style="background-color: rgb(193,215,251); border: 2px solid darkblue;">PDF</button>
                    </form>
                    <button style="background-color: rgb(255,189,189); border: 2px solid rgb(158,3,3);"
                        class="btnSupprimer"
                        data-id="<?= htmlspecialchars(
                            $a["num_facture"],
                            ENT_QUOTES,
                        ) ?>">Supprimer</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div><a href="index.php?entity=achat&action=create"><button class="btn1">+ Nouvelle vente</button></a></div>
</div>

<script src="<?= BASE_URL ?>/lib/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= BASE_URL ?>/Views/achat/script.js"></script>

</body>
</html>
