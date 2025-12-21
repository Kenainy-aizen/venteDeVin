<?php

    $group = [];

    foreach($reglement as $rows){
        $group[$rows['num_facture']][]= $rows;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGLEMENT</title>
    <link rel="stylesheet" href="/lib/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/Views/reglement/read.css">
    <nav class="navbarAll">
        <div>
          <a class="logo">VENTE</a>
          
          <div class="" id="mynavbar">
            <ul>
              <li class="nav-item">
                <a href="index.php?entity=acceuil&action=read"><button class="nav-link">Dashbord</button></a>
              </li>
              <li class="nav-item">
                <a href="index.php?entity=produit&action=read"><button class="nav-link" >Produit</button></a>
              </li>
              <li class="nav-item">
                <a href="index.php?entity=achat&action=read"><button class="nav-link">Achats</button></a>
              </li>
              <li class="nav-item">
                <a href="index.php?entity=client&action=read"><button class="nav-link">Client</button></a>
              </li>
              <li class="nav-item">
                <a href="index.php?entity=client&action=read"><button class="nav-link">Reglement</button></a>
              </li> 
                <li class="nav-item">
                   <a href="index.php?entity=command&action=read"><button class="nav-link">Commande</button></a>
                </li>           
            </ul>
            <!-- <form class="d-flex" action="">
              <input id="inputRecherche" type="text" placeholder="Taper ici pour rechercher">
              <button class="btnRecherche">Rechercher</button>
            </form> -->
            <!-- <a href=""><button class="notif">N</button></a> -->
            
          </div>
        </div>
      </nav>
</head>
<body>
<div class="titre">
        <h1>Liste des reglement</h1>
    </div>
    <div  style="margin-top: 55px;"><br><br><br>
        <form action="index.php?entity=reglement&action=CreatePdf" method='post'>
        <table style="margin-left: 10px; margin-right: 0px;" class="tbl" id="enter">
            <colgroup>
                <col style="width: 170px;">
                <col style="width: 200px;">
                <col style="width: 200px;">
                <col style="width: 90px;">
                <col style="width: 200px;">
                <col style="width: 200px;">
                <col style="width: 150px;">
                <col style="width: 120px;">
                <col style="width: 250px;">
                
            </colgroup>

            <thead style="position: fixed;">
                <tr class="trMedocTble">
                    <th style="width: 170px;">Numero de reglement</th>
                    <th style="width: 200px;">Numero facture</th>
                    <th style="width: 200px;">Nom client</th>
                    <th style="width: 90px;">Date</th>
                    <th style="width: 200px;">Mode de paiement</th>
                    <th style="width: 200px;">Montant de reglement</th>
                    <th style="width: 150px;">Montant total</th>
                    <th style="width: 120px;">reste a payer</th>
                    <th style="width: 250px; background-color:rgb(33, 33, 33);color: white;">Action</th>
                </tr>
            </thead>
            <tr style="height: 40px;"></tr>
            <tbody>
                
              <?php foreach ($group as $num_facture => $lignes) : ?>
                <?php
                    $rowspan = count($lignes);
                    $numFacture = $lignes[0]['num_facture'];
                    // $date = $lignes[0]['date_reglement'];
                    $reste = $lignes[0]['reste_a_payer'];
                    $montant_total = $lignes[0]['montant_total'];
                  //  $nom = $lignes[0]['nom_personne_reglement'];
                ?>
                <?php foreach ($lignes as $i => $ligne) : ?>

                    <tr>

                        <td style="text-align"> <input type="checkbox" name="selected_reglements[]" value="<?= $ligne['num_reglement'] ?>" style="width: 30px"> <?= $ligne['num_reglement'] ?></td>

                        <?php if( $i === 0 ): ?>
                            <td rowspan ="<?= $rowspan ?>"> <?= $numFacture ?></td>
                        <?php endif; ?>

                        <td  style="text-align: left;" > <?= $ligne['nom_personne_reglement'] ?></td>
                    
                        <td> <?= $ligne['date_reglement'] ?></td>

                        <td> <?= $ligne['mode_paiement']?></td>

                        <td> <?= $ligne['montant_reglement'] ?> </td>

                        <?php if( $i === 0 ): ?>
                            <td rowspan ="<?= $rowspan ?>"> <?= $montant_total ?></td>
                        <?php endif; ?>
                            
                        <?php if( $i === 0 ): ?> 
                            <td rowspan="<?= $rowspan ?>"><?= $reste ?></td>                         
                        <?php endif; ?>
                    
                        <td>
                            <button type="button" style="background-color: rgb(193, 215, 251); border: 2px solid darkblue;" id="Edit"  onclick = "openModal1('<?= $ligne['num_reglement'] ?>','<?= $ligne['mode_paiement']?>','<?= $ligne['date_reglement']?>','<?= $ligne['nom_personne_reglement']?>','<?= $numFacture?>','<?= $ligne['montant_reglement']?>')">Modifier</button> 
                            <button type="button" style="background-color: rgb(255, 189, 189); border: 2px solid rgb(158, 3, 3);" class="btnSupprimer" data-id="<?= $ligne['num_reglement'] ?>">Supprimer</button>
                                
                        </td>
                    </tr>
                
                <?php endforeach; ?>
                
              <?php endforeach; ?>

            </tbody>
            
        </table>
        <button type="submit" class="btn3">PDF</button>
        </form>
        <button onclick = "openModal()" class="btn1">Ajouter</button>
    </div>

    <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Ajouter un reglement</h2>
                <form id="reglement-form" method="POST">
                    <label for="date">Date :</label>
                    <input type="date" id="date" name="date" value="<?= date('Y-m-d') ?>">
                    <label for="nom">Nom client :</label>
                    <input type="text" id="nom" name="nom">
                    <label for="num_facture">Numero facture :</label>
                    <input type="text" name="num_facture" id="num_facture" required>
                    <label for="mode_paye">Type de paiement :</label>
                    <select name="mode_paye" id="mode_paye">
                        <option value="Espece">Espece</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Carte">Carte</option>
                    </select>
                    <label for="montant">Montant :</label> 
                    <input type="number" name="montant" id="montant">               
                    <button type="submit" class="btn">Enregistrer</button>
                </form>
            </div>
    </div>

    <div id="modal1" class="modal1">
            <div class="modal-content1">
                <span class="close" onclick="closeModal1()">&times;</span>
                <h2>Modification de reglement</h2>
                <form id="modif-form" action="index.php?entity=reglement&action=update" method="POST">
                    <label for="date1">Date :</label>
                    <input type="date" id="date1" name="date_reglement" >
                    <label for="nom1">Nom client :</label>
                    <input type="text" id="nom1" name="nom_client">
                    <label for="num_facture1">Numero facture :</label>
                    <input type="text" name="num_facture" id="num_facture1">
                    <label for="mode_paye1">Type de paiement :</label>
                    <select name="mode_paiement" id="mode_paye1">
                        <option value="Espece">Espece</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Carte">Carte</option>
                    </select>
                    <label for="montant1">Montant :</label> 
                    <input type="number" name="montant_reglement" id="montant1">               
                    <button type="submit" class="btn">Enregistrer</button>
                </form>
            </div>
    </div> 

    <script>
        // Fonction pour ouvrir la boîte modale
        function openModal() {
            document.getElementById("modal").style.display = "flex";
        }

        function openModal1(num_reglement, mode, date, nom, num_facture, montant ) {

            document.getElementById('date1').value = date;
            document.getElementById('mode_paye1').value = mode_paye;
            document.getElementById('num_facture1').value = num_facture;
            document.getElementById('montant1').value = montant;
            document.getElementById('nom1').value = nom;
            document.getElementById('mode_paye1').value = mode;
           
            const form = document.getElementById('modif-form');
            form.action = `index.php?entity=reglement&action=update&id=${num_reglement}`;

            document.getElementById("modal1").style.display = "flex";
          
        }


        // Fonction pour fermer la boîte modale
        function closeModal() {
            document.getElementById("modal").style.display = "none";
        }

        function closeModal1() {
            document.getElementById("modal1").style.display = "none";
        }

        window.onclick = function(event) {
            const modal1 = document.getElementById('modal1');
            const modal = document.getElementById('modal');
            if(event.target === modal1) {
                modal1.style.display = "none";
            } else if(event.target == modal) {
                modal.style.display = "none";
            }
        };
        
    </script>

    <script src="/lib/sweetalert2/sweetalert2.all.min.js" ></script>
    <script src="/Views/reglement/script.js"></script>
    <script src="/Views/reglement/test1.js"></script>

</body>
</html>