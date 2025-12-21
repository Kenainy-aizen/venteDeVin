<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACHAT</title>
    <link rel="stylesheet" href="/lib/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/Views/achat/read.css">
    <nav class="navbarAll">
        <div>
          <a class="logo">VENTE</a>      
          <div class="" id="mynavbar">          
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
                   <a href="index.php?entity=client&action=read"><button class="nav-link">Clients</button></a>
                </li>
                 <li class="nav-item">
                   <a href="index.php?entity=reglement&action=read"><button class="nav-link">Reglements</button></a>
                </li>
                  <li class="nav-item">
                   <a href="index.php?entity=command&action=read"><button class="nav-link">Commandes</button></a>
                </li>
            <form class="d-flex" action="index.php?entity=achat&action=rechercher" method="POST" >
              <input id="inputRecherche" name="inputRecherche" type="text" placeholder="Taper ici pour rechercher">
              <button class="btnRecherche" type="submit" >Rechercher</button>
            </form>
          <a href=""><button class="notif">N</button></a>         
          </div>
        </div>
      </nav>
</head>
<body>
    
<div class="titre">
        <h1>Liste des achat</h1>
    </div>
    <div  style="margin-top: 55px;"><br>
        <div class="teste">
    
        </div>
        <br><br><br>   
        <div id="requete"><br>

        <h3 style = "color: white;">Rechercher de l'achat non regle</h3><br>
          <form action="index.php?entity=achat&action=entreDeuxDate" method="post" >
                <input type="date" name="date1" id="date1">
                <input type="date" name="date2" id="date1"><br><br>
                <button type="submit" style="background-color: rgb(255, 255, 255); border: 2px solid rgb(113, 187, 206);" id="Affiche">afficher</button>
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
            
            <thead  style="position: fixed;">
                <tr class="trMedocTble">
                    <th style="width: 200px;">Numero de facture</th>
                    <th style="width: 200px;">Nom de client</th>
                    <th style="width: 200px;">Date de facture</th>
                    <th style="width: 200px;">Montant</th>
                    <th style="width: 250px; background-color:rgb(33, 33, 33);color: white;">Action</th>
                </tr>
            </thead>
            <tr style="height: 40px;"></tr>

              <tbody>

              <?php foreach ($achat as $achat) : ?>
              <tr>
                  <td> <?= $achat['num_facture'] ?></td>
                  <td> <?= $achat['nom_client'] ?></td>
                  <td> <?= $achat['date_facture'] ?></td>
                  <td> <?= $achat['montant_total'] ?></td>
                  <td style="display: flex;justify-content: flex-start; align-items: center;  gap: 10px;  margin-left: 15px">

                      <form id="formAchat" method="post" action="index.php?entity=achat&action=CreatePdf&id=<?= $achat['num_facture'] ?>"> 
                        <button type="submit" name="genererPdf" style="background-color: rgb(193, 215, 251); border: 2px solid darkblue;" id="Edit"> Editer en pdf</button> 
                      </form>
                        <button style="background-color: rgb(255, 189, 189); border: 2px solid rgb(158, 3, 3);" class="btnSupprimer" data-id="<?= $achat['num_facture'] ?>">Supprimer</button>
                                         
                  </td>
              </tr>
              <?php endforeach; ?>

              </tbody>
          
        </table>
        <div><a href="index.php?entity=achat&action=create" ><button class="btn1">Ajouter</button></a></div>
        <!-- <div><button class="ExporPdf">Exporter en pdf</button></div> -->
    </div>

    <div class="">

    </div>

    <div id="modal1" class="modal1">
            <div class="modal-content1">
                <span class="close" onclick="closeModal1()">&times;</span>
                <h2>Modification de liste d'achat</h2>
                <form id="medicament-form" action="index.php?entity=achat&action=update" method="POST">
                    <label for="nom_produit">Numero medicament :</label>
                    <input type="text" name="numMedoc" id="numMedoc" value="" >

                    <label for="nomClient">Nom client :</label>
                    <input type="text" name="nomClient" id="nomClient" value="" >

                    <label for="nbr">Stock :</label>
                    <input type="number" name="nbr" id="nbr" value="" >

                    <label for="dateAchat">Date d'achat :</label>
                    <input type="date" name="dateAchat" id="dateAchat">

                    <button type="submit" class="btn2">Enregistrer</button>
                </form>
            </div>
    </div>
    <script>
        // Fonction pour ouvrir la boîte modal

        function openModal1(numAchat, numMedoc, nomClient, nbr, dateAchat) {
            document.getElementById('numMedoc').value = numMedoc;
            document.getElementById('nomClient').value = nomClient;
            document.getElementById('dateAchat').value = dateAchat;
            document.getElementById('nbr').value = nbr;

            const form = document.getElementById('medicament-form');
            form.action = `index.php?entity=achat&action=update&id=${numAchat}&param1=${numMedoc}&param2=${nbr}`;

            document.getElementById("modal1").style.display = "flex";
            console.log(numMedoc);
            console.log(nomClient);
            console.log(form.action);
        }


        // Fonction pour fermer la boîte modale

        function closeModal1() {
            document.getElementById("modal1").style.display = "none";
        }

        window.onclick = function(event) {
            const modal1 = document.getElementById('modal1');

            if(event.target === modal1) {
                modal1.style.display = "none";
            } 

        };
    </script>

    <script src="/lib/sweetalert2/sweetalert2.all.min.js" ></script>
    <script src="/Views/achat/script.js"></script>
    
    
</body>
</html>

 